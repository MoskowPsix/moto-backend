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
        Schema::create('race_cup', function (Blueprint $table) {
            $table->id();
            $table->foreignId('race_id')->nullable(true)->constrained('races')->nullOnDelete();
            $table->foreignId('cup_id')->nullable(true)->constrained('cups')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('race_cup');
    }
};
