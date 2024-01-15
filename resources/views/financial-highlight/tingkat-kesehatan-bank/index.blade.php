@extends('tema.app')
@section('content')

<style>

</style>

<div class="col-md-12">
    <div class="card border-white">
        <div class="card-body">

            <div class="w-sm-100 mr-auto">
                <h5 class="mb-0" align="center">
                    TINGKAT KESEHATAN BANK <br/>{{ strtoupper(\App\Models\InformasiPokokBprPelapor::namaBpr($sandi_bpr)->nama_bpr) ?? '' }}
                </h5>
                <h5 class="mb-0" align="center">{{ strtoupper(bulan($bulan))}} {{ $tahun }}</h5>
            </div>

            <div style="height:30px"></div>
            @include('menu-laporan-triwulan')
            <div style="height:30px"></div>

            <form action="{{ url('tingkat-kesehatan-bank-search') }}" method="POST">@csrf
                <input type="hidden" name="sandi_bpr" value="{{ $sandi_bpr ?? '' }}" >

                <div class="container">
                    <ul class="list-inline">
                        <li class="list-inline-item col-md-4" >
                            <label class="col-md-9">Bulan</label>
                            <div class="col-xl-11">
                                <select name="bulan" class="form-control select" required>
                                    <option value="">Pilih</option>
                                    <option value="1">Januari</option>
                                    <option value="2">Februari</option>
                                    <option value="3">Maret</option>
                                    <option value="4">April</option>
                                    <option value="5">Mei</option>
                                    <option value="6">Juni</option>
                                    <option value="7">Juli</option>
                                    <option value="8">Agustus</option>
                                    <option value="9">September</option>
                                    <option value="10">Oktober</option>
                                    <option value="11">November</option>
                                    <option value="12">Desember</option>
                                </select>
                            </div>
                        </li>

                        <?php $year = date('Y'); ?>
                        <li class="list-inline-item col-md-4" >
                            <label class="col-md-9">Tahun</label>
                            <div class="col-xl-11">
                                <select name="tahun" class="form-control select" required>
                                    <option value="">Pilih</option>
                                    @for($i=2019; $i<=$year; $i++)
                                    <option value="{{ $i }}">{{ $i}} </option>
                                    @endfor
                                </select>
                            </div>
                        </li>
                    </ul>
                </div>

                <div style="height:10px"></div>

                <button type="submit" class="btn btn-primary" style="position: relative; left:18.5%">Search</button>
            </form>

            <div style="height:10px"></div>

            <div id="test">

                <table class="table table" style="width:100%" id="table">
                    <tr>
                        <th width="350" style="text-align:center">Uraian</th>
                        <th width="80" style="text-align:center">Nilai</th>
                        <th style="text-align:center">Nilai Kredit</th>
                        <th style="text-align:center">Bobot <br/>Komponen</th>
                        <th style="height:40px font-size:13px; text-align:center" >Bobot <br/>Komponen <br/>Dalam Faktor</th>
                        <th style="text-align:center">Nilai Kredit<br/> Komponen</th>
                        <th>Nilai Kredit Faktor</th>
                        <th style="text-align:center">Predikat</th>
                    </tr>

                    <tr>
                        <td><b>I. PERMODALAN (CAPITAL)</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>

                    <?php $bobot_komponen_dalam_faktor_car = $bobot_komponen_car->bobot/$bobot_komponen_dalam_faktor_car * 100; ?>
                    <tr>
                        <td>a. CAR/KPMM</td>
                        <td style="text-align:right;">{{ $car= $nilai_car }} %</td>
                        <td style="text-align:right;">{{ $nilai_kredit_car ?? '' }}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>

                    <tr>
                        <td style="text-align:right;"><b>TOTAL FAKTOR PERMODALAN</b></td>
                        <td></td>
                        <td></td>
                        <td style="text-align:right;">{{ $bobot_komponen_car->bobot ?? '0' }}%</td>
                        <td style="text-align:right;">{{ $bobot_komponen_dalam_faktor_car ?? '' }} %</td>
                        <td style="text-align:right;">{{ $nk_komponen_car = $nilai_kredit_car * $bobot_komponen_dalam_faktor_car/100 }}</td>
                        <td style="text-align:right;">{{ $nk_faktor_car = $nk_komponen_car * $bobot_komponen_car->bobot /100}}</td>
                        <td style="text-align:center"><b>{{\App\Models\PredikatTks::statusTks($nk_komponen_car)->status}}</b></td>
                    </tr>

                    <tr>
                        <td style="text-align:right;"><b></b></td>
                        <td></td>
                        <td></td>
                        <td style="text-align:right;"></td>
                        <td style="text-align:right;"></td>
                        <td style="text-align:right;"></td>
                        <td style="text-align:right;"></td>
                        <td></td>
                    </tr>
                    <!-- II -->
                    <tr>
                        <td><b>II. KAP (ASET)</td>
                        <td style="text-align:right;"></td>
                        <td style="text-align:right;"></td>
                        <td style="text-align:right;"></td>
                        <td style="text-align:right;"></td>
                        <td style="text-align:right;"></td>
                        <td style="text-align:right;"></td>
                        <td style="text-align:right;"></td>
                    </tr>

                    <tr>
                        <td>a. Aset Produktif</td>
                        <td style="text-align:right;">{{ $kap= $nilai_kap ?? '' }} %</td>
                        <td style="text-align:right;">{{ $nilai_kredit_kap = ($nilai_kredit_kap >=100) ? 100 : round($nilai_kredit_kap) }}</td>
                        <td style="text-align:right;">{{ $bobot_komponen_kap->bobot }}%</td>
                        <td style="text-align:right;">{{ $bobot_komponen_dalam_faktor_kap = round((float)($bobot_komponen_kap->bobot/$bobot_komponen_dalam_faktor_kap) * 100,2) ?? '' }} %</td>
                        <td style="text-align:right;">{{ $nk_faktor_kap = $nilai_kredit_kap* $bobot_komponen_dalam_faktor_kap/100}}</td>
                        <td></td>
                        <td></td>
                    </tr>

                    <tr>
                        <td>b. PPAP yang dibentuk</td>
                        <td style="text-align:right;">{{ $ppap= $nilai_ppap ?? '' }} %</td>
                        <td style="text-align:right;">{{ $nilai_kredit_ppap = ($nilai_kredit_ppap >=100) ? 100 : round($nilai_kredit_ppap,2) }}</td>
                        <td style="text-align:right;">{{ $bobot_komponen_ppap->bobot }}%</td>
                        <td style="text-align:right;">{{ $bobot_komponen_dalam_faktor_ppap = round((float)($bobot_komponen_ppap->bobot/$bobot_komponen_dalam_faktor_ppap) * 100,2) ?? '' }} %</td>
                        <td style="text-align:right;">{{ $nk_faktor_ppap =  $nilai_kredit_ppap* $bobot_komponen_dalam_faktor_ppap/100}}</td>
                        <td></td>
                        <td></td>
                    </tr>

                    <tr>
                        <td style="text-align:right;"><b>TOTAL FAKTOR KAP</b></td>
                        <td></td>
                        <td></td>
                        <td style="text-align:right;">{{ $bobot_komponen_faktor_kap_ppap = $bobot_komponen_kap->bobot + $bobot_komponen_ppap->bobot }}%</td>
                        <td style="text-align:right;">{{ $bobot_komponen_dalam_faktor_kap_ppap = $bobot_komponen_dalam_faktor_kap + $bobot_komponen_dalam_faktor_ppap }}%</td>
                        <td style="text-align:right;">{{ $nk_komponen_kap_ppap = $nk_faktor_kap + $nk_faktor_ppap }}</td>
                        <td style="text-align:right;">{{ $nk_faktor_kap_ppap = ($bobot_komponen_faktor_kap_ppap * $bobot_komponen_dalam_faktor_kap_ppap * $nk_komponen_kap_ppap)/ 10000 }}</td>
                        <td style="text-align:center"><b>{{\App\Models\PredikatTks::statusTks($nk_komponen_kap_ppap)->status}}</b></td>
                    </tr>

                    <tr>
                        <td style="text-align:right;"><b></b></td>
                        <td></td>
                        <td></td>
                        <td style="text-align:right;"></td>
                        <td style="text-align:right;"></td>
                        <td style="text-align:right;"></td>
                        <td style="text-align:right;"></td>
                        <td></td>
                    </tr>

                    <!-- III -->

                    <tr>
                        <td><b>III. MANAJEMEN</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>

                    <tr>
                        <td align="center">a. Manajemen Umum</td>
                        <td style="text-align:right;">{{ $manajemen_umum_nilai }}</td>
                        <td style="text-align:right;">{{ $manajemen_umum_nilai_kredit = ($manajemen_umum_nilai >=100) ? 100 : round($manajemen_umum_nilai,2) }}</td>
                        <td style="text-align:right;">{{ $manajemen_umum_bobot }}%</td>
                        <td style="text-align:right;">{{ $bobot_komponen_dalam_faktor_manajemen_umum = ($manajemen_umum_bobot/$manajemen_komponen_faktor) * 100 }} %</td>
                        <td style="text-align:right;">{{ $nk_komponen_manajemen_umum = ($manajemen_umum_nilai_kredit * $bobot_komponen_dalam_faktor_manajemen_umum)/100 }}</td>
                        <td></td>
                        <td></td>
                    </tr>

                    <tr>
                        <td>b. Manajemen Risiko</td>
                        <td style="text-align:right;">{{ $manajemen_resiko_nilai }}</td>
                        <td style="text-align:right;">{{ $manajemen_resiko_nilai_kredit = ($manajemen_resiko_nilai >=100) ? 100 : round($manajemen_resiko_nilai,2) }}</td>
                        <td style="text-align:right;">{{ $manajemen_resiko_bobot }}%</td>
                        <td style="text-align:right;">{{ $bobot_komponen_dalam_faktor_manajemen_resiko = ($manajemen_resiko_bobot/$manajemen_komponen_faktor) *100 }} %</td>
                        <td style="text-align:right;">{{ $nk_komponen_manajemen_resiko = ($manajemen_resiko_nilai_kredit * $bobot_komponen_dalam_faktor_manajemen_resiko)/100 }}</td>
                        <td></td>
                        <td></td>
                    </tr>

                    <tr>
                        <td style="text-align:right;"><b>TOTAL FAKTOR MANAJEMEN</b></td>
                        <td></td>
                        <td></td>
                        <td style="text-align:right;">{{ $total_faktor_manajemen_bobot_komponen = $manajemen_resiko_bobot + $manajemen_umum_bobot }}%</td>
                        <td style="text-align:right;">{{ $total_faktor_manajemen_bobot_komponen_dalam_faktor = $bobot_komponen_dalam_faktor_manajemen_resiko + $bobot_komponen_dalam_faktor_manajemen_umum }}%</td>
                        <td style="text-align:right;">{{ $total_faktor_manajemen_nk_komponen = $nk_komponen_manajemen_resiko + $nk_komponen_manajemen_umum }}</td>
                        <td style="text-align:right;">{{ $nk_faktor_manajemen = ($total_faktor_manajemen_bobot_komponen * $total_faktor_manajemen_bobot_komponen_dalam_faktor * $total_faktor_manajemen_nk_komponen)/10000 }}</td>
                        <td style="text-align:center"><b>{{\App\Models\PredikatTks::statusTks($total_faktor_manajemen_nk_komponen)->status}}</b></td>
                    </tr>

                    <tr>
                        <td style="text-align:right;"><b></b></td>
                        <td></td>
                        <td></td>
                        <td style="text-align:right;"></td>
                        <td style="text-align:right;"></td>
                        <td style="text-align:right;"></td>
                        <td style="text-align:right;"></td>
                        <td></td>
                    </tr>

                    <!-- IV -->

                    <tr>
                        <td><b>IV. RENTABILITAS (EARNINGS)</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>

                    <tr>
                        <td>a. ROA</td>
                        <td style="text-align:right;">{{ $roa_nilai }}%</td>
                        <td style="text-align:right;">{{ $roa_nilai_kredit = ($roa_nilai_kredit >=100) ? 100 : round($roa_nilai_kredit,2) }}</td>
                        <td style="text-align:right;">{{ $roa_bobot }}%</td>
                        <td style="text-align:right;">{{ $bobot_komponen_dalam_faktor_roa = ($roa_bobot == null or $total_bobot_rentabilitas == null) ? 0 :  ($roa_bobot/$total_bobot_rentabilitas) * 100}}%</td>
                        <td style="text-align:right;">{{ $nk_komponen_roa = ($roa_nilai_kredit * $bobot_komponen_dalam_faktor_roa)/100 }}</td>
                        <td></td>
                        <td></td>
                    </tr>

                    <tr>
                        <td>b. BOPO</td>
                        <td style="text-align:right;">{{ $bopo_nilai }}%</td>
                        <td style="text-align:right;">{{ $bopo_nilai_kredit = ($bopo_nilai_kredit >=100) ? 100 : round($bopo_nilai_kredit,2) }}</td>
                        <td style="text-align:right;">{{ $bopo_bobot }}%</td>
                        <td style="text-align:right;">{{ $bobot_komponen_dalam_faktor_bopo = ($bopo_bobot == null or $total_bobot_rentabilitas == null) ? 0 : ($bopo_bobot/$total_bobot_rentabilitas) * 100}}%</td>
                        <td style="text-align:right;">{{ $nk_komponen_bopo = round(($bopo_nilai_kredit * $bobot_komponen_dalam_faktor_bopo)/100,2) }}</td>
                        <td></td>
                        <td></td>
                    </tr>

                    <tr>
                        <td style="text-align:right;"><b>TOTAL FAKTOR RENTABILITAS</b></td>
                        <td></td>
                        <td></td>
                        <td style="text-align:right;">{{ $total_bobot_rentabilitas }}%</td>
                        <td style="text-align:right;">{{ $bobot_komponen_dalam_faktor_rentabilitas = $bobot_komponen_dalam_faktor_roa + $bobot_komponen_dalam_faktor_bopo}}%</td>
                        <td style="text-align:right;">{{ $nk_komponen_rentabilitas = $nk_komponen_roa + $nk_komponen_bopo }}</td>
                        <td style="text-align:right;">{{ $nk_faktor_rentablitias = round(($total_bobot_rentabilitas * $bobot_komponen_dalam_faktor_rentabilitas * $nk_komponen_rentabilitas) /10000,2)}}</td>
                        <td style="text-align:center"><b>{{\App\Models\PredikatTks::statusTks($nk_komponen_rentabilitas)->status}}</b></td>
                    </tr>

                    <tr>
                        <td style="text-align:right;"><b></b></td>
                        <td></td>
                        <td></td>
                        <td style="text-align:right;"></td>
                        <td style="text-align:right;"></td>
                        <td style="text-align:right;"></td>
                        <td style="text-align:right;"></td>
                        <td></td>
                    </tr>

                    <!-- V -->
                    <tr>
                        <td><b>V. LIKUIDITAS</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>

                    <tr>
                        <td align="center">a. Cash Ratio</td>
                        <td style="text-align:right;">{{ $cr_nilai }}%</td>
                        <td style="text-align:right;">{{ $cr_nilai_kredit = ($cr_nilai_kredit >=100) ? 100 : round($cr_nilai_kredit,2) }}</td>
                        <td style="text-align:right;">{{ $cr_bobot }}%</td>
                        <td style="text-align:right;">{{ $bobot_komponen_dalam_faktor_cr = ($cr_bobot == null or $total_bobot_likuiditas == null) ? 0 : ($cr_bobot/$total_bobot_likuiditas) *100}}%</td>
                        <td style="text-align:right;">{{ $nk_komponen_cr = round(($cr_nilai_kredit * $bobot_komponen_dalam_faktor_cr)/100,2) }}</td>
                        <td></td>
                        <td></td>
                    </tr>

                    <tr>
                        <td>b. LDR</td>
                        <td style="text-align:right;">{{ $ldr_nilai }}%</td>
                        <td style="text-align:right;">{{ $ldr_nilai_kredit = ($cr_nilai_kredit >=100) ? 100 : round($cr_nilai_kredit,2) }}</td>
                        <td style="text-align:right;">{{ $ldr_bobot }}%</td>
                        <td style="text-align:right;">{{ $bobot_komponen_dalam_faktor_ldr = ($ldr_bobot == null or $total_bobot_likuiditas == null) ? 0 :($ldr_bobot/$total_bobot_likuiditas) *100}}%</td>
                        <td style="text-align:right;">{{ $nk_komponen_ldr = round(($ldr_nilai_kredit * $bobot_komponen_dalam_faktor_ldr)/100,2) }}</td>
                        <td></td>
                        <td></td>
                    </tr>

                    <tr>
                        <td style="text-align:right;"><b>TOTAL FAKTOR LIKUIDITAS</b></td>
                        <td></td>
                        <td></td>
                        <td style="text-align:right;">{{ $total_bobot_likuiditas }}%</td>
                        <td style="text-align:right;">{{ $bobot_komponen_dalam_faktor_likuiditas = $bobot_komponen_dalam_faktor_cr + $bobot_komponen_dalam_faktor_ldr}}%</td>
                        <td style="text-align:right;">{{ $nk_komponen_likuiditas = $nk_komponen_cr + $nk_komponen_ldr }}</td>
                        <td style="text-align:right;">{{ $nk_faktor_likuiditas = round(($total_bobot_likuiditas * $bobot_komponen_dalam_faktor_likuiditas * $nk_komponen_likuiditas) /10000,2)}}</td>
                        <td style="text-align:center"><b>{{\App\Models\PredikatTks::statusTks($nk_komponen_likuiditas)->status}}</b></td>
                    </tr>

                    <tr>
                        <td style="text-align:right;"><b>JUMLAH FAKTOR CAMEL</b></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td style="text-align:right;">
                            <?php $jumlah_camel = $nk_faktor_car + $nk_faktor_kap_ppap + $nk_faktor_manajemen + $nk_faktor_rentablitias + $nk_faktor_likuiditas; ?>
                            <?php $status = \App\Models\PredikatTks::statusTks($jumlah_camel)->status; ?>
                            @if ($status == 'Sehat')
                            <h4 style="color:green">{{ $jumlah_camel }}</h4>
                            @endif

                            @if ($status == 'Cukup Sehat')
                            <h4 style="color:blue">{{ $jumlah_camel }}</h4>
                            @endif

                            @if ($status == 'Kurang Sehat')
                            <h4 style="color:orange">{{ $jumlah_camel }}</h4>
                            @endif

                            @if ($status == 'Tidak Sehat')
                            <h4 style="color:orange">{{ $jumlah_camel }}</h4>
                            @endif
                        </td>
                        <td>

                            @if ($status == 'Sehat')
                            <h4 style="color:green">{{ $status }}</h4>
                            @endif

                            @if ($status == 'Cukup Sehat')
                            <h4 style="color:blue">{{ $status }}</h4>
                            @endif

                            @if ($status == 'Kurang Sehat')
                            <h4 style="color:orange">{{ $status }}</h4>
                            @endif

                            @if ($status == 'Tidak Sehat')
                            <h4 style="color:orange">{{ $status }}</h4>
                            @endif
                        </td>
                    </tr>

                   <!-- <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>-->

                    <!-- VI -->
                   <!-- <tr>
                        <td><b>VI. NK PENGURANG (PLGGRN BMPK)</b></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>

                    <tr>
                        <td><b>HASIL AKHIR PENILAIAN</b></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>-->
                </table>
            </div>
            
            <div style="height:30px"></div>
                <button onclick="window.print();" class="btn btn-danger">PDF</button>
                <button onclick="tableToExcel(['table'], 'W3C Example Table')" class="btn btn-success">Excel</button>
            </div>
        </div>
    </div>
</div>
@endsection


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.rawgit.com/rainabba/jquery-table2excel/1.1.0/dist/jquery.table2excel.min.js"></script>

<script type="text/javascript">
    var tableToExcel = (function() {
      var uri = 'data:application/vnd.ms-excel;base64,'
        , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'
        , base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
        , format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) }
      return function(table, name) {
        if (!table.nodeType) table = document.getElementById(table)
        var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}
        window.location.href = uri + base64(format(template, ctx))
      }
    })()
</script>
