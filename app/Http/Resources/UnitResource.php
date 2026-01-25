<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UnitResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'        => $this->id,
            'name'      => $this->name,
            'type_unit' => $this->type_unit,
            'code'      => $this->code,
            'position'  => $this->position,
            'createdAt'=> $this->created_at?->format('Y-m-d H:i:s'),
            'updatedAt'=> $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}
