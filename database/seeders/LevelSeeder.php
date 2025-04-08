<?php

namespace Database\Seeders;

use App\Constants\levelConstant;
use App\Models\Level;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class LevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(levelConstant $const): void
    {
        if (!Schema::hasTable('levels')) {
            throw new \Exception('Table levels does not exist');
        }

        $levels = $const->getConstants();
        foreach ($levels as $level) {
            Level::create($level);
        }
    }
}
