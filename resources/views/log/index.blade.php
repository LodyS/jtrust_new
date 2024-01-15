@extends('tema.app')
@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="card border-white" style="width: 100rem;">
    <div class="card-body">

        <div class="w-sm-100 mr-auto">
            <h4 class="mb-0">Log Histori

            </h4>
        </div>

        <div style="height:10px"></div>

        @include('flash-message')
        <table class="table" style="width:100%" id="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Keterangan</th>
                    <th>Bagian</th>
                    <th>Tanggal</th>
                </tr>
            </thead>

        </table>
    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
$(document).ready( function () {

    $('#table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ url('logs') }}",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' , orderable: false, searchable: false},
            { data: 'keterangan', name: 'keterangan'},
            { data: 'bagian', name: 'bagian' },
            { data: 'created_at', name: 'created_at'},
        ],
        order: [[0, 'asc']]
    });
});
</script>
@endpush