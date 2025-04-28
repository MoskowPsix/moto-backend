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
        Schema::create('race_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable(true)->references('id')->on('users')->nullOnDelete();
            $table->foreignId('race_id')->nullable(false)->references('id')->on('races')->cascadeOnDelete();
            $table->foreignId('cup_id')->nullable(true)->references('id')->on('cups')->nullOnDelete();
            $table->foreignId('command_id')->nullable(true)->references('id')->on('commands')->nullOnDelete();
            $table->foreignId('grade_id')->nullable(true)->references('id')->on('grades')->nullOnDelete();
            $table->integer('scores')->nullable(false);
            $table->integer('place')->nullable(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('race_results');
    }
};
