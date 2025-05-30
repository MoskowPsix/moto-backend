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
        Schema::table('appointment_races', function (Blueprint $table) {
            $table->foreignId('transaction_id')->nullable(true)->references('id')->on('transactions')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointment_races', function (Blueprint $table) {
            $table->dropColumn('transaction_id');
        });
    }
};
