<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $categoryId = $this->route('category')?->id ?? null;

        return [
            'name' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('categories', 'name')->ignore($categoryId),
            ],

            'icon' => [
                'nullable',
                'string',
                'max:255',
            ],

            'parent_id' => [
                'nullable',
                'integer',
                'exists:categories,id',
                // يمنع إن الكاتيجوري يبقى parent لنفسه
                Rule::notIn([$categoryId]),
            ],
        ];
    }
}
