<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'            => $this->id,
            'employee_code' => $this->employee_code,
            'name'          => $this->name,
            // 'name_ar'       => $this->name_ar,
            'position'      => $this->position,
            'department'    => $this->department,
            'role'          => $this->role,
            'phone'         => $this->phone,
            'email'         => $this->email,
            'salary'        => $this->salary,
            'created_at'    => $this->created_at?->format('Y-m-d H:i:s'),
        ];
    }
}
