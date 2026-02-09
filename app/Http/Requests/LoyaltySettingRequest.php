<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoyaltySettingRequest extends FormRequest
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
            'points' => 'nullable|integer|min:0',
            'point_value' => 'nullable|numeric|min:0',
            'silver' => 'nullable|integer|min:0',
            'gold' => 'nullable|integer|min:0',
            'platinum' => 'nullable|integer|min:0',
        ];
    }
}


