<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CashierShiftResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'               => $this->id,
            'employee'         => $this->employee->name ?? $this->admin->name,
            'opening_balance'  => $this->opening_balance,
            'closing_balance'  => $this->closing_balance,
            'cash_sales'       => $this->cash_sales,
            'card_sales'       => $this->card_sales,
            'returns_amount'   => $this->returns_amount,
            'expected_amount'  => $this->expected_amount,
            'actual_amount'    => $this->actual_amount,
            'difference'       => $this->difference,
            'opened_at'        => $this->opened_at,
            'closed_at'        => $this->closed_at,
            'status'           => $this->status,
            'notes'            => $this->notes,
            'created_at'       => $this->created_at,
            'updated_at'       => $this->updated_at,
        ];
    }
}

