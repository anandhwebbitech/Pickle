@extends('admin.layouts.app')

@section('content')

<link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>
    body{
        background:#f4f6f9;
    }

    .card-box{
        background:#fff;
        border-radius:20px;
        padding:20px;
        box-shadow:0 10px 30px rgba(0,0,0,.05);
    }

    .add-btn{
        background:linear-gradient(135deg,#16a34a,#22c55e);
        color:#fff !important;
        border:none;
        border-radius:50px;
        padding:10px 22px;
        font-weight:600;
    }

    .modal-content{
        border:none;
        border-radius:20px;
        overflow:hidden;
    }

    .modal-header{
        background:linear-gradient(135deg,#16a34a,#22c55e);
        color:#fff;
        border:none;
    }

    .form-control,
    .form-select{
        border-radius:12px;
        font-size:14px;
    }

    .combo-product-row{
        background:#f8fafc;
        padding:12px;
        border-radius:14px;
        margin-bottom:10px;
    }

    .table img{
        width:60px;
        height:60px;
        object-fit:cover;
        border-radius:10px;
    }
</style>

<div class="container mt-4">

    <div class="card-box">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0">Combo Products</h4>

            <button class="btn add-btn"
                    data-bs-toggle="modal"
                    data-bs-target="#addComboModal">
                <i class="fa fa-plus"></i> Add Combo
            </button>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered align-middle" id="comboTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Original Price</th>
                        <th>Offer Price</th>
                        <th>Discount</th>
                        <th>Status</th>
                        <th width="140">Action</th>
                    </tr>
                </thead>
            </table>
        </div>

    </div>

</div>

<!-- ================= ADD MODAL ================= -->

<div class="modal fade" id="addComboModal" tabindex="-1">
    <div class="modal-dialog modal-xl">

        <form id="comboForm" enctype="multipart/form-data">

            @csrf

            <div class="modal-content">

                <div class="modal-header">
                    <h5>Add Combo Product</h5>

                    <button type="button"
                            class="btn-close btn-close-white"
                            data-bs-dismiss="modal">
                    </button>
                </div>

                <div class="modal-body">

                    <div class="row g-3">

                        <div class="col-md-4">
                            <label>Name</label>

                            <input type="text"
                                   name="name"
                                   class="form-control">
                        </div>

                        <div class="col-md-4">
                            <label>Offer Price</label>

                            <input type="number"
                                   step="0.01"
                                   name="offer_price"
                                   class="form-control">
                        </div>

                        <div class="col-md-4">
                            <label>Stock</label>

                            <input type="number"
                                   name="stock"
                                   class="form-control">
                        </div>

                        <div class="col-md-4">
                            <label>Combo Image</label>

                            <input type="file"
                                   name="image"
                                   class="form-control">
                        </div>

                        <div class="col-md-4">
                            <label>Status</label>

                            <select name="status" class="form-select">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>

                        <div class="col-md-12">
                            <label>Description</label>

                            <textarea name="description"
                                      class="form-control"
                                      rows="3"></textarea>
                        </div>

                    </div>

                    <hr>

                    <div class="d-flex justify-content-between align-items-center mb-3">

                        <h5 class="mb-0">Combo Items</h5>

                        <button type="button"
                                class="btn btn-success btn-sm"
                                id="addComboItem">
                            <i class="fa fa-plus"></i> Add Product
                        </button>

                    </div>

                    <div id="comboItemsWrapper">

                        <div class="row combo-product-row">

                            <div class="col-md-5">
                                <label>Product</label>

                                <select name="products[0][product_id]"
                                        class="form-select">

                                    <option value="">Select Product</option>

                                    @foreach($products as $product)

                                        <option value="{{ $product->id }}">
                                            {{ $product->name }}
                                        </option>

                                    @endforeach

                                </select>
                            </div>

                            <div class="col-md-3">
                                <label>Weight</label>

                                <input type="text"
                                       name="products[0][weight]"
                                       class="form-control"
                                       placeholder="500g">
                            </div>

                            <div class="col-md-2">
                                <label>Qty</label>

                                <input type="number"
                                       name="products[0][qty]"
                                       class="form-control"
                                       value="1">
                            </div>

                            <div class="col-md-2 d-flex align-items-end">

                                <button type="button"
                                        class="btn btn-danger removeComboItem w-100">
                                    <i class="fa fa-trash"></i>
                                </button>

                            </div>

                        </div>

                    </div>

                </div>

                <div class="modal-footer">

                    <button type="submit"
                            class="btn btn-success">
                        Save Combo
                    </button>

                </div>

            </div>

        </form>

    </div>
</div>

@endsection

@push('scripts')

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

let comboIndex = 1;

/* ================= ADD COMBO ITEM ================= */

$('#addComboItem').click(function(){

    let html = `
    
    <div class="row combo-product-row">

        <div class="col-md-5">

            <label>Product</label>

            <select name="products[${comboIndex}][product_id]"
                    class="form-select">

                <option value="">Select Product</option>

                @foreach($products as $product)

                    <option value="{{ $product->id }}">
                        {{ $product->name }}
                    </option>

                @endforeach

            </select>

        </div>

        <div class="col-md-3">

            <label>Weight</label>

            <input type="text"
                   name="products[${comboIndex}][weight]"
                   class="form-control"
                   placeholder="250g">

        </div>

        <div class="col-md-2">

            <label>Qty</label>

            <input type="number"
                   name="products[${comboIndex}][qty]"
                   class="form-control"
                   value="1">

        </div>

        <div class="col-md-2 d-flex align-items-end">

            <button type="button"
                    class="btn btn-danger removeComboItem w-100">

                <i class="fa fa-trash"></i>

            </button>

        </div>

    </div>
    `;

    $('#comboItemsWrapper').append(html);

    comboIndex++;

});

/* ================= REMOVE ITEM ================= */

$(document).on('click','.removeComboItem',function(){

    $(this).closest('.combo-product-row').remove();

});

/* ================= DATATABLE ================= */

$('#comboTable').DataTable({

    processing:true,
    serverSide:true,

    ajax:"{{ route('comboproductpage') }}",

    columns:[

        {
            data:'id',
            name:'id'
        },

        {
            data:'image',
            name:'image',
            orderable:false,
            searchable:false
        },

        {
            data:'name',
            name:'name'
        },

        {
            data:'original_price',
            name:'original_price'
        },

        {
            data:'offer_price',
            name:'offer_price'
        },

        {
            data:'discount',
            name:'discount'
        },

        {
            data:'status',
            name:'status',
            orderable:false,
            searchable:false
        },

        {
            data:'action',
            name:'action',
            orderable:false,
            searchable:false
        }

    ]

});

/* ================= SAVE COMBO ================= */

$('#comboForm').submit(function(e){

    e.preventDefault();

    let formData = new FormData(this);

    $.ajax({

        url:"{{ route('combo-products.store') }}",

        type:"POST",

        data:formData,

        processData:false,

        contentType:false,

        beforeSend:function(){

            Swal.fire({
                title:'Saving...',
                allowOutsideClick:false,
                didOpen:() => {
                    Swal.showLoading();
                }
            });

        },

        success:function(res){

            Swal.fire({
                icon:'success',
                title:'Success',
                text:res.message,
                timer:1500,
                showConfirmButton:false
            });

            $('#addComboModal').modal('hide');

            $('#comboForm')[0].reset();

            $('#comboTable').DataTable().ajax.reload();

        },

        error:function(xhr){

            let errors = xhr.responseJSON.errors;

            let errorMsg = '';

            $.each(errors,function(key,val){

                errorMsg += val[0] + '<br>';

            });

            Swal.fire({
                icon:'error',
                title:'Validation Error',
                html:errorMsg
            });

        }

    });

});

</script>

@endpush