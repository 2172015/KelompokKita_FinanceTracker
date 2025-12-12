<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Riwayat {{ $account->name }} - FinansialKu</title>
  
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
        <div class="table-wrapper bg-white p-4 rounded shadow-sm">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3>Daftar Transaksi</h3>
                <a href="{{ route('transactions.create', ['account_id' => $account->id]) }}" class="btn btn-primary">
                    <i class="fa-solid fa-plus"></i> Transaksi Baru
                </a>
            </div>
            
            <table class="table table-hover align-middle">
              <thead class="table-light">
                <tr>
                  <th>Tanggal</th>
                  <th>Deskripsi</th>
                  <th>Kategori</th>
                  <th>Nominal</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                @forelse($transactions as $transaction)
                <tr>
                  <td>{{ \Carbon\Carbon::parse($transaction->date)->format('d M Y') }}</td>
                  
                  <td>{{ $transaction->transaction_notes ?? '-' }}</td>
                  
                  <td><span class="badge bg-secondary">{{ $transaction->category->name }}</span></td>
                  
                  <td class="{{ $transaction->type == 'income' ? 'text-success' : 'text-danger' }}">
                      {{ $transaction->type == 'income' ? '+' : '-' }} 
                      Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                  </td>
                  
                  <td>
                      <form action="{{ route('transactions.destroy', $transaction->id) }}" method="POST" onsubmit="return confirm('Hapus transaksi ini?');">
                          @csrf @method('DELETE')
                          <button type="submit" class="btn btn-link text-danger p-0 border-0">
                              <i class="fa-solid fa-trash"></i>
                          </button>
                      </form>
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="5" class="text-center py-5 text-muted">
                      <i class="fa-solid fa-box-open fa-2x mb-3"></i><br>
                      Belum ada transaksi di akun <b>{{ $account->name }}</b>.
                  </td>
                </tr>
                @endforelse
              </tbody>
            </table>
  
            <div class="mt-3">
                {{ $transactions->links() }}
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