<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Global Supply Chain Risk Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>

    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.css"/>

    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.Default.css"/>

    <style>
        :root {
            --bg-body: #f8fafc;
            --bg-card: #ffffff;
            --bg-navbar: rgba(255, 255, 255, 0.8);
            --border-color: rgba(226, 232, 240, 0.8);
            --text-main: #0f172a;
            --text-muted: #64748b;
            --accent-primary: linear-gradient(135deg, #4f46e5, #6366f1);
            --shadow-card: 0 4px 20px -2px rgba(0, 0, 0, 0.05), 0 2px 8px -1px rgba(0, 0, 0, 0.03), 0 0 0 1px rgba(0,0,0,0.02);
            --shadow-hover: 0 20px 25px -5px rgba(99, 102, 241, 0.08), 0 8px 10px -6px rgba(0, 0, 0, 0.03);
            --input-bg: #ffffff;
            --navbar-brand-color: linear-gradient(90deg, #4f46e5, #06b6d4);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-body) !important;
            color: var(--text-main) !important;
            transition: background-color 0.4s cubic-bezier(0.4, 0, 0.2, 1), color 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            overflow-x: hidden;
        }

        body.bg-dark {
            --bg-body: #090d16;
            --bg-card: #111625;
            --bg-navbar: rgba(17, 22, 37, 0.8);
            --border-color: rgba(255, 255, 255, 0.08);
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
            --accent-primary: linear-gradient(135deg, #6366f1, #818cf8);
            --shadow-card: 0 4px 25px rgba(0, 0, 0, 0.35), 0 2px 10px rgba(0, 0, 0, 0.2);
            --shadow-hover: 0 20px 30px rgba(99, 102, 241, 0.15), 0 8px 15px rgba(0, 0, 0, 0.3);
            --input-bg: #1e293b;
            --navbar-brand-color: linear-gradient(90deg, #818cf8, #22d3ee);
            background-color: var(--bg-body) !important;
            color: var(--text-main) !important;
        }

        /* Floating glassmorphic navbar */
        .navbar {
            margin: 20px auto;
            border-radius: 16px;
            background: var(--bg-navbar) !important;
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow-card);
            padding: 14px 24px;
            max-width: 1300px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 1000;
        }

        .navbar-brand {
            font-size: 20px;
            font-weight: 800;
            background: var(--navbar-brand-color);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .navbar .btn {
            border-radius: 12px;
            font-weight: 600;
            font-size: 14px;
            padding: 8px 18px;
            border: 1px solid transparent;
            transition: all 0.25s ease;
        }

        .navbar .btn-outline-light {
            border-color: var(--border-color);
            color: var(--text-main) !important;
            background: transparent;
        }

        .navbar .btn-outline-light:hover {
            background: rgba(99, 102, 241, 0.1) !important;
            color: #6366f1 !important;
            border-color: rgba(99, 102, 241, 0.3) !important;
        }

        .navbar .btn-warning {
            background-color: rgba(245, 158, 11, 0.1) !important;
            color: #d97706 !important;
            border-color: rgba(245, 158, 11, 0.2) !important;
        }
        body.bg-dark .navbar .btn-warning {
            color: #fbbf24 !important;
        }
        .navbar .btn-warning:hover {
            background-color: #f59e0b !important;
            color: #fff !important;
            box-shadow: 0 4px 12px rgba(245, 158, 11, 0.25);
        }

        .navbar .btn-success {
            background-color: rgba(16, 185, 129, 0.1) !important;
            color: #059669 !important;
            border-color: rgba(16, 185, 129, 0.2) !important;
        }
        body.bg-dark .navbar .btn-success {
            color: #34d399 !important;
        }
        .navbar .btn-success:hover {
            background-color: #10b981 !important;
            color: #fff !important;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.25);
        }

        .navbar .btn-info {
            background-color: rgba(6, 182, 212, 0.1) !important;
            color: #0891b2 !important;
            border-color: rgba(6, 182, 212, 0.2) !important;
        }
        body.bg-dark .navbar .btn-info {
            color: #22d3ee !important;
        }
        .navbar .btn-info:hover {
            background-color: #06b6d4 !important;
            color: #fff !important;
            box-shadow: 0 4px 12px rgba(6, 182, 212, 0.25);
        }

        /* Modern card layout override */
        .card {
            background-color: var(--bg-card) !important;
            border: 1px solid var(--border-color) !important;
            border-radius: 20px;
            box-shadow: var(--shadow-card);
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1), box-shadow 0.3s cubic-bezier(0.4, 0, 0.2, 1), border-color 0.3s ease;
            overflow: hidden;
            color: var(--text-main);
        }

        .card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-hover);
            border-color: rgba(99, 102, 241, 0.25) !important;
        }

        .card-header {
            background: transparent !important;
            border-bottom: 1px solid var(--border-color) !important;
            padding: 20px 24px;
            font-weight: 700;
            font-size: 16px;
            color: var(--text-main) !important;
        }

        .card-body {
            padding: 24px;
        }

        footer {
            margin-top: 80px;
            padding: 30px;
            text-align: center;
            color: var(--text-muted);
            border-top: 1px solid var(--border-color);
            font-size: 14px;
            font-weight: 500;
        }

        /* Modern Blur Loader */
        #loader {
            position: fixed;
            width: 100%;
            height: 100%;
            background: var(--bg-body);
            backdrop-filter: blur(8px);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            z-index: 999999;
            transition: opacity 0.4s ease, visibility 0.4s ease;
            gap: 15px;
        }

        .loader-spinner {
            width: 48px;
            height: 48px;
            border: 4px solid var(--border-color);
            border-bottom-color: #6366f1;
            border-radius: 50%;
            display: inline-block;
            box-sizing: border-box;
            animation: rotation 1s linear infinite;
        }

        @keyframes rotation {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }

        .loader-text {
            font-size: 14px;
            font-weight: 600;
            letter-spacing: 0.05em;
            color: var(--text-muted);
            animation: pulse-glow 1.5s ease-in-out infinite;
        }

        @keyframes pulse-glow {
            0%, 100% { opacity: 0.6; }
            50% { opacity: 1; }
        }

        /* Input styling */
        .form-control, .form-select {
            background-color: var(--bg-card) !important;
            border: 1px solid var(--border-color) !important;
            color: var(--text-main) !important;
            border-radius: 12px;
            padding: 10px 16px;
            font-size: 14px;
            transition: all 0.2s ease;
        }

        .form-control:focus, .form-select:focus {
            outline: 0;
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.15) !important;
            border-color: #6366f1 !important;
        }

        .form-control::placeholder {
            color: var(--text-muted) !important;
            opacity: 0.6;
        }

        /* Modern Tables */
        .table {
            color: var(--text-main) !important;
            vertical-align: middle;
        }
        
        .table > :not(caption) > * > * {
            background-color: transparent !important;
            border-bottom-color: var(--border-color) !important;
            color: var(--text-main) !important;
            padding: 14px 16px;
        }

        .table-dark {
            --bs-table-bg: transparent !important;
            border-bottom: 2px solid var(--border-color) !important;
        }

        .table-dark th {
            color: var(--text-main) !important;
            font-weight: 700;
            font-size: 14px;
            letter-spacing: 0.03em;
            text-transform: uppercase;
        }

        /* Leaflet Overrides */
        .leaflet-container {
            font-family: inherit !important;
            background: var(--bg-body) !important;
        }

        .leaflet-bar {
            border: 1px solid var(--border-color) !important;
            box-shadow: var(--shadow-card) !important;
            border-radius: 10px !important;
            overflow: hidden;
        }

        .leaflet-bar a {
            background-color: var(--bg-card) !important;
            color: var(--text-main) !important;
            border-bottom: 1px solid var(--border-color) !important;
            transition: all 0.2s ease;
        }

        .leaflet-bar a:hover {
            background-color: rgba(99, 102, 241, 0.1) !important;
            color: #6366f1 !important;
        }

        .leaflet-popup-content-wrapper {
            background: var(--bg-card) !important;
            color: var(--text-main) !important;
            border: 1px solid var(--border-color) !important;
            border-radius: 16px !important;
            box-shadow: var(--shadow-card) !important;
            padding: 6px;
        }

        .leaflet-popup-tip {
            background: var(--bg-card) !important;
            border-left: 1px solid var(--border-color) !important;
            border-bottom: 1px solid var(--border-color) !important;
        }

        /* Badges */
        .badge {
            font-weight: 600 !important;
            padding: 6px 12px !important;
            border-radius: 8px !important;
            font-size: 12px !important;
        }
        
        .bg-danger {
            background-color: rgba(239, 68, 68, 0.1) !important;
            color: #ef4444 !important;
            border: 1px solid rgba(239, 68, 68, 0.2);
        }

        .bg-warning {
            background-color: rgba(245, 158, 11, 0.1) !important;
            color: #d97706 !important;
            border: 1px solid rgba(245, 158, 11, 0.2);
        }
        
        body.bg-dark .bg-warning {
            color: #fbbf24 !important;
        }

        .bg-success {
            background-color: rgba(16, 185, 129, 0.1) !important;
            color: #10b981 !important;
            border: 1px solid rgba(16, 185, 129, 0.2);
        }

        .bg-secondary {
            background-color: rgba(100, 116, 139, 0.1) !important;
            color: #64748b !important;
            border: 1px solid rgba(100, 116, 139, 0.2);
        }

        .bg-primary {
            background-color: rgba(99, 102, 241, 0.1) !important;
            color: #6366f1 !important;
            border: 1px solid rgba(99, 102, 241, 0.2);
        }

        /* Custom scrollbars */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: var(--bg-body);
        }
        
        ::-webkit-scrollbar-thumb {
            background: var(--border-color);
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: var(--text-muted);
        }

        .pulse-circle {
            display: inline-block;
            width: 8px;
            height: 8px;
            background-color: #10b981;
            border-radius: 50%;
            margin-right: 6px;
            box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
            animation: pulsing 1.2s infinite;
            vertical-align: middle;
        }

        @keyframes pulsing {
            0% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
            }
            70% {
                transform: scale(1);
                box-shadow: 0 0 0 6px rgba(16, 185, 129, 0);
            }
            100% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(16, 185, 129, 0);
            }
        }
    </style>

    @stack('styles')

