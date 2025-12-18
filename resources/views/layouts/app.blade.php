<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Finance Tracker')</title> 
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('dist/css/style.css') }}">
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @stack('styles') 
</head>

<body>

<div class="layout-container">

    <div class="sidebar">
        <div class="sidebar-header">
            <h2>FINANCE</h2>
        </div>
    
        <div class="menu-items">
            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }} nav-item">
                <i class="fa-solid fa-gauge"></i> 
                <span>Dashboard</span>
            </a>
        
            <a href="{{ route('transactions.index') }}" class="{{ request()->routeIs('transactions*') ? 'active' : '' }} nav-item">
                <i class="fa-solid fa-wallet"></i> 
                <span>Transactions</span>
            </a>
          
            <a href="{{ route('categories.index') }}" class="{{ request()->routeIs('categories*') ? 'active' : '' }} nav-item">
              <i class="fa-solid fa-tags"></i> 
              <span>Categories</span>
            </a>
            
            <a href="{{ route('reports.index') }}" class="{{ request()->routeIs('reports*') ? 'active' : '' }} nav-item">
                <i class="fa-solid fa-chart-pie"></i> 
                <span>Reports</span>
            </a>

            <form method="POST" action="{{ route('logout') }}" class="logout-form">
                @csrf
                <button type="submit" class="nav-item btn-logout">
                    <i class="fa-solid fa-right-from-bracket"></i> 
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </div>

    <div class="main-content">
        @yield('content') 
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')

</body>
</html>