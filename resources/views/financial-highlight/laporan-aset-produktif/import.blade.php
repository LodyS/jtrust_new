@extends('tema.app')
@section('content')

<style>
    ul { list-style: none outside none; margin:0; padding: 0; text-align: center }
    li { display: inline; margin: 0 10px; }
    
    .feather {
        width:16px;
        height:10px;
    }
    
</style>

<div class="card border-white" style="width: 100rem;">
    <div class="card-body">
        <h5 align="center">IMPOR LAPORAN ASET PRODUKTIF <br/>{{ strtoupper($nama_bpr = \App\Models\InformasiPokokBprPelapor::namaBpr($sandi_bpr)->nama_bpr ?? '') }}</h5>

        <div style="height:30px" align="centre"></div>

        @if(Auth::user()->jabatan_user->nama_jabatan == 'Account Officer')
            @include('menu-import-laporan-keuangan')
        @endif

    <div style="height:30px"></div>

        <form action="{{ url('import-laporan-aset-produktif') }}" method="POST"  enctype="multipart/form-data">@csrf

        @include('flash-message')

        <div class="form-group row">
		    <label class="col-md-3">File (Excel format)</label>
			    <div class="col-md-7">
                <input type="file" class="form-control" name="file" required>
		    </div>
	    </div>

        <div class="form-group row">
		    <label class="col-md-3">Pilih Periode</label>
			    <div class="col-md-7">
                <select name="periode_waktu" class="form-control" required>
                    <option>Pilih</option>
                    <option value="1">Januari</option>
                    <option value="2">Febuari</option>
                    <option value="3">Maret</option>
                    <option value="4">April</option>
                    <option value="5">Mei</option>
                    <option value="6">Juni</option>
                    <option value="7">Juli</option>
                    <option value="8">Agustus</option>
                    <option value="9">September</option>
                    <option value="10">Oktober</option>
                    <option value="11">November</option>
                    <option value="12">Desember</option>
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
                    <option value="{{ $i }}">{{ $i}} </option>
                    @endfor
                </select>
		    </div>
	    </div>

        <input type="hidden" class="form-control" name="jenis_laporan" value="Laporan Aset Produktif">
        <input type="hidden" class="form-control" name="sandi_bpr" value="{{ $sandi_bpr ?? '' }}">
        <input type="hidden" class="form-control" name="nama_bpr" value="{{ $nama_bpr ?? '' }}">

        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="{{ url('list-data-bpr') }}" class="btn btn-danger">Back</a>
        </div>

    </div>
</div>
@endsection





