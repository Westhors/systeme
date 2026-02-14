<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SalesInvoiceReturnResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'return_number' => $this->return_number,

            'invoice_number' => optional($this->invoice)->invoice_number,
            'customer' => optional(optional($this->invoice)->customer)->name,

            'return_method' => $this->return_method,
            'total_amount' => $this->total_amount,
            'note' => $this->note,

            'items' => $this->items->map(fn ($item) => [
                'product' => optional($item->product)->name,
                'quantity' => $item->quantity,
                'price' => $item->price,
                'total' => $item->total,
                'reason' => $item->reason,
            ]),

            'created_at' => $this->created_at?->format('Y-m-d'),
        ];
    }
}

