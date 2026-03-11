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
            'name_ar'       => $this->name_ar,
            'position'      => $this->position,
            'department'    => $this->department,
            
            // ✅ الصلاحية
            'role' => [
                'id' => $this->role?->id,
                'name' => $this->role?->name,
            ],
            
            // ✅ الفرع
            'branch' => $this->branch ? [
                'id' => $this->branch->id,
                'name' => $this->branch->name,
                'name_ar' => $this->branch->name_ar,
            ] : null,
            
            // ✅ الخزينة
            'treasury' => $this->treasury ? [
                'id' => $this->treasury->id,
                'name' => $this->treasury->name,
                'name_ar' => $this->treasury->name_ar,
                'is_main' => $this->treasury->is_main,
            ] : null,
            
            'phone'         => $this->phone,
            'email'         => $this->email,
            'salary'        => $this->salary,
            'is_active'     => $this->is_active,
            'created_at'    => $this->created_at?->format('Y-m-d H:i:s'),
        ];
    }
}