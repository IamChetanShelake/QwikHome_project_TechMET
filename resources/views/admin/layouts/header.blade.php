<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QwikHome - Admin Panel</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="logo">
                <img src="{{ asset('images/qwikhome-logo-white.svg') }}" alt="QwikHome" class="logo-image">
            </div>
            <button class="sidebar-toggle" id="sidebarToggle">
                <i class="fas fa-bars"></i>
            </button>
        </div>

        <nav class="sidebar-nav">
            <ul>
                <li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }} ">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link" data-section="dashboard">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('customers') }}" class="nav-link">
                        <i class="fas fa-users"></i>
                        <span>Customer Management</span>
                    </a>
                </li>
                <li class="nav-item">
                    <div class="service-menu">
                        <a href="#" class="nav-link service-menu-trigger">
                            <i class="fas fa-cogs"></i>
                            <span>Service Management</span>
                            <i class="fas fa-caret-down ml-1"></i>
                        </a>
                        <div class="service-dropdown-menu">
                            <a href="{{ route('services.services.index') }}" class="dropdown-item">Services</a>
                            <a href="{{ route('services.categories.index') }}" class="dropdown-item">Categories</a>
                            <a href="{{ route('services.subcategories.index') }}" class="dropdown-item">Subcategories</a>
                        </div>
                    </div>
                </li>
                <li class="nav-item">
                    <a href="#bookings" class="nav-link" data-section="bookings">
                        <i class="fas fa-calendar-check"></i>
                        <span>Booking Management</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#finance" class="nav-link" data-section="finance">
                        <i class="fas fa-wallet"></i>
                        <span>Finance & Wallet</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#promotions" class="nav-link" data-section="promotions">
                        <i class="fas fa-tags"></i>
                        <span>Coupons & Promotions</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#notifications" class="nav-link" data-section="notifications">
                        <i class="fas fa-bell"></i>
                        <span>Notifications</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#reports" class="nav-link" data-section="reports">
                        <i class="fas fa-chart-bar"></i>
                        <span>Reports & Analytics</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#complaints" class="nav-link" data-section="complaints">
                        <i class="fas fa-exclamation-triangle"></i>
                        <span>Complaints</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#content" class="nav-link" data-section="content">
                        <i class="fas fa-edit"></i>
                        <span>Content Management</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#leads" class="nav-link" data-section="leads">
                        <i class="fas fa-user-plus"></i>
                        <span>Lead Management</span>
                    </a>
                </li>
            </ul>
        </nav>

        {{-- <div class="sidebar-footer">
            <div class="user-info">
                <div class="user-avatar">
                    <i class="fas fa-user-shield"></i>
                </div>
                <div class="user-details">
                    <span class="user-name">Admin User</span>
                    <span class="user-role">Super Admin</span>
                </div>
            </div>
            <button class="logout-btn">
                <i class="fas fa-sign-out-alt"></i>
            </button>
        </div> --}}
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <header class="header">
            <div class="header-left">
                <button class="mobile-menu-toggle" id="mobileMenuToggle">
                    <i class="fas fa-bars"></i>
                </button>
                <h1 class="page-title">Dashboard</h1>
            </div>
            <div class="header-right">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Search...">
                </div>
                <div class="header-actions">
                    <button class="notification-btn">
                        <i class="fas fa-bell"></i>
                        <span class="notification-badge">3</span>
                    </button>
                <div class="user-menu">
                    <span class="user-trigger">{{ auth()->user()->name }}</span>
                    <div class="dropdown-menu">
                        <a href="#profile" class="dropdown-item">Profile</a>
                        <a href="#settings" class="dropdown-item">Settings</a>
                        <a href="#logout" class="dropdown-item">Logout</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                        {{-- <a href="{{ route('logout') }}">Logout</a> --}}
                    </div>
                </div>
                </div>
            </div>
        </header>
