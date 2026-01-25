<?php

namespace App\Models;

use App\Traits\HasMedia;

class Warehouse extends BaseModel
{
    use HasMedia;

    protected $with = [
        'media',
    ];

    protected $casts = [
        'active' => 'boolean',
        'main_branch' => 'boolean',
    ];

    protected $guarded = ['id'];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
