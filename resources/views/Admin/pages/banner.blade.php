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
    <div class="admin-card">

        <!-- HEADER -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-semibold">Banner Master</h5>

            <button class="btn btn-primary"
                    data-bs-toggle="modal"
                    data-bs-target="#addBannerModal">
                <i class="fa fa-plus"></i> Add Banner
            </button>
        </div>

        <!-- TABLE -->
        <table id="bannerTable" class="table table-hover w-100">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Image</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>

    </div>
</div>

<!-- ================= ADD MODAL ================= -->
<div class="modal fade" id="addBannerModal">
    <div class="modal-dialog modal-dialog-centered">
        <form id="bannerForm" enctype="multipart/form-data"
              class="modal-content border-0 shadow rounded-4">
            @csrf

            <div class="modal-header border-0">
                <h5>🖼️ Add Banner</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <input type="text" name="name" class="form-control mb-3"
                       placeholder="Banner Title" required>

                <input type="file" name="image" id="imageInput"
                       class="form-control mb-3" required>

                <img id="preview" style="width:100%; display:none; border-radius:10px;">

                <select name="status" class="form-select mt-3">
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>

            </div>

            <div class="modal-footer border-0">
                <button class="btn btn-success">Save</button>
            </div>

        </form>
    </div>
</div>

<!-- ================= EDIT MODAL ================= -->
<div class="modal fade" id="editBannerModal">
    <div class="modal-dialog modal-dialog-centered">
        <form id="editForm" enctype="multipart/form-data"
              class="modal-content border-0 shadow rounded-4">
            @csrf

            <div class="modal-header border-0">
                <h5>✏️ Edit Banner</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <input type="hidden" id="edit_id">

                <input type="text" name="name" id="edit_name"
                       class="form-control mb-3" required>

                <input type="file" name="image" id="edit_image"
                       class="form-control mb-3">

                <img id="edit_preview"
                     style="width:100%; border-radius:10px; margin-bottom:10px;">

                <select name="status" id="edit_status"
                        class="form-select">
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>

            </div>

            <div class="modal-footer border-0">
                <button class="btn btn-primary">Update</button>
            </div>

        </form>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
let table;

$(document).ready(function () {

    table = $('#bannerTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('bannerpage') }}",
        columns: [
            { data: 'DT_RowIndex', orderable:false, searchable:false },
            { data: 'name' },
            { data: 'image', orderable:false },
            { data: 'status' },
            { data: 'action', orderable:false }
        ]
    });

});


// ================= IMAGE PREVIEW (ADD) =================
$('#imageInput').change(function(e){
    let file = e.target.files[0];

    if(file){
        let reader = new FileReader();
        reader.onload = e => {
            $('#preview').attr('src', e.target.result).show();
        }
        reader.readAsDataURL(file);
    }
});


// ================= ADD =================
$('#bannerForm').submit(function(e){
    e.preventDefault();

    let formData = new FormData(this);

    $.ajax({
        url: "{{ route('banners.store') }}",
        type: "POST",
        data: formData,
        processData:false,
        contentType:false,

        success:function(){
            $('#addBannerModal').modal('hide');
            $('#bannerForm')[0].reset();
            $('#preview').hide();

            table.ajax.reload();

            Swal.fire('Added!','','success');
        }
    });
});


// ================= EDIT CLICK =================
$(document).on('click','.editBtn',function(){
    const bannerImageBase = "{{ asset('public/uploads/banners') }}/";
    $('#edit_id').val($(this).data('id'));
    $('#edit_name').val($(this).data('name'));
    $('#edit_status').val($(this).data('status'));

    let image = $(this).data('image');
    $('#edit_preview').attr('src', bannerImageBase + image);

    $('#editForm').attr('action',$(this).data('url'));

    $('#editBannerModal').modal('show');
});


// ================= IMAGE PREVIEW (EDIT) =================
$('#edit_image').change(function(e){
    let file = e.target.files[0];

    if(file){
        let reader = new FileReader();
        reader.onload = e => {
            $('#edit_preview').attr('src', e.target.result);
        }
        reader.readAsDataURL(file);
    }
});


// ================= UPDATE =================
let isSubmitting = false;

$('#editForm').submit(function(e){

    if(isSubmitting) return;
    isSubmitting = true;

    e.preventDefault();

    let formData = new FormData(this);

    $.ajax({
        url: $(this).attr('action'),
        type: "POST",
        data: formData,
        processData:false,
        contentType:false,

        success:function(){
            $('#editBannerModal').modal('hide');
            table.ajax.reload();

            Swal.fire('Updated!','','success');
        },
        complete:function(){
            isSubmitting = false;
        }
    });
});
$('#editBannerModal').on('hidden.bs.modal', function () {
    $('#editForm')[0].reset();
    $('#edit_preview').attr('src', '').hide();
});


// ================= DELETE =================
$(document).on('click','.deleteBtn',function(){

    let id = $(this).data('id');

    Swal.fire({
        title:'Delete?',
        icon:'warning',
        showCancelButton:true
    }).then(res => {

        if(res.isConfirmed){

            $.ajax({
                url: "{{ route('banners.destroy', ':id') }}".replace(':id',id),
                type:'POST',
                data:{
                    _token:"{{ csrf_token() }}",
                    _method:"DELETE"
                },
                success:function(){
                    table.ajax.reload();
                    Swal.fire('Deleted!','','success');
                }
            });

        }
    });

});
</script>
@endpush
