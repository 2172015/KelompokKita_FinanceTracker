@extends('layouts.app')

@section('title', 'Dashboard - Finance Tracker')

@section('content')

    <div class="dashboard-header d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
        <div>
            <h2 class="fw-bold text-dark mb-1">Dashboard</h2>
            <p class="text-muted m-0">Ringkasan keuangan Anda hari ini.</p>
        </div>
        <div>
            <div class="px-3 py-2 bg-white rounded-pill shadow-sm border d-inline-flex align-items-center">
                <i class="fa-regular fa-user me-2 text-primary"></i> 
                <span style="font-size: 0.9rem;">Halo, <strong>{{ Str::limit(Auth::user()->name, 15) }}</strong></span>
            </div>
        </div>
    </div>

    @if($accounts->isEmpty())
        
        <div class="row justify-content-center mt-5">
            <div class="col-12 col-md-6 col-lg-5">
                <div class="text-center p-4 p-md-5 bg-white rounded-4 shadow-sm border border-light">
                    <div class="mb-4">
                        <span class="fa-stack fa-3x">
                            <i class="fa-solid fa-circle fa-stack-2x text-light"></i>
                            <i class="fa-solid fa-wallet fa-stack-1x text-secondary"></i>
                        </span>
                    </div>
                    <h3 class="fw-bold text-dark fs-4">Dompet Masih Kosong</h3>
                    <p class="text-muted mb-4 small">Anda belum memiliki akun dompet. Buat akun pertama Anda untuk mulai mencatat keuangan.</p>
                    <a href="{{ route('accountcreate') }}" class="btn btn-primary px-4 py-2 rounded-pill fw-bold shadow-sm text-white">
                        <i class="fa-solid fa-plus me-2"></i> Buat Akun Baru
                    </a>
                </div>
            </div>
        </div>

    @else

        @php
            $totalBalance = $accounts->sum('balance');
        @endphp

        <div class="row mb-4">
            <div class="col-12">
                <div class="card stat-card card-total-balance shadow rounded-4 border-0 text-white" 
                    style="background: linear-gradient(135deg, #4f46e5 0%, #3730a3 100%);">
                    
                    <div class="card-body p-4 p-lg-5 d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between">
                        
                        <div class="mb-3 mb-md-0 w-100">
                            <div class="d-flex align-items-center mb-2">
                                <div class="bg-white bg-opacity-20 rounded-circle p-2 me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                    <i class="fa-solid fa-sack-dollar text-white"></i>
                                </div>
                                <span class="text-white-50 fw-medium text-uppercase small ls-1">Total Kekayaan</span>
                            </div>
                            <h1 class="fw-bold mb-0 display-5 text-break lh-1">
                                Rp {{ number_format($totalBalance, 0, ',', '.') }}
                            </h1>
                        </div>

                        <hr class="d-md-none border-white border-opacity-25 w-100 my-4"> 
                        <div class="vr d-none d-md-block bg-white bg-opacity-25 mx-4" style="min-height: 60px; width: 1px; opacity: 0.3;"></div>

                        <div class="flex-shrink-0">
                            <div class="d-flex gap-4">
                                <div>
                                    <small class="text-white-50 d-block mb-1 text-uppercase" style="font-size: 0.7rem; letter-spacing: 1px;">Dompet Aktif</small>
                                    <div class="d-flex align-items-center">
                                        <i class="fa-solid fa-wallet me-2 opacity-50"></i>
                                        <span class="fw-bold fs-4">{{ $accounts->count() }}</span>
                                    </div>
                                </div>
                                </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-3 mt-5">
            <h4 class="fw-bold text-dark m-0">Dompet & Anggaran</h4>
            <a href="{{ route('accountcreate') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                <i class="fa-solid fa-plus me-1"></i> Tambah Dompet
            </a>
        </div>

        <div class="row g-3 g-xl-4">
            @foreach($accounts as $account)
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card stat-card bg-white h-100 shadow-sm rounded-4 border-0 position-relative overflow-hidden">
                    
                    <div class="d-flex justify-content-between align-items-start p-4 pb-0">
                        <div class="d-flex align-items-center overflow-hidden">
                            <div class="rounded-circle bg-light p-3 me-3 text-primary flex-shrink-0">
                                <i class="fa-solid fa-building-columns fa-lg"></i>
                            </div>
                            <div class="overflow-hidden">
                                <h5 class="fw-bold text-dark mb-0 text-truncate">{{ $account->name }}</h5>
                                <small class="text-muted">Dompet Utama</small>
                            </div>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-action-circle" type="button" data-bs-toggle="dropdown">
                                <i class="fa-solid fa-ellipsis-vertical"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                                @if($account->budget)
                                <li>
                                    <a class="dropdown-item" href="{{ route('budgets.edit', $account->budget->id) }}">
                                        <i class="fa-solid fa-gear me-2 text-muted"></i> Edit Budget
                                    </a>
                                </li>
                                @endif
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('accounts.destroy', $account->id) }}" method="POST" onsubmit="return confirm('Hapus dompet {{ $account->name }}?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="fa-solid fa-trash me-2"></i> Hapus Akun
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="card-body p-4 pt-3">
                        <div class="mb-4">
                            <h3 class="fw-bold text-dark mb-1 text-truncate">
                                Rp {{ number_format($account->balance, 0, ',', '.') }}
                            </h3>
                            @if($account->is_low_balance)
                                <span class="badge bg-danger bg-opacity-10 text-white border border-danger rounded-pill px-3 mt-1">
                                    <i class="fa-solid fa-triangle-exclamation me-1"></i> Saldo Rendah
                                </span>
                            @endif
                        </div>

                        @if($account->budget)
                            <div class="bg-light p-3 rounded-3 mb-3 border border-light">
                                
                                @if($account->budget->maximum_expense > 0)
                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between mb-1">
                                            <span class="small fw-bold text-secondary">Pengeluaran</span>
                                            <span class="small fw-bold {{ $account->expense_pct > 100 ? 'text-danger' : 'text-primary' }}">
                                                {{ number_format($account->expense_pct, 0) }}%
                                            </span>
                                        </div>
                                        <div class="progress progress-slim">
                                            <div class="progress-bar {{ $account->expense_pct > 100 ? 'bg-danger' : 'bg-primary' }}" 
                                                 role="progressbar" 
                                                 style="width: {{ min($account->expense_pct, 100) }}%"></div>
                                        </div>
                                        <div class="d-flex justify-content-between mt-1 text-muted" style="font-size: 10px;">
                                            <span>Pakai: {{ number_format($account->spent_amount/1000, 0) }}k</span>
                                            <span>Max: {{ number_format($account->budget->maximum_expense/1000, 0) }}k</span>
                                        </div>
                                    </div>
                                @endif

                                @if($account->budget->target_balance > 0)
                                    @php
                                        $targetPct = ($account->balance / $account->budget->target_balance) * 100;
                                    @endphp
                                    <div class="{{ $account->budget->maximum_expense > 0 ? 'mt-3 pt-2 border-top border-secondary border-opacity-10' : '' }}">
                                        <div class="d-flex justify-content-between mb-1">
                                            <div class="d-flex align-items-center">
                                                <i class="fa-solid fa-bullseye text-success me-1" style="font-size: 10px;"></i>
                                                <span class="small fw-bold text-secondary">Target Goal</span>
                                            </div>
                                            <span class="small fw-bold text-success">{{ number_format($targetPct, 0) }}%</span>
                                        </div>
                                        <div class="progress progress-slim">
                                            <div class="progress-bar bg-success" role="progressbar" style="width: {{ min($targetPct, 100) }}%"></div>
                                        </div>
                                        <div class="d-flex justify-content-between mt-1 text-muted" style="font-size: 10px;">
                                            <span>Kini: {{ number_format($account->balance/1000, 0) }}k</span>
                                            <span>Target: {{ number_format($account->budget->target_balance/1000, 0) }}k</span>
                                        </div>
                                    </div>
                                @endif
                                
                                @if($account->budget->maximum_expense == 0 && $account->budget->target_balance == 0)
                                    <div class="text-center py-1 text-muted fst-italic small">Belum ada pengaturan budget.</div>
                                @endif
                            </div>
                        @endif

                        <div class="d-grid gap-2">
                            <a href="{{ route('transactions.create', ['account_id' => $account->id]) }}" class="btn btn-primary rounded-pill btn-sm shadow-sm text-white">
                                <i class="fa-solid fa-plus me-1"></i> Transaksi Baru
                            </a>
                            <a href="{{ route('transactions.list', $account->id) }}" class="btn btn-outline-secondary btn-sm rounded-pill border">
                                Lihat Riwayat <i class="fa-solid fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-5 mb-5">
            <div class="d-flex justify-content-between align-items-end mb-3">
                <h4 class="fw-bold text-dark mb-0">Transaksi Terbaru</h4>
                <a href="{{ route('transactions.index') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3 fw-bold">
                    Lihat Semua <i class="fa-solid fa-arrow-right ms-1"></i>
                </a>
            </div>
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4 py-3 text-secondary text-uppercase small">Tanggal</th>
                                <th class="py-3 text-secondary text-uppercase small">Deskripsi</th>
                                <th class="py-3 text-secondary text-uppercase small d-none d-md-table-cell">Kategori</th>
                                <th class="pe-4 py-3 text-end text-secondary text-uppercase small">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentTransactions as $transaction)
                            <tr class="table-row-hover">
                                <td class="ps-4 text-nowrap" style="width: 80px;">
                                    <div class="fw-bold text-dark">{{ \Carbon\Carbon::parse($transaction->date)->format('d') }}</div>
                                    <div class="small text-muted">{{ \Carbon\Carbon::parse($transaction->date)->format('M') }}</div>
                                </td>
                                <td>
                                    <div class="fw-semibold text-dark text-truncate" style="max-width: 150px;">{{ $transaction->description }}</div>
                                    <div class="small text-muted d-flex align-items-center">
                                        <i class="fa-solid fa-wallet me-1 text-primary opacity-50" style="font-size: 10px;"></i> 
                                        <span class="text-truncate" style="max-width: 100px;">{{ $transaction->account->name ?? 'Unknown' }}</span>
                                    </div>
                                </td>
                                <td class="d-none d-md-table-cell">
                                    <span class="badge rounded-pill fw-normal px-3 py-2 bg-light text-dark border">
                                        {{ $transaction->category->name ?? 'Uncategorized' }}
                                    </span>
                                </td>
                                <td class="text-end pe-4">
                                    <span class="fw-bold {{ $transaction->type == 'income' ? 'text-success' : 'text-danger' }}">
                                        {{ $transaction->type == 'income' ? '+' : '-' }} 
                                        Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-4 text-muted small">Belum ada transaksi.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    @endif

@endsection