<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SalesRepresentativeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

     public function rules(): array
    {
        $id = $this->sales_representative?->id;

        return [
           
            'name'  => 'required|string|max:255',

            'phone' => [
                'required',
                'string',
                'max:20',
                Rule::unique('sales_representatives', 'phone')->ignore($id)
            ],

            'email' => [
                'nullable',
                'email',
                Rule::unique('sales_representatives', 'email')->ignore($id)
            ],

            'commission_rate' => 'nullable|numeric|min:0|max:100',

            'active' => 'boolean',

            'employee_id' => 'nullable|exists:employees,id',
            'branch_id' => 'nullable|exists:branches,id',
        ];
    }

}
