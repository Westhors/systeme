<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

class TransferResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'type' => $this->type,

            'from' => [
                'treasury' => $this->fromTreasury?->name,
                'bank' => $this->fromBank?->name,
            ],

            'to' => [
                'treasury' => $this->toTreasury?->name,
                'bank' => $this->toBank?->name,
            ],

            'amount' => $this->amount,
            'currency' => $this->currency,
            'notes' => $this->notes,
            'date' => $this->created_at->format('Y-m-d H:i'),
        ];
    }
}
