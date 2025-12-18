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
        $accountsCount = Account::where('user_id', Auth::id())->count();

        return view('index/transactions/transactions', compact('transactions', 'accountsCount'));
    }

    // Halaman Form Create
    public function create(Request $request)
    {
        // 1. Ambil semua akun milik user
        $accounts = Account::where('user_id', Auth::id())->get();

        // 2. VALIDASI: Jika tidak ada akun, tendang ke halaman buat akun
        if ($accounts->isEmpty()) {
            return redirect()
                ->route('accountcreate') // Pastikan nama route ini sesuai (lihat routes/web.php)
                ->with('error', 'Anda harus membuat Dompet/Akun terlebih dahulu sebelum mencatat transaksi.');
        }

        // 3. Lanjut proses normal...
        $categories = Category::where('user_id', Auth::id())->get();
        
        // Ambil account_id dari URL jika ada
        $accountId = $request->query('account_id');
        $selectedAccount = null;

        if ($accountId) {
            $selectedAccount = $accounts->where('id', $accountId)->first();
        }

        return view('index/transactions/transactioncreate', compact('accounts', 'categories', 'selectedAccount'));
    }

    /**
     * Simpan Transaksi Baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'account_id'    => 'required|exists:accounts,id',
            'category_id'   => 'required|exists:categories,id',
            'amount'        => 'required|numeric|min:1',
            'date'          => 'required|date',
            'description'   => 'nullable|string|max:255',
            'type'          => 'required|in:income,expense',
        ]);

        $account = Account::findOrFail($request->account_id);

        if ($account->user_id != Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Cek Saldo Dompet (Hanya jika pengeluaran)
        if ($request->type == 'expense') {
            if ($request->amount > $account->balance) {
                return back()
                    ->withErrors(['amount' => 'Saldo tidak mencukupi! Sisa: ' . number_format($account->balance)])
                    ->withInput();
            }
        }

        DB::transaction(function () use ($request, $account) {
            
            // 1. Simpan Transaksi
            Transaction::create([
                'account_id'  => $request->account_id,
                'category_id' => $request->category_id,
                'amount'      => $request->amount,
                'date'        => $request->date,
                'description' => $request->description,
                'type'        => $request->type,
            ]);

            // 2. Update Saldo AKUN (Dompet)
            if ($request->type == 'income') {
                $account->increment('balance', $request->amount);
            } else {
                $account->decrement('balance', $request->amount);
            }

            // 3. Update Saldo KATEGORI (PENTING!)
            // Kita hanya menambah saldo kategori jika ini adalah PENGELUARAN (Expense)
            // Atau sesuaikan dengan logika bisnis Anda. Biasanya budget kategori = total pengeluaran.
            if ($request->type == 'expense') {
                $category = Category::find($request->category_id);
                if ($category) {
                    $category->increment('categories_balance', $request->amount);
                }
            }
            
        });

        return redirect()->route('dashboard')->with('success', 'Transaksi berhasil disimpan.');
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

    /**
     * Hapus Satu Transaksi
     */
    public function destroy($id)
    {
        $transaction = Transaction::findOrFail($id);

        if ($transaction->account->user_id != Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        DB::transaction(function () use ($transaction) {
            $account = $transaction->account;
            $category = $transaction->category;

            // 1. Rollback Saldo AKUN
            if ($transaction->type == 'income') {
                $account->decrement('balance', $transaction->amount);
            } else {
                $account->increment('balance', $transaction->amount);
            }

            // 2. Rollback Saldo KATEGORI (INI YANG ANDA CARI)
            // Jika transaksi yang dihapus adalah pengeluaran, kurangi total pengeluaran kategori
            if ($transaction->type == 'expense' && $category) {
                $category->decrement('categories_balance', $transaction->amount);
            }

            // 3. Hapus Data
            $transaction->delete();
        });

        return back()->with('success', 'Transaksi dihapus & saldo dikembalikan.');
    }

    /**
     * Hapus Banyak Transaksi Sekaligus
     */
    public function bulkDestroy(Request $request)
    {
        $request->validate([
            'ids' => 'required|string',
        ]);

        $ids = explode(',', $request->ids);

        // Ambil data transaksi yang akan dihapus (untuk loop logic saldo)
        $transactions = Transaction::whereIn('id', $ids)
            ->whereHas('account', function($query) {
                $query->where('user_id', Auth::id());
            })
            ->with(['account', 'category']) // Eager load biar cepat
            ->get();

        if ($transactions->isEmpty()) {
            return back()->with('error', 'Tidak ada data yang dihapus.');
        }

        DB::transaction(function () use ($transactions) {
            foreach ($transactions as $transaction) {
                $account = $transaction->account;
                $category = $transaction->category;

                // 1. Rollback Saldo AKUN
                if ($transaction->type == 'income') {
                    $account->decrement('balance', $transaction->amount);
                } else {
                    $account->increment('balance', $transaction->amount);
                }

                // 2. Rollback Saldo KATEGORI
                if ($transaction->type == 'expense' && $category) {
                    $category->decrement('categories_balance', $transaction->amount);
                }

                // 3. Hapus Item
                $transaction->delete();
            }
        });

        return back()->with('success', count($transactions) . ' transaksi berhasil dihapus.');
    }
}