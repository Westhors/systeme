<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'name' => 'nullable',
            'email' => ['nullable','email','unique:admins,email,'.$this->admin?->id],
            'password' => ['nullable'],
            'phone' => 'nullable',
            'active' => 'nullable|boolean',
            'address' => 'nullable',
            'tax_id' => 'nullable',
            'commercial_register' => 'nullable',
            'country' => 'nullable',
            'currency' => 'nullable',
            'date' => 'nullable|date',
        ];
    }
}
