<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'        => $this->id,
            'name'      => $this->name,
            'icon'      => $this->icon,
            'parent_id' => $this->parent_id,

            'type' => $this->parent_id === null
                ? 'category'
                : 'sub_category',

            'parent' => $this->when(
                $this->parent_id !== null,
                fn () => new CategoryResource($this->parent)
            ),

            'children' => $this->when(
                $this->parent_id === null && $this->relationLoaded('children'),
                fn () => CategoryResource::collection($this->children)
            ),

            'createdAt' => $this->created_at?->format('Y-m-d H:i:s'),
            'updatedAt' => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}
