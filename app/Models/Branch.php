<?php

namespace App\Models;

use App\Traits\HasMedia;

class Branch extends BaseModel
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

    public function warehouses()
    {
        return $this->hasMany(Warehouse::class);
    }
}
