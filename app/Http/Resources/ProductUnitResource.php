<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductUnitResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'unit_id'     => $this->unit_id,
            'unit_name'   => optional($this->unit)->name,
            'cost_price'  => $this->cost_price,
            'sell_price'  => $this->sell_price,
            'barcode'     => $this->barcode,

            'colors'      => ProductUnitColorResource::collection(
                $this->colors
            ),
        ];
    }
}
