// Admin Panel JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // Initialize admin panel
    initializeAdminPanel();

    // Initialize user menu
    initializeUserMenu();

    // Load dashboard by default
    loadSection('dashboard');
});

function initializeAdminPanel() {
    // Sidebar navigation
    const navLinks = document.querySelectorAll('.nav-link');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const mobileMenuToggle = document.getElementById('mobileMenuToggle');
    const sidebar = document.getElementById('sidebar');
    
    // Navigation click handlers
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Remove active class from all nav items
            document.querySelectorAll('.nav-item').forEach(item => {
                item.classList.remove('active');
            });
            
            // Add active class to clicked item
            this.parentElement.classList.add('active');
            
            // Get section name and load content
            const section = this.getAttribute('data-section');
            loadSection(section);
            
            // Update page title
            const pageTitle = document.querySelector('.page-title');
            pageTitle.textContent = this.querySelector('span').textContent;
        });
    });
    
    // Mobile menu toggle
    if (mobileMenuToggle) {
        mobileMenuToggle.addEventListener('click', function() {
            sidebar.classList.toggle('open');
        });
    }
    
    // Sidebar toggle
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('collapsed');
        });
    }
}

function initializeUserMenu() {
    const userMenu = document.querySelector('.user-menu');
    const userTrigger = document.querySelector('.user-trigger');
    const dropdownMenu = document.querySelector('.dropdown-menu');
    const dropdownItems = document.querySelectorAll('.dropdown-item');

    if (!userMenu || !userTrigger || !dropdownMenu) {
        return;
    }

    // Toggle dropdown on trigger click
    userTrigger.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();

        const isActive = userMenu.classList.contains('active');

        // Close all other dropdowns first
        document.querySelectorAll('.user-menu.active').forEach(menu => {
            if (menu !== userMenu) {
                menu.classList.remove('active');
            }
        });

        // Toggle current dropdown
        if (isActive) {
            closeDropdown();
        } else {
            openDropdown();
        }
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
        if (!userMenu.contains(e.target)) {
            closeDropdown();
        }
    });

    // Close dropdown on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && userMenu.classList.contains('active')) {
            closeDropdown();
            userTrigger.focus(); // Return focus to trigger
        }
    });

    // Handle dropdown item clicks
    dropdownItems.forEach((item, index) => {
        // Make items focusable for accessibility
        item.setAttribute('tabindex', '0');

        item.addEventListener('click', function(e) {
            const href = this.getAttribute('href');

            // Handle special actions
            if (href === '#logout') {
                e.preventDefault();
                handleLogout();
            } else if (href.startsWith('#')) {
                e.preventDefault();
                // Handle other internal actions
                const action = href.substring(1);
                handleMenuAction(action);
            }

            // Close dropdown after action
            closeDropdown();
        });

        // Add keyboard navigation
        item.addEventListener('keydown', function(e) {
            switch(e.key) {
                case 'Enter':
                case ' ':
                    e.preventDefault();
                    this.click();
                    break;
                case 'ArrowDown':
                    e.preventDefault();
                    focusNextItem(index);
                    break;
                case 'ArrowUp':
                    e.preventDefault();
                    focusPreviousItem(index);
                    break;
                case 'Home':
                    e.preventDefault();
                    dropdownItems[0].focus();
                    break;
                case 'End':
                    e.preventDefault();
                    dropdownItems[dropdownItems.length - 1].focus();
                    break;
            }
        });
    });

    function focusNextItem(currentIndex) {
        const nextIndex = currentIndex < dropdownItems.length - 1 ? currentIndex + 1 : 0;
        dropdownItems[nextIndex].focus();
    }

    function focusPreviousItem(currentIndex) {
        const prevIndex = currentIndex > 0 ? currentIndex - 1 : dropdownItems.length - 1;
        dropdownItems[prevIndex].focus();
    }

    // Add hover effects for better UX
    userTrigger.addEventListener('mouseenter', function() {
        if (!userMenu.classList.contains('active')) {
            // Add subtle hover effect
            this.style.transform = 'translateY(-1px)';
        }
    });

    userTrigger.addEventListener('mouseleave', function() {
        if (!userMenu.classList.contains('active')) {
            this.style.transform = '';
        }
    });

    function openDropdown() {
        userMenu.classList.add('active');

        // Add slight delay for smooth animation
        setTimeout(() => {
            dropdownMenu.style.opacity = '1';
            dropdownMenu.style.visibility = 'visible';
            dropdownMenu.style.transform = 'translateY(0) scale(1)';
        }, 10);

        // Focus first dropdown item for accessibility
        const firstItem = dropdownMenu.querySelector('.dropdown-item');
        if (firstItem) {
            setTimeout(() => firstItem.focus(), 100);
        }
    }

    function closeDropdown() {
        userMenu.classList.remove('active');

        // Reset styles
        dropdownMenu.style.opacity = '0';
        dropdownMenu.style.visibility = 'hidden';
        dropdownMenu.style.transform = 'translateY(-10px) scale(0.95)';

        // Reset trigger hover effect
        userTrigger.style.transform = '';
    }

    function handleLogout() {
        // Show confirmation dialog
        if (confirm('Are you sure you want to logout?')) {
            // Add loading state
            showNotification('Logging out...', 'info');

            // Simulate logout process
            setTimeout(() => {
                // In a real application, this would be handled by the backend
                window.location.href = '/admin/logout';
            }, 1000);
        }
    }

    function handleMenuAction(action) {
        switch (action) {
            case 'profile':
                showNotification('Opening profile...', 'info');
                // Load profile content or redirect
                break;
            case 'settings':
                showNotification('Opening settings...', 'info');
                // Load settings content or redirect
                break;
            case 'preferences':
                showNotification('Opening preferences...', 'info');
                // Load preferences content or redirect
                break;
            case 'activity':
                showNotification('Opening activity log...', 'info');
                // Load activity content or redirect
                break;
            case 'help':
                showNotification('Opening help & support...', 'info');
                // Load help content or redirect
                break;
            default:
                showNotification('Action not implemented yet', 'info');
        }
    }
}

