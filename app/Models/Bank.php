<?php

namespace App\Models;

class Bank extends BaseModel
{
    protected $guarded = ['id'];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
