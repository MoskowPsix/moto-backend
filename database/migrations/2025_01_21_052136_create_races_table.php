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
        Schema::create('races', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('desc')->nullable(true);
            $table->boolean('is_work')->default(true);
            $table->dateTime('date_start');
            $table->json('images')->nullable(true);
            $table->foreignId('track_id')->constrained("tracks")->nullOnUpdate();
            $table->foreignId('user_id')->constrained("users")->nullOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('races');
    }
};
