<style>
ul { list-style: none outside none; margin:0; padding: 0; text-align: center }
li { display: inline; margin: 0 10px; }

.feather {
    width:16px;
    height:10px;
}

</style>

<div id="myDiv">
    <ul class="v4">
        <li class="inline"><a style="width:22%" class="btn btn-outline-primary btn-xs" href="{{ url('lembar-keputusan-kredit-header', $id) }}">Header</a></li>
 
        <li class="inline"><a style="width:22%" class="btn btn-outline-primary btn-xs" href="{{ url('lembar-keputusan-kredit-fasilitas-kredit', $id) }}">A. Fasilitas Kredit</a></li>
        <li class="inline"><a style="width:22%" class="btn btn-outline-primary btn-xs" href="{{ url('lembar-keputusan-kredit-agunan-fasilitas-kredit', $id) }}">B. Agunan Fasilitas Kredit</a></li>
        <li class="inline"><a style="width:22%" class="btn btn-outline-primary btn-xs" href="{{ url('syarat-dan-kondisi-penyediaan-fasilitas', $id) }}">C. Syarat Dan Kondisi Penyediaan Fasilitas</a></li>
    </ul>
    <div style="height:20px"></div>
    <ul>
        <li class="inline"><a style="width:22%" class="btn btn-outline-primary btn-xs" href="{{ url('persetujuan-khusus-dan-deviasi', $id) }}">D. Persetujuan Khusus Dan Deviasi</a></li>
        <li class="inline"><a style="width:22%" class="btn btn-outline-primary btn-xs" href="{{ url('usulan-dan-persetujuan-kredit', $id) }}">E. Usulan dan Persetujuan Kredit</a></li>
        <li class="inline"><a style="width:22%" class="btn btn-outline-primary btn-xs" href="{{ url('arr', $id) }}">ARR</a></li>
        <li class="inline"><a style="width:22%" class="btn btn-outline-primary btn-xs" href="{{ url('lembar-keputusan-kredit-print', $id) }}" target="_blabk">Print</a></li>
    </ul>
</div>
