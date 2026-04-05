<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Models\VehicleLimit;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin',
            'email' => 'admin@fuelstation.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        // Create fuel categories and products
        $categories = [
            'Octane' => ['name' => 'Octane 95', 'price' => 130.00, 'qty' => 5000],
            'Petrol' => ['name' => 'Petrol Regular', 'price' => 115.00, 'qty' => 8000],
            'Diesel' => ['name' => 'Diesel Standard', 'price' => 110.00, 'qty' => 10000],
        ];

        foreach ($categories as $catName => $product) {
            $category = Category::create(['name' => $catName]);
            Product::create([
                'category_id' => $category->id,
                'name' => $product['name'],
                'price_per_liter' => $product['price'],
                'available_quantity' => $product['qty'],
            ]);
        }

        // Create vehicle limits
        $limits = [
            ['vehicle_type' => 'Motorcycle', 'max_amount' => 500, 'max_liters' => 5, 'block_days' => 3],
            ['vehicle_type' => 'Car', 'max_amount' => 3000, 'max_liters' => 30, 'block_days' => 7],
            ['vehicle_type' => 'CNG', 'max_amount' => 2000, 'max_liters' => 20, 'block_days' => 5],
            ['vehicle_type' => 'Truck', 'max_amount' => 10000, 'max_liters' => 100, 'block_days' => 7],
            ['vehicle_type' => 'Bus', 'max_amount' => 15000, 'max_liters' => 150, 'block_days' => 5],
        ];

        foreach ($limits as $limit) {
            VehicleLimit::create($limit);
        }
    }
}
