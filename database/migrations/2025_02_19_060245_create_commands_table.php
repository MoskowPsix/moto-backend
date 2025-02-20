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
        Schema::create('commands', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('avatar')->nullable(true);
            $table->string('city');
            $table->foreignId('user_id')->nullable(true)->constrained('users')->nullOnUpdate();
            $table->foreignId('location_id')->nullable(true)->constrained('locations')->nullOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commands');
    }
};
