@extends('admin.layouts.app')

@section('content')
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">

    <style>
        /* ====== PAGE ====== */
        body {
            background-color: #f4f6f9;
        }

        /* ====== ADD BUTTON ====== */
        .add-btn {
            background: linear-gradient(135deg, #22c55e, #16a34a);
            color: #fff !important;
            padding: 10px 22px;
            border-radius: 999px;
            font-size: 14px;
            font-weight: 600;
            box-shadow: 0 8px 20px rgba(34, 197, 94, .35);
            transition: all .3s ease;
        }

        .add-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 28px rgba(34, 197, 94, .45);
        }

        /* ====== MODAL ====== */
        .modal-content {
            border-radius: 18px;
            border: none;
            overflow: hidden;
        }

        .modal-header {
            background: linear-gradient(135deg, #16a34a, #22c55e);
            color: #fff;
            border-bottom: none;
            padding: 18px 24px;
        }

        .modal-header h5 {
            font-weight: 600;
        }

        .modal-footer {
            border-top: none;
            padding: 16px 24px;
        }

        /* ====== FORM ====== */
        label {
            font-size: 13px;
            font-weight: 500;
            margin-bottom: 6px;
        }

        .form-control,
        .form-select {
            border-radius: 10px;
            border: 1px solid #e5e7eb;
            padding: 10px 12px;
            font-size: 14px;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #22c55e;
            box-shadow: 0 0 0 3px rgba(34, 197, 94, .15);
        }

        /* ====== CHECKBOX ====== */
        .form-check-input {
            width: 18px;
            height: 18px;
            cursor: pointer;
        }

        .form-check-input:checked {
            background-color: #22c55e;
            border-color: #22c55e;
        }

        /* ====== SAVE BUTTON ====== */
        .modal-footer .btn-success {
            background: linear-gradient(135deg, #22c55e, #16a34a);
            border: none;
            border-radius: 10px;
            padding: 10px 26px;
            font-weight: 600;
            box-shadow: 0 6px 16px rgba(34, 197, 94, .35);
        }

        /* ====== TABLE ====== */
        .premium-table {
            background: #fff;
            border-radius: 18px;
            padding: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .06);
        }

        #orderTable thead th {
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            color: #6b7280;
            border-bottom: 1px solid #e5e7eb;
        }

        #orderTable tbody td {
            font-size: 14px;
            vertical-align: middle;
            border-bottom: 1px solid #f1f5f9;
        }

        #orderTable tbody tr:hover {
            background: #f9fafb;
        }

        /* ====== ALERT ====== */
        .alert-success {
            border-radius: 14px;
            box-shadow: 0 6px 18px rgba(34, 197, 94, .25);
        }

        /* Popup size */
        .small-swal {
            padding: 20px !important;
        }

        /* Title small */
        .swal-title {
            font-size: 18px;
            font-weight: 600;
        }

        /* Small input */
        .small-input {
            font-size: 14px !important;
            padding: 8px 10px !important;
            height: 38px !important;
        }

        /* Buttons small */
        .swal2-actions button {
            font-size: 13px !important;
            padding: 6px 16px !important;
        }

        #orderDetailsContent .row {
            border-bottom: 1px solid #f1f5f9;
            padding-bottom: 6px;
        }

        #orderDetailsContent .fw-semibold {
            color: #6b7280;
        }
    </style>

    <div class="container mt-4">

        @if(session('success'))
            <div class="alert alert-success" id="successMessage">
                {{ session('success') }}
            </div>
        @endif

        <!-- ================= PRODUCT TABLE ================= -->
        <div class="table-responsive premium-table">
            <table id="orderTable" class="table w-100">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Order ID</th>
                        <th>Product Name</th>
                        <th>Category</th>
                        <th>Coupon</th>
                        <th>Price</th>
                        <th>Order Date</th>
                        <th>Image</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
        <div class="modal fade" id="orderViewModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Order Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body" id="orderDetailsContent">
                        Loading...
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
@push('scripts')
    <script>

        $(document).ready(function () {

            $('#orderTable').DataTable({
                processing: true,
                serverSide: false,
                ajax: "{{ route('adminorders') }}",
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },

                    { data: 'orderid', name: 'orderid' },
                    { data: 'product_name', name: 'product_name' },
                    { data: 'category', name: 'category' },
                    { data: 'coupon', name: 'coupon' },
                    {
                        data: 'price',
                        name: 'price',
                        orderable: false,
                        searchable: false
                    },
                    { data: 'order_date', name: 'order_date' },


                    {
                        data: 'image',
                        name: 'image',
                        orderable: false,
                        searchable: false
                    },



                    {
                        data: 'status',
                        name: 'status',
                        orderable: false,
                        searchable: false
                    },

                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

        });
        $(document).on('click', '.deliverBtn', function () {

            let orderId = $(this).data('id');
            let price = $(this).data('price');

            Swal.fire({
                title: '<span class="swal-title">Mark as Delivered</span>',
                html: `
                                            <input type="number" id="amount" class="swal2-input small-input" 
                                                   placeholder="Enter Amount" value="${price}">

                                            <select id="status" class="swal2-select small-input">
                                                <option value="2">Delivered</option>
                                                <option value="0">Pending</option>
                                                <option value="5">shipping</option>
                                            </select>
                                        `,
                showCancelButton: true,
                confirmButtonText: 'Save',
                cancelButtonText: 'Cancel',
                width: '380px',
                customClass: {
                    popup: 'small-swal',
                    confirmButton: 'btn btn-sm btn-primary',
                    cancelButton: 'btn btn-sm btn-secondary'
                },
                preConfirm: () => {
                    return {
                        amount: document.getElementById('amount').value,
                        status: document.getElementById('status').value
                    }
                }
            }).then((result) => {

                if (result.isConfirmed) {

                    $.ajax({
                        url: "{{ route('update.delivery', ':id') }}".replace(':id', orderId),
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            amount: result.value.amount,
                            status: result.value.status
                        },
                        success: function (response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Updated!',
                                text: 'Order marked as delivered.',
                                timer: 1500,
                                showConfirmButton: false,
                                width: '300px'
                            });

                            setTimeout(() => {
                                location.reload();
                            }, 1500);
                        }
                    });
                }
            });

        });

        $(document).on('click', '.viewBtn', function () {

            let orderId = $(this).data('id');

            $.ajax({
                url: "{{ route('admin.order.view', ':id') }}".replace(':id', orderId),
                type: "GET",
                success: function (response) {

                    if (response.status) {

                        let order = response.data;

                        let html = `
                        <div class="row">
                            
                            <div class="col-6 mb-2">
                                <strong>Order ID:</strong> ORD-${order.orderid ?? order.id}
                            </div>
                            <div class="col-6 mb-2">
                                <strong>Total Price:</strong> ₹${order.price ?? 0}
                            </div>
                        </div>
                        
                        <hr>
                        <h6 class="mb-3">Product Details</h6>
                    `;

                        if (order.product) {
                            let statusBadge = '<span class="badge bg-danger">Cancelled</span>';
                            if (order.status == 2) {
                                statusBadge = '<span class="badge bg-success">Delivered</span>';
                            } else if (order.status == 0) {
                                statusBadge = '<span class="badge bg-warning">Pending</span>';
                            } else if (order.status == 1) {
                                statusBadge = '<span class="badge bg-info">Order Confirm</span>';
                            } else if (order.status == 4) {
                                statusBadge = '<span class="badge bg-danger">Returned</span>';
                            }

                            html += `
                            <div class="row mb-2">
                                <div class="col-5 fw-semibold">Product Name :</div>
                                <div class="col-7">${order.product.name ?? 'N/A'}</div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-5 fw-semibold">Order Price :</div>
                                <div class="col-7">₹${order.price ?? 0}</div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-5 fw-semibold">Discount :</div>
                                <div class="col-7">₹${order.discount ?? 0}</div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-5 fw-semibold">Coupon Code :</div>
                                <div class="col-7">${order.coupon_code ?? 'N/A'}</div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-5 fw-semibold">Total :</div>
                                <div class="col-7 fw-bold text-success">₹${order.total ?? 0}</div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-5 fw-semibold">Payment Type :</div>
                                <div class="col-7">
                                    ${
                                        order.payment_type == 1 
                                            ? 'COD' 
                                            : order.payment_type == 2 
                                                ? 'Razorpay' 
                                                : 'N/A'
                                    }
                                </div>
                            </div>
                            

                            <div class="row mb-2">
                                <div class="col-5 fw-semibold">Status :</div>
                                <div class="col-7">${statusBadge}</div>
                            </div>

                           <div class="row mb-2">
                            <div class="col-5 fw-semibold">Address :</div>
                                <div class="col-7">
                                    ${
                                        order.address 
                                            ? `${order.address.address ?? ''}, 
                                            ${order.address.city ?? ''}, 
                                            ${order.address.state ?? ''} - 
                                            ${order.address.pincode ?? ''}`
                                            : 'N/A'
                                    }
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-5 fw-semibold">Order Date :</div>
                                <div class="col-7">${order.order_date ?? 'N/A'}</div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-5 fw-semibold">Delivery Date :</div>
                                <div class="col-7">${order.delivery_date ?? 'N/A'}</div>
                            </div>
                        `;

                        } else {
                            html += `<p class="text-muted">No product found</p>`;
                        }

                        $('#orderDetailsContent').html(html);

                        let myModal = new bootstrap.Modal(
                            document.getElementById('orderViewModal')
                        );
                        myModal.show();
                    }
                }
            });

        });
    </script>


@endpush