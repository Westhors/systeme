<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AttendanceResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'         => $this->id,
            'employee' => [
                'name' => $this->employee?->name,
                'employee_code'   => $this->employee?->id,
            ],
            'date'       => $this->date?->format('Y-m-d'),


            'check_in'   => $this->check_in?->format('H:i:s'),
            'check_out'  => $this->check_out?->format('H:i:s'),
            'status'     => $this->status,

            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
        ];
    }
}
