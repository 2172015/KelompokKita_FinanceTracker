<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\AccountController;
use App\Models\Account;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('')->middleware(['auth', 'verified'])->group(function () {
    // 1. DASHBOARD: Kita ubah jadi Route::get agar bisa kirim data $accounts
    Route::get('/dashboard', function () {
        // Ambil data akun user dari database
        $accounts = Account::where('user_id', Auth::id())->get();
        // Kirim ke view
        return view('index/index', compact('accounts')); 
    })->name('dashboard');

    // 2. ACCOUNT ROUTES: Untuk menampilkan form dan menyimpan data
    Route::get('/accountcreate', [AccountController::class, 'create'])->name('accountcreate');
    // Route::post('/accounts', [AccountController::class, 'store'])->name('accounts.store');
    Route::resource('accounts', AccountController::class);

    Route::view('/budgets', 'index.budgets')->name('budgets');
    Route::view('/accounts', 'index.accounts')->name('accounts');
    Route::view('/categories', 'index.categories')->name('categories');
    Route::view('/profile-page', 'index.profile')->name('profile.page');
    Route::view('/reports', 'index.reports')->name('reports');
    Route::view('/transactions', 'index.transactions')->name('transactions');
    Route::resource('transactions', TransactionController::class);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\SessionController;

require __DIR__.'/auth.php';