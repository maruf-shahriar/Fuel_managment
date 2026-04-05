<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $fillable = [
        'user_id',
        'vehicle_type',
        'vehicle_number',
        'is_blocked',
        'blocked_until',
    ];

    protected function casts(): array
    {
        return [
            'is_blocked' => 'boolean',
            'blocked_until' => 'datetime',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    public function isCurrentlyBlocked(): bool
    {
        if (!$this->is_blocked) {
            return false;
        }

        if ($this->blocked_until && $this->blocked_until->isPast()) {
            $this->update(['is_blocked' => false, 'blocked_until' => null]);
            return false;
        }

        return true;
    }
}
