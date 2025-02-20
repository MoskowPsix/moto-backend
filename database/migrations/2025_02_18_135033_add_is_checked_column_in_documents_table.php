<?php

use App\Models\Document;
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
        Schema::table('documents', function (Blueprint $table) {
            $table->timestamp('is_checked')->nullable(true);
            $table->text('url_view')->nullable();
            $table->string('number')->nullable();
            $table->text('issued_whom')->nullable();
            $table->string('it_works_date')->nullable();
        });
        \App\Models\AppointmentRace::all()->each(function ($apps) {
            $data = json_decode($apps->data, true);
            if (isset($data)) {
                if(isset($data['polisFileLink'])) {
                    dump('polis', $data);
                    $url_arr = explode('/', $data['polisFileLink']);
                    $id = array_pop($url_arr);
                    Document::find($id)->update([
                        'type' => 'polis',
                        'url_view' => $data['polisFileLink'],
                        'number' => $data['polisNumber'] ?? '',
                        'issued_whom' => $data['polisIssuedWhom'] ?? '',
                        'it_works_date' => $data['polisItWorksDate'] ?? '',
                    ]);
                }
                if(isset($data['licensesFileLink'])) {
                    dump('licenses', $data);
                    $url_arr = explode('/', $data['licensesFileLink']);
                    $id = array_pop($url_arr);
                    Document::find($id)->update([
                        'type' => 'licenses',
                        'url_view' => $data['licensesFileLink'],
                        'number' => $data['licensesNumber'] ?? '',
                    ]);
                }
                if(isset($data['notariusFileLink'])) {
                    dump('notarius', $data);
                    $url_arr = explode('/', $data['notariusFileLink']);
                    $id = array_pop($url_arr);
                    Document::find($id)->update([
                        'type' => 'notarius',
                        'url_view' => $data['notariusFileLink'],
                    ]);
                }
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->dropColumn('url_view');
            $table->dropColumn('number');
            $table->dropColumn('issued_whom');
            $table->dropColumn('it_works_date');
            $table->dropColumn('is_checked');
        });
    }
};
