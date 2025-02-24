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
            $table->foreignId('grade_id')->nullable(true)->constrained('grades')->nullOnDelete();
        });
        \App\Models\AppointmentRace::all()->each(function ($apps) {
            $data = json_decode($apps->data, true);
            if (isset($data)) {
                $apps->surname = $data['surname'] ?? null;
                $apps->name = $data['name'] ?? null;
                $apps->patronymic = $data['patronymic'] ?? null;
                $apps->engine = $data['engine'] ?? null;
                $apps->start_number = $data['startNumber'] ?? null;
                $apps->rank = $data['rank'] ?? null;
                $apps->date_of_birth = $data['dateOfBirth'] ?? null;
                $apps->community = $data['community'] ?? null;
                $apps->moto_stamp = $data['motoStamp'] ?? null;
                $apps->number_and_seria = $data['numberAndSeria'] ?? null;
                $apps->snils = $data['snils'] ?? null; // Будет шифроватся
                $apps->phone_number = $data['phoneNumber'] ?? null;
                $apps->coach = $data['coach'] ?? null;
                $apps->inn = $data['inn'] ?? null; // Будет шифроватся
                $apps->city = $data['city'] ?? null;
                $apps->location_id = isset($data['region']) ? \App\Models\Location::where('name', explode(' ', $data['region'])[0])->first()->id : null;
                $apps->grade_id = \App\Models\Grade::where('name', $data['group'])->first()->id ?? null;
                $apps->save();
            }
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
            $table->dropColumn('start_number');
            $table->dropColumn('rank');
            $table->dropColumn('date_of_birth');
            $table->dropColumn('community');
            $table->dropColumn('moto_stamp');
            $table->dropColumn('number_and_seria');
            $table->dropColumn('snils');
            $table->dropColumn('phone_number');
            $table->dropColumn('coach');
            $table->dropColumn('inn');
            $table->dropColumn('city');
            $table->dropColumn('location_id');
            $table->dropColumn('grade_id');
        });
    }
};
