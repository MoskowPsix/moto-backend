<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\GoogleSheetController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login')->name('user.login');
    Route::post('register', 'register')->name('user.register');
    Route::post('logout', 'logout')->middleware('auth:sanctum')->name('user.logout');
});

Route::controller(UserController::class)->group(function () {
    Route::get('users', 'getUserForToken')->middleware('auth:sanctum')->name('user.get_user.for_token');
    Route::get('users/{id}', 'getForId')->name('user.get_for_id');
    Route::post('users/update', 'update')->middleware('auth:sanctum')->name('user.get_user.update');

});

Route::controller(\App\Http\Controllers\Api\VerificationEmail::class)->group(function () {
    Route::post('verification-email/send', 'send')->middleware('auth:sanctum')->name('verification_email.send');
    Route::post('verification-email/verify', 'verify')->middleware('auth:sanctum')->name('verification_email.verify');
});

Route::controller(\App\Http\Controllers\Api\TrackController::class)-> group(function () {
    $role = new \App\Constants\RoleConstant();
    Route::get('tracks', 'get')->name('track.get');
    Route::get('tracks/{id}', 'getForId')->name('track.get_for_id');
    Route::post('tracks', 'create')->middleware(['auth:sanctum', 'role:'. $role::ORGANIZATION .'|'. $role::ADMIN.'|'.$role::ROOT, 'email_verification'])->name('track.create');
//    Route::put('tracks/{track}', 'update')->name('track.update');
//    Route::delete('tracks/{track}', 'delete')->name('track.delete');
});

Route::controller(\App\Http\Controllers\Api\RoleController::class)->group(function () {
    $role = new \App\Constants\RoleConstant();
    Route::get('roles-change', 'getChangeRoles')->name('role.get_change_roles');
    Route::post('roles-change', 'changeRoleForDefaultUser')->middleware(['auth:sanctum', 'email_verification'])->name('role.change_roles_for_default_user');
});

Route::controller(\App\Http\Controllers\Api\RaceController::class)->group(function () {
    $role = new \App\Constants\RoleConstant();
    Route::get('races', 'get')->name('race.get');
    Route::get('races/{id}', 'getForId')->name('race.get_for_id');
    Route::post('races', 'create')->middleware(['auth:sanctum', 'role:'. $role::ORGANIZATION .'|'. $role::ADMIN.'|'.$role::ROOT, 'email_verification'])->name('race.create');
    Route::post('races/{id}/update', 'update')->middleware(['auth:sanctum', 'role:'. $role::ORGANIZATION .'|'. $role::ADMIN.'|'.$role::ROOT, 'email_verification'])->name('race.update');
    Route::get('races/{id}/toggle-is-work', 'toggleIsWork')->middleware(['auth:sanctum', 'role:'. $role::ORGANIZATION .'|'. $role::ADMIN.'|'.$role::ROOT, 'email_verification'])->name('race.update');
});
Route::controller(\App\Http\Controllers\Api\PersonalInfoController::class)->group(function () {
    Route::post('users/cabinet/personal-info', 'create')->middleware('auth:sanctum')->name('personal_info.create');
    Route::patch('users/cabinet/personal-info', 'update')->middleware('auth:sanctum')->name('personal_info.update');

});

Route::controller(\App\Http\Controllers\Api\DocumentController::class)->group(function () {
    Route::post('users/cabinet/documents', 'create')->middleware('auth:sanctum')->name('document.create');
    Route::get('users/cabinet/documents', 'getForUser')->middleware('auth:sanctum')->name('document.get_for_user');
    Route::get('users/cabinet/documents/{id}/files', 'getFile')->middleware('auth:sanctum');
    Route::get('users/cabinet/documents/{id}', 'getForUserById')->middleware('auth:sanctum')->name('document.get_for_user_by_id');
    Route::post('users/cabinet/documents/{id}/update', 'update')->middleware('auth:sanctum')->name('document.update');
    Route::delete('users/cabinet/documents/{id}', 'delete')->middleware('auth:sanctum')->name('document.delete');
});

Route::controller(App\Http\Controllers\Api\AppointmentRaceController::class)->group(function () {
    $role = new \App\Constants\RoleConstant();
    Route::post('races/{id}/toggle-appointment-race', 'toggle')->middleware(['auth:sanctum', 'email_verification', 'role:' . $role::RIDER . '|' . $role::ORGANIZATION .'|'. $role::ADMIN.'|'.$role::ROOT])->name('appointment_race.create');
    Route::get('races/{id}/appointment-race/users', 'getUsersAppointmentRace')->name('appointment_race.get_users_appointment_race');
    Route::get('races/{id}/appointment-race/users-table', 'getUsersAppointmentRaceInTable')->middleware(['auth:sanctum', 'role:' . $role::ADMIN.'|'.$role::ROOT])->name('appointment_race.get_users_table_appointment_race');
});

Route::controller(App\Http\Controllers\Api\LocationController::class)->group(function () {
    Route::get('locations', 'get')->name('location.get');
    Route::get('locations/{id}', 'getForId')->name('location.get_for_id');
});

Route::controller(\App\Http\Controllers\Api\GradeController::class)->group(function () {
    $role = new \App\Constants\RoleConstant();
    Route::get('grades', 'get')->name('grade.get');
    Route::get('grades/{id}', 'getForId')->name('grade.get_for_id');
    Route::post('grades', 'create')->middleware(['auth:sanctum'])->name('grade.create');
    Route::patch('grades/{id}', 'update')->middleware(['auth:sanctum'])->name('grade.update');
});
