<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Employee extends BaseModel
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $guarded = ['id'];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

}
