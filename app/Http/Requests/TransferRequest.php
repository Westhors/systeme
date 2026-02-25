<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransferRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'type' => 'required|in:treasury_to_treasury,treasury_to_bank,bank_to_treasury,treasury_deposit,treasury_withdraw,bank_deposit,bank_withdraw',

            'from_treasury_id' => 'required_if:type,treasury_to_treasury,treasury_to_bank|nullable|exists:treasuries,id',
            'to_treasury_id'   => 'required_if:type,treasury_to_treasury,bank_to_treasury|nullable|exists:treasuries,id',

            'from_bank_id' => 'required_if:type,bank_to_treasury|nullable|exists:banks,id',
            'to_bank_id'   => 'required_if:type,treasury_to_bank|nullable|exists:banks,id',

            'amount' => 'required|numeric|min:0.01',
            'currency' => 'required|string|max:10',
            'notes' => 'nullable|string|max:500',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {

            // منع التحويل لنفس الخزنة
            if ($this->type === 'treasury_to_treasury' &&
                $this->from_treasury_id == $this->to_treasury_id) {
                $validator->errors()->add('to_treasury_id', 'لا يمكن التحويل لنفس الخزنة');
            }
        });
    }

    public function messages()
    {
        return [
            'required_if' => 'هذا الحقل مطلوب حسب نوع التحويل',
        ];
    }
}
