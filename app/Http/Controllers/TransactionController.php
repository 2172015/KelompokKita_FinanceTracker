<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; // Penting untuk Database Transaction

class TransactionController extends Controller
{
    /**
     * Menampilkan daftar transaksi (Read)
     */
    public function index()
    {
        // Ambil transaksi milik user yang login, urutkan dari yang terbaru
        // Gunakan 'with' agar query lebih cepat (Eager Loading)
        $transactions = Transaction::with(['category', 'account'])
            ->where('user_id', Auth::id())
            ->latest('date')
            ->paginate(10); // Tampilkan 10 per halaman

        return view('transactions.index', compact('transactions'));
    }

    /**
     * Menampilkan form tambah transaksi (Create - View)
     */
    public function create()
    {
        // Kita butuh data Akun dan Kategori untuk pilihan Dropdown
        $accounts = Account::where('user_id', Auth::id())->get();
        $categories = Category::where('user_id', Auth::id())->get();

        return view('transactions.create', compact('accounts', 'categories'));
    }

    /**
     * Menyimpan transaksi baru ke database (Create - Action)
     */
    public function store(Request $request)
    {
        // 1. Validasi Input
        $validated = $request->validate([
            'account_id' => 'required|exists:accounts,id',
            'category_id' => 'required|exists:categories,id',
            'amount' => 'required|numeric|min:1',
            'type' => 'required|in:income,expense',
            'date' => 'required|date',
            'notes' => 'nullable|string|max:255',
        ]);

        // 2. Mulai Database Transaction
        // Fitur ini menjamin: Jika update saldo gagal, transaksi tidak akan tersimpan. (Aman!)
        DB::transaction(function () use ($validated) {
            
            // A. Simpan Transaksi
            Transaction::create([
                'user_id' => Auth::id(), // Ambil ID user otomatis
                'account_id' => $validated['account_id'],
                'category_id' => $validated['category_id'],
                'amount' => $validated['amount'],
                'type' => $validated['type'],
                'date' => $validated['date'],
                'notes' => $validated['notes'],
            ]);

            // B. Update Saldo Akun Otomatis
            $account = Account::find($validated['account_id']);
            
            if ($validated['type'] === 'income') {
                $account->increment('balance', $validated['amount']); // Tambah Saldo
            } else {
                $account->decrement('balance', $validated['amount']); // Kurang Saldo
            }
            
        });

        // 3. Kembali ke halaman index dengan pesan sukses
        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil disimpan!');
    }

    /**
     * Menghapus transaksi (Delete)
     */
    public function destroy(Transaction $transaction)
    {
        // Pastikan yang menghapus adalah pemilik data (Security Check)
        if ($transaction->user_id !== Auth::id()) {
            abort(403);
        }

        DB::transaction(function () use ($transaction) {
            // A. Kembalikan Saldo Akun (Reverse Balance)
            // Jika hapus Income -> Saldo berkurang
            // Jika hapus Expense -> Saldo bertambah kembali
            $account = Account::find($transaction->account_id);
            
            if ($transaction->type === 'income') {
                $account->decrement('balance', $transaction->amount);
            } else {
                $account->increment('balance', $transaction->amount);
            }

            // B. Hapus Data
            $transaction->delete();
        });

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil dihapus!');
    }
}
