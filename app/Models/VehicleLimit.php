<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VehicleLimit extends Model
{
    protected $fillable = [
        'vehicle_type',
        'max_amount',
        'max_liters',
        'block_days',
    ];

    protected function casts(): array
    {
        return [
            'max_amount' => 'decimal:2',
            'max_liters' => 'decimal:2',
        ];
    }
}
