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
            {{-- <i class="fas fa-search"></i>
            <input type="text" placeholder="Search...">
        </div>
        <div id="searchResults"></div> --}}
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
            document.querySelectorAll(".block, .unblock").forEach(button => {
                button.addEventListener("click", function() {
                    let userId = this.getAttribute("data-id");

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
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                alert(data.message);
                                // reload page or update button dynamically
                                location.reload();
                            }
                        })
                        .catch(error => console.error("Error:", error));
                });
            });
        });
    </script>


    {{-- search user script --> --}}
    <script>
        document.getElementById('searchInput').addEventListener('keyup', function() {
            let query = this.value;

            if (query.length > 0) {
                fetch(`/admin/search-users?query=${query}`)
                    .then(response => response.json())
                    .then(data => {
                        let resultsBox = document.getElementById('searchResults');
                        resultsBox.innerHTML = '';
                        console.log(resultsBox);
                        if (data.length > 0) {
                            data.forEach(user => {
                                resultsBox.innerHTML += `
                            <div class="result-item">
                                ${user.name} - ${user.email} - ${user.phone}
                            </div>`;
                            });
                        } else {
                            resultsBox.innerHTML = '<p>No results found</p>';
                        }
                    })
                    .catch(error => console.error('Error:', error));
            } else {
                document.getElementById('searchResults').innerHTML = '';
            }
        });
    </script>
@endsection
