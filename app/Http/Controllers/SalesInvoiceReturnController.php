<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSalesInvoiceReturnRequest;
use App\Models\Product;
use App\Models\SalesInvoice;
use App\Models\SalesInvoiceReturn;
use App\Models\SalesInvoiceReturnItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalesInvoiceReturnController extends Controller
{
    public function storeReturn(StoreSalesInvoiceReturnRequest $request)
    {
        DB::beginTransaction();

        try {
            $invoice = SalesInvoice::findOrFail($request->sales_invoice_id);

            $returnNumber = 'SR-' . now()->format('Ymd') . '-' . rand(1000, 9999);

            $totalReturn = collect($request->items)->sum(function($item) {
                return $item['quantity'] * $item['price'];
            });

            $return = SalesInvoiceReturn::create([
                'sales_invoice_id' => $invoice->id,
                'return_number' => $returnNumber,
                'return_method' => $request->return_method,
                'total_amount' => $totalReturn,
                'note' => $request->note,
            ]);

            foreach ($request->items as $item) {
                SalesInvoiceReturnItem::create([
                    'sales_invoice_return_id' => $return->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'total' => $item['quantity'] * $item['price'],
                    'reason' => $item['reason'],
                ]);

                // تحديث المخزون
                $product = Product::find($item['product_id']);
                $product->increment('stock', $item['quantity']);
            }

            DB::commit();

            return response()->json([
                'data' => $return->load('items.product', 'invoice.customer'),
                'result' => 'Success',
                'message' => 'Sales return created successfully',
                'status' => 200,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'result' => 'Error',
                'message' => $e->getMessage(),
                'status' => 500,
            ], 500);
        }
    }

}
