<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductWarehouseResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,

            'product' => new ProductResource($this->whenLoaded('product')),

            'warehouse' => [
                'id' => $this->warehouse?->id,
                'name' => $this->warehouse?->name,
            ],

            'stock' => $this->stock,
            'cost' => $this->cost,

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
