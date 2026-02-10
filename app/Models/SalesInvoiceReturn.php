<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesInvoiceReturn extends BaseModel
{
    protected $guarded = ['id'];

    public function invoice()
    {
        return $this->belongsTo(SalesInvoice::class, 'sales_invoice_id');
    }

    public function items()
    {
        return $this->hasMany(SalesInvoiceReturnItem::class);
    }
}
