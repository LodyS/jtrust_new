@extends('tema.app')
@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="card border-white" style="width: 100rem;">
    <div class="card-body">
        <div class="sub-header mt-3 py-3 align-self-center d-sm-flex w-100 rounded">
            <div class="w-sm-100 mr-auto"><h4 class="mb-0">Komponen TKS</h4></div>

            <span style="float:right;"><a href="{{ route('komponen-tks.create') }}" class="btn btn-primary btn-sm"  align="right">Create</a></span>
        </div>
    </div>

    <div class="card-body">

        @include('flash-message')

        <div style="height:10px"></div>

        <div style="overflow-x:auto;">
            <table class="table"  id="table">
                <thead>
                    <tr>
                        <th>NO</th>
                        <th>Komponen</th>
                        <th>Sub Komponen</th>
                        <th>Bobot</th>
                        <th>Minimum Ratio</th>
                        <th>Perubahan Ratio</th>
                        <th>Nilai Minimum Kredit</th>
                        <th>Perubahan Nilai Kredit</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
@endsection


@push('scripts')
<script type="text/javascript">
$(document).ready( function () {

    $('#table').DataTable({
        processing: true,
        serverSide: true,
        dom: 'Bfrtip',
        buttons: ['csv', 'excel', 'pdf', 'print'],
        ajax: "{{ route('komponen-tks.index') }}",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' , orderable: false, searchable: false},
            { data: 'komponen', name: 'komponen' },
            { data: 'sub_komponen', name: 'sub_komponen' },
            { data: 'bobot', name: 'bobot' },
            { data : 'minimum_ratio', name : 'minimum_ratio' },
            { data : 'perubahan_ratio', name : 'perubahan_ratio' },
            { data: 'nilai_minimum_kredit', name: 'nilai_minimum_kredit'},
            { data: 'perubahan_nilai_kredit', name: 'perubahan_nilai_kredit'},
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
