<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TreasuryResource extends JsonResource
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
            'code' => $this->code,
            'branch_id' => $this->branch_id,
            'branch' => new BranchResource($this->branch) ?? null,
            'balance' => (float) $this->balance,
            'currency' => $this->currency,
            'is_main' => $this->is_main,
            'notes' => $this->notes,
            'created_at' => $this->created_at?->toDateTimeString(),
        ];
    }
}
