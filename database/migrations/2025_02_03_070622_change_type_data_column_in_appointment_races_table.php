<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Reverse the migrations.
     */
    public function up(): void
    {
        Schema::table('appointment_races', function (Blueprint $table) {
            // Добавляем временное поле для хранения данных
            $table->json('temp_data')->nullable();
        });

        // Переносим данные из data в temp_data
        DB::table('appointment_races')->update(['temp_data' => DB::raw('data')]);

        // Меняем тип основного поля на longText
        Schema::table('appointment_races', function (Blueprint $table) {
            $table->longText('data')->nullable()->change();
        });
        DB::table('appointment_races')->orderBy('id')->chunk(1000, function ($documents) {
            $documents->each(function ($document) {
                $encryptedData = Crypt::encryptString($document->temp_data);
                DB::table('appointment_races')
                    ->where('id', $document->id)
                    ->update(['data' => $encryptedData]);
            });
        });

        // Удаляем временное поле
        Schema::table('appointment_races', function (Blueprint $table) {
            $table->dropColumn('temp_data');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointment_races', function (Blueprint $table) {
            // Добавляем временное поле для хранения данных
            $table->longText('temp_data')->nullable();
        });

        // Расшифровываем данные и переносим их во временное поле
        DB::table('appointment_races')->orderBy('id')->chunk(1000, function ($documents) {
            $documents->each(function ($document) {
                $decryptedData = Crypt::decryptString($document->data);
                DB::table('appointment_races')
                    ->where('id', $document->id)
                    ->update([
                        'data' => null,
                        'temp_data' => $decryptedData
                    ]);
            });
        });
        // Меняем тип основного поля обратно на json с использованием USING
        DB::statement('ALTER TABLE appointment_races ALTER COLUMN data TYPE json USING data::json');
        // Переносим данные из временного поля обратно в data, преобразуя text в json
        DB::statement('UPDATE appointment_races SET data = temp_data::json');

        // Удаляем временное поле
        Schema::table('appointment_races', function (Blueprint $table) {
            $table->dropColumn('temp_data');
        });
    }
};

//appointment_races
