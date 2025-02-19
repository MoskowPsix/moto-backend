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
        DB::table('personal_infos')->orderBy('id')->chunk(1000, function ($infos) {
             $infos->each(function ($info) {
                 \App\Models\PersonalInfo::find($info->id)->update([
                     'name'              => Crypt::decryptString($info->name),
                     'patronymic'        => Crypt::decryptString($info->patronymic),
                     'phone_number'      => Crypt::decryptString($info->phone_number),
                     'rank_number'       => Crypt::decryptString($info->rank_number),
                 ]);
             });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('personal_infos')->orderBy('id')->chunk(1000, function ($infos) {
            $infos->each(function ($info) {
                \App\Models\PersonalInfo::find($info->id)->update([
                    'name'              => $info->name,
                    'patronymic'        => $info->patronymic,
                    'phone_number'      => $info->phone_number,
                    'rank_number'       => $info->rank_number,
                ]);
            });
        });
    }
};
