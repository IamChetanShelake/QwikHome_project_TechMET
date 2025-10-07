@extends('admin.layouts.masterlayout')

@section('content')
    <div class="content-area">
        <div class="modern-list-container">
            <!-- Success Message -->
            @if (session('success'))
                <div class="modern-alert modern-alert-success" id="successAlert">
                    <div class="alert-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="alert-content">
                        <strong>Success!</strong>
                        <span>{{ session('success') }}</span>
                    </div>
                    <button class="alert-close" onclick="closeAlert()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            @endif

            <!-- Header Section -->
            <div class="list-header-section">
                <div class="list-header-content">
                    <div class="list-title-group">
                        <div class="list-icon-wrapper">
                            <i class="fas fa-user-plus list-main-icon"></i>
                        </div>
                        <div class="list-title-text">
                            <h2 class="list-title">Employee Management</h2>
                            <p class="list-subtitle">Manage service provider accounts and their access to the platform</p>
                        </div>
                    </div>
                    <a href="{{ route('serviceProviders.create') }}" class="modern-btn modern-btn-primary">
                        <i class="fas fa-plus"></i>
                        <span>Add New Employee</span>
                    </a>
                </div>
            </div>

            <!-- Search Section -->
            <div class="search-section">
                <div class="search-wrapper">
                    <div class="search-input-group">
                        <i class="fas fa-search search-icon"></i>
                        <input type="text" id="searchInput" placeholder="Search by name, email, or mobile..." class="search-input">
                    </div>
                </div>
            </div>

            <!-- Table Section -->
            <div class="modern-table-card">
                <div class="table-wrapper">
                    <table class="modern-table">
                        <thead>
                            <tr>
                                <th>
                                    <div class="th-content">
                                        <i class="fas fa-hashtag"></i>
                                        <span>Sr.</span>
                                    </div>
                                </th>
                                <th>
                                    <div class="th-content">
                                        <i class="fas fa-image"></i>
                                        <span>Photo</span>
                                    </div>
                                </th>
                                <th>
                                    <div class="th-content">
                                        <i class="fas fa-user"></i>
                                        <span>Name</span>
                                    </div>
                                </th>
                                <th>
                                    <div class="th-content">
                                        <i class="fas fa-envelope"></i>
                                        <span>Email</span>
                                    </div>
                                </th>
                                <th>
                                    <div class="th-content">
                                        <i class="fas fa-phone"></i>
                                        <span>Phone</span>
                                    </div>
                                </th>
                                <th>
                                    <div class="th-content">
                                        <i class="fas fa-map-marker-alt"></i>
                                        <span>Address</span>
                                    </div>
                                </th>
                                <th>
                                    <div class="th-content">
                                        <i class="fas fa-calendar"></i>
                                        <span>Joined Date</span>
                                    </div>
                                </th>
                                <th>
                                    <div class="th-content">
                                        <i class="fas fa-cogs"></i>
                                        <span>Actions</span>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($serviceProviders as $serviceProvider)
                                <tr class="table-row" data-id="{{ $serviceProvider->id }}">
                                    <td>
                                        <div class="td-content">
                                            <span class="serial-number">{{ $loop->iteration }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        @if ($serviceProvider->image)
                                            <img src="{{ asset('user_images/' . $serviceProvider->image) }}"
                                                alt="{{ $serviceProvider->name }}" class="user-avatar-small">
                                        @else
                                            <div class="user-avatar-small no-image">
                                                <i class="fas fa-user"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="td-content">
                                            <div class="user-info">
                                                <span class="user-name">{{ $serviceProvider->name }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="td-content">
                                            <div class="email-badge">
                                                <i class="fas fa-envelope"></i>
                                                <span>{{ $serviceProvider->email ?? 'Not provided' }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="td-content">
                                            <div class="phone-number">
                                                <i class="fas fa-phone"></i>
                                                <span>{{ $serviceProvider->phone ?? 'Not provided' }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="td-content">
                                            <div class="address-text" title="{{ $serviceProvider->address }}">
                                                {{ Str::limit($serviceProvider->address ?? 'Not provided', 30) }}
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="td-content">
                                            <div class="joined-date">
                                                <i class="fas fa-calendar-check"></i>
                                                <span>{{ $serviceProvider->created_at->format('d/m/Y') }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="td-content">
                                            <div class="action-buttons">
                                                <a href="{{ route('serviceProviders.show', $serviceProvider->id) }}"
                                                    class="action-btn action-view" title="View Details">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('serviceProviders.edit', $serviceProvider->id) }}"
                                                    class="action-btn action-edit" title="Edit Employee">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button type="button" class="action-btn action-delete"
                                                    title="Delete Employee"
                                                    onclick="deleteEmployee({{ $serviceProvider->id }}, '{{ $serviceProvider->name }}')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8">
                                        <div class="empty-state">
                                            <div class="empty-icon">
                                                <i class="fas fa-user-plus"></i>
                                            </div>
                                            <h3>No Employees Found</h3>
                                            <p>Start by creating your first employee account</p>
                                            <a href="{{ route('serviceProviders.create') }}"
                                                class="modern-btn modern-btn-primary">
                                                <i class="fas fa-plus"></i>
                                                <span>Add First Employee</span>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Form (Hidden) -->
    <form id="deleteForm" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

    <style>
        /* Modern List Styles */
        .modern-list-container {
            max-width: 1600px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Alert Styles */
        .modern-alert {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 16px 20px;
            border-radius: 12px;
            margin-bottom: 20px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            animation: slideInDown 0.3s ease;
        }

        .modern-alert-success {
            background: rgba(34, 197, 94, 0.1);
            border-color: rgba(34, 197, 94, 0.3);
            color: #22c55e;
        }

        .alert-icon {
            font-size: 20px;
        }

        .alert-content {
            flex: 1;
        }

        .alert-content strong {
            display: block;
            font-weight: 600;
            margin-bottom: 2px;
        }

        .alert-close {
            background: none;
            border: none;
            color: inherit;
            cursor: pointer;
            padding: 4px;
            border-radius: 4px;
            transition: background-color 0.2s;
        }

        .alert-close:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        /* Header Styles */
        .list-header-section {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border-radius: 20px 20px 0 0;
            padding: 30px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-bottom: none;
        }

        .list-header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
        }

        .list-title-group {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .list-icon-wrapper {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #00d4ff, #0099cc);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 25px rgba(0, 212, 255, 0.3);
        }

        .list-main-icon {
            font-size: 24px;
            color: white;
        }

        .list-title {
            font-size: 28px;
            font-weight: 700;
            color: #ffffff;
            margin: 0;
            background: linear-gradient(135deg, #ffffff, #00d4ff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .list-subtitle {
            color: rgba(255, 255, 255, 0.7);
            margin: 5px 0 0 0;
        }

        /* Search Section */
        .search-section {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(10px);
            padding: 20px 30px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-top: none;
        }

        .search-wrapper {
            max-width: 600px;
        }

        .search-input-group {
            position: relative;
            display: flex;
            align-items: center;
        }

        .search-icon {
            position: absolute;
            left: 16px;
            color: rgba(255, 255, 255, 0.5);
            font-size: 16px;
        }

        .search-input {
            width: 100%;
            padding: 14px 16px 14px 50px;
            background: rgba(255, 255, 255, 0.05);
            border: 2px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            color: #ffffff;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .search-input:focus {
            outline: none;
            border-color: #00d4ff;
            background: rgba(255, 255, 255, 0.08);
            box-shadow: 0 0 15px rgba(0, 212, 255, 0.2);
        }

        .search-input::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }

        /* Table Styles */
        .modern-table-card {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(15px);
            border-radius: 0 0 20px 20px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-top: none;
            overflow: hidden;
        }

        .table-wrapper {
            overflow-x: auto;
        }

        .modern-table {
            width: 100%;
            border-collapse: collapse;
        }

        .modern-table th {
            background: rgba(255, 255, 255, 0.05);
            padding: 20px 16px;
            text-align: left;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .th-content {
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 600;
            color: #ffffff;
        }

        .th-content i {
            color: #00d4ff;
        }

        .modern-table td {
            padding: 20px 16px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .table-row {
            transition: all 0.3s ease;
        }

        .table-row:hover {
            background: rgba(255, 255, 255, 0.03);
        }

        .td-content {
            display: flex;
            align-items: center;
        }

        /* Content Styles */
        .serial-number {
            color: rgba(255, 255, 255, 0.7);
            font-weight: 500;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-avatar-small {
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid rgba(0, 212, 255, 0.3);
        }

        .user-avatar-small.no-image {
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(0, 212, 255, 0.1);
            color: #00d4ff;
        }

        .user-name {
            color: #ffffff;
            font-weight: 600;
        }

        .email-badge {
            display: flex;
            align-items: center;
            gap: 6px;
            color: rgba(255, 255, 255, 0.8);
        }

        .phone-number {
            display: flex;
            align-items: center;
            gap: 6px;
            color: rgba(255, 255, 255, 0.8);
        }

        .address-text {
            color: rgba(255, 255, 255, 0.8);
            max-width: 150px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .joined-date {
            display: flex;
            align-items: center;
            gap: 6px;
            color: rgba(255, 255, 255, 0.8);
        }

        .joined-date i {
            color: #00d4ff;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 8px;
        }

        .action-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .action-view {
            background: rgba(59, 130, 246, 0.1);
            color: #3b82f6;
            border: 1px solid rgba(59, 130, 246, 0.3);
        }

        .action-view:hover {
            background: rgba(59, 130, 246, 0.2);
            transform: translateY(-2px);
        }

        .action-edit {
            background: rgba(245, 158, 11, 0.1);
            color: #f59e0b;
            border: 1px solid rgba(245, 158, 11, 0.3);
        }

        .action-edit:hover {
            background: rgba(245, 158, 11, 0.2);
            transform: translateY(-2px);
        }

        .action-delete {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
            border: 1px solid rgba(239, 68, 68, 0.3);
        }

        .action-delete:hover {
            background: rgba(239, 68, 68, 0.2);
            transform: translateY(-2px);
        }

        /* Button Styles */
        .modern-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 14px 28px;
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .modern-btn-primary {
            background: linear-gradient(135deg, #00d4ff, #0099cc);
            color: white;
            box-shadow: 0 8px 25px rgba(0, 212, 255, 0.3);
        }

        .modern-btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 35px rgba(0, 212, 255, 0.4);
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: rgba(255, 255, 255, 0.7);
        }

        .empty-icon {
            font-size: 48px;
            color: rgba(255, 255, 255, 0.3);
            margin-bottom: 20px;
        }

        .empty-state h3 {
            font-size: 20px;
            color: #ffffff;
            margin-bottom: 8px;
        }

        .empty-state p {
            margin-bottom: 24px;
        }

        /* Animations */
        @keyframes slideInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .modern-list-container {
                padding: 10px;
            }

            .list-header-section {
                padding: 20px;
            }

            .list-header-content {
                flex-direction: column;
                align-items: flex-start;
            }

            .search-section {
                padding: 15px 20px;
            }

            .modern-table th,
            .modern-table td {
                padding: 12px 8px;
            }

            .action-buttons {
                flex-direction: column;
                gap: 4px;
            }

            .address-text {
                max-width: 100px;
            }
        }
    </style>

    <script>
        // Auto-hide success alert
        document.addEventListener('DOMContentLoaded', function() {
            const successAlert = document.getElementById('successAlert');
            if (successAlert) {
                setTimeout(function() {
                    successAlert.style.opacity = '0';
                    setTimeout(function() {
                        successAlert.remove();
                    }, 300);
                }, 3000);
            }
        });

        function closeAlert() {
            const alerts = document.querySelectorAll('.modern-alert');
            alerts.forEach(alert => {
                alert.style.opacity = '0';
                setTimeout(function() {
                    alert.remove();
                }, 300);
            });
        }

        // Search functionality
        document.getElementById('searchInput').addEventListener('input', function() {
            let query = this.value.trim();

            // Debounce the search
            clearTimeout(this.searchTimeout);
            this.searchTimeout = setTimeout(() => {
                if (query.length >= 2) {
                    fetch(`/admin/search-service-providers?query=${encodeURIComponent(query)}`)
                        .then(response => response.json())
                        .then(data => {
                            updateTable(data);
                        })
                        .catch(error => console.error('Search error:', error));
                } else if (query.length === 0) {
                    // Restore original table when search is cleared
                    location.reload();
                }
            }, 500);
        });

        function updateTable(serviceProviders) {
            const tbody = document.querySelector('.modern-table tbody');
            tbody.innerHTML = '';

            if (serviceProviders.length > 0) {
                serviceProviders.forEach((provider, index) => {
                    let imageHTML = provider.image ?
                        `<img src="/user_images/${provider.image}" alt="${provider.name}" class="user-avatar-small">` :
                        `<div class="user-avatar-small no-image"><i class="fas fa-user"></i></div>`;

                    let actionHTML = `
                        <div class="action-buttons">
                            <a href="/serviceProviders/${provider.id}" class="action-btn action-view" title="View Details">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="/serviceProviders/${provider.id}/edit" class="action-btn action-edit" title="Edit Employee">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button type="button" class="action-btn action-delete"
                                title="Delete Employee"
                                onclick="deleteEmployee(${provider.id}, '${provider.name}')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    `;

                    let rowHTML = `
                        <tr class="table-row">
                            <td><div class="td-content"><span class="serial-number">${index + 1}</span></div></td>
                            <td>${imageHTML}</td>
                            <td><div class="td-content"><div class="user-info"><span class="user-name">${provider.name}</span></div></div></td>
                            <td><div class="td-content"><div class="email-badge"><i class="fas fa-envelope"></i><span>${provider.email || 'Not provided'}</span></div></div></td>
                            <td><div class="td-content"><div class="phone-number"><i class="fas fa-phone"></i><span>${provider.phone || 'Not provided'}</span></div></div></td>
                            <td><div class="td-content"><div class="address-text" title="${provider.address || ''}">${(provider.address || 'Not provided').substring(0, 30)}${(provider.address && provider.address.length > 30) ? '...' : ''}</div></div></td>
                            <td><div class="td-content"><div class="joined-date"><i class="fas fa-calendar-check"></i><span>${new Date(provider.created_at).toLocaleDateString()}</span></div></div></td>
                            <td><div class="td-content">${actionHTML}</div></td>
                        </tr>
                    `;
                    tbody.innerHTML += rowHTML;
                });
            } else {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="8">
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <i class="fas fa-search"></i>
                                </div>
                                <h3>No Results Found</h3>
                                <p>No employees match your search criteria.</p>
                            </div>
                        </td>
                    </tr>
                `;
            }
        }

        function deleteEmployee(id, name) {
            if (confirm(`Are you sure you want to delete the employee "${name}"? This action cannot be undone.`)) {
                const form = document.getElementById('deleteForm');
                form.action = `/serviceProviders/${id}`;
                form.submit();
            }
        }
    </script>
@endsection
