<?php

namespace App\Models;

use App\Traits\HasMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Product extends BaseModel
{
    use HasFactory, Notifiable , HasMedia;

    protected $with = [
        'media',
    ];

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

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }
}
