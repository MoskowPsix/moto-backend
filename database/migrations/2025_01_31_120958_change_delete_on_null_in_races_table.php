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
        if(config('database.default') !== 'sqlite') {
            Schema::table('races', function (Blueprint $table) {
                $table->dropForeign('races_track_id_foreign');
                $table->foreign('track_id')->references('id')->on('tracks')->nullOnDelete();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if(config('database.default') !== 'sqlite') {

            Schema::table('races', function (Blueprint $table) {
                //
            });
        }
    }
};
