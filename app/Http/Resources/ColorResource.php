<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ColorResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'        => $this->id,
            'name'      => $this->name,
            'code'      => $this->code,
            'hex_code'  => $this->hex_code,
            'createdAt'=> $this->created_at?->format('Y-m-d H:i:s'),
            'updatedAt'=> $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}

