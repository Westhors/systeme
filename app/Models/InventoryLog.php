<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryLog extends BaseModel
{
    protected $guarded = ['id'];
    
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class)->withTrashed();
    }

    public function product()
    {
        return $this->belongsTo(Product::class)->withTrashed();
    }
}
