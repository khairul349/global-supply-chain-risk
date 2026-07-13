@extends('layouts.app')

@section('content')

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-5 mt-2">
        <div>
            <h1 class="h3 fw-bold mb-1" style="letter-spacing: -0.02em;">
                📍 Country Profile
            </h1>
            <p class="text-muted fw-medium mb-0">
                Detailed supply chain indicators & threat trends for {{ $country->name }}
            </p>
        </div>
        <a href="/" class="btn btn-outline-light d-inline-flex align-items-center gap-2 fw-semibold" style="border-radius: 12px; padding: 10px 20px; border-color: var(--border-color);">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" x2="5" y1="12" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
            Back to Dashboard
        </a>
    </div>

    <div class="row g-4">

        <div class="col-lg-6">
            <div class="card shadow-sm h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>📋 General Information</span>
                    <span class="text-muted fw-normal" style="font-size: 13px;">Demographics & Geography</span>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-column flex-sm-row gap-4 align-items-center align-items-sm-start mb-4">
                        <img src="{{ $country->flag_png }}"
                             class="border rounded-3 shadow-sm"
                             alt="{{ $country->name }}"
                             style="width: 140px; height: auto; object-fit: cover;">
                        <div>
                            <h2 class="fw-bold mb-1" style="letter-spacing: -0.02em;">{{ $country->name }}</h2>
                            <span class="badge bg-primary">{{ $country->region }}</span>
                            <span class="badge bg-secondary ms-1">{{ $country->subregion }}</span>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-sm-6">
                            <div class="p-3 border rounded-3" style="border-color: var(--border-color) !important; background-color: rgba(148, 163, 184, 0.02);">
                                <small class="text-muted d-block uppercase fw-bold" style="font-size: 10px; letter-spacing: 0.05em;">Capital</small>
                                <strong style="font-size: 15px;">{{ $country->capital ?? '-' }}</strong>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="p-3 border rounded-3" style="border-color: var(--border-color) !important; background-color: rgba(148, 163, 184, 0.02);">
                                <small class="text-muted d-block uppercase fw-bold" style="font-size: 10px; letter-spacing: 0.05em;">Population</small>
                                <strong style="font-size: 15px;">{{ number_format($country->population) }}</strong>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="p-3 border rounded-3" style="border-color: var(--border-color) !important; background-color: rgba(148, 163, 184, 0.02);">
                                <small class="text-muted d-block uppercase fw-bold" style="font-size: 10px; letter-spacing: 0.05em;">Currency</small>
                                <strong style="font-size: 15px;">{{ $country->currency_name ?? '-' }} ({{ $country->currency_code ?? '-' }})</strong>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="p-3 border rounded-3" style="border-color: var(--border-color) !important; background-color: rgba(148, 163, 184, 0.02);">
                                <small class="text-muted d-block uppercase fw-bold" style="font-size: 10px; letter-spacing: 0.05em;">Coordinates</small>
                                <strong style="font-size: 14px;">Lat: {{ $country->latitude }}, Long: {{ $country->longitude }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card shadow-sm h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>🛡️ Risk Metrics Breakdown</span>
                    <span class="text-muted fw-normal" style="font-size: 13px;">Real-Time Score</span>
                </div>
                <div class="card-body">
                    @if($risk)
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <tbody>
                                <tr>
                                    <td class="fw-semibold text-muted" style="font-size: 14px; width: 50%;">⛅ Weather Score</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="progress flex-grow-1" style="height: 6px; background-color: rgba(100, 116, 139, 0.1);">
                                                <div class="progress-bar" style="width: {{ min(100, $risk->weather_score * 10) }}%; background: #6366f1 !important;"></div>
                                            </div>
                                            <strong style="min-width: 24px; text-align: right;">{{ $risk->weather_score }}</strong>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold text-muted" style="font-size: 14px;">📈 Inflation Score</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="progress flex-grow-1" style="height: 6px; background-color: rgba(100, 116, 139, 0.1);">
                                                <div class="progress-bar" style="width: {{ min(100, $risk->inflation_score * 10) }}%; background: #6366f1 !important;"></div>
                                            </div>
                                            <strong style="min-width: 24px; text-align: right;">{{ $risk->inflation_score }}</strong>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold text-muted" style="font-size: 14px;">💱 Currency Score</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="progress flex-grow-1" style="height: 6px; background-color: rgba(100, 116, 139, 0.1);">
                                                <div class="progress-bar" style="width: {{ min(100, $risk->currency_score * 10) }}%; background: #6366f1 !important;"></div>
                                            </div>
                                            <strong style="min-width: 24px; text-align: right;">{{ $risk->currency_score }}</strong>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold text-muted" style="font-size: 14px;">📰 News Score</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="progress flex-grow-1" style="height: 6px; background-color: rgba(100, 116, 139, 0.1);">
                                                <div class="progress-bar" style="width: {{ min(100, $risk->news_score * 10) }}%; background: #6366f1 !important;"></div>
                                            </div>
                                            <strong style="min-width: 24px; text-align: right;">{{ $risk->news_score }}</strong>
                                        </div>
                                    </td>
                                </tr>
                                <tr style="border-top: 2px solid var(--border-color); background-color: rgba(99, 102, 241, 0.02) !important;">
                                    <td class="fw-bold" style="font-size: 15px;">Total Aggregated Score</td>
                                    <td>
                                        <div class="d-flex align-items-center justify-content-between">
                                            <strong style="font-size: 18px; color: var(--text-main);">{{ $risk->total_score }}</strong>
                                            @if($risk->risk_level == 'High')
                                                <span class="badge bg-danger">High Threat</span>
                                            @elseif($risk->risk_level == 'Medium')
                                                <span class="badge bg-warning">Medium Threat</span>
                                            @else
                                                <span class="badge bg-success">Low Threat</span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    @else
                        <div class="alert alert-warning border-0" style="border-radius: 12px; background-color: rgba(245, 158, 11, 0.1); color: #d97706;">
                            ⚠️ Risk score data is currently unavailable.
                        </div>
                    @endif
                </div>
            </div>
        </div>

    </div>

    <div class="card mt-4 shadow-sm">

        <div class="card-header d-flex justify-content-between align-items-center">
            <span>📈 Risk Score Trend</span>
            <span class="text-muted fw-normal" style="font-size: 13px;">Historical changes over time</span>
        </div>

        <div class="card-body">

            <div style="position: relative; height: 350px; width: 100%;">
                <canvas id="trendChart"></canvas>
            </div>

        </div>

    </div>

</div>

<script>

let trendChart;

function loadTrend(){

fetch('/api/trend/{{ $country->id }}')

.then(response=>response.json())

.then(data=>{

const labels=data.map(item=>{

return new Date(item.created_at).toLocaleString();

});

const scores=data.map(item=>item.total_score);

if(trendChart){

trendChart.destroy();

}

const ctx = document.getElementById('trendChart').getContext('2d');
const isDark = document.body.classList.contains('bg-dark');
const textColor = isDark ? '#94a3b8' : '#64748b';
const gridColor = isDark ? 'rgba(255, 255, 255, 0.05)' : 'rgba(0, 0, 0, 0.05)';

// Create soft gradient under line
const gradient = ctx.createLinearGradient(0, 0, 0, 300);
gradient.addColorStop(0, 'rgba(99, 102, 241, 0.35)');
gradient.addColorStop(1, 'rgba(99, 102, 241, 0)');

trendChart=new Chart(

    ctx,

    {

        type: 'line',

        data: {

            labels: labels,

            datasets: [{

                label: 'Risk Score',

                data: scores,

                fill: true,
                backgroundColor: gradient,
                borderColor: '#6366f1',

                borderWidth: 3,

                tension: 0.4,
                pointBackgroundColor: '#6366f1',
                pointBorderColor: isDark ? '#111625' : '#ffffff',
                pointBorderWidth: 2,
                pointRadius: 5,
                pointHoverRadius: 8

            }]

        },

        options: {

            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: isDark ? '#1e293b' : '#0f172a',
                    titleColor: '#fff',
                    bodyColor: '#e2e8f0',
                    padding: 12,
                    cornerRadius: 10,
                    titleFont: {
                        family: 'Plus Jakarta Sans',
                        weight: '700'
                    },
                    bodyFont: {
                        family: 'Plus Jakarta Sans'
                    }
                }
            },
            scales: {
                y: {
                    grid: { color: gridColor, drawTicks: false },
                    ticks: {
                        color: textColor,
                        font: { family: 'Plus Jakarta Sans', size: 12 }
                    }
                },
                x: {
                    grid: { display: false },
                    ticks: {
                        color: textColor,
                        font: { family: 'Plus Jakarta Sans', size: 11 }
                    }
                }
            }

        }

    }

);

});

}

loadTrend();

setInterval(loadTrend,30000);

// Watch for theme toggles to update chart configurations
document.getElementById('darkModeBtn').addEventListener('click', () => {
    setTimeout(() => {
        const isDarkNow = document.body.classList.contains('bg-dark');
        const newTextColor = isDarkNow ? '#94a3b8' : '#64748b';
        const newGridColor = isDarkNow ? 'rgba(255, 255, 255, 0.05)' : 'rgba(0, 0, 0, 0.05)';
        
        if(trendChart) {
            trendChart.options.scales.x.ticks.color = newTextColor;
            trendChart.options.scales.y.ticks.color = newTextColor;
            trendChart.options.scales.y.grid.color = newGridColor;
            trendChart.data.datasets[0].pointBorderColor = isDarkNow ? '#111625' : '#ffffff';
            trendChart.update();
        }
    }, 100);
});

</script>
@endsection