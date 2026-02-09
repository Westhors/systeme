<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesInvoice extends BaseModel
{
    protected $guarded = ['id'];

    public function items()
    {
        return $this->hasMany(SalesInvoiceItem::class, 'sales_invoice_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function salesRepresentative()
    {
        return $this->belongsTo(SalesRepresentative::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function tax()
    {
        return $this->belongsTo(Tax::class);
    }

}
