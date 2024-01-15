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
                <h5 style="text-align:center">LEMBAR OPINI - COMPLIANCE </h5>
                <div style="height:30px"></div>
         
                @include('list-menu')
            </div>
        </div>
         
        <div style="height:10px"></div>

        <div class="card border-white">
            <div class="card-body">
                <form action="{{ url('lembar-opini-compliance') }}" method="POST">@csrf
                    <input type="hidden" name="loan_applicant_id" value="{{ $id }}">
                    <input type="hidden" name="aksi" value="create">

                    <input type="hidden" name="section_head" value="{{ $sectionHead->id ?? '' }}">
                    <input type="hidden" name="departemen_head" value="{{ $depHead->id ?? '' }}">
                    <input type="hidden" name="division_head" value="{{ $divisionHead->id ?? '' }}">

                    <table class="table">
                        <tr>
                            <td colspan="1" style="text-align:center;"><b>LEMBAR OPINI ATAS USULAN KREDIT <br/> KAJIAN KEPATUHAN<br/>LONG FORM</b></td>
                         
                        </tr>
                    </table>

                    <table class="table">
                        <tr>
                            <td>
                                <ul>
                                    <li>Rekomendasi dan mitigasi di bawah ini adalah kesimpulan dan catatan yang didapat sesuai dengan kajian atas dokumen,
                                    <br/>informasi serta data yang disampaikan
                                    oleh pihak pengusul kredit dalam bentuk; <br/>Dokumen NAK, Dokumen Pendukung lainnya serta
                                    penjelasan lisan dalam forum RATEK.</li>

                                    <br/>

                                    <li>Validitas dan verifikasi atas kebenaran, keakuratan dan kekinian atas data, <br/>dokumen serta bentuk lain
                                    informasi yang disampaikan sepenuhnya menjadi tanggung jawab Pengusul.</li>
                                </ul>
                            </td>
                        </tr>
                    </table>

                    <table class="table table-bordered table-sm">
                        <tr>
                            <th colspan="3" style="text-align:center;">PENGUSUL KREDIT</th>
                        </tr>

                        <tr>
                            <td width="30%">Nama BM/RM/Cabang</td>
                            <td>ANCUN</td>
                        </tr>

                        <tr>
                            <td width="30%">No. NAK/ARR</td>
                            <td>{{ $data->no_nak_long_form ?? '' }}</td>
                        </tr>

                        <tr>
                            <td width="30%">Segmen Pengelola/Bussiness Unit</td>
                            <td>-</td>
                        </tr>
                    </table>

                    <table class="table table-bordered table-sm">
                        <tr>
                            <th colspan="3" style="text-align:center;">INFORMASI DEBITUR/CALON DEBITUR</th>
                        </tr>

                        <tr>
                            <td width="30%">Nama</td>
                            <td>{{ \App\Models\InformasiPokokBprPelapor::namaBpr($data->sandi_bpr)->nama_bpr ?? ''}}</td>
                        </tr>

                        <tr>
                            <td width="30%">Alamat</td>
                            <td>{{ $informasiPokokBpr->alamat_bpr ?? '' }}</td>
                        </tr>

                        <tr>
                            <td width="30%">Group Usaha Terkait</td>
                            <td>{{ $informasiPokokBpr->group_usaha ?? '' }}</td>
                        </tr>

                        <tr>
                            <td width="30%">Sektor Bidang Usaha</td>
                            <td>{{ $informasiPokokBpr->bidang_usaha_group ?? '' }}</td>
                        </tr>

                        <tr>
                            <td width="30%">Tujuan</td>
                            <td>{{ $data->jenis_pengajuan ?? '' }}</td>
                        </tr>
                    </table>

                    <table class="table table-bordered table-sm">
                        <tr>
                            <th colspan="5" style="text-align:center;">PLAFOND</th>
                        </tr>

                        <tr>
                            <th>No</th>
                            <th>Jenis</th>
                            <th>Plafond</th>
                            <th>Outstanding</th>
                            <th>Kolektibilitas</th>
                        </tr>

                        <tr>
                            <td>1</td>
                            <td>KAB</td>
                            <td style="text-align:right">Rp. {{ number_format($data->plafond,2) }}</td>
                            <td>-</td>
                            <td>{{ $data->kol_di_bank_jtrust ?? ''}}</td>
                        </tr>

                        <tr>
                            <td></td>
                            <td></td>
                            <td style="text-align:center">Rp. {{ number_format($data->where('id', $data->id)->sum('plafond'),2) }}</td>
                            <td></td>
                            <td></td>
                        </tr>
                    </table>
                </div> 
            </div> 

            <div style="height:10px"></div>

            <div class="card border-white">
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <th style="text-align:center;">ANALISA PROFIL RISIKO KEPATUHAN& MANAJEMEN RISIKO</th>
                        </tr>

                        @foreach($pertanyaan as $sub=>$q)
                            <tr>
                                <td style="background-color:white;">
                                    <b>Risiko : </b>
                                    <div style="height:20px"></div>
                                    <textarea class="form-control" rows="15">{{ strip_tags($sub) }}</textarea>

                                    <input type="hidden" name="pertanyaan_id[]" value="{{ \App\Models\MasterPertanyaan::getId($sub) }}">

                                    <div style="height:20px"></div>
                                    <b>Indentifikasi : </b>
                                    <div style="height:20px"></div>

                                    @foreach ($q as $key =>$d)
                                        <div class="form-check">
                                            <div class="col-sm-5" style="position: relative; left:1%">
                                            <input class="form-check-input" type="radio" name="identifikasi[]{{$d->pertanyaan_id}}" value="{{ $d->jawaban }}">
                                            <label class="form-check-label" style="position: relative; right:5%">{{ $d->jawaban }} </label>
                                        </div>
                                    @endforeach
                                    <div style="height:20px"></div>

                                    <div class="form-group">
                                        <label><b>CATATAN /REKOMENDASI / MITIGASI</b></label>
                                        <textarea class="form-control" name="catatan_rekomendasi_mitigasi[]" rows="15"></textarea>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div> 
            </div> 

            <div class="card border-white">
                <div class="card-body">
                    <label><b>Lembar Opini</b></label>
                    <textarea class="form-control content" name="lembar_opini"></textarea></td>
                </div> 
            </div>  

            <div class="card border-white">
                <div class="card-body">
                    <label><b>Catatan</b></label>
                    <textarea class="form-control content" name="catatan"></textarea></td>    
                </div> 
            </div> 

            <div style="height:10px"></div>

            <div class="card border-white">
                <div class="card-body">
                    <table class="table">

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

                    @if($setting_flow->status_compliance_opini == 'Yes' && $opini == null)
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



