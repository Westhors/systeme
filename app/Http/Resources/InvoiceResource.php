<?php

namespace App\Http\Resources;

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

            'salesRepresentative' => [
                'id'   => $this->salesRepresentative?->id,
                'name' => $this->salesRepresentative?->name,
            ],

            // ✅ إضافة الكاشير (الموظف اللي سجل الفاتورة)
            'cashier' => $this->cashier ? [
                'id'          => $this->cashier->id,
                'name'        => $this->cashier->name,
                'name_ar'     => $this->cashier->name_ar,
                'employee_code' => $this->cashier->employee_code,
            ] : null,

            // ✅ إضافة الخزينة
            'treasury' => $this->treasury ? [
                'id'          => $this->treasury->id,
                'name'        => $this->treasury->name,
                'name_ar'     => $this->treasury->name_ar,
                'is_main'     => $this->treasury->is_main,
            ] : null,

            'amounts' => [
                'total'     => (float) $this->total_amount,
                'paid'      => (float) $this->paid_amount,
                'remaining' => (float) $this->remaining_amount,
            ],

            'items' => InvoiceItemResource::collection($this->items),

            'payments' => InvoicePaymentResource::collection($this->payments),

            'created_at' => $this->created_at?->format('Y-m-d H:i'),
        ];
    }
}