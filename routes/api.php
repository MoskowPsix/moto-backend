<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AuthPhoneController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login')->name('user.login');
    Route::post('register', 'register')->name('user.register');
    Route::post('logout', 'logout')->middleware('auth:sanctum')->name('user.logout');
});

Route::controller(AuthPhoneController::class)->group(function () {
    Route::post('phone/login', 'login')->name('user.phone.login');
    Route::post('phone/register', 'register')->name('user.phone.register');
    Route::post('phone/verify', 'verify')->name('user.phone.verify');
    Route::post('phone/verify/hook', 'hook')->name('user.phone.hook');
    Route::delete('phone/{userId}/delete', 'delete')->middleware('auth:sanctum')->name('user.phone.delete');
});

Route::controller(UserController::class)->group(function () {
    Route::get('users', 'getUserForToken')->middleware('auth:sanctum')->name('user.get_user.for_token');
    Route::get('users/{id}', 'getForId')->name('user.get_for_id');
    Route::post('users/update', 'update')->middleware('auth:sanctum')->name('user.get_user.update');
    Route::get('users-commissions', 'getCommissions')->name('user.get_user_commissions');
    Route::delete('users', 'delete')->middleware(['auth:sanctum'])->name('user.delete');

});

Route::controller(\App\Http\Controllers\Api\RecoveryPassword::class)->group(function () {
    Route::post('recovery-password/send', 'send')->name('recovery_password.send');
    Route::post('recovery-password/recovery', 'recovery')->name('recovery_password.recovery');
});

Route::controller(\App\Http\Controllers\Api\VerificationEmail::class)->group(function () {
    Route::post('verification-email/send', 'send')->middleware('auth:sanctum')->name('verification_email.send');
    Route::post('verification-email/verify', 'verify')->middleware('auth:sanctum')->name('verification_email.verify');
});

Route::controller(\App\Http\Controllers\Api\TrackController::class)-> group(function () {
    $role = new \App\Constants\RoleConstant();
    Route::get('tracks', 'get')->name('track.get');
    Route::get('tracks/{id}', 'getForId')->name('track.get_for_id');
    Route::post('tracks', 'create')
        ->middleware(['auth:sanctum', 'role:'.$role::ROOT.'|'.$role::ORGANIZATION])
        ->name('track.create');
    Route::post('tracks/{id}', 'update')
        ->middleware(['auth:sanctum', 'role:'.$role::ROOT.'|'.$role::ORGANIZATION])
        ->name('track.update');
    Route::delete('tracks/{id}', 'delete')->middleware(['auth:sanctum', 'role:'.$role::ROOT.'|'.$role::ORGANIZATION])->name('track.delete');
});

Route::controller(\App\Http\Controllers\Api\StoreController::class)->group(function () {
    $role = new \App\Constants\RoleConstant();
    Route::post('stores', 'create')
        ->middleware(['auth:sanctum', 'role:'.$role::ROOT. '|' .$role::ORGANIZATION, 'email_verification'])
        ->name('store.create');
});

Route::controller(\App\Http\Controllers\Api\TransactionController::class)->group(function () {
    Route::post('transactions', 'create')->middleware('auth:sanctum')->name('transaction.create');
    Route::post('transactions/result', 'result')->name('transaction.result');
});

Route::controller(\App\Http\Controllers\Api\RoleController::class)->group(function () {
    $role = new \App\Constants\RoleConstant();
    Route::get('roles-change', 'getChangeRoles')->name('role.get_change_roles');
    Route::post('roles-change', 'changeRoleForDefaultUser')
        ->middleware(['auth:sanctum'])
        ->name('role.change_roles_for_default_user');
    Route::post('roles-change/{id}/commission', 'addCommission')
        ->middleware(['auth:sanctum', 'email_verification', 'phone_verification', 'role:'. $role::COMMISSION . '|'.$role::ROOT])
        ->name('role.change_roles_for_default_user');
});

Route::controller(\App\Http\Controllers\Api\RaceController::class)->group(function () {
    $role = new \App\Constants\RoleConstant();
    Route::get('races', 'get')->name('race.get');
    Route::get('races/{id}', 'getForId')->name('race.get_for_id');
    Route::post('races', 'create')
        ->middleware(['auth:sanctum', 'role:'. $role::ORGANIZATION .'|'.$role::ROOT])
        ->name('race.create');
    Route::post('races/{id}/update', 'update')
        ->middleware(['auth:sanctum', 'role:'. $role::ORGANIZATION.'|'.$role::ROOT])
        ->name('race.update');
    Route::get('races/{id}/toggle-is-work', 'toggleIsWork')
        ->middleware(['auth:sanctum', 'role:'. $role::ORGANIZATION.'|'.$role::ROOT])
        ->name('race.update');
    Route::post('races/{id}/commission/add', 'addCommission')
        ->middleware('auth:sanctum')
        ->name('race.commission.add');
    Route::delete('races/{id}', 'delete')
        ->middleware(['auth:sanctum', 'role:'. $role::ORGANIZATION.'|'.$role::ROOT])
        ->name('race.delete');
    Route::post('races/{id}/add-document', 'addDocument')
        ->middleware(['auth:sanctum', 'role:'. $role::COMMISSION.'|'.$role::ROOT])
        ->name('race.add.document');
});

