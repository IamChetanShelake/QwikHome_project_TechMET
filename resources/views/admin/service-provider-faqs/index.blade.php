@extends('admin.layouts.masterlayout')

@section('content')
<style>
    /* Modern Form Styles */
    .modern-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 20px;
    }

    .modern-header {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        border-radius: 20px 20px 0 0;
        padding: 30px;
        border: 1px solid rgba(0, 0, 0, 0.1);
        border-bottom: none;
    }

    .header-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 20px;
    }

    .header-title-group {
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
        box-shadow: 0 8px 25px rgba(0, 212, 255, 0.3);
    }

    .header-icon {
        font-size: 24px;
        color: white;
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

    .modern-card {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(15px);
        border-radius: 0 0 20px 20px;
        border: 1px solid rgba(0, 0, 0, 0.1);
        border-top: none;
        padding: 40px;
        overflow: hidden;
    }

    .search-section {
        display: flex;
        gap: 15px;
        align-items: center;
        margin-bottom: 30px;
        flex-wrap: wrap;
    }

    .search-input {
        flex: 1;
        min-width: 250px;
        padding: 14px 20px;
        background: rgba(255, 255, 255, 0.9);
        border: 2px solid rgba(0, 0, 0, 0.1);
        border-radius: 12px;
        color: #334155;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    .search-input:focus {
        outline: none;
        border-color: #00d4ff;
        background: rgba(0, 212, 255, 0.05);
        box-shadow: 0 0 20px rgba(0, 212, 255, 0.2);
    }

    .modern-btn {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 12px 24px;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
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

    .modern-btn-secondary {
        background: rgba(0, 0, 0, 0.1);
        color: #334155;
        border: 2px solid rgba(0, 0, 0, 0.2);
    }

    .modern-btn-secondary:hover {
        background: rgba(0, 0, 0, 0.15);
        border-color: #00d4ff;
        color: #00d4ff;
    }

    .modern-table {
        width: 100%;
        background: rgba(255, 255, 255, 0.9);
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid rgba(0, 0, 0, 0.1);
    }

    .modern-table thead {
        background: linear-gradient(135deg, #00d4ff, #0099cc);
        color: white;
    }

    .modern-table th {
        padding: 16px 20px;
        font-weight: 600;
        font-size: 14px;
        text-align: left;
    }

    .modern-table td {
        padding: 16px 20px;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        color: #334155;
    }

    .modern-table tbody tr:hover {
        background: rgba(0, 212, 255, 0.03);
    }

    .status-badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
    }

    .status-active {
        background: rgba(34, 197, 94, 0.1);
        color: #16a34a;
    }

    .status-inactive {
        background: rgba(239, 68, 68, 0.1);
        color: #dc2626;
    }

    .actions-column {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }

    .btn-action {
        padding: 8px 12px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .btn-view {
        background: rgba(59, 130, 246, 0.1);
        color: #3b82f6;
        border: 1px solid rgba(59, 130, 246, 0.2);
    }

    .btn-edit {
        background: rgba(245, 158, 11, 0.1);
        color: #d97706;
        border: 1px solid rgba(245, 158, 11, 0.2);
    }

    .btn-delete {
        background: rgba(239, 68, 68, 0.1);
        color: #dc2626;
        border: 1px solid rgba(239, 68, 68, 0.2);
    }

    .btn-action:hover {
        transform: translateY(-1px);
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: rgba(51, 65, 85, 0.6);
    }

    .empty-icon {
        width: 80px;
        height: 80px;
        margin: 0 auto 20px;
        background: rgba(0, 212, 255, 0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .pagination-modern {
        display: flex;
        justify-content: center;
        margin-top: 40px;
    }

    .pagination-modern .page-link {
        color: #00d4ff;
        border-color: rgba(0, 212, 255, 0.3);
        padding: 8px 16px;
        margin: 0 4px;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .pagination-modern .page-link:hover {
        background: #00d4ff;
        border-color: #00d4ff;
    }

    .pagination-modern .page-item.active .page-link {
        background: #00d4ff;
        border-color: #00d4ff;
    }

    @media (max-width: 768px) {
        .modern-container {
            padding: 10px;
        }

        .modern-header,
        .modern-card {
            padding: 20px;
        }

        .header-content {
            flex-direction: column;
            align-items: flex-start;
        }

        .search-section {
            flex-direction: column;
            align-items: stretch;
        }

        .modern-table {
            font-size: 12px;
        }

        .modern-table th,
        .modern-table td {
            padding: 12px 8px;
        }

        .actions-column {
            flex-direction: column;
            gap: 4px;
        }
    }
</style>

<div class="content-area">
    <div class="modern-container">
        <!-- Header Section -->
        <div class="modern-header">
            <div class="header-content">
                <div class="header-title-group">
                    <div class="header-icon-wrapper">
                        <i class="fas fa-question-circle header-icon"></i>
                    </div>
                    <div class="header-title-text">
                        <h2 class="header-title">Service Provider FAQs</h2>
                        <p class="header-subtitle">Manage frequently asked questions and answers</p>
                    </div>
                </div>
                <a href="{{ route('service-provider-faqs.create') }}" class="modern-btn modern-btn-primary">
                    <i class="fas fa-plus"></i>
                    <span>Add New FAQ</span>
                </a>
            </div>
        </div>

        <!-- Main Content -->
        <div class="modern-card">
            <!-- Search Section -->
            <div class="search-section">
                <form method="GET" style="display: flex; gap: 15px; align-items: center; flex: 1;">
                    <input type="text" name="search" class="search-input" placeholder="Search FAQs..."
                           value="{{ $search }}">
                    <button type="submit" class="modern-btn modern-btn-primary">
                        <i class="fas fa-search"></i>
                        <span>Search</span>
                    </button>
                    @if($search)
                        <a href="{{ route('service-provider-faqs.index') }}" class="modern-btn modern-btn-secondary">
                            <i class="fas fa-times"></i>
                            <span>Clear</span>
                        </a>
                    @endif
                </form>
            </div>

            <!-- Table Section -->
            @if($faqs->count() > 0)
                <div style="overflow-x: auto;">
                    <table class="modern-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Question</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($faqs as $faq)
                            <tr>
                                <td style="font-weight: 600; color: #00d4ff;">#{{ $faq->id }}</td>
                                <td style="max-width: 300px;" title="{{ $faq->question }}">
                                    {{ Str::limit($faq->question, 50) }}
                                </td>
                                <td>
                                    <span class="status-badge {{ $faq->is_active ? 'status-active' : 'status-inactive' }}">
                                        <i class="fas fa-{{ $faq->is_active ? 'check-circle' : 'times-circle' }}"></i>
                                        {{ $faq->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="actions-column">
                                        <a href="{{ route('service-provider-faqs.show', $faq) }}" class="btn-action btn-view">
                                            <i class="fas fa-eye"></i>
                                            View
                                        </a>
                                        <a href="{{ route('service-provider-faqs.edit', $faq) }}" class="btn-action btn-edit">
                                            <i class="fas fa-edit"></i>
                                            Edit
                                        </a>
                                        <form method="POST" action="{{ route('service-provider-faqs.destroy', $faq) }}" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-action btn-delete"
                                                    onclick="return confirm('Are you sure you want to delete this FAQ?')">
                                                <i class="fas fa-trash"></i>
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-question-circle" style="font-size: 30px; color: #00d4ff;"></i>
                    </div>
                    <h4>No FAQs Found</h4>
                    <p>{{ $search ? 'No FAQs match your search criteria.' : 'Start by creating your first FAQ!' }}</p>
                    <a href="{{ route('service-provider-faqs.create') }}" class="modern-btn modern-btn-primary" style="margin-top: 15px;">
                        <i class="fas fa-plus"></i>
                        <span>Create First FAQ</span>
                    </a>
                </div>
            @endif

            <!-- Pagination -->
            @if($faqs->hasPages())
                <div class="pagination-modern">
                    {{ $faqs->appends(['search' => $search])->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
