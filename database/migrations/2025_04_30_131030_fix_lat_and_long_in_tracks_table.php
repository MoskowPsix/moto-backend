<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        config('database.default') !== 'sqlite' ?
            \App\Models\Track::query()->selectRaw('*, ST_AsGeoJSON(point) as point')->with('level', 'location')->orderBy('id')->chunk(1000, function($tracks) {
                $tracks->each(function($track) {
                    $coords = json_decode($track->point);
                    $track->update([
                        'point' => 'POINT(' . $coords->coordinates[1] . ' ' . $coords->coordinates[0] . ')'
                    ]);
                });
            }): null;
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        config('database.default') !== 'sqlite' ?
            \App\Models\Track::query()->orderBy('id')->chunk(1000, function($tracks) {
                $tracks->each(function($track) {
                    $coords = json_decode($track->point);
                    $track->update([
                        'point' => 'POINT(' . $coords->coordinates[1] . ' ' . $coords->coordinates[0] . ')'
                    ]);
                });
            }): null;
    }
};
