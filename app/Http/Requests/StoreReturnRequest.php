<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReturnRequest extends FormRequest
{
    public function authorize() { return true; }

    public function rules()
    {
        return [
            'purchase_invoices_id' => 'required|exists:purchase_invoices,id', // ✅ خليها required
            'reason' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'nullable|numeric|min:0' // ✅ خليها nullable
        ];
    }

    // ✅ إضافة messages عربية
    public function messages()
    {
        return [
            'purchase_invoices_id.required' => 'رقم الفاتورة مطلوب',
            'purchase_invoices_id.exists' => 'الفاتورة غير موجودة',
            'items.required' => 'يجب إضافة منتج واحد على الأقل',
            'items.min' => 'يجب إضافة منتج واحد على الأقل',
            'items.*.product_id.required' => 'معرف المنتج مطلوب',
            'items.*.product_id.exists' => 'المنتج غير موجود',
            'items.*.quantity.required' => 'الكمية مطلوبة',
            'items.*.quantity.min' => 'الكمية يجب أن تكون 1 على الأقل',
        ];
    }
}