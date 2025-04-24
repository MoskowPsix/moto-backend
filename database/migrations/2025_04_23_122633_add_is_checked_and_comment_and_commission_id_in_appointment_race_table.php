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
            $table->text('comment')->nullable(true);
            $table->foreignId('commission_id')->nullable(true)->references('id')->on('users')->nullOnDelete();
            $table->timestamp('is_checked')->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointment_races', function (Blueprint $table) {
            $table->dropColumn('comment');
            $table->dropColumn('commission_id');
            $table->dropColumn('is_checked');
        });
    }
};
