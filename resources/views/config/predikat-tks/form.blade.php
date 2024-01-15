@extends('tema.app')
@section('content')

<div class="card border-white" style="width: 100rem;">
    <div class="card-body">
        <h4>Form Predikat TKS</h4>
        <div style="height:20px" align="centre"></div>
        <form action="{{ (!empty($predikat_tk)) ? route('predikat-tks.update', [$predikat_tk->id]) : route('predikat-tks.store') }}" method="POST">@csrf

            <input type="hidden" value="{{ $predikat_tk->id ?? '' }}" class="form-control" name="id">
            <input type="hidden" value="{{ (empty($predikat_tk)) ? 'Create' : 'Update' }}" name="aksi">
            <input type="hidden" value="predikat_tks" name="tabel">

            @if(!empty($predikat_tk)) @method('PUT') @endif
            @include('flash-message')
            @include('error-message')

            <div class="form-group row">
		        <label class="col-md-3">Kategori</label>
			    <div class="col-md-7">
                    <select class="form-control" name="predikat" required>
                        <option value="">Pilih</option>
                        <option value="Sehat" {{ (!empty($predikat_tk->predikat) == 'Sehat') ? 'selected' : '' }}>Sehat</option>
                        <option value="Cukup Sehat" {{ (!empty($predikat_tk->predikat) == 'Cukup Sehat') ? 'selected' : '' }}>Cukup Sehat</option>
                        <option value="Kurang Sehat" {{ (!empty($predikat_tk->predikat) == 'Kurang Sehat') ? 'selected' : '' }}>Kurang Sehat</option>
                        <option value="Tidak Sehat" {{ (!empty($predikat_tk->predikat) == 'Tidak Sehat') ? 'selected': '' }}>Tidak Sehat</option> 
                    </select>
                </div>
	        </div>

            <div class="form-group row">
		        <label class="col-md-3">Nilai Minimal</label>
			    <div class="col-md-7">
                    <input type="text" class="form-control" name="nilai_min" value="{{ $predikat_tk->nilai_min ?? '' }}" required>
                </div>
	        </div>

            <div class="form-group row">
		        <label class="col-md-3">Nilai Maksimal</label>
			    <div class="col-md-7">
                    <input type="text" class="form-control" name="nilai_max" value="{{ $predikat_tk->nilai_max ?? '' }}" required>
                </div>
	        </div>

            <div>
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="{{ route('predikat-tks.index') }}" class="btn btn-danger">Cancel</a>
            </div>

        </form>
    </div>
</div>
@endsection
