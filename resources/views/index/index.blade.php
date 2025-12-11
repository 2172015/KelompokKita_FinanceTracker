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
  
      <a href="{{ route('accounts') }}" class="{{ request()->routeIs('accounts*') ? 'active' : '' }} normal">
          <i class="fa-solid fa-building-columns"></i> Accounts
      </a>
  
      <a href="#" class="normal"><i class="fa-solid fa-piggy-bank"></i> Budgets</a>
      <a href="#" class="normal"><i class="fa-solid fa-tags"></i> Categories</a>
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
        <h1>Dashboard</h1>
        <div class="header-actions">
          <div class="me-3">Halo, <strong>{{ Auth::user()->name }}</strong></div>
          <button class="toggle btn btn-sm btn-outline-secondary me-2" onclick="toggleDark()"><i class="fa-solid fa-moon"></i></button>
        </div>
      </div>

      @if($accounts->isEmpty())
        
        <div class="text-center mt-5 p-5 bg-white rounded shadow-sm">
            <i class="fa-solid fa-wallet fa-4x text-secondary mb-3"></i>
            <h2 class="mt-3">Dompet Masih Kosong</h2>
            <p class="text-muted mb-4">Anda belum memiliki akun dompet. Buat akun pertama Anda untuk memulai.</p>
            
            <a href="{{ route('accountcreate') }}" class="btn btn-primary px-4 py-2 rounded-pill">
                <i class="fa-solid fa-plus"></i> Buat Akun Baru
            </a>
        </div>

      @else

        @php
            $totalBalance = $accounts->sum('balance');
        @endphp

        <div class="cards d-flex flex-wrap gap-3 mt-4">
            <div class="card bg-primary text-white p-3 flex-fill" style="min-width: 250px; border-radius: 15px;">
                <h3 class="text-white-50 fs-6">Total Balance</h3>
                <p class="text-white fs-3 fw-bold">Rp {{ number_format($totalBalance, 0, ',', '.') }}</p>
            </div>
        </div>

        <div class="cards">
            @foreach($accounts as $account)
            <div class="card">
                <h3><i class="fa-solid fa-building-columns me-2"></i> {{ $account->name }}</h3>
                <p class="">
                    Rp {{ number_format($account->balance, 0, ',', '.') }}
                </p>
                <form action="{{ route('accounts.destroy', $account->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus dompet {{ $account->name }}? Semua transaksi di dalamnya juga akan terhapus.');">
                  @csrf
                  @method('DELETE') <button type="submit" class="btn btn-sm btn-light text-danger border-0" title="Hapus Akun">
                      <i class="fa-solid fa-trash"></i>
                  </button>
                </form>
            </div>
            @endforeach

            <a href="{{ route('accountcreate') }}" class="card d-flex align-items-center justify-content-center text-decoration-none bg-light border-dashed flex-fill" style="min-width: 200px; border-radius: 15px; border: 2px dashed #ccc;">
                <div class="text-center text-muted p-3">
                    <i class="fa-solid fa-plus fa-2x mb-2"></i>
                    <h5 class="m-0 fs-6">Add Account</h5>
                </div>
            </a>
        </div>

        <div class="table-wrapper mt-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3>Recent Transactions</h3>
                <a href="{{ route('transactions.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            
            <table class="table">
            <thead>
                <tr>
                <th>Date</th>
                <th>Description</th>
                <th>Category</th>
                <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                <td colspan="4" class="text-center text-muted py-4">
                    <i>Data transaksi akan muncul di sini.</i>
                </td>
                </tr>
            </tbody>
            </table>
        </div>
      </div>

      @endif 
      </div>
  </div>

  <script>
    function toggleDark() { document.body.classList.toggle('dark'); }
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>