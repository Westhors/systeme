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


}
