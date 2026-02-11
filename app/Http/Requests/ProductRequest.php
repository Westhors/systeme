<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $productId = $this->route('product'); // أو $this->product حسب اسم الراوت

        return [
            // product
            'name'            => 'required|string|max:255',
            'description'     => 'nullable|string',
            'image_url'       => 'nullable|string',
            'category_id'     => 'required|exists:categories,id',
            'sku' => [
            'nullable',
            'string',
            Rule::unique('products', 'sku')->ignore($productId),
            ],

            'barcode' => [
                'nullable',
                'string',
                Rule::unique('products', 'barcode')->ignore($productId),
            ],
            'stock'           => 'nullable|integer|min:0',
            'reorder_level'   => 'nullable|integer|min:0',
            'price'           => 'nullable|numeric|min:0',
            'cost'            => 'nullable|numeric|min:0',

            // units
            'units'                       => 'nullable|array|min:1',
            'units.*.unit_id'             => 'nullable|exists:units,id',
            'units.*.cost_price'          => 'nullable|numeric|min:0',
            'units.*.sell_price'          => 'nullable|numeric|min:0',
            'units.*.barcode'             => 'nullable|string',

            // colors per unit
            'units.*.colors'              => 'nullable|array|min:1',
            'units.*.colors.*.color_id'   => 'nullable|exists:colors,id',
            'units.*.colors.*.stock'      => 'nullable|integer|min:0',
        ];
    }
}
