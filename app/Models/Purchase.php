<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $fillable = [
        'user_id',
        'vehicle_id',
        'product_id',
        'amount_paid',
        'liters',
        'status',
        'slip_id',
    ];

    protected function casts(): array
    {
        return [
            'amount_paid' => 'decimal:2',
            'liters' => 'decimal:2',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
