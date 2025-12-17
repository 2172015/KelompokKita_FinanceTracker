@extends('layouts.app')

@section('title', 'New Transaction - Finance Tracker')

@section('content')

    <div class="header mb-4">
        <div>
            <h1 class="mb-1">New Transaction</h1>
            <p class="text-muted m-0 small">Catat pemasukan atau pengeluaran baru.</p>
        </div>
        <div class="header-actions">
            <div class="me-3">Halo, <strong>{{ Auth::user()->name }}</strong></div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-7"> 
            
            <div class="card border-0 shadow-sm" style="border-radius: 20px;">
                <div class="card-body p-4 p-md-5">
                    
                    <div class="text-center mb-5">
                        <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-primary bg-opacity-10 text-primary mb-3" style="width: 70px; height: 70px;">
                            <i class="fa-solid fa-receipt fa-2x"></i>
                        </div>
                        <h4 class="fw-bold mb-1">Catat Transaksi</h4>
                        <span class="badge bg-light text-secondary border rounded-pill px-3">Entry Data</span>
                    </div>

                    <form action="{{ route('transactions.store') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label class="form-label-custom">TANGGAL TRANSAKSI</label>
                            <div class="input-group-soft">
                                <span class="input-group-text"><i class="fa-regular fa-calendar"></i></span>
                                <input type="date" 
                                       class="form-control" 
                                       name="date" 
                                       value="{{ old('date', date('Y-m-d')) }}">
                            </div>
                            @error('date') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label-custom">JENIS TRANSAKSI</label>
                            <div class="btn-group w-100" role="group">
                                
                                <input type="radio" class="btn-check" name="type" id="income" value="income" {{ old('type') == 'income' ? 'checked' : '' }}>
                                <label class="btn btn-outline-success py-3 fw-bold rounded-start-3 border-2" for="income">
                                    <i class="fa-solid fa-arrow-trend-up me-2"></i> Pemasukan
                                </label>
                            
                                <input type="radio" class="btn-check" name="type" id="expense" value="expense" {{ old('type') == 'expense' ? 'checked' : 'checked' }}>
                                <label class="btn btn-outline-danger py-3 fw-bold rounded-end-3 border-2" for="expense">
                                    <i class="fa-solid fa-arrow-trend-down me-2"></i> Pengeluaran
                                </label>
                            </div>
                            @error('type') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label-custom">NOMINAL (IDR)</label>
                            <div class="input-group-soft">
                                <span class="input-group-text fw-bold">Rp</span>
                                <input type="number" 
                                       class="form-control fw-bold fs-5" 
                                       name="amount" 
                                       placeholder="0" 
                                       value="{{ old('amount') }}" 
                                       min="0"
                                       onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                            </div>
                            @error('amount') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="form-label-custom">KATEGORI</label>
                                <div class="input-group-soft">
                                    <span class="input-group-text"><i class="fa-solid fa-layer-group"></i></span>
                                    <select class="form-control form-select border-0 shadow-none bg-transparent" name="category_id" style="cursor: pointer;">
                                        <option value="" disabled selected>-- Pilih Kategori --</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('category_id') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label-custom">AKUN DOMPET</label>
                                
                                @if(isset($selectedAccount))
                                    <div class="input-group-soft bg-light">
                                        <span class="input-group-text"><i class="fa-solid fa-lock text-muted"></i></span>
                                        <input type="text" class="form-control text-muted" value="{{ $selectedAccount->name }}" readonly>
                                        <input type="hidden" name="account_id" value="{{ $selectedAccount->id }}">
                                    </div>
                                    <div class="form-text text-muted small mt-1">Akun otomatis terpilih.</div>
                                @else
                                    <div class="input-group-soft">
                                        <span class="input-group-text"><i class="fa-solid fa-wallet"></i></span>
                                        <select class="form-control form-select border-0 shadow-none bg-transparent" name="account_id" style="cursor: pointer;">
                                            <option value="" disabled selected>-- Pilih Akun --</option>
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

                        <div class="mb-5">
                            <label class="form-label-custom">CATATAN (OPSIONAL)</label>
                            <div class="input-group-soft align-items-start">
                                <span class="input-group-text pt-3"><i class="fa-regular fa-note-sticky"></i></span>
                                <textarea name="transaction_notes" class="form-control" rows="3" placeholder="Contoh: Makan siang di warteg">{{ old('transaction_notes') }}</textarea>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary rounded-3 py-3 fw-bold shadow-sm">
                                <i class="fa-solid fa-check me-2"></i> Simpan Transaksi
                            </button>
                            <a href="{{ route('transactions.index') }}" class="btn btn-danger rounded-3 py-3 text-muted fw-bold">
                                Batal
                            </a>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>

@endsection