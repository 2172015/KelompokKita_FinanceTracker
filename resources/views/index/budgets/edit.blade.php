<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Budget - {{ $budget->account->name }}</title>
  
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('dist/css/style.css') }}">
</head>

<body>

<div class="layout-container">

    <div class="sidebar">
        <h2>FINANCE</h2>
    
        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }} normal">
            <i class="fa-solid fa-gauge"></i> Dashboard
        </a>
    
        <a href="{{ route('transactions.index') }}" class="{{ request()->routeIs('transactions*') ? 'active' : '' }} normal">
            <i class="fa-solid fa-wallet"></i> Transactions
        </a>
      
        <a href="{{ route('categories.index') }}" class="{{ request()->routeIs('categories*') ? 'active' : '' }} normal">
          <i class="fa-solid fa-tags"></i> Categories
        </a>
        <a href="#" class="normal"><i class="fa-solid fa-chart-pie"></i> Reports</a>
        <a href="#" class="normal"><i class="fa-solid fa-user"></i> Profile</a>
    
        <div class="logout-wrapper" style="margin-top: auto;">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-danger w-100 text-start">
                    <i class="fa-solid fa-right-from-bracket"></i> Logout
                </button>
            </form>
        </div>
    </div>

    <div class="main-content">
        
        <div class="header mb-4">
            <div>
                <h1 class="mb-1">Edit Budget Plan</h1>
                <p class="text-muted m-0">Sesuaikan batasan pengeluaran untuk dompet Anda.</p>
            </div>
            <div class="header-actions">
                <div class="me-3">Halo, <strong>{{ Auth::user()->name }}</strong></div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6"> <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                    <div class="card-body p-4 p-md-5">
                        
                        <div class="text-center mb-4">
                            <div class="d-inline-block p-3 rounded-circle bg-primary bg-opacity-10 text-primary mb-3">
                                <i class="fa-solid fa-pen-to-square fa-2x"></i>
                            </div>
                            <h4 class="fw-bold">Budget: {{ $budget->account->name }}</h4>
                            <p class="text-muted small">Atur limit agar pengeluaran terkontrol.</p>
                        </div>

                        <form action="{{ route('budgets.update', $budget->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                        
                            <div class="mb-4">
                                <label class="form-label fw-bold text-secondary">
                                    <i class="fa-solid fa-ban text-danger me-1"></i> Batas Maksimal Pengeluaran
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">Rp</span>
                                    <input type="number" name="maximum_expense" class="form-control" value="{{ $budget->maximum_expense }}" placeholder="0">
                                </div>
                                <div class="form-text text-muted small">Target maksimal uang keluar bulan ini.</div>
                            </div>
                        
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label class="form-label fw-bold text-secondary">
                                        <i class="fa-solid fa-bullseye text-success me-1"></i> Target Saldo
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light">Rp</span>
                                        <input type="number" name="target_balance" class="form-control" value="{{ $budget->target_balance }}" placeholder="0">
                                    </div>
                                    <div class="form-text text-muted small">Saldo yang ingin dicapai.</div>
                                </div>
                        
                                <div class="col-md-6 mb-4">
                                    <label class="form-label fw-bold text-secondary">
                                        <i class="fa-solid fa-shield-halved text-warning me-1"></i> Saldo Minimum
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light">Rp</span>
                                        <input type="number" name="minimum_balance" class="form-control" value="{{ $budget->minimum_balance }}" placeholder="0">
                                    </div>
                                    <div class="form-text text-muted small">Batas aman saldo terendah.</div>
                                </div>
                            </div>
                        
                            <div class="mb-4">
                                <label class="form-label fw-bold text-secondary">Catatan</label>
                                <textarea name="budgets_notes" class="form-control" rows="2">{{ $budget->budgets_notes }}</textarea>
                            </div>
                            
                            <div class="d-grid gap-2 d-md-flex mt-4">
                                <a href="{{ route('dashboard') }}" class="btn btn-light rounded-pill px-4 flex-fill">Batal</a>
                                <button type="submit" class="btn btn-primary rounded-pill px-4 flex-fill">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>