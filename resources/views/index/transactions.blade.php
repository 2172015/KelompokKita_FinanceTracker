<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Transactions - FinansialKu</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link rel="stylesheet" href="{{ asset('dist/css/style.css') }}">
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <style>
        /* Tambahan style kecil untuk pagination dan alert */
        .text-success { color: #28a745 !important; font-weight: bold; }
        .text-danger { color: #dc3545 !important; font-weight: bold; }
        .action-btn { background: none; border: none; cursor: pointer; }
    </style>

</head>
<body>
    <div class="layout-container">
        <div class="sidebar">
            <h2>FINANCE</h2>
        
            <a href="{{ route('dashboard') }}" 
               class="{{ request()->routeIs('dashboard') ? 'active' : '' }} normal">
                <i class="fa-solid fa-gauge"></i> Dashboard
            </a>
        
            <a href="{{ route('transactions.index') }}" 
               class="{{ request()->routeIs('transactions') ? 'active' : '' }} normal">
                <i class="fa-solid fa-wallet"></i> Transactions
            </a>
        
            <a href="{{ route('accounts') }}" 
               class="{{ request()->routeIs('accounts') ? 'active' : '' }} normal">
                <i class="fa-solid fa-building-columns"></i> Accounts
            </a>
        
            <a href="{{ route('budgets') }}" 
               class="{{ request()->routeIs('budgets') ? 'active' : '' }} normal">
                <i class="fa-solid fa-piggy-bank"></i> Budgets
            </a>
        
            <a href="{{ route('categories') }}" 
               class="{{ request()->routeIs('categories') ? 'active' : '' }} normal">
                <i class="fa-solid fa-tags"></i> Categories
            </a>
        
            <a href="{{ route('reports') }}" 
               class="{{ request()->routeIs('reports') ? 'active' : '' }} normal">
                <i class="fa-solid fa-chart-pie"></i> Reports
            </a>
        
            <a href="{{ route('profile.page') }}" 
               class="{{ request()->routeIs('profile.page') ? 'active' : '' }} normal">
                <i class="fa-solid fa-user"></i> Profile
            </a>
        
            <a href="none" class="btn btn-danger logout">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" style="background:none; border:none; color:white">
                    <i class="fa-solid fa-right-from-bracket"></i> Logout
                </button>
            </form>
            </a>
          </div>

        <div class="main-content">

            <div class="header">
                <h1>Transaksi</h1>
                <a href="{{ route('transactions.create') }}" class="btn btn-primary">
                    <i class="fa-solid fa-plus"></i> Tambah Transaksi
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="table-wrapper">
                <h3>Riwayat Transaksi</h3>
                
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Deskripsi</th>
                            <th>Kategori</th>
                            <th>Akun</th>
                            <th>Nominal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $transaction)
                        <tr>
                            <td>{{ $transaction->date->format('d M Y') }}</td>
                            
                            <td>{{ $transaction->notes ?? '-' }}</td>
                            
                            <td>
                                <span class="badge bg-secondary">{{ $transaction->category->name }}</span>
                            </td>
                            
                            <td>{{ $transaction->account->name }}</td>
                            
                            <td class="{{ $transaction->type == 'income' ? 'text-success' : 'text-danger' }}">
                                {{ $transaction->type == 'income' ? '+' : '-' }} 
                                Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                            </td>
                            
                            <td>
                                <form action="{{ route('transactions.destroy', $transaction->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus transaksi ini?');">
                                    @csrf
                                    @method('DELETE')
                                    
                                    <button type="submit" class="text-danger action-btn">
                                        <i class="fa-solid fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">Belum ada transaksi. Silakan tambah baru!</td>
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
