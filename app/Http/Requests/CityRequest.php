<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CityRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function rules()
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'country_id' => ['required', 'exists:countries,id'],
            'active' => ['required', 'boolean'],
            'position' => ['required'],
        ];

        if ($this->isMethod('put') || $this->isMethod('patch')) {
            $rules['name'] = ['nullable', 'string', 'max:255'];
            $rules['country_id'] = ['nullable', 'exists:countries,id'];
            $rules['active'] = ['nullable', 'boolean'];
            $rules['position'] = ['nullable'];
        }

        return $rules;
    }


    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
