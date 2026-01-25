<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WarehouseRequest extends FormRequest
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
            'code' => 'nullable',
            'phone' => 'nullable',
            'address' => 'nullable',
            'manager' => 'nullable',
            'branch_id' => 'nullable|exists:branches,id',
            'note' => 'nullable',
            'active' => 'nullable|boolean',
            'main_branch' => 'nullable|boolean',
        ];
    }
}


