<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'from_treasury_id',
        'to_treasury_id',
        'from_bank_id',
        'to_bank_id',
        'amount',
        'currency',
        'notes',
    ];

    public function fromTreasury() { return $this->belongsTo(Treasury::class, 'from_treasury_id'); }
    public function toTreasury() { return $this->belongsTo(Treasury::class, 'to_treasury_id'); }
    public function fromBank() { return $this->belongsTo(Bank::class, 'from_bank_id'); }
    public function toBank() { return $this->belongsTo(Bank::class, 'to_bank_id'); }
}
