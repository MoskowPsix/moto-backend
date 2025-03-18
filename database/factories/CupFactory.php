<?php

namespace Database\Factories;

use App\Models\Location;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cup>
 */
class CupFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'          => fake()->name(),
            'year'          => fake()->year(),
            'stages'        => fake()->numberBetween(1,10),
            'location_id'   => Location::inRandomOrder()->first()->id,
            'user_id'       => User::inRandomOrder()->first()->id,
        ];
    }
}
