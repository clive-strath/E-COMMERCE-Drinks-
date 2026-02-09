<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_number' => 'ORD-' . strtoupper(Str::random(10)),
            'user_id' => User::factory(),
            'customer_name' => $this->faker->name(),
            'customer_phone' => $this->faker->phoneNumber(),
            'delivery_address' => $this->faker->address(),
            'city' => $this->faker->city(),
            'total_amount' => $this->faker->randomFloat(2, 20, 500),
            'status' => 'pending',
            'payment_status' => 'pending',
            'payment_method' => 'card',
        ];
    }
}
