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
        <li class="inline"><a style="width:20%" class="btn btn-outline-primary btn-xs" href="{{ url('arr', $id) }}">Header</a></li>
        <li class="inline"><a style="width:20%" class="btn btn-outline-primary btn-xs" href="{{ url('informasi-debitur-dan-group', $id) }}">A. Informasi Debitur Dan Group</a></li>
        <li class="inline"><a style="width:20%" class="btn btn-outline-primary btn-xs" href="{{ url('informasi-fasilitas-kredit-debitur-dan-group', $id) }}">B. Informasi Fasilitas Kredit Dan Group</a></li>
        <li class="inline"><a style="width:20%" class="btn btn-outline-primary btn-xs" href="{{ url('arr-financial-higlight', $id) }}">C. Financial Highlights</a></li>
       
    </ul>

    <div style="height:10px"></div>
    <ul class="v4">
        <li class="inline"><a style="width:20%" class="btn btn-outline-primary btn-xs" href="{{ url('key-risk-issue', $id) }}">D. Key Risk Issue</a></li>
        <li class="inline"><a style="width:20%" class="btn btn-outline-primary btn-xs" href="{{ url('covenant-checklist', $id) }}">E.Covenant Checklist</a></li>
        <li class="inline"><a style="width:20%" class="btn btn-outline-primary btn-xs" href="{{ url('catatan-penting-lainnya', $id) }}">F. Catatan Penting Lainnya (Opsional)</a></li>
        <li class="inline"><a style="width:20%" class="btn btn-outline-primary btn-xs" href="{{ url('arr-rekomendasi', $id) }}">G. Rekomendasi</a></li>
    </ul>

    <div style="height:10px"></div>
    <ul class="v4">
        <li class="inline"><a style="width:20%" class="btn btn-outline-primary btn-xs" href="{{ url('arr-print', $id) }}">Print</a></li>
        <li class="inline"><a style="width:20%" class="btn btn-outline-primary btn-xs" target="_blank" href="{{ url('lembar-keputusan-kredit-header', $id) }}">Lembar Keputusan Kredit</a></li>
        
        {{-- <liclass="inline"><astyle="width:20%"class="btnbtn-outline-primarybtn-xs"href="url('nak',$id) }}">NAK</a></li>
        <li class="inline"><a style="width:20%" class="btn btn-outline-primary btn-xs" target="_blank" href="{{ url('legal-opini', $id) }}">Opini Legal</a></li>
        <li class="inline"><a style="width:20%" class="btn btn-outline-primary btn-xs" target="_blank" href="{{ url('compliance-opini', $id) }}">Opini Compliance</a></li>--}}
    </ul>

    <div style="height:10px"></div>
    <ul class="v4">
       {{-- <liclass="inline"><astyle="width:20%"class="btnbtn-outline-primarybtn-xs"target="_blank"href="url('ca-opini',$id) }}">Opini CAD</a></li>--}}
    </ul>
</div>
