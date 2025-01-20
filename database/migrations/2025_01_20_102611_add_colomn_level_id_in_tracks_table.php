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
        Schema::table('tracks', function (Blueprint $table) {
            $table->foreignId('level_id')->nullable(true)->constrained("levels")->nullOnUpdate();
            $table->text('desc')->nullable(true);
            $table->integer('length')->nullable(true);
            $table->integer('turns')->nullable(true);
            $table->boolean('free')->default(true);
            $table->boolean('is_work')->default(true);
            $table->json('spec')->nullable(true);
            $table->foreignId('user_id')->constrained("users")->nullOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tracks', function (Blueprint $table) {
            $table->dropColumn('level_id');
            $table->dropColumn('desc');
            $table->dropColumn('length');
            $table->dropColumn('turns');
            $table->dropColumn('free');
            $table->dropColumn('is_work');
            $table->dropColumn('spec');
            $table->dropColumn('user_id');
        });
    }
};
