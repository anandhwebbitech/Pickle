@extends('admin.layouts.app')

@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">

<style>
    /* ===== GLOBAL TEXT ===== */
    body {
        font-size: 13px;
    }

    /* ===== CARD ===== */
    .admin-card {
        background: #ffffff;
        border-radius: 16px;
        padding: 22px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.06);
    }

    /* ===== BUTTONS ===== */
    .btn {
        font-size: 12.5px;
        padding: 6px 16px;
        border-radius: 20px;
    }

    /* ===== MODALS ===== */
    .modal-content {
        border-radius: 18px;
    }

    .modal-title {
        font-size: 15px;
    }

    .form-label {
        font-size: 12.5px;
        font-weight: 500;
    }

    .form-control,
    .form-select {
        font-size: 12.5px;
        border-radius: 10px;
    }

    /* ===== TABLE ===== */
    .premium-table table {
        background: #fff;
        border-radius: 14px;
        overflow: hidden;
    }

    .premium-table thead {
        background: #f8fafc;
    }

    .premium-table th {
        font-size: 12px;
        font-weight: 600;
        color: #475569;
        padding: 12px;
    }

    .premium-table td {
        font-size: 12.5px;
        padding: 10px 12px;
        vertical-align: middle;
    }

    .table-hover tbody tr:hover {
        background-color: #f1f5f9;
    }

    /* ===== STATUS ===== */
    .badge-active {
        background: #dcfce7;
        color: #166534;
        padding: 4px 10px;
        border-radius: 12px;
        font-size: 11px;
    }

    .badge-inactive {
        background: #fee2e2;
        color: #991b1b;
        padding: 4px 10px;
        border-radius: 12px;
        font-size: 11px;
    }
</style>

<div class="container mt-4">
    <div class="admin-card">

        <!-- HEADER -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0 fw-semibold"> Coupon </h5>

            <button class="btn btn-primary"
                data-bs-toggle="modal"
                data-bs-target="#addCouponModal">
                <i class="fa fa-plus me-1"></i> Add Coupon
            </button>
        </div>

        <!-- ALERTS -->
        @if (session('success'))
        <div id="successMessage" class="alert alert-success small">
            {{ session('success') }}
        </div>
        @endif

        @if (session('danger'))
        <div id="dangerMessage" class="alert alert-danger small">
            {{ session('danger') }}
        </div>
        @endif

        <!-- TABLE -->
        <div class="table-responsive premium-table">
            <table id="categoryTable" class="table table-hover w-100">
                <thead>
                    <tr>
                        <th width="60">ID</th>
                        <th>Coupon Code</th>
                        <th>Type</th>
                        <th>value</th>
                        <th>Expiry Date</th>
                        <th>Limit</th>
                        <th>Home</th>
                        <th width="120">Status</th>
                        <th width="140">Action</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- DataTables / JS --}}
                </tbody>
            </table>
        </div>

    </div>
</div>

<!-- ================= ADD COUPON MODAL ================= -->
<div class="modal fade" id="addCouponModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <form method="POST"
            id="couponForm"
            class="modal-content border-0 shadow-lg rounded-4">
            @csrf

            <div class="modal-header border-0 px-4 pt-4">
                <h5 class="modal-title fw-semibold">
                    <i class="fa fa-ticket me-1"></i> Add Coupon
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body px-4 pb-3">
                <div class="row">

                    <!-- Coupon Code -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Coupon Code</label>
                        <input type="text"
                            name="code"
                            class="form-control"
                            placeholder="EX: SAVE10"
                            required>
                    </div>

                    <!-- Discount Type -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Discount Type</label>
                        <select name="type" class="form-select" required>
                            <option value="percentage">Percentage (%)</option>
                            <option value="amount">Fixed Amount</option>
                        </select>
                    </div>

                    <!-- Discount Value -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Discount Value</label>
                        <input type="number"
                            name="value"
                            class="form-control"
                            placeholder="Enter value"
                            required>
                    </div>
                    <!-- Usage Limit -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Usage Limit</label>
                        <input type="number"
                            name="limit"
                            class="form-control"
                            placeholder="How many times can be used?"
                            min="1">
                    </div>

                    <!-- Expiry Date -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Expiry Date</label>
                        <input type="date"
                            name="expiry_date"
                            class="form-control">
                    </div>

                    <!-- Status -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select" required>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>

                </div>
            </div>

            <div class="modal-footer border-0 px-4 pb-4">
                <button type="button"
                    class="btn btn-light"
                    data-bs-dismiss="modal">
                    Cancel
                </button>
                <button type="submit"
                    class="btn btn-danger">
                    Save Coupon
                </button>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="editCouponModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <form method="POST"
              id="editCouponForm"
              class="modal-content border-0 shadow-lg rounded-4">
            @csrf
            @method('PUT')

            <input type="hidden" id="edit_id">

            <div class="modal-header border-0 px-4 pt-4">
                <h5 class="modal-title fw-semibold">
                    <i class="fa fa-ticket me-1"></i> Edit Coupon
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body px-4 pb-3">
                <div class="row">

                    <!-- Coupon Code -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Coupon Code</label>
                        <input type="text"
                               id="edit_code"
                               name="code"
                               class="form-control"
                               required>
                    </div>

                    <!-- Discount Type -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Discount Type</label>
                        <select id="edit_type"
                                name="type"
                                class="form-select"
                                required>
                            <option value="percentage">Percentage (%)</option>
                            <option value="amount">Fixed Amount</option>
                        </select>
                    </div>

                    <!-- Discount Value -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Discount Value</label>
                        <input type="number"
                               id="edit_value"
                               name="value"
                               class="form-control"
                               required>
                    </div>
                    <!-- Usage Limit -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Usage Limit</label>
                        <input type="number"
                            name="limit"
                            id="edit_limit"
                            class="form-control"
                            placeholder="How many times can be used?"
                            min="1">
                    </div>

                    <!-- Expiry Date -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Expiry Date</label>
                        <input type="date"
                            name="expiry_date"
                            id="edit_expiry_date"
                            class="form-control">
                    </div>

                    <!-- Status -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Status</label>
                        <select id="edit_status"
                                name="status"
                                class="form-select"
                                required>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>

                </div>
            </div>

            <div class="modal-footer border-0 px-4 pb-4">
                <button type="button"
                        class="btn btn-light"
                        data-bs-dismiss="modal">
                    Cancel
                </button>
                <button type="submit"
                        class="btn btn-primary">
                    Update Coupon
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
let table;

