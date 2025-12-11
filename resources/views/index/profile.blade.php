<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <title>Profile - Finance Tracker</title>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
        <link rel="stylesheet" href="{{ asset('dist/css/style.css') }}" />
        <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet">
    </head>

    <body>
        
        <div class="layout-container">
            <div class="sidebar">
                <h2>FINANCE</h2>
            
                <a href="{{ route('dashboard') }}" 
                   class="{{ request()->routeIs('dashboard') ? 'active' : '' }} normal">
                    <i class="fa-solid fa-gauge"></i> Dashboard
                </a>
            
                <a href="{{ route('transactions') }}" 
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
                    <h1>Profile</h1>
                </div>
    
                <div
                    style="
                        background-color: #1e1f26;
                        color: white;
                        padding: 20px;
                        border-radius: 8px;
                        width: 400px;
                    "
                >
                    <h3>Username: johndoe</h3>
                    <p>Email: johndoe@email.com</p>
                    <p>Theme: Dark</p>
                    <button class="btn">Edit Profile</button>
                    <button
                        class="btn"
                        style="background-color: #ef4444; margin-left: 10px"
                    >
                        Logout
                    </button>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        
    </body>
</html>
