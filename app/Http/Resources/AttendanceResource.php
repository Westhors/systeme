<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AttendanceResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'         => $this->id,
            'date'       => $this->date?->format('Y-m-d'),

            'employee' => [
                'name' => $this->employee?->name,
                'employee_code'   => $this->employee?->id,
            ],

            'check_in'   => $this->check_in,
            'check_out'  => $this->check_out,
            'status'     => $this->status,

            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
        ];
    }
}
