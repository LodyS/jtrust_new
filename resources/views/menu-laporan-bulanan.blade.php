<div id="myDiv">
    <ul>
        <li class="inline"><a style="width:20%" class="btn btn-outline-primary btn-xs" href="{{ url('laporan-keuangan-bulanan', $sandi_bpr) }}">Laporan Neraca</a></li>
        <li class="inline"><a style="width:20%" class="btn btn-outline-primary btn-xs" href="{{ url('laporan-bulanan-laba-rugi', $sandi_bpr) }}">Laporan Laba Rugi</a></li>
        <li class="inline"><a style="width:20%" class="btn btn-outline-primary btn-xs" href="{{ url('rekening-administratif', $sandi_bpr) }}">Rekening Administratif</a></li>
        <li class="inline"><a style="width:20%" class="btn btn-outline-primary btn-xs" href="{{ url('input-profil', $sandi_bpr) }}">Input Profil LKM</a></li>
    </ul>

    <div style="height:10px"></div>
    
    <ul>
        <li class="inline"><a style="width:20%" class="btn btn-outline-primary btn-xs" href="{{ url('ppap', $sandi_bpr) }}">PPAP</a></li>
        <li class="inline"><a style="width:20%" class="btn btn-outline-primary btn-xs" href="{{ url('atmr', $sandi_bpr) }}">ATMR</a></li>
        <li class="inline"><a style="width:20%" class="btn btn-outline-primary btn-xs" href="{{ url('kpmm', $sandi_bpr) }}">KPMM</a></li>
        <li class="inline"><a style="width:20%" class="btn btn-outline-primary btn-xs" href="{{ url('rasio', $sandi_bpr) }}">Rasio</a></li>
    </ul>

    <div style="height:10px"></div>
    
    <ul>
        <li class="inline"><a style="width:20%" class="btn btn-outline-primary btn-xs" href="{{ url('input-financial-highlight', $sandi_bpr) }}">Financial Highlight</a></li>
    </ul>
</div>
