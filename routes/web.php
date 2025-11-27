<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EventSessionController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\AttendanceController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\SessionController;

Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    Route::resource('events', EventController::class);
    Route::resource('sessions', SessionController::class);
    Route::resource('registrations', RegistrationController::class)->only(['index', 'show', 'destroy']);
    Route::resource('registrations', RegistrationController::class);
    Route::resource('attendances', AttendanceController::class);
    Route::resource('event-sessions', EventSessionController::class);

    Route::get('attendance', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::post('attendance/scan', [AttendanceController::class, 'scan'])->name('attendance.scan');
});

require __DIR__.'/auth.php';