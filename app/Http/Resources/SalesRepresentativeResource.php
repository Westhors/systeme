<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SalesRepresentativeResource extends JsonResource
{
    public function toArray($request): array
    {

        return [
            'id'              => $this->id,
            'name'            => $this->name,
            'phone'           => $this->phone,
            'email'           => $this->email,
            'commission_rate' => $this->commission_rate,
            'active'          => $this->active,

            'branch_id'   => $this->branch?->id,
            'branch_name' => $this->branch?->name,
            'employee_id'   => $this->employee?->id,
            'employee_name'   => $this->employee?->name,

            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
        ];
    }

}
