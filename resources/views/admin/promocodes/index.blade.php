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
            <a href="{{ route('promocodes.create') }}" class="btn btn-primary">Create Promocode</a>
        </div>
    </div>
    <div class="content-area">
        <!-- Dashboard Section -->
        <section id="dashboard-section" class="content-section active">
            <div class="dashboard-card">
                <div class="card-header">
                    <h3>Promocodes Management</h3>
                </div>
                <div class="table-container">
                    <table class="data-table ">
                        <thead>
                            <tr>
                                <th>Sr.</th>
                                <th>Code</th>
                                <th>Discount</th>
                                <th>For Active Subscription</th>
                                <th>Used</th>
                                <th>Expiry Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($promocodes as $promocode)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $promocode->code }}</td>
                                    <td>{{ number_format($promocode->discount, 2) }} {{ config('app.currency', 'AED') }}</td>
                                    <td>
                                        @if ($promocode->for_active_subscription)
                                            <span class="status-badge completed"> Yes </span>
                                        @else
                                            <span class="status-badge pending"> No </span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($promocode->is_used)
                                            <span class="status-badge pending"> Used </span>
                                        @else
                                            <span class="status-badge completed"> Not Used </span>
                                        @endif
                                    </td>
                                    <td>{{ $promocode->expiry_date ? $promocode->expiry_date->format('d/m/Y') : 'No Expiry' }}</td>
                                    <td>
                                        <div class="d-flex gap-1 justify-content-center">
                                            <a href="{{ route('promocodes.view', $promocode->id) }}">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('promocodes.edit', $promocode->id) }}">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form method="POST" action="{{ route('promocodes.delete', $promocode->id) }}"
                                                style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    onclick="return confirm('Are you sure you want to delete this promocode?')"
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
