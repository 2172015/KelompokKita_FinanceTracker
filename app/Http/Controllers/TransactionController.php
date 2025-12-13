<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    // Halaman Index (Menu Sidebar)
    public function index(Request $request)
    {
        // Mulai query dasar (milik user yang login)
        $query = Transaction::with(['category', 'account'])
                    ->whereHas('account', function($q) {
                        $q->where('user_id', Auth::id());
                    });

        // LOGIKA FILTER:
        // Jika ada parameter 'account_id' di URL (hasil klik dari dashboard)
        if ($request->has('account_id') && $request->account_id != null) {
            $query->where('account_id', $request->account_id);
        }

        // Ambil data (terurut tanggal terbaru)
        $transactions = $query->orderBy('date', 'desc')->paginate(10);

        // Kirim juga parameter agar view tahu kita sedang memfilter akun apa (opsional)
        // append() pada pagination berguna agar saat pindah page 2, filternya tidak hilang
        $transactions->appends($request->all());

        return view('index/transactions/transactions', compact('transactions'));
    }

    // Halaman Form Create
    public function create(Request $request)
    {
        // 1. Ambil account_id dari URL (jika ada)
        $accountId = $request->query('account_id');
        $selectedAccount = null;

        // 2. Jika ada ID, cari datanya untuk ditampilkan namanya nanti
        if ($accountId) {
            $selectedAccount = Account::where('user_id', Auth::id())
                                    ->where('id', $accountId)
                                    ->first();
        }

        // 3. Tetap ambil semua akun (untuk berjaga-jaga jika user masuk lewat sidebar)
        $accounts = Account::where('user_id', Auth::id())->get();
        $categories = Category::where('user_id', Auth::id())->get();

        return view('index/transactions/transactioncreate', compact('accounts', 'categories', 'selectedAccount'));
    }

    // Simpan Data (Store)
    public function store(Request $request)
    {
        $request->validate([
            'account_id' => 'required|exists:accounts,id',
            'category_id' => 'required|exists:categories,id',
            'amount' => 'required|numeric|min:1',
            'type' => 'required|in:income,expense',
            'date' => 'required|date',
            'notes' => 'nullable|string|max:255',
        ]);

        DB::transaction(function () use ($request) {
            // 1. Simpan Transaksi
            Transaction::create([
                'account_id' => $request->account_id,
                'category_id' => $request->category_id,
                'amount' => $request->amount,
                'type' => $request->type,
                'date' => $request->date,
                'transaction_notes' => $request->notes,
            ]);

            // 2. Update Saldo Akun
            $account = Account::find($request->account_id);
            if ($request->type == 'income') {
                $account->increment('balance', $request->amount);
            } else {
                $account->decrement('balance', $request->amount);
            }

            // 3. Update Saldo Kategori
            $category = Category::find($request->category_id);
            $category->increment('categories_balance', $request->amount);
        });

        return redirect()->route('dashboard')->with('success', 'Transaksi berhasil disimpan!');
    }

    public function listByAccount($id)
    {
        // ... kode validasi akun & user sebelumnya ...
        $account = Account::findOrFail($id);
        
        if ($account->user_id != Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
    
        $transactions = Transaction::with('category')
            ->where('account_id', $id)
            ->orderBy('date', 'desc')
            ->paginate(10);
    
        // PASTIKAN NAMA FILE VIEW SESUAI
        // Jika file ada di folder: resources/views/index/transactionslist.blade.php
        return view('index/transactions/transactionslist', compact('account', 'transactions'));
    }

    // Hapus Transaksi (Destroy)
    public function destroy($id)
    {
        // 1. Cari Transaksi berdasarkan ID
        $transaction = Transaction::findOrFail($id);

        // 2. Keamanan: Cek apakah transaksi ini milik akun user yang sedang login
        // Kita load relasi account untuk cek user_id
        if ($transaction->account->user_id != Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        DB::transaction(function () use ($transaction) {
            // 3. Ambil Akun dan Kategori terkait
            $account = $transaction->account;
            $category = $transaction->category;

            // 4. LOGIKA PENGEMBALIAN SALDO (Rollback)
            if ($transaction->type == 'income') {
                // Jika dulu Pemasukan (uang masuk), maka saat dihapus uang harus DITARIK KEMBALI (dikurangi)
                $account->decrement('balance', $transaction->amount);
            } else {
                // Jika dulu Pengeluaran (uang keluar), maka saat dihapus uang harus DIKEMBALIKAN (ditambah)
                $account->increment('balance', $transaction->amount);
            }

            // 5. Kembalikan saldo kategori (Opsional, agar data sinkron dengan method store)
            if ($category) {
                $category->decrement('categories_balance', $transaction->amount);
            }

            // 6. Hapus Data Transaksi Permanen
            $transaction->delete();
        });

        // Redirect kembali ke halaman sebelumnya (bisa dari index atau listByAccount)
        return back()->with('success', 'Transaksi berhasil dihapus dan saldo telah dikembalikan.');
    }
}