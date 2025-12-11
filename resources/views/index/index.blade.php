<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Finance Tracker Dashboard</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link rel="stylesheet" href="{{ asset('dist/css/style.css') }}">
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
    rel="stylesheet">
</head>

<body>
  <div class="layout-container">
    <!-- Sidebar with active paths -->
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
  

    <!-- Main Content -->
    <div class="main-content">
      <div class="header">
        <h1>Dashboard</h1>
        <div class="header-actions">
          <button class="toggle" onclick="toggleDark()"><i class="fa-solid fa-moon"></i></button>
          <button class="btn">+ Add Transaction</button>
        </div>
      </div>

      <!-- Cards -->
      <div class="cards">
        <div class="card">
          <h3>Total Income</h3>
          <p class="income">$ 4,987</p>
        </div>
        <div class="card">
          <h3>Total Expense</h3>
          <p class="expense">$ 2,345</p>
        </div>
        <div class="card">
          <h3>Current Balance</h3>
          <p>$ 2,642</p>
        </div>
      </div>

      <!-- Table -->
      <div class="table-wrapper">
        <h3>Recent Transactions</h3>
        <table>
          <tr>
            <th>Date</th>
            <th>Description</th>
            <th>Category</th>
            <th>Amount</th>
          </tr>
          <tr>
            <td>Apr 10</td>
            <td>Salary</td>
            <td>Income</td>
            <td class="income">+$5,000</td>
          </tr>
          <tr>
            <td>Apr 12</td>
            <td>Grocery</td>
            <td>Food</td>
            <td class="expense">-$150</td>
          </tr>
          <tr>
            <td>Apr 15</td>
            <td>Restaurant</td>
            <td>Food</td>
            <td class="expense">-$60</td>
          </tr>
          <tr>
            <td>Apr 17</td>
            <td>Utility Bill</td>
            <td>Utilities</td>
            <td class="expense">-$100</td>
          </tr>
        </table>
      </div>
    </div>
  </div>

  <script>
    function toggleDark() { document.body.classList.toggle('dark'); }
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
