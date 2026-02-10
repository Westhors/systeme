<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesInvoiceReturnItem extends Model
{
    protected $guarded = ['id'];

        public function return()
    {
        return $this->belongsTo(SalesInvoiceReturn::class, 'sales_invoice_return_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

}
