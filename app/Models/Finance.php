<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Finance extends Model
{
    protected $guarded = ['id'];

    use HasFactory, SoftDeletes;

    protected $casts = [
        'date' => 'date',
        'amount' => 'decimal:2'
    ];

    // العلاقات (لو محتاج تربط بحاجات تانية)
    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }

    // Scopes مفيدة
    public function scopeToday($query)
    {
        return $query->whereDate('date', today());
    }

    public function scopeThisMonth($query)
    {
        return $query->whereMonth('date', now()->month)
                     ->whereYear('date', now()->year);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    // Accessor
    public function getFormattedAmountAttribute()
    {
        return number_format($this->amount, 2) . ' EGP';
    }

    public function getPaymentMethodArabicAttribute()
    {
        $methods = [
            'cash' => 'نقدي',
            'bank_transfer' => 'تحويل بنكي',
            'check' => 'شيك',
            'credit_card' => 'بطاقة ائتمان',
            'other' => 'أخرى'
        ];

        return $methods[$this->payment_method] ?? $this->payment_method;
    }
}
