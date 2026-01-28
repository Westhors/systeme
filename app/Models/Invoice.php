<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends BaseModel
{
    protected $guarded = ['id'];

    protected static function booted()
    {
        static::creating(function ($invoice) {

            $year = now()->year;

            $lastInvoice = Invoice::whereYear('created_at', $year)
                ->orderBy('id', 'desc')
                ->first();

            $lastNumber = $lastInvoice
                ? intval(substr($lastInvoice->invoice_number, -6))
                : 0;

            $invoice->invoice_number =
                'INV-' . $year . '-' . str_pad($lastNumber + 1, 6, '0', STR_PAD_LEFT);
        });
    }
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
}