$(document).ready(function () {

    // ================= DATATABLE LOAD =================
    table = $('#categoryTable').DataTable({
        processing: true,
        ajax: "{{ route('coupons.datatable') }}",
        columns: [
            { data: 'id', width: '60px' },
            { data: 'code' },
            { data: 'type' },
            { data: 'value' },
            { data: 'expiry_date' },
            { data: 'use_limit' },
            { data: 'featured', orderable: false, searchable: false },
            { data: 'status', orderable: false, searchable: false },
            { data: 'action', orderable: false, searchable: false }
        ],
        order: [[0, 'desc']],
        responsive: true,
        language: {
            emptyTable: "No coupons available"
        }
    });

});


// ================= ADD COUPON =================
$('#couponForm').on('submit', function (e) {
    e.preventDefault();

    $.ajax({
        url: "{{ route('coupons.store') }}",
        type: "POST",
        data: $(this).serialize(),
        beforeSend: function () {
            Swal.fire({
                title: 'Saving...',
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });
        },
        success: function (response) {

            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: response.message,
                timer: 1500,
                showConfirmButton: false
            });

            $('#addCouponModal').modal('hide');
            $('#couponForm')[0].reset();

            table.ajax.reload(null, false); // reload table
        },
        error: function (xhr) {

            let errorMsg = '';
            $.each(xhr.responseJSON.errors, function (key, value) {
                errorMsg += value[0] + '<br>';
            });

            Swal.fire({
                icon: 'error',
                title: 'Validation Error',
                html: errorMsg
            });
        }
    });
});


// ================= EDIT LOAD =================
$(document).on('click', '.editBtn', function () {
    const id = $(this).data('id');

    let url = "{{ route('coupons.edit', ':id') }}";
    url = url.replace(':id', id);

    $.get(url, function (data) {
        $('#edit_id').val(data.id);
        $('#edit_code').val(data.code);
        $('#edit_type').val(data.type == 1 ? 'percentage' : 'amount');
        $('#edit_value').val(data.value);
        $('#edit_status').val(data.status);
        $('#edit_limit').val(data.use_limit);
        // $('#edit_expiry_date').val(data.expiry_date);
        if (data.expiry_date) {
            let date = new Date(data.expiry_date);
            let formattedDate = date.toISOString().split('T')[0];
            $('#edit_expiry_date').val(formattedDate);
        }
        $('#editCouponModal').modal('show');
    });
});


// ================= UPDATE =================
$('#editCouponForm').on('submit', function (e) {
    e.preventDefault();

    const id = $('#edit_id').val();

    let url = "{{ route('coupons.update', ':id') }}";
    url = url.replace(':id', id);

    $.ajax({
        url: url,
        type: 'POST',
        data: $(this).serialize(),
        beforeSend: function () {
            Swal.fire({
                title: 'Updating...',
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });
        },
        success: function (res) {

            Swal.fire({
                icon: 'success',
                title: 'Updated!',
                text: res.message,
                timer: 1500,
                showConfirmButton: false
            });

            $('#editCouponModal').modal('hide');

            table.ajax.reload(null, false); // reload table
        },
        error: function (xhr) {

            let msg = '';
            $.each(xhr.responseJSON.errors, function (k, v) {
                msg += v[0] + '<br>';
            });

            Swal.fire({
                icon: 'error',
                title: 'Error',
                html: msg
            });
        }
    });
});


// ================= DELETE =================
$(document).on('click', '.deleteBtn', function () {

    const id = $(this).data('id');

    let url = "{{ route('coupons.destroy', ':id') }}";
    url = url.replace(':id', id);

    Swal.fire({
        title: 'Are you sure?',
        text: 'This coupon will be deleted!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it'
    }).then((result) => {

        if (result.isConfirmed) {

            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    _method: 'DELETE'
                },
                success: function (res) {

                    Swal.fire({
                        icon: 'success',
                        title: 'Deleted!',
                        text: res.message,
                        timer: 1500,
                        showConfirmButton: false
                    });

                    table.ajax.reload(null, false); // reload table
                }
            });
        }
    });
});

$(document).on('change', '.featureToggle', function () {

    let id = $(this).data('id');

    $.ajax({

        url: "{{ route('coupons.feature.toggle') }}",

        type: "POST",

        data: {

            _token: "{{ csrf_token() }}",

            id: id
        },

        beforeSend: function () {

            Swal.fire({
                title: 'Updating...',
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });
        },

        success: function (res) {

            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: res.message,
                timer: 1200,
                showConfirmButton: false
            });

            // RELOAD TABLE
            table.ajax.reload(null, false);
        },

        error: function () {

            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Something went wrong'
            });
        }
    });

});
</script>
@endpush
