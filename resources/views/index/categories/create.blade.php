<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Categories - FinansialKu</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link rel="stylesheet" href="{{ asset('dist/css/style.css') }}">
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet">
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
                  <h1 class="mb-1">Add New Category</h1>
                  <p class="text-muted m-0">Buat kategori baru untuk mengelompokkan transaksi Anda.</p>
              </div>
              <div class="header-actions">
                  <div class="me-3">Halo, <strong>{{ Auth::user()->name }}</strong></div>
              </div>
            </div>
      
            <div class="row">
                <div class="col-md-6"> <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                        <div class="card-body p-4">
                            
                            <form action="{{ route('categories.store') }}" method="POST">
                                @csrf <div class="mb-4">
                                    <label for="name" class="form-label fw-bold text-secondary">Category Name</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fa-solid fa-tag text-muted"></i>
                                        </span>
                                        <input type="text" 
                                               class="form-control border-start-0 ps-0 @error('name') is-invalid @enderror" 
                                               id="name" 
                                               name="name" 
                                               placeholder="Contoh: Makanan, Transportasi, Gaji"
                                               value="{{ old('name') }}" 
                                               autofocus>
                                        
                                        @error('name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-text text-muted small mt-2">
                                        Nama kategori harus unik (tidak boleh sama dengan yang sudah ada).
                                    </div>
                                </div>
      
                                <div class="d-flex gap-2 pt-2">
                                    <button type="submit" class="btn btn-primary rounded-pill px-4">
                                        <i class="fa-solid fa-save me-1"></i> Simpan
                                    </button>
                                    
                                    <a href="{{ route('categories.index') }}" class="btn btn-light rounded-pill px-4 text-secondary">
                                        Batal
                                    </a>
                                </div>
      
                            </form>
                            </div>
                    </div>
                </div>
        </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
