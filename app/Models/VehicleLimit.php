<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VehicleLimit extends Model
{
    protected $fillable = [
        'vehicle_type',
        'max_amount',
        'block_days_per_amount',
    ];

    protected function casts(): array
    {
        return [
            'max_amount' => 'decimal:2',
            'block_days_per_amount' => 'decimal:2',
        ];
    }

    /**
     * Calculate block days based on amount paid.
     * Formula: (amount_paid / max_amount) * block_days_per_amount
     */
    public function calculateBlockDays(float $amountPaid): float
    {
        if ($this->max_amount <= 0) {
            return 0;
        }

        return ($amountPaid / $this->max_amount) * $this->block_days_per_amount;
    }
}
