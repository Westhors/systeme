<?php

namespace App\Models;

use App\Traits\HasMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends BaseModel
{
    use HasMedia;
    protected $with = [
        'media',
    ];

    protected $casts = [
        'active' => 'boolean',
        'show_home' => 'boolean',
    ];
    protected $guarded = ['id'];
}
