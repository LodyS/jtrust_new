<!DOCTYPE html>
@extends('tema.app')
@section('content')

<div class="card border-white" style="width: 100rem;">
    <div class="card-body">

        <div class="card border-white">
			<div class="card-body">
                <h5 align="center">
                    FINANCIAL HIGLIGHT - {{ strtoupper(\App\Models\InformasiPokokBprPelapor::namaBpr($sandi_bpr)->nama_bpr) }}
                </h5>

                <div style="height:30px"></div>

                @include('flash-message')
                @include('error-message')
        		@include('menu-arr')
			</div> 
		</div>

		<div style="height:10px"></div>

		<form action="{{ url('store-arr-financial-higlight') }}" method="POST" enctype="multipart/form-data">@csrf
            <input type="hidden" name="loan_applicant_id" value="{{ $id ?? '' }}">

            <div class="card border-white">
                <div class="card-body">
                    <textarea class="form-control content" name="keterangan">{{ $data->keterangan ?? '' }}</textarea>
            
                    <div style="height:30px"></div>

                    @if (Auth::user()->divisi == 'Credit Risk Reviewer' && $statusLevelProses == null)
                        <button type="submit" class="btn btn-primary">Save</button>
                    @endif
                </div> 
            </div>
        </form>
	</div>
</html>
@endsection
