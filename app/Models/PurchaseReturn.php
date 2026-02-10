<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseReturn extends BaseModel
{
    protected $guarded = ['id'];

    public function items()
    {
        return $this->hasMany(PurchaseReturnItem::class);
    }

    public function purchaseInvoice()
    {
        return $this->belongsTo(PurchaseInvoice::class, 'purchase_invoices_id');
    }
}
