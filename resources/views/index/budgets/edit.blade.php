@extends('layouts.app')

@section('title', 'Edit Budget - ' . $budget->account->name)

@section('content')

    <div class="header mb-4">
        <div>
            <h1 class="mb-1">Edit Budget Plan</h1>
            <p class="text-muted m-0 small">Sesuaikan batasan pengeluaran untuk dompet Anda.</p>
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
                            <i class="fa-solid fa-wallet fa-2x"></i>
                        </div>
                        <h4 class="fw-bold mb-1">{{ $budget->account->name }}</h4>
                        <span class="badge bg-light text-secondary border rounded-pill px-3">Budget Settings</span>
                    </div>

                    <form action="{{ route('budgets.update', $budget->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                    
                        <div class="mb-4">
                            <label class="form-label-custom text-danger">
                                <i class="fa-solid fa-ban me-1"></i> Batas Maksimal (Limit)
                            </label>
                            <div class="input-group-soft">
                                <span class="input-group-text">Rp</span>
                                <input type="number" 
                                       name="maximum_expense" 
                                       class="form-control" 
                                       value="{{ (int) $budget->maximum_expense }}" 
                                       placeholder="0"
                                       step="1"
                                       min="0"
                                       onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                            </div>
                            <div class="form-text text-muted small mt-2 ms-1">
                                Jika pengeluaran melebihi angka ini, bar akan menjadi merah.
                            </div>
                        </div>
                    
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="form-label-custom text-success">
                                    <i class="fa-solid fa-bullseye me-1"></i> Target Saldo
                                </label>
                                <div class="input-group-soft">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" 
                                           name="target_balance" 
                                           class="form-control" 
                                           value="{{ (int) $budget->target_balance }}" 
                                           placeholder="0"
                                           step="1"
                                           min="0"
                                           onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                                </div>
                            </div>
                    
                            <div class="col-md-6 mb-4">
                                <label class="form-label-custom text-warning">
                                    <i class="fa-solid fa-shield-halved me-1"></i> Saldo Minimum
                                </label>
                                <div class="input-group-soft">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" 
                                           name="minimum_balance" 
                                           class="form-control" 
                                           value="{{ (int) $budget->minimum_balance }}" 
                                           placeholder="0"
                                           step="1"
                                           min="0"
                                           onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                                </div>
                            </div>
                        </div>
                    
                        <div class="mb-5">
                            <label class="form-label-custom">Catatan Tambahan</label>
                            <div class="input-group-soft align-items-start">
                                <span class="input-group-text pt-3"><i class="fa-regular fa-note-sticky"></i></span>
                                <textarea name="budgets_notes" class="form-control" rows="3" placeholder="Contoh: Tabungan untuk liburan akhir tahun">{{ $budget->budgets_notes }}</textarea>
                            </div>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary rounded-3 py-3 fw-bold shadow-sm">
                                <i class="fa-solid fa-check me-2"></i> Simpan Perubahan
                            </button>
                            <a href="{{ route('dashboard') }}" class="btn btn-danger rounded-3 py-3 text-muted fw-bold">
                                Batal
                            </a>
                        </div>
                    
                    </form>
                </div>
            </div>

        </div>
    </div>

@endsection