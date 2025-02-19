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
        Schema::create('appointment_race_document', function (Blueprint $table) {
            $table->id();
            $table->foreignId('document_id')->nullable(true)->constrained('documents')->cascadeOnDelete();
            $table->foreignId('appointment_race_id')->nullable(true)->constrained('appointment_races')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointment_race_document');
    }
};
