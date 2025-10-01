@extends('admin.layouts.masterlayout')

@section('content')
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
<<<<<<< HEAD

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
                        <div class="user-trigger">
                            <div class="user-avatar">
                                <!-- <img src="https://via.placeholder.com/40" alt="User Avatar" class="avatar-image"> -->
                                <div class="online-indicator"></div>
                            </div>
                            <div class="user-info">
                                <span class="user-name">Admin User</span>
                                <span class="user-role">Super Admin</span>
                            </div>
                            <i class="fas fa-chevron-down dropdown-arrow"></i>
                        </div>
                        <div class="dropdown-menu">
                            <div class="dropdown-header">
                                <div class="user-avatar">
                                    <!-- <img src="https://via.placeholder.com/40" alt="User Avatar" class="avatar-image"> -->
                                </div>
                                <div class="user-details">
                                    <span class="user-name">Admin User</span>
                                    <span class="user-email">admin@qwikhome.com</span>
                                </div>
                            </div>
                            <div class="dropdown-divider"></div>
                            <a href="#profile" class="dropdown-item">
                                <i class="fas fa-user"></i>
                                <span>Profile</span>
                            </a>
                            <a href="#settings" class="dropdown-item">
                                <i class="fas fa-cog"></i>
                                <span>Settings</span>
                            </a>
                            <a href="#preferences" class="dropdown-item">
                                <i class="fas fa-palette"></i>
                                <span>Preferences</span>
                            </a>
                            <a href="#activity" class="dropdown-item">
                                <i class="fas fa-history"></i>
                                <span>Activity Log</span>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="#help" class="dropdown-item">
                                <i class="fas fa-question-circle"></i>
                                <span>Help & Support</span>
                            </a>
                            <a href="#logout" class="dropdown-item logout-item">
                                <i class="fas fa-sign-out-alt"></i>
                                <span>Logout</span>
                            </a>
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
=======
@endsection
>>>>>>> mayur
