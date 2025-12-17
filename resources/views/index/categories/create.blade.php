@extends('layouts.app')

@section('title', 'Add New Category - Finance Tracker')

@section('content')

    <div class="header mb-4">
        <div>
            <h1 class="mb-1">Add New Category</h1>
            <p class="text-muted m-0 small">Buat kategori baru untuk mengelompokkan transaksi Anda.</p>
        </div>
        <div class="header-actions">
            <div class="me-3">Halo, <strong>{{ Auth::user()->name }}</strong></div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6"> 
            
            <div class="card border-0 shadow-sm" style="border-radius: 20px;">
                <div class="card-body p-4 p-md-5">
                    
                    <div class="text-center mb-5">
                        <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-primary bg-opacity-10 text-primary mb-3" style="width: 70px; height: 70px;">
                            <i class="fa-solid fa-tag fa-2x"></i>
                        </div>
                        <h4 class="fw-bold mb-1">New Category</h4>
                        <span class="badge bg-light text-secondary border rounded-pill px-3">Setup</span>
                    </div>

                    <form action="{{ route('categories.store') }}" method="POST">
                        @csrf 

                        <div class="mb-4">
                            <label for="name" class="form-label-custom">
                                CATEGORY NAME
                            </label>
                            <div class="input-group-soft @error('name') border-danger @enderror">
                                <span class="input-group-text">
                                    <i class="fa-solid fa-tag"></i>
                                </span>
                                <input type="text" 
                                       class="form-control" 
                                       id="name" 
                                       name="name" 
                                       placeholder="Contoh: Makanan, Transportasi"
                                       value="{{ old('name') }}" 
                                       autofocus>
                            </div>
                            
                            @error('name')
                                <div class="text-danger small mt-1">
                                    {{ $message }}
                                </div>
                            @enderror

                            <div class="form-text text-muted small mt-2 ms-1">
                                Nama kategori harus unik (tidak boleh sama dengan yang sudah ada).
                            </div>
                        </div>
      
                        <div class="d-grid gap-2 mt-5">
                            <button type="submit" class="btn btn-primary rounded-3 py-3 fw-bold shadow-sm">
                                <i class="fa-solid fa-check me-2"></i> Simpan Kategori
                            </button>
                            
                            <a href="{{ route('categories.index') }}" class="btn btn-danger rounded-3 py-3 text-muted fw-bold">
                                Batal
                            </a>
                        </div>
      
                    </form>
                </div>
            </div>

        </div>
    </div>

@endsection