<?php

namespace Database\Factories;

use App\Models\Location;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Location>
 */
class LocationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
//            'name' => fake()->text(),
//            'address' => fake()->text(),
//            'point' => fake()->randomNumber(),
//            'population' => fake()->randomNumber(),
//            'type' => fake()->text(),
//            'postal_code' => fake()->randomNumber(),
//            'time_zone' => fake()->time(),
//            'integration_data' => fake()->text(),
//            'location_id' => Location::inRandomOrder()->first()->id,
        ];
    }
}
