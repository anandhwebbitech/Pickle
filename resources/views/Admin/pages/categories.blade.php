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
    <div class="admin-card">

        <!-- HEADER -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0 fw-semibold"> Category </h5>

            <button class="btn btn-primary"
                    data-bs-toggle="modal"
                    data-bs-target="#addCategoryModal">
                <i class="fa fa-plus me-1"></i> Add Category
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
                        <th>Name</th>
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

<!-- ================= ADD CATEGORY MODAL ================= -->
<div class="modal fade" id="addCategoryModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST"
              id="categoryForm"
              class="modal-content border-0 shadow-lg rounded-4">
            @csrf

            <div class="modal-header border-0 px-4 pt-4">
                <h5 class="modal-title fw-semibold">➕ Add Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body px-4 pb-3">
                <div class="mb-3">
                    <label class="form-label">Category Name</label>
                    <input type="text"
                           name="name"
                           class="form-control"
                           placeholder="Enter category name"
                           required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select" required>
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
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
                    Save Category
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ================= EDIT CATEGORY MODAL ================= -->
<!-- ================= EDIT CATEGORY MODAL ================= -->
<div class="modal fade" id="editCategoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form id="editCategoryForm"
              method="POST"
              class="modal-content border-0 shadow rounded-4">
            @csrf
            @method('PUT')

            <!-- Header -->
            <div class="modal-header border-0 px-4 pt-4">
                <h5 class="modal-title fw-semibold">
                    ✏️ Edit Category
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Body -->
            <div class="modal-body px-4 pb-3">

                <!-- Hidden ID -->
                <input type="hidden" id="edit_id">

                <!-- Name -->
                <div class="mb-3">
                    <label class="form-label small fw-semibold">
                        Category Name
                    </label>
                    <input type="text"
                           id="edit_name"
                           name="name"
                           class="form-control form-control-sm"
                           placeholder="Enter category name"
                           required>
                </div>

                <!-- Status -->
                <div class="mb-3">
                    <label class="form-label small fw-semibold">
                        Status
                    </label>
                    <select id="edit_status"
                            name="status"
                            class="form-select form-select-sm"
                            required>
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>

            </div>

            <!-- Footer -->
            <div class="modal-footer border-0 px-4 pb-4">
                <button type="button"
                        class="btn btn-light btn-sm"
                        data-bs-dismiss="modal">
                    Cancel
                </button>
                <button type="submit"
                        class="btn btn-primary btn-sm">
                    Update Category
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
    setTimeout(() => {
        $('#successMessage, #dangerMessage').fadeOut();
    }, 3000);
    // ================= ADD =================
   let categoryTable;

$(document).ready(function () {

    categoryTable = $('#categoryTable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ordering: false,
        searching: true,

        ajax: "{{ route('categories.index') }}",

        columns: [
            {
                data: null,
                orderable: false,
                render: (data, type, row, meta) =>
                    meta.row + meta.settings._iDisplayStart + 1
            },
            { data: 'name', name: 'name' },
            { data: 'status', name: 'status' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],

        language: {
            emptyTable: "No categories found",
            processing: "Loading categories..."
        }
    });

});

// 🔄 Reload table safely
function reloadTable() {
    if (categoryTable) {
        categoryTable.ajax.reload(null, false);
    }
}
$('#categoryForm').submit(function (e) {
    e.preventDefault();

    $.ajax({
        url: "{{ route('categories.store') }}",
        type: "POST",
        data: $(this).serialize(),

        success: function (response) {
            // Close modal & reset form
            $('#addCategoryModal').modal('hide');
            $('#categoryForm')[0].reset();

            // ✅ SUCCESS ALERT
            Swal.fire({
                icon: 'success',
                title: 'Added!',
                text: 'Category added successfully',
                timer: 1500,
                showConfirmButton: false
            });

            // Optional reload / refresh
           reloadTable();

        },

        error: function (xhr) {

            let message = 'Something went wrong!';

            // Laravel validation errors
            if (xhr.status === 422) {
                let errors = xhr.responseJSON.errors;
                message = Object.values(errors)[0][0]; // first error message
            }

            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: message
            });
        }
    });
});

 // ================= EDIT =================
$(document).on('click', '.editBtn', function () {

    $('#edit_id').val($(this).data('id'));
    $('#edit_name').val($(this).data('name'));
    $('#edit_status').val($(this).data('status'));

    let url = $(this).data('url');
    $('#editCategoryForm').attr('action', url);

    $('#editCategoryModal').modal('show');
});
    // ================= UPDATE =================
    $('#editCategoryForm').submit(function (e) {
    e.preventDefault();

    let url = $('#editCategoryForm').attr('action');

    $.ajax({
        url: url,
        type: "POST", // method spoofing
        data: $(this).serialize(),
        success: function (response) {

            $('#editCategoryModal').modal('hide');

            Swal.fire({
                icon: 'success',
                title: 'Updated!',
                text: response.message ?? 'Category updated successfully',
                timer: 1500,
                showConfirmButton: false
            });

            $('#categoryTable').DataTable().ajax.reload(null, false);
        },
        error: function (xhr) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: xhr.responseJSON?.message ?? 'Update failed'
            });
        }
    });
});

    // ================= DELETE =================
    $(document).on('click', '.deleteBtn', function () {
        const id = $(this).data('id');

        Swal.fire({
            title: 'Are you sure?',
            text: 'This category will be deleted!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/categories/${id}`,
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        _method: 'DELETE'
                    },
                    success: function () {
                        fetchCategories();
                        Swal.fire('Deleted!', 'Category removed.', 'success');
                    }
                });
            }
        });
    });
</script>
@endpush
