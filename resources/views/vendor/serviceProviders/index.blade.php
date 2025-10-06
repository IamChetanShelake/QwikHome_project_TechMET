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
    <div class="header-left mt-3 mx-3  ">

    </div>
    <div class="header-right mt-3 mx-3">
        <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" id="searchInput" placeholder="Search by name, email, or mobile...">
        </div>
        <div class="search-box">
            <a href="{{ route('serviceProviders.create') }}" class="btn btn-primary">Create Employee</a>
        </div>
    </div>
    <div class="content-area">
        <!-- Dashboard Section -->
        <section id="dashboard-section" class="content-section active">
            <div class="dashboard-card">
                <div class="card-header">
                    <h3>Employee Management</h3>
                </div>
                <div class="table-container">
                    <table class="data-table ">
                        <thead>
                            <tr>
                                <th>Sr.</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Address</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($serviceProviders as $serviceProvider)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        @if ($serviceProvider->image)
                                            <img src="{{ asset('user_images/' . $serviceProvider->image) }}"
                                                alt="{{ $serviceProvider->name }}" class="rounded-circle"
                                                style="width: 50px; height: 50px; object-fit: cover;">
                                        @else
                                            <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center"
                                                style="width: 50px; height: 50px;">
                                                <i class="fas fa-user text-white"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>{{ $serviceProvider->name }}</td>
                                    <td>{{ $serviceProvider->email ?? 'N/A' }}</td>
                                    <td>{{ $serviceProvider->phone ?? 'N/A' }}</td>
                                    <td>{{ $serviceProvider->address ?? 'N/A' }}</td>
                                    <td>
                                        <div class="d-flex gap-1 justify-content-center">
                                            <a href="{{ route('serviceProviders.show', $serviceProvider->id) }}"
                                                class="action-btn action-view" title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('serviceProviders.edit', $serviceProvider->id) }}"
                                                class="action-btn action-edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form method="POST"
                                                action="{{ route('serviceProviders.destroy', $serviceProvider->id) }}"
                                                style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    onclick="return confirm('Are you sure you want to delete this service provider?')"
                                                    class="action-btn action-delete">
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
        let currentTableHTML = document.querySelector('.data-table tbody').innerHTML; // Store original table

        document.getElementById('searchInput').addEventListener('keyup', function() {
            let query = this.value.trim();

            fetch(`/admin/search-service-providers?query=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    let tbody = document.querySelector('.data-table tbody');
                    tbody.innerHTML = '';

                    if (data.length > 0) {
                        data.forEach((user, index) => {
                            let imageHTML = user.image ?
                                `<img src="/user_images/${user.image}" alt="${user.name}" class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">` :
                                `<div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;"><i class="fas fa-user text-white"></i></div>`;

                            let actionHTML = `
                                <div class="d-flex gap-1 justify-content-center">
                                    <a href="/serviceProviders/${user.id}" class="action-btn action-view" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="/serviceProviders/${user.id}/edit" class="action-btn action-edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form method="POST" action="/serviceProviders/${user.id}" style="display: inline;">
                                        <input type="hidden" name="_token" value="${document.querySelector('meta[name=csrf-token]').getAttribute('content')}">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" onclick="return confirm('Are you sure you want to delete this service provider?')" class="action-btn action-delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            `;

                            let rowHTML = `
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>${imageHTML}</td>
                                    <td>${user.name}</td>
                                    <td>${user.email || 'N/A'}</td>
                                    <td>${user.phone || 'N/A'}</td>
                                    <td>${user.address || 'N/A'}</td>
                                    <td>${actionHTML}</td>
                                </tr>
                            `;
                            tbody.innerHTML += rowHTML;
                        });
                    } else {
                        tbody.innerHTML = '<tr><td colspan="7">No service providers found.</td></tr>';
                    }
                })
                .catch(error => console.error('Search error:', error));
        });

        $(document).ready(function() {
            setTimeout(function() {
                $('.alert-success').fadeOut('slow');
            }, 3000);
        });
    </script>
@endsection
