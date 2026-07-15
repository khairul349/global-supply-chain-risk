<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Global Supply Chain Risk Platform</title>

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
            --bg-body: radial-gradient(circle at 10% 20%, #1c0f38 0%, #0d061c 50%, #05020c 100%);
            --bg-card: rgba(255, 255, 255, 0.02);
            --border-color: rgba(255, 255, 255, 0.06);
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
            --accent-primary: linear-gradient(135deg, #8b5cf6, #a78bfa);
            --shadow-card: 0 8px 32px 0 rgba(0, 0, 0, 0.3);
            --input-bg: rgba(255, 255, 255, 0.02);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg-body) !important;
            color: var(--text-main) !important;
            transition: background-color 0.4s ease, color 0.4s ease;
            overflow-x: hidden;
            min-height: 100vh;
        }

        /* Responsive Wrapper Layout */
        #wrapper {
            display: flex;
            width: 100vw;
            min-height: 100vh;
            align-items: stretch;
        }

        /* Sidebar Styling (Glassmorphism) */
        #sidebar-wrapper {
            min-width: 280px;
            max-width: 280px;
            background: rgba(10, 5, 20, 0.6);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-right: 1px solid rgba(255, 255, 255, 0.06);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 1000;
            display: flex;
            flex-direction: column;
        }

        .sidebar-brand {
            padding: 24px;
            display: flex;
            align-items: center;
            gap: 12px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
        }

        .brand-logo {
            flex-shrink: 0;
        }

        .brand-text {
            display: flex;
            flex-direction: column;
        }

        .brand-title {
            font-size: 17px;
            font-weight: 800;
            color: #ffffff;
            letter-spacing: 0.5px;
            line-height: 1.2;
        }

        .brand-subtitle {
            font-size: 9px;
            font-weight: 800;
            color: #a78bfa;
            letter-spacing: 1.5px;
            text-transform: uppercase;
        }

        .sidebar-nav {
            padding: 20px 14px;
            flex-grow: 1;
            overflow-y: auto;
        }

        .nav-section-title {
            font-size: 10px;
            font-weight: 700;
            color: rgba(255, 255, 255, 0.35);
            letter-spacing: 1.2px;
            margin-top: 24px;
            margin-bottom: 8px;
            padding-left: 12px;
            text-transform: uppercase;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 16px;
            color: rgba(255, 255, 255, 0.65);
            font-size: 13.5px;
            font-weight: 600;
            text-decoration: none;
            border-radius: 12px;
            margin-bottom: 4px;
            transition: all 0.2s ease;
            cursor: pointer;
            border: 1px solid transparent;
        }

        .nav-item:hover {
            background: rgba(255, 255, 255, 0.04);
            color: #ffffff;
            border-color: rgba(255, 255, 255, 0.04);
        }

        .nav-item.active {
            background: rgba(139, 92, 246, 0.12);
            color: #c084fc;
            border: 1px solid rgba(139, 92, 246, 0.2);
        }

        .nav-icon {
            font-size: 16px;
            width: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .disabled-nav-item {
            opacity: 0.4;
            cursor: not-allowed;
        }

        .disabled-nav-item:hover {
            background: transparent;
            color: rgba(255, 255, 255, 0.65);
            border-color: transparent;
        }

        /* Page Content Wrapper */
        #page-content-wrapper {
            flex: 1;
            display: flex;
            flex-direction: column;
            min-width: 0; /* Prevents flex items from overflowing */
        }

        /* Topbar Styling (Glassmorphism) */
        .top-navbar {
            background: rgba(10, 5, 20, 0.3);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 30px;
            min-height: 75px;
            gap: 20px;
        }

        .btn-toggle-sidebar {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 10px;
            color: #ffffff;
            cursor: pointer;
            display: none;
            padding: 8px 12px;
            transition: all 0.2s ease;
        }

        .btn-toggle-sidebar:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        .search-wrapper {
            flex: 1;
            max-width: 400px;
        }

        .search-input {
            width: 100%;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 12px;
            padding: 9px 16px;
            font-size: 13.5px;
            color: #ffffff;
            transition: all 0.2s ease;
        }

        .search-input::placeholder {
            color: rgba(255, 255, 255, 0.3);
        }

        .search-input:focus {
            outline: none;
            border-color: rgba(139, 92, 246, 0.5);
            box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.15);
        }

        .topbar-utilities {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        /* Glass Buttons */
        .btn-glass {
            background: rgba(255, 255, 255, 0.04) !important;
            backdrop-filter: blur(8px) !important;
            -webkit-backdrop-filter: blur(8px) !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            border-radius: 12px !important;
            color: #ffffff !important;
            font-size: 13px !important;
            font-weight: 600 !important;
            padding: 9px 18px !important;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1) !important;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1) !important;
        }

        .btn-glass:hover {
            background: rgba(255, 255, 255, 0.12) !important;
            border-color: rgba(255, 255, 255, 0.25) !important;
            box-shadow: 0 0 15px rgba(139, 92, 246, 0.45) !important;
            transform: translateY(-1.5px) !important;
        }

        .notification-bell {
            position: relative;
            color: rgba(255, 255, 255, 0.6);
            cursor: pointer;
            transition: color 0.2s ease;
            padding: 4px;
        }

        .notification-bell:hover {
            color: #ffffff;
        }

        .bell-badge {
            position: absolute;
            top: -2px;
            right: -2px;
            background: #ff7a00;
            color: #ffffff;
            font-size: 9px;
            font-weight: 700;
            padding: 2px 5px;
            border-radius: 6px;
            line-height: 1;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 12px;
            border-left: 1px solid rgba(255, 255, 255, 0.08);
            padding-left: 16px;
        }

        .user-avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: linear-gradient(135deg, #a78bfa, #8b5cf6);
            color: #ffffff;
            font-size: 13px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid rgba(255, 255, 255, 0.15);
        }

        .user-info {
            display: flex;
            flex-direction: column;
        }

        .user-name {
            font-size: 13px;
            font-weight: 700;
            color: #ffffff;
            line-height: 1.2;
        }

        .user-role {
            font-size: 10px;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.4);
        }

        /* Glassmorphism Cards */
        .card {
            background: rgba(255, 255, 255, 0.02) !important;
            backdrop-filter: blur(16px) !important;
            -webkit-backdrop-filter: blur(16px) !important;
            border: 1px solid rgba(255, 255, 255, 0.05) !important;
            border-radius: 20px !important;
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.3) !important;
            color: #ffffff !important;
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1), box-shadow 0.3s cubic-bezier(0.4, 0, 0.2, 1), border-color 0.3s ease !important;
        }

        .card:hover {
            transform: translateY(-4px) !important;
            border-color: rgba(139, 92, 246, 0.2) !important;
            box-shadow: 0 12px 40px rgba(139, 92, 246, 0.15) !important;
        }

        .card-header {
            background: transparent !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.06) !important;
            color: #ffffff !important;
            font-weight: 700 !important;
            font-size: 16px !important;
            padding: 20px 24px !important;
        }

        .card-body {
            padding: 24px !important;
        }

        /* Input overrides */
        .form-control, .form-select {
            background-color: rgba(255, 255, 255, 0.03) !important;
            border: 1px solid rgba(255, 255, 255, 0.08) !important;
            color: #ffffff !important;
            border-radius: 12px !important;
            padding: 10px 16px !important;
        }

        .form-control:focus, .form-select:focus {
            box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.2) !important;
            border-color: rgba(139, 92, 246, 0.4) !important;
        }

        /* Buttons overrides across the whole site to exhibit glass effect */
        .btn, .navbar .btn {
            border-radius: 12px !important;
            font-weight: 600 !important;
            font-size: 13.5px !important;
            padding: 10px 18px !important;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1) !important;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            background: rgba(255, 255, 255, 0.04) !important;
            backdrop-filter: blur(8px) !important;
            -webkit-backdrop-filter: blur(8px) !important;
            border: 1px solid rgba(255, 255, 255, 0.08) !important;
            color: #ffffff !important;
        }

        .btn:hover, .navbar .btn:hover {
            background: rgba(255, 255, 255, 0.12) !important;
            border-color: rgba(255, 255, 255, 0.25) !important;
            box-shadow: 0 0 15px rgba(139, 92, 246, 0.45) !important;
            transform: translateY(-2px) !important;
            color: #ffffff !important;
        }

        /* Specific glows based on button overrides */
        .btn-primary:hover {
            box-shadow: 0 0 20px rgba(99, 102, 241, 0.5) !important;
        }
        .btn-success:hover {
            box-shadow: 0 0 20px rgba(16, 185, 129, 0.5) !important;
        }
        .btn-warning:hover {
            box-shadow: 0 0 20px rgba(245, 158, 11, 0.5) !important;
        }
        .btn-info:hover {
            box-shadow: 0 0 20px rgba(6, 182, 212, 0.5) !important;
        }

        /* Tables styling */
        .table {
            background: transparent !important;
            color: rgba(255, 255, 255, 0.9) !important;
        }

        .table > :not(caption) > * > * {
            background-color: transparent !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.06) !important;
            color: rgba(255, 255, 255, 0.9) !important;
            padding: 14px 16px !important;
        }

        .table-hover tbody tr:hover td {
            color: #ffffff !important;
            background-color: rgba(255, 255, 255, 0.02) !important;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        ::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.15);
        }
        ::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.06);
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.15);
        }

        /* Main Content wrapper */
        .main-content {
            padding: 35px 30px;
            flex: 1;
            overflow-y: auto;
        }

        footer {
            margin-top: auto;
            padding: 30px;
            text-align: center;
            color: var(--text-muted);
            border-top: 1px solid rgba(255, 255, 255, 0.05);
            font-size: 13.5px;
            font-weight: 500;
            background: rgba(10, 5, 20, 0.15);
        }

        /* Modern Blur Loader */
        #loader {
            position: fixed;
            width: 100%;
            height: 100%;
            background: #0d061c;
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
            border: 4px solid rgba(255, 255, 255, 0.1);
            border-bottom-color: #8b5cf6;
            border-radius: 50%;
            display: inline-block;
            box-sizing: border-box;
            animation: rotation 1s linear infinite;
        }

        @keyframes rotation {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .loader-text {
            font-size: 13px;
            font-weight: 700;
            letter-spacing: 0.1em;
            color: #a78bfa;
            animation: pulse-glow 1.5s ease-in-out infinite;
        }

        @keyframes pulse-glow {
            0%, 100% { opacity: 0.6; }
            50% { opacity: 1; }
        }

        .pulse-circle {
            display: inline-block;
            width: 8px;
            height: 8px;
            background-color: #10b981;
            border-radius: 50%;
            margin-right: 8px;
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

        /* Badges */
        .badge {
            font-weight: 700 !important;
            padding: 6px 12px !important;
            border-radius: 8px !important;
            font-size: 11px !important;
            border: 1px solid transparent !important;
        }

        .bg-danger {
            background-color: rgba(239, 68, 68, 0.15) !important;
            color: #f87171 !important;
            border-color: rgba(239, 68, 68, 0.25) !important;
        }

        .bg-warning {
            background-color: rgba(245, 158, 11, 0.15) !important;
            color: #fbbf24 !important;
            border-color: rgba(245, 158, 11, 0.25) !important;
        }

        .bg-success {
            background-color: rgba(16, 185, 129, 0.15) !important;
            color: #34d399 !important;
            border-color: rgba(16, 185, 129, 0.25) !important;
        }

        .bg-secondary {
            background-color: rgba(100, 116, 139, 0.15) !important;
            color: #94a3b8 !important;
            border-color: rgba(100, 116, 139, 0.25) !important;
        }

        .bg-primary {
            background-color: rgba(139, 92, 246, 0.15) !important;
            color: #c084fc !important;
            border-color: rgba(139, 92, 246, 0.25) !important;
        }

        /* Leaflet Map overrides for glass theme */
        .leaflet-container {
            font-family: inherit !important;
            background: #0d061c !important;
        }

        .leaflet-bar {
            border: 1px solid rgba(255, 255, 255, 0.08) !important;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3) !important;
            border-radius: 10px !important;
            overflow: hidden;
        }

        .leaflet-bar a {
            background-color: rgba(20, 10, 35, 0.8) !important;
            backdrop-filter: blur(10px);
            color: #ffffff !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08) !important;
            transition: all 0.2s ease;
        }

        .leaflet-bar a:hover {
            background-color: rgba(139, 92, 246, 0.2) !important;
            color: #c084fc !important;
        }

        /* Responsive Layout Behavior */
        @media (max-width: 991px) {
            #sidebar-wrapper {
                margin-left: -280px;
                position: absolute;
                top: 0;
                bottom: 0;
                height: 100vh;
            }
            #wrapper.toggled #sidebar-wrapper {
                margin-left: 0;
            }
            .btn-toggle-sidebar {
                display: flex;
                align-items: center;
                justify-content: center;
            }
            .top-navbar {
                padding: 16px 20px;
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

<div id="wrapper">

    <!-- Sidebar Wrapper -->
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <svg class="brand-logo" width="24" height="28" viewBox="0 0 24 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 0L2 4V13C2 19.3 6.3 25.1 12 28C17.7 25.1 22 19.3 22 13V4L12 0Z" fill="#ff7a00"/>
                <path d="M12 2.5L3.8 5.8V13.2C3.8 18.5 7.4 23.3 12 25.8V2.5Z" fill="#ff9900"/>
            </svg>
            <div class="brand-text">
                <span class="brand-title" style="font-size: 15px;">Global Supply Chain</span>
                <span class="brand-subtitle">Risk</span>
            </div>
        </div>

        <nav class="sidebar-nav">
            <div class="nav-section-title">Main Control</div>
            
            <a href="{{ url('/') }}" class="nav-item {{ Request::is('/') ? 'active' : '' }}">
                <span class="nav-icon">🎛️</span> Dashboard
            </a>
            
            <a href="{{ url('/countries') }}" class="nav-item {{ Request::is('countries') ? 'active' : '' }}">
                <span class="nav-icon">🗺️</span> Countries
            </a>
            
            <a href="{{ route('weather') }}" class="nav-item {{ Request::is('weather') ? 'active' : '' }}">
                <span class="nav-icon">⛅</span> Weather
            </a>
            
            <a href="{{ url('/economy') }}" class="nav-item {{ Request::is('economy') ? 'active' : '' }}">
                <span class="nav-icon">📈</span> Economy
            </a>
            
            <a href="{{ url('/currency') }}" class="nav-item {{ Request::is('currency') ? 'active' : '' }}">
                <span class="nav-icon">💵</span> Currency
            </a>
            
            <a href="{{ route('ports') }}" class="nav-item {{ Request::is('ports') ? 'active' : '' }}">
                <span class="nav-icon">🚢</span> Ports
            </a>
            
            <a href="{{ route('news') }}" class="nav-item {{ Request::is('news') ? 'active' : '' }}">
                <span class="nav-icon">📰</span> News & Events
            </a>

            <div class="nav-section-title">Analytics</div>
            
            <a href="{{ url('/analytics') }}" class="nav-item {{ Request::is('analytics') ? 'active' : '' }}">
                <span class="nav-icon">📊</span> Risk Scores
            </a>
            
            <a href="{{ url('/watchlist') }}" class="nav-item {{ Request::is('watchlist') ? 'active' : '' }}">
                <span class="nav-icon">📋</span> Watchlist
            </a>
            
            <a href="{{ url('/compare') }}" class="nav-item {{ Request::is('compare') ? 'active' : '' }}">
                <span class="nav-icon">🔀</span> Compare
            </a>
            
            <a href="#" class="nav-item disabled-nav-item">
                <span class="nav-icon">🌍</span> Global Map
            </a>

            <div class="nav-section-title">Account</div>
            
            <a href="#" class="nav-item" id="darkModeBtn">
                <span class="nav-icon">🌙</span> Dark Mode
            </a>
            
            <a href="#" class="nav-item disabled-nav-item">
                <span class="nav-icon">⚙️</span> Settings
            </a>
            
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
            <a href="#" class="nav-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <span class="nav-icon">🚪</span> Logout
            </a>
        </nav>
    </aside>

    <!-- Page Content Wrapper -->
    <div id="page-content-wrapper">
        
        <!-- Top Navbar -->
        <header class="top-navbar">
            
            <!-- Menu Toggle Button (Mobile) -->
            <button class="btn-toggle-sidebar" id="menu-toggle">
                <svg viewBox="0 0 24 24" width="22" height="22" fill="currentColor">
                    <path d="M3,6H21V8H3V6M3,11H21V13H3V11M3,16H21V18H3V16Z"/>
                </svg>
            </button>
            
            <!-- Search bar -->
            <div class="search-wrapper">
                <input type="text" class="search-input" placeholder="Search countries, ports...">
            </div>

            <!-- Utilities -->
            <div class="topbar-utilities">
                
                @if(auth()->check() && auth()->user()->role === 'admin')
                    <!-- Sync APIs Button (Glass effect) -->
                    <button class="btn-glass" onclick="location.reload();">
                        🔄 Sync APIs
                    </button>
                @endif

                <!-- Notification Bell -->
                <div class="notification-bell">
                    <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor">
                        <path d="M12,2A2,2 0 0,0 10,4A2,2 0 0,0 10,4.29C7.12,5.14 5,7.82 5,11V17L3,19V20H21V19L19,17V11C19,7.82 16.88,5.14 14,4.29A2,2 0 0,0 14,4A2,2 0 0,0 12,2M12,22A2,2 0 0,0 14,20H10A2,2 0 0,0 12,22Z"/>
                    </svg>
                    <span class="bell-badge">9+</span>
                </div>

                <!-- User Profile -->
                @if(auth()->check())
                    <div class="user-profile">
                        <div class="user-avatar">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <div class="user-info d-none d-sm-flex">
                            <span class="user-name">{{ auth()->user()->name }}</span>
                            <span class="user-role">{{ auth()->user()->role === 'admin' ? 'Administrator' : 'Standard User' }}</span>
                        </div>
                    </div>
                @endif


            </div>

        </header>

        <!-- Main Content Body -->
        <main class="main-content">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer>
            SupplyGuard Risk Intelligence Platform © {{ date('Y') }}
        </footer>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet.markercluster@1.5.3/dist/leaflet.markercluster.js"></script>

<script>
    // Hide Loader
    window.onload = function() {
        document.getElementById("loader").style.display = "none";
    }

    // Toggle Sidebar (Mobile)
    const wrapper = document.getElementById("wrapper");
    const menuToggle = document.getElementById("menu-toggle");
    if (menuToggle) {
        menuToggle.addEventListener("click", function(e) {
            e.preventDefault();
            wrapper.classList.toggle("toggled");
        });
    }

    // Dark Mode Theme toggle logic
    const body = document.body;
    const btn = document.getElementById("darkModeBtn");
    
    // Set theme text correctly on load
    if (localStorage.getItem("theme") === "dark") {
        body.classList.add("bg-dark", "text-white");
        btn.innerHTML = '<span class="nav-icon">☀</span> Light Mode';
    } else {
        btn.innerHTML = '<span class="nav-icon">🌙</span> Dark Mode';
    }

    btn.addEventListener("click", (e) => {
        e.preventDefault();
        body.classList.toggle("bg-dark");
        body.classList.toggle("text-white");
        
        if (body.classList.contains("bg-dark")) {
            localStorage.setItem("theme", "dark");
            btn.innerHTML = '<span class="nav-icon">☀</span> Light Mode';
        } else {
            localStorage.setItem("theme", "light");
            btn.innerHTML = '<span class="nav-icon">🌙</span> Dark Mode';
        }
    });
</script>

<!-- High Risk Alerts Toast -->
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
    let lastHighRisk = null;

    function checkHighRisk() {
        fetch("{{ url('/api/high-risk') }}")
            .then(r => r.json())
            .then(data => {
                if (lastHighRisk === null) {
                    lastHighRisk = data.map(x => x.id);
                    return;
                }
                data.forEach(item => {
                    if (!lastHighRisk.includes(item.id)) {
                        lastHighRisk.push(item.id);
                        document.getElementById("toastMessage").innerHTML =
                            "<strong>" + item.country.name + "</strong><br>Risk Score : " + item.total_score;
                        new bootstrap.Toast(document.getElementById("riskToast")).show();
                    }
                });
            });
    }

    checkHighRisk();
    setInterval(checkHighRisk, 30000);

    function toggleWatchlistGlobal(countryId, callback) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
        const url = "{{ url('/watchlist/toggle') }}/" + countryId;
        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            }
        })
        .then(r => r.json())
        .then(res => {
            if (res.success) {
                if (typeof callback === 'function') {
                    callback(res.watchlisted, res.message);
                }
            } else {
                alert(res.message || 'Error updating watchlist');
            }
        })
        .catch(err => {
            console.error(err);
            alert('An error occurred while updating watchlist.');
        });
    }
</script>

@stack('scripts')

</body>
</html>