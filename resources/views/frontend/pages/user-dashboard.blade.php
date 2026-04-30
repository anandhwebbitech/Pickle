@extends('frontend.layouts.app')
@section('content')
    <style>
        #ordersTable {
            font-size: 12px;
        }

        .dataTables_wrapper .dataTables_length {
            margin-bottom: 20px;
        }

        .dataTables_wrapper .dataTables_filter {
            margin-bottom: 20px;
        }

        .dataTables_wrapper .dataTables_info {
            padding-top: 15px;
        }

        .dataTables_wrapper .dataTables_paginate {
            padding-top: 10px;
        }

        #ordersTable th.no-center {
            text-align: left;
            /* or default */
        }

        /* Toggle Container */
        .default-toggle {
            display: flex;
            align-items: center;
        }

        /* Switch */
        .switch {
            position: relative;
            display: inline-block;
            width: 46px;
            height: 24px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        /* Slider */
        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .3s;
            border-radius: 34px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: .3s;
            border-radius: 50%;
        }

        .switch input:checked+.slider {
            background-color: #5e0e3c;
            /* your brand color */
        }

        .switch input:checked+.slider:before {
            transform: translateX(22px);
        }
    </style>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <div class="container yp-dashboard-wrap mt-5">
        <div class="row g-4">
            <div class="col-lg-3">
                <div class="yp-sidebar text-center">
                    <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-2 text-calor"
                        style="width: 60px; height: 60px;">
                        <i class="bi bi-person-circle fs-2"></i>
                    </div>
                    <h6 class="fw-bold mb-3 border-bottom pb-3" id="side-name">{{ $user->name ?? 'John Doe' }}</h6>

                    <nav class="text-start">
                        <a class="yp-nav-link active" onclick="switchTab('profile', this)"><i class="bi bi-person"></i>
                            Personal Info</a>
                        <a class="yp-nav-link" onclick="switchTab('orders', this)"><i class="bi bi-bag"></i> Order
                            History</a>
                        <a class="yp-nav-link" onclick="switchTab('address', this)"><i class="bi bi-geo-alt"></i> My
                            Address</a>
                        <a class="yp-nav-link" onclick="switchTab('password', this)"><i class="bi bi-key"></i> Change
                            Password</a>
                        <!-- <a href="login.php" class="yp-nav-link mt-4 text-muted border-top pt-3"><i
                                                                    class="bi bi-box-arrow-left"></i> Logout</a> -->
                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                            class="yp-nav-link mt-4 text-muted border-top pt-3">
                            <i class="bi bi-box-arrow-left"></i> Logout
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </nav>
                </div>
            </div>

            <div class="col-lg-9">
                <div class="yp-content-card">

                    <div id="tab-profile" class="tab-content">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="fw-bold mb-0">Personal Information</h4>
                            {{-- <a href="#" class="btn btn-dark  rounded-pill py-2 fw-bold text-decoration-none shadow-sm">
                                Track Your Order
                            </a> --}}
                            {{-- <button class="yp-btn-primary btn-sm" data-bs-toggle="modal"
                                data-bs-target="#profileModal">Edit
                                Profile</button> --}}
                            <button class="yp-btn-primary btn-sm editProfileBtn" data-id="{{ auth()->user()->id }}"
                                data-name="{{ auth()->user()->name }}" data-email="{{ auth()->user()->email }}"
                                data-phone="{{ auth()->user()->phone }}" data-bs-toggle="modal"
                                data-bs-target="#profileModal">
                                Edit Profile
                            </button>

                        </div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="yp-info-box"><span class="yp-form-label">Full Name</span>
                                    <div id="val-name" class="yp-info-value">{{ $user->name ?? '' }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="yp-info-box"><span class="yp-form-label">Email Address</span>
                                    <div id="val-email" class="yp-info-value">{{ $user->email ?? '' }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="yp-info-box"><span class="yp-form-label">Phone Number</span>
                                    <div id="val-phone" class="yp-info-value">{{ $user->phone ?? '' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- <div id="tab-orders" class="tab-content" style="display:none;">
                        <h4 class="fw-bold mb-4">Order History</h4>
                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Date</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="fw-bold">#YP-1024</td>
                                        <td>Jan 24, 2026</td>
                                        <td>₹850.00</td>
                                        <td><span class="badge-delivered">Delivered</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div> --}}
                    <div id="tab-orders" class="tab-content" style="display:none;">
                        <h4 class="fw-bold mb-4">Order History</h4>

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped w-100" id="ordersTable">
                                <thead class="table-light">
                                    <tr>
                                        <th>S.No</th>
                                        <th>Order ID</th>
                                        <th>Product Name</th>
                                        <th>Order Date</th>
                                        <th>Price</th>
                                        <th>Status</th>
                                        <th class="no-center">Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>

                    <div id="tab-address" class="tab-content" style="display:none;">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="fw-bold mb-0">Saved Addresses</h4>
                            <button class="yp-btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addressModal">
                                + Add New
                            </button>
                        </div>

                        @forelse($addresses as $address)

                            <div class="yp-info-box d-flex justify-content-between align-items-center mb-3">

                                <div>
                                    <span class="yp-form-label">
                                        {{ $address->is_default == 1 ? 'Default Shipping' : 'Shipping Address' }}
                                    </span>

                                    <div class="yp-info-value">
                                        {{ $address->name }},
                                        {{ $address->mobile }},
                                        {{ $address->address }},
                                        {{ $address->city }},
                                        {{ $address->state }} - {{ $address->pincode }}
                                    </div>
                                </div>

                                <div class="d-flex align-items-center gap-2 flex-nowrap">
                                    @if($address->is_default == 1)
                                        <span class="badge bg-success me-2">Default</span>
                                    @endif

                                    <button class="btn btn-sm btn-outline-dark rounded-pill px-3" data-bs-toggle="modal"
                                        data-id="{{ $address->id }}" data-name="{{ $address->name }}"
                                        data-mobile="{{ $address->mobile }}" data-address="{{ $address->address }}"
                                        data-city="{{ $address->city }}" data-state="{{ $address->state }}"
                                        data-pincode="{{ $address->pincode }}" data-default="{{ $address->is_default }}"
                                        data-bs-target="#editaddressModal">
                                        <i class="bi bi-pencil-square me-1"></i>
                                    </button>
                                    <!-- Delete Button -->
                                    <button class="btn btn-sm btn-outline-danger rounded-pill px-3 deleteAddressBtn"
                                        data-id="{{ $address->id }}">
                                        <i class="bi bi-trash3 me-1"></i>
                                    </button>
                                </div>

                            </div>

                        @empty

                            <div class="alert alert-info">
                                No addresses found. Please add a new address.
                            </div>

                        @endforelse

                    </div>

                    <div id="tab-password" class="tab-content" style="display:none;">
                        <h4 class="fw-bold mb-4">Change Password</h4>

                        <form id="passForm" style="max-width: 400px;">
                            @csrf

                            <label class="yp-form-label">Current Password</label>
                            <input type="password" name="current_password" class="yp-form-input" required>

                            <label class="yp-form-label">New Password</label>
                            <input type="password" name="new_password" class="yp-form-input" required>

                            <label class="yp-form-label">Confirm Password</label>
                            <input type="password" name="new_password_confirmation" class="yp-form-input" required>

                            <button type="submit" class="yp-btn-primary w-100 mt-3">
                                Update Password
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="profileModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-4">
                <h5 class="fw-bold mb-3">Update Profile</h5>
                <form id="profileForm">
                    @csrf
                    <input type="hidden" id="user-id">

                    <label class="yp-form-label">Full Name</label>
                    <input type="text" id="input-name" class="yp-form-input" required>

                    <label class="yp-form-label">Email</label>
                    <input type="email" id="input-email" class="yp-form-input">

                    <label class="yp-form-label">Phone Number</label>
                    <input type="tel" id="input-phone" class="yp-form-input">

                    <button type="submit" class="yp-btn-primary w-100 mt-2">
                        Save Changes
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- <div class="modal fade" id="addressModal" tabindex="-1">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content p-4">
                                                        <h5 class="fw-bold mb-3">Address Details</h5>
                                                        <form id="addressForm">
                                                            <label class="yp-form-label">Full Address</label>
                                                            <textarea id="address_line1" class="yp-form-input" rows="3">123 Pickle Lane, Coimbatore, 641001</textarea>
                                                            <button type="submit" class="yp-btn-primary w-100 mt-2">Update Address</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div> -->
    <div class="modal fade" id="addressModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-4">
                <h5 class="fw-bold mb-3">Address Details</h5>

                <form id="addressForm">
                    @csrf

                    <label class="yp-form-label">Full Name</label>
                    <input type="text" name="full_name" class="yp-form-input" required>

                    <label class="yp-form-label">Mobile</label>
                    <input type="text" name="mobile" class="yp-form-input" required>

                    <label class="yp-form-label">Pincode</label>
                    <input type="text" name="pincode" id="pincode" class="yp-form-input" required maxlength="6">

                    <label class="yp-form-label">State</label>
                    <input type="text" name="state" id="state" class="yp-form-input" readonly required>

                    <label class="yp-form-label">City</label>
                    <input type="text" name="city" id="city" class="yp-form-input" readonly required>

                    <label class="yp-form-label">Address Line</label>
                    <textarea name="address_line1" class="yp-form-input" rows="3" required></textarea>

                    <div class="default-toggle mt-3">
                        <label class="switch">
                            <input type="checkbox" name="is_default" value="1">
                            <span class="slider"></span>
                        </label>
                        <span class="ms-2 fw-semibold">Set as Default Address</span>
                    </div>

                    <button type="submit" class="yp-btn-primary w-100 mt-3">
                        Save Address
                    </button>
                </form>
            </div>
        </div>
    </div>
    <!-- Edit Address Modal -->
    <div class="modal fade" id="editaddressModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-4">
                <h5 class="fw-bold mb-3">Address Details</h5>

                <form id="editaddressForm">
                    @csrf
                    <input type="hidden" name="address_id" id="edit_address_id">

                    <label class="yp-form-label">Full Name</label>
                    <input type="text" name="edit_full_name" id="edit_full_name" class="yp-form-input" required>

                    <label class="yp-form-label">Mobile</label>
                    <input type="text" name="edit_mobile" id="edit_mobile" class="yp-form-input" required>

                    <label class="yp-form-label">Pincode</label>
                    <input type="text" name="edit_pincode" id="edit_pincode" class="yp-form-input" required maxlength="6">

                    <label class="yp-form-label">State</label>
                    <input type="text" name="edit_state" id="edit_state" class="yp-form-input" readonly required>

                    <label class="yp-form-label">City</label>
                    <input type="text" name="edit_city" id="edit_city" class="yp-form-input" readonly required>

                    <label class="yp-form-label">Address Line</label>
                    <textarea name="edit_address_line1" id="edit_address_line1" class="yp-form-input" rows="3"
                        required></textarea>

                    <div class="default-toggle mt-3">
                        <label class="switch">
                            <input type="checkbox" name="edit_is_default" id="edit_is_default" value="1">
                            <span class="slider"></span>
                        </label>
                        <span class="ms-2 fw-semibold">Set as Default Address</span>
                    </div>

                    <button type="submit" class="yp-btn-primary w-100 mt-3">
                        Update Address
                    </button>
                </form>
            </div>
        </div>
    </div>
    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function () {

                const urlParams = new URLSearchParams(window.location.search);
                const tab = urlParams.get('tab');

                if (tab === 'address') {
                    const addressTab = document.querySelector('[onclick*="switchTab(\'address\'"]');
                    if (addressTab) {
                        switchTab('address', addressTab);
                    }
                }
                if (tab === 'orders') {
                    const ordersTab = document.querySelector('[onclick*="switchTab(\'orders\'"]');
                    if (ordersTab) {
                        switchTab('orders', ordersTab);
                    }
                }
                if (tab === 'password') {
                    const passwordTab = document.querySelector('[onclick*="switchTab(\'password\'"]');
                    if (passwordTab) {
                        switchTab('password', passwordTab);
                    }
                }

            });
            document.addEventListener("DOMContentLoaded", function () {

                document.querySelector(".editProfileBtn").addEventListener("click", function () {
                    document.getElementById("user-id").value = this.dataset.id;
                    document.getElementById("input-name").value = this.dataset.name;
                    document.getElementById("input-email").value = this.dataset.email;
                    document.getElementById("input-phone").value = this.dataset.phone;
                });

            });
            // Tab Switching
            function switchTab(tabId, el) {
                document.querySelectorAll('.tab-content').forEach(t => t.style.display = 'none');
                document.getElementById('tab-' + tabId).style.display = 'block';
                document.querySelectorAll('.yp-nav-link').forEach(l => l.classList.remove('active'));
                el.classList.add('active');
            }

            // Save Profile Logic
            document.getElementById('profileForm').addEventListener('submit', function (e) {
                e.preventDefault();
                const n = document.getElementById('input-name').value;
                const e_mail = document.getElementById('input-email').value;
                const p = document.getElementById('input-phone').value;

                document.getElementById('val-name').innerText = n;
                document.getElementById('side-name').innerText = n;
                document.getElementById('val-email').innerText = e_mail;
                document.getElementById('val-phone').innerText = p;

                bootstrap.Modal.getInstance(document.getElementById('profileModal')).hide();
                alert('Profile Updated!');
            });

            // Save Address Logic


            // Password Update logic
            // document.getElementById('passForm').addEventListener('submit', function(e) {
            //     e.preventDefault();
            //     alert('Password Updated Successfully!');
            //     this.reset();
            // });
            $(document).on('submit', '#addressForm', function (e) {
                e.preventDefault();

                let formData = $(this).serialize();

                $.ajax({
                    url: "{{ route('address.store') }}",
                    method: "POST",
                    data: formData,
                    success: function (res) {

                        if (res.success) {

                            $('#addressModal').modal('hide');

                            Swal.fire({
                                title: 'Success!',
                                text: res.message,
                                icon: 'success',
                                confirmButtonText: 'OK',
                                confirmButtonColor: '#28a745'
                            }).then(() => {
                                // location.reload(); // reload after clicking OK
                                let urlParams = new URLSearchParams(window.location.search);

                                if (urlParams.get('from') === 'checkout') {
                                    window.location.href = "{{ route('checkout') }}";
                                } else {
                                    location.reload();
                                }
                            });

                        }
                    },
                    error: function (xhr) {

                        Swal.fire({
                            title: 'Error!',
                            text: 'Something went wrong. Please try again.',
                            icon: 'error',
                            confirmButtonColor: '#dc3545'
                        });

                    }
                });
            });
            $(document).on('click', '[data-bs-target="#editaddressModal"]', function () {

                $('#edit_address_id').val($(this).data('id'));
                $('input[name="edit_full_name"]').val($(this).data('name'));
                $('input[name="edit_mobile"]').val($(this).data('mobile'));
                $('textarea[name="edit_address_line1"]').val($(this).data('address'));
                $('input[name="edit_city"]').val($(this).data('city'));
                $('input[name="edit_state"]').val($(this).data('state'));
                $('input[name="edit_pincode"]').val($(this).data('pincode'));

                if ($(this).data('default') == 1) {
                    $('#edit_defaultCheck').prop('checked', true);
                } else {
                    $('#edit_defaultCheck').prop('checked', false);
                }

            });
            $('#editaddressForm').on('submit', function (e) {
                e.preventDefault();

                let id = $('#edit_address_id').val();

                $.ajax({
                    url: "{{ route('address.update', ':id') }}".replace(':id', id),
                    type: "POST",
                    data: $(this).serialize(),
                    success: function (res) {

                        if (res.success) {

                            $('#editaddressModal').modal('hide');

                            Swal.fire({
                                title: 'Updated!',
                                text: res.message,
                                icon: 'success',
                                confirmButtonColor: '#28a745'
                            }).then(() => {
                                let urlParams = new URLSearchParams(window.location.search);

                                if (urlParams.get('from') === 'checkout') {
                                    window.location.href = "{{ route('checkout') }}";
                                } else {
                                    location.reload();
                                }
                                // location.reload();
                            });
                        }
                    },
                    error: function () {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Something went wrong!',
                            icon: 'error'
                        });
                    }
                });

            });

            $('#passForm').on('submit', function (e) {
                e.preventDefault();

                $.ajax({
                    url: "{{ route('change.password') }}",
                    type: "POST",
                    data: $(this).serialize(),

                    success: function (res) {

                        Swal.fire({
                            title: 'Success!',
                            text: res.message,
                            icon: 'success',
                            confirmButtonColor: '#28a745'
                        });

                        $('#passForm')[0].reset();
                    },

                    error: function (xhr) {

                        let message = "Something went wrong!";

                        if (xhr.responseJSON) {

                            // VALIDATION ERRORS
                            if (xhr.responseJSON.errors) {
                                message = Object.values(xhr.responseJSON.errors)[0][0];
                            }

                            // CUSTOM ERRORS (like wrong current password)
                            else if (xhr.responseJSON.message) {
                                message = xhr.responseJSON.message;
                            }
                        }

                        Swal.fire({
                            title: 'Error!',
                            text: message,
                            icon: 'error',
                            confirmButtonColor: '#dc3545'
                        });
                    }
                });
            });
            $(document).ready(function () {

                $('#ordersTable').DataTable({
                    processing: true,
                    serverSide: false,
                    ajax: "{{ route('user.orders.datatable') }}",
                    columns: [
                        { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                        { data: 'order_number', name: 'order_number' },
                        { data: 'productname', name: 'productname' },
                        { data: 'date', name: 'date' },
                        { data: 'amount', name: 'amount' },
                        { data: 'status', name: 'status', orderable: false, searchable: false },
                        { data: 'action', orderable: false, searchable: false }
                    ],
                    columnDefs: [
                        {
                            targets: 1, // Date column
                            className: 'text-nowrap'
                        },
                        {
                            targets: [0, 1, 2, 3, 4, 5], // all except last column (Action)
                            className: 'text-center'
                        }
                    ]
                });

            });
            $(document).on('click', '.cancel-order', function () {

                let orderId = $(this).data('id');
                let url = "{{ route('order.cancel', ':id') }}";
                url = url.replace(':id', orderId);

                Swal.fire({
                    title: 'Cancel this order?',
                    text: "Please enter cancel reason",
                    input: 'textarea',
                    inputPlaceholder: 'Type your reason here...',
                    inputValidator: (value) => {
                        if (!value) {
                            return 'Cancel reason is required!';
                        }
                    },
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Submit Cancel'
                }).then((result) => {

                    if (result.isConfirmed) {

                        $.ajax({
                            url: url,
                            type: "POST",
                            data: {
                                _token: "{{ csrf_token() }}",
                                reason: result.value
                            },
                            success: function (res) {

                                if (res.status) {

                                    Swal.fire({
                                        title: 'Cancelled!',
                                        text: res.message,
                                        icon: 'success',
                                        confirmButtonColor: '#28a745'
                                    }).then(() => {
                                        $('#ordersTable').DataTable().ajax.reload(null, false);
                                    });

                                } else {

                                    Swal.fire('Warning', res.message, 'warning');
                                }
                            },
                            error: function (xhr) {

                                let message = 'Something went wrong.';

                                if (xhr.responseJSON && xhr.responseJSON.message) {
                                    message = xhr.responseJSON.message;
                                }

                                Swal.fire('Error!', message, 'error');
                            }
                        });

                    }
                });
            });
            $(document).on('click', '.return-order', function () {

                let orderId = $(this).data('id');
                let url = "{{ route('order.return', ':id') }}";
                url = url.replace(':id', orderId);

                Swal.fire({
                    title: 'Return this order?',
                    text: "Please enter return reason",
                    input: 'textarea',
                    inputPlaceholder: 'Type your reason here...',
                    inputAttributes: {
                        'aria-label': 'Return reason'
                    },
                    inputValidator: (value) => {
                        if (!value) {
                            return 'Return reason is required!';
                        }
                    },
                    showCancelButton: true,
                    confirmButtonText: 'Submit Return',
                    confirmButtonColor: '#ffc107',
                    cancelButtonColor: '#6c757d'
                }).then((result) => {

                    if (result.isConfirmed) {

                        $.ajax({
                            url: url,
                            type: "POST",
                            data: {
                                _token: "{{ csrf_token() }}",
                                reason: result.value
                            },
                            success: function (res) {

                                if (res.status) {

                                    Swal.fire({
                                        title: 'Return Requested!',
                                        text: res.message,
                                        icon: 'success',
                                        confirmButtonColor: '#28a745'
                                    }).then(() => {
                                        $('#ordersTable').DataTable().ajax.reload(null, false);
                                    });

                                } else {

                                    Swal.fire('Warning', res.message, 'warning');
                                }
                            },
                            error: function () {

                                Swal.fire('Error!', 'Something went wrong.', 'error');
                            }
                        });

                    }
                });
            });

            document.getElementById("profileForm").addEventListener("submit", function (e) {
                e.preventDefault();

                let userId = document.getElementById("user-id").value;

                fetch("{{ route('profile.update', ':id') }}".replace(':id', userId), {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                        "Accept": "application/json"
                    },
                    body: JSON.stringify({
                        name: document.getElementById("input-name").value,
                        email: document.getElementById("input-email").value,
                        phone: document.getElementById("input-phone").value
                    })
                })
                .then(async response => {

                    const data = await response.json();

                    // ✅ Handle validation error (422)
                    if (!response.ok) {

                        if (response.status === 422) {
                            let errorMessage = Object.values(data.errors)[0][0];

                            Swal.fire({
                                icon: 'error',
                                title: 'Validation Error',
                                text: errorMessage
                            });

                            return;
                        }

                        throw new Error("Server error");
                    }

                    return data;
                })
                .then(data => {

                    if (!data) return;

                    if (data.success) {

                        Swal.fire({
                            icon: 'success',
                            title: 'Updated!',
                            text: 'Profile updated successfully.',
                            confirmButtonColor: '#5e0e3c'
                        });

                        let modal = bootstrap.Modal.getInstance(document.getElementById('profileModal'));
                        modal.hide();
                    }

                })
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Server Error',
                        text: 'Please try again later.'
                    });

                    console.error("Error:", error);
                });
            });

            document.getElementById("pincode").addEventListener("blur", function () {

                let pincode = this.value.trim();

                if (pincode.length !== 6 || isNaN(pincode)) {
                    alert("Please enter a valid 6-digit pincode");
                    return;
                }

                fetch("https://api.postalpincode.in/pincode/" + pincode)
                    .then(response => response.json())
                    .then(data => {

                        if (data[0].Status === "Success") {

                            let postOffice = data[0].PostOffice[0];

                            document.getElementById("state").value = postOffice.State;
                            document.getElementById("city").value = postOffice.District;

                        } else {

                            document.getElementById("state").value = "";
                            document.getElementById("city").value = "";

                            alert("Invalid Pincode. Please enter a correct pincode.");
                        }

                    })
                    .catch(error => {
                        alert("Unable to fetch location. Please try again.");
                    });

            });
            document.getElementById("edit_pincode").addEventListener("blur", function () {

                let pincode = this.value.trim();

                if (pincode.length !== 6 || isNaN(pincode)) {
                    alert("Please enter a valid 6-digit pincode");
                    return;
                }

                fetch("https://api.postalpincode.in/pincode/" + pincode)
                    .then(response => response.json())
                    .then(data => {

                        if (data[0].Status === "Success") {

                            let postOffice = data[0].PostOffice[0];

                            document.getElementById("edit_state").value = postOffice.State;
                            document.getElementById("edit_city").value = postOffice.District;

                        } else {

                            document.getElementById("edit_state").value = "";
                            document.getElementById("edit_city").value = "";

                            alert("Invalid Pincode. Please enter a correct pincode.");
                        }

                    })
                    .catch(error => {
                        alert("Unable to fetch location. Please try again.");
                    });

            });
            const deleteAddressRoute = "{{ route('address.delete', ':id') }}";

            document.addEventListener("click", function (e) {

                if (e.target.classList.contains("deleteAddressBtn")) {

                    let addressId = e.target.getAttribute("data-id");
                    let url = deleteAddressRoute.replace(':id', addressId);

                    Swal.fire({
                        title: "Delete Address?",
                        text: "This address will be permanently removed.",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#d33",
                        cancelButtonColor: "#6c757d",
                        confirmButtonText: "Yes, Delete",
                        cancelButtonText: "Cancel"
                    }).then((result) => {

                        if (result.isConfirmed) {

                            fetch(url, {
                                method: "DELETE",
                                headers: {
                                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                                    "Content-Type": "application/json"
                                }
                            })
                                .then(res => res.json())
                                .then(data => {

                                    if (data.status) {

                                        Swal.fire({
                                            icon: "success",
                                            title: "Deleted!",
                                            text: "Address deleted successfully.",
                                            timer: 1500,
                                            showConfirmButton: false
                                        }).then(() => {
                                            location.reload();
                                        });

                                    } else {

                                        Swal.fire("Error", data.message, "error");

                                    }

                                })
                                .catch(() => {
                                    Swal.fire("Error", "Something went wrong.", "error");
                                });

                        }
                    });
                }

            });
        </script>


    @endpush

@endsection