@extends('tema.app')
@section('content')

<div class="card border-white" style="width: 100rem;">
    <div class="card-body">
        <form action="{{ url('save-upload-document') }}" method="POST" enctype="multipart/form-data">@csrf

            <input type="hidden" name="sandi_bpr" value="{{ $sandi_bpr ?? ''  }}">
            
            <div class="card border-white">
                <div class="card-body">
                    <h5 align="center">DOKUMEN - {{ strtoupper(\App\Models\InformasiPokokBprPelapor::namaBpr($sandi_bpr)->nama_bpr) }} </h5>
            
                    @if (Auth::user()->jabatan_user->kode == 'account_officer')
                        @include('flash-message')
               
                        <div style="height:30px"></div>
                        <table class="table table" id="tambah_foto">
                                
                            <tr>
                                <th>File</th>
                                <th>Nama Dokumen</th>
                                <th style="text-align:right"><button class="btn btn-danger btn-xs" type="button" id="add">Tambah</button></th>
                            </tr>
                        </table>

                        <div style="height:10px"></div>
                        
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div> 
                </div>
            @endif
        </form>

        <div class="card border-white">
            <div class="card-body">
                <table class="table" style="width:100%" id="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Dokumen</th>
                            <th>Download</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
	</div>
</div>
@endsection

@push('scripts')
<script>

function test(element) {
    var newTab = window.open();
        setTimeout(function(){newTab.document.body.innerHTML = element.innerHTML;
    },500);

    return false;
}

$(document).ready( function () {

    $('#table').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 20,
        ajax: "{{ url('upload-documents-bpr', $sandi_bpr) }}",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' , orderable: false, searchable: false},
            { data: 'file', name: 'file'},
            { data: 'download', name: 'download' },
          
        ],
        order: [[0, 'asc']]
    });
});

var i = 0;

$("#add").on("click", function() {
    var row = $("<tr>");
    var cols = "";
        cols += '<td><input type="file" name="file[]" class="form-control"></td>';
        cols += '<td><input type="text" name="keterangan[]" class="form-control"></td>'
        cols += '<td style="text-align:right"><button type="button" class="btn btn-danger adRow ibtnDel" style="width:25%;">x</button></a></td>';

        row.append(cols);
        $("#tambah_foto").append(row);
    i++;
});

$("#tambah_foto").on("click", ".ibtnDel", function(_event) {
    $(this).closest("tr").remove();
    i -= 1
});

</script>
@endpush
