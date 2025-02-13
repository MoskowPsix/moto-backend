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
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address')->nullable(true);
            $table->geography('point',subtype: 'point', srid: 4326)->nullable(true);
            $table->integer('population')->nullable(true);
            $table->string('type');
            $table->integer('postal_code')->nullable(true);
            $table->string('time_zone');
            $table->json('integration_data')->nullable(true);
            $table->foreignId('location_id')->nullable(true)->constrained("tracks")->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};
