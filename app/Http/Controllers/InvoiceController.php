<?php

namespace App\Http\Controllers;

use App\Http\Resources\InvoiceResource;
use App\Models\Admin;
use App\Models\CashierShift;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\InvoicePayment;
use App\Models\LoyaltySetting;
use App\Models\Product;
use App\Models\Treasury;
use App\Models\TreasuryTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class InvoiceController extends Controller
{
    public function invoiceIndex(Request $request)
    {
        try {
            $filters = $request->input('filters', []);
            $orderBy = $request->input('orderBy', 'id');
            $orderByDirection = $request->input('orderByDirection', 'desc');
            $perPage = $request->input('perPage', 10);
            $paginate = $request->boolean('paginate', true);

            $query = Invoice::with([
                'customer',
                'cashier',
                'treasury',
                'salesRepresentative',
                'shift'
            ]);

            // =========================
            // FILTERS
            // =========================

            if (!empty($filters['invoice_number'])) {
                $query->where('invoice_number', 'like', '%' . $filters['invoice_number'] . '%');
            }

            if (!empty($filters['customer_id'])) {
                $query->where('customer_id', $filters['customer_id']);
            }

            if (!empty($filters['status'])) {
                $query->where('status', $filters['status']);
            }

            if (!empty($filters['cashier_id'])) {
                $query->where('cashier_id', $filters['cashier_id']);
            }

            if (!empty($filters['treasury_id'])) {
                $query->where('treasury_id', $filters['treasury_id']);
            }

            if (!empty($filters['date_from'])) {
                $query->whereDate('created_at', '>=', $filters['date_from']);
            }

            if (!empty($filters['date_to'])) {
                $query->whereDate('created_at', '<=', $filters['date_to']);
            }

            // =========================
            // SORT
            // =========================
            $query->orderBy($orderBy, $orderByDirection);

            // =========================
            // PAGINATION MODE
            // =========================
            if ($paginate) {
                $invoices = $query->paginate($perPage);

                return response()->json([
                    'data' => InvoiceResource::collection($invoices->items()),
                    'links' => [
                        'first' => $invoices->url(1),
                        'last' => $invoices->url($invoices->lastPage()),
                        'prev' => $invoices->previousPageUrl(),
                        'next' => $invoices->nextPageUrl(),
                    ],
                    'meta' => [
                        'current_page' => $invoices->currentPage(),
                        'from' => $invoices->firstItem(),
                        'last_page' => $invoices->lastPage(),
                        'path' => $invoices->path(),
                        'per_page' => $invoices->perPage(),
                        'to' => $invoices->lastItem(),
                        'total' => $invoices->total(),
                    ],
                    'result' => 'Success',
                    'message' => 'Invoices fetched successfully',
                    'status' => 200,
                ]);
            }

            // =========================
            // NON PAGINATED MODE
            // =========================
            $invoices = $query->get();

            return response()->json([
                'data' => InvoiceResource::collection($invoices),
                'links' => null,
                'meta' => null,
                'result' => 'Success',
                'message' => 'Invoices fetched successfully',
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

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            // ✅ جلب المستخدم الحالي
            $user = auth()->user();

            // ✅ تحديد cashier_id (الموظف) و treasury_id (الخزينة بتاعته)
            $cashierId = null;
            $treasuryId = null;

            if ($user instanceof Employee) {
                $cashierId = $user->id;
                $treasuryId = $user->treasury_id; // الخزينة بتاعة الموظف من جدول employees

                // التحقق من وجود خزينة للموظف
                if (!$treasuryId) {
                    DB::rollBack();
                    return response()->json([
                        'status' => false,
                        'message' => 'الموظف ليس لديه خزينة مخصصة. يرجى تحديث بيانات الموظف'
                    ], 400);
                }
            } elseif ($user instanceof Admin) {
                // لو admin، نستخدم أول خزينة رئيسية
                $cashierId = null;
                $mainTreasury = Treasury::where('is_main', true)->first();
                $treasuryId = $mainTreasury?->id;

                if (!$treasuryId) {
                    DB::rollBack();
                    return response()->json([
                        'status' => false,
                        'message' => 'لا توجد خزينة رئيسية. يرجى إنشاء خزينة أولاً'
                    ], 400);
                }
            }

            // حساب المجاميع
            $total = collect($request->items)
                ->sum(fn ($item) => $item['price'] * $item['quantity']);

            $paid = collect($request->payments)->sum('amount');
            $cashPaid = collect($request->payments)->where('method', 'cash')->sum('amount');
            $cardPaid = collect($request->payments)->where('method', 'card')->sum('amount');
            $walletPaid = collect($request->payments)
                ->where('method', 'wallet')
                ->sum('amount');

            $invoiceNumber = 'INV-' . now()->format('Ymd') . '-' . rand(1000, 9999);

            $discountPercentage = $request->discount_percentage ?? 0;

            $discountAmount = ($total * $discountPercentage) / 100;

            $netTotal = $total - $discountAmount;
            // ✅ إنشاء الفاتورة مع cashier_id و treasury_id
            $invoice = Invoice::create([
                'invoice_number'   => $invoiceNumber,
                'customer_id'      => $request->customer_id,
                'sales_representative_id' => $request->sales_representative_id,
                'cashier_id'       => $cashierId,
                'treasury_id'      => $treasuryId,

                'total_amount'     => $netTotal,
                'discount_percentage' => $discountPercentage,
                'discount_amount'  => $discountAmount,

                'paid_amount'      => $paid,
                'remaining_amount' => $netTotal - $paid,
                'status'           => $paid >= $netTotal ? 'paid' : 'partial',
            ]);

            /*
            |--------------------------------------------------------------------------
            | إضافة العناصر
            |--------------------------------------------------------------------------
            */
            foreach ($request->items as $item) {
                $product = Product::find($item['product_id']);

                if (!$product) {
                    DB::rollBack();
                    return response()->json([
                        'status' => false,
                        'message' => "المنتج ID {$item['product_id']} غير موجود"
                    ], 400);
                }

                if ($product->stock < $item['quantity']) {
                    DB::rollBack();
                    return response()->json([
                        'status' => false,
                        'message' => "الكمية المتوفرة في المخزون للمنتج '{$product->name}' أقل من المطلوبة"
                    ], 400);
                }

                $invoice->items()->create([
                    'product_id'   => $item['product_id'],
                    'product_name' => $item['product_name'] ?? $product->name,
                    'color'        => $item['color'] ?? null,
                    'size'         => $item['size'] ?? null,
                    'quantity'     => $item['quantity'],
                    'price'        => $item['price'],
                    'total'        => $item['price'] * $item['quantity'],
                ]);

                $product->decrement('stock', $item['quantity']);
            }

            /*
            |--------------------------------------------------------------------------
            | إضافة المدفوعات
            |--------------------------------------------------------------------------
            */
            foreach ($request->payments as $payment) {
                $invoice->payments()->create([
                    'method' => $payment['method'],
                    'amount' => $payment['amount'],
                ]);
            }

            /*
            |--------------------------------------------------------------------------
            | ✅ ✅ ✅ الفلوس تروح للخزينة بتاعة الموظف (للمدفوعات النقدية فقط)
            |--------------------------------------------------------------------------
            */
            if ($cashPaid > 0 && $treasuryId) {
                // 1. زيادة رصيد الخزينة
                $treasury = Treasury::find($treasuryId);
                if ($treasury) {
                    $oldBalance = $treasury->balance;
                    $treasury->increment('balance', $cashPaid);

                    Log::info("💰 Treasury balance increased from invoice", [
                        'treasury_id' => $treasury->id,
                        'treasury_name' => $treasury->name,
                        'cashier_id' => $cashierId,
                        'cashier_name' => $user?->name,
                        'old_balance' => $oldBalance,
                        'new_balance' => $treasury->balance,
                        'amount' => $cashPaid,
                        'invoice_id' => $invoice->id,
                        'invoice_number' => $invoice->invoice_number
                    ]);
                }

                // 2. إنشاء حركة خزنية (داخل)
                TreasuryTransaction::create([
                    'treasury_id' => $treasuryId,
                    'reference_type' => Invoice::class,
                    'reference_id' => $invoice->id,
                    'type' => 'in', // داخل للخزينة (إيراد)
                    'amount' => $cashPaid,
                    'description' => "فاتورة مبيعات رقم {$invoice->invoice_number} - كاشير: " . ($user?->name ?? 'مدير'),
                    'created_by' => $user?->id,
                    'created_at' => now(),
                ]);
            }

            /*
            |--------------------------------------------------------------------------
            | تحديث نقاط الولاء
            |--------------------------------------------------------------------------
            */
            $loyaltySetting = LoyaltySetting::first();

            if ($loyaltySetting && $loyaltySetting->point_value > 0) {
                $customer = Customer::find($request->customer_id);
                if ($customer) {
                    $earnedPoints = floor($paid / $loyaltySetting->point_value);
                    $customer->point = ($customer->point ?? 0) + $earnedPoints;
                    $customer->last_paid_amount = $paid;
                    $customer->save();
                }
            }

            /*
            |--------------------------------------------------------------------------
            | ربط الفاتورة بالوردية المفتوحة + تحديث مبيعاتها
            |--------------------------------------------------------------------------
            */
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

            if ($shift) {
                $invoice->update(['cashier_shift_id' => $shift->id]);

                $shift->increment('cash_sales', $cashPaid);
                $shift->increment('card_sales', $cardPaid);
                $shift->increment('wallet_sales', $walletPaid);
            }

            DB::commit();

            return response()->json([
                'status'  => true,
                'message' => 'Invoice created successfully',
                'data'    => new InvoiceResource(
                    $invoice->load([
                        'items',
                        'payments',
                        'customer',
                        'shift',
                        'salesRepresentative',
                        'cashier',
                        'treasury'
                    ])
                )
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status'  => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function searchByInvoiceNumber(Request $request)
    {
        $request->validate([
            'invoice_number' => 'required|string'
        ]);

        try {
            $invoice = Invoice::with([
                'items.product',
                'customer',
                'cashier',
                'treasury',
                'salesRepresentative'
            ])
                ->where('invoice_number', $request->query('invoice_number'))
                ->first();

            if (!$invoice) {
                return response()->json([
                    'status'  => false,
                    'message' => "لا توجد فاتورة برقم {$request->query('invoice_number')}"
                ], 404);
            }

            return response()->json([
                'status'  => true,
                'message' => 'تم العثور على الفاتورة',
                'data'    => new InvoiceResource($invoice)
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'حدث خطأ أثناء البحث',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $invoice = Invoice::with([
                'items',
                'payments',
                'customer',
                'shift',
                'salesRepresentative',
                'cashier',
                'treasury'
            ])->findOrFail($id);

            return response()->json([
                'status' => true,
                'data' => new InvoiceResource($invoice)
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
