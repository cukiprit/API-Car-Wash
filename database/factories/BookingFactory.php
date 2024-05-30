<?php

namespace Database\Factories;

use App\Models\ServiceModel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class BookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'phone' => fake()->phoneNumber(),
            'booking_time' => fake()->time(),
            'booking_data' => fake()->date(),
            'status' => fake()->randomElement(['scheduled', 'completed', 'cancelled']),
            'id_service' => ServiceModel::factory()
        ];
    }
}
