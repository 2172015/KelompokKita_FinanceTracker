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

            @foreach($accounts as $account)
            <div class="card bg-white p-0 flex-fill shadow-sm position-relative overflow-hidden" style="min-width: 250px; border-radius: 15px; border:none;">
                
                <div class="position-absolute top-0 end-0 p-2 z-2">
                    <form action="{{ route('accounts.destroy', $account->id) }}" method="POST" onsubmit="return confirm('Hapus dompet {{ $account->name }}?');">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm text-danger hover-bg-light rounded-circle" style="width:30px; height:30px;">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </form>
                </div>
            
                <a href="{{ route('transactions.list', $account->id) }}" class="text-decoration-none text-dark d-block p-3 h-100">
                    <h3 class="text-muted fs-6 mb-2 mt-2">
                        <i class="fa-solid fa-building-columns me-2"></i> {{ $account->name }}
                    </h3>
                    <p class="text-success fs-3 fw-bold mb-0">
                        Rp {{ number_format($account->balance, 0, ',', '.') }}
                    </p>
                    <small class="text-muted" style="font-size: 11px;">
                        <i class="fa-solid fa-list-ul"></i> Klik untuk detail transaksi akun ini
                    </small>
                </a>
            
                <div class="p-3 pt-0">
                    <a href="{{ route('transactions.create', ['account_id' => $account->id]) }}" class="btn btn-primary btn-sm w-100 position-relative z-3">
                        <i class="fa-solid fa-plus"></i> Tambah Transaksi
                    </a>
                </div>
            
            </div>
            @endforeach

            <a href="{{ route('accounts.create') }}" class="card d-flex align-items-center justify-content-center text-decoration-none bg-light border-dashed flex-fill" style="min-width: 200px; border-radius: 15px; border: 2px dashed #ccc;">
                <div class="text-center text-muted p-3">
                    <i class="fa-solid fa-plus fa-2x mb-2"></i>
                    <h5 class="m-0 fs-6">Add Account</h5>
                </div>
            </a>
        </div>

        <div class="table-wrapper mt-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3 class="mb-0">Recent Transactions</h3>
                <a href="{{ route('transactions.index') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">View All</a>
            </div>
            
            <div class="card border-0 shadow-sm" style="border-radius: 12px; overflow: hidden;">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4 py-3 text-secondary" style="font-weight: 600; font-size: 0.9rem;">Date</th>
                                <th class="py-3 text-secondary" style="font-weight: 600; font-size: 0.9rem;">Description</th>
                                <th class="py-3 text-secondary" style="font-weight: 600; font-size: 0.9rem;">Category</th>
                                <th class="pe-4 py-3 text-end text-secondary" style="font-weight: 600; font-size: 0.9rem;">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentTransactions as $transaction)
                            <tr>
                                <td class="ps-4 text-muted" style="font-size: 0.9rem;">
                                    {{ \Carbon\Carbon::parse($transaction->date)->format('d M Y') }}
                                </td>

                                <td>
                                    <div class="fw-bold text-dark">{{ $transaction->description }}</div>
                                    <div class="small text-muted" style="font-size: 0.75rem;">
                                        <i class="fa-solid fa-wallet me-1 text-primary opacity-50"></i> 
                                        {{ $transaction->account->name ?? 'Unknown Account' }}
                                    </div>
                                </td>

                                <td>
                                    <span class="badge rounded-pill fw-normal px-3 py-2" 
                                          style="background-color: #f3f4f6; color: #4b5563; border: 1px solid #e5e7eb;">
                                        {{ $transaction->category->name ?? 'Uncategorized' }}
                                    </span>
                                </td>

                                <td class="text-end pe-4 fw-bold">
                                    @if($transaction->type == 'income')
                                        <span class="text-success">
                                            + Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                                        </span>
                                    @else
                                        <span class="text-danger">
                                            - Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-5">
                                    <div class="text-muted opacity-50 mb-2">
                                        <i class="fa-solid fa-receipt fa-3x"></i>
                                    </div>
                                    <p class="text-muted m-0">Belum ada transaksi terbaru.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
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