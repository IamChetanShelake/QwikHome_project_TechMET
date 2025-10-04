<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QwikHome - {{ auth()->user()->role == 'admin' ? 'Admin' : 'Vendor' }} Panel</title>

    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+3:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.6.1/nouislider.min.css" rel="stylesheet">
    <!--====== Summernote CSS ======-->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <!--====== Jquery js ======-->
    <script src="{{ asset('website/assets/vendor/jquery-3.7.1.min.js') }}"></script>

    <!--====== Bootstrap css ======-->
    <link rel="stylesheet" href="{{ asset('website/assets/vendor/bootstrap/css/bootstrap.min.css') }}">
    <!--====== Bootstrap js ======-->
    <script src="{{ asset('website/assets/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    <!--====== Bootstrap js ======-->
    <script src="{{ asset('website/assets/vendor/popper/popper.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('js/admin.js') }}"></script>
    <style>
        /* Modern Service Management Dropdown Styling */
        .service-dropdown-menu {
            display: none;
            background: rgba(45, 45, 45, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
            min-width: 220px;
            z-index: 1000;
            margin-top: 8px;
            overflow: hidden;
        }

        .service-dropdown-menu .dropdown-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            color: #ffffff;
            text-decoration: none;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            transition: all 0.3s ease;
            font-size: 14px;
            font-weight: 500;
        }

        .service-dropdown-menu .dropdown-item:hover,
        .service-dropdown-menu .dropdown-item.active {
            background: rgba(0, 212, 255, 0.1);
            color: #00d4ff;
            transform: translateX(4px);
        }

        .service-dropdown-menu .dropdown-item i {
            width: 18px;
            text-align: center;
            font-size: 14px;
            color: rgba(255, 255, 255, 0.7);
            transition: all 0.3s ease;
        }

        .service-dropdown-menu .dropdown-item:hover i,
        .service-dropdown-menu .dropdown-item.active i {
            color: #00d4ff;
            transform: scale(1.1);
        }

        .service-dropdown-menu .dropdown-item:last-child {
            border-bottom: none;
        }

        .service-dropdown-menu .dropdown-item span {
            transition: all 0.3s ease;
        }

        /* Enhanced arrow animation */
        .fa-caret-down.rotate {
            transform: rotate(180deg);
            transition: transform 0.3s ease;
            color: #00d4ff;
        }

        .fa-caret-down {
            transition: all 0.3s ease;
            color: rgba(255, 255, 255, 0.7);
        }

        /* Service menu trigger hover effect */
        .service-menu-trigger:hover .fa-caret-down {
            color: #00d4ff;
        }

        /* Add subtle glow effect */
        .service-dropdown-menu::before {
            content: '';
            position: absolute;
            top: -1px;
            left: -1px;
            right: -1px;
            bottom: -1px;
            background: linear-gradient(135deg, rgba(0, 212, 255, 0.2), rgba(0, 153, 204, 0.2));
            border-radius: 12px;
            z-index: -1;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .service-dropdown-menu:hover::before {
            opacity: 1;
        }

        /* Smooth slide animation */
        .service-dropdown-menu {
            animation: slideDown 0.3s ease-out;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Mobile responsive adjustments */
        @media (max-width: 768px) {
            .service-dropdown-menu {
                min-width: 200px;
                margin-top: 4px;
            }

            .service-dropdown-menu .dropdown-item {
                padding: 10px 14px;
                font-size: 13px;
            }

            .service-dropdown-menu .dropdown-item i {
                width: 16px;
                font-size: 13px;
            }
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
                @if (auth()->user()->role == 'admin')
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
                @endif
                <li class="nav-item">
                    <div class="service-menu">
                        <a href="javascript:void(0)" class="nav-link service-menu-trigger">
                            <i class="fas fa-cogs"></i>
                            <span>Service Management</span>
                            <i class="fas fa-caret-down ml-1"></i>
                        </a>
                        <div class="service-dropdown-menu" style="display: none;">
                            <a href="{{ route('services.categories.index') }}" class="dropdown-item">
                                <i class="fas fa-folder"></i>
                                <span>Categories</span>
                            </a>

                            <a href="{{ route('services.subcategories.index') }}" class="dropdown-item">
                                <i class="fas fa-folder-open"></i>
                                <span>Sub-Category</span>
                            </a>
                            <a href="{{ route('services.services.index') }}" class="dropdown-item">
                                <i class="fas fa-concierge-bell"></i>
                                <span>Services</span>
                            </a>
                        </div>
                    </div>
                </li>
                <script>
                    $(document).ready(function() {
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

                        $(".service-menu-trigger").on("click", function(e) {
                            e.preventDefault();
                            const $dropdown = $(this).next(".service-dropdown-menu");
                            const $arrow = $(this).find(".fa-caret-down");

                            $dropdown.slideToggle(200);
                            $arrow.toggleClass("rotate");
                        });
                    });

                    // Initialize user menu dropdown
                    $(document).on("click", ".user-trigger", function(e) {
                        e.stopPropagation();
                        $(this).closest(".user-menu").toggleClass("active");
                    });

                    // Close user menu when clicking outside
                    $(document).on("click", function(e) {
                        if (!$(e.target).closest(".user-menu").length) {
                            $(".user-menu").removeClass("active");
                        }
                    });

                    // Handle logout
                    $(document).on("click", ".user-menu .dropdown-item[href='#logout']", function(e) {
                        e.preventDefault();
                        $("#logout-form").submit();
                    });

                    // Mobile menu toggle
                    $(document).on("click", "#mobileMenuToggle", function(e) {
                        if ($(window).width() <= 768) {
                            $("#sidebar").toggleClass("open");
                        }
                    });

                    // Close mobile sidebar when clicking outside, on sidebar content, or hamburger again
                    $(document).on("click", "#mobileMenuToggle, #sidebar a", function(e) {
                        if ($(window).width() <= 768) {
                            // For sidebar links, close immediately
                            if ($(e.target).closest("#sidebar a").length) {
                                $("#sidebar").removeClass("open");
                            }
                        }
                    });

                    // Close mobile sidebar when clicking outside
                    $(document).on("click", function(e) {
                        if ($(window).width() <= 768) {
                            if (!$(e.target).closest("#sidebar, #mobileMenuToggle").length) {
                                $("#sidebar").removeClass("open");
                            }
                        }
                    });

                    // Swipe gesture for mobile sidebar
                    if ($(window).width() <= 768) {
                        let touchStartX = 0;
                        let touchStartY = 0;
                        let touchEndX = 0;
                        let touchEndY = 0;

                        $("#sidebar").on("touchstart", function(e) {
                            touchStartX = e.originalEvent.touches[0].clientX;
                            touchStartY = e.originalEvent.touches[0].clientY;
                        });

                        $("#sidebar").on("touchmove", function(e) {
                            if (!touchStartX || !touchStartY) return;

                            touchEndX = e.originalEvent.touches[0].clientX;
                            touchEndY = e.originalEvent.touches[0].clientY;

                            const deltaX = touchStartX - touchEndX;
                            const deltaY = Math.abs(touchStartY - touchEndY);

                            // If horizontal swipe is greater than vertical, handle it
                            if (Math.abs(deltaX) > deltaY && Math.abs(deltaX) > 50) {
                                if (deltaX > 50) { // Left swipe
                                    e.preventDefault();
                                    $("#sidebar").removeClass("open");
                                }
                            }
                        });

                        $("#sidebar").on("touchend", function() {
                            touchStartX = 0;
                            touchStartY = 0;
                            touchEndX = 0;
                            touchEndY = 0;
                        });
                    }

                    // Sidebar toggle (desktop)
                    $(document).on("click", "#sidebarToggle", function(e) {
                        $("#sidebar").removeClass("open").toggleClass("collapsed");
                        $(".main-content").toggleClass("collapsed");
                    });
                </script>

                @if (auth()->user()->role == 'admin')
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-calendar-check"></i>
                            <span>Booking Management</span>
                        </a>
                    </li>
                    <li class="nav-item {{ request()->routeIs('admin.vendors.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.vendors.index') }}" class="nav-link">
                            <i class="fas fa-user-tie"></i>
                            <span>Vendor Management</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-calendar-check"></i>
                            <span>Booking Management</span>
                        </a>
                    </li>
                    <li class="nav-item {{ request()->routeIs('serviceProviders.index') ? 'active' : '' }}">
                        <a href="{{ route('serviceProviders.index') }}" class="nav-link">
                            <i class="fas fa-user-plus"></i>
                            <span>Service Providers</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('coupons.index') }}" class="nav-link">
                            <i class="fas fa-tags"></i>
                            <span>Coupons</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-bell"></i>
                            <span>Notifications</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-chart-bar"></i>
                            <span>Reports & Analytics</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('complaints.index') }}" class="nav-link">
                            <i class="fas fa-exclamation-triangle"></i>
                            <span>Complaints</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-edit"></i>
                            <span>Content Management</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-user-plus"></i>
                            <span>Lead Management</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('faq') }}" class="nav-link">
                            <i class="fas fa-user-plus"></i>
                            <span>FAQ's</span>
                        </a>
                    </li>
                @else
                    <li class="nav-item {{ request()->routeIs('serviceProviders.index') ? 'active' : '' }}">
                        <a href="{{ route('serviceProviders.index') }}" class="nav-link">
                            <i class="fas fa-user-plus"></i>
                            <span>Service Providers</span>
                        </a>
                    </li>
                    <li class="nav-item {{ request()->routeIs('vendor.bookings.index') ? 'active' : '' }}">
                        <a href="{{ route('vendor.bookings.index') }}" class="nav-link">
                            <i class="fas fa-tasks"></i>
                            <span>Service Monitoring</span>
                        </a>
                    </li>
                    <li class="nav-item {{ request()->routeIs('profile.show') ? 'active' : '' }}">
                        <a href="{{ route('profile.show') }}" class="nav-link">
                            <i class="fas fa-user"></i>
                            <span>My Profile</span>
                        </a>
                    </li>
                @endif
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

                <h1 class="page-title">{{ auth()->user()->role == 'admin' ? 'Admin' : 'Vendor' }} Dashboard</h1>
            </div>
            <div class="header-right">

                <div class="header-actions">
                    <button class="notification-btn">
                        <i class="fas fa-bell"></i>
                        <span class="notification-badge">3</span>
                    </button>
                    <div class="user-menu">
                        <span class="user-trigger">{{ auth()->user()->name }}
                            <a href="#logout" class="dropdown-item">Logout</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                style="display: none;">
                                @csrf
                            </form>
                        </span>

                        {{-- <div class="dropdown-menu">
                        <a href="#profile" class="dropdown-item">Profile</a>
                        <a href="#settings" class="dropdown-item">Settings</a>

                    </div> --}}
                    </div>
                </div>
            </div>
        </header>
