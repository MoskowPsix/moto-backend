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
            $table->foreignId('command_id')->nullable()->constrained('commands')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointment_races', function (Blueprint $table) {
            $table->dropColumn('command_id');
        });
    }
};
