<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard') - EcoEvents</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Leaflet CSS for maps -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    
    @stack('styles')
    
    <style>
        :root {
            --primary-green: #059669;
            --secondary-green: #10b981;
            --accent-orange: #f97316;
            --light-gray: #f8f9fa;
            --dark-gray: #343a40;
        }

        body {
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Mobile sidebar toggle
        document.addEventListener('DOMContentLoaded', function() {
            const mobileToggle = document.getElementById('mobileMenuToggle');
            const sidebar = document.getElementById('sidebar');
            const sidebarOverlay = document.getElementById('sidebarOverlay');
            
            // Mobile toggle button functionality
            if (mobileToggle && sidebar) {
                mobileToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('show');
                    sidebarOverlay.classList.toggle('show');
                    
                    // Change icon
                    const icon = this.querySelector('i');
                    if (sidebar.classList.contains('show')) {
                        icon.className = 'fas fa-times';
                    } else {
                        icon.className = 'fas fa-bars';
                    }
                });
            }
            
            // Close sidebar when clicking overlay
            if (sidebarOverlay) {
                sidebarOverlay.addEventListener('click', function() {
                    sidebar.classList.remove('show');
                    sidebarOverlay.classList.remove('show');
                    const icon = mobileToggle.querySelector('i');
                    icon.className = 'fas fa-bars';
                });
            }
            
            // Close sidebar when clicking nav links on mobile
            const navLinks = document.querySelectorAll('.sidebar .nav-link');
            navLinks.forEach(link => {
                link.addEventListener('click', function() {
                    if (window.innerWidth <= 768) {
                        sidebar.classList.remove('show');
                        sidebarOverlay.classList.remove('show');
                        const icon = mobileToggle.querySelector('i');
                        icon.className = 'fas fa-bars';
                    }
                });
            });
            
            // Handle window resize
            window.addEventListener('resize', function() {
                if (window.innerWidth > 768) {
                    sidebar.classList.remove('show');
                    sidebarOverlay.classList.remove('show');
                    const icon = mobileToggle.querySelector('i');
                    icon.className = 'fas fa-bars';
                }
            });
            
            // Auto-hide alerts after 5 seconds
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    if (alert && alert.classList.contains('show')) {
                        alert.classList.remove('show');
                        setTimeout(() => alert.remove(), 150);
                    }
                }, 5000);
            });
            
            // Add fade-in animation to main content
            const mainContent = document.querySelector('.main-content');
            if (mainContent) {
                mainContent.classList.add('fade-in');
            }
            
            // Smooth scroll for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });
        });
    </script>
    
    @stack('scripts')
