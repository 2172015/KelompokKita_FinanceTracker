<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Transactions - Finance Tracker</title>
  
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
        <h1>Transactions</h1>
        <div class="header-actions">
            <a href="{{ route('transactions.create') }}" class="btn btn-primary">
                <i class="fa-solid fa-plus"></i> Transaksi Baru
           </a>
        </div>
      </div>

      @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
          <i class="fa-solid fa-check-circle me-2"></i> {{ session('success') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
        @endif

        @if(request('account_id'))
        <div class="alert alert-info d-flex justify-content-between align-items-center mb-3">
            <span><i class="fa-solid fa-filter me-2"></i> Menampilkan transaksi untuk akun terpilih saja.</span>
            <a href="{{ route('transactions.index') }}" class="btn btn-sm btn-light">Reset Filter</a>
        </div>
        @endif

        <div class="table-wrapper bg-white p-4 rounded shadow-sm">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Tanggal</th>
                            <th>Deskripsi</th>
                            <th>Kategori</th>
                            <th>Akun Dompet</th> <th>Nominal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $transaction)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($transaction->date)->format('d M Y') }}</td>
                            
                            <td>{{ $transaction->transaction_notes ?? '-' }}</td>
                            
                            <td>
                                <span class="badge bg-secondary rounded-pill px-3">
                                    {{ $transaction->category->name ?? 'Umum' }}
                                </span>
                            </td>
                            
                            <td>
                                <i class="fa-solid fa-wallet text-muted me-1"></i>
                                {{ $transaction->account->name ?? 'Deleted Account' }}
                            </td>
                            
                            <td class="{{ $transaction->type == 'income' ? 'text-success' : 'text-danger' }}">
                                {{ $transaction->type == 'income' ? '+' : '-' }} 
                                Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                            </td>
                            
                            <td>
                                <form action="{{ route('transactions.destroy', $transaction->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus transaksi ini? Saldo akun akan dikembalikan.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-link text-danger p-0" title="Hapus">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <img src="https://cdn-icons-png.flaticon.com/512/7486/7486744.png" alt="Empty" style="width: 60px; opacity: 0.5;" class="mb-3">
                                <br>
                                Belum ada riwayat transaksi apapun.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
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