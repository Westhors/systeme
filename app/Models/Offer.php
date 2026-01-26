<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offer extends BaseModel
{
    protected $guarded = ['id'];

    protected $casts = [
        'active' => 'boolean',
    ];


    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
