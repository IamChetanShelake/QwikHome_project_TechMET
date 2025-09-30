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
@endsection
