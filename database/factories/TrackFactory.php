<?php

namespace Database\Factories;

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
            'name'      => fake()->name(),
            'address'   => fake()->address(),
            'point'     => 'POINT('.fake()->numberBetween(50, 90).' '.fake()->numberBetween(50, 90).')', // Berlin, Germany
        ];
    }
}
