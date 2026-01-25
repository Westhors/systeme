<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ColorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $colorId = $this->route('color')?->id ?? null;

        return [
            'name' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('colors', 'name')->ignore($colorId),
            ],

            'code' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('colors', 'code')->ignore($colorId),
            ],

            'hex_code' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('colors', 'hex_code')->ignore($colorId),
            ],
        ];
    }
}
