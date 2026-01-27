<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OfferResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'              => $this->id,
            'name'            => $this->name,
            'description'     => $this->description,

            'discount_type'   => $this->discount_type,
            'discount_value'  => $this->discount_value,

            'min_quantity'    => $this->min_quantity,
            'min_usage'       => $this->min_usage,

            'start_date'      => $this->start_date,
            'start_time'      => $this->start_time,
            'end_date'        => $this->end_date,
            'end_time'        => $this->end_time,

            'active'       => $this->is_active,

            'products'        => ProductResource::collection($this->whenLoaded('products')),

            'created_at'      => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at'      => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}

