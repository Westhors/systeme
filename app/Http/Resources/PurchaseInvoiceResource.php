<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PurchaseInvoiceResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'invoice_number' => $this->invoice_number,

            'supplier_id' => $this->supplier_id,
            'supplier_name' => $this->supplier?->name,
            'supplier_name_ar' => $this->supplier?->name_ar,

            'branch_id' => $this->branch_id,
            'branch_name' => $this->branch?->name,
            
            'warehouse_id' => $this->warehouse_id,
            'warehouse_name' => $this->warehouse?->name,

            // ✅ الخزينة
            'treasury_id' => $this->treasury_id,
            'treasury_name' => $this->treasury?->name,

            'currency_id' => $this->currency_id,
            'currency_code' => $this->currency?->code,
            
            'tax_id' => $this->tax_id,
            'tax_rate' => $this->tax?->rate,

            'invoice_date' => $this->invoice_date,
            'due_date' => $this->due_date,
            'payment_method' => $this->payment_method,
            'note' => $this->note,
            
            // ✅ المبالغ
            'subtotal' => (float) $this->subtotal,
            'discount_total' => (float) $this->discount_total,
            'tax_total' => (float) $this->tax_total,
            'total_amount' => (float) $this->total_amount,
            'paid_amount' => (float) $this->paid_amount,

            // ✅ الأصناف (مبسطة)
            'items' => $this->items->map(fn ($item) => [
                'product_id' => $item->product_id,
                'product_name' => $item->product?->name,
                'quantity' => $item->quantity,
                'price' => (float) $item->price,
                'discount' => (float) $item->discount,
                'tax' => (float) $item->tax,
                'total' => (float) $item->total,
            ]),

            'created_at' => $this->created_at->format('Y-m-d H:i'),
        ];
    }
}