<!DOCTYPE html>
@extends('tema.app')
@section('content')

<div class="card border-white" style="width: 100rem;">
    <div class="card-body">
       
        <div class="card border-white">
			<div class="card-body">
                <h5 style="text-align:center">PEMASARAN - {{ strtoupper(\App\Models\InformasiPokokBprPelapor::namaBpr($app->sandi_bpr)->nama_bpr) ?? '' }}</h5>
                <div style="height:30px"></div>
        
                @include('flash-message')
                @include('error-message')
                @include('list-menu')
            </div>
        </div>

        <div style="height:10px"></div>
      
        <div class="card border-white">
            <div class="card-body">
                <form action="{{ url('save-pemasaran') }}" method="POST" enctype="multipart/form-data">@csrf
                    <input type="hidden" name="sandi_bpr" value="{{ $app->sandi_bpr ?? ''  }}">
                    <input type="hidden" name="loan_applicant_id" value="{{ $id ?? ''  }}">

                    <input type="hidden" name="tabel" value="pemasaran">
                    <input type="hidden" name="aksi" value="{{ (isset($pemasaran->id)) ? 'Update' : 'Create' }}">
                    <input type="hidden" name="bagian" value="Nak">

                    <div style="height:30px"></div>

                    <div class="form-group">
                        <textarea class="form-control {{ (Auth::user()->jabatan_user->kode == 'account_officer' && $app->status_level_proses == 1) ? 'content' : 'read' }}" name="keterangan"  rows="6">{{ $pemasaran->keterangan ?? '' }}</textarea>
                    </div>

                    @if (Auth::user()->jabatan_user->kode == 'account_officer' && $app->status_level_proses == '1')
                        <button type="submit" class="btn btn-primary">Save</button>
                    @endif
                </form>
            </div> 
        </div>
    </div>
</div>
@endsection
