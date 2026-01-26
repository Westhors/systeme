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
            'warehouse_id'    => 'required|exists:warehouses,id',
            'sku'             => 'nullable|string|unique:products,sku',
            'barcode'         => 'nullable|string|unique:products,barcode',
            'stock'           => 'nullable|integer|min:0',
            'reorder_level'   => 'nullable|integer|min:0',
            'price'           => 'nullable|numeric|min:0',
            'cost'            => 'nullable|numeric|min:0',

            // units
            'units'                       => 'nullable|array|min:1',
            'units.*.unit_id'             => 'nullable|exists:units,id',
            'units.*.cost_price'          => 'nullable|numeric|min:0',
            'units.*.sell_price'          => 'nullable|numeric|min:0',
            'units.*.barcode'             => 'nullable|string|unique:product_units,barcode',

            // colors per unit
            'units.*.colors'              => 'nullable|array|min:1',
            'units.*.colors.*.color_id'   => 'nullable|exists:colors,id',
            'units.*.colors.*.stock'      => 'nullable|integer|min:0',
        ];
    }
}
