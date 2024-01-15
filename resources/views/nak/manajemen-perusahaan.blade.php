<!DOCTYPE html>
@extends('tema.app')
@section('content')

<div class="card border-white" style="width: 100rem;">
    <div class="card-body">
       
      
        <div class="card border-white">
			<div class="card-body">
                <h5 style="text-align:center">MANAJEMEN PERUSAHAAN - {{ strtoupper(\App\Models\InformasiPokokBprPelapor::namaBpr($data->sandi_bpr)->nama_bpr) ?? '' }}</h4>

                <div style="height:30px"></div>
                @include('flash-message')
                @include('error-message')
                @include('list-menu')
            </div>
        </div>

        <div style="height:10px"></div>

        <form action="{{ url('save-manajemen-perusahaan') }}" method="POST" enctype="multipart/form-data">@csrf
            <input type="hidden" name="sandi_bpr" value="{{ $data->sandi_bpr ?? ''  }}">
            <input type="hidden" name="loan_applicant_id" value="{{ $id }}">

            <input type="hidden" name="tabel" value="form_002">
            <input type="hidden" name="aksi" value="Create">
            <input type="hidden" name="bagian" value="Nak">

            @if (Auth::user()->jabatan_user->kode == 'account_officer' && $data->status_level_proses == 1)
                <div class="card border-white">
                    <div class="card-body">  
                        <div class="form-group">

                            <div style="height:10px"></div>

                            <table class="table table" id="tambah_foto">
                                <tr>
                                    <th>Form</th>
                                    <th style="text-align:right"><button class="btn btn-danger btn-xs" type="button" id="foto_add">Tambah</button></th>
                                </tr>
                            </table>
                        </div>

                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            @endif

            <div style="height:10px"></div>

            <div class="card border-white">
                <div class="card-body">  
                    <h6 align="center">DAFTAR MANAJEMEN PERUSAHAAN</h6>
                    <div style="height:40px"></div>

                    <table class="table table" id="table" width="100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Foto</th>
                                <th>Nama</th>
                                <th>Jabatan</th>
                                <th>Keterangan</th>
                                @if(Auth::user()->jabatan_user->kode == 'account_officer')
                                    <th>Aksi</th>
                                @endif
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </form>
	</div>
</div>
@endsection

@push('scripts')

<script>

function test(element)
{
    var newTab = window.open();
        setTimeout(function(){
            newTab.document.body.innerHTML = element.innerHTML;
        },
    500);

    return false;
}

$(document).ready(function(){
    // form dinamis
    var i = 0;

    $("#foto_add").on("click", function() {
        var row = $("<tr>");
        var cols = "";
            cols += '<td><label>Foto</label><input type="file" name="foto[]" class="form-control">';
            cols += '<label>Nama</label><input type="text" name="nama[]" class="form-control">';
            cols += '<label>Pendidikan</label><textarea class="form-control content" name="pendidikan[]" rows="10"></textarea>';
            cols += '<label>Pengalaman Kerja</label><textarea class="form-control content" name="pengalaman_kerja[]" rows="10"></textarea>';
            cols += '<label>Jabatan</label><textarea name="jabatan[]" class="form-control content" rows="10"></textarea></td>';
            cols += '<td><button type="button" class="btn btn-danger adRow ibtnDel" style="width:25%;">x</button></a></td>';

            row.append(cols);
            $("#tambah_foto").append(row);
        i++;
    });

    $("#tambah_foto").on("click", ".ibtnDel", function(_event) {
        $(this).closest("tr").remove();
        i -= 1
    });
});

$('#table').DataTable({
    processing: true,
    serverSide: true,
    pageLength: 20,
    scrollX: true,
    ajax: "{{ url('anggota-direksi-komisaris', $data->sandi_bpr) }}",
    columns: [
        { data: 'DT_RowIndex', name: 'DT_RowIndex' , orderable: false, searchable: false},
        { data:'foto', name:'foto'},
        { data: 'nama', name:'nama'},
        { data: 'jabatan', name:'jabatan'},
        { data: 'keterangan', name:'keterangan'},
        @if(Auth::user()->jabatan_user->kode == 'account_officer')
            { data: 'action', name: 'action'},
        @endif

    ],
    order: [[0, 'asc']]
});
function hapus(id)
{
    if (confirm("Are you sure want to delete this data ?") == true) {
    var id = id;
    $.ajax({
        type:"POST",
        url: "{{ url('destroy-direksi') }}",
        data: {
                id: id,
                _token : "{{ csrf_token() }}",
                tabel : "form_002",
                aksi : "Delete",
                bagian : "Master BPR",
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
