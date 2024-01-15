@extends('tema.app')
@section('content')

<style>
.container {
    position: relative;
    display: flex;
    align-items: flex-start;
}

.table-scroll {
	position:relative;
	max-width:auto;
	margin:auto;
	overflow:hidden;
	border:1px solid #000;
}
.table-wrap {
	width:100%;
	overflow:auto;
}
.table-scroll table {
	width:100%;
	margin:auto;
	border-collapse:separate;
	border-spacing:0;
}
.table-scroll th, .table-scroll td {
	padding:5px 10px;
	border:1px solid #000;
	background:#fff;
	white-space:nowrap;
	vertical-align:top;
}
.table-scroll thead, .table-scroll tfoot {
	background:#f9f9f9;
}
.clone {
	position:absolute;
	top:0;
	left:0;
	pointer-events:none;
}
.clone th, .clone td {
	visibility:hidden
}
.clone td, .clone th {
	border-color:transparent
}
.clone tbody th {
	visibility:visible;
	color:black;
}
.clone .fixed-side {
	border:1px solid #000;
	background:#eee;
	visibility:visible;
}
.clone thead, .clone tfoot{background:transparent;}

</style>

<div class="col-md-12">
    <div class="card border-white">
        <div class="card-body">

            <div class="card border-white">
                <div class="card-body">
                    <div class="w-sm-100 mr-auto">
                        <h5 class="mb-0" align="center">LAPORAN LABA RUGI TAHUN </h5>
                        <h5 class="mb-0" align="center">{{ strtoupper($bpr->nama_bpr) ?? '' }}</h5>
                    </div>

                    <div style="height:30px"></div>
                    @include('menu-laporan-triwulan')
                </div>
            </div>
            
            <div style="height:10px"></div>

            <form action="{{ url('cari-detail-laporan-laba-rugi') }}" method="POST">{{ @csrf_field() }}

                <input type="hidden" name="sandi_bpr" value="{{ $bpr->sandi_bpr ?? '' }}">

                <div class="card border-white">
                    <div class="card-body">
                        <?php $year = date('Y'); ?>
                        <div class="form-group row">
                            <label class="col-md-3">Pilih Tahun</label>
                                <div class="col-md-7">
                                <select name="tahun" class="form-control select" required>
                                    <option value="">Pilih</option>
                                    @for($i=2019; $i<=$year; $i++)
                                    <option value="{{ $i }}">{{ $i}} </option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Search</button>
                    </div> 
                </div>

                <div style="height:10px"></div>

                <div class="card border-white">
                    <div class="card-body">
                        <div id="table-scroll" class="table-scroll">
                            <div class="table-wrap">
                                <table class="table table-hover main-table" id="main-table">
                                    <thead>
                                        <tr>
                                            <th class="fixed-side" scope="col" >POS</th>
                                            <th colspan="2" style="text-align:center;">Januari</th>
                                            <th colspan="2" style="text-align:center;">Februari</th>
                                            <th colspan="2" style="text-align:center;">Maret</th>
                                            <th colspan="2" style="text-align:center;">April</th>
                                            <th colspan="2" style="text-align:center;">Mei</th>
                                            <th colspan="2" style="text-align:center;">Juni</th>
                                            <th colspan="2" style="text-align:center;">Juli</th>
                                            <th colspan="2" style="text-align:center;">Agustus</th>
                                            <th colspan="2" style="text-align:center;">September</th>
                                            <th colspan="2" style="text-align:center;">Oktober</th>
                                            <th colspan="2" style="text-align:center;">November</th>
                                            <th colspan="2" style="text-align:center;">Desember</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <tr>
                                            <td class="fixed-side" scope="col"></td>
                                            <td style="text-align:center;"><b>{{ $tahun }}</b></td>
                                            <td style="text-align:center;"><b>{{ $tahun - 1}}</b></td>

                                            <td style="text-align:center;"><b>{{ $tahun }}</b></td>
                                            <td style="text-align:center;"><b>{{ $tahun - 1}}</b></td>

                                            <td style="text-align:center;"><b>{{ $tahun }}</b></td>
                                            <td style="text-align:center;"><b>{{ $tahun - 1}}</b></td>

                                            <td style="text-align:center;"><b>{{ $tahun }}</b></td>
                                            <td style="text-align:center;"><b>{{ $tahun - 1}}</b></td>

                                            <td style="text-align:center;"><b>{{ $tahun }}</b></td>
                                            <td style="text-align:center;"><b>{{ $tahun - 1}}</b></td>

                                            <td style="text-align:center;"><b>{{ $tahun }}</b></td>
                                            <td style="text-align:center;"><b>{{ $tahun - 1}}</b></td>

                                            <td style="text-align:center;"><b>{{ $tahun }}</b></td>
                                            <td style="text-align:center;"><b>{{ $tahun - 1}}</b></td>

                                            <td style="text-align:center;"><b>{{ $tahun }}</b></td>
                                            <td style="text-align:center;"><b>{{ $tahun - 1}}</b></td>

                                            <td style="text-align:center;"><b>{{ $tahun }}</b></td>
                                            <td style="text-align:center;"><b>{{ $tahun - 1}}</b></td>

                                            <td style="text-align:center;"><b>{{ $tahun }}</b></td>
                                            <td style="text-align:center;"><b>{{ $tahun - 1}}</b></td>

                                            <td style="text-align:center;"><b>{{ $tahun }}</b></td>
                                            <td style="text-align:center;"><b>{{ $tahun - 1}}</b></td>

                                            <td style="text-align:center;"><b>{{ $tahun }}</b></td>
                                            <td style="text-align:center;"><b>{{ $tahun - 1}}</b></td>
                                        </tr>

                                        @foreach ($data->where('pos', '<>', null) as $key=> $d)
                                        <tr>
                                            <th class="fixed-side" style="font-size:11px">{{ $d->pos }}</th>
                                            <td style="text-align:right;">Rp. {{ empty($jan[$key]) ? 0 : number_format((float)$jan[$key]->nominal) }}</td>
                                            <td style="text-align:right;">Rp. {{ empty($jan_b[$key]) ? 0 : number_format((float)$jan_b[$key]->nominal) }}</td>
                                            <td style="text-align:right;">Rp. {{ empty($feb[$key]) ? 0 : number_format((float)$feb[$key]->nominal) }}</td>
                                            <td style="text-align:right;">Rp. {{ empty($feb_b[$key]) ? 0 : number_format((float)$feb_b[$key]->nominal) }}</td>
                                            <td style="text-align:right;">Rp. {{ empty($maret[$key]) ? 0 : number_format((float)$maret[$key]->nominal) }}</td>
                                            <td style="text-align:right;">Rp. {{ empty($maret_b[$key]) ? 0 : number_format((float)$maret_b[$key]->nominal) }}</td>
                                            <td style="text-align:right;">Rp. {{ empty($april[$key]) ? 0 : number_format((float)$april[$key]->nominal) }}</td>
                                            <td style="text-align:right;">Rp. {{ empty($april_b[$key]) ? 0 : number_format((float)$april_b[$key]->nominal) }}</td>
                                            <td style="text-align:right;">Rp. {{ empty($mei[$key]) ? 0 : number_format((float)$mei[$key]->nominal) }}</td>
                                            <td style="text-align:right;">Rp. {{ empty($mei_b[$key]) ? 0 : number_format((float)$mei_b[$key]->nominal) }}</td>
                                            <td style="text-align:right;">Rp. {{ empty($juni[$key]) ? 0 : number_format((float)$juni[$key]->nominal) }}</td>
                                            <td style="text-align:right;">Rp. {{ empty($juni_b[$key]) ? 0 : number_format((float)$juni_b[$key]->nominal) }}</td>
                                            <td style="text-align:right;">Rp. {{ empty($juli[$key]) ? 0 : number_format((float)$juli[$key]->nominal) }}</td>
                                            <td style="text-align:right;">Rp. {{ empty($juli_b[$key]) ? 0 : number_format((float)$juli_b[$key]->nominal) }}</td>
                                            <td style="text-align:right;">Rp. {{ empty($agustus[$key]) ? 0 : number_format((float)$agustus[$key]->nominal) }}</td>
                                            <td style="text-align:right;">Rp. {{ empty($agustus_b[$key]) ? 0 : number_format((float)$agustus_b[$key]->nominal) }}</td>
                                            <td style="text-align:right;">Rp. {{ empty($september[$key]) ? 0 : number_format((float)$september[$key]->nominal) }}</td>
                                            <td style="text-align:right;">Rp. {{ empty($september_b[$key]) ? 0 : number_format((float)$september_b[$key]->nominal) }}</td>
                                            <td style="text-align:right;">Rp. {{ empty($oktober[$key]) ? 0 : number_format((float)$oktober[$key]->nominal) }}</td>
                                            <td style="text-align:right;">Rp. {{ empty($oktober_b[$key]) ? 0 : number_format((float)$oktober_b[$key]->nominal) }}</td>
                                            <td style="text-align:right;">Rp. {{ empty($november[$key]) ? 0 : number_format((float)$november[$key]->nominal) }}</td>
                                            <td style="text-align:right;">Rp. {{ empty($november_b[$key]) ? 0 : number_format((float)$november_b[$key]->nominal) }}</td>
                                            <td style="text-align:right;">Rp. {{ empty($desember[$key]) ? 0 : number_format((float)$desember[$key]->nominal) }}</td>
                                            <td style="text-align:right;">Rp. {{ empty($desember_b[$key]) ? 0 : number_format((float)$desember_b[$key]->nominal) }}</td>
                                        </tr>
                                    </tbody>
                                    @endforeach
                                </table>
                            </div>
                        </div>

                        <div style="height:20px"></div>
                        <button onclick="tableToExcel(['main-table'], 'W3C Example Table')" class="btn btn-success">Excel</button>
                    </div>
                </div> 
            </form>
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
