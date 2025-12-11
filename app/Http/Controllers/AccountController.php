<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    public function destroy(Account $account)
    {
        // 1. Cek Kepemilikan (Security)
        // Pastikan user tidak menghapus akun milik orang lain via inspect element
        if ($account->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // 2. Hapus Akun
        // Karena kita set 'ON DELETE CASCADE' di database, 
        // semua transaksi terkait akun ini juga akan otomatis terhapus.
        $account->delete();

        // 3. Kembali ke Dashboard
        return redirect()->route('dashboard')->with('success', 'Akun berhasil dihapus!');
    }
}