@extends('tema.app')
@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="card border-white" style="width: 100rem;">
    <div class="card-body">
        <div class="sub-header mt-3 py-3 align-self-center d-sm-flex w-100 rounded">
            <div class="w-sm-100 mr-auto"><h4 class="mb-0">Product Category</h4></div>

            <span style="float:right;"><a href="{{ url('product-category-form') }}" class="btn btn-primary btn-sm" >Create</a></span>
        </div>
    </div>
</div>

<div class="card border-white" style="width: 100rem;">

    <div class="card-body">

        @include('flash-message')

        <div style="height:10px"></div>


        <table class="display table dataTable table-striped table-bordered"  id="table">
            <thead>
                <tr>
                    <th>NO</th>
                    <th>Product ID</th>
                    <th>Code</th>
                    <th>Title</th>
                    <th>Maksimal RPC Persentase</th>
                    <th>Aksi</th>
                </tr>
            </thead>
        </table>

    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
$(document).ready( function () {

    $('#tambah').on("click",function() {
        $('#modal-create').modal('show');
    });

    $('#table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ url('product-category-data') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex' , orderable: false, searchable: false},
                { data: 'product_title', name: 'product_title' },
                { data: 'code', name: 'credit.code' },
                { data: 'title', name: 'title'},
                { data: 'maksimal_rpc_persentase', name: 'maksimal_rpc_persentase'},
                { data: 'action', name: 'action', orderable: false},
            ],
        order: [[0, 'asc']]
    });
});

function hapus(id){
    if (confirm("Apakah Anda yakin akan hapus data ini ?") == true) {
    var id = id;
    $.ajax({
        type:"POST",
        url: "{{ url('product-category-delete') }}",
        data: {
                id: id,
                _token : "{{ csrf_token() }}",
            },

        dataType: 'json',
        success: function(res){
            var oTable = $('#table').dataTable();
                oTable.fnDraw(false);
            }
        });
    }
}
</script>
@endpush
