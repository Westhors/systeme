<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesRepresentative extends BaseModel
{

    protected $guarded = ['id'];

    protected $casts = [
        'active' => 'boolean'
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
