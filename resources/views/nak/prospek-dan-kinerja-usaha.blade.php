<!DOCTYPE html>
@extends('tema.app')
@section('content')
<body>
    <div class="card border-white" style="width: 100rem;">
        <div class="card-body">

            <div class="card border-white">
                <div class="card-body">

                    <h5 style="text-align:center">PROSPEK DAN KINERJA USAHA - {{ strtoupper(\App\Models\InformasiPokokBprPelapor::namaBpr($data->sandi_bpr)->nama_bpr) }}</h5>
                    <div style="height:30px"></div>
                    @include('flash-message')
                    @include('error-message')

                    @include('list-menu')
                </div>
            </div>
    
            <div style="height:10px"></div>

            <form action="{{ url('save-prospek-dan-kinerja-usaha') }}" method="POST" enctype="multipart/form-data">@csrf
                <input type="hidden" name="sandi_bpr" value="{{ $data->sandi_bpr ?? ''  }}">
                <input type="hidden" name="loan_applicant_id" value="{{ $id }}">

                <input type="hidden" name="tabel" value="prospek_dan_kinerja_usaha">
                <input type="hidden" name="aksi" value="{{ (isset($prospekDanKinerjaUsaha->id)) ? 'Update' : 'Create' }}">
                <input type="hidden" name="bagian" value="Nak">

                <div class="card border-white">
                    <div class="card-body">
                        <div class="form-group">
                            <textarea class="form-control {{ (Auth::user()->jabatan_user->kode == 'account_officer' && $data->status_level_proses == 1) ? 'content' : 'read' }}" name="keterangan"  rows="6">{{ $prospekDanKinerjaUsaha->keterangan ?? '' }}</textarea>
                        </div>

                        <div style="height:20px"></div>

                        @if (Auth::user()->jabatan_user->kode == 'account_officer' && $data->status_level_proses == 1)
                            <button type="submit" class="btn btn-primary">Save</button>
                        @endif
                    </div> 
                </div>
            </form>
	    </div>
    </div>
</body>
@endsection

