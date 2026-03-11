<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TreasuryTransaction extends BaseModel
{
    protected $guarded = ['id'];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    // العلاقة مع الخزينة
    public function treasury()
    {
        return $this->belongsTo(Treasury::class);
    }

    // العلاقة متعددة الأشكال مع المستندات (فواتير، سندات، الخ)
    public function reference()
    {
        return $this->morphTo();
    }

    // العلاقة مع المستخدم الذي أنشأ الحركة
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // سكوب للحركات الواردة
    public function scopeIncoming($query)
    {
        return $query->where('type', 'in');
    }

    // سكوب للحركات الصادرة
    public function scopeOutgoing($query)
    {
        return $query->where('type', 'out');
    }
}