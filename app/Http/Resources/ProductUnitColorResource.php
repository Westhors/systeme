<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductUnitColorResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'        => $this->id,
            'color_id'  => $this->color_id,
            'color'     => optional($this->color)->name,
            'stock'     => $this->stock,
        ];
    }
}