</body>
</html>nd-color: var(--light-gray);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .bg-primary-green {
            background-color: var(--primary-green) !important;
        }

        .bg-secondary-green {
            background-color: var(--secondary-green) !important;
        }

        .bg-accent-orange {
            background-color: var(--accent-orange) !important;
        }

        .text-primary-green {
            color: var(--primary-green) !important;
        }

        .text-secondary-green {
            color: var(--secondary-green) !important;
        }

        .text-accent-orange {
            color: var(--accent-orange) !important;
        }

        .btn-primary-green {
            background-color: var(--primary-green);
            border-color: var(--primary-green);
            color: white;
        }

        .btn-primary-green:hover {
            background-color: #047857;
            border-color: #047857;
            color: white;
        }

        .btn-outline-primary-green {
            color: var(--primary-green);
            border-color: var(--primary-green);
        }

        .btn-outline-primary-green:hover {
            background-color: var(--primary-green);
            border-color: var(--primary-green);
            color: white;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 100;
            width: 240px;
            padding: 0;
            box-shadow: 2px 0 10px rgba(0, 0, 0, .1);
            background: linear-gradient(180deg, var(--primary-green) 0%, var(--secondary-green) 100%);
        }

        .sidebar-sticky {
            position: sticky;
            top: 0;
            height: 100vh;
            padding-top: 0;
            overflow-x: hidden;
            overflow-y: auto;
            /* Add padding to prevent content from touching scrollbar */
            padding-right: 5px;
        }

        /* Enhanced Custom Scrollbar for Sidebar */
        .sidebar-sticky::-webkit-scrollbar {
            width: 12px;
            background: transparent;
        }

        .sidebar-sticky::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.15);
            border-radius: 10px;
            margin: 10px 0;
            border: 2px solid transparent;
            background-clip: padding-box;
        }

        .sidebar-sticky::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.5) 0%, rgba(255, 255, 255, 0.3) 100%);
            border-radius: 10px;
            border: 2px solid transparent;
            background-clip: padding-box;
            box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
        }

        .sidebar-sticky::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.7) 0%, rgba(255, 255, 255, 0.5) 100%);
            box-shadow: inset 0 0 8px rgba(0, 0, 0, 0.3);
            transform: scaleY(1.05);
        }

        .sidebar-sticky::-webkit-scrollbar-thumb:active {
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.9) 0%, rgba(255, 255, 255, 0.7) 100%);
        }

        /* Firefox Scrollbar - Enhanced */
        .sidebar-sticky {
            scrollbar-width: auto;
            scrollbar-color: rgba(255, 255, 255, 0.4) rgba(0, 0, 0, 0.15);
        }

        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            font-weight: 500;
            padding: 0.75rem 1rem;
            border-radius: 0;
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: white;
            background-color: rgba(255, 255, 255, 0.1);
            border-left: 4px solid var(--accent-orange);
        }

        .sidebar .nav-link i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }

        /* Main content */
        .main-content {
            margin-left: 240px;
            padding: 20px;
            min-height: 100vh;
        }

        /* Top navbar */
        .navbar-admin {
            background: white;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            padding: 0.5rem 1rem;
            position: fixed;
            top: 0;
            right: 0;
            left: 240px;
            z-index: 1030;
            height: 60px;
        }

        .content-wrapper {
            margin-top: 60px;
        }

        /* Cards */
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .card:hover {
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        /* Enhanced Statistics Cards */
        .transform-hover {
            transition: all 0.3s ease;
        }
        
        .transform-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15) !important;
        }
        
        .icon-circle {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .card-body {
            padding: 1.5rem;
        }
        
        .text-gray-800 {
            color: #2d3748 !important;
        }
        
        /* Enhanced buttons */
        .btn {
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        
        /* Enhanced form styling */
        .form-control {
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            border-color: var(--primary-green);
            box-shadow: 0 0 0 0.2rem rgba(5, 150, 105, 0.25);
        }
        
        /* Enhanced tables */
        .table {
            border-radius: 8px;
            overflow: hidden;
        }
        
        .table thead th {
            background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
            color: white;
            font-weight: 600;
            border: none;
        }
        
        .table tbody tr:hover {
            background-color: #f8fafc;
            transform: scale(1.01);
            transition: all 0.2s ease;
        }
        
        /* Enhanced gradients */
        .bg-gradient-primary {
            background: linear-gradient(135deg, #007bff, #0056b3);
        }
        
        .bg-gradient-success {
            background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
        }
        
        .bg-gradient-info {
            background: linear-gradient(135deg, #17a2b8, #138496);
        }
        
        .bg-gradient-warning {
            background: linear-gradient(135deg, var(--accent-orange), #e67e22);
        }
        
        .bg-gradient-secondary {
            background: linear-gradient(135deg, #6c757d, #5a6268);
        }
        
        .bg-gradient-dark {
            background: linear-gradient(135deg, #343a40, #23272b);
        }
        
        /* Unified Form Styling */
        .form-floating label {
            color: #6c757d;
            font-weight: 500;
        }
        
        .form-floating .form-control:focus ~ label {
            color: var(--primary-green);
        }
        
        .form-select {
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            transition: all 0.3s ease;
        }
        
        .form-select:focus {
            border-color: var(--primary-green);
            box-shadow: 0 0 0 0.2rem rgba(5, 150, 105, 0.25);
        }
        
        /* Modern Badge Styling */
        .badge {
            font-weight: 500;
            padding: 0.5rem 0.75rem;
            border-radius: 20px;
            font-size: 0.775em;
        }
        
        .badge-soft-success {
            background-color: rgba(5, 150, 105, 0.1);
            color: var(--primary-green);
        }
        
        .badge-soft-warning {
            background-color: rgba(249, 115, 22, 0.1);
            color: var(--accent-orange);
        }
        
        .badge-soft-info {
            background-color: rgba(23, 162, 184, 0.1);
            color: #17a2b8;
        }
        
        .badge-soft-danger {
            background-color: rgba(220, 53, 69, 0.1);
            color: #dc3545;
        }
        
        /* Action Button Groups */
        .action-buttons .btn {
            margin: 0 2px;
            min-width: 40px;
            height: 38px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        
        .action-buttons .btn-sm {
            min-width: 32px;
            height: 32px;
            font-size: 0.875rem;
        }
        
        /* Data Tables Enhancement */
        .table-responsive {
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }
        
        .table th {
            font-weight: 600;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 1rem 0.75rem;
        }
        
        .table td {
            padding: 1rem 0.75rem;
            vertical-align: middle;
        }
        
        .table tbody tr:hover {
            background-color: rgba(5, 150, 105, 0.02);
        }
        
        /* Pagination Styling */
        .pagination .page-link {
            border-radius: 8px;
            margin: 0 2px;
            border: 1px solid #e2e8f0;
            color: #6c757d;
            font-weight: 500;
        }
        
        .pagination .page-link:hover {
            background-color: var(--primary-green);
            border-color: var(--primary-green);
            color: white;
        }
        
        .pagination .page-item.active .page-link {
            background-color: var(--primary-green);
            border-color: var(--primary-green);
        }
        
        /* Alert Styling */
        .alert {
            border-radius: 12px;
            border: none;
            padding: 1rem 1.25rem;
            margin-bottom: 1.5rem;
            font-weight: 500;
        }
        
        .alert-success {
            background-color: rgba(5, 150, 105, 0.1);
            color: var(--primary-green);
            border-left: 4px solid var(--primary-green);
        }
        
        .alert-danger {
            background-color: rgba(220, 53, 69, 0.1);
            color: #dc3545;
            border-left: 4px solid #dc3545;
        }
        
        .alert-warning {
            background-color: rgba(249, 115, 22, 0.1);
            color: var(--accent-orange);
            border-left: 4px solid var(--accent-orange);
        }
        
        .alert-info {
            background-color: rgba(23, 162, 184, 0.1);
            color: #17a2b8;
            border-left: 4px solid #17a2b8;
        }
        
        /* Search and Filter Bar */
        .search-filter-bar {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            margin-bottom: 1.5rem;
        }
        
        .search-filter-bar .form-control {
            border-radius: 25px;
            padding-left: 2.5rem;
        }
        
        .search-filter-bar .search-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
        }
        
        /* Empty State Styling */
        .empty-state {
            text-align: center;
            padding: 3rem 2rem;
            color: #6c757d;
        }
        
        .empty-state i {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }
        
        .empty-state h5 {
            margin-bottom: 0.5rem;
            color: #495057;
        }
        
        .empty-state p {
            margin-bottom: 1.5rem;
        }
        
        /* Stats Card Enhancement */
        .stats-card {
            background: white;
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 2px 12px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .stats-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }
        
        .stats-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--primary-green);
        }
        
        .stats-card.warning::before {
            background: var(--accent-orange);
        }
        
        .stats-card.info::before {
            background: #17a2b8;
        }
        
        .stats-card.danger::before {
            background: #dc3545;
        }
        
        /* Button block utility */
        .btn-block {
            display: block;
            width: 100%;
        }
        
        /* Loading states and animations */
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        
        .pulse {
            animation: pulse 2s infinite;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .fade-in {
            animation: fadeIn 0.5s ease-out;
        }
        
        /* Page Header Styling */
        .page-header {
            background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
            color: white;
            padding: 2rem 0;
            margin: -20px -20px 2rem -20px;
            border-radius: 0 0 20px 20px;
        }
        
        .page-header h1 {
            margin-bottom: 0.5rem;
            font-weight: 600;
        }
        
        .page-header p {
            opacity: 0.9;
            margin-bottom: 0;
        }
        
        .page-header .btn {
            background: rgba(255,255,255,0.2);
            border: 1px solid rgba(255,255,255,0.3);
            color: white;
            backdrop-filter: blur(10px);
        }
        
        .page-header .btn:hover {
            background: rgba(255,255,255,0.3);
            border-color: rgba(255,255,255,0.5);
            color: white;
        }
        
        /* Responsive improvements */
        @media (max-width: 768px) {
            .stats-card {
                margin-bottom: 1rem;
            }
            
            .action-buttons {
                display: flex;
                flex-wrap: wrap;
                gap: 0.25rem;
            }
            
            .search-filter-bar {
                padding: 1rem;
            }
            
            .table-responsive {
                font-size: 0.875rem;
            }
        }
        
        /* Mobile Menu Toggle */
        .mobile-menu-toggle {
            display: none;
            position: fixed;
            top: 15px;
            left: 15px;
            z-index: 1051;
            background: var(--primary-green);
            color: white;
            border: none;
            width: 45px;
            height: 45px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            transition: all 0.3s ease;
        }

        .mobile-menu-toggle:hover {
            background: var(--secondary-green);
            transform: scale(1.05);
        }

        @media (max-width: 768px) {
            .mobile-menu-toggle {
                display: flex;
                align-items: center;
                justify-content: center;
            }
            
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
                z-index: 1050;
            }
            
            .sidebar.show {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
                padding: 15px;
            }
            
            .navbar-admin {
                left: 0;
                margin-top: 0;
            }
            
            .content-wrapper {
                margin-top: 80px;
            }
            
            .page-header {
                margin: -15px -15px 1.5rem -15px;
                padding: 1.5rem 1rem;
            }
        }

        /* Sidebar overlay for mobile */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1049;
        }

        @media (max-width: 768px) {
            .sidebar-overlay.show {
                display: block;
            }
        }

        .card-header {
            border-bottom: none;
            border-radius: 8px 8px 0 0 !important;
            font-weight: 600;
        }

        /* Logo */
        .logo {
            padding: 1rem;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 1rem;
        }

        .logo h4 {
            color: white;
            margin: 0;
            font-weight: bold;
        }

        .logo i {
            color: var(--accent-orange);
            margin-right: 8px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }
            
            .sidebar.show {
                transform: translateX(0);
            }
            
            .main-content,
            .navbar-admin {
                margin-left: 0;
                left: 0;
            }
        }

        /* Breadcrumb */
        .breadcrumb {
            background: transparent;
            padding: 0;
            margin-bottom: 1rem;
        }

        .breadcrumb-item + .breadcrumb-item::before {
            color: #6c757d;
        }

        /* Custom table styles */
        .table th {
            border-top: none;
            font-weight: 600;
            color: var(--dark-gray);
        }

        /* Progress bars */
        .progress {
            height: 8px;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <!-- Mobile Menu Toggle -->
    <button class="mobile-menu-toggle d-md-none" id="mobileMenuToggle">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Sidebar Overlay for Mobile -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Sidebar -->
    <nav class="sidebar" id="sidebar">
        <div class="logo">
            <h4>
                <i class="fas fa-rocket"></i>
                EcoEvents
            </h4>
            <small class="text-white-50">Admin Panel</small>
        </div>
        <div class="sidebar-sticky">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" 
                       href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-tachometer-alt"></i>
                        Dashboard
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.events.*') ? 'active' : '' }}" 
                       href="{{ route('admin.events.index') }}">
                        <i class="fas fa-calendar-alt"></i>
                        Events Management
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" 
                       href="{{ route('admin.users.index') }}">
                        <i class="fas fa-users"></i>
                        Users Management
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.registrations.*') ? 'active' : '' }}" 
                       href="{{ route('admin.registrations.index') }}">
                        <i class="fas fa-clipboard-list"></i>
                        Registrations
                    </a>
                </li>
                
                <hr class="my-3" style="border-color: rgba(255,255,255,0.2);">
                <li class="nav-item">
                    <small class="text-white-50 px-3 d-block mb-2 mt-2" style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">E-Commerce</small>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.sponsors.*') ? 'active' : '' }}" 
                       href="{{ route('admin.sponsors.index') }}">
                        <i class="fas fa-handshake"></i>
                        Sponsors
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.produits.*') ? 'active' : '' }}" 
                       href="{{ route('admin.produits.index') }}">
                        <i class="fas fa-box"></i>
                        Products
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.materiels.*') ? 'active' : '' }}" 
                       href="{{ route('admin.materiels.index') }}">
                        <i class="fas fa-tools"></i>
                        Materials
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.panier.*') ? 'active' : '' }}" 
                       href="{{ route('admin.panier.index') }}">
                        <i class="fas fa-shopping-cart"></i>
                        Cart Orders
                    </a>
                </li>
                
                <hr class="my-3" style="border-color: rgba(255,255,255,0.2);">
                <li class="nav-item">
                    <small class="text-white-50 px-3 d-block mb-2 mt-2" style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">Configuration</small>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}" 
                       href="{{ route('admin.categories.index') }}">
                        <i class="fas fa-tags"></i>
                        Categories
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.venues.*') ? 'active' : '' }}" 
                       href="{{ route('admin.venues.index') }}">
                        <i class="fas fa-map-marker-alt"></i>
                        Venues
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.positions.*') ? 'active' : '' }}" 
                       href="{{ route('admin.positions.index') }}">
                        <i class="fas fa-user-cog"></i>
                        Positions
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.avis.*') ? 'active' : '' }}" 
                       href="{{ route('admin.avis.index') }}">
                        <i class="fas fa-star"></i>
                        Avis
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.commentaires.*') ? 'active' : '' }}" 
                       href="{{ route('admin.commentaires.index') }}">
                        <i class="fas fa-comments"></i>
                        Commentaires
                    </a>
                </li>
                
                <hr class="my-3" style="border-color: rgba(255,255,255,0.2);">
                
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}" target="_blank">
                        <i class="fas fa-external-link-alt"></i>
                        View Site
                    </a>
                </li>
                
                <li class="nav-item">
                    <form action="{{ route('logout') }}" method="POST" class="d-inline w-100">
                        @csrf
                        <button type="submit" class="nav-link border-0 bg-transparent text-start w-100 text-white-50">
                            <i class="fas fa-sign-out-alt"></i>
                            Logout
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Top Navbar -->
    <nav class="navbar navbar-expand-lg navbar-admin">
        <div class="container-fluid">
            <div class="d-flex align-items-center">
                <span class="navbar-text text-muted me-3">
                    Welcome, {{ Auth::user()->name }}
                </span>
            </div>
            
            <div class="navbar-nav ms-auto">
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" 
                       id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                        <div class="icon-circle bg-primary me-2" style="width: 32px; height: 32px;">
                            <i class="fas fa-user text-white"></i>
                        </div>
                        <span class="d-none d-sm-inline">{{ Auth::user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="{{ route('home') }}" target="_blank">
                                <i class="fas fa-external-link-alt me-2"></i>View Site
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main-content">
        <div class="content-wrapper">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Leaflet JS for maps -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    
    <script>
        // Mobile sidebar toggle
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.querySelector('.navbar-toggler');
            const sidebar = document.querySelector('.sidebar');
            
            if (sidebarToggle && sidebar) {
                sidebarToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('show');
                });
            }
        });
    </script>
    
    @stack('scripts')
    @yield('scripts')
</body>
</html>