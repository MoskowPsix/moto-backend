<?php

namespace Database\Seeders;

use App\Models\AppointmentRace;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AppointmentRaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AppointmentRace::factory()->count(20)->create();
    }
}
