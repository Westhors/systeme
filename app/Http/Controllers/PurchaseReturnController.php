<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReturnRequest;
use App\Http\Resources\PurchaseReturnResource;
use App\Models\Product;
use App\Models\PurchaseInvoice;
use App\Models\PurchaseReturn;
use App\Models\Treasury;
use App\Models\TreasuryTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
                'treasury', // ✅ إضافة علاقة الخزينة
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

            if (!empty($filters['treasury_id'])) { // ✅ فلتر الخزينة
                $query->where('treasury_id', $filters['treasury_id']);
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
            // جلب الفاتورة الأصلية
            $invoice = PurchaseInvoice::find($request->purchase_invoices_id);
            
            if (!$invoice) {
                throw new \Exception('Invoice not found');
            }

            // حساب إجمالي المرتجع
            $total = collect($request->items)
                ->sum(fn($i) => $i['quantity'] * $i['unit_price']);

            // إنشاء المرتجع مع الخزينة (نفس خزينة الفاتورة)
            $return = PurchaseReturn::create([
                'purchase_invoices_id' => $request->purchase_invoices_id,
                'return_number' => 'PR-' . now()->format('Ymd') . '-' . rand(1000,9999),
                'total_amount' => $total,
                'reason' => $request->reason,
                'treasury_id' => $invoice->treasury_id, // ✅ نفس خزينة الفاتورة
                'payment_method' => $invoice->payment_method, // ✅ نفس طريقة الدفع
            ]);

            // إضافة الأصناف المرتجعة
            foreach ($request->items as $item) {
                $return->items()->create([
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'total_price' => $item['quantity'] * $item['unit_price']
                ]);

                // 🔹 تحديث المخزون العام (نقص)
                $product = Product::find($item['product_id']);
                if ($product) {
                    $product->decrement('stock', $item['quantity']);
                }

                // 🔹 تحديث المخزون في pivot table
                $pivot = \DB::table('product_warehouse')
                    ->where('product_id', $item['product_id'])
                    ->where('warehouse_id', $invoice->warehouse_id)
                    ->first();

                if ($pivot) {
                    \DB::table('product_warehouse')
                        ->where('product_id', $item['product_id'])
                        ->where('warehouse_id', $invoice->warehouse_id)
                        ->decrement('stock', $item['quantity']);
                } else {
                    // لو مش موجود (مفروض يكون موجود)
                    \DB::table('product_warehouse')->insert([
                        'product_id' => $item['product_id'],
                        'warehouse_id' => $invoice->warehouse_id,
                        'stock' => 0 - $item['quantity'], // سالب!
                    ]);
                }
            }

            // ✅ ✅ ✅ إعادة المبلغ للخزينة وتسجيل حركة (في حالة الدفع النقدي)
            if ($invoice->payment_method === 'cash' && $invoice->treasury_id && $total > 0) {
                
                // 1. تحديث رصيد الخزينة (زيادة)
                $treasury = Treasury::find($invoice->treasury_id);
                if ($treasury) {
                    $oldBalance = $treasury->balance;
                    $treasury->increment('balance', $total);
                    
                    Log::info("Treasury balance increased from return", [
                        'treasury_id' => $treasury->id,
                        'old_balance' => $oldBalance,
                        'new_balance' => $treasury->balance,
                        'amount' => $total,
                        'return_id' => $return->id,
                        'invoice_id' => $invoice->id
                    ]);
                }

                // 2. إنشاء حركة خزنية (داخل)
                TreasuryTransaction::create([
                    'treasury_id' => $invoice->treasury_id,
                    'reference_type' => PurchaseReturn::class,
                    'reference_id' => $return->id,
                    'type' => 'in', // داخل للخزينة (مرتجع)
                    'amount' => $total,
                    'description' => "مرتجع مشتريات - فاتورة رقم {$invoice->invoice_number} - مرتجع رقم {$return->return_number}",
                    'created_at' => now(),
                ]);

                // 3. تحديث المبلغ المدفوع في الفاتورة (لو حابب)
                // $invoice->decrement('paid_amount', $total);
                // $invoice->increment('remaining_amount', $total);
            }

            DB::commit();

            // تحميل العلاقات للـ resource
            $return->load(['items.product', 'purchaseInvoice', 'treasury']);

            return new PurchaseReturnResource($return);

        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Purchase return creation failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request' => $request->all()
            ]);
            
            return response()->json([
                'result' => 'Error',
                'message' => 'Failed to create purchase return',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    public function show($id)
    {
        $return = PurchaseReturn::with([
            'items.product', 
            'purchaseInvoice',
            'treasury', // ✅ إضافة الخزينة
            'treasuryTransactions' // ✅ إضافة حركات الخزينة
        ])->findOrFail($id);
        
        return new PurchaseReturnResource($return);
    }
}