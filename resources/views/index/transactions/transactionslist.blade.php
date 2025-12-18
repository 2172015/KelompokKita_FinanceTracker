@extends('layouts.app')

@section('title', 'Riwayat ' . $account->name . ' - Finance Tracker')

@section('content')

    <div class="dashboard-header d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
        <div>
            <h2 class="fw-bold text-dark mb-1">Riwayat Transaksi</h2>
            <div class="text-muted m-0 d-flex align-items-center">
                <span class="small me-2">Dompet:</span>
                
                <span class="badge bg-theme-soft text-theme rounded-pill px-3 py-2 fw-bold" style="font-size: 0.8rem;">
                    <i class="fa-solid fa-wallet me-2"></i> {{ $account->name }}
                </span>
            </div>
        </div>
        
        <div class="d-none d-md-block">
            <div class="px-3 py-2 bg-white rounded-pill shadow-sm border d-inline-flex align-items-center">
                <i class="fa-regular fa-user me-2 text-theme"></i> 
                <span style="font-size: 0.9rem;">Halo, <strong>{{ Str::limit(Auth::user()->name, 15) }}</strong></span>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3 bg-white border">
            <i class="fa-solid fa-arrow-left me-1"></i> Kembali
        </a>

        <a href="{{ route('transactions.create', ['account_id' => $account->id]) }}" class="btn btn-primary btn-sm rounded-pill px-3 shadow-sm text-white">
            <i class="fa-solid fa-plus me-1"></i> <span class="d-none d-sm-inline">Transaksi Baru</span><span class="d-inline d-sm-none">Baru</span>
        </a>
    </div>

    <div class="table-wrapper p-0 p-md-4 overflow-hidden">
        
        <div class="p-4 pb-0 d-block d-md-none">
            <h5 class="fw-bold text-dark">Daftar Transaksi</h5>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3 text-secondary text-uppercase small">Tanggal</th>
                        <th class="py-3 text-secondary text-uppercase small">Deskripsi</th>
                        <th class="py-3 text-secondary text-uppercase small d-none d-md-table-cell">Kategori</th>
                        <th class="py-3 text-secondary text-uppercase text-end pe-4 small">Nominal</th>
                        <th class="py-3 text-secondary text-uppercase text-center small" style="width: 60px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $transaction)
                    <tr class="table-row-hover">
                        <td class="ps-4 text-nowrap" style="width: 80px;">
                            <div class="fw-bold text-dark">{{ \Carbon\Carbon::parse($transaction->date)->format('d') }}</div>
                            <div class="small text-muted" style="font-size: 0.75rem;">{{ \Carbon\Carbon::parse($transaction->date)->format('M Y') }}</div>
                        </td>
                        
                        <td style="min-width: 150px;">
                            <div class="fw-semibold text-dark text-truncate" style="max-width: 200px;">{{ $transaction->transaction_notes ?? '-' }}</div>
                            <div class="d-block d-md-none mt-1">
                                <span class="badge bg-light text-secondary border fw-normal" style="font-size: 0.65rem;">
                                    {{ Str::limit($transaction->category->name ?? 'Umum', 15) }}
                                </span>
                            </div>
                        </td>
                        
                        <td class="d-none d-md-table-cell">
                            <span class="badge rounded-pill fw-normal px-3 py-2 bg-light text-dark border">
                                {{ $transaction->category->name ?? 'Umum' }}
                            </span>
                        </td>
                        
                        <td class="text-end pe-4 text-nowrap">
                            <span class="fw-bold {{ $transaction->type == 'income' ? 'text-success' : 'text-danger' }}">
                                {{ $transaction->type == 'income' ? '+' : '-' }} 
                                {{ number_format($transaction->amount, 0, ',', '.') }}
                            </span>
                        </td>
                        
                        <td class="text-center">
                            <form action="{{ route('transactions.destroy', $transaction->id) }}" method="POST" onsubmit="return confirm('Hapus transaksi ini? Saldo akan dikembalikan.');">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-action-circle" title="Hapus Transaksi">
                                    <i class="fa-solid fa-trash fs-6"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            <div class="mb-3 opacity-25">
                                <i class="fa-solid fa-receipt fa-3x"></i>
                            </div>
                            <h6 class="text-muted fw-bold">Belum ada transaksi di dompet ini.</h6>
                            <p class="small text-muted mb-0">Klik tombol "Baru" di atas untuk mulai mencatat.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($transactions->hasPages())
            <div class="p-4 d-flex justify-content-center justify-content-md-end border-top">
                {{ $transactions->links() }}
            </div>
        @endif
    </div>

@endsection