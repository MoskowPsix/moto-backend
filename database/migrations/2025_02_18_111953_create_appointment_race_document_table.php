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
        \App\Models\AppointmentRace::all()->each(function ($apps) {
            $data = json_decode($apps->data, true);
            if (isset($data)) {
                if(isset($data['polisFileLink'])) {
                    $url_arr = explode('/', $data['polisFileLink']);
                    $id = array_pop($url_arr);
                    dump();
                    $apps->documents()->attach($id);
                }
                if(isset($data['licensesFileLink'])) {
                    $url_arr = explode('/', $data['licensesFileLink']);
                    $id = array_pop($url_arr);
                    $apps->documents()->attach($id);
                }
                if(isset($data['notariusFileLink'])) {
                    $url_arr = explode('/', $data['notariusFileLink']);
                    $id = array_pop($url_arr);
                    $apps->documents()->attach($id);
                }
            }
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
