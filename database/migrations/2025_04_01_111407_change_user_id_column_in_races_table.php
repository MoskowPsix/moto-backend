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
        Schema::table('races', function (Blueprint $table) {
            $table->integer('user_id')->nullable(true)->change();

            if (DB::getDriverName() !== 'sqlite') {
                $table->dropForeign('races_user_id_foreign');
            }

            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('races', function (Blueprint $table) {
            //
        });
    }
};
