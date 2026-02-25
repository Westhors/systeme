<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AccountResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'name' => $this->name,
            'debit' => (float) $this->debit,
            'credit' => (float) $this->credit,
            'balance' => (float) $this->balance,
            'level' => $this->level, // عمق الحساب
            'has_children' => $this->children->isNotEmpty(),

            // الأبناء مع أحفادهم (كل المستويات)
            'children' => AccountResource::collection($this->whenLoaded('childrenRecursive')),

            // معلومات الأب
            'parent' => $this->whenLoaded('parentRecursive', function() {
                return [
                    'id' => $this->parent->id,
                    'code' => $this->parent->code,
                    'name' => $this->parent->name,
                ];
            }),
        ];
    }
}
