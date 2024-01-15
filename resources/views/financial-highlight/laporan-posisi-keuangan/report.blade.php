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

<div class="card border-white">
    <div class="card-body">

        <div class="card border-white">
			<div class="card-body">
                <div class="w-sm-100 mr-auto">
                    <h5 class="mb-0" align="center">LAPORAN POSISI KEUANGAN </h5>
                    <h5 class="mb-0" align="center">{{ strtoupper($bpr->nama_bpr) ?? '' }}</h5>
                </div>

                <div style="height:30px"></div>
                @include('menu-laporan-triwulan')
            </div> 
        </div> 

        <div style="height:10px"></div>

        <form action="{{ url('cari-detail-laporan-posisi-keuangan') }}" method="POST">@csrf

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

                    <div>
                        <button type="submit" class="btn btn-primary">Search</button>
                    </div>
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
                                        <th scope="col" colspan="2" style="text-align:center;">Januari</th>
                                        <th scope="col" colspan="2" style="text-align:center;">Februari</th>
                                        <th scope="col" colspan="2" style="text-align:center;">Maret</th>
                                        <th scope="col" colspan="2" style="text-align:center;">April</th>
                                        <th scope="col" colspan="2" style="text-align:center;">Mei</th>
                                        <th scope="col" colspan="2" style="text-align:center;">Juni</th>
                                        <th scope="col" colspan="2" style="text-align:center;">Juli</th>
                                        <th scope="col" colspan="2" style="text-align:center;">Agustus</th>
                                        <th scope="col" colspan="2" style="text-align:center;">September</th>
                                        <th scope="col" colspan="2" style="text-align:center;">Oktober</th>
                                        <th scope="col" colspan="2" style="text-align:center;">November</th>
                                        <th scope="col" colspan="2" style="text-align:center;">Desember</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr>
                                        <td class="fixed-side" scope="col"></td>
                                        <td style="text-align:center;"  scope="col"><b>{{ $tahun }}</b></td>
                                        <td style="text-align:center;"  scope="col"><b>{{ $tahun - 1}}</b></td>

                                        <td style="text-align:center;"  scope="col"><b>{{ $tahun }}</b></td>
                                        <td style="text-align:center;"  scope="col"><b>{{ $tahun - 1}}</b></td>

                                        <td style="text-align:center;"  scope="col"><b>{{ $tahun }}</b></td>
                                        <td style="text-align:center;"  scope="col"><b>{{ $tahun - 1}}</b></td>

                                        <td style="text-align:center;"  scope="col"><b>{{ $tahun }}</b></td>
                                        <td style="text-align:center;"  scope="col"><b>{{ $tahun - 1}}</b></td>

                                        <td style="text-align:center;"  scope="col"><b>{{ $tahun }}</b></td>
                                        <td style="text-align:center;"  scope="col"><b>{{ $tahun - 1}}</b></td>

                                        <td style="text-align:center;" scope="col"><b>{{ $tahun }}</b></td>
                                        <td style="text-align:center;"  scope="col"><b>{{ $tahun - 1}}</b></td>

                                        <td style="text-align:center;"  scope="col"><b>{{ $tahun }}</b></td>
                                        <td style="text-align:center;"  scope="col"><b>{{ $tahun - 1}}</b></td>

                                        <td style="text-align:center;"  scope="col"><b>{{ $tahun }}</b></td>
                                        <td style="text-align:center;"  scope="col"><b>{{ $tahun - 1}}</b></td>

                                        <td style="text-align:center;"  scope="col"><b>{{ $tahun }}</b></td>
                                        <td style="text-align:center;"  scope="col"><b>{{ $tahun - 1}}</b></td>

                                        <td style="text-align:center;"  scope="col"><b>{{ $tahun }}</b></td>
                                        <td style="text-align:center;"  scope="col"><b>{{ $tahun - 1}}</b></td>

                                        <td style="text-align:center;"  scope="col"><b>{{ $tahun }}</b></td>
                                        <td style="text-align:center;"  scope="col"><b>{{ $tahun - 1}}</b></td>

                                        <td style="text-align:center;"  scope="col"><b>{{ $tahun }}</b></td>
                                        <td style="text-align:center;"  scope="col"><b>{{ $tahun - 1}}</b></td>
                                    </tr>

                                    @foreach ($data as $key=> $d)
                                    <tr>
                                        <th class="fixed-side" style="font-size:11;">{{ $d->pos }}</th>
                                        <td style="text-align:right; ">Rp. {{ ($d->januari == 0) ? 0 : number_format($d->januari).','.'000' }}</td>
                                        <td style="text-align:right; ">Rp. {{ ($d->januari_tahun_lalu == 0) ? 0 : number_format($d->januari_tahun_lalu).','.'000' }}</td>
                                        <td style="text-align:right; ">Rp. {{ ($d->februari == 0) ? 0 : number_format($d->februari).','.'000' }}</td>
                                        <td style="text-align:right; ">Rp. {{ ($d->februari_tahun_lalu == 0) ? 0 : number_format($d->februari_tahun_lalu).','.'000' }}</td>
                                        <td style="text-align:right; ">Rp. {{ ($d->maret == 0) ? 0 : number_format($d->maret).','.'000' }}</td>
                                        <td style="text-align:right; ">Rp. {{ ($d->maret_tahun_lalu == 0) ? 0 : number_format($d->maret_tahun_lalu).','.'000' }}</td>
                                        <td style="text-align:right; ">Rp. {{ ($d->april == 0) ? 0 : number_format($d->april).','.'000' }}</td>
                                        <td style="text-align:right; ">Rp. {{ ($d->april_tahun_lalu == 0) ? 0 : number_format($d->april_tahun_lalu).','.'000' }}</td>
                                        <td style="text-align:right; ">Rp. {{ ($d->mei == 0) ? 0 : number_format($d->mei).','.'000' }}</td>
                                        <td style="text-align:right; ">Rp. {{ ($d->mei_tahun_lalu == 0) ? 0 : number_format($d->mei_tahun_lalu).','.'000' }}</td>
                                        <td style="text-align:right; ">Rp. {{ ($d->juni == 0) ? 0 : number_format($d->juni).','.'000' }}</td>
                                        <td style="text-align:right; ">Rp. {{ ($d->juni_tahun_lalu ==0) ? 0 : number_format($d->juni_tahun_lalu).','.'000' }}</td>
                                        <td style="text-align:right; ">Rp. {{ ($d->juli == 0) ? 0 : number_format($d->juli).','.'000' }}</td>
                                        <td style="text-align:right; ">Rp. {{ ($d->juli_tahun_lalu ==0) ? 0 : number_format($d->juli_tahun_lalu).','.'000' }}</td>
                                        <td style="text-align:right; ">Rp. {{ ($d->agustus == 0) ? 0 : number_format($d->agustus).','.'000' }}</td>
                                        <td style="text-align:right; ">Rp. {{ ($d->agustus_tahun_lalu ==0) ? 0 : number_format($d->agustus_tahun_lalu).','.'000' }}</td>
                                        <td style="text-align:right; ">Rp. {{ ($d->september == 0) ? 0 : number_format($d->september).','.'000' }}</td>
                                        <td style="text-align:right; ">Rp. {{ ($d->september_tahun_lalu == 0) ? 0 : number_format($d->september_tahun_lalu).','.'000' }}</td>
                                        <td style="text-align:right; ">Rp. {{ ($d->oktober == 0) ? 0 : number_format($d->oktober).','.'000' }}</td>
                                        <td style="text-align:right; ">Rp. {{ ($d->oktober_tahun_lalu == 0) ? 0 : number_format($d->oktober_tahun_lalu).','.'000' }}</td>
                                        <td style="text-align:right; ">Rp. {{ ($d->november == 0) ? 0 : number_format($d->november).','.'000' }}</td>
                                        <td style="text-align:right; ">Rp. {{ ($d->november_tahun_lalu == 0) ? 0 : number_format($d->november_tahun_lalu).','.'000' }}</td>
                                        <td style="text-align:right; ">Rp. {{ ($d->desember == 0) ? 0 : number_format($d->desember).','.'000'}}</td>
                                        <td style="text-align:right; ">Rp. {{ ($d->desember_tahun_lalu == 0) ? 0 : number_format($d->desember_tahun_lalu).','.'000' }}</td>
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
