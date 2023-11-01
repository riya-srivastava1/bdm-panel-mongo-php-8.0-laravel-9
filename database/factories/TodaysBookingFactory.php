<?php

namespace Database\Factories;
use App\Models\TodaysBooking;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TodaysBooking>
 */
class TodaysBookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

     protected $model = TodaysBooking::class;
    public function definition()
    {
        return [
            'order_id' => $this->faker->randomNumber(),
            'user_name' => $this->faker->name(),
            'gender' => $this->faker->randomElement(['male', 'female']),
            'artist' => $this->faker->name(),
            'location' => $this->faker->address(),
            'services' => $this->faker->sentence(),
            'artist_prize' => $this->faker->randomFloat(2, 10, 1000),
            'c_w_discount' => $this->faker->randomFloat(2, 0, 50),
            'net_amount' => $this->faker->randomFloat(2, 0, 1000),
            'date' => $this->faker->date(),
            'time' => $this->faker->time(),
            'astatus' => $this->faker->randomElement(['active', 'inactive']),
            'status' => $this->faker->randomElement(['pending', 'completed', 'canceled']),
        ];
    }
}
