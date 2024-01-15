@extends('tema.app')
@section('content')

<style>
table
{
    border-collapse: collapse;
    border-spacing: 0;
    /*width: 100%; */
    border: 1px solid #ddd;
}

th, td
{
    text-align: left;
    padding: 8px;
}

tr:nth-child(even)
{
    background-color: #f2f2f2
}
</style>


<div class="card border-white" style="width: 100rem;">
    <div class="card-body">

        <div class="card border-white">
            <div class="card-body">
                <div class="w-sm-80 mr-auto">
                    <h5 class="mb-0" align="center">HISTORI RATIO TAHUN {{ $tahun }}</h5>
                    <h5 class="mb-0" align="center">{{ strtoupper($bpr->nama_bpr ?? $bprr->nama_bpr) }}</h5>
                </div>

                <div style="height:30px"></div>
                @include('menu-laporan-triwulan')
              
                <div style="height:10px"></div>

                <form action="{{ url('cari-histori-ratio') }}" method="POST">{{ @csrf_field() }}

                    <input type="hidden" name="sandi_bpr" value="{{ $bpr->sandi_bpr ?? $bprr->sandi_bpr }}">

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

                    <div style="height:30px"></div>

                    <button type="submit" class="btn btn-primary">Search</button>
                </form>
            </div> 
        </div> 

        <div style="height:30px"></div>

        <div style="overflow-x:auto;">
            <table class="table table-bordered table-sm">
                <tr>
                    <th style="font-size: 11px;">POS</th>
                    <th style="font-size: 11px;">Januari</th>
                    <th style="font-size: 11px;">Februari</th>
                    <th style="font-size: 11px;">Maret</th>
                    <th style="font-size: 11px;">April</th>
                    <th style="font-size: 11px;">Mei</th>
                    <th style="font-size: 11px;">Juni</th>
                    <th style="font-size: 11px;">Juli</th>
                    <th style="font-size: 11px;">Agustus</th>
                    <th style="font-size: 11px;">September</th>
                    <th style="font-size: 11px;">Oktober</th>
                    <th style="font-size: 11px;">November</th>
                    <th style="font-size: 11px;">Desember</th>
                </tr>

                @foreach ($data as $key=> $d)
                    {{--@if($key < 5)
                    @else--}}
                    <tr>
                        <td style="font-size: 11px;">{{ $d->pos }}</td>
                        <td style="text-align:right; font-size: 11px;">{{ ($key <9) ? number_format($d->jumlah_januari) : $d->jumlah_januari. '%' }} </td>
                        <td style="text-align:right; font-size: 11px;">{{ ($key <9) ? number_format($d->jumlah_februari) : $d->jumlah_februari. '%' }} </td>
                        <td style="text-align:right; font-size: 11px;">{{ ($key <9) ? number_format($d->jumlah_maret) : $d->jumlah_maret. '%' }} </td>
                        <td style="text-align:right; font-size: 11px;">{{ ($key <9) ? number_format($d->jumlah_april) : $d->jumlah_april. '%' }} </td>
                        <td style="text-align:right; font-size: 11px;">{{ ($key <9) ? number_format($d->jumlah_mei) : $d->jumlah_mei. '%' }} </td>
                        <td style="text-align:right; font-size: 11px;">{{ ($key <9) ? number_format($d->jumlah_juni) : $d->jumlah_juni. '%' }} </td>
                        <td style="text-align:right; font-size: 11px;">{{ ($key <9) ? number_format($d->jumlah_juli) : $d->jumlah_juli. '%' }} </td>
                        <td style="text-align:right; font-size: 11px;">{{ ($key <9) ? number_format($d->jumlah_agustus) : $d->jumlah_agustus. '%' }} </td>
                        <td style="text-align:right; font-size: 11px;">{{ ($key <9) ? number_format($d->jumlah_september) : $d->jumlah_september. '%' }} </td>
                        <td style="text-align:right; font-size: 11px;">{{ ($key <9) ? number_format($d->jumlah_oktober) : $d->jumlah_oktober. '%' }} </td>
                        <td style="text-align:right; font-size: 11px;">{{ ($key <9) ? number_format($d->jumlah_november) : $d->jumlah_november. '%' }} </td>
                        <td style="text-align:right; font-size: 11px;">{{ ($key <9) ? number_format($d->jumlah_desember) : $d->jumlah_desember. '%' }} </td>
                    </tr>
                    {{--@endif--}}
                @endforeach

            </table>
        </div>

        <div id="linechart" style="width: 900px; height: 500px;"></div>
    </div>
</div>
@endsection

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script type="text/javascript">
    var grafik = <?php echo $grafik; ?>;
    console.log(grafik);
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = google.visualization.arrayToDataTable(grafik);
        var options = {
            title: 'Histori Ratio',
            curveType: 'function',
            legend: { position: 'bottom' }
        };
        var chart = new google.visualization.LineChart(document.getElementById('linechart'));
        chart.draw(data, options);
    }
</script>