Route::controller(\App\Http\Controllers\Api\RaceResultController::class)->group(function () {
    $role = new \App\Constants\RoleConstant();
    Route::get('race/{id}/results', 'get')
        ->name('race_result.get');
    Route::post('race/{id}/results', 'create')
        ->middleware(['auth:sanctum', 'role:'. $role::COMMISSION.'|'.$role::ROOT.'|'.$role::ADMIN])
        ->name('race_result.create');
});


Route::controller(\App\Http\Controllers\Api\FavoriteUserController::class)->group(function () {
    Route::post('race/{id}/favorite', 'toggleFavoriteRace')->middleware(['auth:sanctum'])->name('race.favorite.create');
});

Route::controller(\App\Http\Controllers\Api\StatusController::class)->group(function() {
    Route::get('statuses', 'get')->name('status.get');
});

Route::controller(\App\Http\Controllers\Api\CupController::class)->group(function () {
    $role = new \App\Constants\RoleConstant();
    Route::get('cups/{id}', 'getForId')->name('cup.get_for_id');
    Route::get('cups/race/{id}', 'getForRaceId')->name('cup.get_for_race_id');
    Route::post('cups', 'create')->middleware('auth:sanctum')->name('cup.create');
    Route::post('cups/{id}', 'update')->middleware('auth:sanctum')->name('cup.update');
});

Route::controller(\App\Http\Controllers\Api\PersonalInfoController::class)->group(function () {
    Route::post('users/cabinet/personal-info', 'create')->middleware('auth:sanctum')->name('personal_info.create');
    Route::patch('users/cabinet/personal-info', 'update')->middleware('auth:sanctum')->name('personal_info.update');

});

Route::controller(\App\Http\Controllers\Api\DocumentController::class)->group(function () {
    $role = new \App\Constants\RoleConstant();
    Route::post('users/cabinet/documents', 'create')->middleware('auth:sanctum')->name('document.create');
    Route::get('users/cabinet/documents', 'getForUser')->middleware('auth:sanctum')->name('document.get_for_user');
    Route::get('users/cabinet/documents/{id}/files', 'getFile')->middleware('auth:sanctum');
    Route::get('users/cabinet/documents/{id}', 'getForUserById')->middleware('auth:sanctum')->name('document.get_for_user_by_id');
    Route::post('users/cabinet/documents/{id}/update', 'update')->middleware('auth:sanctum')->name('document.update');
    Route::delete('users/cabinet/documents/{id}', 'delete')->middleware('auth:sanctum')->name('document.delete');

    Route::post('documents/{id}/commission-checked', 'verifyDocsForCommission')->middleware(['auth:sanctum', 'role:' . $role::ADMIN.'|'.$role::ROOT.'|'.$role::COMMISSION])->name('document.commission.checked');
});

Route::controller(App\Http\Controllers\Api\AppointmentRaceController::class)->group(function () {
    $role = new \App\Constants\RoleConstant();
    Route::post('races/{id}/toggle-appointment-race', 'toggle')
        ->middleware(['auth:sanctum', 'email_or_phone_phone_verification', 'role:' .$role::COUCH . '|' . $role::RIDER . '|' . $role::ORGANIZATION .'|'. $role::ADMIN.'|'.$role::ROOT])
        ->name('appointment_race.create');
    Route::get('races/{id}/appointment-race/users', 'getUsersAppointmentRace')
        ->name('appointment_race.get_users_appointment_race');
    Route::get('races/{id}/appointment-race/users-table', 'getUsersAppointmentRaceInTable')
        ->middleware(['auth:sanctum', 'role:' . $role::COMMISSION .'|' . $role::ORGANIZATION .'|' .$role::ADMIN.'|'.$role::ROOT])
        ->name('appointment_race.get_users_table_appointment_race');
    Route::get('races/appointment-race/{id}/pdf', 'getAppointmentPDF')
        ->middleware(['auth:sanctum', 'role:' . $role::ADMIN.'|'.$role::ROOT])
        ->name('appointment_race.get_pdf_appointment_race');
    Route::get('races/{id}/appointment-race/appointments', 'getAppointmentsUsers')
        ->middleware(['auth:sanctum', 'role:' . '|' . $role::COMMISSION .'|' .$role::ADMIN.'|'.$role::ROOT])
        ->name('appointment_race.get_users_table_appointment_race');

    Route::get('races/{id}/appointment-race/users-table/export', 'exportApplications')
        ->middleware(['auth:sanctum', 'role:' . $role::COMMISSION . '|' . $role::ORGANIZATION .'|' .$role::ADMIN.'|'.$role::ROOT])
        ->name('appointment_race.export');
    Route::get('races/{raceId}/results/export', 'exportResults')
        ->name('results.export');
    Route::post('races/{raceId}/results/import', 'importResults')
        ->name('results.import');

    Route::post('races/appointment-race/{id}/checked', 'checkedForCommission')
        ->middleware(['auth:sanctum', 'role:' . '|' . $role::COMMISSION .'|' .$role::ADMIN.'|'.$role::ROOT])
        ->name('appointment_race.checked');

});

