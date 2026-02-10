<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PurchaseOrderResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'order_number' => $this->order_number,
            'supplier' => [
                'id' => $this->supplier?->id,
                'name' => $this->supplier?->name,
            ],
            'expected_delivery' => $this->expected_delivery,
            'total_amount' => $this->total_amount,
            'notes' => $this->notes,
            'items' => $this->items->map(function($item){
                return [
                    'product_id' => $item->product_id,
                    'product_name' => $item->product?->name,
                    'quantity' => $item->quantity,
                    'unit_cost' => $item->unit_cost,
                    'total' => $item->total,
                ];
            }),
            'created_at' => $this->created_at->format('Y-m-d H:i'),
        ];
    }
}
