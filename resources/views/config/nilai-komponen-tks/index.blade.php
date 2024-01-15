@extends('tema.app')
@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="card border-white" style="width: 100rem;">
    <div class="card-body">
        <div class="sub-header mt-3 py-3 align-self-center d-sm-flex w-100 rounded">
            <div class="w-sm-100 mr-auto"><h4 class="mb-0">Nilai Komponen TKS</h4></div>

            <span style="float:right;"><a href="{{ route('nilai-komponen-tks.create') }}" class="btn btn-primary btn-sm" id="tambah" align="right">Create</a></span>
        </div>
    </div>


    <div class="card-body">

        @include('flash-message')

        <div style="height:10px"></div>

        <table class="table" style="width:100%" id="table">
            <thead>
                <tr>
                    <th>NO</th>
                    <th>Sub Komponen</th>
                    <th>Nilai Minimum</th>
                    <th>Nilai Maksimal</th>
                    <th>Kategori</th>
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
        pageLength: 10,
        dom: 'Bfrtip',
        buttons: ['csv', 'excel', 'pdf', 'print'],
        ajax: "{{ route('nilai-komponen-tks.index') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex' , orderable: false, searchable: false},
                { data: 'sub_komponen', name: 'komponen_tks.sub_komponen' },
                { data: 'nilai_min', name: 'nilai_min', searchable: false },
                { data: 'nilai_max', name: 'nilai_max', searchable: false},
                { data: 'kategori', name: 'kategori', searchable: false},
                { data: 'action', name: 'action', orderable: false},
            ],
        order: [[0, 'asc']]
    });

    $('.buttons-excel, .buttons-csv').each(function() {
        $(this).removeClass('btn-default').addClass('btn-success')
    })

    $('.buttons-pdf').each(function() {
        $(this).removeClass('btn-default').addClass('btn-danger')
    })

    $('.buttons-print').each(function() {
        $(this).removeClass('btn-default').addClass('btn-primary')
    })
});
</script>
@endpush
