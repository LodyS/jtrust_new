@extends('tema.app')
@section('content')

<div class="card border-white" style="width: 100rem;">
    <div class="card-body">
        <h4 class="modal-title">Form Informasi Grup Usaha</h4>
        <div style="height:40px" align="centre"></div>
        <form action="{{ (empty($informasiGrupUsaha)) ? route('informasi-grup-usaha.store') : route('informasi-grup-usaha.update', [$informasiGrupUsaha->id]) }}" method="POST">@csrf

            @if(!empty($informasiGrupUsaha)) @method('PUT') @endif
            <input type="hidden" value="{{ $informasiGrupUsaha->id ?? '' }}" name="id">
            <input type="hidden" name="aksi" value="{{ (empty($informasiGrupUsaha)) ? 'Create' : 'Update' }}">
            <input type="hidden" value="informasi_grup_usaha" name="tabel">

            @include('flash-message')
            @include('error-message')

            <div class="form-group row">
		        <label class="col-md-3">Nama Perusahaan</label>
			        <div class="col-md-7">
                    <input type="text" class="form-control" name="nama_perusahaan" value="{{ $informasiGrupUsaha->nama_perusahaan ?? ''}}" required>
                </div>
	        </div>

            <div class="form-group row">
		        <label class="col-md-3">Bidang Usaha</label>
			        <div class="col-md-7">
                    <input type="text" class="form-control" name="bidang_usaha" value="{{ $informasiGrupUsaha->bidang_usaha ?? '' }}" required>
                </div>
	        </div>

            <div class="form-group row">
		        <label class="col-md-3">Tahun Pendirian</label>
			        <div class="col-md-7">
                    <input type="text" class="form-control" name="tahun_pendirian" value="{{ $informasiGrupUsaha->tahun_pendirian ?? '' }}"
                    onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" maxlength="4" pattern = "^[0-9]{4}$"
                    required>
                </div>
	        </div>

            <div>
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="{{ url('komponen-tks') }}" class="btn btn-danger">Cancel</a>
            </div>

        </form>
    </div>
</div>
@endsection

