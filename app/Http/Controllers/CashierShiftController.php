<?php

namespace App\Http\Controllers;

use App\Http\Resources\CashierShiftResource;
use App\Models\Admin;
use App\Models\CashierShift;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CashierShiftController extends Controller
{
      public function openShift(Request $request)
    {
        $request->validate([
            'opening_balance' => 'required|numeric|min:0',
            'notes'           => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            $shiftData = [
                'opening_balance' => $request->opening_balance,
                'notes'           => $request->notes,
                'opened_at'       => now(),
                'status'          => 'open',
            ];

        $user = $request->user();

        if ($user instanceof Admin) {
            $shiftData['admin_id'] = $user->id;
        } elseif ($user instanceof Employee) {
            $shiftData['employee_id'] = $user->id;
        } else {
            throw new \Exception('نوع المستخدم غير معروف');
        }


            $shift = CashierShift::create($shiftData);

            DB::commit();

            return response()->json([
                'status'  => true,
                'message' => 'تم فتح الورديه بنجاح',
                'data'    => new CashierShiftResource($shift)
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status'  => false,
                'message' => 'حدث خطأ أثناء فتح الورديه',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    // اغلاق وردية
  public function closeShift(Request $request)
    {
        $request->validate([
            'actual_amount' => 'required|numeric|min:0',
            'notes'         => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            $user = auth()->user();

            // جلب آخر وردية مفتوحة للشخص الحالي
            $shift = CashierShift::where('status', 'open')
                ->where(function ($q) use ($user) {
                    if ($user instanceof Admin) {
                        $q->where('admin_id', $user->id);
                    } elseif ($user instanceof Employee) {
                        $q->where('employee_id', $user->id);
                    }
                })
                ->latest('opened_at')
                ->first();

            if (!$shift) {
                return response()->json([
                    'status' => false,
                    'message' => 'لا توجد وردية مفتوحة حالياً'
                ], 404);
            }

            $expected = ($shift->cash_sales + $shift->card_sales - $shift->returns_amount);

            $shift->update([
                'closing_balance' => $request->actual_amount,
                'actual_amount'   => $request->actual_amount,
                'expected_amount' => $expected,
                'difference'      => $request->actual_amount - $expected,
                'status'          => 'closed',
                'closed_at'       => now(),
                'notes'           => $request->notes,
            ]);

            DB::commit();

            return response()->json([
                'status'  => true,
                'message' => 'تم إغلاق الورديه بنجاح',
                'data'    => new CashierShiftResource($shift->fresh())
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status'  => false,
                'message' => 'حدث خطأ أثناء إغلاق الورديه',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    // عرض كل الورديات
    public function index()
    {
        $shifts = cashierShift::with(['employee','admin'])->latest()->get();

        return response()->json([
            'status' => true,
            'data'   => CashierShiftResource::collection($shifts)
        ]);
    }

    // عرض وردية واحدة
    public function show(cashierShift $shift)
    {
        $shift->load(['employee','admin']);
        return response()->json([
            'status' => true,
            'data'   => new CashierShiftResource($shift)
        ]);
    }


   public function getCurrentShift()
    {
        $user = auth()->user();

        $query = CashierShift::query()->where('status', 'open')
            ->where(function ($q) use ($user) {
                if ($user instanceof Admin) {
                    $q->where('admin_id', $user->id);
                } elseif ($user instanceof Employee) {
                    $q->where('employee_id', $user->id);
                }
            });

        $shift = $query->latest('opened_at')->first();

        if (!$shift) {
            return response()->json([
                'status' => false,
                'message' => 'لا توجد وردية مفتوحة حالياً'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'آخر وردية مفتوحة',
            'data' => $shift
        ]);
    }

}