Route::controller(App\Http\Controllers\Api\LocationController::class)->group(function () {
    Route::get('locations', 'get')->name('location.get');
    Route::get('locations/{id}', 'getForId')->name('location.get_for_id');
});

Route::controller(App\Http\Controllers\Api\DistrictController::class)->group(function () {
    Route::get('districts', 'get')->name('district.get');
});

Route::controller(\App\Http\Controllers\Api\GradeController::class)->group(function () {
    $role = new \App\Constants\RoleConstant();
    Route::get('grades', 'get')->name('grade.get');
    Route::get('grades/{id}', 'getForId')->name('grade.get_for_id');
    Route::post('grades', 'create')->middleware(['auth:sanctum', 'role:'. $role::ORGANIZATION .'|'. $role::ADMIN.'|'.$role::ROOT, 'email_verification'])->name('grade.create');
    Route::patch('grades/{id}', 'update')->middleware(['auth:sanctum', 'role:'. $role::ORGANIZATION .'|'.$role::ROOT, 'email_verification'])->name('grade.update');
});

Route::controller(\App\Http\Controllers\Api\CommandController::class)->group(function (){
    $role = new \App\Constants\RoleConstant();
    Route::get('commands', 'get')->name('command.get');
    Route::get('commands/{id}', 'getForId')->name('command.get_for_id');
    Route::post('commands', 'create')->middleware(['auth:sanctum', 'role:'. $role::ORGANIZATION .'|'. $role::RIDER .'|'. $role::COUCH .'|'. $role::ADMIN.'|'.$role::ROOT])->name('command.create');
    Route::post('commands/{id}', 'update')->middleware(['auth:sanctum', 'email_verification', 'role:'. $role::ORGANIZATION .'|'. $role::RIDER .'|' .$role::COUCH .'|'.$role::ROOT])->name('command.update');
    Route::delete('commands/{id}', 'delete')->middleware(['auth:sanctum', 'role:'. $role::COUCH .'|'. $role::ADMIN.'|'.$role::ROOT])->name('command.delete');

//    Route::get('commands/{command_id}/couches', 'getCoaches')->name('command.get.couch'); // Сомнительный метод, не факт что он используется.
    Route::post('commands/{command_id}/couches/{user_id}', 'toggleCouch')
        ->middleware(['auth:sanctum', 'role:'. $role::ORGANIZATION.'|'.$role::ROOT])
        ->name('command.add.couch');
    Route::post('commands/{command_id}/members', 'toggleMember')
        ->middleware(['auth:sanctum', 'role:'. $role::RIDER.'|'.$role::ORGANIZATION.'|'.$role::COUCH.'|'.$role::COMMISSION.'|'.$role::ADMIN.'|'.$role::ROOT])
        ->name('command.add.member');
    Route::get('commands/{command_id}/members', 'getMembers')
        ->name('command.get.member');
    Route::get('commands/{command_id}/coaches', 'getCoachesForAll')
        ->name('command.get.coaches');
    Route::get('commands/{command_id}/members-for-coach', 'getMembersForCoach')
        ->middleware(['auth:sanctum', 'role:'. $role::RIDER.'|'.$role::ORGANIZATION.'|'.$role::COUCH.'|'.$role::COMMISSION.'|'.$role::ADMIN.'|'.$role::ROOT])
        ->name('command.get_for_coach.member');
    Route::get('commands/{coach_id}/coach', 'getCommandsForCoachId')->middleware(['auth:sanctum', 'role:'. $role::COUCH.'|'.$role::ROOT])->name('command.get_for_coach_id');
});

Route::controller(\App\Http\Controllers\Api\AttendanceController::class)->group(function (){
    $role = new \App\Constants\RoleConstant();
    Route::get('attendances/{id}', 'getForId')->name('attendance.get_for_id');
    Route::post('attendances', 'create')->middleware(['auth:sanctum', 'role:'. $role::ORGANIZATION .'|'. $role::ADMIN.'|'.$role::ROOT, 'email_verification'])->name('attendance.create');
    Route::post('attendance/{id}', 'update')->middleware(['auth:sanctum', 'role:'. $role::ORGANIZATION .'|'. $role::ADMIN.'|'.$role::ROOT, 'email_verification'])->name('attendance.update');
    Route::delete('attendance/{id}', 'delete')->middleware(['auth:sanctum', 'role:'. $role::ORGANIZATION .'|'. $role::ADMIN.'|'.$role::ROOT, 'email_verification'])->name('attendance.delete');
});

Route::controller(\App\Http\Controllers\Api\DegreeController::class)->group(function () {
    Route::get('degree', 'get')->name('degree.get');
    Route::get('degree/{id}', 'getForId')->name('degree.get');
});
