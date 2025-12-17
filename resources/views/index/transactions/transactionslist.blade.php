@extends('layouts.app')

@section('title', 'Riwayat ' . $account->name . ' - Finance Tracker')

@section('content')

    <div class="header mb-4">
        <div>
            <h1 class="mb-1">Riwayat Transaksi</h1>
            <p class="text-muted m-0 small">
                Detail transaksi untuk dompet <span class="fw-bold text-primary">{{ $account->name }}</span>
            </p>
        </div>
        <div class="header-actions">
            <div class="me-3">Halo, <strong>{{ Auth::user()->name }}</strong></div>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-4">
        
      <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary rounded-pill px-4 py-2 fw-bold border-2">
          <i class="fa-solid fa-arrow-left me-2"></i> Kembali
      </a>

      <a href="{{ route('transactions.create', ['account_id' => $account->id]) }}" class="btn btn-primary rounded-pill px-4 py-2 shadow-sm">
          <i class="fa-solid fa-plus me-2"></i> Transaksi Baru
      </a>
     </div>

    <div class="card border-0 shadow-sm" style="border-radius: 15px; overflow: hidden;">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3 text-secondary text-uppercase" style="font-size: 11px; font-weight: 700;">Tanggal</th>
                        <th class="py-3 text-secondary text-uppercase" style="font-size: 11px; font-weight: 700;">Deskripsi</th>
                        <th class="py-3 text-secondary text-uppercase" style="font-size: 11px; font-weight: 700;">Kategori</th>
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
                        
                        <td class="text-end pe-4">
                            <span class="fw-bold {{ $transaction->type == 'income' ? 'text-success' : 'text-danger' }}">
                                {{ $transaction->type == 'income' ? '+' : '-' }} 
                                Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                            </span>
                        </td>
                        
                        <td class="text-center">
                            <div class="d-flex justify-content-center">
                                <form action="{{ route('transactions.destroy', $transaction->id) }}" method="POST" onsubmit="return confirm('Hapus transaksi ini? Saldo akan dikembalikan.');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-action delete" title="Hapus Transaksi">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            <div class="mb-3 opacity-25">
                                <i class="fa-solid fa-box-open fa-3x"></i>
                            </div>
                            <h5 class="text-muted fw-bold">Belum ada transaksi.</h5>
                            <p class="small text-muted">Mulai catat pengeluaran/pemasukan untuk akun ini.</p>
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