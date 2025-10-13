@extends('admin.layouts.masterlayout')

@section('content')
    <style>
        th,
        td {
            text-align: center !important;
            vertical-align: middle !important;
            /* optional, keeps content vertically centered */
        }

        .table-container {
            display: flex;
            justify-content: center;
        }

        .table-container table {
            margin: 0 auto;
        }

        /* Modal styling to match index page theme (dark) */
        #customerViewModal {
            z-index: 1060;
        }

        .customer-modal .modal-content {
            background: rgba(52, 58, 64, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #ffffff;
            z-index: 1061;
        }

        .customer-modal .modal-backdrop {
            background-color: rgba(0, 0, 0, 0.7);
            z-index: 1059;
        }

        .customer-modal .modal-header {
            background: rgba(0, 0, 0, 0.2);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding: 15px 20px;
        }

        .customer-modal .modal-header h1 {
            color: #ffffff;
            font-size: 24px;
            font-weight: 600;
            margin: 0;
        }

        .customer-modal .modal-body {
            background: rgba(52, 58, 64, 0.95);
            color: #ffffff;
        }

        .customer-modal .detail-section {
            background: rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            margin-bottom: 20px;
            padding: 20px;
        }

        .customer-modal .section-header {
            background: rgba(52, 58, 64, 0.95);
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 15px;
            font-weight: bold;
            font-size: 18px;
            color: #ffffff;
            display: flex;
            align-items: center;
            gap: 10px;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .customer-modal .detail-item {
            margin-bottom: 15px;
        }

        .customer-modal .detail-item label {
            font-weight: 600;
            color: rgba(255, 255, 255, 0.9);
            display: block;
            margin-bottom: 5px;
        }

        .customer-modal .detail-item span {
            color: #ffffff;
        }

        .customer-modal .image-container {
            text-align: center;
            padding: 20px;
            background: rgba(0, 0, 0, 0.2);
            border-radius: 10px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .customer-modal .image-container img {
            max-width: 200px;
            max-height: 200px;
            border-radius: 10px;
            border: 2px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        }

        .customer-modal .image-container p {
            color: rgba(255, 255, 255, 0.7);
            font-style: italic;
        }

        .customer-modal .modal-footer {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding: 15px 20px;
            background: rgba(0, 0, 0, 0.2);
        }

        .customer-modal .btn-secondary {
            background: rgba(108, 117, 125, 0.8);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: #ffffff;
        }

        .customer-modal .btn-secondary:hover {
            background: rgba(108, 117, 125, 1);
            color: #ffffff;
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
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>status</th>
                                <th>View</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($customers as $customer)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $customer->name }}</td>
                                    <td>{{ $customer->email }}</td>
                                    <td>{{ $customer->phone }}</td>
                                    <td>
                                        @if ($customer->is_deleted == 1)
                                            <span class="status-badge" style="background-color: #6c757d; color: white;">
                                                Deleted </span>
                                        @elseif ($customer->active == 0)
                                            <span class="status-badge completed"> Active </span>
                                        @else
                                            <span class="status-badge pending"> Blocked </span>
                                        @endif

                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-success view-btn"
                                            data-id="{{ $customer->id }}"
                                            data-image="{{ $customer->image ? asset('customer_images/' . $customer->image) : '' }}"
                                            data-name="{{ $customer->name }}" data-email="{{ $customer->email }}"
                                            data-phone="{{ $customer->phone ?: 'N/A' }}"
                                            @if ($customer->is_deleted == 1) data-status="Deleted"
                                            @elseif ($customer->active == 0)
                                                data-status="Active"
                                            @else
                                                data-status="Blocked" @endif
                                            data-created="{{ $customer->created_at->format('d M, Y') }}"
                                            data-updated="{{ $customer->updated_at->format('d M, Y') }}"
                                            data-role="{{ $customer->role }}"
                                            data-address="{{ $customer->address ?: 'N/A' }}"
                                            data-email-verified="{{ $customer->email_verified_at ? 'Yes' : 'No' }}">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </td>

                                    <td>
                                        <div class="d-flex gap-1 justify-content-center">
                                            @if ($customer->is_deleted == 1)
                                                <span class="text-muted">N/A</span>
                                            @elseif ($customer->active == 0)
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

    <!-- Customer View Modal -->
    <div class="modal fade customer-modal" id="customerViewModal" tabindex="-1" aria-labelledby="customerViewModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title" id="customerViewModalLabel">
                        <i class="fas fa-user"></i> Customer Details
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Basic Information Section -->
                    <div class="detail-section">
                        <div class="section-header">
                            <i class="fas fa-info-circle"></i>
                            Basic Information
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="detail-item">
                                    <label><i class="fas fa-user"></i> Name:</label>
                                    <span id="modal-customer-name"></span>
                                </div>
                                <div class="detail-item">
                                    <label><i class="fas fa-envelope"></i> Email:</label>
                                    <span id="modal-customer-email"></span> <small class="text-muted"
                                        id="modal-customer-email-verified"></small>
                                </div>
                                <div class="detail-item">
                                    <label><i class="fas fa-phone"></i> Phone:</label>
                                    <span id="modal-customer-phone"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="detail-item">
                                    <label><i class="fas fa-user-tag"></i> Role:</label>
                                    <span id="modal-customer-role"></span>
                                </div>
                                <div class="detail-item">
                                    <label><i class="fas fa-bell"></i> Status:</label>
                                    <span id="modal-customer-status"></span>
                                </div>
                                <div class="detail-item">
                                    <label><i class="fas fa-calendar-alt"></i> Created At:</label>
                                    <span id="modal-customer-created"></span>
                                </div>
                                <div class="detail-item">
                                    <label><i class="fas fa-edit"></i> Updated At:</label>
                                    <span id="modal-customer-updated"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Address Section -->
                    <div class="detail-section">
                        <div class="section-header">
                            <i class="fas fa-address-card"></i>
                            Additional Information
                        </div>
                        <div class="detail-item">
                            <label><i class="fas fa-map-marker-alt"></i> Address:</label>
                            <span id="modal-customer-address"></span>
                        </div>
                    </div>

                    <!-- Image Section -->
                    <div class="detail-section">
                        <div class="section-header">
                            <i class="fas fa-image"></i>
                            Customer Image
                        </div>
                        <div class="image-container">
                            <img id="modal-customer-image" src="" alt="Customer Image" style="display: none;">
                            <p id="modal-no-image">No Image</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i> Close
                    </button>
                </div>
            </div>
        </div>
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

    {{-- View Modal Script --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelector('.data-table').addEventListener('click', function(e) {
                if (e.target.classList.contains('view-btn') || e.target.closest('.view-btn')) {
                    e.preventDefault();
                    let btn = e.target.classList.contains('view-btn') ? e.target : e.target.closest(
                        '.view-btn');

                    // Populate modal with customer data
                    document.getElementById('modal-customer-name').textContent = btn.getAttribute(
                        'data-name');
                    document.getElementById('modal-customer-email').textContent = btn.getAttribute(
                        'data-email');
                    document.getElementById('modal-customer-phone').textContent = btn.getAttribute(
                        'data-phone');
                    document.getElementById('modal-customer-status').textContent = btn.getAttribute(
                        'data-status');
                    document.getElementById('modal-customer-created').textContent = btn.getAttribute(
                        'data-created');
                    document.getElementById('modal-customer-updated').textContent = btn.getAttribute(
                        'data-updated');
                    document.getElementById('modal-customer-role').textContent = btn.getAttribute(
                        'data-role');
                    document.getElementById('modal-customer-address').textContent = btn.getAttribute(
                        'data-address');
                    document.getElementById('modal-customer-email-verified').textContent = btn.getAttribute(
                        'data-email-verified');

                    const imageSrc = btn.getAttribute('data-image');
                    const imgElement = document.getElementById('modal-customer-image');
                    const noImgElement = document.getElementById('modal-no-image');

                    if (imageSrc) {
                        imgElement.src = imageSrc;
                        imgElement.style.display = 'block';
                        noImgElement.style.display = 'none';
                    } else {
                        imgElement.style.display = 'none';
                        noImgElement.style.display = 'block';
                    }

                    // Show modal
                    const modal = new bootstrap.Modal(document.getElementById('customerViewModal'));
                    modal.show();
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

                            let statusHTML = '';
                            let actionHTML = '';
                            let statusText = '';

                            if (user.is_deleted == 1) {
                                statusHTML =
                                    `<span class="status-badge" style="background-color: #6c757d; color: white;"> Deleted </span>`;
                                actionHTML = `<span class="text-muted">N/A</span>`;
                                statusText = 'Deleted';
                            } else if (user.active == 0) {
                                statusHTML = `<span class="status-badge completed"> Active </span>`;
                                actionHTML =
                                    `<button type="button" class="btn btn-danger block" data-id="${user.id}">block</button>`;
                                statusText = 'Active';
                            } else {
                                statusHTML = `<span class="status-badge pending"> Blocked </span>`;
                                actionHTML =
                                    `<button type="button" class="btn btn-success unblock" data-id="${user.id}">unblock</button>`;
                                statusText = 'Blocked';
                            }

                            let viewBtnHTML =
                                `<button type="button" class="btn btn-success view-btn" data-id="${user.id}" data-image="${user.image ? '/customer_images/' + user.image : ''}" data-name="${user.name}" data-email="${user.email}" data-phone="${user.phone || 'N/A'}" data-status="${statusText}" data-created="${new Date(user.created_at).toLocaleDateString()}" data-updated="${new Date(user.updated_at).toLocaleDateString()}" data-role="${user.role}" data-address="${user.address || 'N/A'}" data-email-verified="${user.email_verified_at ? 'Yes' : 'No'}"><i class="fas fa-eye"></i></button>`;

                            let rowHTML = `
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>${imageHTML}</td>
                                    <td>${user.name}</td>
                                    <td>${user.email}</td>
                                    <td>${user.phone || 'N/A'}</td>
                                    <td>${statusHTML}</td>
                                    <td>${new Date(user.created_at).toLocaleDateString()}</td>
                                    <td>
                                        <div class="d-flex gap-1 justify-content-center">
                                            ${viewBtnHTML}
                                            ${actionHTML}
                                        </div>
                                    </td>
                                </tr>
                            `;
                            tbody.innerHTML += rowHTML;
                        });
                    } else {
                        tbody.innerHTML = '<tr><td colspan="8">No customers found.</td></tr>';
                    }


                })
                .catch(error => console.error('Error:', error));
        });
    </script>
@endsection
