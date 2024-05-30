<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'car_type' => fake()->randomElement(['small/medium', 'large/big/suv', 'premium']),
            'service_type' => fake()->randomElement(['Express Glow', 'Hidrolik Glow', 'Extra Glow']),
            'price' => fake()->randomFloat(2, 25000, 100000),
            'description' => fake()->paragraph()
        ];
    }
}
