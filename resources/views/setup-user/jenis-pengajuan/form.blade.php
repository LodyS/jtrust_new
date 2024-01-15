@extends('tema.app')
@section('content')

<div class="card border-white" style="width: 100rem;">
    <div class="card-body">
        <h4 class="mb-0">Form Jenis Pengajuan</h4>


        <div style="height:40px" align="centre"></div>
            <form action="{{ (empty($jenisPengajuan)) ? route('jenis-pengajuan.store') : route('jenis-pengajuan.update', [$jenisPengajuan->id]) }}" method="POST">@csrf

            @if(!empty($jenisPengajuan)) @method('PUT') @endif
            <input type="hidden" value="{{ $jenisPengajuan->id ?? '' }}" class="form-control" name="id" readonly>
            <input type="hidden" value="jenis_pengajuan" name="tabel">
            <input type="hidden" value="{{ (empty($jenisPengajuan)) ? 'Create' : 'Update' }}" name="aksi">

            @include('flash-message')

            <div class="form-group row">
		        <label class="col-md-3">Kode Pengajuan</label>
			        <div class="col-md-7">
                    <input type="text" class="form-control" name="kode_pengajuan" value="{{ $jenisPengajuan->kode_pengajuan ?? '' }}" required>
		        </div>
	        </div>

            <div class="form-group row">
		        <label class="col-md-3">Nama Pengajuan</label>
			        <div class="col-md-7">
                    <input type="text" class="form-control" name="nama_pengajuan" value="{{ $jenisPengajuan->nama_pengajuan ?? '' }}" required>
		        </div>
	        </div>

            <div class="form-group row">
		        <label class="col-md-3">Publish</label>
			    <div class="col-md-7">
                    <select class="form-control" name="publish" required>
                        <option value="">Silahkan Pilih</option>
                        <option value="Ya" {{ (isset($jenisPengajuan->publish) == 'Ya') ? 'selected' : '' }}>Ya</option>
                        <option value="Tidak" {{ (isset($jenisPengajuan->publish) == 'Tidak') ? 'selected' : '' }}>Tidak</option>
                    </select>
                </div>
	        </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="{{ url('jabatan') }}" class="btn btn-danger">Cancel</a>
            </div>

        </form>
    </div>
</div>
@endsection
