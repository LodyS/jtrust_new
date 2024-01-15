@extends('tema.app')
@section('content')

<div class="col-md-12">
    <div class="card border-white">
        <div class="card-body">

            <div class="w-sm-10.30 mr-auto">
                <h5 class="mb-0" align="center">FINANCIAL HIGHLIGHT</h5>
                <h5 class="mb-0" align="center">{{ strtoupper(\App\Models\InformasiPokokBprPelapor::namaBpr($sandi_bpr)->nama_bpr) ?? '' }}</h5>
            </div>

            <div style="height:30px"></div>
            @include('menu-laporan-triwulan')
            <div style="height:30px"></div>
            

            <div id="test">

                <table class="table  table-sm" width="100%" id="table">
                    <tr>
                        <td style="text-align:center;"><b>KETERANGAN</b></td>
                        <td colspan="{{ isset($bulan_berjalan->sub_jenis) ? '4' : '3'}} " style="text-align:center;"><b>REALISASI</b></td>
                        <td colspan="2" style="text-align:center;"><b>RKAT</b></td>
                    </tr>

                    <tr>
                        <td></td>

                        @if(isset($bulan_berjalan->sub_jenis))
                            <td style="font-size: 10.3px;"><b>{{ tanggalAkhirBulan($bulan_berjalan->bulan) }} {{ bulan($bulan_berjalan->bulan) }} {{ $bulan_berjalan->tahun ?? '' }}</b></td>
                        @endif

                        <td style="font-size: 10.3px;"><b>31 Desember {{ $tahun_ini  }}</b></td>
                        <td style="font-size: 10.3px;"><b>31 Desember {{ ($tahun_ini == null) ? '' : $tahun_ini - 1}}</b></td>
                        <td style="font-size: 10.3px;"><b>31 Desember {{ ($tahun_ini == null) ? '' : $tahun_ini - 2}}</b></td>


                        <td style="font-size: 10.3px;"><b>31 Desember {{ $tahun_max_rkat ?? '' }}</b></td>
                        <td style="font-size: 10.3px;"><b>31 Desember {{ $tahun_rkat_sebelumnya }}</b></td>
                    </tr>

                    <tr>
                        <td></td>
                        @if(isset($bulan_berjalan->sub_jenis))
                        <td style="font-size: 10.3px;"><b>OJK PUBLIKASI</b></td>
                        @endif
                        <td style="font-size: 10.3px;"><b>AUDIT</b></td>
                        <td style="font-size: 10.3px;"><b>AUDIT</b></td>
                        <td style="font-size: 10.3px;"><b>AUDIT<b></td>

                        <td style="font-size: 10.3px;"><b>DISAMPAIKAN KE OJK</b></td>
                        <td style="font-size: 10.3px;"><b>DISAMPAIKAN KE OJK</b></td>
                    </tr>

                    @foreach($data as $d)
                    <tr>
                        @if($d->keterangan == 'EBITDA (Earning Before Interest & Tax, Depreciation & Amortisation)')
                        <td style="font-size:10.3px;">EBITDA <br/>(Earning Before Interest & Tax, Depreciation & Amortisation)</td>
                        @else
                        <td style="font-size: 10.3px;">{{ $d->keterangan }}</td>
                        @endif

                        @if(isset($bulan_berjalan->sub_jenis))
                        <td style="text-align:right; font-size: 10.3px;">{{ $d->e_nominal }}</td>
                        @endif

                        <td style="text-align:right; font-size: 10.3px;">{{ $d->b_nominal }}</td>
                        <td style="text-align:right; font-size: 10.3px;">{{ $d->d_nominal }}</td>

                        <td style="text-align:right; font-size: 10.3px;">{{ $d->c_nominal }}</td>
                        <td style="text-align:right; font-size: 10.3px;">{{ $d->g_nominal }}</td>
                        <td style="text-align:right; font-size: 10.3px;">{{ $d->f_nominal }}</td>

                    </tr>
                    @endforeach
                </table>
            </div>

            <div style="height:20px"></div>
            <button onclick="tableToExcel(['table'], 'W3C Example Table')" class="btn btn-success">Excel</button>

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

jQuery(document).ready(function() {
   jQuery(".main-table").clone(true).appendTo('#table-scroll').addClass('clone');
});

</script>
