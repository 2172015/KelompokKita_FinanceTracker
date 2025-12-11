<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Budgets - FinansialKu</title>
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
    
        <a href="{{ route('dashboard') }}" 
           class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="fa-solid fa-gauge"></i> Dashboard
        </a>
    
        <a href="{{ route('transactions') }}" 
           class="{{ request()->routeIs('transactions') ? 'active' : '' }}">
            <i class="fa-solid fa-wallet"></i> Transactions
        </a>
    
        <a href="{{ route('accounts') }}" 
           class="{{ request()->routeIs('accounts') ? 'active' : '' }}">
            <i class="fa-solid fa-building-columns"></i> Accounts
        </a>
    
        <a href="{{ route('budgets') }}" 
           class="{{ request()->routeIs('budgets') ? 'active' : '' }}">
            <i class="fa-solid fa-piggy-bank"></i> Budgets
        </a>
    
        <a href="{{ route('categories') }}" 
           class="{{ request()->routeIs('categories') ? 'active' : '' }}">
            <i class="fa-solid fa-tags"></i> Categories
        </a>
    
        <a href="{{ route('reports') }}" 
           class="{{ request()->routeIs('reports') ? 'active' : '' }}">
            <i class="fa-solid fa-chart-pie"></i> Reports
        </a>
    
        <a href="{{ route('profile.page') }}" 
           class="{{ request()->routeIs('profile.page') ? 'active' : '' }}">
            <i class="fa-solid fa-user"></i> Profile
        </a>
    
        <form method="POST" action="{{ route('logout') }}" style="margin-top: 20px;">
            @csrf
            <button type="submit" 
                    style="background:none;border:none;color:white;cursor:pointer;padding:12px 16px;text-align:left;width:100%;">
                <i class="fa-solid fa-right-from-bracket"></i> Logout
            </button>
        </form>
    </div>

    <div class="main-content">

        <div class="header">
            <h1>Anggaran</h1>
            <button class="btn">Tambah Anggaran</button>
        </div>

        <div class="table-wrapper">
            <h3>Daftar Anggaran</h3>
            <table>
                <tr>
                    <th>Kategori</th>
                    <th>Batas</th>
                    <th>Dipakai</th>
                    <th>Sisa</th>
                    <th>Periode</th>
                    <th>Aksi</th>
                </tr>
                <tr>
                    <td>Makanan</td>
                    <td>Rp 500.000</td>
                    <td class="expense">Rp 350.000</td>
                    <td class="income">Rp 150.000</td>
                    <td>Bulanan</td>
                    <td>Edit | Hapus</td>
                </tr>
            </table>
        </div>

    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
