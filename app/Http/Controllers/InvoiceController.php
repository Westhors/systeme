<?php

namespace App\Http\Controllers;

use App\Http\Resources\InvoiceResource;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\InvoicePayment;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
   public function store(Request $request)
{
    DB::beginTransaction();

    try {

        $total = collect($request->items)->sum(fn ($item) =>
            $item['price'] * $item['quantity']
        );

        $paid = collect($request->payments)->sum('amount');

        $invoice = Invoice::create([
            'customer_id'      => $request->customer_id,
            'total_amount'     => $total,
            'paid_amount'      => $paid,
            'remaining_amount' => $total - $paid,
            'status'           => $paid >= $total ? 'paid' : 'partial',
        ]);

        foreach ($request->items as $item) {

            $product = Product::findOrFail($item['product_id']);

            $invoice->items()->create([
                'product_id'   => $product->id,
                'product_name' => $product->name,
                'color'        => $item['color'] ?? null,
                'size'         => $item['size'] ?? null,
                'quantity'     => $item['quantity'],
                'price'        => $item['price'],
                'total'        => $item['price'] * $item['quantity'],
            ]);
        }

        foreach ($request->payments as $payment) {
            $invoice->payments()->create([
                'method' => $payment['method'],
                'amount' => $payment['amount'],
            ]);
        }

        DB::commit();

        return response()->json([
            'status'  => true,
            'message' => 'Invoice created successfully',
            'data'    => new InvoiceResource(
                $invoice->load(['items', 'payments', 'customer'])
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
