<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QwikHome - Admin Panel</title>

    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+3:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.6.1/nouislider.min.css" rel="stylesheet">
    <!--====== Jquery js ======-->
    <script src="{{ asset('website/assets/vendor/jquery-3.7.1.min.js') }}"></script>

    <!--====== Bootstrap css ======-->
    <link rel="stylesheet" href="{{ asset('website/assets/vendor/bootstrap/css/bootstrap.min.css') }}">
    <!--====== Bootstrap js ======-->
    <script src="{{ asset('website/assets/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    <!--====== Bootstrap js ======-->
    <script src="{{ asset('website/assets/vendor/popper/popper.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <script src="{{ asset('js/admin.js') }}"></script>

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
                <li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }} " style="">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link" data-section="dashboard">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('customers') ? 'active' : '' }} ">
                    <a href="{{ route('customers') }}" class="nav-link">
                        <i class="fas fa-users"></i>
                        <span>Customer Management</span>
                    </a>
                </li>

                <li class="nav-item ">
                    <a href="" class="nav-link" data-section="services">

                        <i class="fas fa-cogs"></i>
                        <span>Service Management</span>

                    </a>
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

        <div class="sidebar-footer">
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
        </div>
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

                <div class="header-actions">
                    <button class="notification-btn">
                        <i class="fas fa-bell"></i>
                        <span class="notification-badge">3</span>
                    </button>
                    <div class="user-menu">
                        {{-- <img src="https://via.placeholder.com/40" alt="User" class="user-avatar"> --}}
                        {{ auth()->user()->name }}
                        <div class="dropdown-menu">
                            <a href="#profile">Profile</a>
                            <a href="#settings">Settings</a>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <input type="submit" value="Logout">
                            </form>
                            {{-- <a href="{{ route('logout') }}">Logout</a> --}}
                        </div>
                    </div>
                </div>
            </div>
        </header>
