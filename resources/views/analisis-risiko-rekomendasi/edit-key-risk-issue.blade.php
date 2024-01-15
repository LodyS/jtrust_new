<!DOCTYPE html>
@extends('tema.app')
@section('content')

<style>
ul { list-style: none outside none; margin:0; padding: 0; text-align: center }
li { display: inline; margin: 0 10px; }

.feather {
    width:16px;
    height:10px;
}

table {
    border-collapse: collapse;
    border-spacing: 0;
    width: 100%;
    border: 1px solid #ddd;
}

th, td {
    text-align: left;
    padding: 8px;
}

tr:nth-child(even) {
    background-color: #f2f2f2
}

pre {
    width: 700px;
    //word-wrap: break-word;
}

</style>

<div class="card border-white" style="width: 100rem;">
    <div class="card-body">

        <div class="card border-white">
            <div class="card-body">
                <h5 style="text-align:center">
                    ANALISIS RISIKO DAN REKOMENDASI - KEY RISK ISSUE {{ strtoupper(\App\Models\InformasiPokokBprPelapor::namaBpr($sandi_bpr)->nama_bpr) }}

                    <span style="float:right;"> 
                        <a href="javascript:void(0);" onClick="tambah({{ $id }})" class="hapus btn btn-danger btn-xs">Refresh</a>
                    </span>
                </h5>
        
                <div style="height:30px"></div>

                @include('flash-message')
                @include('error-message')    
                @include('menu-arr')
            </div> 
        </div>
                
        <div style="height:10px"></div>

		<form action="{{ url('store-key-risk-issue') }}" method="POST">@csrf

            <input type="hidden" name="loan_applicant_id" value="{{ $id ?? '' }}">
            <input type="hidden" name="aksi" value="edit">

            <div class="card border-white">
                <div class="card-body">
                        <table class="table table-bordered table-sm">
                            <tr>
                                <th style="width:80%">Risk Issue</th>
                                <th style="width:15%">Answer</th>
                            </tr>

                            <tr>
                                <th colspan="4" style="text-align:center;">Character</th>
                            </tr>
                                            
                            @foreach($data->where('sub_jenis_pertanyaan', 'Character') as $key=>$d)
                                <tr>
                                    <td style="font-size: 11px;">
                                        <label>Pertanyaan</label>
                                        <textarea class="form-control" readonly rows="6">{{ strip_tags($d->pertanyaan) ?? '' }}</textarea><br/>
                                        <input type="hidden" name="risk_issue[]" value="{{ $d->id}}">

                                        <label>Risk Mitigation</label>
                                        <textarea class="form-control content" name="risk_mitigation[]" rows="4">{{ $d->risk_mitigation ?? '' }}</textarea>
                                    </td>
                                                    
                                    <td style="vertical-align:top">
                                        <div class="form-check" style="position: relative; left:25%">
                                            <input class="form-check-input" type="radio" name="jawaban[]{{ $key }}" value="Ya" {{ $d->jawaban == "Ya" ? 'checked' : '' }}>
                                            <div style="height:5px"></div>
                                            <label style="font-size: 11px;">Ya</label>
                                        </div>
                                                        
                                        <div class="form-check" style="position: relative; left:25%">
                                            <input class="form-check-input" type="radio" name="jawaban[]{{ $key }}" value="Tidak" {{ $d->jawaban == "Tidak" ? 'checked' : '' }}>
                                            <div style="height:5px"></div>
                                            <label style="font-size: 11px;">Tidak</label>
                                        </div>
                                                    
                                        <div class="form-check" style="position: relative; left:25%">
                                            <input class="form-check-input" type="radio" name="jawaban[]{{ $key }}" value="Tidak Ada Informasi" {{ $d->jawaban == "Tidak Ada Informasi" ? 'checked' : '' }}>
                                            <div style="height:5px"></div>
                                            <label style="font-size: 11px;">Tidak Ada Informasi</label>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                            <tr>
                                <th colspan="4" style="text-align:center;">Capital</th>
                            </tr>

                            @foreach($data->where('sub_jenis_pertanyaan', 'Capital') as $key=>$d)
                                <tr>
                                    <td style="font-size: 11px;">
                                        <label>Pertanyaan</label>
                                        <textarea class="form-control" readonly rows="6">{{ strip_tags($d->pertanyaan) ?? '' }}</textarea><br/>
                                        <input type="hidden" name="risk_issue[]" value="{{ $d->id}}">

                                        <label>Risk Mitigation</label>
                                        <textarea class="form-control content" name="risk_mitigation[]" rows="4">{{ $d->risk_mitigation ?? '' }}</textarea>
                                    </td>
                                                    
                                    <td style="vertical-align:top">
                                        <div class="form-check" style="position: relative; left:25%">
                                            <input class="form-check-input" type="radio" name="jawaban[]{{ $key }}" value="Ya" {{ $d->jawaban == "Ya" ? 'checked' : '' }}>
                                            <div style="height:5px"></div>
                                            <label style="font-size: 11px;">Ya</label>
                                        </div>
                                                        
                                        <div class="form-check" style="position: relative; left:25%">
                                            <input class="form-check-input" type="radio" name="jawaban[]{{ $key }}" value="Tidak" {{ $d->jawaban == "Tidak" ? 'checked' : '' }}>
                                            <div style="height:5px"></div>
                                            <label style="font-size: 11px;">Tidak</label>
                                        </div>
                                                        
                                        <div class="form-check" style="position: relative; left:25%">
                                            <input class="form-check-input" type="radio" name="jawaban[]{{ $key }}" value="Tidak Ada Informasi" {{ $d->jawaban == "Tidak Ada Informasi" ? 'checked' : '' }}>
                                            <div style="height:5px"></div>
                                            <label style="font-size: 11px;">Tidak Ada Informasi</label>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                            <tr>
                                <th colspan="4" style="text-align:center;">Capacity</th>
                            </tr>

                            @foreach($data->where('sub_jenis_pertanyaan', 'Capacity') as $key=>$d)
                                <tr>
                                    <td style="font-size: 11px;">
                                        <textarea class="form-control" readonly rows="6">{{ strip_tags($d->pertanyaan) ?? '' }}</textarea><br/>
                                        <input type="hidden" name="risk_issue[]" value="{{ $d->id}}">

                                        <label>Risk Mitigation</label>
                                        <textarea class="form-control content" name="risk_mitigation[]" rows="4">{{ $d->risk_mitigation ?? '' }}</textarea>
                                    </td>
                                                    
                                    <td style="vertical-align:top">
                                        <div class="form-check" style="position: relative; left:25%">
                                            <input class="form-check-input" type="radio" name="jawaban[]{{ $key }}" value="Ya" {{ $d->jawaban == "Ya" ? 'checked' : '' }}>
                                            <div style="height:5px"></div>
                                            <label style="font-size: 11px;">Ya</label>
                                        </div>
                                                        
                                        <div class="form-check" style="position: relative; left:25%">
                                            <input class="form-check-input" type="radio" name="jawaban[]{{ $key }}" value="Tidak" {{ $d->jawaban == "Tidak" ? 'checked' : '' }}>
                                            <div style="height:5px"></div>
                                            <label style="font-size: 11px;">Tidak</label>
                                        </div>
                                                        
                                        <div class="form-check" style="position: relative; left:25%">
                                            <input class="form-check-input" type="radio" name="jawaban[]{{ $key }}" value="Tidak Ada Informasi" {{ $d->jawaban == "Tidak Ada Informasi" ? 'checked' : '' }}>
                                            <div style="height:5px"></div>
                                            <label style="font-size: 11px;">Tidak Ada Informasi</label>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                            <tr>
                                <th colspan="4" style="text-align:center;">Collateral</th>
                            </tr>

                            @foreach($data->where('sub_jenis_pertanyaan', 'Collateral') as $key=>$d)
                                <tr>
                                    <td style="font-size: 11px;">
                                        <textarea class="form-control" readonly rows="6">{{ strip_tags($d->pertanyaan) ?? '' }}</textarea><br/>
                                        <input type="hidden" name="risk_issue[]" value="{{ $d->id}}">

                                        <label>Risk Mitigation</label>
                                        <textarea class="form-control content" name="risk_mitigation[]" rows="4">{{ $d->risk_mitigation ?? '' }}</textarea>
                                    </td>
                                                    
                                    <td style="vertical-align:top">
                                        <div class="form-check" style="position: relative; left:25%">
                                            <input class="form-check-input" type="radio" name="jawaban[]{{ $key }}" value="Ya" {{ $d->jawaban == "Ya" ? 'checked' : '' }}>
                                            <div style="height:5px"></div>
                                            <label style="font-size: 11px;">Ya</label>
                                        </div>
                                                        
                                        <div class="form-check" style="position: relative; left:25%">
                                            <input class="form-check-input" type="radio" name="jawaban[]{{ $key }}" value="Tidak" {{ $d->jawaban == "Tidak" ? 'checked' : '' }}>
                                            <div style="height:5px"></div>
                                            <label style="font-size: 11px;">Tidak</label>
                                        </div>
                                                        
                                        <div class="form-check" style="position: relative; left:25%">
                                            <input class="form-check-input" type="radio" name="jawaban[]{{ $key }}" value="Tidak Ada Informasi" {{ $d->jawaban == "Tidak Ada Informasi" ? 'checked' : '' }}>
                                            <div style="height:5px"></div>
                                            <label style="font-size: 11px;">Tidak Ada Informasi</label>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                            <tr>
                                <th colspan="4" style="text-align:center;">Condition of Economic</th>
                            </tr>

                            @foreach($data->where('sub_jenis_pertanyaan', 'Condition of Economic') as $key=>$d)
                                <tr>
                                    <td style="font-size: 11px;">
                                        <textarea class="form-control" readonly rows="6">{{ strip_tags($d->pertanyaan) ?? '' }}</textarea><br/>
                                        <input type="hidden" name="risk_issue[]" value="{{ $d->id}}">

                                        <label>Risk Mitigation</label>
                                        <textarea class="form-control content" name="risk_mitigation[]" rows="4">{{ $d->risk_mitigation ?? '' }}</textarea>
                                    </td>
                                    <td style="vertical-align:top">
                                        <div class="form-check" style="position: relative; left:25%">
                                            <input class="form-check-input" type="radio" name="jawaban[]{{ $key }}" value="Ya" {{ $d->jawaban == "Ya" ? 'checked' : '' }}>
                                            <div style="height:5px"></div>
                                            <label style="font-size: 11px;">Ya</label>
                                        </div>
                                        <div class="form-check" style="position: relative; left:25%">
                                            <input class="form-check-input" type="radio" name="jawaban[]{{ $key }}" value="Tidak" {{ $d->jawaban == "Tidak" ? 'checked' : '' }}>
                                            <div style="height:5px"></div>
                                            <label style="font-size: 11px;">Tidak</label>
                                        </div>
                                        <div class="form-check" style="position: relative; left:25%">
                                            <input class="form-check-input" type="radio" name="jawaban[]{{ $key }}" value="Tidak Ada Informasi" {{ $d->jawaban == "Tidak Ada Informasi" ? 'checked' : '' }}>
                                            <div style="height:5px"></div>
                                            <label style="font-size: 11px;">Tidak Ada Informasi</label>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                
                                            
                    @if (Auth::user()->divisi == 'Credit Risk Reviewer' && $statusLevelProses == null)
                        <div style="height:30px"></div>

                        <div>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    @endif
                </div>
            </div> 
		</div>
    </div>
</div>
@endsection

@push('scripts')
<script>

function tambah(id)
{
    if (confirm("Apakah Anda akan menambahkan pertanyaan yang belum terdapat pada Key Risk Issue ini ?") == true) {
    var id = id;
    $.ajax({
        type:"POST",
        url: "{{ url('tambah-pertanyaan-key-risk-issue') }}",
        data: {
                id: id,
                _token : "{{ csrf_token() }}",
            },

            dataType: 'json',
            success: function(res){
                location.reload();
            }
        });
    }
}

</script>
@endpush
