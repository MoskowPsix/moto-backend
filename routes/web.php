<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/pdf', function () {
    return view('template_doc.appr_temp_pdf', [
        'grade'                 => 'grade',
        'engine'                => 'engine',
        'start_number'          => 'start_number',
        'race_name'             => 'race_name',
        'race_address'          => 'race_address',
        'race_date'             => 'race_date',
        'surname'               => 'surname',
        'name'                  => 'name',
        'patronymic'            => 'patronymic',
        'licenses_number'       => 'licenses_number',
        'rank'                  => 'rank',
        'rank_number'           => 'rank_number',
        'birth_date'            => 'birth_date',
        'location'              => 'location',
        'command'               => 'command',
        'registr_number'        => 'registr_number',
        'mark'                  => 'mark',
        'couch'                 => 'couch',
        'polis_number'          => 'polis_number',
        'polis_date'            => 'polis_date',
        'polis_is_who'          => 'polis_is_who',
        'number_and_serial'     => 'number_and_serial',
        'inn'                   => 'inn',
        'snils'                 => 'snils',
        'home_address'          => 'home_address',
        'email'                 => 'email',
        'number'                => 'number'
    ]);
});
