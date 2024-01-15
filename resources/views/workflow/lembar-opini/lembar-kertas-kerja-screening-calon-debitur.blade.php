<!DOCTYPE html>
@extends('tema.app')
@section('content')

<style>
.v4 { list-style: none outside none; margin:0; padding: 0; text-align: center }
.inline { display: inline; margin: 0 10px; }

.feather {
    width:16px;
    height:10px;
}

</style>

<div class="card border-white" style="width: 100rem;">
    <div class="card-body">
             
        <div class="card border-white" >
            <div class="card-body">  

                <div>
                    <h5 style="text-align:center;">LEMBAR OPINI - KERTAS KERJA SCREENING CALON DEBITUR
                        @if($data->kertas_kerja_screening_cadeb)
                            <span style="float:right;">
                                <a href="{{ url('print-kertas-kerja-screening-calon-debitur', $data->id)}}" class="btn btn-primary btn-xs" align="right"> Print</a>
                            </span>
                        @endif
                    </h5>
                </div>

                <div style="height:30px"></div>
          
                @include('list-menu')  
                @include('flash-message')
            </div>
        </div>

        <div style="height:30px"></div>

        <form action="{{ url('kertas-kerja-screening-cadeb-store') }}" method="POST">@csrf
            <div class="card border-white" >
                <div class="card-body">  

                    <input type="hidden" name="id" value="{{ $id ?? '' }}">

                    <h5 style="text-align:center">Kertas Kerja Screening Calon Debitur<h5>
                    <div style="height:10px"></div>
                    
                    <table class="table table-borderd">
                        <tr>
                            <td>Nomor</td>
                            <td>{{ $data->no_nak_long_form ?? '' }}</td>
                        </tr>

                        <tr>
                            <td>Nama Calon Debitur</td>
                            <td>{{ \App\Models\InformasiPokokBprPelapor::namaBpr($data->sandi_bpr)->nama_bpr }}</td>
                        </tr>
                    </table>
                </div> 
            </div> 

            <div style="height:10px"></div>

            <div class="card border-white" >
                <div class="card-body">  
                    <div class="form-group">
                        @if(Auth::user()->jabatan_user->nama_jabatan == 'AML & CFT Section Head')
                            <textarea class="form-control content" name="kertas_kerja_screening_cadeb">{{ $data->kertas_kerja_screening_cadeb ?? '' }}</textarea>
                        @else
                            <textarea class="form-control read" name="kertas_kerja_screening_cadeb">{{ $data->kertas_kerja_screening_cadeb ?? '' }}</textarea>
                        @endif
            
                        @if($setting_flow->status_worksheet_screening == 'Yes' && $data->kertas_kerja_screening_cadeb == null)
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        @endif

                        @if($setting_flow->status_worksheet_screening == 'Yes' && isset($data->kertas_kerja_screening_cadeb))
                            @if($data->return_status_kertas_kerja_screening == 'Yes')
                                <div style="height:30px"></div>
                                <div>
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            @endif
                        @endif
                    </div>
                </div> 
            </div>
        </form>
    </div>
</div>
@endsection
