<?php

namespace App\Http\Controllers;

use App\Models\Account;
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
        // 1. Validasi Input
        $request->validate([
            'name' => 'required|string|max:100', // Nama wajib diisi
            'balance' => 'required|numeric|min:0', // Saldo wajib angka & tidak boleh minus
        ]);

        // 2. Simpan ke Database
        Account::create([
            'user_id' => Auth::id(), // Ambil ID user yang sedang login
            'name' => $request->name,
            'balance' => $request->balance,
        ]);

        // 3. Redirect kembali ke Dashboard dengan pesan sukses
        return redirect()->route('dashboard')->with('success', 'Akun berhasil dibuat!');
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