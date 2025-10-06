@extends('admin.layouts.masterlayout')

@section('content')
    <style>
        th,
        td {
            text-align: center;
            vertical-align: middle;
            /* optional, keeps content vertically centered */
        }

        .td-content {
            display: flex;
            align-items: center;
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
            font-size: 14px;
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
    </style>


    <!-- Content Area -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <div class="header-right mt-3 mx-3">
        <div class="search-box">
            <a href="{{ route('faq.create') }}" class="modern-btn modern-btn-primary">
                <i class="fas fa-plus"></i>
                <span>Create FAQ</span>
            </a>
        </div>
    </div>
    <div class="content-area">
        <!-- Dashboard Section -->
        <section id="dashboard-section" class="content-section active">
            <div class="dashboard-card">
                <div class="card-header">
                    <h3>FAQ's Management</h3>
                </div>
                <div class="table-container">
                    <table class="data-table ">
                        <thead>
                            <tr>
                                <th>Sr.</th>
                                <th>Service</th>
                                <th>Question</th>
                                <th>Answer</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($faqs as $faq)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $faq->service->name ?? 'N/A' }}</td>
                                    <td>{{ Str::limit($faq->question, 50) }}</td>
                                    <td>{{ Str::limit($faq->answer, 100) }}</td>
                                    <td>
                                        @if ($faq->status == 1)
                                            <span class="status-badge completed"> Active </span>
                                        @else
                                            <span class="status-badge pending"> Inactive </span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="td-content">
                                            <div class="action-buttons">
                                                <a href="{{ route('faq.view', $faq->id) }}"
                                                    class="action-btn action-view" title="View Details">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('faq.edit', $faq->id) }}"
                                                    class="action-btn action-edit" title="Edit FAQ">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button type="button" class="action-btn action-delete"
                                                    title="Delete FAQ"
                                                    onclick="deleteFAQ({{ $faq->id }}, '{{ Str::limit($faq->question, 20) }}')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach


                        </tbody>
                    </table>


        </section>

    </div>

    <!-- Delete Form (Hidden) -->
    <form id="deleteForm" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

    <script>
        $(document).ready(function() {
            setTimeout(function() {
                $('.alert-success').fadeOut('slow');
            }, 3000);
        });

        function deleteFAQ(id, question) {
            if (confirm(`Are you sure you want to delete the FAQ "${question}"? This action cannot be undone.`)) {
                const form = document.getElementById('deleteForm');
                form.action = `/faq/${id}`;
                form.submit();
            }
        }
    </script>
@endsection
