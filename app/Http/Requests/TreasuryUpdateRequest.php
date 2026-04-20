<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TreasuryUpdateRequest extends FormRequest
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
            'name' => 'nullable|string|max:255',
            'code' => [
                'nullable',
                'string',
                'max:50',
                Rule::unique('treasuries', 'code')->ignore($this->route('treasury')),
            ],
            'branch_id' => 'nullable|exists:branches,id',
            'balance' => 'nullable|numeric|min:0',
            'currency' => 'nullable|string|max:10',
            'is_main' => 'nullable|boolean',
            'notes' => 'nullable|string',
        ];
    }
}

