@extends('frontend.layouts.app')
@section('content')

<div class="container yp-dashboard-wrap mt-5">
    <div class="row g-4">
        <div class="col-lg-3">
            <div class="yp-sidebar text-center">
                <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-2 text-calor"
                    style="width: 60px; height: 60px;">
                    <i class="bi bi-person-circle fs-2"></i>
                </div>
                <h6 class="fw-bold mb-3 border-bottom pb-3" id="side-name">John Doe</h6>

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
                        <a href="#" class="btn btn-dark  rounded-pill py-2 fw-bold text-decoration-none shadow-sm">
                            Track Your Order
                        </a>
                        <button class="yp-btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#profileModal">Edit
                            Profile</button>

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

                <div id="tab-orders" class="tab-content" style="display:none;">
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

                        <div>
                            @if($address->is_default == 1)
                            <span class="badge bg-success me-2">Default</span>
                            @endif

                            <button class="btn btn-sm btn-outline-dark rounded-pill px-3"
                                data-bs-toggle="modal"
                                data-id="{{ $address->id }}"
                                data-name="{{ $address->name }}"
                                data-mobile="{{ $address->mobile }}"
                                data-address="{{ $address->address }}"
                                data-city="{{ $address->city }}"
                                data-state="{{ $address->state }}"
                                data-pincode="{{ $address->pincode }}"
                                data-default="{{ $address->is_default }}"
                                data-bs-target="#editaddressModal">
                                Edit
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
                <label class="yp-form-label">Full Name</label>
                <input type="text" id="input-name" class="yp-form-input" value="John Doe">
                <label class="yp-form-label">Email</label>
                <input type="email" id="input-email" class="yp-form-input" value="john@example.com">
                <label class="yp-form-label">Phone Number</label>
                <input type="tel" id="input-phone" class="yp-form-input" value="+91 98765 43210">
                <button type="submit" class="yp-btn-primary w-100 mt-2">Save Changes</button>
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

                <label class="yp-form-label">Address Line</label>
                <textarea name="address_line1" class="yp-form-input" rows="3" required></textarea>

                <label class="yp-form-label">City</label>
                <input type="text" name="city" class="yp-form-input" required>

                <label class="yp-form-label">State</label>
                <input type="text" name="state" class="yp-form-input" required>

                <label class="yp-form-label">Pincode</label>
                <input type="text" name="pincode" class="yp-form-input" required>

                <div class="form-check mt-2">
                    <input type="checkbox" name="is_default" value="1" class="form-check-input" id="defaultCheck">
                    <label class="form-check-label" for="defaultCheck">
                        Set as Default Address
                    </label>
                </div>

                <button type="submit" class="yp-btn-primary w-100 mt-3">
                    Save Address
                </button>
            </form>
        </div>
    </div>
</div>
<!-- Edit Profile -->
<div class="modal fade" id="editaddressModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-4">
            <h5 class="fw-bold mb-3">Address Details</h5>

            <form id="editaddressForm">
                @csrf

                <label class="yp-form-label">Full Name</label>
                <input type="text" name="edit_full_name" class="yp-form-input" required>
                <input type="hidden" name="address_id" id="edit_address_id">

                <label class="yp-form-label">Mobile</label>
                <input type="text" name="edit_mobile" class="yp-form-input" required>

                <label class="yp-form-label">Address Line</label>
                <textarea name="edit_address_line1" class="yp-form-input" rows="3" required></textarea>

                <label class="yp-form-label">City</label>
                <input type="text" name="edit_city" class="yp-form-input" required>

                <label class="yp-form-label">State</label>
                <input type="text" name="edit_state" class="yp-form-input" required>

                <label class="yp-form-label">Pincode</label>
                <input type="text" name="edit_pincode" class="yp-form-input" required>

                <div class="form-check mt-2">
                    <input type="checkbox" name="edit_is_default" value="1" class="form-check-input" id="edit_defaultCheck">
                    <label class="form-check-label" for="defaultCheck">
                        Set as Default Address
                    </label>
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

<script>
    // Tab Switching
    function switchTab(tabId, el) {
        document.querySelectorAll('.tab-content').forEach(t => t.style.display = 'none');
        document.getElementById('tab-' + tabId).style.display = 'block';
        document.querySelectorAll('.yp-nav-link').forEach(l => l.classList.remove('active'));
        el.classList.add('active');
    }

    // Save Profile Logic
    document.getElementById('profileForm').addEventListener('submit', function(e) {
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
    $(document).on('submit', '#addressForm', function(e) {
        e.preventDefault();

        let formData = $(this).serialize();

        $.ajax({
            url: "{{ route('address.store') }}",
            method: "POST",
            data: formData,
            success: function(res) {

                if (res.success) {

                    $('#addressModal').modal('hide');

                    Swal.fire({
                        title: 'Success!',
                        text: res.message,
                        icon: 'success',
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#28a745'
                    }).then(() => {
                        location.reload(); // reload after clicking OK
                    });

                }
            },
            error: function(xhr) {

                Swal.fire({
                    title: 'Error!',
                    text: 'Something went wrong. Please try again.',
                    icon: 'error',
                    confirmButtonColor: '#dc3545'
                });

            }
        });
    });
    $(document).on('click', '[data-bs-target="#editaddressModal"]', function() {

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
    $('#editaddressForm').on('submit', function(e) {
        e.preventDefault();

        let id = $('#edit_address_id').val();

        $.ajax({
            url: "{{ route('address.update', ':id') }}".replace(':id', id),
            type: "POST",
            data: $(this).serialize(),
            success: function(res) {

                if (res.success) {

                    $('#editaddressModal').modal('hide');

                    Swal.fire({
                        title: 'Updated!',
                        text: res.message,
                        icon: 'success',
                        confirmButtonColor: '#28a745'
                    }).then(() => {
                        location.reload();
                    });
                }
            },
            error: function() {
                Swal.fire({
                    title: 'Error!',
                    text: 'Something went wrong!',
                    icon: 'error'
                });
            }
        });

    });

    $('#passForm').on('submit', function(e) {
    e.preventDefault();

    $.ajax({
        url: "{{ route('change.password') }}",
        type: "POST",
        data: $(this).serialize(),

        success: function(res) {

            Swal.fire({
                title: 'Success!',
                text: res.message,
                icon: 'success',
                confirmButtonColor: '#28a745'
            });

            $('#passForm')[0].reset();
        },

        error: function(xhr) {

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
</script>
@endpush

@endsection