<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReturnInvoice extends Model
{
    protected $guarded = ['id'];

    public function items()
    {
        return $this->hasMany(ReturnItem::class);
    }


    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    protected static function booted()
    {
        static::creating(function ($model) {
            $last = self::max('id') ?? 0;
            $model->return_number = 'RET-' . str_pad($last + 1, 6, '0', STR_PAD_LEFT);
        });
    }

        public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

}
