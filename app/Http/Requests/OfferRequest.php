<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OfferRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'            => 'required|string|max:255',
            'description'     => 'nullable|string',

            'discount_type'   => 'required|in:percentage,fixed',
            'discount_value'  => 'required|numeric|min:0',

            'min_quantity'    => 'required|integer|min:1',
            'min_usage'       => 'nullable|integer|min:1',

            'start_date'      => 'required|date',
            'start_time'      => 'required|date_format:H:i',
            'end_date'        => 'required|date|after_or_equal:start_date',
            'end_time'        => 'required|date_format:H:i',

            'active'       => 'boolean',

            'product_ids'     => 'required|array|min:1',
            'product_ids.*'   => 'exists:products,id',
        ];
    }
}
