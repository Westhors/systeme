<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'addressLineOne' => $this->address_line_one,
            'addressLineTwo' => $this->address_line_two,
            'city' => $this->city,
            'state' => $this->state,
            'postalCode' => $this->postal_code,
            'country' => new CountryResource($this->country) ?? null,
            'countryId' => $this->country_id,
            'website' => $this->website,
            'phone' => $this->phone,
            'membersCount' => $this->members_count,
            'businessEst' => $this->business_est,
            'profile' => $this->profile,
            'fpp' => $this->fpp,
            'email' => $this->email,
            'refId' => $this->ref_id ?? null,
            'status' => $this->status ?? null,
            'active' => $this->active ?? null,
            'show_home' => $this->show_home ?? null,
            'imageUrl' => $this->getFirstMediaUrl(),
            'image' => new MediaResource($this->getFirstMedia()) ,
            'createdAt' => $this->created_at ? $this->created_at->format('d-M-Y H:i A') : null,
            'updatedAt' => $this->updated_at ? $this->updated_at->format('d-M-Y H:i A') : null,
            'contactPersons' => ContactPeopleResource::collection($this->contactPersons),
        ];
    }
}


