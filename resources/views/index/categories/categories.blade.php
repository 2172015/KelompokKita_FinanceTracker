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

            <div class="header">
                <div class="textwrap">
                    <h1 class="mb-1">Categories List</h1>
                    <p class="text-muted m-0" style="text-align: left">Kelola kategori pengeluaran dan pemasukan Anda.</p>
                </div>
                <div class="header-actions">
                  <div class="me-3">Halo, <strong>{{ Auth::user()->name }}</strong></div>
                </div>
            </div>

            <div class="main-content">
      
                <div class="d-flex justify-content-between align-items-center mb-4">                  
                  <div>
                      <a href="{{ route('categories.create') }}" class="btn btn-primary rounded-pill px-4 py-2">
                          <i class="fa-solid fa-plus me-1"></i> Add New Category
                      </a>
                  </div>
                </div>
          
                <div class="card border-0 shadow-sm" style="border-radius: 12px; overflow: hidden;">
                  <div class="table-responsive">
                      <table class="table table-hover align-middle mb-0">
                          <thead class="bg-light">
                              <tr>
                                  <th class="ps-4 py-3 text-secondary" style="font-weight: 600; width: 5%;">No</th>
                                  <th class="py-3 text-secondary" style="font-weight: 600;">Category Name</th>
                                  <th class="py-3 text-secondary text-end pe-5" style="font-weight: 600;">Total Balance</th>
                                  <th class="py-3 text-secondary text-center" style="font-weight: 600; width: 15%;">Actions</th>
                              </tr>
                          </thead>
                          <tbody>
                              @forelse($categories as $category)
                              <tr>
                                  <td class="ps-4 text-muted">{{ $loop->iteration }}</td>
                                  
                                  <td>
                                      <div class="fw-bold text-dark fs-6">
                                          <i class="fa-solid fa-tag me-2 text-primary opacity-50"></i>
                                          {{ $category->name }}
                                      </div>
                                  </td>
          
                                  <td class="text-end pe-5">
                                      <span class="fw-bold {{ $category->categories_balance < 0 ? 'text-danger' : 'text-dark' }}">
                                          Rp {{ number_format($category->categories_balance ?? 0, 0, ',', '.') }}
                                      </span>
                                  </td>
          
                                  <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-sm btn-outline-warning border-0" title="Edit">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                
                                        @if($category->categories_balance == 0)
                                            <form action="{{ route('categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kategori {{ $category->name }}?');">
                                                @csrf 
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger border-0" title="Delete">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </form>
                                        @else
                                            <button type="button" class="btn btn-sm btn-outline-secondary border-0" disabled title="Tidak bisa dihapus karena saldo belum Rp 0">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        @endif
                                    </div>
                                  </td>
                              </tr>
                              @empty
                              <tr>
                                  <td colspan="4" class="text-center py-5">
                                      <div class="mb-3 text-muted opacity-25">
                                          <i class="fa-solid fa-folder-open fa-3x"></i>
                                      </div>
                                      <h5 class="text-muted">Belum ada kategori ditemukan.</h5>
                                      <p class="text-muted small">Silakan tambahkan kategori baru untuk memulai.</p>
                                  </td>
                              </tr>
                              @endforelse
                          </tbody>
                      </table>
                  </div>
                </div>
            </div>
        </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
