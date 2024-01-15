@extends('tema.app')
@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="card border-white" style="width: 100rem;">
    <div class="card-body">

        <div class="w-sm-100 mr-auto">
            <h4 class="mb-0">REGION
                <span style="float:right;"><a href="{{ route('region.create') }}" class="btn btn-primary btn-sm">Create</a></span>
            </h4>
            <div style="height:10px"></div>
        </div>

        <div style="height:10px"></div>

        @include('flash-message')
        <table class="table" style="width:100%" id="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Region Code</th>
                    <th>Region Title</th>
                    <th>Aksi</th>
                </tr>
            <thead>
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
    ajax: "{{ url('region') }}",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' , orderable: false, searchable: false},
            { data: 'region_code', name: 'region_code'},
            { data: 'region_title', name: 'region_title' },
            { data: 'action', name: 'action', orderable: false},
        ],
        order: [[0, 'asc']]
    });
});
</script>
@endpush
