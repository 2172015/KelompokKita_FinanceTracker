<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ReportController;
use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('index/loginpage');
});

Route::prefix('')->middleware(['auth', 'verified'])->group(function () {
    // 1. DASHBOARD: Kita ubah jadi Route::get agar bisa kirim data $accounts
    Route::get('/dashboard', function () {
        $user = Auth::user();
        $accounts = $user->accounts->load('budget'); 
        
        foreach ($accounts as $account) {
            // 1. HITUNG PENGELUARAN (Untuk Maximum Expense)
            $spent = App\Models\Transaction::where('account_id', $account->id)
                                ->where('type', 'expense')
                                ->sum('amount');
            $account->spent_amount = $spent;
    
            // Persentase Pengeluaran (Expense vs Max Limit)
            if ($account->budget && $account->budget->maximum_expense > 0) {
                $account->expense_pct = ($spent / $account->budget->maximum_expense) * 100;
            } else {
                $account->expense_pct = 0;
            }
    
            // 2. HITUNG PENCAPAIAN TARGET (Current Balance vs Target)
            // Balance otomatis berubah jika ada transaksi income/expense
            if ($account->budget && $account->budget->target_balance > 0) {
                $account->target_pct = ($account->balance / $account->budget->target_balance) * 100;
            } else {
                $account->target_pct = 0;
            }
    
            // 3. CEK SALDO MINIMUM
            // True jika saldo saat ini KURANG DARI batas minimum
            $account->is_low_balance = false;
            if ($account->budget && $account->budget->minimum_balance > 0) {
                if ($account->balance < $account->budget->minimum_balance) {
                    $account->is_low_balance = true;
                }
            }
        }
        
        // ... logic recent transactions (tetap sama) ...
        $recentTransactions = App\Models\Transaction::whereIn('account_id', $accounts->pluck('id'))
                                ->with(['category', 'account'])
                                ->latest('date')
                                ->take(5)
                                ->get();
    
        return view('index.index', compact('accounts', 'recentTransactions'));
    })->middleware(['auth', 'verified'])->name('dashboard');

    // 2. ACCOUNT ROUTES: Untuk menampilkan form dan menyimpan data
    Route::get('/accountcreate', [AccountController::class, 'create'])->name('accountcreate');
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/accounts/{id}/transactions', [TransactionController::class, 'listByAccount'])
    ->name('transactions.list');
    Route::view('/accounts', 'index.accounts')->name('accounts');
    Route::delete('/transactions/bulk-delete', [TransactionController::class, 'bulkDestroy'])->name('transactions.bulkDestroy');
    Route::resource('accounts', AccountController::class);
    Route::resource('budgets', BudgetController::class);
    Route::resource('categories', CategoryController::class);
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