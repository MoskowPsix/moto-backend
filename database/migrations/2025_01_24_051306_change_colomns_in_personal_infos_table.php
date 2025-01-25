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
        Schema::table('personal_infos', function (Blueprint $table) {
            $table->string('name')->nullable(true)->change();
            $table->string('surname')->nullable(true)->change();
            $table->string('patronymic')->nullable(true)->change();
            $table->date('date_of_birth')->nullable(true)->change();
            $table->string('city')->nullable(true)->change();
            $table->string('inn')->nullable(true)->change();
            $table->string('snils')->nullable(true)->change();
            $table->string('phone_number')->nullable(true)->change();
            $table->string('start_number')->nullable(true)->change();
            $table->string('group')->nullable(true)->change();
            $table->string('rank')->nullable(true)->nullable(true)->change();
            $table->string('rank_number')->nullable(true)->nullable(true)->change();
            $table->string('community')->nullable(true)->nullable(true)->change();
            $table->string('coach')->nullable(true)->nullable(true)->change();
            $table->string('moto_stamp')->nullable(true)->change();
            $table->string('engine')->nullable(true)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('personal_infos', function (Blueprint $table) {
            //
        });
    }
};
