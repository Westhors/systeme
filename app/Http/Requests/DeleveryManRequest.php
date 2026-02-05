<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DeleveryManRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',

            'phone' => [
                'required',
                'string',
                'max:20',
                Rule::unique('sales_representatives', 'phone')
                    ->ignore($this->sales_representative?->id)
            ],

            'vehicle_type'   => 'nullable|string|max:50',
            'vehicle_number' => 'nullable|string|max:50',
        ];
    }
}
