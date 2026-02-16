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
use App\Models\ReturnInvoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

            $query = Invoice::with(['customer']);

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

            $total = collect($request->items)
                ->sum(fn ($item) => $item['price'] * $item['quantity']);

            $paid = collect($request->payments)->sum('amount');

            $invoiceNumber = 'INV-' . now()->format('Ymd') . '-' . rand(1000, 9999);

            $invoice = Invoice::create([
                'invoice_number'   => $invoiceNumber,
                'customer_id'      => $request->customer_id,
                'total_amount'     => $total,
                'paid_amount'      => $paid,
                'remaining_amount' => $total - $paid,
                'status'           => $paid >= $total ? 'paid' : 'partial',
            ]);

            /*
            |--------------------------------------------------------------------------
            | إضافة العناصر
            |--------------------------------------------------------------------------
            */
            foreach ($request->items as $item) {
                $invoice->items()->create([
                    'product_id'   => $item['product_id'],
                    'product_name' => $item['product_name'] ?? 'Product',
                    'color'        => $item['color'] ?? null,
                    'size'         => $item['size'] ?? null,
                    'quantity'     => $item['quantity'],
                    'price'        => $item['price'],
                    'total'        => $item['price'] * $item['quantity'],
                ]);
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
            $user = auth()->user();

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

                // ربط الفاتورة بالوردية
                $invoice->update([
                    'cashier_shift_id' => $shift->id
                ]);

                // حساب المدفوعات حسب الطريقة
                $cash = collect($request->payments)
                    ->where('method', 'cash')
                    ->sum('amount');

                $card = collect($request->payments)
                    ->where('method', 'card')
                    ->sum('amount');

                // تحديث مبيعات الوردية
                $shift->increment('cash_sales', $cash);
                $shift->increment('card_sales', $card);
            }

            DB::commit();

            return response()->json([
                'status'  => true,
                'message' => 'Invoice created successfully',
                'data'    => new InvoiceResource(
                    $invoice->load(['items', 'payments', 'customer', 'shift'])
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
            $invoice = Invoice::with(['items.product', 'customer'])
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
                'data'    => $invoice
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'حدث خطأ أثناء البحث',
                'error'   => $e->getMessage()
            ], 500);
        }
    }


}
