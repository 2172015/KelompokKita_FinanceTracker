@extends('layouts.app')

@section('title', 'Edit Budget - ' . $budget->account->name)

@section('content')

    <div class="dashboard-header d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1">Edit Budget Plan</h2>
            <p class="text-muted m-0">Sesuaikan batasan pengeluaran untuk dompet Anda.</p>
        </div>
        <div>
            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary rounded-pill shadow-sm px-4">
                <i class="fa-solid fa-arrow-left me-2"></i> Kembali
            </a>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6"> 
            
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4 p-md-5">
                    
                    <div class="text-center mb-5">
                        <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-theme-soft text-theme mb-3" style="width: 80px; height: 80px;">
                            <i class="fa-solid fa-wallet fa-2x"></i>
                        </div>
                        <h4 class="fw-bold mb-1 text-dark">{{ $budget->account->name }}</h4>
                        <span class="badge bg-light text-secondary border rounded-pill px-3">Budget Settings</span>
                    </div>

                    <form action="{{ route('budgets.update', $budget->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                    
                        <div class="mb-4">
                            <label class="form-label text-uppercase small fw-bold text-danger ps-1">
                                <i class="fa-solid fa-ban me-1"></i> Batas Maksimal (Limit)
                            </label>
                            <div class="input-group-soft @error('maximum_expense') border-danger @enderror">
                                <span class="input-group-text text-danger">Rp</span>
                                <input type="number" 
                                       name="maximum_expense" 
                                       class="form-control text-danger fw-bold" 
                                       value="{{ old('maximum_expense', (int)$budget->maximum_expense) }}" 
                                       placeholder="0"
                                       min="0">
                            </div>
                            @error('maximum_expense')
                                <div class="text-danger small mt-1 ps-1">{{ $message }}</div>
                            @enderror
                            <div class="form-text text-muted small mt-2 ps-1">
                                Jika pengeluaran bulan ini melebihi angka ini, status bar akan menjadi merah.
                            </div>
                        </div>
                    
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="form-label text-uppercase small fw-bold text-success ps-1">
                                    <i class="fa-solid fa-bullseye me-1"></i> Target Saldo
                                </label>
                                <div class="input-group-soft @error('target_balance') border-danger @enderror">
                                    <span class="input-group-text text-success">Rp</span>
                                    <input type="number" 
                                           name="target_balance" 
                                           class="form-control" 
                                           value="{{ old('target_balance', (int)$budget->target_balance) }}" 
                                           placeholder="0"
                                           min="0">
                                </div>
                                @error('target_balance')
                                    <div class="text-danger small mt-1 ps-1">{{ $message }}</div>
                                @enderror
                            </div>
                    
                            <div class="col-md-6 mb-4">
                                <label class="form-label text-uppercase small fw-bold text-warning ps-1">
                                    <i class="fa-solid fa-shield-halved me-1"></i> Saldo Minimum
                                </label>
                                <div class="input-group-soft @error('minimum_balance') border-danger @enderror">
                                    <span class="input-group-text text-warning">Rp</span>
                                    <input type="number" 
                                           name="minimum_balance" 
                                           class="form-control" 
                                           value="{{ old('minimum_balance', (int)$budget->minimum_balance) }}" 
                                           placeholder="0"
                                           min="0">
                                </div>
                                @error('minimum_balance')
                                    <div class="text-danger small mt-1 ps-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    
                        <div class="mb-5">
                            <label class="form-label text-uppercase small fw-bold text-muted ps-1">Catatan Tambahan</label>
                            <div class="input-group-soft align-items-start">
                                <span class="input-group-text pt-3"><i class="fa-regular fa-note-sticky text-muted"></i></span>
                                <textarea name="budgets_notes" class="form-control" rows="3" placeholder="Contoh: Tabungan untuk liburan akhir tahun">{{ old('budgets_notes', $budget->budgets_notes) }}</textarea>
                            </div>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary py-3 fw-bold shadow-sm">
                                <i class="fa-solid fa-check me-2"></i> Simpan Perubahan
                            </button>
                            <a href="{{ route('dashboard') }}" class="btn btn-danger py-3 text-white fw-bold">
                                Batal
                            </a>
                        </div>
                    
                    </form>
                </div>
            </div>

        </div>
    </div>

@endsection