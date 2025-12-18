@extends('layouts.app')

@section('title', 'Categories - Finance Tracker')

@section('content')

    <div class="dashboard-header d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
        <div>
            <h2 class="fw-bold text-dark mb-1">Daftar Kategori</h2>
            <p class="text-muted m-0">Kelola jenis pemasukan dan pengeluaran.</p>
        </div>
        <div>
            <a href="{{ route('categories.create') }}" class="btn btn-primary rounded-pill shadow-sm text-white px-4">
                <i class="fa-solid fa-plus me-2"></i> Kategori Baru
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm mb-4 rounded-3 d-flex align-items-center" role="alert">
            <i class="fa-solid fa-circle-check me-2 fs-5"></i>
            <div>{{ session('success') }}</div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="table-wrapper p-0 p-md-4 overflow-hidden">
        <div class="p-4 p-md-0 d-flex justify-content-between align-items-center mb-md-3">
            <h3 class="fw-bold text-dark mb-0 fs-5">List Kategori</h3>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3 text-secondary text-uppercase small d-none d-md-table-cell" style="width: 5%;">No</th>
                        <th class="ps-4 ps-md-0 py-3 text-secondary text-uppercase small">Nama Kategori</th>
                        <th class="py-3 text-secondary text-uppercase text-end pe-4 small">Total Pengeluaran</th>
                        <th class="py-3 text-secondary text-uppercase text-center small" style="width: 50px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                    <tr class="table-row-hover">
                        <td class="ps-4 text-muted fw-bold d-none d-md-table-cell">{{ $loop->iteration }}</td>
                        
                        <td class="ps-4 ps-md-0">
                            <div class="d-flex align-items-center">
                                <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-theme-soft text-theme me-3" style="width: 35px; height: 35px; flex-shrink: 0;">
                                    <i class="fa-solid fa-tag" style="font-size: 0.9rem;"></i>
                                </div>
                                <div>
                                    <div class="fw-semibold text-dark">{{ $category->name }}</div>
                                </div>
                            </div>
                        </td>

                        <td class="text-end pe-4 text-nowrap">
                            <span class="fw-bold {{ $category->categories_balance < 0 ? 'text-danger' : 'text-dark' }}" style="font-size: 0.9rem;">
                                Rp {{ number_format($category->categories_balance ?? 0, 0, ',', '.') }}
                            </span>
                        </td>

                        <td class="text-center">
                            @if($category->categories_balance == 0)
                                <form action="{{ route('categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kategori {{ $category->name }}?');">
                                    @csrf 
                                    @method('DELETE')
                                    <button type="submit" class="btn-action-circle delete" title="Hapus">
                                        <i class="fa-solid fa-trash" style="font-size: 0.8rem;"></i>
                                    </button>
                                </form>
                            @else
                                <button type="button" class="btn-action-circle opacity-50" style="cursor: not-allowed;" disabled title="Saldo harus Rp 0 untuk menghapus">
                                    <i class="fa-solid fa-trash text-muted" style="font-size: 0.8rem;"></i>
                                </button>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-5 text-muted">
                            <div class="mb-3 opacity-25">
                                <i class="fa-solid fa-folder-open fa-3x"></i>
                            </div>
                            <h6 class="text-muted fw-bold">Belum ada kategori.</h6>
                            <p class="small m-0">Silakan tambahkan kategori baru.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection