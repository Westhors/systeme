<?php

namespace App\Http\Controllers;

use App\Http\Resources\ReturnInvoiceResource;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\ReturnInvoice;
use App\Models\ReturnItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReturnInvoiceController extends Controller
{
    public function storeReturn(Request $request)
    {
        DB::beginTransaction();

       try {
        $invoice = Invoice::with('items')
            ->where('invoice_number', $request->invoice_number)
            ->firstOrFail();

        $total = 0;

        foreach ($request->items as $item) {
            $invoiceItem = $invoice->items->firstWhere('product_id', $item['product_id']);

            if (!$invoiceItem) {
                return response()->json([
                    'status' => false,
                    'message' => "المنتج بالمعرف  مش موجود في الفاتورة {$invoice->invoice_number}"
                ], 404);
            }

            $alreadyReturned = ReturnItem::where('product_id', $item['product_id'])
                ->whereHas('returnInvoice', fn($q) => $q->where('invoice_id', $invoice->id))
                ->sum('quantity');

            $remaining = $invoiceItem->quantity - $alreadyReturned;

            if ($item['quantity'] > $remaining) {
                return response()->json([
                    'status' => false,
                    'message' => "الكمية المرتجعة أكبر من المتبقي للمنتج {$invoiceItem->product_name}"
                ], 400);
            }

            $total += $invoiceItem->price * $item['quantity'];
        }


            // إنشاء المرتجع
            $return = ReturnInvoice::create([
                'invoice_id'      => $invoice->id,
                'total_amount'    => $total,
                'refunded_amount' => $total,
                'refund_method'   => $request->refund_method,
                'reason'          => $request->reason,
            ]);

            // حفظ العناصر المرتجعة
            foreach ($request->items as $item) {

                $invoiceItem = $invoice->items
                    ->where('product_id', $item['product_id'])
                    ->firstOrFail();

                $product = Product::findOrFail($item['product_id']);

                $return->items()->create([
                    'product_id'   => $product->id,
                    'product_name' => $product->name,
                    // 'color'        => $invoiceItem->color ?? null,
                    // 'size'         => $invoiceItem->size ?? null,
                    'quantity'     => $item['quantity'],
                    'price'        => $invoiceItem->price,
                    'total'        => $invoiceItem->price * $item['quantity'],
                ]);

                // إعادة للمخزون
                $product->increment('stock', $item['quantity']);
            }

            // Audit Log
            activity()
                ->performedOn($return)
                ->withProperties(['invoice_id' => $invoice->id])
                ->log('return_created');

            DB::commit();

            return response()->json([
                'status'  => true,
                'message' => 'تم إنشاء فاتورة المرتجع بنجاح',
                'data'    => new ReturnInvoiceResource(
                    $return->load(['items', 'invoice'])
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

    public function invoiceReturnIndex(Request $request)
    {
        try {
            $filters = $request->input('filters', []);
            $orderBy = $request->input('orderBy', 'id');
            $orderByDirection = $request->input('orderByDirection', 'desc');
            $perPage = $request->input('perPage', 10);
            $paginate = $request->boolean('paginate', true);

            $query = ReturnInvoice::with(['invoice.customer']);

            // =========================
            // FILTERS
            // =========================

            if (!empty($filters['return_number'])) {
                $query->where('return_number', 'like', '%' . $filters['return_number'] . '%');
            }

            if (!empty($filters['invoice_number'])) {
                $query->whereHas('invoice', function ($q) use ($filters) {
                    $q->where('invoice_number', 'like', '%' . $filters['invoice_number'] . '%');
                });
            }

            if (!empty($filters['refund_method'])) {
                $query->where('refund_method', $filters['refund_method']);
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
                $returns = $query->paginate($perPage);

                return response()->json([
                    'data' => ReturnInvoiceResource::collection($returns->items()),
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
                    'message' => 'Return invoices fetched successfully',
                    'status' => 200,
                ]);
            }

            // =========================
            // NON PAGINATED MODE
            // =========================
            $returns = $query->get();

            return response()->json([
                'data' => ReturnInvoiceResource::collection($returns),
                'links' => null,
                'meta' => null,
                'result' => 'Success',
                'message' => 'Return invoices fetched successfully',
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




}
