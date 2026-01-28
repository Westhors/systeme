<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceItemResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'product_id'   => $this->product_id,
            'product_name' => $this->product_name,
            'color'        => $this->color,
            'size'         => $this->size,
            'quantity'     => $this->quantity,
            'price'        => $this->price,
            'total'        => $this->total,
        ];
    }
}

