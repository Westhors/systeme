<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReturnItem extends Model
{
     protected $guarded = ['id'];

     public function returnInvoice()
     {
         return $this->belongsTo(ReturnInvoice::class);
     }
}
