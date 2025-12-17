@extends('layouts.app')

@section('title', 'Financial Reports - Finance Tracker')

@section('content')

    <div class="header mb-4 d-flex flex-column flex-md-row justify-content-between align-items-md-end gap-3">
        <div>
            <h1 class="mb-1">Financial Reports</h1>
            <p class="text-muted m-0 small">Analisis arus kas dalam periode tertentu.</p>
        </div>
        
        <form action="{{ route('reports.index') }}" method="GET">
            <div class="d-flex align-items-center gap-2 bg-white p-2 rounded-4 shadow-sm border">
                
                <div class="custom-date" title="Dari Bulan">
                    <i class="fa-solid fa-calendar text-muted"></i>
                    <input type="month" name="from_date" value="{{ $fromDateVal }}">
                </div>
    
                <span class="text-muted small"><i class="fa-solid fa-arrow-right"></i></span>
    
                <div class="custom-date" title="Sampai Bulan">
                    <i class="fa-solid fa-calendar-check text-muted"></i>
                    <input type="month" name="to_date" value="{{ $toDateVal }}">
                </div>
    
                <button type="submit" class="btn btn-primary rounded-3 px-3 py-2 shadow-sm d-flex align-items-center justify-content-center" style="height: 38px;">
                    <i class="fa-solid fa-filter"></i>
                </button>
            </div>
        </form>
    </div>

    <div class="row g-3 mb-4">
        
        <div class="col-md-4">
            <div class="stat-card income shadow-sm">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="mb-1 fw-bold opacity-75 small">TOTAL INCOME</p>
                        <h3 class="fw-bold mb-0">Rp {{ number_format($totalIncome, 0, ',', '.') }}</h3>
                    </div>
                    <div class="icon-bg">
                        <i class="fa-solid fa-arrow-trend-up"></i>
                    </div>
                </div>
            </div>
        </div>
    
        <div class="col-md-4">
            <div class="stat-card expense shadow-sm">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="mb-1 fw-bold opacity-75 small">TOTAL EXPENSE</p>
                        <h3 class="fw-bold mb-0">Rp {{ number_format($totalExpense, 0, ',', '.') }}</h3>
                    </div>
                    <div class="icon-bg">
                        <i class="fa-solid fa-arrow-trend-down"></i>
                    </div>
                </div>
            </div>
        </div>
    
        <div class="col-md-4">
            <div class="stat-card balance shadow-sm">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="mb-1 fw-bold opacity-75 small">NET BALANCE</p>
                        <h3 class="fw-bold mb-0">Rp {{ number_format($netIncome, 0, ',', '.') }}</h3>
                    </div>
                    <div class="icon-bg">
                        <i class="fa-solid fa-wallet"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 15px;">
                <div class="card-body">
                    <h5 class="card-title fw-bold mb-4">Arus Kas (Cash Flow)</h5>
                    <div style="height: 300px; width: 100%;">
                        <canvas id="cashFlowChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 15px;">
                <div class="card-body">
                    <h5 class="card-title fw-bold mb-4">Pengeluaran per Kategori</h5>
                    <div style="height: 300px; position: relative;">
                        @if(count($pieData) > 0)
                            <canvas id="categoryChart"></canvas>
                        @else
                            <div class="d-flex align-items-center justify-content-center h-100 text-muted flex-column">
                                <i class="fa-solid fa-chart-pie fa-2x mb-2 opacity-25"></i>
                                <small>Tidak ada pengeluaran</small>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        
        // 1. DATA DARI CONTROLLER
        const barLabels = {!! json_encode($barLabels ?? []) !!};
        const incomeData = {!! json_encode($incomeData ?? []) !!};
        const expenseData = {!! json_encode($expenseData ?? []) !!};
        const pieLabels = {!! json_encode($pieLabels ?? []) !!};
        const pieData = {!! json_encode($pieData ?? []) !!};

        // 2. BAR CHART (CASH FLOW)
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
                            borderRadius: 4,
                            barPercentage: 0.6,
                        },
                        {
                            label: 'Pengeluaran',
                            data: expenseData,
                            backgroundColor: '#ef4444',
                            borderRadius: 4,
                            barPercentage: 0.6,
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'top' },
                        tooltip: { mode: 'index', intersect: false }
                    },
                    scales: {
                        y: { 
                            beginAtZero: true,
                            grid: { borderDash: [2, 4], color: '#e5e7eb' } 
                        },
                        x: { grid: { display: false } }
                    }
                }
            });
        }

        // 3. PIE CHART (CATEGORIES)
        const canvasPie = document.getElementById('categoryChart');
        if (canvasPie && pieData.length > 0) {
            new Chart(canvasPie.getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: pieLabels,
                    datasets: [{
                        data: pieData,
                        backgroundColor: [
                            '#4f46e5', '#ec4899', '#f59e0b', '#10b981', '#6366f1', '#8b5cf6', '#06b6d4', '#f43f5e'
                        ],
                        borderWidth: 2,
                        borderColor: '#ffffff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { 
                            position: 'bottom', 
                            labels: { usePointStyle: true, boxWidth: 8 } 
                        }
                    }
                }
            });
        }
    });
</script>
@endpush