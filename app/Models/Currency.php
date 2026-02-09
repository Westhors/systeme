<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Currency extends BaseModel
{
    protected $guarded = ['id'];

    protected $casts = [
        'active' => 'boolean',
        'default' => 'boolean',
    ];
}
