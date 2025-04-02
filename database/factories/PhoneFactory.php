<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Phone>
 */
class PhoneFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'number' => fake()->phoneNumber(),
            'last_num'  => fake()->randomNumber(),
            'user_id'   => User::inRandomOrder()->first()->id,
            'number_verified_at' => fake()->randomNumber(),
        ];
    }
    public function verified()
    {
        return $this->state(function (array $attributes) {
            return [
                'number_verified_at' => now(),
            ];
        });
    }
}
