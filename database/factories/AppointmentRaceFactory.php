<?php

namespace Database\Factories;

use App\Models\Grade;
use App\Models\Location;
use App\Models\Race;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AppointmentRace>
 */
class AppointmentRaceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'race_id'   => Race::inRandomOrder()->first()->id,
            'user_id'   => User::inRandomOrder()->first()->id,
            'data'      => json_encode([
                "name"                  => fake()->firstName(),
                "surname"               => fake()->firstName(),
                "patronymic"            => fake()->firstName(),
                "dateOfBirth"           => fake()->date('Y-m-d'),
                "city"                  => fake()->city(),
                "inn"                   => fake()->numberBetween(9999, 10000),
                "snils"                 => fake()->numberBetween(9999, 10000),
                "phoneNumber"           => fake()->numberBetween(999999999, 1000000000),
                "startNumber"           => fake()->numberBetween(1, 999),
                "group"                 => "B-" . fake()->numberBetween(1, 20),
                "rank"                  => fake()->text(5),
                "rankNumber"            => fake()->numberBetween(9999, 10000),
                "community"             => fake()->text(30),
                "coach"                 => fake()->name(),
                "motoStamp"             => fake()->domainName(),
                "engine"                => "T" . fake()->numberBetween(1, 20),
                "numberAndSeria"        => fake()->numberBetween(9999, 10000),
                "polisNumber"           => fake()->numberBetween(9999, 10000),
                "issuedWhom"            => fake()->numberBetween(9999, 10000),
                "itWorksDate"           => fake()->date('Y-m-d'),
                "licensesNumber"        => fake()->numberBetween(9999, 10000),
                "licensesFileLink"      => fake()->url(),
                "polisFileLink"         => fake()->url(),
                "notariuFileLink"       => fake()->url(),
            ], true),
            'surname'           => fake()->firstName(),
            'name'              => fake()->firstName(),
            'patronymic'        => fake()->firstName(),
            'engine'            => "T" . fake()->numberBetween(1, 20),
            'start_number'      => fake()->numberBetween(1, 999),
            'rank'              => fake()->text(5),
            'date_of_birth'     => fake()->date('Y-m-d'),
            'community'         => fake()->text(30),
            'moto_stamp'        => fake()->domainName(),
            'number_and_seria'  => fake()->numberBetween(9999, 10000),
            'snils'             => fake()->numberBetween(9999, 10000),
            'phone_number'      => fake()->numberBetween(999999999, 1000000000),
            'coach'             => fake()->name(),
            'inn'               => fake()->numberBetween(9999, 10000),
            'city'              => fake()->city(),
            'location_id'       => Location::inRandomOrder()->first()->id,
            'grade_id'          => Grade::inRandomOrder()->first()->id,
        ];
    }
}
