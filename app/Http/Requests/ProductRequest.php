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
        $productId = $this->route('product');

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
            'beginning_balance' => 'nullable|boolean',
            'reorder_level'   => 'nullable|integer|min:0',
            'price'           => 'nullable|numeric|min:0',
            'cost'            => 'nullable|numeric|min:0',

            // units
            'units' => 'sometimes|array',
            'units.*.unit_id'             => 'required|exists:units,id',
            'units.*.cost_price'          => 'required|numeric|min:0',
            'units.*.sell_price'          => 'required|numeric|min:0',
            'units.*.barcode'             => 'nullable|string',

            // colors per unit - ✅ إزالة قواعد distinct
            'units.*.colors' => 'sometimes|array',
            'units.*.colors.*.color_id'   => 'required_with:units.*.colors|exists:colors,id',
            'units.*.colors.*.stock'      => 'required_with:units.*.colors|integer|min:0',
        ];
    }

    /**
     * بعد التحقق من الصلاحية، نقوم بتنقية البيانات من التكرار
     */
    public function validated($key = null, $default = null)
    {
        $validated = parent::validated($key, $default);

        // تنقية الـ units من الألوان المكررة
        if (isset($validated['units']) && is_array($validated['units'])) {
            foreach ($validated['units'] as &$unit) {
                if (isset($unit['colors']) && is_array($unit['colors'])) {
                    // إزالة الألوان المكررة بناءً على color_id
                    $uniqueColors = [];
                    $seenColorIds = [];

                    foreach ($unit['colors'] as $color) {
                        if (!in_array($color['color_id'], $seenColorIds)) {
                            $uniqueColors[] = $color;
                            $seenColorIds[] = $color['color_id'];
                        }
                    }

                    $unit['colors'] = $uniqueColors;
                }
            }
        }

        return $validated;
    }
}
