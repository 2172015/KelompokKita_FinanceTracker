<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Budget;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AccountController extends Controller
{
    /**
     * Menampilkan Form Tambah Akun
     */
    public function index()
    {
        $accounts = Account::where('user_id', Auth::id())->get();
        return view('dashboard', compact('accounts'));
    }

    public function create()
    {
        return view('index/accountcreate');
    }

    /**
     * Menyimpan Data ke Database
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'balance' => 'required|numeric|min:0',
        ]);
    
        $account = Account::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'balance' => $request->balance,
        ]);
    
        Budget::create([
            'account_id' => $account->id,
            'name' => 'Budget ' . $account->name,
            'maximum_expense' => 0,
            'target_balance' => 0,
            'minimum_balance' => 0,
            'starting_balance' => 0,
            'budgets_notes' => 'Auto-generated budget',
        ]);
    
        return redirect()->route('dashboard')->with('success', 'Akun dan Budget berhasil dibuat!');
    }

    /**
     * Menghapus Akun & Sinkronisasi Saldo Kategori
     */
    public function destroy($id)
    {
        $account = Account::findOrFail($id);
    
        // Cek Keamanan
        if ($account->user_id != Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
    
        DB::transaction(function () use ($account) {
            
            // ============================================================
            // 1. UPDATE SALDO KATEGORI (Logic Baru)
            // ============================================================
            // Sebelum dihapus, kita ambil dulu semua transaksi pengeluaran (expense)
            // dari akun ini agar kita bisa kurangi saldo di kategori terkait.
            $expenses = $account->transactions()
                                ->where('type', 'expense')
                                ->get();

            foreach ($expenses as $expense) {
                // Jika transaksi punya kategori, kurangi saldo kategorinya
                if ($expense->category_id) {
                    Category::where('id', $expense->category_id)
                        ->decrement('categories_balance', $expense->amount);
                }
            }
            // ============================================================

            // 2. Hapus semua transaksi milik akun ini
            $account->transactions()->delete();
    
            // 3. Hapus Budget yang terhubung
            Budget::where('account_id', $account->id)->delete();
    
            // 4. Hapus Akun
            $account->delete();
        });
    
        return back()->with('success', 'Akun berhasil dihapus. Saldo kategori terkait telah disesuaikan.');
    }    
}