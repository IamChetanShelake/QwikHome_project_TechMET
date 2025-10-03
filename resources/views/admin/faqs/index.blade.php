@extends('admin.layouts.masterlayout')

@section('content')
    <style>
        th,
        td {
            text-align: center;
            vertical-align: middle;
            /* optional, keeps content vertically centered */
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
            <a href="{{ route('faq.create') }}" class="btn btn-primary">Create FAQ</a>
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
                                        <div class="d-flex gap-1 justify-content-center">
                                            <a href="{{ route('faq.view', $faq->id) }}">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('faq.edit', $faq->id) }}">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form method="POST" action="{{ route('faq.delete', $faq->id) }}"
                                                style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    onclick="return confirm('Are you sure you want to delete this FAQ?')"
                                                    class="btn btn-sm btn-danger p-0">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach


                        </tbody>
                    </table>


        </section>

    </div>

    <script>
        $(document).ready(function() {
            setTimeout(function() {
                $('.alert-success').fadeOut('slow');
            }, 3000);
        });
    </script>
@endsection
