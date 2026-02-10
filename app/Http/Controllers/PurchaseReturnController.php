<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReturnRequest;
use App\Http\Resources\PurchaseReturnResource;
use App\Models\PurchaseReturn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseReturnController extends Controller
{
    public function index(Request $request)
    {
        try {
            $filters = $request->input('filters', []);
            $orderBy = $request->input('orderBy', 'id');
            $orderByDirection = $request->input('orderByDirection', 'desc');
            $perPage = $request->input('perPage', 10);
            $paginate = $request->boolean('paginate', true);

            $query = PurchaseReturn::with([
                'purchaseInvoice',
                'items.product',
            ]);

            // =========================
            // FILTERS
            // =========================

            if (!empty($filters['return_number'])) {
                $query->where('return_number', 'like', '%' . $filters['return_number'] . '%');
            }

            if (!empty($filters['invoice_number'])) {
                $query->whereHas('purchaseInvoice', function ($q) use ($filters) {
                    $q->where('invoice_number', 'like', '%' . $filters['invoice_number'] . '%');
                });
            }

            if (!empty($filters['purchase_invoices_id'])) {
                $query->where('purchase_invoices_id', $filters['purchase_invoices_id']);
            }

            if (!empty($filters['min_total'])) {
                $query->where('total_amount', '>=', $filters['min_total']);
            }

            if (!empty($filters['max_total'])) {
                $query->where('total_amount', '<=', $filters['max_total']);
            }

            if (!empty($filters['date_from'])) {
                $query->whereDate('created_at', '>=', $filters['date_from']);
            }

            if (!empty($filters['date_to'])) {
                $query->whereDate('created_at', '<=', $filters['date_to']);
            }

            if (!empty($filters['reason'])) {
                $query->where('reason', 'like', '%' . $filters['reason'] . '%');
            }

            // =========================
            // SORT
            // =========================
            $query->orderBy($orderBy, $orderByDirection);

            // =========================
            // PAGINATION MODE
            // =========================
            if ($paginate) {
                $returns = $query->paginate($perPage);

                return response()->json([
                    'data' => PurchaseReturnResource::collection($returns->items()),

                    'links' => [
                        'first' => $returns->url(1),
                        'last' => $returns->url($returns->lastPage()),
                        'prev' => $returns->previousPageUrl(),
                        'next' => $returns->nextPageUrl(),
                    ],

                    'meta' => [
                        'current_page' => $returns->currentPage(),
                        'from' => $returns->firstItem(),
                        'last_page' => $returns->lastPage(),
                        'path' => $returns->path(),
                        'per_page' => $returns->perPage(),
                        'to' => $returns->lastItem(),
                        'total' => $returns->total(),
                    ],

                    'result' => 'Success',
                    'message' => 'Purchase returns fetched successfully',
                    'status' => 200,
                ]);
            }

            // =========================
            // NON PAGINATED MODE
            // =========================
            $returns = $query->get();

            return response()->json([
                'data' => PurchaseReturnResource::collection($returns),
                'links' => null,
                'meta' => null,
                'result' => 'Success',
                'message' => 'Purchase returns fetched successfully',
                'status' => 200,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'result' => 'Error',
                'message' => $e->getMessage(),
                'status' => 500,
            ], 500);
        }
    }

    public function store(StoreReturnRequest $request)
    {
        DB::beginTransaction();

        try {
            $total = collect($request->items)
                ->sum(fn($i) => $i['quantity'] * $i['unit_price']);

            $return = PurchaseReturn::create([
                'purchase_invoices_id' => $request->purchase_invoices_id,
                'return_number' => 'PR-' . now()->format('Ymd') . '-' . rand(1000,9999),
                'total_amount' => $total,
                'reason' => $request->reason
            ]);

            foreach ($request->items as $item) {
                $return->items()->create([
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'total_price' => $item['quantity'] * $item['unit_price']
                ]);
            }

            DB::commit();

            return new PurchaseReturnResource($return);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        $return = PurchaseReturn::with('items.product', 'purchaseInvoice')->findOrFail($id);
        return new PurchaseReturnResource($return);
    }
}
