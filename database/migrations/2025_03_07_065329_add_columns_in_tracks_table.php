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
            $table->text('logo')->nullable(true);
            $table->boolean('light')->nullable(true);
            $table->boolean('season')->nullable(true);
            $table->text('schema_img')->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tracks', function (Blueprint $table) {
            $table->dropColumn('logo');
            $table->dropColumn('light');
            $table->dropColumn('season');
            $table->dropColumn('schema_img');

        });
    }
};
