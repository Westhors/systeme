<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends BaseModel
{
    use SoftDeletes;

    protected $guarded = ['id'];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

}
