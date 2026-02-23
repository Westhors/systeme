<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RevenueRequest extends FormRequest
{
    public function authorize()
    {
        return true; // عدلها حسب صلاحياتك
    }

    public function rules()
    {
        $rules = [
            'category' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:1000',
            'date' => 'required|date',
            'payment_method' => 'required|in:cash,bank_transfer,check,credit_card,other',
            'reference_number' => 'nullable|string|max:255'
        ];

        // لو عندك categories محددة مسبقاً
        // 'category' => 'required|in:sales,services,investments,other',

        return $rules;
    }

    public function messages()
    {
        return [
            'category.required' => 'الفئة مطلوبة',
            'amount.required' => 'المبلغ مطلوب',
            'amount.numeric' => 'المبلغ يجب أن يكون رقماً',
            'amount.min' => 'المبلغ يجب أن يكون أكبر من صفر',
            'date.required' => 'التاريخ مطلوب',
            'date.date' => 'التاريخ غير صحيح',
            'payment_method.required' => 'طريقة الدفع مطلوبة',
            'payment_method.in' => 'طريقة الدفع غير صحيحة'
        ];
    }
}
