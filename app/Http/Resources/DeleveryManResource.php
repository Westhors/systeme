<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Validation\Rule;

class DeleveryManResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'              => $this->id,
            'name'            => $this->name,
            'phone'           => $this->phone,
            'vehicle_type'    => $this->vehicle_type,
            'vehicle_number'  => $this->vehicle_number,
            'created_at'      => $this->created_at?->format('Y-m-d H:i:s'),
        ];

    }
}

