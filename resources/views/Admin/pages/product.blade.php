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

        #productTable thead th {
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            color: #6b7280;
            border-bottom: 1px solid #e5e7eb;
        }

        #productTable tbody td {
            font-size: 14px;
            vertical-align: middle;
            border-bottom: 1px solid #f1f5f9;
        }

        #productTable tbody tr:hover {
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

        <!-- ================= ADD PRODUCT MODAL ================= -->
        <button class="btn m-3 add-btn" data-bs-toggle="modal" data-bs-target="#addProductModal">
            Add Product
        </button>

        <div class="modal fade" id="addProductModal" tabindex="-1">
            <div class="modal-dialog modal-xl">
                <form id="addProductForm" enctype="multipart/form-data">
                    @csrf

                    <div class="modal-content">
                        <div class="modal-header">
                            <h5>Add Product</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                            <div class="row g-3">

                                <!-- Product Name -->
                                <div class="col-md-4">
                                    <label>Product Name</label>
                                    <input type="text" name="name" class="form-control">
                                </div>

                                <!-- Category -->
                                <div class="col-md-4">
                                    <label>Category</label>
                                    <select name="category_id" class="form-control">
                                        <option value="">Select</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label>Sub Category</label>
                                    <select name="sub_category_id" class="form-control" id="subCategorySelect">
                                        <option value="">Select Sub Category</option>
                                    </select>
                                </div>

                                <!-- Deals + South Indian -->
                                <div class="col-md-4 d-flex align-items-center gap-4 mt-4">
                                    <div class="form-check">
                                        <input type="checkbox" name="deals" value="1" class="form-check-input">
                                        <label class="form-check-label">Deals</label>
                                    </div>

                                    <div class="form-check">
                                        <input type="checkbox" name="south_indian" value="1" class="form-check-input">
                                        <label class="form-check-label">South Indian</label>
                                    </div>
                                </div>

                                <!-- Image -->
                                <div class="col-md-4">
                                    <label>Image (Max 4)</label>
                                    <input type="file" name="images[]" class="form-control" multiple accept="image/*"
                                        id="imageInput">
                                </div>
                                <!-- Discount -->
                                <div class="col-md-4">
                                    <label>Discount (%)</label>
                                    <input type="number" name="discount" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label>Quantity (kg)</label>
                                    <input type="number" step="0.01" name="quantity" class="form-control"
                                        placeholder="Eg: 1.5">
                                </div>

                                <!-- WEIGHT & PRICE -->
                                <div class="col-md-12">
                                    <label>Weight & Price</label>

                                    <div id="weightPriceWrapper">
                                        <div class="row mb-2 weight-row">
                                            <div class="col-md-4">
                                                <input type="text" name="weights[0][weight]" class="form-control"
                                                    placeholder="Weight (eg: 250g)">
                                            </div>

                                            <div class="col-md-4">
                                                <input type="number" name="weights[0][price]" class="form-control"
                                                    placeholder="Price (₹)">
                                            </div>

                                            <div class="col-md-2">
                                                <button type="button" class="btn btn-success btn-sm addWeightPrice"
                                                    style="border-radius:25px; padding:7px 10px;">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Discount -->

                                <!-- Description -->
                                <div class="col-md-12">
                                    <label>Description</label>
                                    <textarea name="description" class="form-control" rows="3"></textarea>
                                </div>

                                <!-- CONTAINS -->
                                <div class="col-md-12">
                                    <label>Contains</label>

                                    <div id="containsWrapper">
                                        <div class="row mb-2">
                                            <div class="col-md-10">
                                                <input type="text" name="contains[]" class="form-control"
                                                    placeholder="Eg: Mustard, Garlic">
                                            </div>
                                            <div class="col-md-2">
                                                <!-- <button type="button" class="btn btn-primary w-100 addContains">
                                                + Add
                                            </button> -->
                                                <button type="button" class="btn btn-primary btn-sm addContains"
                                                    style="border-radius:25px; padding:7px 10px;">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>



                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">Save</button>
                        </div>

                    </div>
                </form>
            </div>
        </div>


        <!-- ================= PRODUCT TABLE ================= -->
        <div class="table-responsive premium-table">
            <table id="productTable" class="table w-100">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>

        <!-- Edit Modal -->
        <div class="modal fade" id="editProductModal" tabindex="-1">
            <div class="modal-dialog modal-xl">
                <form id="editProductForm" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="id" id="edit_id">

                    <div class="modal-content">
                        <div class="modal-header">
                            <h5>Edit Product</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                            <div class="row g-3">

                                <div class="col-md-4">
                                    <label>Product Name</label>
                                    <input type="text" name="name" id="edit_name" class="form-control">
                                </div>

                                <div class="col-md-4">
                                    <label>Category</label>
                                    <select name="category_id" id="edit_category" class="form-control">
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label>Sub Category</label>
                                    <select name="sub_category_id" id="edit_sub_category" class="form-control">
                                        <option value="">Select Sub Category</option>
                                    </select>
                                </div>

                                <div class="col-md-4 d-flex gap-4 mt-4 p-4">
                                    <div class="form-check">
                                        <input type="checkbox" name="deals" id="edit_deals" value="1"
                                            class="form-check-input">
                                        <label class="form-check-label">Deals</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" name="south_indian" id="edit_south_indian"
                                            value="1" class="form-check-input">
                                        <label class="form-check-label">South Indian</label>
                                    </div>
                                </div>
                                {{-- <div class="col-md-4 d-flex gap-4 mt-4">
                                    
                                </div> --}}


                                <div class="col-md-4">
                                    <label>Image (Max 4)</label>
                                    <input type="file" name="images[]" class="form-control" multiple accept="image/*"
                                        id="imageInput">
                                </div>

                                <div class="col-md-4">
                                    <label>Quantity</label>
                                    <input type="number" name="quantity" id="edit_quantity" class="form-control">
                                </div>

                                <div class="col-md-12">
                                    <label>Description</label>
                                    <textarea name="description" id="edit_description" class="form-control"></textarea>
                                </div>

                                <!-- WEIGHT & PRICE -->
                                <div class="col-md-12">
                                    <label>Weight & Price</label>
                                    <div id="editWeightWrapper"></div>
                                    <button type="button" class="btn btn-success btn-sm addEditWeight mt-2">
                                        <i class="fa fa-plus"></i> Add Weight
                                    </button>
                                </div>

                                <!-- CONTAINS -->
                                <div class="col-md-12">
                                    <label>Contains</label>
                                    <!-- <div id="editContainsWrapper"></div> -->
                                    <div id="editContainsWrapper"></div>
                                    <button type="button" class="btn btn-primary btn-sm addEditContains mt-2">
                                        <i class="fa fa-plus"></i> Add Contains
                                    </button>
                                </div>

                            </div>
                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-success">Update</button>
                        </div>
                    </div>
                </form>
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

        document.getElementById('imageInput').addEventListener('change', function () {
            if (this.files.length > 4) {
                alert("You can select maximum 4 images only.");
                this.value = "";
            }
        });
        $(document).ready(function () {

            /* ================= CONTAINS (ADD) ================= */
            $(document).on('click', '.addContains', function () {
                let row = `
            <div class="row mb-2 contains-row">
                <div class="col-md-10">
                    <input type="text" name="contains[]" class="form-control">
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger btn-sm removeContains">
                        <i class="fa fa-trash"></i>
                    </button>
                </div>
            </div>`;
                $('#containsWrapper').append(row);
            });

            /* ================= CONTAINS (REMOVE) ================= */
            $(document).on('click', '.removeContains', function () {
                $(this).closest('.contains-row').remove();
            });


            /* ================= WEIGHT & PRICE ================= */
            let weightIndex = 1;

            $(document).on('click', '.addWeightPrice', function () {
                let row = `
            <div class="row mb-2 weight-row">
                <div class="col-md-4">
                    <input type="text" name="weights[${weightIndex}][weight]" class="form-control">
                </div>
                <div class="col-md-4">
                    <input type="number" name="weights[${weightIndex}][price]" class="form-control">
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger btn-sm removeWeightPrice">
                        <i class="fa fa-trash"></i>
                    </button>
                </div>
            </div>`;
                $('#weightPriceWrapper').append(row);
                weightIndex++;
            });

            $(document).on('click', '.removeWeightPrice', function () {
                $(this).closest('.weight-row').remove();
            });


            /* ================= EDIT MODAL (WEIGHT ADD) ================= */
            $(document).on('click', '.addEditWeight', function () {
                let index = $('#editWeightWrapper .edit-weight-row').length;

                let row = `
            <div class="row mb-2 edit-weight-row">
                <div class="col-md-4">
                    <input type="text" name="weights[${index}][weight]" class="form-control">
                </div>
                <div class="col-md-4">
                    <input type="number" name="weights[${index}][price]" class="form-control">
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger btn-sm removeEditWeight">
                        <i class="fa fa-trash"></i>
                    </button>
                </div>
            </div>`;
                $('#editWeightWrapper').append(row);
            });

            $(document).on('click', '.removeEditWeight', function () {
                $(this).closest('.edit-weight-row').remove();
            });


            /* ================= EDIT MODAL (CONTAINS ADD) ================= */
            $(document).on('click', '.addEditContains', function () {
                let row = `
            <div class="row mb-2 edit-contains-row">
                <div class="col-md-10">
                    <input type="text" name="contains[]" class="form-control">
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger btn-sm removeEditContains">
                        <i class="fa fa-trash"></i>
                    </button>
                </div>
            </div>`;
                $('#editContainsWrapper').append(row);
            });

            $(document).on('click', '.removeEditContains', function () {
                $(this).closest('.edit-contains-row').remove();
            });

        });
        
        let productTable; // global variable to hold the DataTable instance
        $(document).ready(function () {

            productTable = $('#productTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('products.index') }}",

                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },

                    {
                        data: 'image',
                        name: 'image',
                        orderable: false,
                        searchable: false
                    },

                    { data: 'name', name: 'name' },

                    { data: 'category', name: 'category.name' },

                    {
                        data: 'price',
                        name: 'price',
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
            $('#addProductForm').on('submit', function (e) {
                e.preventDefault();

                let form = this;
                let formData = new FormData(form);

                $.ajax({
                    url: "{{ route('products.store') }}",
                    type: "POST",
                    data: formData,
                    processData: false,   // Important for FormData
                    contentType: false,   // Important for FormData
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },

                    beforeSend: function () {
                        // Optional: Disable button to prevent double click
                        $('#addProductForm button[type="submit"]').prop('disabled', true);
                    },

                    success: function (response) {

                        $('#addProductModal').modal('hide');
                        form.reset();
                        $('#weightPriceWrapper').html('');

                        Swal.fire({
                            icon: 'success',
                            title: 'Added!',
                            text: response.message ?? 'Product added successfully',
                            timer: 1500,
                            showConfirmButton: false
                        });
                        window.location.reload(); 
                    },

                    error: function (xhr) {

                        let message = 'Something went wrong';

                        if (xhr.status === 422 && xhr.responseJSON.errors) {
                            let errors = xhr.responseJSON.errors;
                            message = Object.values(errors)[0][0];
                        }

                        Swal.fire({
                            icon: 'error',
                            title: 'Validation Error',
                            text: message
                        });
                    },

                    complete: function () {
                        $('#addProductForm button[type="submit"]').prop('disabled', false);
                    }
                });
            });

        });
        $(document).on('click', '.editBtn', function () {

            let id = $(this).data('id');

            $.get("{{ url('products') }}/" + id + "/edit", function (res) {

                $('#edit_id').val(res.id);
                $('#edit_name').val(res.name);
                 $('#edit_category').val(res.category_id).trigger('change');

                setTimeout(() => {

                    $('#edit_sub_category').val(res.sub_category_id);

                }, 500);
                $('#edit_quantity').val(res.quantity);
                $('#edit_description').val(res.description);
                $('#edit_deals').prop('checked', res.deals == 1);
                $('#edit_south_indian').prop('checked', res.south_indian == 1);

                /* ===== WEIGHT & PRICE ===== */
                let weights = JSON.parse(res.weight || '[]');
                let weightHtml = '';

                weights.forEach((w, i) => {
                    weightHtml += `
                <div class="row mb-2 edit-weight-row">
                    <div class="col-md-4">
                        <input type="text" name="weights[${i}][weight]"
                            value="${w.weight}" class="form-control">
                    </div>

                    <div class="col-md-4">
                        <input type="number" name="weights[${i}][price]"
                            value="${w.price}" class="form-control">
                    </div>

                    <div class="col-md-2">
                        <button type="button"
                            class="btn btn-danger btn-sm removeEditWeight"
                            style="border-radius:25px; padding:6px 10px;">
                            <i class="fa fa-trash"></i>
                        </button>
                    </div>
                </div>`;
                });

                $('#editWeightWrapper').html(weightHtml);

                /* ===== CONTAINS ===== */
                let contains = JSON.parse(res.contains || '[]');
                let containsHtml = '';

                contains.forEach(c => {
                    containsHtml += `
                <div class="row mb-2 edit-contains-row">
                    <div class="col-md-10">
                        <input type="text" name="contains[]"
                            value="${c}" class="form-control">
                    </div>

                    <div class="col-md-2">
                        <button type="button"
                            class="btn btn-danger btn-sm removeEditContains"
                            style="border-radius:25px; padding:6px 10px;">
                            <i class="fa fa-trash"></i>
                        </button>
                    </div>
                </div>`;
                });

                $('#editContainsWrapper').html(containsHtml);

                $('#editProductModal').modal('show');
            });
        });

        $('#editProductForm').submit(function (e) {
            e.preventDefault();

            let id = $('#edit_id').val();
            let formData = new FormData(this);

            $.ajax({
                url: "{{ url('products') }}/" + id,
                method: "POST",
                data: formData,
                contentType: false,
                processData: false,

                success: function () {
                    $('#editProductModal').modal('hide');
                    $('#productTable').DataTable().ajax.reload();

                    Swal.fire({
                        icon: 'success',
                        title: 'Updated!',
                        timer: 1500,
                        showConfirmButton: false
                    });
                }
            });
        });
        $(document).on('click', '.deleteBtn', function () {

            let id = $(this).data('id');

            Swal.fire({
                title: 'Are you sure?',
                text: 'This will be deleted permanently!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {

                if (result.isConfirmed) {

                    $.ajax({
                        url: "{{ url('products') }}/" + id,
                        method: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            _method: "DELETE"
                        },

                        success: function () {
                            $('#productTable').DataTable().ajax.reload();

                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                timer: 1200,
                                showConfirmButton: false
                            });
                        }
                    });
                }
            });
        });

        $('#addProductForm select[name="category_id"]').on('change', function () {
            let categoryId = $(this).val();

            if (categoryId) {
                let url = "{{ route('get.subcategories', ':id') }}".replace(':id', categoryId);

                $.ajax({
                    url: url,
                    type: "GET",
                    success: function (res) {

                        let options = '<option value="">Select Sub Category</option>';

                        res.forEach(function (item) {
                            options += `<option value="${item.id}">${item.sub_category_name}</option>`;
                        });

                        $('#subCategorySelect').html(options);
                    }
                });
            } else {
                $('#subCategorySelect').html('<option value="">Select Sub Category</option>');
            }
        });

        // EDIT PRODUCT
        $('#edit_category').on('change', function () {

            let categoryId = $(this).val();

            if (categoryId) {

                let url = "{{ route('get.subcategories', ':id') }}"
                            .replace(':id', categoryId);

                $.ajax({
                    url: url,
                    type: "GET",

                    success: function (res) {

                        let options = '<option value="">Select Sub Category</option>';

                        res.forEach(function (item) {

                            options += `
                                <option value="${item.id}">
                                    ${item.sub_category_name}
                                </option>
                            `;
                        });

                        $('#edit_sub_category').html(options);
                    }
                });

            } else {

                $('#edit_sub_category').html(
                    '<option value="">Select Sub Category</option>'
                );
            }
        });
    </script>


@endpush