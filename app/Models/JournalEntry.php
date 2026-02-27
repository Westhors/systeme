<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JournalEntry extends Model
{
    protected $guarded = ['id'];
    public function lines()
    {
        return $this->hasMany(JournalEntryLine::class);
    }
}
