<!DOCTYPE html>
@extends('tema.app')
@section('content')

<div class="card border-white" style="width: 100rem;">
    <div class="card-body">
        <div class="card border-white">
			<div class="card-body">
                <h5 align="center">
                    KEY RISK ISSUE {{ strtoupper(\App\Models\InformasiPokokBprPelapor::namaBpr($sandi_bpr)->nama_bpr) }}
                </h5>

                <div style="height:30px"></div>

                @include('flash-message')
                @include('error-message')
        		@include('menu-arr')
			</div> 
		</div>

		<div style="height:10px"></div>

        <div class="card border-white">
			<div class="card-body">
				<form action="{{ url('store-key-risk-issue') }}" method="POST">@csrf

                    <input type="hidden" name="loan_applicant_id" value="{{ $id ?? '' }}">
                    <input type="hidden" name="aksi" value="create">

                    <table class="table table-bordered" style="width:100%">
                        <tr>
                            <th style="width:80%">Risk Issue</th>
                            <th>Answer</th>
                        </tr>

                        <tr>
                            <th colspan="2" style="text-align:center;">Character</th>
                        </tr>

                        @foreach($pertanyaan->where('sub_jenis_pertanyaan', 'Character') as $key=>$d)
                            <tr>
                                <td style="font-size: 11px;" ><!--<pre>{!! $d->pertanyaan !!}</pre>-->
                                    <textarea class="form-control" rows="5" readonly>{{ strip_tags($d->pertanyaan) }}</textarea><br/>
                                    <input type="hidden" name="risk_issue[]" value="{{ $d->id}}">

                                    <label>Risk Mitigation</label>
                                    <textarea class="form-control content" name="risk_mitigation[]" rows="4"></textarea>
                                </td>
                                            
                                <td style="vertical-align:top">
                                    <div class="form-check" style="position: relative; left:25%">
                                        <input class="form-check-input" type="radio" name="jawaban[]{{ $key }}" value="Ya">
                                        <div style="height:5px"></div>
                                        <label style="font-size: 11px;">Ya</label>
                                    </div>
                                    <div class="form-check" style="position: relative; left:25%">
                                        <input class="form-check-input" type="radio" name="jawaban[]{{ $key }}" value="Tidak">
                                        <div style="height:5px"></div>
                                        <label style="font-size: 11px;">Tidak</label>
                                    </div>
                                    <div class="form-check" style="position: relative; left:25%">
                                        <input class="form-check-input" type="radio" name="jawaban[]{{ $key }}" value="Tidak Ada Informasi">
                                        <div style="height:5px"></div>
                                        <label style="font-size: 11px;">Tidak Ada Informasi</label>
                                    </div>
                                </td>
                            </tr>
                         @endforeach
                        
                        <tr>
                            <th colspan="2" style="text-align:center;">Capital</th>
                        </tr>

                        @foreach($pertanyaan->where('sub_jenis_pertanyaan', 'Capital') as $key=>$d)
                            <tr>
                                <td style="font-size: 11px;">
                                    <label>Pertanyaan</label>
                                    <textarea class="form-control" readonly rows="5">{{ strip_tags($d->pertanyaan) ?? '' }}</textarea><br/>

                                    <input type="hidden" name="risk_issue[]" value="{{ $d->id}}">

                                    <label>Risk Mitigation</label>
                                    <textarea class="form-control content" name="risk_mitigation[]" rows="4"></textarea>
                                </td>
                                <td style="vertical-align:top">
                                    <div class="form-check" style="position: relative; left:25%">
                                        <input class="form-check-input" type="radio" name="jawaban[]{{ $key }}" value="Ya">
                                        <div style="height:5px"></div>
                                        <label style="font-size: 11px;">Ya</label>
                                    </div>
                                    <div class="form-check" style="position: relative; left:25%">
                                        <input class="form-check-input" type="radio" name="jawaban[]{{ $key }}" value="Tidak">
                                        <div style="height:5px"></div>
                                        <label style="font-size: 11px;">Tidak</label>
                                    </div>
                                    <div class="form-check" style="position: relative; left:25%">
                                        <input class="form-check-input" type="radio" name="jawaban[]{{ $key }}" value="Tidak Ada Informasi">
                                        <div style="height:5px"></div>
                                        <label style="font-size: 11px;">Tidak Ada Informasi</label>
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                        <tr>
                            <th colspan="2" style="text-align:center;">Capacity</th>
                        </tr>

                        @foreach($pertanyaan->where('sub_jenis_pertanyaan', 'Capacity') as $key=>$d)
                            <tr>
                                <td style="font-size: 11px;">

                                    <label>Pertanyaan</label>
                                    <textarea class="form-control" readonly rows="6">{{ strip_tags($d->pertanyaan) ?? '' }}</textarea><br/>
                                    <input type="hidden" name="risk_issue[]" value="{{ $d->id}}">

                                    <label>Risk Mitigation</label>
                                    <textarea class="form-control content" name="risk_mitigation[]" rows="4"></textarea>
                                </td>
                                            
                                <td>
                                    <div class="form-check" style="position: relative; left:25%">
                                        <input class="form-check-input" type="radio" name="jawaban[]{{ $key }}" value="Ya">
                                        <div style="height:5px"></div>
                                        <label style="font-size: 11px;">Ya</label>
                                    </div>
                                                
                                    <div class="form-check" style="position: relative; left:25%">
                                        <input class="form-check-input" type="radio" name="jawaban[]{{ $key }}" value="Tidak">
                                        <div style="height:5px"></div>
                                        <label style="font-size: 11px;">Tidak</label>
                                    </div>
                                               
                                    <div class="form-check" style="position: relative; left:25%">
                                        <input class="form-check-input" type="radio" name="jawaban[]{{ $key }}" value="Tidak Ada Informasi">
                                        <div style="height:5px"></div>
                                        <label style="font-size: 11px;">Tidak Ada Informasi</label>
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                        <tr>
                            <th colspan="2" style="text-align:center;">Collateral</th>
                        </tr>

                        @foreach($pertanyaan->where('sub_jenis_pertanyaan', 'Collateral') as $key=>$d)
                            <tr>
                                <td style="font-size: 11px;">

                                    <label>Pertanyaan</label>
                                    <textarea class="form-control" readonly rows="6">{{ strip_tags($d->pertanyaan) ?? '' }}</textarea><br/>
                                    <input type="hidden" name="risk_issue[]" value="{{ $d->id}}">

                                    <label>Risk Mitigation</label>
                                    <textarea class="form-control content" name="risk_mitigation[]" rows="4"></textarea>
                                </td>
                                            
                                <td style="vertical-align:top">  
                                    <div class="form-check" style="position: relative; left:25%">
                                        <input class="form-check-input" type="radio" name="jawaban[]{{ $key }}" value="Ya">
                                        <div style="height:5px"></div>
                                        <label style="font-size: 11px;">Ya</label>
                                    </div>
                                                
                                    <div class="form-check" style="position: relative; left:25%">
                                        <input class="form-check-input" type="radio" name="jawaban[]{{ $key }}" value="Tidak">
                                        <div style="height:5px"></div>
                                        <label style="font-size: 11px;">Tidak</label>
                                    </div>
                                                
                                    <div class="form-check" style="position: relative; left:25%">
                                        <input class="form-check-input" type="radio" name="jawaban[]{{ $key }}" value="Tidak Ada Informasi">
                                        <div style="height:5px"></div>
                                        <label style="font-size: 11px;">Tidak Ada Informasi</label>
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                        <tr>
                            <th colspan="2" style="text-align:center;">Condition of Economic</th>
                        </tr>

                        @foreach($pertanyaan->where('sub_jenis_pertanyaan', 'Condition of Economic') as $key=>$d)
                            <tr>
                                <td style="font-size: 11px;">

                                    <label>Pertanyaan</label>
                                    <textarea class="form-control" readonly rows="6">{{ strip_tags($d->pertanyaan) ?? '' }}</textarea><br/>

                                    <input type="hidden" name="risk_issue[]" value="{{ $d->id}}">

                                    <label>Risk Mitigation</label>
                                    <textarea class="form-control content" name="risk_mitigation[]" rows="4"></textarea>
                                </td>
                                <td style="vertical-align:top">
                                    <div class="form-check" style="position: relative; left:25%">
                                        <input class="form-check-input" type="radio" name="jawaban[]{{ $key }}" value="Ya">
                                        <div style="height:5px"></div>
                                        <label style="font-size: 11px;">Ya</label>
                                    </div>
                                        
                                    <div class="form-check" style="position: relative; left:25%">
                                        <input class="form-check-input" type="radio" name="jawaban[]{{ $key }}" value="Tidak">
                                        <div style="height:5px"></div>
                                        <label style="font-size: 11px;">Tidak</label>
                                    </div>

                                    <div class="form-check" style="position: relative; left:25%">
                                        <input class="form-check-input" type="radio" name="jawaban[]{{ $key }}" value="Tidak Ada Informasi">
                                        <div style="height:5px"></div>
                                        <label style="font-size: 11px;">Tidak Ada Informasi</label>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                    
                    @if (Auth::user()->divisi == 'Credit Risk Reviewer' && $statusLevelProses == null)
                        <div style="height:30px"></div>
                        <button type="submit" class="btn btn-primary">Save</button>
                    @endif

                </form>
            </div>
        </div>
    </div>
</div>
@endsection


