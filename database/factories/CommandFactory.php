<?php

namespace Database\Factories;

use App\Models\Location;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Command>
 */
class CommandFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'          =>fake()->name(),
            'city'          =>fake()->city(),
            'full_name'      =>fake()->name(),
            'coach'         => fake()->name(),
            'user_id'       => User::inRandomOrder()->first()->id,
            'location_id'   => Location::inRandomOrder()->first()->id,
        ];
    }
}
