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
                'image' => 'products/coca-cola.jpg',
            ],
            [
                'name' => 'Pepsi 500ml',
                'slug' => 'pepsi-500ml',
                'description' => 'Refreshing cola with a unique taste',
                'price' => 1.45,
                'size' => '500ml',
                'stock' => 85,
                'status' => 'available',
                'category_id' => 1, // Soft Drinks
                'image' => 'products/pepsi.jpg',
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
                'image' => 'products/orange-juice.jpg',
            ],
            [
                'name' => 'Apple Juice 1L',
                'slug' => 'apple-juice-1l',
                'description' => 'Pure apple juice from fresh apples',
                'price' => 3.49,
                'size' => '1L',
                'stock' => 60,
                'status' => 'available',
                'category_id' => 2, // Fresh Juice
                'image' => 'products/apple-juice.jpg',
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
                'image' => 'products/red-bull.jpg',
            ],
            [
                'name' => 'Monster Energy 500ml',
                'slug' => 'monster-energy-500ml',
                'description' => 'Unleash the beast with this energy drink',
                'price' => 2.99,
                'size' => '500ml',
                'stock' => 45,
                'status' => 'available',
                'category_id' => 3, // Energy Drinks
                'image' => 'products/monster-energy.jpg',
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
                'image' => 'products/mineral-water.jpg',
            ],
            [
                'name' => 'Sparkling Water 500ml',
                'slug' => 'sparkling-water-500ml',
                'description' => 'Refreshing sparkling mineral water',
                'price' => 1.29,
                'size' => '500ml',
                'stock' => 120,
                'status' => 'available',
                'category_id' => 4, // Bottled Water
                'image' => 'products/sparkling-water.jpg',
            ],
            [
                'name' => 'Espresso Coffee 250ml',
                'slug' => 'espresso-coffee-250ml',
                'description' => 'Rich and bold espresso coffee',
                'price' => 2.25,
                'size' => '250ml',
                'stock' => 80,
                'status' => 'available',
                'category_id' => 5, // Hot Beverages
                'image' => 'products/coffee.jpg',
            ],
            [
                'name' => 'Mountain Dew 500ml',
                'slug' => 'mountain-dew-500ml',
                'description' => 'Citrus soda with a kick of caffeine',
                'price' => 1.60,
                'size' => '500ml',
                'stock' => 90,
                'status' => 'available',
                'category_id' => 1, // Soft Drinks
                'image' => 'products/mountain-dew.png',
            ],
            [
                'name' => 'Pineapple Juice 1L',
                'slug' => 'pineapple-juice-1l',
                'description' => 'Tropical pineapple juice',
                'price' => 4.25,
                'size' => '1L',
                'stock' => 40,
                'status' => 'available',
                'category_id' => 2, // Fresh Juice
                'image' => 'products/pineapple-juice.png',
            ],
            [
                'name' => 'Rockstar Energy 500ml',
                'slug' => 'rockstar-energy-500ml',
                'description' => 'High energy drink for active lifestyles',
                'price' => 2.80,
                'size' => '500ml',
                'stock' => 60,
                'status' => 'available',
                'category_id' => 3, // Energy Drinks
                'image' => 'products/rockstar-energy.png',
            ],
            [
                'name' => 'Perrier Sparkling Water 330ml',
                'slug' => 'perrier-sparkling-water-330ml',
                'description' => 'Premium sparkling mineral water',
                'price' => 1.99,
                'size' => '330ml',
                'stock' => 150,
                'status' => 'available',
                'category_id' => 4, // Bottled Water
                'image' => 'products/perrier-water.png',
            ],
            [
                'name' => 'Latte Coffee 300ml',
                'slug' => 'latte-coffee-300ml',
                'description' => 'Creamy latte with a hint of vanilla',
                'price' => 3.50,
                'size' => '300ml',
                'stock' => 70,
                'status' => 'available',
                'category_id' => 5, // Hot Beverages
                'image' => 'products/latte-coffee.png',
            ],
        ];

        foreach ($products as $product) {
            \App\Models\Product::create($product);
        }
    }
}
