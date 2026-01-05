<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Soft Drinks', 'slug' => 'soft-drinks'],
            ['name' => 'Fresh Juice', 'slug' => 'fresh-juice'],
            ['name' => 'Energy Drinks', 'slug' => 'energy-drinks'],
            ['name' => 'Bottled Water', 'slug' => 'bottled-water'],
            ['name' => 'Combo Packs', 'slug' => 'combo-packs'],
        ];

        foreach ($categories as $category) {
            \App\Models\Category::create($category);
        }
    }
}
