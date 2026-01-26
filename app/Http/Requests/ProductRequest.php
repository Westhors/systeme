<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // product
            'name'            => 'required|string|max:255',
            'description'     => 'nullable|string',
            'image_url'       => 'nullable|string',
            'category_id'     => 'required|exists:categories,id',
            'sku'             => 'nullable|string|unique:products,sku',
            'barcode'         => 'nullable|string|unique:products,barcode',
            'stock'           => 'nullable|integer|min:0',
            'reorder_level'   => 'nullable|integer|min:0',

            // units
            'units'                       => 'required|array|min:1',
            'units.*.unit_id'             => 'required|exists:units,id',
            'units.*.cost_price'          => 'required|numeric|min:0',
            'units.*.sell_price'          => 'required|numeric|min:0',
            'units.*.barcode'             => 'nullable|string|unique:product_units,barcode',

            // colors per unit
            'units.*.colors'              => 'required|array|min:1',
            'units.*.colors.*.color_id'   => 'required|exists:colors,id',
            'units.*.colors.*.stock'      => 'required|integer|min:0',
        ];
    }
}
