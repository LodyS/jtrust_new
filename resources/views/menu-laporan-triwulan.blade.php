<style>
ul { list-style: none outside none; margin:0; padding: 0; text-align: center }
li { display: inline; margin: 0 10px; }

.feather {
    width:16px;
    height:10px;
}

.v4 { list-style: none outside none; margin:0; padding: 0; text-align: center }
</style>

<div id="myDiv">
    <ul class="v4">
        <li class="inline"><a style="width:20%" class="btn btn-outline-primary btn-xs" href="{{ url('detail-laporan-posisi-keuangan', $sandi_bpr) }}">Laporan Posisi Keuangan</a></li>
        <li class="inline"><a style="width:20%" class="btn btn-outline-primary btn-xs" href="{{ url('detail-laporan-laba-rugi', $sandi_bpr) }}">Laporan Laba Rugi</a></li>
        <li class="inline"><a style="width:20%" class="btn btn-outline-primary btn-xs" href="{{ url('detail-laporan-aset-produktif', $sandi_bpr) }}">Laporan Aset Produktif</a></li>
    </ul>
</div>

<div style="height:10px"></div>

<div id="myDiv">
    <ul class="v4">
        <li class="inline"><a style="width:20%" class="btn btn-outline-primary btn-xs" href="{{ url('histori-ratio', $sandi_bpr) }}">Histori Ratio</a></li>
        <li class="inline"><a style="width:20%" class="btn btn-outline-primary btn-xs" href="{{ url('tingkat-kesehatan-bank', $sandi_bpr) }}">Tingkat Kesehatan Bank</a></li>
        <li class="inline"><a style="width:20%" class="btn btn-outline-primary btn-xs" href="{{ url('publikasi-ojk', $sandi_bpr) }}">Laporan Financial Highlight</a></li>
    </ul>
</div>
