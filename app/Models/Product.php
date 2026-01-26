<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends BaseModel
{
    protected $guarded = ['id'];

    protected $casts = [
        'active' => 'boolean',
    ];
    
    public function units()
    {
        return $this->hasMany(ProductUnit::class);
    }

    public function offers()
    {
        return $this->belongsToMany(Offer::class);
    }
}
