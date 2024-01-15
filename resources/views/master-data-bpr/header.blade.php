@extends('tema.app')
@section('content')

<div class="card border-white" style="width: 100rem;">
    <div class="card-body">

        <p style="text-align:left;">
            <h4 class="mb-0">Header Laporan</h4>
        </p>

        <div style="height:30px"></div>
        <body>
            @include('flash-message')
            <table class="display table dataTable table-striped table-bordered" style="width:100%" id="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Jenis Laporan</th>
                        <th>Periode Waktu</th>
                        <th>Tahun</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </body>
    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
$(document).ready( function () {

    $('#table').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 20,
        //scrollX: true,
        ajax: "{{ url('header', $sandi_bpr) }}",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' , orderable: false, searchable: false},
            { data: 'jenis_laporan', name: 'jenis_laporan'},
            { data: 'bulan', name:'bulan', searchable: true},
            { data: 'tahun', name: 'tahun'},
            { data: 'action', name: 'action', orderable: false},
        ],
        order: [[0, 'asc']]
    });
});
</script>
@endpush