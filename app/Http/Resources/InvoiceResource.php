<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'               => $this->id,
            'invoice_number'   => $this->invoice_number,
            'status'           => $this->status,

            'customer' => [
                'id'   => $this->customer?->id,
                'name' => $this->customer?->name,
            ],

            'amounts' => [
                'total'     => $this->total_amount,
                'paid'      => $this->paid_amount,
                'remaining' => $this->remaining_amount,
            ],

            'items' => InvoiceItemResource::collection($this->items),

            'payments' => InvoicePaymentResource::collection($this->payments),

            'created_at' => $this->created_at?->format('Y-m-d H:i'),
        ];
    }
}
