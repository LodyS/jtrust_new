@extends('tema.app')
@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="card border-white" style="width: 100rem;">
    <div class="card-body">

        <div class="w-sm-100 mr-auto">
            <h4 class="mb-0">Setting Flow
                <span style="float:right;">
                <a href="{{ route('setting-flow.create')}}" class="btn btn-primary btn-sm" align="right">Create</a>
                </span>
            </h4>
        </div>

        <div style="height:10px"></div>

        @include('flash-message')
        <table class="table" style="width:100%" id="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Divisi</th>
                    <th>Jabatan</th>
                    <th>Level</th>
                    <th>Action</th>
                </tr>
            </thead>

        </table>
    </div>
</div>
@endsection

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-confirmation/1.0.5/bootstrap-confirmation.min.js"></script>


<script type="text/javascript">
$(document).ready( function () {

    $('#table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ url('setting-flow') }}",
        //scrollX: true,
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' , orderable: false, searchable: false},
            { data: 'divisi', name: 'divisi' },
            { data: 'jabatan', name: 'jabatan' },
            { data: 'level', name: 'level'},
            { data: 'action', name: 'action', orderable: false},
        ],
        order: [[0, 'asc']]
    });
});


function destroy(id){
    if (confirm("Apakah Anda yakin hapus user ini ?") == true) {
    var id = id;

    $.ajax({
        type:"POST",
        url: "{{ url('delete-setting-flow') }}",
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
