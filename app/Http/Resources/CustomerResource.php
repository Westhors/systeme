<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'address' => $this->address,
            'email' => $this->email,
            'phone' => $this->phone,
            'point' => $this->point, // أي نقاط يدوية موجودة
            'last_paid_amount' => $this->last_paid_amount,
            // 'total_invoices_amount' => $this->total_invoices_amount,
            // 'loyalty_points' => $this->loyalty_points, // النقاط المحسوبة تلقائياً
        ];
    }
}
