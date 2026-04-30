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

            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addShortModal">
                + Add Short
            </button>
        </div>

        <!-- TABLE -->
        <table id="shortsTable" class="table table-hover w-100">
            <thead>
                <tr>
                    <th>#</th>
                    <th>video</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>

    </div>
</div>

<!-- ================= ADD MODAL ================= -->
<div class="modal fade" id="addShortModal">
    <div class="modal-dialog modal-dialog-centered">
        <form id="shortForm"
              class="modal-content border-0 shadow-lg rounded-4">
            @csrf

            <!-- HEADER -->
            <div class="modal-header border-0 px-4 pt-4">
                <h5 class="modal-title fw-semibold">🎬 Add Short</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- BODY -->
            <div class="modal-body px-4 pb-3">

                <!-- TITLE -->
                <div class="mb-3">
                    <label class="form-label">Title</label>
                    <input type="text" name="title"
                           class="form-control"
                           placeholder="Enter title">
                </div>

                <!-- YOUTUBE URL -->
                <div class="mb-3">
                    <label class="form-label">YouTube Shorts URL</label>
                    <input type="text" name="youtube_url"
                           id="shortUrl"
                           class="form-control"
                           placeholder="Paste Shorts link"
                           required>
                </div>

                <!-- PREVIEW -->
                <div class="mb-3 text-center">
                    <iframe id="shortPreview"
                            style="width:100%; height:220px; display:none; border-radius:10px;"></iframe>
                </div>

                <!-- STATUS -->
                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>

            </div>

            <!-- FOOTER -->
            <div class="modal-footer border-0 px-4 pb-4">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                    Cancel
                </button>
                <button type="submit" class="btn btn-success">
                    Save Short
                </button>
            </div>

        </form>
    </div>
</div>
<!-- ================= EDIT MODAL ================= -->
<div class="modal fade" id="editShortModal">
    <div class="modal-dialog modal-dialog-centered">
        <form id="editShortForm"
              class="modal-content border-0 shadow-lg rounded-4">
            @csrf

            <!-- HEADER -->
            <div class="modal-header border-0 px-4 pt-4">
                <h5 class="modal-title fw-semibold">✏️ Edit Short</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- BODY -->
            <div class="modal-body px-4 pb-3">

                <input type="hidden" id="edit_id">

                <!-- TITLE -->
                <div class="mb-3">
                    <label class="form-label">Title</label>
                    <input type="text" name="title" id="edit_title"
                           class="form-control">
                </div>

                <!-- URL -->
                <div class="mb-3">
                    <label class="form-label">YouTube Shorts URL</label>
                    <input type="text" name="youtube_url" id="edit_url"
                           class="form-control">
                </div>

                <!-- PREVIEW -->
                <div class="mb-3 text-center">
                    <iframe id="editShortPreview"
                            style="width:100%; height:220px; border-radius:10px;"></iframe>
                </div>

                <!-- STATUS -->
                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" id="edit_status"
                            class="form-select">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>

            </div>

            <!-- FOOTER -->
            <div class="modal-footer border-0 px-4 pb-4">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                    Cancel
                </button>
                <button type="submit" class="btn btn-primary">
                    Update Short
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function convertShort(url){
    return url.replace("shorts/", "embed/");
}

// ADD PREVIEW
$('#shortUrl').on('input', function(){

    let embed = convertToEmbed($(this).val());

    if(embed){
        $('#shortPreview').attr('src', embed).show();
    }else{
        $('#shortPreview').hide();
    }
});

// EDIT PREVIEW
$('#edit_url').on('input', function(){
    let embed = convertToEmbed($(this).val());
    $('#editShortPreview').attr('src', embed);
});
// DATATABLE
let table = $('#shortsTable').DataTable({
    processing:true,
    serverSide:true,
    ajax:"{{ route('shorts.page') }}",
    columns:[
        { data: 'DT_RowIndex', orderable:false, searchable:false },
        {data:'video'},
        {data:'status'},
        {data:'action'}
    ]
});


// PREVIEW ADD
// $('#shortUrl').on('input',function(){
//     $('#shortPreview')
//         .attr('src',convertShort($(this).val()))
//         .show();
// });


// ADD
$('#shortForm').submit(function(e){
    e.preventDefault();

    $.post("{{ route('shorts.store') }}", $(this).serialize(), function(){
        $('#addShortModal').modal('hide');
        table.ajax.reload();
    });
});


// EDIT CLICK
$(document).on('click','.editBtn',function(){

    let url = $(this).data('url');

    $('#edit_title').val($(this).data('title'));
    $('#edit_url').val(url);
    $('#edit_status').val($(this).data('status'));

    $('#editShortPreview').attr('src', convertShort(url));

    $('#editShortForm').attr('action', $(this).data('update'));

    $('#editShortModal').modal('show');
});


// UPDATE
$('#editShortForm').submit(function(e){
    e.preventDefault();

    $.post($(this).attr('action'), $(this).serialize(), function(){
        $('#editShortModal').modal('hide');
        table.ajax.reload();
    });
});


// DELETE
$(document).on('click','.deleteBtn',function(){

    let id = $(this).data('id');

    $.post("{{ route('shorts.destroy',':id') }}".replace(':id',id),{
        _token:"{{ csrf_token() }}",
        _method:"DELETE"
    },function(){
        table.ajax.reload();
    });

});
function convertToEmbed(url){

    let videoId = '';

    if(!url) return '';

    // shorts
    if(url.includes("shorts/")){
        videoId = url.split("shorts/")[1];
    }
    // watch
    else if(url.includes("watch?v=")){
        videoId = url.split("watch?v=")[1];
    }
    // youtu.be
    else if(url.includes("youtu.be/")){
        videoId = url.split("youtu.be/")[1];
    }

    if(videoId.includes("?")){
        videoId = videoId.split("?")[0];
    }

    return videoId ? "https://www.youtube.com/embed/" + videoId : '';
}
</script>
@endpush
