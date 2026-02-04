<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReturnPaymentResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,

            'method' => $this->method,
            // cash | card | wallet

            'amount' => (float) $this->amount,

            'created_at' => $this->created_at?->format('Y-m-d H:i'),
        ];
    }
}

