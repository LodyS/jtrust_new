@extends('tema.app')
@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="card border-white" style="width: 100rem;">
    <div class="card-body">

        <div class="w-sm-100 mr-auto">
            <h4 class="mb-0">List Users
                <span style="float:right;">
                <a href="{{ route('list-user.create')}}" class="btn btn-primary btn-sm" align="right">Create</a>
                </span>
            </h4>
        </div>

        <div style="height:30px"></div>

        @include('flash-message')
        <table class="table" style="width:100%" id="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Username</th>
                    <th>Position</th>
                    <th>Status</th>
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
        ajax: "{{ url('list-user') }}",
        //scrollX: true,
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' , orderable: false, searchable: false},
            { data: 'name', name: 'name'},
            { data: 'jabatan', name: 'jabatan' },
            { data: 'status', name: 'status' },
            { data: 'action', name: 'action', orderable: false},
        ],
        order: [[0, 'asc']]
    });
});

function block(id){
    if (confirm("Apakah Anda yakin block user ini ?") == true) {
    var id = id;
    var status = 'Block';
    $.ajax({
        type:"POST",
        url: "{{ url('update-status-user') }}",
        data: {
                id: id,
                status : status,
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

function openBlock(id){
    if (confirm("Apakah Anda yakin open block user ini ?") == true) {
    var id = id;
    var status = "Active";
    $.ajax({
        type:"POST",
        url: "{{ url('update-status-user') }}",
        data: {
                id: id,
                status : status,
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

function deactive(id){
    if (confirm("Apakah Anda yakin deactive user ini ?") == true) {
    var id = id;
    var status = "Deactive";
    $.ajax({
        type:"POST",
        url: "{{ url('update-status-user') }}",
        data: {
                id: id,
                status : status,
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

function destroy(id){
    if (confirm("Apakah Anda yakin hapus user ini ?") == true) {
    var id = id;

    $.ajax({
        type:"POST",
        url: "{{ url('delete-user') }}",
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
