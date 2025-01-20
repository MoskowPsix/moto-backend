<?php

namespace Database\Seeders;

use App\Constants\levelConstant;
use App\Models\Level;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(levelConstant $const): void
    {
        $levels = $const->getConstants();
        foreach ($levels as $level) {
            Level::create($level);
        }
    }
}
