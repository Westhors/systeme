<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Employee extends BaseModel
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $guarded = ['id'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    // ✅ إضافة علاقة الفرع
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    // ✅ إضافة علاقة الخزينة
    public function treasury()
    {
        return $this->belongsTo(Treasury::class);
    }
}