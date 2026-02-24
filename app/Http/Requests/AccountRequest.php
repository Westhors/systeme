<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AccountRequest extends FormRequest
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
            'code' => 'required|unique:accounts,code',
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:accounts,id',
            'debit' => 'nullable|numeric',
            'credit' => 'nullable|numeric',
        ];
    }
}
