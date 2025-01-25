<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PersonalInfo>
 */
class PersonalInfoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'          => fake()->title(),
            'surname'       => fake()->titleMale(),
            'patronymic'    => fake()->titleFemale(),
            'date_of_birth' => fake()->date(),
            'city'          => fake()->city(),
            'inn'           => fake()->numberBetween(99999999999, 100000000000),
            'snils'         => fake()->numberBetween(9999999999, 10000000000),
            'phone_number'  => fake()->phoneNumber(),
            'start_number'  => fake()->numberBetween(100, 1000),
            'group'         => fake()->jobTitle(),
            'rank_number'   => fake()->numberBetween(99999, 100000),
            'rank'          => fake()->jobTitle(),
            'community'     => fake()->company(),
            'coach'         => fake()->name(),
            'moto_stamp'    => fake()->title(),
            'engine'        => fake()->title(),
            'user_id'       => User::inRandomOrder()->first()->id,
        ];
    }
}
