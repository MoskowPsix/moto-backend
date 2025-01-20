<?php

namespace Database\Factories;

use App\Models\Level;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Track>
 */
class TrackFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'      => fake()->jobTitle(),
            'address'   => fake()->address(),
            'point'     => 'POINT('.fake()->latitude().' '.fake()->longitude().')',
            'level_id'  => Level::inRandomOrder()->first()->id,
            'user_id'   => User::inRandomOrder()->first()->id,
            'desc'      => fake()->text(500),
            'length'    => fake()->randomNumber(3),
            'turns'     => fake()->randomNumber(2),
            'free'      => fake()->boolean(),
            'is_work'   => fake()->boolean(),
        ];
    }
}
