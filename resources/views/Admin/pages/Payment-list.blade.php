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

        #paymentTable thead th {
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            color: #6b7280;
            border-bottom: 1px solid #e5e7eb;
        }

        #paymentTable tbody td {
            font-size: 14px;
            vertical-align: middle;
            border-bottom: 1px solid #f1f5f9;
        }

        #paymentTable tbody tr:hover {
            background: #f9fafb;
        }

        /* ====== ALERT ====== */
        .alert-success {
            border-radius: 14px;
            box-shadow: 0 6px 18px rgba(34, 197, 94, .25);
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
            <table id="paymentTable" class="table w-100">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Order ID</th>
                        <th>Product Name</th>
                        <th>Payment ID</th>
                        <th>Payment Method</th>
                        <th>Amount</th>
                        <th>Payment Status</th>
                    </tr>
                </thead>
            </table>
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

            $('#paymentTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('payments') }}",

                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable:false, searchable:false },

                    { data: 'order_id', name: 'order_id' },
                    { data: 'product_name', name: 'product_name' },
                    { data: 'payment_id', name: 'payment_id' },
                    { data: 'payment_method', name: 'payment_method' },
                    { data: 'amount', name: 'amount' },
                    {
                        data: 'status',
                        name: 'status',
                        orderable: false,
                        searchable: false
                    },

                    
                ]
            });

        });
        
    </script>


@endpush