function loadSection(sectionName) {
    // Hide all sections
    const sections = document.querySelectorAll('.content-section');
    sections.forEach(section => {
        section.classList.remove('active');
    });
    
    // Show dashboard section if it exists
    const dashboardSection = document.getElementById('dashboard-section');
    const dynamicContent = document.getElementById('dynamic-content');
    
    if (sectionName === 'dashboard' && dashboardSection) {
        dashboardSection.classList.add('active');
        return;
    }
    
    // Load dynamic content for other sections
    const content = getSectionContent(sectionName);
    dynamicContent.innerHTML = content;
    dynamicContent.classList.add('active');
    
    // Add fade-in animation
    dynamicContent.classList.add('fade-in');
    setTimeout(() => {
        dynamicContent.classList.remove('fade-in');
    }, 500);
}

function getSectionContent(section) {
    const contents = {
        users: `
            <section class="content-section active">
                <div class="section-header">
                    <h2>User Management</h2>
                    <div class="section-actions">
                        <button class="btn-primary">Add New User</button>
                        <button class="btn-secondary">Export Data</button>
                    </div>
                </div>
                
                <div class="filter-bar">
                    <div class="filter-group">
                        <select class="filter-select">
                            <option>All Users</option>
                            <option>Customers</option>
                            <option>Service Providers</option>
                        </select>
                        <select class="filter-select">
                            <option>All Status</option>
                            <option>Active</option>
                            <option>Blocked</option>
                            <option>Pending</option>
                        </select>
                        <input type="text" placeholder="Search users..." class="filter-input">
                    </div>
                </div>
                
                <div class="dashboard-card">
                    <div class="table-container">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>User ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                    <th>Joined</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>#U001</td>
                                    <td>John Doe</td>
                                    <td>john@example.com</td>
                                    <td>Customer</td>
                                    <td><span class="status-badge completed">Active</span></td>
                                    <td>2024-01-15</td>
                                    <td>
                                        <button class="action-btn edit">Edit</button>
                                        <button class="action-btn block">Block</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>#U002</td>
                                    <td>Jane Smith</td>
                                    <td>jane@example.com</td>
                                    <td>Provider</td>
                                    <td><span class="status-badge pending">Pending</span></td>
                                    <td>2024-01-20</td>
                                    <td>
                                        <button class="action-btn approve">Approve</button>
                                        <button class="action-btn reject">Reject</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        `,
        
        services: `
            <section class="content-section active">
                <div class="section-header">
                    <h2>Service Management</h2>
                    <div class="section-actions">
                        <button class="btn-primary">Add Service</button>
                        <button class="btn-secondary">Manage Categories</button>
                    </div>
                </div>
                
                <div class="services-grid">
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="fas fa-broom"></i>
                        </div>
                        <h3>House Cleaning</h3>
                        <p>Professional home cleaning services</p>
                        <div class="service-stats">
                            <span>₹500 - ₹2000</span>
                            <span>156 Providers</span>
                        </div>
                        <div class="service-actions">
                            <button class="btn-secondary">Edit</button>
                            <button class="btn-danger">Delete</button>
                        </div>
                    </div>
                    
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="fas fa-wrench"></i>
                        </div>
                        <h3>Plumbing</h3>
                        <p>Expert plumbing repair services</p>
                        <div class="service-stats">
                            <span>₹800 - ₹3000</span>
                            <span>89 Providers</span>
                        </div>
                        <div class="service-actions">
                            <button class="btn-secondary">Edit</button>
                            <button class="btn-danger">Delete</button>
                        </div>
                    </div>
                    
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="fas fa-bolt"></i>
                        </div>
                        <h3>Electrical</h3>
                        <p>Licensed electrical repair services</p>
                        <div class="service-stats">
                            <span>₹600 - ₹2500</span>
                            <span>67 Providers</span>
                        </div>
                        <div class="service-actions">
                            <button class="btn-secondary">Edit</button>
                            <button class="btn-danger">Delete</button>
                        </div>
                    </div>
                </div>
            </section>
        `,
        
        bookings: `
            <section class="content-section active">
                <div class="section-header">
                    <h2>Booking Management</h2>
                    <div class="section-actions">
                        <button class="btn-primary">Manual Booking</button>
                        <button class="btn-secondary">Export Report</button>
                    </div>
                </div>
                
                <div class="booking-stats">
                    <div class="stat-card">
                        <h3>45</h3>
                        <p>Today's Bookings</p>
                    </div>
                    <div class="stat-card">
                        <h3>12</h3>
                        <p>In Progress</p>
                    </div>
                    <div class="stat-card">
                        <h3>8</h3>
                        <p>Pending Assignment</p>
                    </div>
                    <div class="stat-card">
                        <h3>25</h3>
                        <p>Completed Today</p>
                    </div>
                </div>
                
                <div class="dashboard-card">
                    <div class="card-header">
                        <h3>All Bookings</h3>
                        <div class="booking-filters">
                            <select class="filter-select">
                                <option>All Status</option>
                                <option>Pending</option>
                                <option>Assigned</option>
                                <option>In Progress</option>
                                <option>Completed</option>
                                <option>Cancelled</option>
                            </select>
                        </div>
                    </div>
                    <div class="table-container">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Booking ID</th>
                                    <th>Customer</th>
                                    <th>Service</th>
                                    <th>Provider</th>
                                    <th>Date & Time</th>
                                    <th>Status</th>
                                    <th>Amount</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>#BK001</td>
                                    <td>John Doe</td>
                                    <td>House Cleaning</td>
                                    <td>Clean Pro Services</td>
                                    <td>2024-01-25 10:00 AM</td>
                                    <td><span class="status-badge in-progress">In Progress</span></td>
                                    <td>₹1,500</td>
                                    <td>
                                        <button class="action-btn view">View</button>
                                        <button class="action-btn reassign">Reassign</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        `,
        
        finance: `
            <section class="content-section active">
                <div class="section-header">
                    <h2>Finance & Wallet Management</h2>
                    <div class="section-actions">
                        <button class="btn-primary">Process Payments</button>
                        <button class="btn-secondary">Generate Report</button>
                    </div>
                </div>
                
                <div class="finance-overview">
                    <div class="finance-card">
                        <h3>₹2,45,678</h3>
                        <p>Total Revenue</p>
                        <span class="change positive">+12%</span>
                    </div>
                    <div class="finance-card">
                        <h3>₹45,890</h3>
                        <p>Pending Settlements</p>
                        <span class="change negative">-3%</span>
                    </div>
                    <div class="finance-card">
                        <h3>₹12,456</h3>
                        <p>Commission Earned</p>
                        <span class="change positive">+8%</span>
                    </div>
                    <div class="finance-card">
                        <h3>₹8,900</h3>
                        <p>Refunds Processed</p>
                        <span class="change neutral">0%</span>
                    </div>
                </div>
                
                <div class="dashboard-grid">
                    <div class="dashboard-card">
                        <div class="card-header">
                            <h3>Recent Transactions</h3>
                        </div>
                        <div class="table-container">
                            <table class="data-table">
                                <thead>
                                    <tr>
                                        <th>Transaction ID</th>
                                        <th>Type</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>#TXN001</td>
                                        <td>Payment</td>
                                        <td>₹1,500</td>
                                        <td><span class="status-badge completed">Success</span></td>
                                        <td>2024-01-25</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <div class="dashboard-card">
                        <div class="card-header">
                            <h3>Commission Settings</h3>
                        </div>
                        <div class="commission-settings">
                            <div class="setting-item">
                                <label>House Cleaning</label>
                                <input type="number" value="15" min="0" max="100">
                                <span>%</span>
                            </div>
                            <div class="setting-item">
                                <label>Plumbing</label>
                                <input type="number" value="12" min="0" max="100">
                                <span>%</span>
                            </div>
                            <button class="btn-primary">Update Settings</button>
                        </div>
                    </div>
                </div>
            </section>
        `,
        
        promotions: `
            <section class="content-section active">
                <div class="section-header">
                    <h2>Coupons & Promotions</h2>
                    <div class="section-actions">
                        <button class="btn-primary">Create Coupon</button>
                        <button class="btn-secondary">Bulk Actions</button>
                    </div>
                </div>
                
                <div class="promotions-stats">
                    <div class="stat-card">
                        <h3>25</h3>
                        <p>Active Coupons</p>
                    </div>
                    <div class="stat-card">
                        <h3>₹45,890</h3>
                        <p>Total Savings</p>
                    </div>
                    <div class="stat-card">
                        <h3>1,234</h3>
                        <p>Times Used</p>
                    </div>
                </div>
                
                <div class="dashboard-card">
                    <div class="table-container">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Coupon Code</th>
                                    <th>Description</th>
                                    <th>Discount</th>
                                    <th>Usage</th>
                                    <th>Valid Until</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><strong>WELCOME20</strong></td>
                                    <td>Welcome discount for new users</td>
                                    <td>20%</td>
                                    <td>45/100</td>
                                    <td>2024-12-31</td>
                                    <td><span class="status-badge completed">Active</span></td>
                                    <td>
                                        <button class="action-btn edit">Edit</button>
                                        <button class="action-btn block">Disable</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        `,
        
        notifications: `
            <section class="content-section active">
                <div class="section-header">
                    <h2>Notifications</h2>
                    <div class="section-actions">
                        <button class="btn-primary">Send Notification</button>
                        <button class="btn-secondary">Templates</button>
                    </div>
                </div>
                
                <div class="notification-composer">
                    <div class="dashboard-card">
                        <div class="card-header">
                            <h3>Send New Notification</h3>
                        </div>
                        <div class="composer-form">
                            <div class="form-group">
                                <label>Recipient Type</label>
                                <select class="filter-select">
                                    <option>All Users</option>
                                    <option>Customers Only</option>
                                    <option>Service Providers Only</option>
                                    <option>Specific User</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Title</label>
                                <input type="text" class="filter-input" placeholder="Notification title">
                            </div>
                            <div class="form-group">
                                <label>Message</label>
                                <textarea class="message-textarea" placeholder="Enter your message here..."></textarea>
                            </div>
                            <button class="btn-primary">Send Now</button>
                        </div>
                    </div>
                </div>
                
                <div class="dashboard-card">
                    <div class="card-header">
                        <h3>Recent Notifications</h3>
                    </div>
                    <div class="table-container">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Recipients</th>
                                    <th>Sent Date</th>
                                    <th>Delivery Rate</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Service Update</td>
                                    <td>All Users (1,234)</td>
                                    <td>2024-01-25</td>
                                    <td>98.5%</td>
                                    <td><span class="status-badge completed">Delivered</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        `,
        
        reports: `
            <section class="content-section active">
                <div class="section-header">
                    <h2>Reports & Analytics</h2>
                    <div class="section-actions">
                        <button class="btn-primary">Generate Report</button>
                        <button class="btn-secondary">Export Data</button>
                    </div>
                </div>
                
                <div class="reports-grid">
                    <div class="report-card">
                        <div class="report-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h3>Revenue Report</h3>
                        <p>Monthly revenue analysis and trends</p>
                        <button class="btn-secondary">View Report</button>
                    </div>
                    
                    <div class="report-card">
                        <div class="report-icon">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <h3>Booking Analytics</h3>
                        <p>Booking patterns and statistics</p>
                        <button class="btn-secondary">View Report</button>
                    </div>
                    
                    <div class="report-card">
                        <div class="report-icon">
                            <i class="fas fa-star"></i>
                        </div>
                        <h3>Provider Performance</h3>
                        <p>Service provider ratings and metrics</p>
                        <button class="btn-secondary">View Report</button>
                    </div>
                    
                    <div class="report-card">
                        <div class="report-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <h3>User Analytics</h3>
                        <p>User engagement and retention metrics</p>
                        <button class="btn-secondary">View Report</button>
                    </div>
                </div>
                
                <div class="dashboard-card">
                    <div class="card-header">
                        <h3>Quick Stats</h3>
                    </div>
                    <div class="quick-stats">
                        <div class="quick-stat">
                            <span class="stat-label">Today's Revenue</span>
                            <span class="stat-value">₹12,450</span>
                        </div>
                        <div class="quick-stat">
                            <span class="stat-label">New Registrations</span>
                            <span class="stat-value">23</span>
                        </div>
                        <div class="quick-stat">
                            <span class="stat-label">Avg. Rating</span>
                            <span class="stat-value">4.8/5</span>
                        </div>
                    </div>
                </div>
            </section>
        `,
        
        complaints: `
            <section class="content-section active">
                <div class="section-header">
                    <h2>Complaints & Disputes</h2>
                    <div class="section-actions">
                        <button class="btn-primary">New Complaint</button>
                        <button class="btn-secondary">Export Report</button>
                    </div>
                </div>
                
                <div class="complaints-stats">
                    <div class="stat-card">
                        <h3>15</h3>
                        <p>Open Complaints</p>
                        <span class="stat-change negative">+3</span>
                    </div>
                    <div class="stat-card">
                        <h3>89</h3>
                        <p>Resolved This Month</p>
                        <span class="stat-change positive">+12%</span>
                    </div>
                    <div class="stat-card">
                        <h3>4.2</h3>
                        <p>Avg. Resolution Time (hrs)</p>
                        <span class="stat-change positive">-0.5</span>
                    </div>
                </div>
                
                <div class="dashboard-card">
                    <div class="table-container">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Complaint ID</th>
                                    <th>Customer</th>
                                    <th>Type</th>
                                    <th>Priority</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>#C001</td>
                                    <td>John Doe</td>
                                    <td>Service Quality</td>
                                    <td><span class="priority-badge high">High</span></td>
                                    <td><span class="status-badge pending">Open</span></td>
                                    <td>2024-01-25</td>
                                    <td>
                                        <button class="action-btn view">View</button>
                                        <button class="action-btn approve">Resolve</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        `,
        
        content: `
            <section class="content-section active">
                <div class="section-header">
                    <h2>Content Management</h2>
                    <div class="section-actions">
                        <button class="btn-primary">Add Content</button>
                        <button class="btn-secondary">Manage Media</button>
                    </div>
                </div>
                
                <div class="content-grid">
                    <div class="content-card">
                        <div class="content-icon">
                            <i class="fas fa-image"></i>
                        </div>
                        <h3>Banners</h3>
                        <p>Manage homepage and promotional banners</p>
                        <div class="content-stats">
                            <span>5 Active</span>
                            <span>2 Scheduled</span>
                        </div>
                        <button class="btn-secondary">Manage</button>
                    </div>
                    
                    <div class="content-card">
                        <div class="content-icon">
                            <i class="fas fa-question-circle"></i>
                        </div>
                        <h3>FAQs</h3>
                        <p>Frequently asked questions management</p>
                        <div class="content-stats">
                            <span>25 Questions</span>
                            <span>3 Categories</span>
                        </div>
                        <button class="btn-secondary">Manage</button>
                    </div>
                    
                    <div class="content-card">
                        <div class="content-icon">
                            <i class="fas fa-tags"></i>
                        </div>
                        <h3>Offers</h3>
                        <p>Special offers and promotional content</p>
                        <div class="content-stats">
                            <span>8 Active</span>
                            <span>12 Expired</span>
                        </div>
                        <button class="btn-secondary">Manage</button>
                    </div>
                    
                    <div class="content-card">
                        <div class="content-icon">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <h3>Static Pages</h3>
                        <p>Terms, privacy policy, about us pages</p>
                        <div class="content-stats">
                            <span>6 Pages</span>
                            <span>All Updated</span>
                        </div>
                        <button class="btn-secondary">Manage</button>
                    </div>
                </div>
            </section>
        `,
        
        leads: `
            <section class="content-section active">
                <div class="section-header">
                    <h2>Lead Management</h2>
                    <div class="section-actions">
                        <button class="btn-primary">Add New Lead</button>
                        <button class="btn-secondary">Import Leads</button>
                    </div>
                </div>
                
                <div class="leads-stats">
                    <div class="stat-card">
                        <h3>45</h3>
                        <p>New Leads</p>
                        <span class="stat-change positive">+8</span>
                    </div>
                    <div class="stat-card">
                        <h3>23</h3>
                        <p>Follow-ups Due</p>
                        <span class="stat-change neutral">Today</span>
                    </div>
                    <div class="stat-card">
                        <h3>12</h3>
                        <p>Converted</p>
                        <span class="stat-change positive">+5</span>
                    </div>
                    <div class="stat-card">
                        <h3>65%</h3>
                        <p>Conversion Rate</p>
                        <span class="stat-change positive">+3%</span>
                    </div>
                </div>
                
                <div class="dashboard-card">
                    <div class="card-header">
                        <h3>Lead Pipeline</h3>
                        <div class="lead-filters">
                            <select class="filter-select">
                                <option>All Leads</option>
                                <option>New</option>
                                <option>Contacted</option>
                                <option>Qualified</option>
                                <option>Converted</option>
                                <option>Lost</option>
                            </select>
                        </div>
                    </div>
                    <div class="table-container">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Lead ID</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Service Interest</th>
                                    <th>Status</th>
                                    <th>Last Contact</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>#L001</td>
                                    <td>Mike Johnson</td>
                                    <td>+91 98765 43210</td>
                                    <td>House Cleaning</td>
                                    <td><span class="status-badge pending">New</span></td>
                                    <td>2024-01-25</td>
                                    <td>
                                        <button class="action-btn edit">Contact</button>
                                        <button class="action-btn approve">Convert</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        `
    };
    
    return contents[section] || '<div class="loading">Loading content...</div>';
}

// Additional utility functions
function showNotification(message, type = 'info') {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `notification ${type}`;
    notification.textContent = message;
    
    // Add to page
    document.body.appendChild(notification);
    
    // Remove after 3 seconds
    setTimeout(() => {
        notification.remove();
    }, 3000);
}

// Initialize charts (placeholder for Chart.js integration)
function initializeCharts() {
    const chartCanvas = document.getElementById('revenueChart');
    if (chartCanvas) {
        // Chart.js implementation would go here
        console.log('Charts initialized');
    }
}
