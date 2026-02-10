<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseInvoiceRequest extends FormRequest
{
    public function authorize() { return true; }

    public function rules()
    {
        return [
            'supplier_id' => 'required|exists:suppliers,id',
            'branch_id' => 'nullable|exists:branches,id',
            'warehouse_id' => 'nullable|exists:warehouses,id',
            'currency_id' => 'nullable|exists:currencies,id',
            'tax_id' => 'nullable|exists:taxes,id',

            'invoice_date' => 'required|date',
            'due_date' => 'nullable|date',
            'payment_method' => 'nullable|string',
            'note' => 'nullable|string',

            'items' => 'required|array|min:1',

            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|numeric|min:1',
            'items.*.price' => 'required|numeric|min:0',
            'items.*.discount' => 'nullable|numeric|min:0',
            'items.*.tax' => 'nullable|numeric|min:0',
        ];
    }
}
