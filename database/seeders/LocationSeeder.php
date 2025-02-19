<?php

namespace Database\Seeders;

use App\Contracts\Actions\Commands\GenerateLocationCsvActionContract;
use App\Models\Location;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(GenerateLocationCsvActionContract $action): void
    {
        $action();
    }
}
