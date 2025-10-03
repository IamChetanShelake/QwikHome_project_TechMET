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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .service-dropdown-menu {
            display: none;
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 0 0 4px 4px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            min-width: 200px;
            z-index: 1000;
        }
        .service-dropdown-menu .dropdown-item {
            display: block;
            padding: 10px 15px;
            color: #333;
            text-decoration: none;
            border-bottom: 1px solid #eee;
        }
        .service-dropdown-menu .dropdown-item:hover,
        .service-dropdown-menu .dropdown-item.active {
            background-color: #007bff;
            color: white;
        }
        .service-dropdown-menu .dropdown-item:last-child {
            border-bottom: none;
        }
        .fa-caret-down.rotate {
            transform: rotate(180deg);
            transition: transform 0.2s ease;
        }
        .fa-caret-down {
            transition: transform 0.2s ease;
        }
    </style>
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
                <li class="nav-item {{ request()->routeIs('customers') ? 'active' : '' }} ">
                    <a href="{{ route('customers') }}" class="nav-link">
                        <i class="fas fa-users"></i>
                        <span>Customer Management</span>
                    </a>
                </li>
                <li class="nav-item">
                    <div class="service-menu">
                        <a href="javascript:void(0)" class="nav-link service-menu-trigger">
                            <i class="fas fa-cogs"></i>
                            <span>Service Management</span>
                            <i class="fas fa-caret-down ml-1"></i>
                        </a>
                        <div class="service-dropdown-menu" style="display: none;">
                            <a href="{{ route('services.services.index') }}" class="dropdown-item">Services</a>
                            <a href="{{ route('services.categories.index') }}" class="dropdown-item">Categories</a>
                            <a href="{{ route('services.subcategories.index') }}" class="dropdown-item">Subcategories</a>
                        </div>
                    </div>
                </li>
                <script>
                    $(document).ready(function () {
                        function isServiceManagementPage() {
                            return window.location.pathname.startsWith('/services');
                        }

                        // Check if on service management page and show dropdown
                        if (isServiceManagementPage()) {
                            $(".service-dropdown-menu").show();
                            $(".service-menu-trigger").find(".fa-caret-down").addClass("rotate");

                            // Highlight active section
                            const currentPath = window.location.pathname;
                            if (currentPath === '/services' || currentPath.startsWith('/services?')) {
                                $('.service-dropdown-menu a[href*="services.services.index"]').addClass('active');
                            } else if (currentPath.includes('/categories')) {
                                $('.service-dropdown-menu a[href*="services.categories.index"]').addClass('active');
                            } else if (currentPath.includes('/subcategories')) {
                                $('.service-dropdown-menu a[href*="services.subcategories.index"]').addClass('active');
                            }
                        }

                        $(".service-menu-trigger").on("click", function (e) {
                            e.preventDefault();
                            const $dropdown = $(this).next(".service-dropdown-menu");
                            const $arrow = $(this).find(".fa-caret-down");

                            if (isServiceManagementPage() && $dropdown.is(':visible')) {
                                // Allow closing dropdown only if not on service management page
                                return;
                            }

                            $dropdown.slideToggle(200);
                            $arrow.toggleClass("rotate");
                        });
                    });
                </script>

                <li class="nav-item">
                    <a href="#bookings" class="nav-link">
                        <i class="fas fa-calendar-check"></i>
                        <span>Booking Management</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#finance" class="nav-link">
                        <i class="fas fa-wallet"></i>
                        <span>Finance & Wallet</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#promotions" class="nav-link">
                        <i class="fas fa-tags"></i>
                        <span>Coupons & Promotions</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#notifications" class="nav-link">
                        <i class="fas fa-bell"></i>
                        <span>Notifications</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#reports" class="nav-link" >
                        <i class="fas fa-chart-bar"></i>
                        <span>Reports & Analytics</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#complaints" class="nav-link">
                        <i class="fas fa-exclamation-triangle"></i>
                        <span>Complaints</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#content" class="nav-link" >
                        <i class="fas fa-edit"></i>
                        <span>Content Management</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#leads" class="nav-link" >
                        <i class="fas fa-user-plus"></i>
                        <span>Lead Management</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('faq')}}" class="nav-link" >
                        <i class="fas fa-user-plus"></i>
                        <span>FAQ's</span>
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
