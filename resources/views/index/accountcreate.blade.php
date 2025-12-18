@extends('layouts.app')

@section('title', 'Create Account - Finance Tracker')

@section('content')

    <div class="dashboard-header d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1">Tambah Dompet</h2>
            <p class="text-muted m-0">Tambahkan akun bank, e-wallet, atau uang tunai baru.</p>
        </div>
        <div>
            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary rounded-pill shadow-sm px-4">
                <i class="fa-solid fa-arrow-left me-2"></i> Kembali ke Dashboard
            </a>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-5"> 
            
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4 p-md-5">
                    
                    <div class="text-center mb-5">
                        <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-theme-soft text-theme mb-3" style="width: 80px; height: 80px;">
                            <i class="fa-solid fa-wallet fa-2x"></i>
                        </div>
                        <h4 class="fw-bold mb-1 text-dark">Setup Dompet</h4>
                        <p class="text-muted small">Masukkan detail saldo awal Anda.</p>
                    </div>

                    <form action="{{ route('accounts.store') }}" method="POST">
                        @csrf 

                        <div class="mb-4">
                            <label for="name" class="form-label text-uppercase small fw-bold text-muted ps-1">
                                Nama Akun / Dompet
                            </label>
                            
                            <div class="input-group-soft @error('name') border-danger @enderror">
                                <span class="input-group-text">
                                    <i class="fa-solid fa-signature text-muted"></i>
                                </span>
                                <input type="text" 
                                       class="form-control" 
                                       id="name" 
                                       name="name" 
                                       placeholder="Contoh: BCA, Gopay, Tunai"
                                       value="{{ old('name') }}" 
                                       required
                                       autofocus>
                            </div>
                            
                            @error('name')
                                <div class="text-danger small mt-1 ps-1">
                                    <i class="fa-solid fa-circle-exclamation me-1"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="balance" class="form-label text-uppercase small fw-bold text-muted ps-1">
                                Saldo Awal
                            </label>
                            
                            <div class="input-group-soft @error('balance') border-danger @enderror">
                                <span class="input-group-text fw-bold text-muted" style="font-size: 0.9rem;">
                                    Rp
                                </span>
                                <input type="number" 
                                       class="form-control" 
                                       id="balance" 
                                       name="balance" 
                                       placeholder="0" 
                                       min="0"
                                       value="{{ old('balance') }}" 
                                       required>
                            </div>
                            
                            @error('balance')
                                <div class="text-danger small mt-1 ps-1">
                                    <i class="fa-solid fa-circle-exclamation me-1"></i> {{ $message }}
                                </div>
                            @enderror
                            
                            <div class="form-text text-muted small mt-2 ps-1">
                                * Masukkan jumlah uang yang ada di dompet ini sekarang.
                            </div>
                        </div>
      
                        <div class="d-grid gap-2 mt-5">
                            <button type="submit" class="btn btn-primary py-3 fw-bold shadow-sm">
                                <i class="fa-solid fa-check me-2"></i> Simpan Akun
                            </button>
                        </div>
      
                    </form>
                </div>
            </div>

        </div>
    </div>

@endsection