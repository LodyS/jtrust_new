@extends('tema.app')
@section('content')

<div class="card border-white" style="width: 100rem;">
    <div class="card-body">
        @include('flash-message')
        <h4>Edit Header Laporan Keuangan {{ $data->nama_bpr ?? '' }}</h4>

        <div style="height:40px" align="centre"></div>

        <form action="{{  url('update-header-import') }}" method="POST">@csrf

        @include('error-message')

        <input type="hidden" name="id" value="{{ optional($data)->id }}">
        <input type="hidden" name="sandi_bpr" value="{{ optional($data)->sandi_bpr }}">
        <input type="hidden" name="aksi" value="Update">
        <input type="hidden" name="tabel" value="header_import">

        <div class="form-group row">
		    <label class="col-md-3">Jenis Laporan</label>
			    <div class="col-md-7">
                <input type="text" class="form-control" value="{{ optional($data)->jenis_laporan }}" readonly>
		    </div>
	    </div>

        <div class="form-group row">
		    <label class="col-md-3">Pilih Periode</label>
			    <div class="col-md-7">
                <select name="periode_waktu" class="form-control" required>
                    <option>Pilih</option>
                    <option value="Januari" {{ ($data->periode_waktu == 'Januari') ? 'selected' : '' }}>Januari</option>
                    <option value="Februari" {{ ($data->periode_waktu == 'Februari') ? 'selected' : '' }}>Februari</option>
                    <option value="Maret" {{ ($data->periode_waktu == 'Maret') ? 'selected' : '' }}>Maret</option>
                    <option value="April" {{ ($data->periode_waktu == 'April') ? 'selected' : '' }}>April</option>
                    <option value="Mei" {{ ($data->periode_waktu == 'Mei') ? 'selected' : '' }}>Mei</option>
                    <option value="Juni" {{ ($data->periode_waktu == 'Juni') ? 'selected' : '' }}>Juni</option>
                    <option value="Juli" {{ ($data->periode_waktu == 'Juli') ? 'selected' : '' }}>Juli</option>
                    <option value="Agustus" {{ ($data->periode_waktu == 'Agustus') ? 'selected' : '' }}>Agustus</option>
                    <option value="September" {{ ($data->periode_waktu == 'September') ? 'selected' : '' }}>September</option>
                    <option value="Oktober" {{ ($data->periode_waktu == 'Oktober') ? 'selected' : '' }}>Oktober</option>
                    <option value="November" {{ ($data->periode_waktu == 'November') ? 'selected' : '' }}>November</option>
                    <option value="Desember" {{ ($data->periode_waktu == 'Desember') ? 'selected' : '' }}>Desember</option>
                </select>
		    </div>
	    </div>

        <?php $tahun = date('Y'); ?>
        <div class="form-group row">
		    <label class="col-md-3">Pilih Tahun</label>
			    <div class="col-md-7">
                <select name="tahun" id="tahun" class="form-control select" required>
                    <option value="">Pilih</option>
                    @for($i=2019; $i<=$tahun; $i++)
                    <option value="{{ $i }}" {{ ($data->tahun == $i)?'selected':''}}>{{ $i}} </option>
                    @endfor
                </select>
		    </div>
	    </div>

        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="{{ url('list-user') }}" class="btn btn-danger">Cancel</a>
        </div>

    </div>
</div>
@endsection





