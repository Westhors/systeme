<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UnitRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $unitId = $this->route('unit')?->id ?? null;

        return [
            'name' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('units', 'name')->ignore($unitId),
            ],

            'type_unit' => [
                'nullable',
                'string',
                'max:255',
            ],

            'code' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('units', 'code')->ignore($unitId),
            ],

            'position' => [
                'nullable',
                'max:255',
            ],
        ];
    }
}
