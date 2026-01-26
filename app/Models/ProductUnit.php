<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductUnit extends BaseModel
{
    protected $guarded = ['id'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function colors()
    {
        return $this->hasMany(ProductUnitColor::class);
    }


}
