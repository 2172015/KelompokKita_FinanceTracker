<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Finance Reports</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link rel="stylesheet" href="{{ asset('dist/css/style.css') }}">
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
    rel="stylesheet">

  <!-- Chart JS CDN -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
  <div class="layout-container">

  <!-- Sidebar -->
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

  <!-- Main Content -->
  <div class="main-content">

    <!-- Header -->
    <div class="header">
      <h1>Reports & Analytics</h1>
      <button class="toggle" onclick="toggleDark()"><i class="fa-solid fa-moon"></i></button>
    </div>

    <!-- Chart Section -->
    <div class="cards">

      <!-- Income vs Expense -->
      <div class="card">
        <h3>Income vs Expense</h3>
        <canvas id="incomeExpenseChart"></canvas>
      </div>

      <!-- Category Breakdown -->
      <div class="card">
        <h3>Category Breakdown</h3>
        <canvas id="categoryChart"></canvas>
      </div>

    </div>

  </div>
</div>

<script>
  function toggleDark() {
    document.body.classList.toggle("dark");
  }

  /* 📊 Chart 1 - Income vs Expense Trend */
  const incomeExpenseChart = new Chart(document.getElementById("incomeExpenseChart"), {
    type: "line",
    data: {
      labels: ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"],
      datasets: [
        {
          label: "Income",
          data: [3500,4000,4200,5000,4700,5300,5500,5200,6000,5800,6100,6500],
          borderWidth: 2
        },
        {
          label: "Expense",
          data: [2000,2200,2400,2600,2500,3000,3150,2980,3300,3500,3600,3900],
          borderWidth: 2
        }
      ],
    },
    options:{ responsive:true }
  });

  /* 📊 Chart 2 - Expense Category Breakdown */
  const categoryChart = new Chart(document.getElementById("categoryChart"), {
    type: "pie",
    data: {
      labels: ["Food","Bills","Transport","Entertainment","Shopping","Others"],
      datasets: [{
        data: [450,300,200,120,500,180]
      }]
    },
    options: { responsive:true }
  });

</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
