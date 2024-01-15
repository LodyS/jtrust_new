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
                    <h5 class="mb-0" align="center">LAPORAN ASET PRODUKTIF</h5>
                    <h5 class="mb-0" align="center">{{ strtoupper(\App\Models\InformasiPokokBprPelapor::namaBpr($sandi_bpr)->nama_bpr) }}</h5>
                    <h5 class="mb-0" align="center">TAHUN {{ $tahun ?? '' }}</h5>
                </div>

                <div style="height:30px"></div>
                @include('menu-laporan-triwulan')
            </div>
        </div> 

        <div style="height:10px"></div>

        <form action="{{ url('cari-detail-laporan-aset-produktif') }}" method="POST">@csrf

            <input type="hidden" name="sandi_bpr" value="{{ $bpr->sandi_bpr ?? '' }}">

            <div class="card border-white">
                <div class="card-body">
                    <?php $year = date('Y'); ?>
                    <div class="form-group row">
                        <label class="col-md-3">Pilih Tahun</label>
                            <div class="col-md-7">
                                <select name="tahun" class="form-control select" required id="tahun">
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
        </form>

        <div style="height:30px"></div>

        <div id="table-scroll" class="table-scroll">
            <div class="table-wrap">
                <table class="table table-hover main-table" id="main-table">
                    <thead>

                        <th class="fixed-side" scope="col" >POS</th>
                        <th>Lancar</th>
                        <th>DPK</th>
                        <th>Kurang Lancar</th>
                        <th>Diragukan</th>
                        <th>Macet</th>
                        <th>Jumlah</th>

                        <th>Lancar</th>
                        <th>DPK</th>
                        <th>Kurang Lancar</th>
                        <th>Diragukan</th>
                        <th>Macet</th>
                        <th>Jumlah</th>

                        <th>Lancar</th>
                        <th>DPK</th>
                        <th>Kurang Lancar</th>
                        <th>Diragukan</th>
                        <th>Macet</th>
                        <th>Jumlah</th>

                        <th>Lancar</th>
                        <th>DPK</th>
                        <th>Kurang Lancar</th>
                        <th>Diragukan</th>
                        <th>Macet</th>
                        <th>Jumlah</th>

                        <th>Lancar</th>
                        <th>DPK</th>
                        <th>Kurang Lancar</th>
                        <th>Diragukan</th>
                        <th>Macet</th>
                        <th>Jumlah</th>

                        <th>Lancar</th>
                        <th>DPK</th>
                        <th>Kurang Lancar</th>
                        <th>Diragukan</th>
                        <th>Macet</th>
                        <th>Jumlah</th>

                        <th>Lancar</th>
                        <th>DPK</th>
                        <th>Kurang Lancar</th>
                        <th>Diragukan</th>
                        <th>Macet</th>
                        <th>Jumlah</th>

                        <th>Lancar</th>
                        <th>DPK</th>
                        <th>Kurang Lancar</th>
                        <th>Diragukan</th>
                        <th>Macet</th>
                        <th>Jumlah</th>

                        <th>Lancar</th>
                        <th>DPK</th>
                        <th>Kurang Lancar</th>
                        <th>Diragukan</th>
                        <th>Macet</th>
                        <th>Jumlah</th>

                        <th>Lancar</th>
                        <th>DPK</th>
                        <th>Kurang Lancar</th>
                        <th>Diragukan</th>
                        <th>Macet</th>
                        <th>Jumlah</th>

                        <th>Lancar</th>
                        <th>DPK</th>
                        <th>Kurang Lancar</th>
                        <th>Diragukan</th>
                        <th>Macet</th>
                        <th>Jumlah</th>

                        <th>Lancar</th>
                        <th>DPK</th>
                        <th>Kurang Lancar</th>
                        <th>Diragukan</th>
                        <th>Macet</th>
                        <th>Jumlah</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td class="fixed-side" scope="col"></td>
                        <td colspan="6" style="text-align:center;"><b>Januari</b></td>
                        <td colspan="6" style="text-align:center;"><b>Februari</b></td>
                        <td colspan="6" style="text-align:center;"><b>Maret</b></td>
                        <td colspan="6" style="text-align:center;"><b>April</b></td>
                        <td colspan="6" style="text-align:center;"><b>Mei</b></td>
                        <td colspan="6" style="text-align:center;"><b>Juni</b></td>
                        <td colspan="6" style="text-align:center;"><b>Juli</b></td>
                        <td colspan="6" style="text-align:center;"><b>Agustus</b></td>
                        <td colspan="6" style="text-align:center;"><b>September</b></td>
                        <td colspan="6" style="text-align:center;"><b>Oktober</b></td>
                        <td colspan="6" style="text-align:center;"><b>November</b></td>
                        <td colspan="6" style="text-align:center;"><b>Desember</b></td>
                    </tr>

                    @foreach ($data as $key=> $d)
                    <?php $kunci = array(1,2,3,4,5,6,7,9,10,11,12,13,14,15,16);?>

                    <tr>
                        <td class="fixed-side">{{ $d->pos }}</td>
                        <!-- Januari-->
                        @if(isset($jan[$key]))
                        <td style="text-align:right;">{{ ($key < 4) ? number_format((float)$jan[$key]->l) : '' }}</td>
                        <td style="text-align:right;">{{ ($key < 4) ? number_format((float)$jan[$key]->dpk) : '' }}</td>
                        <td style="text-align:right;">{{ ($key < 4) ? number_format((float)$jan[$key]->kl) : '' }}</td>
                        <td style="text-align:right;">{{ ($key < 4) ? number_format((float)$jan[$key]->d) : '' }}</td>
                        <td style="text-align:right;">{{ ($key < 4) ? number_format((float)$jan[$key]->m) : ''}}</td>
                        <td style="text-align:right;">{{ ($key < 4) ? number_format((float)$jan[$key]->jumlah) : $jan[$key]->jumlah }}</td>
                        @else
                        <td style="text-align:right;"></td>
                        <td style="text-align:right;"></td>
                        <td style="text-align:right;"></td>
                        <td style="text-align:right;"></td>
                        <td style="text-align:right;"></td>
                        <td style="text-align:right;"></td>
                        @endif

                        @if(isset($feb[$key]))
                        <td style="text-align:right;">{{ ($key < 4) ? number_format((float)$feb[$key]->l) : '' }}</td>
                        <td style="text-align:right;">{{ ($key < 4) ? number_format((float)$feb[$key]->dpk) : '' }}</td>
                        <td style="text-align:right;">{{ ($key < 4) ? number_format((float)$feb[$key]->kl) : '' }}</td>
                        <td style="text-align:right;">{{ ($key < 4) ? number_format((float)$feb[$key]->d) : '' }}</td>
                        <td style="text-align:right;">{{ ($key < 4) ? number_format((float)$feb[$key]->m) : ''}}</td>
                        <td style="text-align:right;">{{ ($key < 4) ? number_format((float)$feb[$key]->jumlah) : $feb[$key]->jumlah }}</td>
                        @else
                        <td style="text-align:right;"></td>
                        <td style="text-align:right;"></td>
                        <td style="text-align:right;"></td>
                        <td style="text-align:right;"></td>
                        <td style="text-align:right;"></td>
                        <td style="text-align:right;"></td>
                        @endif

                        @if(isset($mar[$key]))
                        <td style="text-align:right;">{{ ($key < 4) ? number_format((float)$mar[$key]->l) : '' }}</td>
                        <td style="text-align:right;">{{ ($key < 4) ? number_format((float)$mar[$key]->dpk) : '' }}</td>
                        <td style="text-align:right;">{{ ($key < 4) ? number_format((float)$mar[$key]->kl) : '' }}</td>
                        <td style="text-align:right;">{{ ($key < 4) ? number_format((float)$mar[$key]->d) : '' }}</td>
                        <td style="text-align:right;">{{ ($key < 4) ? number_format((float)$mar[$key]->m) : ''}}</td>
                        <td style="text-align:right;">{{ ($key < 4) ? number_format((float)$mar[$key]->jumlah) : $mar[$key]->jumlah }}</td>
                        @else
                        <td style="text-align:right;"></td>
                        <td style="text-align:right;"></td>
                        <td style="text-align:right;"></td>
                        <td style="text-align:right;"></td>
                        <td style="text-align:right;"></td>
                        <td style="text-align:right;"></td>
                        @endif

                        @if(isset($apr[$key]))
                        <td style="text-align:right;">{{ ($key < 4) ? number_format((float)$apr[$key]->l) : '' }}</td>
                        <td style="text-align:right;">{{ ($key < 4) ? number_format((float)$apr[$key]->dpk) : '' }}</td>
                        <td style="text-align:right;">{{ ($key < 4) ? number_format((float)$apr[$key]->kl) : '' }}</td>
                        <td style="text-align:right;">{{ ($key < 4) ? number_format((float)$apr[$key]->d) : '' }}</td>
                        <td style="text-align:right;">{{ ($key < 4) ? number_format((float)$apr[$key]->m) : ''}}</td>
                        <td style="text-align:right;">{{ ($key < 4) ? number_format((float)$apr[$key]->jumlah) : $apr[$key]->jumlah }}</td>
                        @else
                        <td style="text-align:right;"></td>
                        <td style="text-align:right;"></td>
                        <td style="text-align:right;"></td>
                        <td style="text-align:right;"></td>
                        <td style="text-align:right;"></td>
                        <td style="text-align:right;"></td>
                        @endif

                        @if(isset($mei[$key]))
                        <td style="text-align:right;">{{ ($key < 4) ? number_format((float)$mei[$key]->l) : '' }}</td>
                        <td style="text-align:right;">{{ ($key < 4) ? number_format((float)$mei[$key]->dpk) : '' }}</td>
                        <td style="text-align:right;">{{ ($key < 4) ? number_format((float)$mei[$key]->kl) : '' }}</td>
                        <td style="text-align:right;">{{ ($key < 4) ? number_format((float)$mei[$key]->d) : '' }}</td>
                        <td style="text-align:right;">{{ ($key < 4) ? number_format((float)$mei[$key]->m) : ''}}</td>
                        <td style="text-align:right;">{{ ($key < 4) ? number_format((float)$mei[$key]->jumlah) : $mei[$key]->jumlah }}</td>
                        @else
                        <td style="text-align:right;"></td>
                        <td style="text-align:right;"></td>
                        <td style="text-align:right;"></td>
                        <td style="text-align:right;"></td>
                        <td style="text-align:right;"></td>
                        <td style="text-align:right;"></td>
                        @endif

                        @if(isset($jun[$key]))
                        <td style="text-align:right;">{{ ($key < 4) ? number_format((float)$jun[$key]->l) : '' }}</td>
                        <td style="text-align:right;">{{ ($key < 4) ? number_format((float)$jun[$key]->dpk) : '' }}</td>
                        <td style="text-align:right;">{{ ($key < 4) ? number_format((float)$jun[$key]->kl) : '' }}</td>
                        <td style="text-align:right;">{{ ($key < 4) ? number_format((float)$jun[$key]->d) : '' }}</td>
                        <td style="text-align:right;">{{ ($key < 4) ? number_format((float)$jun[$key]->m) : ''}}</td>
                        <td style="text-align:right;">{{ ($key < 4) ? number_format((float)$jun[$key]->jumlah) : $jun[$key]->jumlah }}</td>
                        @else
                        <td style="text-align:right;"></td>
                        <td style="text-align:right;"></td>
                        <td style="text-align:right;"></td>
                        <td style="text-align:right;"></td>
                        <td style="text-align:right;"></td>
                        <td style="text-align:right;"></td>
                        @endif

                        @if(isset($jul[$key]))
                        <td style="text-align:right;">{{ ($key < 4) ? number_format((float)$jul[$key]->l) : '' }}</td>
                        <td style="text-align:right;">{{ ($key < 4) ? number_format((float)$jul[$key]->dpk) : '' }}</td>
                        <td style="text-align:right;">{{ ($key < 4) ? number_format((float)$jul[$key]->kl) : '' }}</td>
                        <td style="text-align:right;">{{ ($key < 4) ? number_format((float)$jul[$key]->d) : '' }}</td>
                        <td style="text-align:right;">{{ ($key < 4) ? number_format((float)$jul[$key]->m) : ''}}</td>
                        <td style="text-align:right;">{{ ($key < 4) ? number_format((float)$jul[$key]->jumlah) : $jul[$key]->jumlah }}</td>
                        @else
                        <td style="text-align:right;"></td>
                        <td style="text-align:right;"></td>
                        <td style="text-align:right;"></td>
                        <td style="text-align:right;"></td>
                        <td style="text-align:right;"></td>
                        <td style="text-align:right;"></td>
                        @endif

                        @if(isset($ags[$key]))
                        <td style="text-align:right;">{{ ($key < 4) ? number_format((float)$ags[$key]->l) : '' }}</td>
                        <td style="text-align:right;">{{ ($key < 4) ? number_format((float)$ags[$key]->dpk) : '' }}</td>
                        <td style="text-align:right;">{{ ($key < 4) ? number_format((float)$ags[$key]->kl) : '' }}</td>
                        <td style="text-align:right;">{{ ($key < 4) ? number_format((float)$ags[$key]->d) : '' }}</td>
                        <td style="text-align:right;">{{ ($key < 4) ? number_format((float)$ags[$key]->m) : ''}}</td>
                        <td style="text-align:right;">{{ ($key < 4) ? number_format((float)$ags[$key]->jumlah) : $ags[$key]->jumlah }}</td>
                        @else
                        <td style="text-align:right;"></td>
                        <td style="text-align:right;"></td>
                        <td style="text-align:right;"></td>
                        <td style="text-align:right;"></td>
                        <td style="text-align:right;"></td>
                        <td style="text-align:right;"></td>
                        @endif

                        @if(isset($sep[$key]))
                        <td style="text-align:right;">{{ ($key < 4) ? number_format((float)$sep[$key]->l) : '' }}</td>
                        <td style="text-align:right;">{{ ($key < 4) ? number_format((float)$sep[$key]->dpk) : '' }}</td>
                        <td style="text-align:right;">{{ ($key < 4) ? number_format((float)$sep[$key]->kl) : '' }}</td>
                        <td style="text-align:right;">{{ ($key < 4) ? number_format((float)$sep[$key]->d) : '' }}</td>
                        <td style="text-align:right;">{{ ($key < 4) ? number_format((float)$sep[$key]->m) : ''}}</td>
                        <td style="text-align:right;">{{ ($key < 4) ? number_format((float)$sep[$key]->jumlah) : $sep[$key]->jumlah }}</td>
                        @else
                        <td style="text-align:right;"></td>
                        <td style="text-align:right;"></td>
                        <td style="text-align:right;"></td>
                        <td style="text-align:right;"></td>
                        <td style="text-align:right;"></td>
                        <td style="text-align:right;"></td>
                        @endif

                        @if(isset($okt[$key]))
                        <td style="text-align:right;">{{ ($key < 4) ? number_format((float)$okt[$key]->l) : '' }}</td>
                        <td style="text-align:right;">{{ ($key < 4) ? number_format((float)$okt[$key]->dpk) : '' }}</td>
                        <td style="text-align:right;">{{ ($key < 4) ? number_format((float)$okt[$key]->kl) : '' }}</td>
                        <td style="text-align:right;">{{ ($key < 4) ? number_format((float)$okt[$key]->d) : '' }}</td>
                        <td style="text-align:right;">{{ ($key < 4) ? number_format((float)$okt[$key]->m) : ''}}</td>
                        <td style="text-align:right;">{{ ($key < 4) ? number_format((float)$okt[$key]->jumlah) : $okt[$key]->jumlah }}</td>
                        @else
                        <td style="text-align:right;"></td>
                        <td style="text-align:right;"></td>
                        <td style="text-align:right;"></td>
                        <td style="text-align:right;"></td>
                        <td style="text-align:right;"></td>
                        <td style="text-align:right;"></td>
                        @endif

                        @if(isset($nov[$key]))
                        <td style="text-align:right;">{{ ($key < 4) ? number_format((float)$nov[$key]->l) : '' }}</td>
                        <td style="text-align:right;">{{ ($key < 4) ? number_format((float)$nov[$key]->dpk) : '' }}</td>
                        <td style="text-align:right;">{{ ($key < 4) ? number_format((float)$nov[$key]->kl) : '' }}</td>
                        <td style="text-align:right;">{{ ($key < 4) ? number_format((float)$nov[$key]->d) : '' }}</td>
                        <td style="text-align:right;">{{ ($key < 4) ? number_format((float)$nov[$key]->m) : ''}}</td>
                        <td style="text-align:right;">{{ ($key < 4) ? number_format((float)$nov[$key]->jumlah) : $nov[$key]->jumlah }}</td>
                        @else
                        <td style="text-align:right;"></td>
                        <td style="text-align:right;"></td>
                        <td style="text-align:right;"></td>
                        <td style="text-align:right;"></td>
                        <td style="text-align:right;"></td>
                        <td style="text-align:right;"></td>
                        @endif

                        @if(isset($des[$key]))
                        <td style="text-align:right;">{{ ($key < 4) ? number_format((float)$des[$key]->l) : '' }}</td>
                        <td style="text-align:right;">{{ ($key < 4) ? number_format((float)$des[$key]->dpk) : '' }}</td>
                        <td style="text-align:right;">{{ ($key < 4) ? number_format((float)$des[$key]->kl) : '' }}</td>
                        <td style="text-align:right;">{{ ($key < 4) ? number_format((float)$des[$key]->d) : '' }}</td>
                        <td style="text-align:right;">{{ ($key < 4) ? number_format((float)$des[$key]->m) : ''}}</td>
                        <td style="text-align:right;">{{ ($key < 4) ? number_format((float)$des[$key]->jumlah) : $des[$key]->jumlah }}</td>
                        @else
                        <td style="text-align:right;"></td>
                        <td style="text-align:right;"></td>
                        <td style="text-align:right;"></td>
                        <td style="text-align:right;"></td>
                        <td style="text-align:right;"></td>
                        <td style="text-align:right;"></td>
                        @endif

                    </tr>
                    @endforeach
                    </tbody>

                </table>

                <div style="height:20px"></div>
                <button onclick="tableToExcel(['main-table'], 'W3C Example Table')" class="btn btn-success">Excel</button>

            </div>
        </div>
    </div>
</div>
@endsection

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
