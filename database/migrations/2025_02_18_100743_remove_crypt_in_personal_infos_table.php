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
                     'name'              => empty($info->name) ? null : Crypt::decryptString($info->name),
                     'patronymic'        => empty($info->patronymic) ? null : Crypt::decryptString($info->patronymic),
                     'phone_number'      => empty($info->phone_number) ? null : Crypt::decryptString($info->phone_number),
                     'rank_number'       => empty($info->rank_number) ? null : Crypt::decryptString($info->rank_number),
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
