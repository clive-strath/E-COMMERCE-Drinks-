<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Coca-Cola 500ml',
                'slug' => 'coca-cola-500ml',
                'description' => 'Classic refreshing cola drink',
                'price' => 1.50,
                'size' => '500ml',
                'stock' => 100,
                'status' => 'available',
                'category_id' => 1, // Soft Drinks
            ],
            [
                'name' => 'Orange Juice 1L',
                'slug' => 'orange-juice-1l',
                'description' => 'Fresh squeezed orange juice',
                'price' => 3.99,
                'size' => '1L',
                'stock' => 50,
                'status' => 'available',
                'category_id' => 2, // Fresh Juice
            ],
            [
                'name' => 'Red Bull 250ml',
                'slug' => 'red-bull-250ml',
                'description' => 'Energy drink that gives you wings',
                'price' => 2.50,
                'size' => '250ml',
                'stock' => 75,
                'status' => 'available',
                'category_id' => 3, // Energy Drinks
            ],
            [
                'name' => 'Mineral Water 330ml',
                'slug' => 'mineral-water-330ml',
                'description' => 'Pure natural mineral water',
                'price' => 0.99,
                'size' => '330ml',
                'stock' => 200,
                'status' => 'available',
                'category_id' => 4, // Bottled Water
            ],
        ];

        foreach ($products as $product) {
            \App\Models\Product::create($product);
        }
    }
}
