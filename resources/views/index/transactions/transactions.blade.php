@extends('layouts.app')

@section('title', 'Transactions - Finance Tracker')

@section('content')

    <div class="header mb-4">
        <div>
            <h1 class="mb-1">Transactions</h1>
            <p class="text-muted m-0 small">Riwayat semua pemasukan dan pengeluaran Anda.</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('transactions.create') }}" class="btn btn-primary rounded-pill px-4 py-2 shadow-sm">
                <i class="fa-solid fa-plus me-2"></i> Transaksi Baru
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert" style="background-color: #d1fae5; color: #065f46;">
            <i class="fa-solid fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(request('account_id'))
        <div class="alert alert-info border-0 shadow-sm d-flex justify-content-between align-items-center mb-4" style="background-color: #e0f2fe; color: #0369a1;">
            <span><i class="fa-solid fa-filter me-2"></i> Menampilkan transaksi untuk akun terpilih saja.</span>
            <a href="{{ route('transactions.index') }}" class="btn btn-sm btn-light text-primary fw-bold rounded-pill px-3">Reset Filter</a>
        </div>
    @endif

    <div class="card border-0 shadow-sm" style="border-radius: 15px; overflow: hidden;">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3 text-secondary text-uppercase" style="font-size: 11px; font-weight: 700;">Tanggal</th>
                        <th class="py-3 text-secondary text-uppercase" style="font-size: 11px; font-weight: 700;">Deskripsi</th>
                        <th class="py-3 text-secondary text-uppercase" style="font-size: 11px; font-weight: 700;">Kategori</th>
                        <th class="py-3 text-secondary text-uppercase" style="font-size: 11px; font-weight: 700;">Akun Dompet</th> 
                        <th class="py-3 text-secondary text-uppercase text-end pe-4" style="font-size: 11px; font-weight: 700;">Nominal</th>
                        <th class="py-3 text-secondary text-uppercase text-center" style="font-size: 11px; font-weight: 700;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $transaction)
                    <tr>
                        <td class="ps-4 text-muted" style="font-size: 13px;">
                            {{ \Carbon\Carbon::parse($transaction->date)->format('d M Y') }}
                        </td>
                        
                        <td>
                            <div class="fw-bold text-dark">{{ $transaction->transaction_notes ?? '-' }}</div>
                        </td>
                        
                        <td>
                            <span class="badge rounded-pill fw-normal px-3 py-2" style="background-color: #f3f4f6; color: #4b5563; border: 1px solid #e5e7eb;">
                                {{ $transaction->category->name ?? 'Umum' }}
                            </span>
                        </td>
                        
                        <td>
                            <div class="small text-muted">
                                <i class="fa-solid fa-wallet text-primary opacity-50 me-1"></i>
                                {{ $transaction->account->name ?? 'Deleted Account' }}
                            </div>
                        </td>
                        
                        <td class="text-end pe-4">
                            <span class="fw-bold {{ $transaction->type == 'income' ? 'text-success' : 'text-danger' }}">
                                {{ $transaction->type == 'income' ? '+' : '-' }} 
                                Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                            </span>
                        </td>
                        
                        <td class="text-center">
                            <form action="{{ route('transactions.destroy', $transaction->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus transaksi ini? Saldo akun akan dikembalikan.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger border-0 rounded-circle" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;" title="Hapus">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <div class="mb-3 opacity-25">
                                <i class="fa-solid fa-receipt fa-3x"></i>
                            </div>
                            <h5 class="text-muted fw-bold">Belum ada transaksi.</h5>
                            <p class="small text-muted">Silakan tambah transaksi baru.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($transactions->hasPages())
            <div class="card-footer bg-white border-0 py-3 d-flex justify-content-end">
                {{ $transactions->links() }}
            </div>
        @endif
    </div>

@endsection