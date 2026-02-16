@extends('admin.layouts.app')

@section('content')

    <style>
        /* Dashboard Grid */
        .dashboard-wrapper {
            padding: 40px 20px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 24px;
        }

        /* Stat Card */
        .stat-card {
            position: relative;
            background: #ffffff;
            border-radius: 20px;
            padding: 28px 24px;
            display: flex;
            align-items: center;
            gap: 20px;
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .stat-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
        }

        /* Icon */
        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            color: #fff;
        }

        /* Background gradients */
        .bg-category {
            background: linear-gradient(135deg, #4f46e5, #6366f1);
        }

        .bg-product {
            background: linear-gradient(135deg, #10b981, #059669);
        }

        .bg-user {
            background: linear-gradient(135deg, #f59e0b, #d97706);
        }

        .bg-order {
            background: linear-gradient(135deg, #ef4444, #b91c1c);
        }

        /* Decorative circle */
        .decor-circle {
            position: absolute;
            border-radius: 50%;
            opacity: 0.15;
        }

        /* Content */
        .stat-content h6 {
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 1.2px;
            text-transform: uppercase;
            color: #9ca3af;
            margin-bottom: 4px;
        }

        .stat-content h2 {
            font-size: 32px;
            font-weight: 700;
            margin: 0;
            color: #111827;
        }

        .stat-content p {
            font-size: 13px;
            color: #6b7280;
            margin-top: 4px;
        }

        .stat-icon i {
            font-size: 32px;
            color: #fff;
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

        .card {
            border-radius: 20px;
        }

        .table thead th {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #6b7280;
            border-bottom: 1px solid #e5e7eb;
        }

        .table tbody td {
            font-size: 14px;
            vertical-align: middle;
            padding: 14px 10px;
        }

        .table-hover tbody tr:hover {
            background: #f9fafb;
        }

        .badge-status {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <div class="container-fluid py-4">
        <div class="dashboard-wrapper">

            <!-- Categories Card -->
            <div class="stat-card">
                <div class="decor-circle" style="top:-20px; right:-20px; width:80px; height:80px; background:#6366f1;">
                </div>
                <div class="stat-icon bg-category">
                    <i class="bi bi-grid"></i>
                </div>
                <div class="stat-content">
                    <h6>Categories</h6>
                    <h2>{{ $categoryCount }}</h2>
                    <p>Total categories available</p>
                </div>
            </div>

            <!-- Products Card -->
            <div class="stat-card">
                <div class="decor-circle" style="top:-20px; right:-20px; width:80px; height:80px; background:#059669;">
                </div>
                <div class="stat-icon bg-product">
                    <i class="bi bi-box-seam"></i>
                </div>
                <div class="stat-content">
                    <h6>Products</h6>
                    <h2>{{ $productCount }}</h2>
                    <p>Total products listed</p>
                </div>
            </div>

            <!-- Coupons Card -->
            <div class="stat-card">
                <div class="decor-circle" style="top:-20px; right:-20px; width:80px; height:80px; background:#d97706;">
                </div>
                <div class="stat-icon bg-user">
                    <i class="bi bi-ticket-perforated"></i>
                </div>
                <div class="stat-content">
                    <h6>Active Coupons</h6>
                    <h2>{{ $coupon }}</h2>
                    <p>Total active coupons</p>
                </div>
            </div>

            <!-- Orders Card -->
            <div class="stat-card">
                <div class="decor-circle" style="top:-20px; right:-20px; width:80px; height:80px; background:#b91c1c;">
                </div>
                <div class="stat-icon bg-order">
                    <i class="bi bi-receipt"></i>
                </div>
                <div class="stat-content">
                    <h6>Orders</h6>
                    <h2>{{ $ordersCount }}</h2>
                    <p>Total active orders</p>
                </div>
            </div>

        </div>

        <div class="card border-0 shadow-sm rounded-4 mt-4">
            <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
                <h5 class="fw-bold mb-0">Upcomming Deliveries</h5>
                <p class="text-muted small mb-3">(Today & Tomorrow Deliveries)</p>
            </div>

            <div class="card-body pt-0 px-4 pb-4">
                <div class="table-responsive">
                    <table id="orderTable" class="table align-middle table-hover w-100">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Order ID</th>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Image</th>
                                <th>Delivery Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                    </table>
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
                serverSide: true,
                ajax: "{{ route('dashboardorders') }}",

                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'orderid', name: 'orderid' },
                    { data: 'product_name', name: 'product_name' },
                    {
                        data: 'price',
                        name: 'price',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'image',
                        name: 'image',
                        orderable: false,
                        searchable: false
                    },
                    { data: 'delivery_date', name: 'delivery_date' },
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