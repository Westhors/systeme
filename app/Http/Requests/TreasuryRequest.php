<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TreasuryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'name' => 'required|string|max:255',
            'code' => [
                'nullable',
                'string',
                'max:50',
                Rule::unique('treasuries', 'code')->ignore($this->route('treasury')),
            ],
            'branch_id' => 'nullable|exists:branches,id',
            'is_main' => 'required|boolean',
            'notes' => 'nullable|string',
            'currencies' => 'required|array|min:1',
            'currencies.*.currency_id' => 'required|exists:currencies,id',
            'currencies.*.balance' => 'required|numeric|min:0',
            'currencies.*.is_main' => 'sometimes|boolean',
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => 'حقل الاسم مطلوب',
            'currencies.required' => 'يجب إضافة عملة واحدة على الأقل',
            'currencies.min' => 'يجب إضافة عملة واحدة على الأقل',
            'currencies.*.currency_id.required' => 'معرف العملة مطلوب',
            'currencies.*.currency_id.exists' => 'العملة غير موجودة',
            'currencies.*.balance.required' => 'الرصيد مطلوب',
            'currencies.*.balance.min' => 'الرصيد يجب أن يكون 0 أو أكثر',
        ];
    }

    protected function prepareForValidation()
    {
        $data = $this->all();

        if (isset($data['currencies']) && is_array($data['currencies'])) {
            $hasMain = false;
            $currencies = [];

            foreach ($data['currencies'] as $index => $currency) {
                // التحقق من وجود is_main في البيانات
                $isMain = isset($currency['is_main']) ? (bool)$currency['is_main'] : false;

                if ($isMain) {
                    $hasMain = true;
                }

                $currencies[] = [
                    'currency_id' => (int)($currency['currency_id'] ?? 0),
                    'balance' => (float)($currency['balance'] ?? 0),
                    'is_main' => $isMain,
                ];
            }

            // لو مفيش عملة رئيسية، أول عملة تبقى رئيسية
            if (!$hasMain && !empty($currencies)) {
                $currencies[0]['is_main'] = true;
            }

            $this->merge(['currencies' => $currencies]);
        }
    }
}
