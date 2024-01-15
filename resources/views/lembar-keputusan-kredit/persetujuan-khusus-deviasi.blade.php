<!DOCTYPE html>
@extends('tema.app')
@section('content')

<div class="card border-white" style="width: 100rem;">
    <div class="card-body">
       
        <div class="card border-white">
			<div class="card-body">
                <h5 align="center">PERSETUJUAN KHUSUS DAN DEVIASI - {{ strtoupper(\App\Models\InformasiPokokBprPelapor::namaBpr($sandi_bpr)->nama_bpr) }}</h5>

                <div style="height:30px" ></div>
                @include('flash-message')
                @include('menu-lkk')
            </div> 
        </div>

        <div style="height:10px"></div>

        <div class="card border-white">
            <div class="card-body">

                <form action="{{ url('persetujuan-khusus-dan-deviasi') }}" method="POST">@csrf
                    <input type="hidden" name="loan_applicant_id" value="{{ $id }}">

                    <label>Keterangan</label>
                    <div class="form-group">
                        <textarea class="form-control content" name="keterangan" rows="10">{{ $data->keterangan ?? '' }}</textarea>
                    </div>

                    <div style="height:30px"></div>
                                        
                    @if(Auth::user()->divisi == 'Credit Risk Reviewer')
                        <button type="submit" class="btn btn-primary">Save</button>
                    @endif
                </form>
			</div>
        </div>
    </div>
</div>
@endsection


