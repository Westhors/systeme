<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PurchaseInvoiceResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'invoice_number' => $this->invoice_number,

            'supplier' => [
                'id' => $this->supplier?->id,
                'name' => $this->supplier?->name,
            ],

            'branch' => $this->branch?->name,
            'warehouse' => $this->warehouse?->name,

            'currency' => $this->currency?->code,
            'tax' => $this->tax?->name,

            'invoice_date' => $this->invoice_date,
            'due_date' => $this->due_date,
            'payment_method' => $this->payment_method,
            'note' => $this->note,

            'subtotal' => $this->subtotal,
            'discount_total' => $this->discount_total,
            'tax_total' => $this->tax_total,
            'total_amount' => $this->total_amount,

            'items' => $this->items->map(fn ($item) => [
                'product_id' => $item->product_id,
                'product_name' => $item->product?->name,
                'quantity' => $item->quantity,
                'price' => $item->price,
                'discount' => $item->discount,
                'tax' => $item->tax,
                'total' => $item->total,
            ]),

            'created_at' => $this->created_at->format('Y-m-d H:i'),
        ];
    }
}

