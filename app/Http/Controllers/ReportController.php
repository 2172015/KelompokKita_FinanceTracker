<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // 1. SETUP TANGGAL (From - To)
        // Default: Awal bulan ini sampai Akhir bulan ini
        $startDate = $request->input('from_date') 
            ? Carbon::createFromFormat('Y-m', $request->from_date)->startOfMonth() 
            : Carbon::now()->startOfMonth();

        $endDate = $request->input('to_date') 
            ? Carbon::createFromFormat('Y-m', $request->to_date)->endOfMonth() 
            : Carbon::now()->endOfMonth();

        // Validasi: Jangan sampai Start lebih besar dari End
        if ($startDate->gt($endDate)) {
            $endDate = $startDate->copy()->endOfMonth();
        }

        // 2. QUERY DASAR (Filter Range Tanggal & User)
        $query = Transaction::whereHas('account', function($q) {
            $q->where('user_id', Auth::id());
        })->whereBetween('date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')]);

        // 3. RINGKASAN TOTAL
        $totalIncome = (clone $query)->where('type', 'income')->sum('amount');
        $totalExpense = (clone $query)->where('type', 'expense')->sum('amount');
        $netIncome = $totalIncome - $totalExpense;

        // 4. DATA PIE CHART (Pengeluaran per Kategori)
        $expensesByCategory = (clone $query)
            ->where('type', 'expense')
            ->select('category_id', DB::raw('sum(amount) as total'))
            ->groupBy('category_id')
            ->with('category')
            ->get();

        $pieLabels = $expensesByCategory->pluck('category.name');
        $pieData = $expensesByCategory->pluck('total');

        // 5. DATA BAR CHART (ARUS KAS HARIAN)
        $dailyTransactions = (clone $query)
            ->select(
                // KITA UBAH ALIASNYA JADI 'date_label' AGAR TIDAK DI-CAST JADI OBJECT OLEH MODEL
                DB::raw('DATE(date) as date_label'), 
                DB::raw('SUM(CASE WHEN type = "income" THEN amount ELSE 0 END) as income'),
                DB::raw('SUM(CASE WHEN type = "expense" THEN amount ELSE 0 END) as expense')
            )
            ->groupBy('date_label') // Group by alias baru
            ->get();

        $barLabels = [];
        $incomeData = [];
        $expenseData = [];

        $current = $startDate->copy();
        while ($current <= $endDate) {
            $dateString = $current->format('Y-m-d');
            $barLabels[] = $current->format('d M'); 

            // UBAH PENCARIAN MENGGUNAKAN 'date_label'
            $trx = $dailyTransactions->firstWhere('date_label', $dateString);

            // Debugging: Pastikan angka diambil sebagai float/int agar terbaca JS
            $incomeData[] = $trx ? (float) $trx->income : 0;
            $expenseData[] = $trx ? (float) $trx->expense : 0;

            $current->addDay(); 
        }

        // Kirim format Y-m (misal 2025-01) untuk value input di view
        $fromDateVal = $startDate->format('Y-m');
        $toDateVal = $endDate->format('Y-m');

        return view('index.reports', compact(
            'fromDateVal', 'toDateVal',
            'totalIncome', 'totalExpense', 'netIncome',
            'pieLabels', 'pieData',
            'barLabels', 'incomeData', 'expenseData'
        ));
    }
}