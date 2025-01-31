<?php

namespace Database\Factories;

use App\Models\Race;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\GoogleSheet>
 */
class GoogleSheetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'spread_sheet_id'   => fake()->url(),
            'url'               => fake()->url(),
            'race_id'           => Race::inRandomOrder()->first()->id,
        ];
    }
}
