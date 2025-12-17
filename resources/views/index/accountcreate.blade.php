<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard - Finance Tracker</title>
  
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  
  <link rel="stylesheet" href="{{ asset('dist/css/style.css') }}">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
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
            <a href="{{ route('reports.index') }}" class="{{ request()->routeIs('categories*') ? 'active' : '' }} normal">
                <i class="fa-solid fa-chart-pie"></i> Reports
            </a>
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
            <div class="header">
                <h1>Create Account</h1>
                <div class="header-actions">
                <div class="me-3">Halo, <strong>{{ Auth::user()->name }}</strong></div>
                    <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="fa-solid fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>

            <div class="container mt-4">
                <div class="card border-0 shadow-sm" style="border-radius: 15px; max-width: 600px;">
                    <div class="card-body p-4">
                        <h4 class="card-title mb-4">Informasi Dompet</h4>
                        
                        <form action="{{ route('accounts.store') }}" method="POST">
                            @csrf <div class="mb-4">
                                <label for="name" class="form-label fw-bold">Nama Akun / Dompet</label>
                                <input type="text" class="form-control form-control-lg" id="name" name="name" placeholder="Contoh: BCA, Tunai, Gopay" required>
                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
        
                            <div class="mb-4">
                                <label for="balance" class="form-label fw-bold">Saldo Awal</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white">Rp</span>
                                    <input type="number" class="form-control form-control-lg" id="balance" name="balance" placeholder="0" min="0" required>
                                </div>
                                <small class="text-muted">Masukkan jumlah uang yang ada di dompet ini sekarang.</small>
                                @error('balance')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
        
                            <div class="d-flex justify-content-end gap-2 mt-5">
                                <a href="{{ route('dashboard') }}" class="btn btn-light px-4">Batal</a>
                                <button type="submit" class="btn btn-primary px-4">Simpan Akun</button>
                            </div>
        
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

  <script>
    function toggleDark() { document.body.classList.toggle('dark'); }
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>