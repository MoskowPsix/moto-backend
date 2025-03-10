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
        Schema::create('attendance_transaction', function (Blueprint $table) {
            $table->id();
            $table->foreignId('attendance_id')->nullable(true)->constrained('attendances')->nullOnUpdate();
            $table->foreignId('transaction_id')->nullable(true)->constrained('transactions')->nullOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance_transaction');
    }
};
