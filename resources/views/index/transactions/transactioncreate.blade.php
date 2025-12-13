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
        <div class="header">
            <h1>New Transaction</h1>
            <div class="header-actions">
            <div class="me-3">Halo, <strong>{{ Auth::user()->name }}</strong></div>
            <button class="toggle btn btn-sm btn-outline-secondary me-2" onclick="toggleDark()"><i class="fa-solid fa-moon"></i></button>
            <a href="{{ route('transactions.index') }}" class="btn btn-secondary">
                <i class="fa-solid fa-arrow-left"></i> Kembali
            </a>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body p-5">
                        
                        <form action="{{ route('transactions.store') }}" method="POST">
                            @csrf

                            <div class="mb-4">
                                <label for="date" class="form-label">Tanggal Transaksi</label>
                                <input type="date" class="form-control @error('date') is-invalid @enderror" id="date" name="date" value="{{ old('date', date('Y-m-d')) }}">
                                @error('date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="form-label d-block">Jenis Transaksi</label>
                                <div class="btn-group w-100" role="group">
                                    
                                    <input type="radio" class="btn-check" name="type" id="income" value="income" {{ old('type') == 'income' ? 'checked' : '' }}>
                                    <label class="btn btn-outline-success py-2" for="income">
                                        <i class="fa-solid fa-arrow-up"></i> Pemasukan
                                    </label>
                                
                                    <input type="radio" class="btn-check" name="type" id="expense" value="expense" {{ old('type') == 'expense' ? 'checked' : 'checked' }}>
                                    <label class="btn btn-outline-danger py-2" for="expense">
                                        <i class="fa-solid fa-arrow-down"></i> Pengeluaran
                                    </label>
                                </div>
                                @error('type') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-4">
                                <label for="amount" class="form-label">Nominal (Rp)</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control @error('amount') is-invalid @enderror" id="amount" name="amount" placeholder="0" value="{{ old('amount') }}" min="0">
                                </div>
                                @error('amount')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label for="category_id" class="form-label">Kategori</label>
                                    <select class="form-select @error('category_id') is-invalid @enderror" name="category_id" id="category_id">
                                        <option value="" disabled selected>-- Pilih Kategori --</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label for="account_id" class="form-label">Akun / Dompet</label>
                                
                                    @if(isset($selectedAccount))
                                        <input type="text" class="form-control bg-light" value="{{ $selectedAccount->name }}" readonly>
                                        
                                        <input type="hidden" name="account_id" value="{{ $selectedAccount->id }}">
                                        
                                        <small class="text-muted"><i class="fa-solid fa-lock"></i> Akun otomatis terpilih</small>
                                
                                    @else
                                        <select class="form-select @error('account_id') is-invalid @enderror" name="account_id" id="account_id">
                                            <option value="" disabled selected>-- Pilih Akun --</option>
                                            @foreach($accounts as $account)
                                                <option value="{{ $account->id }}" {{ old('account_id') == $account->id ? 'selected' : '' }}>
                                                    {{ $account->name }} 
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('account_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                
                                    @endif
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="notes" class="form-label">Catatan (Opsional)</label>
                                <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="3" placeholder="Contoh: Makan siang di warteg">{{ old('notes') }}</textarea>
                                @error('notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fa-solid fa-save"></i> Simpan Transaksi
                                </button>
                            </div>

                        </form>
                    </div>
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