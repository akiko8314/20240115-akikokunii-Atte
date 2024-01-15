<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\StampController;
use App\Http\Controllers\Auth\LoginController;


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





Auth::routes();

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware(['auth'])->group(function () {

    Route::post('/attendance', [AttendanceController::class, 'showAttendancePage'])->name('attendance.index');
    Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::post('/start-work', [AttendanceController::class, 'startWork'])->name('startWork');
    Route::post('/end-work', [AttendanceController::class, 'endWork'])->name('endWork');
    Route::post('/start-break', [AttendanceController::class, 'startBreak'])->name('startBreak');
    Route::post('/end-break', [AttendanceController::class, 'endBreak'])->name('endBreak');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::get('/attendance', [AttendanceController::class, 'showAttendancePage'])->name('attendance');
});


