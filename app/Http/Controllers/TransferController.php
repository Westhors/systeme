<?php

namespace App\Http\Controllers;

use App\Helpers\JsonResponse;
use App\Http\Requests\TransferRequest;
use App\Http\Resources\TransferResource;
use App\Models\Bank;
use App\Models\Transfer;
use App\Models\Treasury;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransferController extends Controller
{
    public function transfer(TransferRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $amount = $request->amount;
                $type   = $request->type;

                // ================= خصم أو إضافة =================
                if (in_array($type, ['treasury_to_treasury','treasury_to_bank','treasury_withdraw'])) {
                    $source = Treasury::lockForUpdate()->findOrFail($request->from_treasury_id);
                    if ($source->balance < $amount) throw new \Exception('الرصيد غير كافي في الخزنة المصدر');
                    $source->decrement('balance', $amount);
                }

                if (in_array($type, ['bank_to_treasury','bank_to_bank','bank_withdraw'])) {
                    $source = Bank::lockForUpdate()->findOrFail($request->from_bank_id);
                    if ($source->balance < $amount) throw new \Exception('الرصيد غير كافي في البنك المصدر');
                    $source->decrement('balance', $amount);
                }

                if ($type === 'bank_to_bank') {
                    $destination = Bank::lockForUpdate()->findOrFail($request->to_bank_id);
                    $destination->increment('balance', $amount);
                }

                if (in_array($type, ['treasury_to_treasury','bank_to_treasury','treasury_deposit'])) {
                    $destination = Treasury::lockForUpdate()->findOrFail($request->to_treasury_id);
                    $destination->increment('balance', $amount);
                }

                if (in_array($type, ['treasury_to_bank','bank_deposit'])) {
                    $destination = Bank::lockForUpdate()->findOrFail($request->to_bank_id);
                    $destination->increment('balance', $amount);
                }

                // ================= تسجيل الحركة =================
                Transfer::create([
                    'type'             => $type,
                    'from_treasury_id' => $request->from_treasury_id,
                    'to_treasury_id'   => $request->to_treasury_id,
                    'from_bank_id'     => $request->from_bank_id,
                    'to_bank_id'       => $request->to_bank_id,
                    'amount'           => $amount,
                    'currency'         => $request->currency,
                    'notes'            => $request->notes,
                    'created_by'       => auth()->id() ?? null,
                ]);
            });

            return JsonResponse::respondSuccess('تم تسجيل الحركة بنجاح');

        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function treasuryMovements(Request $request)
    {
        try {
            $filters   = $request->input('filters', []);
            $orderBy   = $request->input('orderBy', 'id');
            $orderDir  = $request->input('orderByDirection', 'desc');
            $perPage   = $request->input('perPage', 10);
            $paginate  = $request->boolean('paginate', true);

            // الحركات الخاصة بالخزنة
            $treasuryTypes = [
                'treasury_to_treasury',
                'treasury_to_bank',
                'bank_to_treasury',
                'treasury_deposit',
                'treasury_withdraw',
            ];

            $query = Transfer::with([
                'fromTreasury',
                'toTreasury',
                'fromBank',
                'toBank'
            ])
            ->whereIn('type', $treasuryTypes);

            // ================= FILTERS =================
            if (!empty($filters['treasury_id'])) {
                $query->where(function ($q) use ($filters) {
                    $q->where('from_treasury_id', $filters['treasury_id'])
                    ->orWhere('to_treasury_id', $filters['treasury_id']);
                });
            }

            if (!empty($filters['type'])) {
                $query->where('type', $filters['type']);
            }

            if (!empty($filters['date_from'])) {
                $query->whereDate('created_at', '>=', $filters['date_from']);
            }

            if (!empty($filters['date_to'])) {
                $query->whereDate('created_at', '<=', $filters['date_to']);
            }

            // ================= SORT =================
            $query->orderBy($orderBy, $orderDir);

            // ================= PAGINATION =================
            if ($paginate) {
                $rows = $query->paginate($perPage);

                return response()->json([
                    'data' => TransferResource::collection($rows->items()),
                    'links' => [
                        'first' => $rows->url(1),
                        'last'  => $rows->url($rows->lastPage()),
                        'prev'  => $rows->previousPageUrl(),
                        'next'  => $rows->nextPageUrl(),
                    ],
                    'meta' => [
                        'current_page' => $rows->currentPage(),
                        'from'         => $rows->firstItem(),
                        'last_page'    => $rows->lastPage(),
                        'per_page'     => $rows->perPage(),
                        'total'        => $rows->total(),
                    ],
                    'result'  => 'Success',
                    'message' => 'Treasury movements fetched successfully',
                    'status'  => 200,
                ]);
            }

            $rows = $query->get();

            return response()->json([
                'data' => TransferResource::collection($rows),
                'result'  => 'Success',
                'message' => 'Treasury movements fetched successfully',
                'status'  => 200,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'result' => 'Error',
                'message' => $e->getMessage(),
                'status' => 500,
            ]);
        }
    }

    public function bankMovements(Request $request)
    {
        try {
            $filters   = $request->input('filters', []);
            $orderBy   = $request->input('orderBy', 'id');
            $orderDir  = $request->input('orderByDirection', 'desc');
            $perPage   = $request->input('perPage', 10);
            $paginate  = $request->boolean('paginate', true);

            // الحركات الخاصة بالبنك
            $bankTypes = [
                'treasury_to_bank',
                'bank_to_treasury',
                'bank_to_bank',
                'bank_deposit',
                'bank_withdraw',
            ];

            $query = Transfer::with([
                'fromTreasury',
                'toTreasury',
                'fromBank',
                'toBank'
            ])
            ->whereIn('type', $bankTypes);

            // ================= FILTERS =================
            if (!empty($filters['bank_id'])) {
                $query->where(function ($q) use ($filters) {
                    $q->where('from_bank_id', $filters['bank_id'])
                    ->orWhere('to_bank_id', $filters['bank_id']);
                });
            }

            if (!empty($filters['type'])) {
                $query->where('type', $filters['type']);
            }

            if (!empty($filters['date_from'])) {
                $query->whereDate('created_at', '>=', $filters['date_from']);
            }

            if (!empty($filters['date_to'])) {
                $query->whereDate('created_at', '<=', $filters['date_to']);
            }

            // ================= SORT =================
            $query->orderBy($orderBy, $orderDir);

            // ================= PAGINATION =================
            if ($paginate) {
                $rows = $query->paginate($perPage);

                return response()->json([
                    'data' => TransferResource::collection($rows->items()),
                    'links' => [
                        'first' => $rows->url(1),
                        'last'  => $rows->url($rows->lastPage()),
                        'prev'  => $rows->previousPageUrl(),
                        'next'  => $rows->nextPageUrl(),
                    ],
                    'meta' => [
                        'current_page' => $rows->currentPage(),
                        'from'         => $rows->firstItem(),
                        'last_page'    => $rows->lastPage(),
                        'per_page'     => $rows->perPage(),
                        'total'        => $rows->total(),
                    ],
                    'result'  => 'Success',
                    'message' => 'Bank movements fetched successfully',
                    'status'  => 200,
                ]);
            }

            $rows = $query->get();

            return response()->json([
                'data' => TransferResource::collection($rows),
                'result'  => 'Success',
                'message' => 'Bank movements fetched successfully',
                'status'  => 200,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'result' => 'Error',
                'message' => $e->getMessage(),
                'status' => 500,
            ]);
        }
    }
}
