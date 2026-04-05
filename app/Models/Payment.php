<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'purchase_id',
        'transaction_id',
        'payment_status',
    ];

    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }
}
