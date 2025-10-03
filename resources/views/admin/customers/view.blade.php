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
    <div class="header-right mt-3">
        <div class="search-box">

        </div>
    </div>
    <div class="content-area">
        <!-- Dashboard Section -->
        <section id="dashboard-section" class="content-section active">
            <div class="dashboard-card">
                <div class="card-header">
                    <h3>View Customer</h3>
                </div>
                <div class="table-container">
                    <table class="data-table ">
                        <thead>
                            <tr>

                                <th>Id</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Mobile</th>
                                <th>status</th>
                            </tr>
                        </thead>
                        <tbody>


                            <tr>
                                <td>{{ $customer->id }}</td>
                                <td>
                                    @if ($customer->image)
                                        <img src="{{ asset('customer_images/' . $customer->image) }}" alt="Image"
                                            class="designer-img">
                                    @else
                                        <p>No Image</p>
                                    @endif
                                </td>
                                <td>{{ $customer->name }}</td>
                                <td>{{ $customer->email }}</td>
                                <td>{{ $customer->phone }}</td>
                                <td>
                                    @if ($customer->active == 0)
                                        <span class="status-badge active">Active</span>
                                    @else
                                        <span class="status-badge blocked">Blocked</span>
                                    @endif
                                </td>

                            </tr>

                        </tbody>
                    </table>
        </section>
    </div>
@endsection
