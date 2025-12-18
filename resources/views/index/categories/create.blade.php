@extends('layouts.app')

@section('title', 'Add New Category - Finance Tracker')

@section('content')

    <div class="dashboard-header d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1">Tambah Kategori</h2>
            <p class="text-muted m-0">Buat kategori baru untuk mengelompokkan transaksi.</p>
        </div>
        <div>
            <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary rounded-pill shadow-sm px-4">
                <i class="fa-solid fa-arrow-left me-2"></i> Kembali
            </a>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-5"> 
            
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4 p-md-5">
                    
                    <div class="text-center mb-5">
                        <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-theme-soft text-theme mb-3" style="width: 80px; height: 80px;">
                            <i class="fa-solid fa-tag fa-2x"></i>
                        </div>
                        <h4 class="fw-bold mb-1 text-dark">Category Setup</h4>
                        <p class="text-muted small">Isi detail kategori di bawah ini.</p>
                    </div>

                    <form action="{{ route('categories.store') }}" method="POST">
                        @csrf 

                        <div class="mb-4">
                            <label for="name" class="form-label text-uppercase small fw-bold text-muted ps-1">
                                Nama Kategori
                            </label>
                            
                            <div class="input-group-soft @error('name') border-danger @enderror">
                                <span class="input-group-text">
                                    <i class="fa-solid fa-font text-muted"></i>
                                </span>
                                <input type="text" 
                                       class="form-control" 
                                       id="name" 
                                       name="name" 
                                       placeholder="Contoh: Makanan, Gaji, Transportasi"
                                       value="{{ old('name') }}" 
                                       autocomplete="off"
                                       autofocus>
                            </div>
                            
                            @error('name')
                                <div class="text-danger small mt-1 ps-1">
                                    <i class="fa-solid fa-circle-exclamation me-1"></i> {{ $message }}
                                </div>
                            @enderror

                            <div class="form-text text-muted small mt-2 ps-1">
                                * Pastikan nama kategori belum pernah dibuat sebelumnya.
                            </div>
                        </div>
      
                        <div class="d-grid gap-2 mt-5">
                            <button type="submit" class="btn btn-primary py-3 fw-bold shadow-sm">
                                <i class="fa-solid fa-check me-2"></i> Simpan Kategori
                            </button>
                        </div>
      
                    </form>
                </div>
            </div>

        </div>
    </div>

@endsection