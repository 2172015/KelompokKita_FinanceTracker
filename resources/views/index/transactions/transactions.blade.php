@extends('layouts.app')

@section('title', 'Transactions - Finance Tracker')

@section('content')

    <div class="dashboard-header d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
        <div>
            <h2 class="fw-bold text-dark mb-1">Riwayat Transaksi</h2>
            <p class="text-muted m-0">Daftar lengkap pemasukan dan pengeluaran.</p>
        </div>
        <div class="d-flex gap-2">
            <button type="button" id="btn-bulk-delete" class="btn btn-danger rounded-pill shadow-sm px-4 d-none" onclick="submitBulkDelete()">
                <i class="fa-solid fa-trash-can me-2"></i> Hapus (<span id="selected-count">0</span>)
            </button>
        
            {{-- LOGIKA TOMBOL TRANSAKSI BARU --}}
            @if(isset($accountsCount) && $accountsCount > 0)
                <a href="{{ route('transactions.create') }}" class="btn btn-primary rounded-pill shadow-sm text-white px-4">
                    <i class="fa-solid fa-plus me-2"></i> Transaksi Baru
                </a>
            @else
                <button type="button" class="btn btn-secondary rounded-pill shadow-sm text-white px-4" onclick="alert('Silakan buat Dompet/Akun terlebih dahulu!')">
                    <i class="fa-solid fa-plus me-2"></i> Transaksi Baru
                </button>
            @endif
        </div>
    </div>  

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm mb-4 rounded-3 d-flex align-items-center" role="alert">
            <i class="fa-solid fa-circle-check me-2 fs-5"></i>
            <div>{{ session('success') }}</div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(request('account_id'))
        <div class="alert alert-primary bg-opacity-10 border-primary border-opacity-25 shadow-sm d-flex justify-content-between align-items-center mb-4 rounded-3 p-3">
            <span class="text-primary small fw-semibold"><i class="fa-solid fa-filter me-2"></i> Filter: Akun Terpilih</span>
            <a href="{{ route('transactions.index') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3 bg-white" style="font-size: 0.75rem;">
                Reset
            </a>
        </div>
    @endif

    <div class="table-wrapper p-0 p-md-4 overflow-hidden">
        <div class="p-4 p-md-0 d-flex justify-content-between align-items-center mb-md-3">
            <h3 class="fw-bold text-dark mb-0 fs-5">Daftar Transaksi</h3>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3" style="width: 40px;">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="select-all">
                            </div>
                        </th>
                        <th class="py-3 text-secondary text-uppercase small">Tgl</th>
                        <th class="py-3 text-secondary text-uppercase small">Deskripsi</th>
                        <th class="py-3 text-secondary text-uppercase small d-none d-md-table-cell">Kategori</th>
                        <th class="py-3 text-secondary text-uppercase small d-none d-md-table-cell">Akun</th> 
                        <th class="py-3 text-secondary text-uppercase text-end pe-4 small">Nominal</th>
                        <th class="py-3 text-secondary text-uppercase text-center small" style="width: 50px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $transaction)
                    <tr class="table-row-hover">
                        <td class="ps-4">
                            <div class="form-check">
                                <input class="form-check-input select-item" type="checkbox" value="{{ $transaction->id }}">
                            </div>
                        </td>

                        <td class="text-nowrap" style="width: 70px;">
                            <div class="fw-bold text-dark">{{ \Carbon\Carbon::parse($transaction->date)->format('d') }}</div>
                            <div class="small text-muted" style="font-size: 0.75rem;">{{ \Carbon\Carbon::parse($transaction->date)->format('M y') }}</div>
                        </td>
                        
                        <td style="min-width: 140px;">
                            <div class="fw-semibold text-dark text-truncate" style="max-width: 180px;">{{ $transaction->transaction_notes ?? '-' }}</div>
                            <div class="d-block d-md-none mt-1">
                                <span class="badge bg-light text-secondary border fw-normal" style="font-size: 0.65rem;">
                                    {{ Str::limit($transaction->category->name ?? 'Umum', 10) }}
                                </span>
                            </div>
                        </td>
                        
                        <td class="d-none d-md-table-cell">
                            <span class="badge rounded-pill fw-normal px-3 py-2 bg-light text-dark border">
                                {{ $transaction->category->name ?? 'Umum' }}
                            </span>
                        </td>
                        
                        <td class="d-none d-md-table-cell text-nowrap">
                            <div class="small text-muted d-flex align-items-center">
                                <i class="fa-solid fa-wallet text-primary opacity-50 me-2"></i>
                                {{ $transaction->account->name ?? 'Deleted' }}
                            </div>
                        </td>
                        
                        <td class="text-end pe-4 text-nowrap">
                            <span class="fw-bold {{ $transaction->type == 'income' ? 'text-success' : 'text-danger' }}" style="font-size: 0.9rem;">
                                {{ $transaction->type == 'income' ? '+' : '-' }} 
                                {{ number_format($transaction->amount, 0, ',', '.') }}
                            </span>
                        </td>
                        
                        <td class="text-center">
                            <form action="{{ route('transactions.destroy', $transaction->id) }}" method="POST" onsubmit="return confirm('Hapus transaksi?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-action-circle delete" title="Hapus">
                                    <i class="fa-solid fa-trash" style="font-size: 0.8rem;"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <div class="mb-3 opacity-25">
                                <i class="fa-solid fa-receipt fa-3x"></i>
                            </div>
                            <h6 class="text-muted fw-bold">Belum ada transaksi.</h6>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($transactions->hasPages())
            <div class="p-4 d-flex justify-content-center justify-content-md-end">
                {{ $transactions->links() }}
            </div>
        @endif
    </div>

    <form id="bulk-delete-form" action="{{ route('transactions.bulkDestroy') }}" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
        <input type="hidden" name="ids" id="bulk-ids">
    </form>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const selectAll = document.getElementById('select-all');
        const checkboxes = document.querySelectorAll('.select-item');
        const bulkBtn = document.getElementById('btn-bulk-delete');
        const selectedCountSpan = document.getElementById('selected-count');

        // Fungsi update tampilan tombol
        function toggleBulkButton() {
            const checkedCount = document.querySelectorAll('.select-item:checked').length;
            selectedCountSpan.textContent = checkedCount;

            if (checkedCount > 0) {
                bulkBtn.classList.remove('d-none');
            } else {
                bulkBtn.classList.add('d-none');
            }
        }

        // Event: Select All diklik
        if(selectAll) {
            selectAll.addEventListener('change', function () {
                checkboxes.forEach(chk => {
                    chk.checked = this.checked;
                });
                toggleBulkButton();
            });
        }

        // Event: Checkbox individual diklik
        checkboxes.forEach(chk => {
            chk.addEventListener('change', function () {
                // Jika salah satu tidak dicentang, uncheck 'select all'
                if (!this.checked) {
                    selectAll.checked = false;
                }
                // Jika semua dicentang manual, check 'select all'
                if (document.querySelectorAll('.select-item:checked').length === checkboxes.length) {
                    selectAll.checked = true;
                }
                toggleBulkButton();
            });
        });
    });

    // Fungsi Submit Form
    function submitBulkDelete() {
        if (!confirm('Apakah Anda yakin ingin menghapus transaksi yang dipilih?')) {
            return;
        }

        // Ambil semua ID yang dicentang
        let selectedIds = [];
        document.querySelectorAll('.select-item:checked').forEach(chk => {
            selectedIds.push(chk.value);
        });

        if (selectedIds.length === 0) return;

        // Masukkan ke hidden input dan submit
        document.getElementById('bulk-ids').value = selectedIds.join(',');
        document.getElementById('bulk-delete-form').submit();
    }
</script>
@endpush