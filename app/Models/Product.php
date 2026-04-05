<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'price_per_liter',
        'available_quantity',
    ];

    protected function casts(): array
    {
        return [
            'price_per_liter' => 'decimal:2',
            'available_quantity' => 'decimal:2',
        ];
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }
}
