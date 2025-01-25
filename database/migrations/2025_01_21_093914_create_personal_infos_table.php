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
        Schema::create('personal_infos', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('surname');
            $table->string('patronymic');
            $table->date('date_of_birth');
            $table->string('city');
            $table->string('inn');
            $table->string('snils');
            $table->string('phone_number');
            $table->string('start_number');
            $table->string('group');
            $table->string('rank')->nullable(true);
            $table->string('rank_number')->nullable(true);
            $table->string('community')->nullable(true);
            $table->string('coach')->nullable(true);
            $table->string('moto_stamp');
            $table->string('engine');
            $table->foreignId('user_id')->constrained("users")->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personal_infos');
    }
};
