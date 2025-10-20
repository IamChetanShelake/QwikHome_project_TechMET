@extends('admin.layouts.masterlayout')

@section('content')
<div class="modern-index-container">
    <!-- Alert System -->
    <div id="alertContainer" class="alert-container"></div>

    <!-- Header Section -->
    <div class="index-header-section">
        <div class="header-content">
            <div class="header-icon-wrapper">
                <i class="fas fa-question-circle"></i>
            </div>
            <div class="header-text">
                <h1 class="header-title">FAQ Management</h1>
                <p class="header-subtitle">Manage frequently asked questions for all services</p>
            </div>
        </div>
        <div class="header-actions">
            <a href="{{ route('faq.create') }}" class="modern-btn modern-btn-primary">
                <i class="fas fa-plus"></i>
                Create FAQ
            </a>
        </div>
    </div>

    <!-- Stats Cards Section -->
    <div class="stats-section">
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-concierge-bell"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ $services->count() }}</h3>
                    <p>Total Services</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-question-circle"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ $services->sum('faq_count') }}</h3>
                    <p>Total FAQs</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-layer-group"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ $services->whereNotNull('category')->unique('category_id')->count() }}</h3>
                    <p>Categories</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-tags"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ $services->whereNotNull('subcategory')->unique('subcategory_id')->count() }}</h3>
                    <p>Subcategories</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Alert System -->
    @if (session('success'))
        <div id="successAlert" class="alert alert-success alert-dismissible fade show" role="alert" style="background: rgba(34, 197, 94, 0.1); color: #22c55e; border: 1px solid rgba(34, 197, 94, 0.3); border-radius: 8px; padding: 16px; margin-bottom: 20px;">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="color: #22c55e;"></button>
        </div>
    @endif

    <!-- Table Section -->
    <div class="table-section">
        <div class="table-header">
            <h3 class="table-title">
                <i class="fas fa-list"></i>
                Services & FAQs
            </h3>
            <div class="table-info">
                <span class="record-count">{{ $services->count() }} services found</span>
            </div>
        </div>

        <div class="modern-table-container">
            <table class="modern-table">
                <thead>
                    <tr>
                        <th class="th-sr">
                            <i class="fas fa-hashtag"></i>
                            Sr.
                        </th>
                        <th class="th-service">
                            <i class="fas fa-concierge-bell"></i>
                            Service
                        </th>
                        <th class="th-category">
                            <i class="fas fa-folder"></i>
                            Category
                        </th>
                        <th class="th-subcategory">
                            <i class="fas fa-folder-open"></i>
                            Subcategory
                        </th>
                        <th class="th-faqs">
                            <i class="fas fa-question-circle"></i>
                            Total FAQs
                        </th>
                        <th class="th-actions">
                            <i class="fas fa-cogs"></i>
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($services as $service)
                        <tr class="table-row">
                            <td class="td-sr">{{ $loop->iteration }}</td>
                            <td class="td-service">
                                <span class="service-name">{{ $service->name }}</span>
                            </td>
                            <td class="td-category">
                                <span class="category-name">{{ $service->category->name ?? 'N/A' }}</span>
                            </td>
                            <td class="td-subcategory">
                                <span class="subcategory-name">{{ $service->subcategory->name ?? 'N/A' }}</span>
                            </td>
                            <td class="td-faqs">
                                <span class="faq-count">{{ $service->faq_count }}</span>
                            </td>
                            <td class="td-actions">
                                <div class="action-buttons">
                                    <a href="{{ route('faqs.service.view', $service->id) }}"
                                        class="action-btn action-view" title="View All FAQs for Service">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('faqs.service.edit', $service->id) }}"
                                        class="action-btn action-edit" title="Edit FAQs for Service">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @if($service->faq_count > 0)
                                        <button type="button" class="action-btn action-delete"
                                                onclick="deleteServiceFAQs({{ $service->id }}, '{{ $service->name }}', {{ $service->faq_count }})"
                                                title="Delete All FAQs for Service">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr class="empty-row">
                            <td colspan="6" class="empty-cell">
                                <div class="empty-state">
                                    <i class="fas fa-concierge-bell"></i>
                                    <h3>No Services Found</h3>
                                    <p>No services are available to manage FAQs.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    /* Modern FAQ Index Styling - Same as Services */
    .modern-index-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 20px;
    }

    .alert-container {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 1000;
    }

    .index-header-section {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        padding: 30px;
        border: 1px solid rgba(0, 0, 0, 0.1);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 20px;
        margin-bottom: 20px;
    }

    .header-content {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .header-icon-wrapper {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, #00d4ff, #0099cc);
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        color: white;
        box-shadow: 0 8px 25px rgba(0, 212, 255, 0.3);
    }

    .header-title {
        font-size: 28px;
        font-weight: 700;
        color: #334155;
        margin: 0;
    }

    .header-subtitle {
        font-size: 14px;
        color: rgba(51, 65, 85, 0.7);
        margin: 5px 0 0 0;
    }

    .header-actions {
        display: flex;
        gap: 15px;
    }

    .stats-section {
        margin-bottom: 20px;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
    }

    .stat-card {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(15px);
        border-radius: 15px;
        border: 1px solid rgba(0, 0, 0, 0.1);
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 15px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .stat-icon {
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, #00d4ff, #0099cc);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        color: white;
    }

    .stat-content h3 {
        font-size: 24px;
        font-weight: 700;
        color: #334155;
        margin: 0;
    }

    .stat-content p {
        font-size: 12px;
        color: rgba(51, 65, 85, 0.7);
        margin: 5px 0 0 0;
        font-weight: 500;
    }

    .table-section {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(15px);
        border-radius: 15px;
        border: 1px solid rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .table-header {
        padding: 25px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .table-title {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 18px;
        font-weight: 600;
        color: #334155;
        margin: 0;
    }

    .record-count {
        color: rgba(51, 65, 85, 0.7);
        font-size: 14px;
    }

    .modern-table-container {
        overflow-x: auto;
    }

    .modern-table {
        width: 100%;
        border-collapse: collapse;
    }

    .modern-table th {
        background: rgba(255, 255, 255, 0.95);
        padding: 15px;
        text-align: left;
        font-weight: 600;
        color: #334155;
        border-bottom: 2px solid rgba(0, 0, 0, 0.1);
        font-size: 14px;
    }

    .modern-table th i {
        margin-right: 8px;
    }

    .modern-table td {
        padding: 15px;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        color: #334155;
        vertical-align: middle;
    }

    .table-row:hover {
        background: rgba(0, 0, 0, 0.02);
    }

    .service-name,
    .category-name,
    .subcategory-name {
        font-weight: 500;
        font-size: 14px;
        color: rgba(51, 65, 85, 0.9);
    }

    .faq-count {
        font-weight: 600;
        color: #334155;
        display: inline-block;
        background: rgba(0, 212, 255, 0.1);
        color: #00d4ff;
        padding: 4px 8px;
        border-radius: 12px;
        font-size: 13px;
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: rgba(51, 65, 85, 0.7);
    }

    .empty-state i {
        font-size: 48px;
        color: rgba(51, 65, 85, 0.3);
        margin-bottom: 20px;
    }

    .empty-state h3 {
        color: #334155;
        margin-bottom: 10px;
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 8px;
        justify-content: center;
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
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 20px;
        border: none;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .modern-btn-primary {
        background: linear-gradient(135deg, #00d4ff, #0099cc);
        color: white;
        box-shadow: 0 4px 15px rgba(0, 212, 255, 0.3);
    }

    .modern-btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 212, 255, 0.4);
        color: white;
    }

    /* Responsive Design */
    @media (max-width: 1024px) {
        .modern-index-container {
            padding: 15px;
        }
    }

    @media (max-width: 768px) {
        .index-header-section {
            flex-direction: column;
            text-align: center;
            gap: 15px;
        }

        .header-content {
            width: 100%;
        }

        .stats-grid {
            grid-template-columns: 1fr;
        }

        .table-header {
            flex-direction: column;
            gap: 15px;
            text-align: center;
        }

        .modern-table {
            font-size: 12px;
        }

        .modern-table th,
        .modern-table td {
            padding: 10px 8px;
        }

        .action-buttons {
            flex-direction: column;
            gap: 4px;
        }

        .action-btn {
            width: 32px;
            height: 32px;
        }
    }

    @media (max-width: 480px) {
        .modern-table th,
        .modern-table td {
            padding: 8px 6px;
        }

        .service-name,
        .category-name,
        .subcategory-name {
            font-size: 13px;
        }

        .faq-count {
            font-size: 12px;
            padding: 2px 6px;
        }
    }
</style>



<script>
    $(document).ready(function() {
        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            $('#successAlert').fadeOut('slow');
        }, 5000);

        // Dismiss alert on close button click
        $('.btn-close').on('click', function() {
            $(this).closest('.alert').fadeOut('fast');
        });
    });

    function deleteServiceFAQs(serviceId, serviceName, faqCount) {
        if (confirm(`Are you sure you want to delete ALL FAQs for the service "${serviceName}"?\n\nThis will permanently delete ${faqCount} FAQ(s).\n\nThis action cannot be undone!`)) {
            // Create a form to submit the delete request
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/faqs/service/${serviceId}/delete-all`;

            // Add CSRF token
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            form.appendChild(csrfToken);

            // Add method spoofing for DELETE
            const methodField = document.createElement('input');
            methodField.type = 'hidden';
            methodField.name = '_method';
            methodField.value = 'DELETE';
            form.appendChild(methodField);

            // Append to body and submit
            document.body.appendChild(form);
            form.submit();
        }
    }
</script>
@endsection
