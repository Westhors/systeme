<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReturnInvoiceResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'            => $this->id,
            'return_number' => $this->return_number,
            'invoice_id'    => $this->invoice_id,

            'total_amount'    => (float) $this->total_amount,
            'refunded_amount' => (float) $this->refunded_amount,
            'refund_method'   => $this->refund_method,

            'reason' => $this->reason,

            'created_at' => $this->created_at->format('Y-m-d H:i'),

            'items' => ReturnItemResource::collection($this->items),
            'invoice' => new InvoiceResource($this->invoice),
        ];
    }
}


