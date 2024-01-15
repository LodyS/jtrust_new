<!DOCTYPE html>
@extends('tema.app')
@section('content')

<div class="card border-white" style="width: 100rem;">
    <div class="card-body">

        <div class="card border-white" >
            <div class="card-body">
                <h5 align="center">DIREKSI & KOMISARIS BPR - {{ strtoupper(\App\Models\InformasiPokokBprPelapor::namaBpr($id)->nama_bpr) }}</h5>
                <form action="{{ ($aksi == 'Create') ? route('anggota-direksi-komisaris.store') : route('anggota-direksi-komisaris.update', [$dataa->id]) }}" method="POST" enctype="multipart/form-data" name="form">@csrf

                @if($aksi == 'Update')
                    @method('PUT')
                @endif

                <div style="height:30px"></div>
                @include('flash-message')
                @include('error-message')

                @if($aksi == 'Create')
                    @include('list-menu-edit-bpr')
                @endif
            </div>
        </div> 

        <div style="height:10px"></div>

        <div class="card border-white">
			<div class="card-body">

                <input type="hidden" name="sandi_bpr" value="{{ $id }}">
                <input type="hidden" name="id_bpr" value="{{ $id_bpr ?? '' }}">
                <input type="hidden" name="id" value="{{ $dataa->id ?? '' }}">
                <input type="hidden" name="aksi" value="{{ $aksi }}">
                <input type="hidden" name="tabel" value="form_002">
                <input type="hidden" name="bagian" value="Master BPR">

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="control-label">Nama</label>
                            <input type="text" class="form-control" name="nama" value="{{ $dataa->nama ?? '' }}" required>
                        </div>
                    </div><!-- Col -->

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="control-label">Jabatan</label>
                            <input type="text" class="form-control" name="jabatan" value="{{ $dataa->jabatan ?? '' }}" required>
                        </div>
                    </div><!-- Col -->
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="control-label">Foto</label>
                            <div style="30px"></div>
                            @if($aksi == 'Update')
                                @if($dataa->status_foto == 'Y')
                                    <img src="{{ url('protected/storage/manajemen_perusahaan/'.$dataa->foto) }}" width="200"/>
                                @else
                                    <img src="{{ url('storage/manajemen-perusahaan/'.$dataa->foto) }}" width="200"/>
                                @endif
                            @endif
                            
                            <input type="file" class="form-control" name="foto" onchange="readURL(this);" id="foto">

                            <img id="modal-preview" src="https://via.placeholder.com/150" alt="Preview" class="form-group hidden" width="100" height="100">
                        </div>
                    </div><!-- Col -->
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="control-label">Pendidikan</label>
                            <textarea class="form-control" name="pendidikan"  rows="6">{{ $dataa->pendidikan ?? '' }}</textarea>
                        </div>
                    </div><!-- Col -->
                
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="control-label">Pengalaman Kerja</label>
                            <textarea class="form-control" name="pengalaman_kerja"  rows="6">{{ $dataa->pengalaman_kerja ?? '' }}</textarea>
                        </div>
                    </div><!-- Col -->
                </div>

                <button type="submit" class="btn btn-primary" style="position: relative; left:1%">Save</button>
            </div>
        </div>

        <div style="height:10px"></div>

        @if($aksi == 'Create')
            <div class="card border-white">
                <div class="card-body">
                    <div style="height:30px"></div>
                    <h5 style="text-align:center">DAFTAR DIREKSI BPR </h5>
                    <div style="height:30px"></div>

                    <table class="table table-hover" id="table" width="100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Foto</th>
                                <th>Nama</th>
                                <th>Jabatan</th>
                                <th>Keterangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        @endif
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
    },500);

    return false;
}

$("form[name='form']").validate({
    submitHandler: function(form) {
        form.submit();
    }
});

$('#table').DataTable({
    processing: true,
    serverSide: true,
    pageLength: 20,
    ajax: "{{ url('anggota-direksi-komisaris', $id) }}",
    columns: [
        { data: 'DT_RowIndex', name: 'DT_RowIndex' , orderable: false, searchable: false},
        { data:'foto', name:'foto'},
        { data: 'nama', name:'nama'},
        { data: 'jabatan', name:'jabatan'},
        { data: 'keterangan', name:'keterangan'},
        { data: 'action', name: 'action'},

    ],
    order: [[0, 'asc']]
});

</script>
@endpush
