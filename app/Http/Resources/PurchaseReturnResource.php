<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PurchaseReturnResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'return_number' => $this->return_number,

            'invoice_number' => optional($this->purchaseInvoice)->invoice_number,

            'total_amount' => $this->total_amount,
            'reason' => $this->reason,

            'items' => $this->items->map(fn($item) => [
                'product' => optional($item->product)->name,
                'quantity' => $item->quantity,
                'unit_price' => $item->unit_price,
                'total_price' => $item->total_price,
            ]),

            'created_at' => $this->created_at?->format('Y-m-d'),
        ];
    }
}

