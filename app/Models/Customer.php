<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends BaseModel
{

    protected $guarded = ['id'];

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    // مجموع كل الفواتير
    public function getTotalInvoicesAmountAttribute()
    {
        return $this->invoices()->sum('total_amount');
    }

    // النقاط الحالية (اليدوية + المكتسبة)
    public function getLoyaltyPointsAttribute()
    {
        $loyaltySetting = LoyaltySetting::first();
        if (!$loyaltySetting || $loyaltySetting->point_value <= 0) return $this->point ?? 0;

        $earnedPoints = floor($this->total_invoices_amount / $loyaltySetting->point_value);

        return ($this->point ?? 0) + $earnedPoints;
    }
}
