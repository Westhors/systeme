<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'name' => $this->name,
            'email' => $this->email,
            'logoUrl' => $this->getFirstMediaUrl('logo'),
            'logo' => new MediaResource($this->getFirstMedia('logo')),
            'logo_icon' => $this->getFirstMediaUrl('logo_icon'),
            'logo_icon_image' => new MediaResource($this->getFirstMedia('logo_icon')),
            'address' => $this->address,
            'phone' => $this->phone,
            'active' => $this->active,
            'tax_id' => $this->tax_id,
            'commercial_register' => $this->commercial_register,
            'country' => $this->country,
            'currency' => $this->currency,
            'date' => $this->date,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

            'website' => $this->website,
            'role' => 'admin',

        ];
    }
}
