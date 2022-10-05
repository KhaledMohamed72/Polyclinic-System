<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});



Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
/*    Route::get('/logout', [\App\Http\Controllers\UserController::class,'logout'])->name('logout');*/
    Route::get('/dashboard',[\App\Http\Controllers\HomeController::class,'index'])->name('home');
    Route::get('/',[\App\Http\Controllers\HomeController::class,'index']);
    Route::resource('/doctors',\App\Http\Controllers\DoctorController::class);
    Route::get('/doctors/schedule_create/{doctor}',[\App\Http\Controllers\DoctorController::class,'scheduleCreate'])->name('schedule-create');
    Route::post('/doctors/scheduleStore/{doctor}',[\App\Http\Controllers\DoctorController::class,'scheduleStore'])->name('schedule-store');
    Route::resource('/receptionists',\App\Http\Controllers\ReceptionistController::class);
    Route::resource('/patients',\App\Http\Controllers\PatientController::class);
});
