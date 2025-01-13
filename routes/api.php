<?php

use App\Http\Controllers\Api\AuthController;
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
