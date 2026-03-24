<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TransferRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // يمكنك تغييرها إلى auth()->check() إذا أردت المصادقة
    }

    public function rules()
    {
        $type = $this->input('type');
        
        return [
            'type' => [
                'required', 
                Rule::in([
                    'treasury_to_treasury', 
                    'treasury_to_bank', 
                    'bank_to_treasury',
                    'bank_to_bank', 
                    'treasury_deposit', 
                    'treasury_withdraw',
                    'bank_deposit', 
                    'bank_withdraw'
                ])
            ],
            
            // خزنة المصدر - مطلوبة لأنواع معينة
            'from_treasury_id' => [
                'nullable',
                'exists:treasuries,id',
                $this->requiredIfIn(['treasury_to_treasury', 'treasury_to_bank', 'treasury_withdraw'])
            ],
            
            // خزنة الوجهة - مطلوبة لأنواع معينة
            'to_treasury_id' => [
                'nullable',
                'exists:treasuries,id',
                $this->requiredIfIn(['treasury_to_treasury', 'bank_to_treasury', 'treasury_deposit'])
            ],
            
            // بنك المصدر - مطلوب لأنواع معينة
            'from_bank_id' => [
                'nullable',
                'exists:banks,id',
                $this->requiredIfIn(['bank_to_treasury', 'bank_to_bank', 'bank_withdraw'])
            ],
            
            // بنك الوجهة - مطلوب لأنواع معينة
            'to_bank_id' => [
                'nullable',
                'exists:banks,id',
                $this->requiredIfIn(['treasury_to_bank', 'bank_to_bank', 'bank_deposit'])
            ],
            
            'amount' => 'required|numeric|min:0.01',
            'currency' => 'required|string|max:10|exists:currencies,code',
            'notes' => 'nullable|string|max:500',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $type = $this->input('type');
            
            // التحقق من عدم وجود المصدر والوجهة بنفس الوقت (لنفس النوع)
            if (in_array($type, ['treasury_to_treasury', 'bank_to_bank'])) {
                if ($type === 'treasury_to_treasury') {
                    // منع التحويل لنفس الخزنة
                    if ($this->from_treasury_id == $this->to_treasury_id) {
                        $validator->errors()->add('to_treasury_id', 'لا يمكن التحويل لنفس الخزنة');
                    }
                }
                
                if ($type === 'bank_to_bank') {
                    // منع التحويل لنفس البنك
                    if ($this->from_bank_id == $this->to_bank_id) {
                        $validator->errors()->add('to_bank_id', 'لا يمكن التحويل لنفس البنك');
                    }
                }
            }
            
            // التحقق من وجود مصدر (لا يمكن أن يكون المصدر فارغ)
            $hasSource = false;
            if (in_array($type, ['treasury_to_treasury', 'treasury_to_bank', 'treasury_withdraw'])) {
                $hasSource = !empty($this->from_treasury_id);
            }
            if (in_array($type, ['bank_to_treasury', 'bank_to_bank', 'bank_withdraw'])) {
                $hasSource = !empty($this->from_bank_id);
            }
            
            if (!$hasSource && in_array($type, ['treasury_withdraw', 'bank_withdraw', 'treasury_to_treasury', 'treasury_to_bank', 'bank_to_treasury', 'bank_to_bank'])) {
                $validator->errors()->add('source', 'يجب تحديد المصدر (خزنة أو بنك)');
            }
            
            // التحقق من وجود وجهة للعمليات التي تتطلب وجهة
            $hasDestination = false;
            if (in_array($type, ['treasury_to_treasury', 'bank_to_treasury', 'treasury_deposit'])) {
                $hasDestination = !empty($this->to_treasury_id);
            }
            if (in_array($type, ['treasury_to_bank', 'bank_to_bank', 'bank_deposit'])) {
                $hasDestination = !empty($this->to_bank_id);
            }
            
            if (!$hasDestination && !in_array($type, ['treasury_withdraw', 'bank_withdraw'])) {
                $validator->errors()->add('destination', 'يجب تحديد الوجهة (خزنة أو بنك)');
            }
        });
    }
    
    /**
     * مساعد للتحقق من أن الحقل مطلوب إذا كان النوع ضمن القائمة
     */
    protected function requiredIfIn(array $types)
    {
        return Rule::requiredIf(in_array($this->input('type'), $types));
    }

    public function messages()
    {
        return [
            'type.required' => 'نوع الحركة مطلوب',
            'type.in' => 'نوع الحركة غير صالح',
            
            'from_treasury_id.required' => 'الخزنة المصدر مطلوبة لهذا النوع من الحركة',
            'from_treasury_id.exists' => 'الخزنة المصدر غير موجودة',
            
            'to_treasury_id.required' => 'الخزنة الوجهة مطلوبة لهذا النوع من الحركة',
            'to_treasury_id.exists' => 'الخزنة الوجهة غير موجودة',
            
            'from_bank_id.required' => 'البنك المصدر مطلوب لهذا النوع من الحركة',
            'from_bank_id.exists' => 'البنك المصدر غير موجود',
            
            'to_bank_id.required' => 'البنك الوجهة مطلوب لهذا النوع من الحركة',
            'to_bank_id.exists' => 'البنك الوجهة غير موجود',
            
            'amount.required' => 'المبلغ مطلوب',
            'amount.numeric' => 'المبلغ يجب أن يكون رقماً',
            'amount.min' => 'المبلغ يجب أن يكون أكبر من صفر',
            
            'currency.required' => 'العملة مطلوبة',
            'currency.exists' => 'العملة غير موجودة في النظام',
            
            'notes.max' => 'الملاحظات لا يمكن أن تتجاوز 500 حرف',
        ];
    }
}