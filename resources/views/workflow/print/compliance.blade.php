<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

<title>OPINI COMPLIANCE {{ strtoupper(\App\Models\InformasiPokokBprPelapor::namaBpr($data->sandi_bpr)->nama_bpr) }}</title>

<style>
* {
    font-size:12px;
}
</style>

<body>
    <div class="card">
        <div class="card-body">

            <table class="table table-bordered">
                <tr>
                    <td colspan="1" style="text-align:center;"><b>LEMBAR OPINI ATAS USULAN KREDIT <br/> KAJIAN KEPATUHAN<br/>LONG FORM</b></td>
                    <td><img src="{{ url('logo/jtrust.jpg') }}" width="200px" height="50px" style="text-align:center"></td>
                </tr>
            </table>

            <table class="table table-bordered">
                <tr>
                    <td>
                        <ul>
                            <li>
                                Rekomendasi dan mitigasi di bawah ini adalah kesimpulan dan catatan yang didapat sesuai dengan kajian atas dokumen,
                                <br/>informasi serta data yang disampaikan
                                oleh pihak pengusul kredit dalam bentuk; <br/>Dokumen NAK, Dokumen Pendukung lainnya serta
                                penjelasan lisan dalam forum RATEK.
                            </li>

                            <br/>

                            <li>
                                Validitas dan verifikasi atas kebenaran, keakuratan dan kekinian atas data, <br/>dokumen serta bentuk lain
                                informasi yang disampaikan sepenuhnya menjadi tanggung jawab Pengusul.
                            </li>
                        </ul>
                    </td>
                </tr>
            </table>

            <table class="table table-bordered table-sm">
                <tr>
                    <th colspan="3" style="text-align:center;">PENGUSUL KREDIT</th>
                </tr>

                <tr>
                    <td>Nama BM/RM/Cabang</td>
                    <td colspan="2"></td>
                </tr>

                <tr>
                    <td>No. NAK/ARR</td>
                    <td colspan="2">{{ $data->no_nak_long_form ?? '' }}</td>
                </tr>

                <tr>
                    <td width="40%">Segmen Pengelola/Bussiness Unit</td>
                    <td colspan="2">-</td>
                </tr>
            </table>

            <table class="table table-bordered table-sm">
                <tr>
                    <th colspan="3" style="text-align:center;">INFORMASI DEBITUR/CALON DEBITUR</th>
                </tr>

                <tr>
                    <td width="30%">Nama</td>
                    <td colspan="2">{{ \App\Models\InformasiPokokBprPelapor::namaBpr($data->sandi_bpr)->nama_bpr ?? ''}}</td>
                </tr>

                <tr>
                    <td width="30%">Alamat</td>
                    <td colspan="2">{{ $informasiPokokBpr->alamat_bpr ?? '' }}</td>
                </tr>

                <tr>
                    <td width="30%">Group Usaha Terkait</td>
                    <td colspan="2">{{ $informasiPokokBpr->group_usaha ?? '' }}</td>
                </tr>

                <tr>
                    <td width="30%">Sektor Bidang Usaha</td>
                    <td colspan="2">{{ $informasiPokokBpr->bidang_usaha_group ?? '' }}</td>
                </tr>

                <tr>
                    <td width="30%">Tujuan</td>
                    <td colspan="2">{{ $data->jenis_pengajuan ?? '' }}</td>
                </tr>
            </table>

            <table class="table table-sm">
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
                    <td style="text-align:right">-</td>
                    <td>{{ $data->kol_di_bank_jtrust ?? ''}}</td>
                </tr>

                <tr>
                    <td></td>
                    <td></td>
                    <td style="text-align:right">Rp. {{ number_format($data->where('id', $data->id)->sum('plafond'),2) }}</td>
                    <td style="text-align:right"></td>
                    <td></td>
                </tr>
            </table>
        </div> 
    </div>

    <div style="height:auto; page-break-before: always"></div>

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-sm">
                <tr>
                    <th style="text-align:center;">ANALISA PROFIL RISIKO KEPATUHAN& MANAJEMEN RISIKO</th>
                </tr>
            </table>

            @foreach($opini_detail as $sub=>$x)
               
                <b>Risiko : </b>
                <div style="height:20px"></div>
                {!! $sub !!}

                <div style="height:20px"></div>
                <b>Identifikasi :  </b>
                <div style="height:20px"></div>

                @foreach ($x as $kunci=> $a)   
                    @foreach ($a as $k => $q)
                        @foreach ($q as $key =>$d)
                            @if($key == 0)
                                <label class="form-check-label">{{ $d->identifikasi }} </label>  
                            @endif
                        @endforeach
                    @endforeach
                @endforeach

                <div style="height:20px"></div>
                <label><b>CATATAN /REKOMENDASI / MITIGASI<b></label>

                @foreach ($x as $kunci=> $q)
                    @foreach ($a as $k => $q)
                        <textarea class="form-control" rows="15" readonly style="background-color:white; width:650px; border-left: none; border-right:none; border-top:none; border-bottom:none;">{{ $k }}</textarea>
                    @endforeach
                @endforeach 
            @endforeach
        </div> 
    </div> 

    <div style="height:auto; page-break-before: always"></div>

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-sm">
                <tr>
                    <th style="text-align:center;">OPINI</th>
                </tr>
            </table>

            {!! $opini->lembar_opini ?? '' !!}
        </div> 
    </div> 

    <div style="height:auto; page-break-before: always"></div>

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-sm">
                <tr>
                    <th style="text-align:center;">CATATAN</th>
                </tr>
            </table>

            {!! $opini->catatan ?? '' !!}
        </div> 
    </div> 

    <div style="height:auto; page-break-before: always"></div>

    <div class="card">
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
        </div>
    </div>
</body>

