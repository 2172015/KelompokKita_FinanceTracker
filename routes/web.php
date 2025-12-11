<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EventSessionController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\AttendanceController;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('')->middleware(['auth', 'verified'])->group(function () {
    Route::view('/dashboard', 'index.index')->name('dashboard');
    Route::view('/budgets', 'index.budgets')->name('budgets');
    Route::view('/accounts', 'index.accounts')->name('accounts');
    Route::view('/categories', 'index.categories')->name('categories');
    Route::view('/profile-page', 'index.profile')->name('profile.page');
    Route::view('/reports', 'index.reports')->name('reports');
    Route::view('/transactions', 'index.transactions')->name('transactions');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\SessionController;

// Route::prefix('admin')->middleware(['auth'])->group(function () {
//     Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

//     Route::resource('events', EventController::class);
//     Route::resource('sessions', SessionController::class);
//     Route::resource('registrations', RegistrationController::class)->only(['index', 'show', 'destroy']);
//     Route::resource('registrations', RegistrationController::class);
//     Route::resource('attendances', AttendanceController::class);
//     Route::resource('event-sessions', EventSessionController::class);

//     Route::get('attendance', [AttendanceController::class, 'index'])->name('attendance.index');
//     Route::post('attendance/scan', [AttendanceController::class, 'scan'])->name('attendance.scan');
// });

require __DIR__.'/auth.php';