</head>

<body>

<div id="loader">

    <div class="loader-spinner"></div>
    <div class="loader-text">CONNECTING SUPPLY CHAIN CHANNELS...</div>

</div>

<nav class="navbar navbar-expand-lg navbar-dark">

    <div class="container">

        <a class="navbar-brand" href="/">
            🌍 Global Supply Chain Risk
        </a>

        <div class="ms-auto">

            <a href="/" class="btn btn-outline-light me-2">
                Dashboard
            </a>

            <a href="/analytics" class="btn btn-warning me-2">
                📊 Analytics
            </a>

            <a href="{{ route('ports') }}" class="btn btn-success me-2">
                🚢 Ports
            </a>

            <a href="{{ route('news') }}" class="btn btn-info me-2">
                📰 News
            </a>

            <button
                id="darkModeBtn"
                class="btn btn-outline-light">

                🌙 Dark Mode

            </button>

        </div>

    </div>

</nav>

<div class="container py-4">

    @yield('content')

</div>

<footer>

Global Supply Chain Risk Intelligence Platform © {{ date('Y') }}

</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script src="https://unpkg.com/leaflet.markercluster@1.5.3/dist/leaflet.markercluster.js"></script>

<script>

window.onload=function(){

document.getElementById("loader").style.display="none";

}

