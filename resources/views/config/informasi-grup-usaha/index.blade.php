@extends('tema.app')
@section('content')

<div class="card border-white" style="width: 100rem;">
    <div class="card-body">
        <div class="sub-header mt-3 py-3 align-self-center d-sm-flex w-100 rounded">
            <div class="w-sm-100 mr-auto"><h4 class="mb-0">Informasi Grup Usaha</h4></div>

            <span style="float:right;"><a class="btn btn-primary btn-sm" href="{{ route('informasi-grup-usaha.create')}}" align="right">Create</a></span>
        </div>
    </div>

    <div class="card-body">

        @include('flash-message')

        <div style="height:10px"></div>

        <table class="table" style="width:100%" id="table">
            <thead>
                <tr>
                    <th>NO</th>
                    <th>Nama Perusahaan</th>
                    <th>Bidang Usaha</th>
                    <th>Tahun Pendirian</th>
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

    $('#table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('informasi-grup-usaha.index') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex' , orderable: false, searchable: false},
                { data: 'nama_perusahaan', name: 'nama_perusahaan' },
                { data: 'bidang_usaha', name: 'bidang_usaha' },
                { data: 'tahun_pendirian', name: 'tahun_pendirian' },
                { data: 'action', name: 'action', orderable: false },
            ],
        order: [[0, 'asc']]
    });
});
</script>
@endpush
