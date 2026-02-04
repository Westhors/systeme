<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReturnItemResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,

            'product' => [
                'id'   => $this->product_id,
                'name' => $this->product_name,
            ],

            'color' => $this->color,
            'size'  => $this->size,

            'quantity' => $this->quantity,

            'price' => (float) $this->price,
            'total' => (float) $this->total,

            'created_at' => $this->created_at?->format('Y-m-d H:i'),
        ];
    }
}
