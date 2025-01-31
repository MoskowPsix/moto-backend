<?php

namespace Database\Seeders;

use App\Models\GoogleSheet;
use App\Models\Race;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $races = Race::factory()->count(10)->create();
        $races->each(function ($r) {
//            GoogleSheet::factory()->create(['race_id' => $r->id]);
        });
    }
}
