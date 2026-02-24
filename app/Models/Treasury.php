<?php

namespace App\Models;


class Treasury extends BaseModel
{
    protected $guarded = ['id'];

    protected $casts = [
        'is_main' => 'boolean',
        'balance' => 'float',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
