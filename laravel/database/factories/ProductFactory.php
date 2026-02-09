<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->words(3, true);
        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => $this->faker->sentence(),
            'price' => $this->faker->randomFloat(2, 1, 10),
            'size' => $this->faker->randomElement(['250ml', '500ml', '1L']),
            'stock' => $this->faker->numberBetween(0, 100),
            'status' => 'available',
            'category_id' => Category::factory(),
            'image' => null,
            'is_featured' => $this->faker->boolean(20),
        ];
    }
}
