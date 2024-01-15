@extends('tema.app')
@section('content')

<div class="card border-white" style="width: 100rem;">
    <div class="card-body">
        <h4>Form Manajemen Pertanyaan</h4>
        <div style="height:40px" align="centre"></div>

        <form action="{{ (empty($manajemenPertanyaan)) ? route('manajemen-pertanyaan.store') : route('manajemen-pertanyaan.update', [$manajemenPertanyaan->id]) }}" method="POST">@csrf
        <input type="hidden" name="id" value="{{ $manajemenPertanyaan->id ?? '' }}">
        <input type="hidden" name="aksi" value="{{ (empty($manajemenPertanyaan)) ? 'Create' : 'Update' }}">
        <input type="hidden" name="tabel" value="manajemen_pertanyaan">

        @if(!empty($manajemenPertanyaan)) @method('PUT') @endif
        @include('flash-message')
        @include('error-message')

        <div class="form-group row">
		    <label class="col-md-3">Kelompok Pertanyaan</label>
			    <div class="col-md-7">
                <input type="text" class="form-control" name="kelompok_pertanyaan" value="{{ $manajemenPertanyaan->kelompok_pertanyaan ?? '' }}" required>
            </div>
	    </div>

        <div class="form-group row">
		    <label class="col-md-3">Sub Kelompok Pertanyaan</label>
			    <div class="col-md-7">
                <input type="text" class="form-control" name="sub_kelompok_pertanyaan" value="{{ $manajemenPertanyaan->sub_kelompok_pertanyaan ?? '' }}" required>
            </div>
	    </div>

        <div class="form-group row">
		    <label class="col-md-3">Detail Pertanyaan</label>
			    <div class="col-md-7">
                <textarea class="form-control" name="detail_pertanyaan" required>{{ $manajemenPertanyaan->detail_pertanyaan ?? '' }}</textarea>
            </div>
	    </div>

        <div class="form-group row">
		    <label class="col-md-3">Range Skor Minimal</label>
			    <div class="col-md-7">
                <input type="number" class="form-control" name="range_skor_minimal" value="{{ $manajemenPertanyaan->range_skor_minimal ?? '' }}" required>
            </div>
	    </div>

        <div class="form-group row">
		    <label class="col-md-3">Range Skor Maksimal</label>
			    <div class="col-md-7">
                <input type="number" class="form-control" name="range_skor_maksimal" value="{{ $manajemenPertanyaan->range_skor_maksimal ?? '' }}" required>
            </div>
	    </div>

        <div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>

        </form>
    </div>
</div>
@endsection