const body=document.body;

const btn=document.getElementById("darkModeBtn");

if(localStorage.getItem("theme")==="dark"){

body.classList.add("bg-dark","text-white");

btn.innerHTML="☀ Light Mode";

}

btn.addEventListener("click",()=>{

body.classList.toggle("bg-dark");

body.classList.toggle("text-white");

if(body.classList.contains("bg-dark")){

localStorage.setItem("theme","dark");

btn.innerHTML="☀ Light Mode";

}else{

localStorage.setItem("theme","light");

btn.innerHTML="🌙 Dark Mode";

}

});

</script>

<!-- Toast tetap -->

<div class="toast-container position-fixed top-0 end-0 p-3">

<div id="riskToast" class="toast text-bg-danger border-0">

<div class="d-flex">

<div class="toast-body">

<strong>⚠ High Risk Alert</strong>

<div id="toastMessage"></div>

</div>

<button class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>

</div>

</div>

</div>

<script>

let lastHighRisk=null;

function checkHighRisk(){

fetch('/api/high-risk')

.then(r=>r.json())

.then(data=>{

if(lastHighRisk===null){

lastHighRisk=data.map(x=>x.id);

return;

}

data.forEach(item=>{

if(!lastHighRisk.includes(item.id)){

lastHighRisk.push(item.id);

document.getElementById("toastMessage").innerHTML=

"<strong>"+item.country.name+"</strong><br>Risk Score : "+item.total_score;

new bootstrap.Toast(document.getElementById("riskToast")).show();

}

});

});

}

checkHighRisk();

setInterval(checkHighRisk,30000);

</script>

@stack('scripts')

</body>
</html>