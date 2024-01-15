<!DOCTYPE html>
@extends('tema.app')
@section('content')

<div class="card border-white" style="width: 100rem;">
    <div class="card-body">
       
        <div class="card border-white">
			<div class="card-body">
                <h5 style="text-align:center">RESUME HASIL OBSERVASI - {{ strtoupper(\App\Models\InformasiPokokBprPelapor::namaBpr($data->sandi_bpr)->nama_bpr) ?? '' }}</h5>
                <div style="height:30px"></div>
        
                @include('flash-message')
                @include('error-message')
                @include('list-menu')
            </div>
        </div>

        <div style="height:10px"></div>
      
        <div class="card border-white">
            <div class="card-body">

                <form action="{{ url('save-resume-hasil-observasi') }}" method="POST">@csrf
                    <input type="hidden" name="sandi_bpr" value="{{ $data->sandi_bpr ?? ''  }}">
                    <input type="hidden" name="id" value="{{ $resumeHasilObservasi->id ?? ''  }}">
                    <input type="hidden" name="loan_applicant_id" value="{{ $id ?? '' }}">

                    <input type="hidden" name="tabel" value="resume_hasil_observasi">
                    <input type="hidden" name="aksi" value="{{ (isset($resumeHasilObservasi->id)) ? 'Update' : 'Create' }}">
                    <input type="hidden" name="bagian" value="Nak">

                    <div class="form-group">
                        <textarea class="form-control {{ (Auth::user()->jabatan_user->kode == 'account_officer' && $data->status_level_proses == 1) ? 'content' : 'read' }}" name="keterangan"  rows="6">{{ $resumeHasilObservasi->keterangan ?? '' }}</textarea>
                    </div>

                    @if (Auth::user()->jabatan_user->kode == 'account_officer' && $data->status_level_proses == 1)
                        <button type="submit" class="btn btn-primary">Save</button>
                    @endif
                </form>
            </div> 
        </div>
	</div>
</html>
@endsection
