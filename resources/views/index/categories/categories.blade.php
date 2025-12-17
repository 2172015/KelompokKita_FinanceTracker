@extends('layouts.app')

@section('title', 'Categories - Finance Tracker')

@section('content')

    <div class="header mb-4">
        <div>
            <h1 class="mb-1">Categories List</h1>
            <p class="text-muted m-0 small">Kelola kategori pengeluaran dan pemasukan Anda.</p>
        </div>
        <div class="header-actions">
            <div class="me-3">Halo, <strong>{{ Auth::user()->name }}</strong></div>
        </div>
    </div>

    <div class="d-flex justify-content-end mb-4">
        <a href="{{ route('categories.create') }}" class="btn btn-primary rounded-pill px-4 py-2 shadow-sm">
            <i class="fa-solid fa-plus me-2"></i> Add New Category
        </a>
    </div>

    <div class="card border-0 shadow-sm" style="border-radius: 15px; overflow: hidden;">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3 text-secondary text-uppercase" style="font-size: 11px; font-weight: 700; width: 5%;">No</th>
                        <th class="py-3 text-secondary text-uppercase" style="font-size: 11px; font-weight: 700;">Category Name</th>
                        <th class="py-3 text-secondary text-uppercase text-end pe-5" style="font-size: 11px; font-weight: 700;">Total Balance</th>
                        <th class="py-3 text-secondary text-uppercase text-center" style="font-size: 11px; font-weight: 700; width: 15%;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                    <tr>
                        <td class="ps-4 text-muted fw-bold">{{ $loop->iteration }}</td>
                        
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-primary bg-opacity-10 text-primary me-3" style="width: 35px; height: 35px;">
                                    <i class="fa-solid fa-tag"></i>
                                </div>
                                <span class="fw-bold text-dark">{{ $category->name }}</span>
                            </div>
                        </td>

                        <td class="text-end pe-5">
                            <span class="fw-bold {{ $category->categories_balance < 0 ? 'text-danger' : 'text-dark' }}">
                                Rp {{ number_format($category->categories_balance ?? 0, 0, ',', '.') }}
                            </span>
                        </td>

                        <td class="text-center">
                            <div class="d-flex justify-content-center">
                                
                                @if($category->categories_balance == 0)
                                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kategori {{ $category->name }}?');">
                                        @csrf 
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger border-0 rounded-circle" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;" title="Delete">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                @else
                                    <button type="button" class="btn btn-sm btn-outline-secondary border-0 rounded-circle opacity-50" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; cursor: not-allowed;" disabled title="Tidak bisa dihapus karena saldo belum Rp 0">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                @endif
                                
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-5">
                            <div class="mb-3 text-muted opacity-25">
                                <i class="fa-solid fa-folder-open fa-3x"></i>
                            </div>
                            <h5 class="text-muted fw-bold">Belum ada kategori.</h5>
                            <p class="text-muted small">Silakan tambahkan kategori baru untuk memulai.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection