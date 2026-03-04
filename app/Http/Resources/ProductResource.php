<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'name'          => $this->name,
            'description'   => $this->description,
            'image_url'     => $this->image_url,

            'imageUrl' => $this->getFirstMediaUrlTeam(),
            'image'    => new MediaResource($this->getFirstMedia()),

            'category'      => new CategoryResource($this->category),

            'sku'           => $this->sku,
            'barcode'       => $this->barcode,
            'beginning_balance' => $this->beginning_balance,

            // 👇 الكمية من المخزن
            'stock'         => $this->stock ?? 0,

            'reorder_level' => $this->reorder_level,
            'price'         => $this->price,
            'cost'          => $this->cost,
            'active'        => $this->active,

            'units' => ProductUnitResource::collection(
                $this->units
            ),

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}

