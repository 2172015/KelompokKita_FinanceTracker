@extends('layouts.app')

@section('title', 'Financial Reports - Finance Tracker')

@section('content')

    <div class="dashboard-header d-flex flex-column flex-lg-row justify-content-between align-items-start align-items-lg-center gap-3 mb-5">
            
        <div class="w-100">
            <h2 class="fw-bold text-dark mb-1">Financial Reports</h2>
            <p class="text-muted m-0">Ringkasan performa keuangan Anda.</p>
        </div>

        <form action="{{ route('reports.index') }}" method="GET" class="w-100 w-lg-auto">
            
            <div class="filter-bar bg-white shadow-sm ms-lg-auto">
                
                <div class="date-input-group">
                    <label class="date-label">Dari</label>
                    <div class="date-field">
                        <i class="fa-regular fa-calendar text-muted"></i>
                        <input type="month" name="from_date" class="filter-input" value="{{ $fromDateVal }}">
                    </div>
                </div>

                <div class="filter-separator-icon">
                    <i class="fa-solid fa-arrow-right text-muted opacity-50"></i>
                </div>

                <div class="date-input-group">
                    <label class="date-label">Sampai</label>
                    <div class="date-field">
                        <i class="fa-solid fa-calendar-check text-muted"></i>
                        <input type="month" name="to_date" class="filter-input" value="{{ $toDateVal }}">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary rounded-circle shadow-sm d-flex align-items-center justify-content-center filter-btn-submit">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </div>
        </form>
    </div>
        

    <div class="row g-3 mb-5">
        <div class="col-md-4">
            <div class="stat-card-gradient bg-gradient-success shadow">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="stat-label-light">Total Pemasukan</div>
                            <h3 class="stat-value-light">Rp {{ number_format($totalIncome, 0, ',', '.') }}</h3>
                        </div>
                        <div class="icon-circle-glass">
                            <i class="fa-solid fa-arrow-trend-up"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
        <div class="col-md-4">
            <div class="stat-card-gradient bg-gradient-danger shadow">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="stat-label-light">Total Pengeluaran</div>
                            <h3 class="stat-value-light">Rp {{ number_format($totalExpense, 0, ',', '.') }}</h3>
                        </div>
                        <div class="icon-circle-glass">
                            <i class="fa-solid fa-arrow-trend-down"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
        <div class="col-md-4">
            <div class="stat-card-gradient bg-gradient-theme shadow">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="stat-label-light">Sisa Saldo (Net)</div>
                            <h3 class="stat-value-light">Rp {{ number_format($netIncome, 0, ',', '.') }}</h3>
                        </div>
                        <div class="icon-circle-glass">
                            <i class="fa-solid fa-wallet"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 20px;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h5 class="fw-bold text-dark m-0">Arus Kas Bulanan</h5>
                        </div>
                    </div>
                    <div style="height: 320px; width: 100%;">
                        <canvas id="cashFlowChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 20px;">
                <div class="card-body p-4">
                    <h5 class="fw-bold text-dark mb-4">Kategori Pengeluaran</h5>
                    <div style="height: 300px; position: relative;">
                        @if(count($pieData) > 0)
                            <canvas id="categoryChart"></canvas>
                        @else
                            <div class="d-flex align-items-center justify-content-center h-100 text-muted flex-column">
                                <div class="bg-light rounded-circle p-4 mb-3">
                                    <i class="fa-solid fa-chart-pie fa-2x opacity-25"></i>
                                </div>
                                <span class="fw-semibold small">Tidak ada data</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        
        // 1. Ambil data dari Controller Laravel
        const barLabels = {!! json_encode($barLabels ?? []) !!};
        const incomeData = {!! json_encode($incomeData ?? []) !!};
        const expenseData = {!! json_encode($expenseData ?? []) !!};
        const pieLabels = {!! json_encode($pieLabels ?? []) !!};
        const pieData = {!! json_encode($pieData ?? []) !!};

        // Setting Font Global Chart
        Chart.defaults.font.family = "'Poppins', sans-serif";
        Chart.defaults.color = '#64748b';

        // 2. Render Bar Chart (Arus Kas)
        const canvasBar = document.getElementById('cashFlowChart');
        if (canvasBar) {
            new Chart(canvasBar.getContext('2d'), {
                type: 'bar',
                data: {
                    labels: barLabels,
                    datasets: [
                        {
                            label: 'Pemasukan',
                            data: incomeData,
                            backgroundColor: '#10b981',
                            borderRadius: 6,
                            barPercentage: 0.6,
                        },
                        {
                            label: 'Pengeluaran',
                            data: expenseData,
                            backgroundColor: '#ef4444',
                            borderRadius: 6,
                            barPercentage: 0.6,
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'top' },
                    },
                    scales: {
                        y: { 
                            beginAtZero: true,
                            grid: { borderDash: [5, 5], color: '#f1f5f9' }
                        },
                        x: { 
                            grid: { display: false }
                        }
                    }
                }
            });
        }

        // 3. Render Pie Chart (Kategori)
        const canvasPie = document.getElementById('categoryChart');
        if (canvasPie && pieData.length > 0) {
            new Chart(canvasPie.getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: pieLabels,
                    datasets: [{
                        data: pieData,
                        backgroundColor: [
                            '#4f46e5', '#ec4899', '#f59e0b', '#10b981', 
                            '#6366f1', '#8b5cf6', '#06b6d4', '#f43f5e'
                        ],
                        borderWidth: 0,
                        hoverOffset: 10
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '70%',
                    plugins: {
                        legend: { position: 'bottom' }
                    }
                }
            });
        }
    });
</script>
@endpush