<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BankResource extends JsonResource
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

            'account_number' => $this->account_number,
            'iban' => $this->iban,
            'swift_code' => $this->swift_code,

            'branch_id' => $this->branch_id,
            'branch' => new BranchResource($this->branch) ?? null,

            'balance' => $this->balance,
            'currency' => $this->currency,

            'contact_person' => $this->contact_person,
            'phone' => $this->phone,
            'address' => $this->address,

            'notes' => $this->notes,
            'created_at' => $this->created_at?->toDateTimeString(),
        ];
    }
}
