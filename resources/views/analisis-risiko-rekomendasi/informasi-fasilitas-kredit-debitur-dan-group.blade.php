<!DOCTYPE html>
@extends('tema.app')
@section('content')

<div class="card border-white" style="width: 100rem;">
    <div class="card-body">

        <div class="card border-white">
			<div class="card-body">
                <h5 style="text-align:center">
                    INFORMASI FASILITAS KREDIT DEBITUR & GROUP- {{ strtoupper(\App\Models\InformasiPokokBprPelapor::namaBpr($data->sandi_bpr)->nama_bpr) }}
                </h5>

                <div style="height:30px"></div>

                @include('flash-message')
                @include('error-message')
        		@include('menu-arr')
			</div> 
		</div>

		<div style="height:10px"></div>

		<form action="{{ url('store-loan-applicant') }}" method="POST">@csrf

            <input type="hidden" name="id" value="{{ $id ?? '' }}">

            <div class="card border-white">
                <div class="card-body">  
                    <table class="table table-bordered table-responsive">
                        <tr>
                            <th width="20%">Fasilitas</th>
                            <th>Plafond Eksiting</th>
                            <th>O/S</th>
                            <th>Usulan Bisnis  +/- (Total Plafond)</th>
                            <th>Rekomendasi CCRD</th>
                            <th>Jatuh Tempo</th>
                        </tr>

                        <tr>
                            <td>KAB</td>
                            <td>-</td>
                            <td>-</td>
                            <td></td>
                            <td></td>
                            <td>{{ $data->tenor ?? '' }} Bulan sejak fasilitas kredit efektif</td>
                        </tr>

                        <tr>
                            <td colspan="1"></td>
                            <td>-</td>
                            <td>-</td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </table>
                </div> 
            </div>

            <div style="height:30px"></div>
        
            <div class="card border-white">
                <div class="card-body">  
                    <div class="form-group">
                        <label>Catatan Tambahan Fasilitas Kredit (Opsional)</label>
                        <textarea class="form-control content" name="catatan_tambahan_fasilitas_kredit"  rows="6">{{ $data->catatan_tambahan_fasilitas_kredit ?? '' }}</textarea>
                    </div>

                    @if (Auth::user()->divisi == 'Credit Risk Reviewer' && $data->crrd_section_head == null)
                        <button type="submit" class="btn btn-primary">Save</button>
                    @endif
                </div> 
            </div>
        </form>
    </div>
</div>
@endsection
