<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InventoryLogResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,

            'warehouse' => [
                'id'   => optional($this->warehouse)->id,
                'name' => optional($this->warehouse)->name,
            ],

            'product' => [
                'id'   => optional($this->product)->id,
                'name' => optional($this->product)->name,
                'sku'  => optional($this->product)->sku,
            ],

            'system_stock'  => $this->system_stock,
            'counted_stock' => $this->counted_stock,
            'difference'    => $this->difference,

            'note' => $this->note,

            'created_at' => optional($this->created_at)->format('Y-m-d H:i'),
        ];
    }
}

