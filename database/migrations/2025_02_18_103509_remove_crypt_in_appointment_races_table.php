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
            $table->string('surname')->nullable();
            $table->string('name')->nullable();
            $table->string('patronymic')->nullable();
            $table->string('engine')->nullable();
            $table->string('start_number')->nullable();
            $table->string('rank')->nullable();
            $table->string('date_of_birth')->nullable();
            $table->string('community')->nullable();
            $table->string('moto_stamp')->nullable();
            $table->text('number_and_seria')->nullable();
            $table->text('snils')->nullable(); // Будет шифроватся
            $table->string('phone_number')->nullable();
            $table->string('coach')->nullable();
            $table->text('inn')->nullable(); // Будет шифроватся
            $table->string('city')->nullable();
            $table->foreignId('location_id')->nullable(true)->constrained('locations')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointment_races', function (Blueprint $table) {
            $table->dropColumn('surname');
            $table->dropColumn('name');
            $table->dropColumn('patronymic');
            $table->dropColumn('engine');
            $table->dropColumn('startNumber');
            $table->dropColumn('licensesNumber');
            $table->dropColumn('rank');
            $table->dropColumn('dateOfBirth');
            $table->dropColumn('community');
            $table->dropColumn('motoStamp');
            $table->dropColumn('itWorksDate');
            $table->dropColumn('numberAndSeria');
            $table->dropColumn('snils');
            $table->dropColumn('phoneNumber');
            $table->dropColumn('polisNumber');
            $table->dropColumn('issuedWhom');
            $table->dropColumn('coach');
            $table->dropColumn('inn');
            $table->dropColumn('city');
            $table->dropColumn('location_id');

        });
    }
};
