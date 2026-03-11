<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends BaseModel
{
    protected $guarded = ['id'];



    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    public function payments()
    {
        return $this->hasMany(InvoicePayment::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function salesRepresentative()
    {
        return $this->belongsTo(SalesRepresentative::class, 'sales_representative_id');
    }

    public function shift()
    {
        return $this->belongsTo(CashierShift::class, 'cashier_shift_id');
    }
     public function cashier()
    {
        return $this->belongsTo(Employee::class, 'cashier_id');
    }

    // ✅ إضافة علاقة الخزينة
    public function treasury()
    {
        return $this->belongsTo(Treasury::class, 'treasury_id');
    }

    // ✅ إضافة علاقة حركات الخزينة
    public function treasuryTransactions()
    {
        return $this->morphMany(TreasuryTransaction::class, 'reference');
    }

}

