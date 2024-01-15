@extends('tema.app')
@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="card border-white" style="width: 100rem;">
    <div class="card-body">
        <div class="sub-header mt-3 py-3 align-self-center d-sm-flex w-100 rounded">
            <div class="w-sm-100 mr-auto"><h4 class="mb-0">Predikat TKS</h4></div>

            <span style="float:right;"><a class="btn btn-primary btn-sm" href="{{ route('predikat-tks.create')}}" align="right">Create</a></span>
        </div>
    </div>

    <div class="card-body">

        @include('flash-message')

        <div style="height:10px"></div>

        <table class="table" style="width:100%"  id="table">
            <thead>
                <tr>
                    <th>NO</th>
                    <th>Predikat</th>
                    <th>Nilai Minimum</th>
                    <th>Nilai Maksimal</th>
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
        dom: 'Bfrtip',
        buttons: ['csv', 'excel', 'pdf', 'print'],
        ajax: "{{ route('predikat-tks.index') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex' , orderable: false, searchable: false},
                { data: 'predikat', name: 'predikat' },
                { data: 'nilai_min', name: 'nilai_min' },
                { data: 'nilai_max', name: 'nilai_max'},
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

function hapus(id)
{
    if (confirm("Apakah Anda yakin akan hapus Predikat TKS ini ?") == true) {
        var id = id;
        $.ajax({
            type:"POST",
            url: "{{ url('predikat-tks-delete') }}",
            data: {
                id: id,
                _token : "{{ csrf_token() }}",
                tabel : "predikat_tks",
                aksi : "Delete",
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
