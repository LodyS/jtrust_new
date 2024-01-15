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

        <div class="card border-white">
            <div class="card-body">
                <h5 style="text-align:center">LEMBAR OPINI - COMPLIANCE
                    <span style="float:right;">
                        <a href="{{ url('print-opini-compliance', $id)}}" class="btn btn-primary btn-xs" align="right" target="_blank">
                            <i data-feather="printer"></i>
                        </a>
                    </span>
                </h5>

                <div style="height:30px"></div>

                @include('list-menu')
            </div> 
        </div>

        <div style="height:30px"></div>
        
        <div class="card border-white">
            <div class="card-body">

                <form action="{{ url('lembar-opini-compliance') }}" method="POST">@csrf
                    <input type="hidden" name="loan_applicant_id" value="{{ $id }}">
                    <input type="hidden" name="aksi" value="edit">

                    <input type="hidden" name="section_head" value="{{ $sectionHead->id ?? '' }}">
                    <input type="hidden" name="departemen_head" value="{{ $depHead->id ?? '' }}">
                    <input type="hidden" name="division_head" value="{{ $divisionHead->id ?? '' }}">

                    <table class="table table-bordered">
                        <tr>
                            <td colspan="2" style="text-align:center;"><b>LEMBAR OPINI ATAS USULAN KREDIT <br/> KAJIAN KEPATUHAN<br/>LONG FORM</b></td>
                        </tr>
                    </table>

                    <table class="table">
                        <tr>
                            <th style="text-align:center;">ANALISA PROFIL RISIKO KEPATUHAN& MANAJEMEN RISIKO</th>
                        </tr>

                        @foreach($opini_detail as $sub=>$x)
                            <tr>
                                <td style="background-color:white">
                                    <b>Risiko : </b>
                                    <div style="height:20px"></div>
                                    <textarea class="form-control" rows="30">{{ strip_tags($sub) }}</textarea>


                                    <div style="height:20px"></div>
                                    <b>Identifikasi : </b>
                                    <div style="height:20px"></div>

                                    @foreach ($x as $kunci=> $a)
                                        <input type="hidden" name="opini_detail[]" value="{{ $kunci }}">
                                        @foreach ($a as $k => $q)
                                            @foreach ($q as $key =>$d)
                                                <div class="form-check">
                                                    <div class="col-sm-5" style="position: relative; left:1%">
                                                        <input class="form-check-input" type="radio" name="identifikasi[]{{$d->pertanyaan_id}}" value="{{ $d->jawaban }}" {{ ($d->identifikasi == $d->jawaban) ? 'checked' : '' }}>
                                                        <label class="form-check-label" style="position: relative; right:5%">{{ $d->jawaban }} </label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endforeach
                                    @endforeach
                                    <div style="height:20px"></div>
                                    
                                    @foreach ($x as $kunci=> $q)
                                        @foreach ($a as $k => $q)
                                            <div class="form-group">
                                                <label><b>CATATAN /REKOMENDASI / MITIGASI</b></label>
                                                <textarea class="form-control" name="catatan_rekomendasi_mitigasi[]"  rows="`5">{{ $k ?? '' }}</textarea>
                                            </div>
                                        @endforeach
                                    @endforeach
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div> 

            <div style="height:10px"></div>

            <div class="card border-white">
                <div class="card-body">

                    <textarea class="form-control content" name="lembar_opini">{{ $opini->lembar_opini ?? '' }}</textarea></td>
                </div> 
            </div> 
            
            <div class="card border-white">
                <div class="card-body">
                    <textarea class="form-control content" name="catatan">{{ $opini->catatan ?? '' }}</textarea></td>
                </div> 
            </div> 

            <div style="height:10px"></div>

            <div class="card border-white">
                <div class="card-body">
                    <table class="table table-bordered table-sm wrap">

                        <tr>
                            <td colspan="2" style="height:2cm"></td>
                            <td colspan="3" style="height:2cm"></td>
                        </tr>

                        <tr>
                            <td colspan="3">{{ $sectionHead->name ?? ''}}</td>
                            <td colspan="2">{{ $depHead->name ?? '' }}</td>

                        </tr>

                        <tr>
                            <td colspan="3">Section Head Regulatory Compliance</td>
                            <td colspan="2">Dept Head Regulatory Compliance  </td>

                        </tr>

                        <tr>
                            <td colspan="5" style="height:2cm"></td>
                        </tr>

                        <tr>
                            <td colspan="5">{{ $divisionHead->name ?? '' }}</td>
                        </tr>

                        <tr>
                            <td colspan="5">Div. Head Compliance </td>
                        </tr>

                    </table>


                    @if($setting_flow->status_compliance_opini == 'Yes' && $data->status == 'Yes')
                    
                        <div style="height:30px"></div>
                        <div>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    @endif

                </form>
            </div>
        </div>
    </div>
</div>
@endsection



