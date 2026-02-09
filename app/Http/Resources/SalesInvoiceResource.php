<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SalesInvoiceResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'invoice_number' => $this->invoice_number,

            'customer' => [
                'id' => $this->customer?->id,
                'name' => $this->customer?->name,
            ],

            'sales_representative' => [
                'id' => $this->salesRepresentative?->id,
                'name' => $this->salesRepresentative?->name,
            ],

            'branch' => $this->branch?->name,
            'warehouse' => $this->warehouse?->name,

            'currency' => $this->currency?->code,
            'tax' => $this->tax?->name,

            'payment_method' => $this->payment_method,
            'due_date' => $this->due_date,
            'note' => $this->note,

            'total_amount' => $this->total_amount,

            'items' => $this->items->map(function ($item) {
                return [
                    'product_id' => $item->product_id,
                    'product_name' => $item->product?->name,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'total' => $item->total,
                ];
            }),

            'created_at' => $this->created_at->format('Y-m-d H:i'),
        ];
    }
}
