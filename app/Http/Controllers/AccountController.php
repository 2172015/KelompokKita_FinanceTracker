<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Budget;
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
        // Fitur ini akan menampilkan daftar akun (opsional untuk nanti)
        $accounts = Account::where('user_id', Auth::id())->get();
        return view('dashboard', compact('accounts')); // Sementara redirect ke dashboard
    }

    public function create()
    {
        // Return view form yang akan kita buat
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
            // Validasi lain...
        ]);
    
        // 1. Simpan Akun
        $account = Account::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'balance' => $request->balance,
            // field lain...
        ]);
    
        // 2. OTOMATIS: Buat Budget Default (0 Rupiah dulu, nanti diedit user)
        Budget::create([
            'account_id' => $account->id,
            'name' => 'Budget ' . $account->name,
            'maximum_expense' => 0, // Default 0
            'target_balance' => 0,
            'minimum_balance' => 0,
            'starting_balance' => 0,
            'budgets_notes' => 'Auto-generated budget',
        ]);
    
        return redirect()->route('dashboard')->with('success', 'Akun dan Budget berhasil dibuat!');
    }

    /**
     * Menghapus Akun
     */
    public function destroy($id)
    {
        // 1. Cari Akun
        $account = Account::findOrFail($id);
    
        // 2. Cek Keamanan (Pastikan milik user yang login)
        if ($account->user_id != Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
    
        // 3. Gunakan DB Transaction agar aman
        DB::transaction(function () use ($account) {
            
            // LANGKAH PENTING: Hapus semua transaksi milik akun ini terlebih dahulu
            // Pastikan di Model Account ada relasi public function transactions()
            $account->transactions()->delete();
    
            // Setelah bersih, baru hapus akunnya
            $account->delete();
        });
    
        return back()->with('success', 'Akun dompet dan seluruh riwayat transaksinya berhasil dihapus.');
    }
}