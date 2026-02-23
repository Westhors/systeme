<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RevenueResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'category' => $this->category,
            'amount' => $this->amount,
            'formatted_amount' => $this->formatted_amount,
            'description' => $this->description,
            'date' => $this->date->format('Y-m-d'),
            'date_formatted' => $this->date->format('d/m/Y'),
            'payment_method' => $this->payment_method,
            'payment_method_arabic' => $this->payment_method_arabic,
            'reference_number' => $this->reference_number,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
