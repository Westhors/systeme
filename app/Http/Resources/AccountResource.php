<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AccountResource extends JsonResource
{
    public function toArray($request)
    {
        // تجهيز البيانات الأساسية
        $data = [
            'id' => $this->id,
            'code' => $this->code,
            'name' => $this->name,
            'debit' => (float) $this->debit,
            'credit' => (float) $this->credit,
            'balance' => (float) $this->balance,
        ];

        // إضافة الحسابات الفرعية إذا كانت محملة
        if ($this->relationLoaded('children')) {
            $data['children'] = AccountResource::collection($this->children);
        }

        // إضافة معلومات الـ parent إذا كان محملاً
        if ($this->relationLoaded('parent') && $this->parent) {
            $data['parent'] = [
                'id' => $this->parent->id,
                'code' => $this->parent->code,
                'name' => $this->parent->name,
            ];
        }

        return $data;
    }
}
