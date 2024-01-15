@extends('tema.app')
@section('content')

<div class="card border-white" style="width: 100rem;">
    <div class="card-body">
        <h4 class="mb-0">Form COA</h4>

        <div style="height:20px" align="centre"></div>
        <form action="{{ ($aksi == 'Create') ? route('coa.store') : route('coa.update', [$data->id])   }}" method="POST">@csrf

            <input type="hidden" value="{{ $data->id ?? '' }}" name="id">
            <input type="hidden" value="coa" name="tabel">
            <input type="hidden" value="{{ $aksi }}" name="aksi">

            @if($aksi == 'Update') @method('PUT') @endif

            @include('error-message')

            <div class="form-group row">
		        <label class="col-md-3">Nama COA</label>
			        <div class="col-md-7">
                    <input type="text" class="form-control" name="nama_coa" value="{{ $data->nama_coa ?? '' }}" required>
		        </div>
	        </div>

            <div class="form-group row">
		        <label class="col-md-3">Sandi COA</label>
			        <div class="col-md-7">
                    <input type="text" class="form-control" name="sandi_coa" value="{{ $data->sandi_coa ?? '' }}" required>
		        </div>
	        </div>

            <div class="form-group row">
                <label class="col-md-3">Bagian</label>
                    <div class="col-md-7">
                    <select name="bagian" class="form-control select" required>
                        <option value="">Pilih</option>
                        <option value="Laporan Laba Rugi" {{ (optional($data)->bagian == 'Laporan Laba Rugi')?'selected':''}}>Laporan Laba Rugi</option>
                        <option value="Laporan Neraca" {{ (optional($data)->bagian == 'Laporan Neraca')?'selected':''}}>Laporan Neraca</option>
                        <option value="Rekening Administratif" {{ (optional($data)->bagian == 'Rekening Administratif')?'selected':''}}>Rekening Administratif</option>
                    </select>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>

        </form>
    </div>
</div>
@endsection
