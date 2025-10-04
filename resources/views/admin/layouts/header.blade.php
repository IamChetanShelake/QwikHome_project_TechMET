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

        /* Collapsed Sidebar Service Management Fixes */
        .sidebar.collapsed .service-menu {
            position: relative;
        }

        .sidebar.collapsed .service-menu-trigger {
            justify-content: center !important;
            padding: 12px 5px !important;
            min-height: 45px !important;
            display: flex !important;
            align-items: center !important;
            position: relative !important;
            width: 100% !important;
            max-width: 80px !important;
        }

        .sidebar.collapsed .service-menu-trigger span,
        .sidebar.collapsed .service-menu-trigger .fa-caret-down {
            display: none !important;
            opacity: 0 !important;
        }

        .sidebar.collapsed .service-menu-trigger i.fas.fa-cogs {
            margin-right: 0 !important;
            opacity: 1 !important;
            visibility: visible !important;
            font-size: 18px !important;
            color: rgba(255, 255, 255, 0.9) !important;
            width: 20px !important;
            height: 20px !important;
            text-align: center !important;
            display: inline-block !important;
            position: relative !important;
            z-index: 10 !important;
        }

        .sidebar.collapsed .service-dropdown-menu {
            display: none !important;
        }

        /* Hide flyout menu by default and only show in collapsed sidebar */
        .service-flyout-menu {
            display: none !important;
        }

        /* Collapsed sidebar flyout menu */
        .sidebar.collapsed .service-flyout-menu {
            display: block !important;
            position: absolute;
            left: 100%;
            top: 0;
            background: rgba(45, 45, 45, 0.95);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.4);
            min-width: 220px;
            z-index: 1002;
            margin-left: 10px;
            overflow: hidden;
            opacity: 0;
            transform: translateX(-10px);
            transition: all 0.3s ease;
            pointer-events: none;
        }

        .sidebar.collapsed .service-flyout-menu.show {
            opacity: 1;
            transform: translateX(0);
            pointer-events: all;
        }

        .sidebar.collapsed .service-flyout-menu .flyout-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            color: #ffffff;
            text-decoration: none;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            transition: all 0.3s ease;
            font-size: 14px;
        }

        .sidebar.collapsed .service-flyout-menu .flyout-item:last-child {
            border-bottom: none;
        }

        .sidebar.collapsed .service-flyout-menu .flyout-item:hover {
            background: rgba(0, 212, 255, 0.1);
            color: #00d4ff;
            transform: translateX(5px);
        }

        .sidebar.collapsed .service-flyout-menu .flyout-item i {
            width: 16px;
            text-align: center;
            color: rgba(255, 255, 255, 0.7);
        }

        .sidebar.collapsed .service-flyout-menu .flyout-item:hover i {
            color: #00d4ff;
        }

        .sidebar.collapsed .service-flyout-menu .flyout-item.active {
            background: rgba(0, 212, 255, 0.15);
            color: #00d4ff;
            border-left: 3px solid #00d4ff;
        }

        .sidebar.collapsed .service-flyout-menu .flyout-item.active i {
            color: #00d4ff;
        }

        .sidebar.collapsed .service-menu:hover .service-menu-trigger {
            background: rgba(0, 212, 255, 0.1) !important;
            border-left: 3px solid #00d4ff !important;
        }

        .sidebar.collapsed .service-menu:hover .service-menu-trigger i.fas.fa-cogs {
            color: #00d4ff !important;
        }

        /* Tooltip for collapsed service menu - hide when flyout is open */
        .sidebar.collapsed .service-menu-trigger:hover::after {
            content: "Service Management";
            position: absolute;
            left: 100%;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(0, 0, 0, 0.9);
            color: white;
            padding: 8px 12px;
            border-radius: 6px;
            font-size: 12px;
            white-space: nowrap;
            z-index: 1001;
            margin-left: 10px;
            opacity: 0;
            animation: fadeInTooltip 0.3s ease forwards;
        }

        .sidebar.collapsed .service-menu .service-flyout-menu.show~.service-menu-trigger:hover::after {
            display: none;
        }

        @keyframes fadeInTooltip {
            to {
                opacity: 1;
            }
        }

        /* Additional fixes for service menu in collapsed state */
        .sidebar.collapsed .nav-item .service-menu {
            width: 100%;
            display: block;
        }

        .sidebar.collapsed .nav-item .service-menu .service-menu-trigger {
            border-left: 3px solid transparent;
            transition: all 0.3s ease;
        }

        .sidebar.collapsed .nav-item.active .service-menu-trigger {
            background: rgba(0, 212, 255, 0.1);
            border-left-color: #00d4ff;
        }

        .sidebar.collapsed .nav-item.active .service-menu-trigger i.fas.fa-cogs {
            color: #00d4ff;
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

        /* Enhanced active state for service management */
        .nav-item.active .service-menu-trigger {
            color: #ffffff !important;
            background: rgba(0, 212, 255, 0.1) !important;
        }

        .nav-item.active .service-menu-trigger i {
            color: #00d4ff !important;
        }

        /* Ensure parent nav-item gets active styling */
        .nav-item.active {
            border-left: 3px solid #00d4ff;
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
                <li
                    class="nav-item {{ request()->routeIs('services.*') || str_contains(request()->url(), '/services') ? 'active' : '' }}">
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
                        <!-- Flyout menu for collapsed sidebar -->
                        <div class="service-flyout-menu">
                            <a href="{{ route('services.categories.index') }}" class="flyout-item">
                                <i class="fas fa-folder"></i>
                                <span>Categories</span>
                            </a>
                            <a href="{{ route('services.subcategories.index') }}" class="flyout-item">
                                <i class="fas fa-folder-open"></i>
                                <span>Sub-Category</span>
                            </a>
                            <a href="{{ route('services.services.index') }}" class="flyout-item">
                                <i class="fas fa-concierge-bell"></i>
                                <span>Services</span>
                            </a>
                        </div>
                    </div>
                </li>
                <script>
                    $(document).ready(function() {
                        function isServiceManagementPage() {
                            const path = window.location.pathname;
                            return path.includes('/services') || path.includes('/categories') || path.includes(
                                '/subcategories');
                        }

                        // Check if on service management page and show dropdown
                        if (isServiceManagementPage()) {
                            $(".service-dropdown-menu").show();
                            $(".service-menu-trigger").find(".fa-caret-down").addClass("rotate");

                            // Highlight active section based on current route
                            const currentPath = window.location.pathname;
                            const currentRoute = window.location.href;

                            // Check for services routes (more specific patterns)
                            if (currentPath.includes('/services/services') || currentRoute.includes('services.services') ||
                                (currentPath.includes('/services') && !currentPath.includes('/categories') && !currentPath
                                    .includes('/subcategories'))) {
                                $('.service-dropdown-menu a[href*="services.services"]').addClass('active');
                            }
                            // Check for categories routes
                            else if (currentPath.includes('/categories') || currentRoute.includes('services.categories')) {
                                $('.service-dropdown-menu a[href*="services.categories"]').addClass('active');
                            }
                            // Check for subcategories routes
                            else if (currentPath.includes('/subcategories') || currentRoute.includes(
                                    'services.subcategories')) {
                                $('.service-dropdown-menu a[href*="services.subcategories"]').addClass('active');
                            }
                        }

                        $(".service-menu-trigger").on("click", function(e) {
                            e.preventDefault();

                            // Handle collapsed sidebar - show flyout menu
                            if ($('.sidebar').hasClass('collapsed')) {
                                const $flyout = $(this).siblings(".service-flyout-menu");

                                // Close any other open flyouts first
                                $('.service-flyout-menu').not($flyout).removeClass('show');

                                // Toggle current flyout
                                $flyout.toggleClass('show');

                                return false;
                            }

                            const $dropdown = $(this).next(".service-dropdown-menu");
                            const $arrow = $(this).find(".fa-caret-down");

                            $dropdown.slideToggle(200);
                            $arrow.toggleClass("rotate");
                        });

                        // Handle sidebar collapse behavior for service menu
                        function handleServiceMenuCollapse() {
                            if ($('.sidebar').hasClass('collapsed')) {
                                // Hide dropdown and reset arrow when collapsed
                                $('.service-dropdown-menu').hide();
                                $('.service-menu-trigger .fa-caret-down').removeClass('rotate');
                                // Also hide any open flyout menus
                                $('.service-flyout-menu').removeClass('show');
                            } else {
                                // Show dropdown if on service management page when expanded
                                if (isServiceManagementPage()) {
                                    $('.service-dropdown-menu').show();
                                    $('.service-menu-trigger .fa-caret-down').addClass('rotate');
                                }
                                // Hide flyout menu when expanded
                                $('.service-flyout-menu').removeClass('show');
                            }
                        }

                        // Handle flyout menu active states
                        function updateFlyoutActiveStates() {
                            const currentPath = window.location.pathname;
                            const currentRoute = window.location.href;

                            // Remove all active classes first
                            $('.service-flyout-menu .flyout-item').removeClass('active');

                            // Add active class based on current route
                            if (currentPath.includes('/services/services') || currentRoute.includes('services.services') ||
                                (currentPath.includes('/services') && !currentPath.includes('/categories') && !currentPath
                                    .includes('/subcategories'))) {
                                $('.service-flyout-menu a[href*="services.services"]').addClass('active');
                            } else if (currentPath.includes('/categories') || currentRoute.includes('services.categories')) {
                                $('.service-flyout-menu a[href*="services.categories"]').addClass('active');
                            } else if (currentPath.includes('/subcategories') || currentRoute.includes(
                                    'services.subcategories')) {
                                $('.service-flyout-menu a[href*="services.subcategories"]').addClass('active');
                            }
                        }

                        // Initialize flyout active states
                        updateFlyoutActiveStates();

                        // Close flyout menu when clicking outside
                        $(document).on('click', function(e) {
                            if (!$(e.target).closest('.service-menu').length) {
                                $('.service-flyout-menu').removeClass('show');
                            }
                        });

                        // Prevent flyout from closing when clicking inside it
                        $(document).on('click', '.service-flyout-menu', function(e) {
                            e.stopPropagation();
                        });

                        // Watch for sidebar collapse changes
                        const observer = new MutationObserver(function(mutations) {
                            mutations.forEach(function(mutation) {
                                if (mutation.type === 'attributes' && mutation.attributeName === 'class') {
                                    handleServiceMenuCollapse();
                                }
                            });
                        });

                        // Start observing sidebar for class changes
                        const sidebar = document.querySelector('.sidebar');
                        if (sidebar) {
                            observer.observe(sidebar, {
                                attributes: true,
                                attributeFilter: ['class']
                            });
                        }
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
                    <li class="nav-item {{ request()->routeIs('admin.vendors.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.vendors.index') }}" class="nav-link">
                            <i class="fas fa-user-tie"></i>
                            <span>Vendor Management</span>
                        </a>
                    </li>

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
                    <li class="nav-item {{ request()->routeIs('coupons.*') ? 'active' : '' }}">
                        <a href="{{ route('coupons.index') }}" class="nav-link">
                            <i class="fas fa-tags"></i>
                            <span>Coupons</span>
                        </a>
                    </li>
                    <li class="nav-item {{ request()->routeIs('promocodes.*') ? 'active' : '' }}">
                        <a href="{{ route('promocodes.index') }}" class="nav-link">
                            <i class="fas fa-gift"></i>
                            <span>Promo Codes</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-bell"></i>
                            <span>Push Notifications</span>
                        </a>
                    </li>
                    <li class="nav-item {{ request()->routeIs('admin.analytics.index') ? 'active' : '' }}">
                        <a href="{{ route('admin.analytics.index') }}" class="nav-link">
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
                    {{-- <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-user-plus"></i>
                            <span>Lead Management</span>
                        </a>
                    </li> --}}
                    <li class="nav-item {{ request()->routeIs('faq*') ? 'active' : '' }}">
                        <a href="{{ route('faq') }}" class="nav-link">
                            <i class="fas fa-question-circle"></i>
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
