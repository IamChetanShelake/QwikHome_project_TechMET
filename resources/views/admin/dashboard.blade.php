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
                <li class="nav-item active">
                    <a href="#dashboard" class="nav-link" data-section="dashboard">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#users" class="nav-link" data-section="users">
                        <i class="fas fa-users"></i>
                        <span>User Management</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#services" class="nav-link" data-section="services">
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
                <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <input type="submit" value="Logout">
                            </form>
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

        <!-- Content Area -->
        <div class="content-area">
            <!-- Dashboard Section -->
            <section id="dashboard-section" class="content-section active">
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <div class="stat-content">
                            <h3>1,234</h3>
                            <p>Total Bookings</p>
                            <span class="stat-change positive">+12%</span>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-rupee-sign"></i>
                        </div>
                        <div class="stat-content">
                            <h3>₹2,45,678</h3>
                            <p>Revenue</p>
                            <span class="stat-change positive">+8%</span>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stat-content">
                            <h3>856</h3>
                            <p>Active Users</p>
                            <span class="stat-change positive">+15%</span>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="stat-content">
                            <h3>23</h3>
                            <p>Pending Approvals</p>
                            <span class="stat-change negative">-5%</span>
                        </div>
                    </div>
                </div>

                <div class="dashboard-grid">
                    <div class="dashboard-card">
                        <div class="card-header">
                            <h3>Recent Bookings</h3>
                            <button class="btn-secondary">View All</button>
                        </div>
                        <div class="table-container">
                            <table class="data-table">
                                <thead>
                                    <tr>
                                        <th>Booking ID</th>
                                        <th>Customer</th>
                                        <th>Service</th>
                                        <th>Status</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>#BK001</td>
                                        <td>John Doe</td>
                                        <td>House Cleaning</td>
                                        <td><span class="status-badge completed">Completed</span></td>
                                        <td>₹1,500</td>
                                    </tr>
                                    <tr>
                                        <td>#BK002</td>
                                        <td>Jane Smith</td>
                                        <td>Plumbing</td>
                                        <td><span class="status-badge in-progress">In Progress</span></td>
                                        <td>₹2,200</td>
                                    </tr>
                                    <tr>
                                        <td>#BK003</td>
                                        <td>Mike Johnson</td>
                                        <td>Electrical</td>
                                        <td><span class="status-badge pending">Pending</span></td>
                                        <td>₹1,800</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="dashboard-card">
                        <div class="card-header">
                            <h3>Revenue Chart</h3>
                        </div>
                        <div class="chart-container">
                            <canvas id="revenueChart"></canvas>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Other sections will be loaded dynamically -->
            <div id="dynamic-content"></div>
        </div>
    </div>

    <script src="{{ asset('js/admin.js') }}"></script>
</body>

</html>
