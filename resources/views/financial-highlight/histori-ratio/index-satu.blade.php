@extends('tema.app')
@section('content')

<style>
table
{
    border-collapse: collapse;
    border-spacing: 0;
    width: 100%;
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

<div class="col-md-18" style="width:1600px">
    <div class="card">
        <div class="card-body">

            <nav class="page-breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{ url('list-data-bpr') }}">List Data BPR</a></li>
					<li class="breadcrumb-item"><a href="{{ url('data-applicant')}}">Loan Application</a></li>
				</ol>
			</nav>

            <div class="w-sm-100 mr-auto">
                <h5 class="mb-0" align="center">Histori Ratio</h5>
                <h5 class="mb-0" align="center">{{ $bpr->sandi_bpr ?? $bprr->sandi_bpr }} - {{ $bpr->nama_bpr ?? $bprr->nama_bpr }}</h5>
                <h5 class="mb-0" align="center">{{ $tahun }}</h5>
            </div>

            <div style="height:30px"></div>

            <form action="{{ url('cari-histori-ratio') }}" method="POST">{{ @csrf_field() }}

            <input type="hidden" name="sandi_bpr" value="{{ $bpr->sandi_bpr ?? $bprr->sandi_bpr }}">

            <?php $year = date('Y'); ?>
            <div class="form-group row">
                <label class="col-md-3">Pilih Tahun Awal</label>
                    <div class="col-md-7">
                    <select name="tahun" class="form-control select" required>
                        <option value="">Pilih</option>
                        @for($i=2019; $i<=$year; $i++)
                        <option value="{{ $i }}">{{ $i}} </option>
                        @endfor
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-md-3">Pilih Tahun Akhir</label>
                    <div class="col-md-7">
                    <select name="tahun_akhir" class="form-control select" required>
                        <option value="">Pilih</option>
                        @for($i=2019; $i<=$year; $i++)
                        <option value="{{ $i }}">{{ $i}} </option>
                        @endfor
                    </select>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Search</button>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-responsive">
                    <tr>
                        <th width="60%">POS</th>
                        <th colspan="4" style="text-align:center;">{{ $tahun }}</th>
                        <th colspan="4" style="text-align:center;">{{ $tahun_akhir }}</th>
                    </tr>

                    <tr>
                        <td width="12%"></td>
                        <td width="12%"><b>Maret</b></td>
                        <td width="12%"><b>Juni<b></td>
                        <td width="12%"><b>September</b></td>
                        <td width="12%"><b>Desember</b></td>

                        <td width="12%"><b>Maret</b></td>
                        <td width="12%"><b>Juni</b></td>
                        <td width="12%"><b>September</b></td>
                        <td width="12%"><b>Desember</b></td>
                    </tr>

                    @foreach ($data as $d)
                    <tr>
                        <td>{{ $d->pos }}</td>
                        <td style="text-align:right;">{{ ($d->pos == 'RASIO – RASIO %') ? '' : $d->jumlah_maret. '%' }} </td>
                        <td style="text-align:right;">{{ ($d->pos == 'RASIO – RASIO %') ? '' : $d->jumlah_juni. '%' }} </td>
                        <td style="text-align:right;">{{ ($d->pos == 'RASIO – RASIO %') ? '' : $d->jumlah_september. '%' }} </td>
                        <td style="text-align:right;">{{ ($d->pos == 'RASIO – RASIO %') ? '' : $d->jumlah_desember. '%' }} </td>

                        <td style="text-align:right;">{{ ($d->pos == 'RASIO – RASIO %') ? '' : $d->jumlah_maret_satu. '%' }} </td>
                        <td style="text-align:right;">{{ ($d->pos == 'RASIO – RASIO %') ? '' : $d->jumlah_juni_satu. '%' }} </td>
                        <td style="text-align:right;">{{ ($d->pos == 'RASIO – RASIO %') ? '' : $d->jumlah_september_satu. '%' }} </td>
                        <td style="text-align:right;">{{ ($d->pos == 'RASIO – RASIO %') ? '' : $d->jumlah_desember_satu. '%' }} </td>
                    </tr>
                    @endforeach

                </table>
            </div>

            <div id="linechart" style="width: 900px; height: 500px;"></div>

        </div>
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
