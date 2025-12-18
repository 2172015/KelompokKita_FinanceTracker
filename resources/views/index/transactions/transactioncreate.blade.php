@extends('layouts.app')

@section('title', 'Tambah Transaksi - Finance Tracker')

@section('content')

    <div class="dashboard-header d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1">Tambah Transaksi</h2>
            <p class="text-muted m-0 small d-none d-md-block">Catat pemasukan atau pengeluaran baru.</p>
        </div>
        <div>
            <a href="{{ route('transactions.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                <i class="fa-solid fa-arrow-left"></i> <span class="d-none d-md-inline ms-1">Kembali</span>
            </a>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6"> 
            
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4 p-md-5">
                    
                    <div class="text-center mb-4">
                        <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-theme-soft text-theme mb-3" style="width: 56px; height: 56px;">
                            <i class="fa-solid fa-pen-to-square fa-xl"></i>
                        </div>
                        <h5 class="fw-bold text-dark">Formulir Transaksi</h5>
                    </div>

                    <form action="{{ route('transactions.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-bold text-secondary" style="font-size: 0.75rem;">TANGGAL</label>
                            <div class="input-group-soft">
                                <span class="input-group-text"><i class="fa-regular fa-calendar fs-5"></i></span>
                                <input type="date" class="form-control" name="date" value="{{ old('date', date('Y-m-d')) }}">
                            </div>
                            @error('date') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold text-secondary" style="font-size: 0.75rem;">JENIS TRANSAKSI</label>
                            <div class="row g-2">
                                <div class="col-6">
                                    <input type="radio" class="btn-check" name="type" id="income" value="income" {{ old('type') == 'income' ? 'checked' : '' }}>
                                    <label class="btn btn-outline-success w-100 py-2 fw-bold border-2" for="income" style="border-radius: 12px;">
                                        <i class="fa-solid fa-arrow-trend-up me-1"></i> Masuk
                                    </label>
                                </div>
                                <div class="col-6">
                                    <input type="radio" class="btn-check" name="type" id="expense" value="expense" {{ old('type') == 'expense' ? 'checked' : 'checked' }}>
                                    <label class="btn btn-outline-danger w-100 py-2 fw-bold border-2" for="expense" style="border-radius: 12px;">
                                        <i class="fa-solid fa-arrow-trend-down me-1"></i> Keluar
                                    </label>
                                </div>
                            </div>
                            @error('type') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold small text-muted">NOMINAL</label>
                            <div class="input-group-soft @error('amount') border-danger @enderror">
                                <span class="input-group-text">Rp</span>
                                <input type="number" 
                                       name="amount" 
                                       class="form-control" 
                                       placeholder="0" 
                                       value="{{ old('amount') }}">
                            </div>
                        
                            @error('amount')
                                <div class="text-danger small mt-1">
                                    <i class="fa-solid fa-circle-exclamation me-1"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-bold text-secondary" style="font-size: 0.75rem;">KATEGORI</label>
                                <div class="input-group-soft">
                                    <span class="input-group-text"><i class="fa-solid fa-layer-group fs-5"></i></span>
                                    <select class="form-control form-select" name="category_id">
                                        <option value="" disabled selected>-- Pilih --</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('category_id') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label fw-bold text-secondary" style="font-size: 0.75rem;">AKUN DOMPET</label>
                                
                                @if(isset($selectedAccount))
                                    <div class="input-group-soft" style="background-color: #e2e8f0;">
                                        <span class="input-group-text"><i class="fa-solid fa-lock text-muted opacity-50 fs-5"></i></span>
                                        <input type="text" class="form-control text-muted" value="{{ $selectedAccount->name }}" readonly>
                                        <input type="hidden" name="account_id" value="{{ $selectedAccount->id }}">
                                    </div>
                                @else
                                    <div class="input-group-soft">
                                        <span class="input-group-text"><i class="fa-solid fa-wallet fs-5"></i></span>
                                        <select class="form-control form-select" name="account_id">
                                            <option value="" disabled selected>-- Pilih --</option>
                                            @foreach($accounts as $account)
                                                <option value="{{ $account->id }}" {{ old('account_id') == $account->id ? 'selected' : '' }}>
                                                    {{ $account->name }} 
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('account_id') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                @endif
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold text-secondary" style="font-size: 0.75rem;">CATATAN</label>
                            <div class="input-group-soft align-items-start pt-2">
                                <span class="input-group-text pt-2"><i class="fa-regular fa-note-sticky fs-5"></i></span>
                                <textarea name="transaction_notes" class="form-control" rows="2" placeholder="Keterangan..." style="resize: none;">{{ old('transaction_notes') }}</textarea>
                            </div>
                        </div>

                        <div class="d-grid gap-3">
                            <button type="submit" class="btn btn-primary rounded-pill py-3 fw-bold shadow-sm text-white">
                                <i class="fa-solid fa-check me-2"></i> Simpan
                            </button>
                            
                            <a href="{{ route('transactions.index') }}" class="btn btn-danger rounded-pill py-3 fw-bold">
                                Batal
                            </a>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>

@endsection