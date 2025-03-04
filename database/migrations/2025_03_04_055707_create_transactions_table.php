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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->boolean('status')->default(false);
            $table->string('desc');
            $table->integer('count');
            $table->timestamp('date')->nullable(true);
            $table->foreignId('user_id')->nullable(true)->constrained('users')->nullOnUpdate();
            $table->foreignId('attendance_id')->nullable(true)->constrained('attendances')->nullOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
