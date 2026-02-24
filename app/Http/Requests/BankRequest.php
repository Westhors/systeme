<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BankRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'account_number' => 'nullable|string|max:100',
            'iban' => 'nullable|string|max:100',
            'swift_code' => 'nullable|string|max:50',
            'branch_id' => 'nullable|exists:branches,id',
            'currency' => 'required|string|max:10',
            'contact_person' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ];
    }
}
