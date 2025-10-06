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
    <div class="header-right mt-3 mx-4  ">
        <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" id="searchInput" placeholder="Search by name, email, or mobile...">
        </div>
    </div>
    <div class="content-area">
        <!-- Dashboard Section -->
        <section id="dashboard-section" class="content-section active">
            <div class="dashboard-card">
                <div class="card-header">
                    <h3>Customer Management</h3>
                </div>
                <div class="table-container">
                    <table class="data-table ">
                        <thead>
                            <tr>
                                <th>Sr.</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Mobile</th>
                                <th>status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($customers as $customer)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
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
                                            <span class="status-badge completed"> Active </span>
                                        @else
                                            <span class="status-badge pending"> Blocked </span>
                                        @endif

                                    </td>

                                    <td>
                                        <div class="d-flex gap-1 justify-content-center">

                                            {{-- <a href="{{ route('customer.view', $customer->id) }}">
                                                <i class="fas fa-eye">

                                                </i>
                                            </a> --}}
                                            @if ($customer->active == 0)
                                                <button type="button" class="btn btn-danger block"
                                                    data-id="{{ $customer->id }}">block
                                                </button>
                                            @else
                                                <button type="button" class="btn btn-success unblock"
                                                    data-id="{{ $customer->id }}">unblock
                                                </button>
                                            @endif

                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                            @if ($customers->isEmpty())
                                <tr>
                                    <td colspan="8">No Customers yet.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>


        </section>

        <!-- Other sections will be loaded dynamically -->
        <div id="dynamic-content"></div>
    </div>


    {{-- script to toggle block/unblock user -->  --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelector('.data-table').addEventListener('click', function(e) {
                if (e.target.classList.contains('block') || e.target.classList.contains('unblock')) {
                    e.preventDefault();
                    let userId = e.target.getAttribute("data-id");

                    fetch("{{ route('customers.toggle-block') }}", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": "{{ csrf_token() }}"
                            },
                            body: JSON.stringify({
                                id: userId
                            })
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.success) {
                                // alert(data.message);
                                // reload page or update button dynamically
                                location.reload();
                            } else {
                                alert('Error: ' + data.message);
                            }
                        })
                        .catch(error => {
                            console.error("Error:", error);
                            alert('There was an error processing your request.');
                        });
                }
            });
        });
    </script>


    {{-- search user script --> --}}
    <script>
        let currentTableHTML = document.querySelector('.data-table tbody').innerHTML; // Store original table

        document.getElementById('searchInput').addEventListener('keyup', function() {
            let query = this.value.trim();

            fetch(`/admin/search-users?query=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    let tbody = document.querySelector('.data-table tbody');
                    tbody.innerHTML = '';

                    if (data.length > 0) {
                        data.forEach((user, index) => {
                            let imageHTML = user.image ?
                                `<img src="/customer_images/${user.image}" alt="Image" class="designer-img">` :
                                `<p>No Image</p>`;

                            let statusHTML = user.active == 0 ?
                                `<span class="status-badge completed"> Active </span>` :
                                `<span class="status-badge pending"> Blocked </span>`;

                            let actionHTML = user.active == 0 ?
                                `<button type="button" class="btn btn-danger block" data-id="${user.id}">block</button>` :
                                `<button type="button" class="btn btn-success unblock" data-id="${user.id}">unblock</button>`;

                            let rowHTML = `
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>${imageHTML}</td>
                                    <td>${user.name}</td>
                                    <td>${user.email}</td>
                                    <td>${user.phone || 'N/A'}</td>
                                    <td>${statusHTML}</td>
                                    <td>
                                        <div class="d-flex gap-1 justify-content-center">
                                            ${actionHTML}
                                        </div>
                                    </td>
                                </tr>
                            `;
                            tbody.innerHTML += rowHTML;
                        });
                    } else {
                        tbody.innerHTML = '<tr><td colspan="7">No customers found.</td></tr>';
                    }


                })
                .catch(error => console.error('Error:', error));
        });
    </script>
@endsection
