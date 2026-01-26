<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'              => $this->id,
            'name'            => $this->name,
            'description'     => $this->description,
            'image_url'       => $this->image_url,
            'category_id'     => $this->category_id,
            'sku'             => $this->sku,
            'barcode'         => $this->barcode,
            'stock'           => $this->stock,
            'reorder_level'   => $this->reorder_level,

            'units'           => ProductUnitResource::collection(
                $this->whenLoaded('units')
            ),

            'created_at'      => $this->created_at,
            'updated_at'      => $this->updated_at,
        ];
    }
}
