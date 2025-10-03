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
            <a href="{{ route('coupons.create') }}" class="btn btn-primary">Create Coupon</a>
        </div>
    </div>
    <div class="content-area">
        <!-- Dashboard Section -->
        <section id="dashboard-section" class="content-section active">
            <div class="dashboard-card">
                <div class="card-header">
                    <h3>Coupons Management</h3>
                </div>
                <div class="table-container">
                    <table class="data-table ">
                        <thead>
                            <tr>
                                <th>Sr.</th>
                                <th>Code</th>
                                <th>Description</th>
                                <th>Discount</th>
                                <th>Expiry Date</th>
                                <th>Usage Limit</th>
                                <th>Used</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($coupons as $coupon)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $coupon->code }}</td>
                                    <td>{{ Str::limit($coupon->description, 50) }}</td>
                                    <td>
                                        {{ $coupon->discount_value }}
                                        @if ($coupon->discount_type == 'percentage')
                                            %
                                        @else
                                            {{ config('app.currency', 'AED') }}
                                        @endif
                                    </td>
                                    <td>{{ $coupon->expiry_date->format('d/m/Y') }}</td>
                                    <td>{{ $coupon->usage_limit ?: 'Unlimited' }}</td>
                                    <td>{{ $coupon->used_count }}</td>
                                    <td>
                                        @if ($coupon->status == 1)
                                            <span class="status-badge completed"> Active </span>
                                        @else
                                            <span class="status-badge pending"> Inactive </span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex gap-1 justify-content-center">
                                            <a href="{{ route('coupons.view', $coupon->id) }}">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('coupons.edit', $coupon->id) }}">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form method="POST" action="{{ route('coupons.delete', $coupon->id) }}"
                                                style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    onclick="return confirm('Are you sure you want to delete this coupon?')"
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
