@extends('admin.layouts.app')

@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">
<style>
    select.form-control-sm, 
.dataTables_length select {
    width: auto !important;      /* Allow it to grow to fit content */
    min-width: 60px;             /* Ensure it's not too small */
    padding-right: 20px !important; /* Space for the dropdown arrow */
    appearance: none;            /* Optional: resets default browser styling */
}
/* ===== GLOBAL TEXT ===== */
body {
    font-size: 13px;
}

/* ===== CARD ===== */
.admin-card {
    background: #ffffff;
    border-radius: 16px;
    padding: 22px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.06);
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
    <div class="card shadow-sm p-4 rounded-4">

        <!-- HEADER -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-semibold mb-0">Sub Categories</h5>

            <button class="btn btn-primary"
                    data-bs-toggle="modal"
                    data-bs-target="#addCategoryModal">
                <i class="fa fa-plus me-1"></i> Add Sub Category
            </button>
        </div>

        <!-- TABLE -->
        <div class="table-responsive">
            <table id="categoryTable" class="table table-hover w-100">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>

    </div>
</div>

<!-- ================= ADD MODAL ================= -->
<div class="modal fade" id="addCategoryModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form id="categoryForm" class="modal-content">
            @csrf

            <div class="modal-header">
                <h5>Add Sub Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <div class="mb-3">
                    <label>Category</label>
                    <select name="category_id" class="form-select" required>
                        <option value="">Select</option>
                        @foreach($category as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Status</label>
                    <select name="status" class="form-select">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>

        </form>
    </div>
</div>

<!-- ================= EDIT MODAL ================= -->
<div class="modal fade" id="editCategoryModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form id="editCategoryForm" class="modal-content">
            @csrf
            @method('PUT')

            <div class="modal-header">
                <h5>Edit Sub Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <input type="hidden" id="edit_id">

                <div class="mb-3">
                    <label>Category</label>
                    <select id="edit_category" name="category_id" class="form-select">
                        @foreach($category as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label>Name</label>
                    <input type="text" id="edit_name" name="name" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Status</label>
                    <select id="edit_status" name="status" class="form-select">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-success">Update</button>
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
let categoryTable;

$(document).ready(function () {

    categoryTable = $('#categoryTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('subcategories.index') }}",
        columns: [
            {
                data: 'DT_RowIndex',
                orderable: false,
                searchable: false
            },
            { data: 'category' },
            { data: 'subcategory' },
            { data: 'status' },
            { data: 'action', orderable:false }
        ]
    });

});

// ADD
$('#categoryForm').submit(function(e){
    e.preventDefault();

    $.post("{{ route('subcategories.store') }}", $(this).serialize(), function(){
        $('#addCategoryModal').modal('hide');
        $('#categoryForm')[0].reset();
        categoryTable.ajax.reload();

        Swal.fire("Added!","","success");
    });
});

// EDIT OPEN
$(document).on('click','.editBtn',function(){

    $('#edit_id').val($(this).data('id'));
    $('#edit_name').val($(this).data('name'));
    $('#edit_category').val($(this).data('category'));
    $('#edit_status').val($(this).data('status'));

    $('#editCategoryForm').attr('action', $(this).data('url'));

    $('#editCategoryModal').modal('show');
});

// UPDATE
$('#editCategoryForm').submit(function(e){
    e.preventDefault();

    let url = $(this).attr('action');

    $.post(url, $(this).serialize(), function(){
        $('#editCategoryModal').modal('hide');
        categoryTable.ajax.reload();

        Swal.fire("Updated!","","success");
    });
});

// DELETE
$(document).on('click','.deleteBtn',function(){

    let id = $(this).data('id');

    let url = "{{ route('subcategories.destroy', ':id') }}";
    url = url.replace(':id', id);

    Swal.fire({
        title:'Delete?',
        showCancelButton:true
    }).then(res=>{

        if(res.isConfirmed){

            $.post(url, {
                _token:"{{ csrf_token() }}",
                _method:"DELETE"
            }, function(){
                categoryTable.ajax.reload();
                Swal.fire("Deleted","","success");
            });

        }
    });
});
</script>

@endpush