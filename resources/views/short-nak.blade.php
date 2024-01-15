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
        <li class="inline"><a style="width:20%" class="btn {{ ($url == 'header') ? 'btn-primary' : 'btn-outline-primary' }} btn-xs" href="{{ url('short-nak', $id) }}">Header & Informasi Debitur</a></li>
        <li class="inline"><a style="width:20%" class="btn {{ ($url == 'informasi-debitur') ? 'btn-primary' : 'btn-outline-primary' }} btn-xs" href="{{ url('short-nak-informasi-debitur', $id) }}">A. Informasi Debitur</a></li>
        <li class="inline"><a style="width:20%" class="btn {{ ($url == 'latar-belakang') ? 'btn-primary' : 'btn-outline-primary' }} btn-xs" href="{{ url('short-nak-latar-belakang', $id) }}">B. Latar Belakang</a></li>
        <li class="inline"><a style="width:20%" class="btn {{ ($url == 'pembahasan') ? 'btn-primary' : 'btn-outline-primary' }} btn-xs" href="{{ url('short-nak-pembahasan', $id) }}">C. Pembahasan</a></li>
    </ul>

    <div style="height:10px"></div>

    <ul class="v4">
        <li class="inline"><a style="width:20%" class="btn {{ ($url == 'usulan') ? 'btn-primary' : 'btn-outline-primary' }} btn-xs" href="{{ url('short-nak-usulan', $id) }}">D. Usulan</a></li>
        <li class="inline"><a style="width:20%" class="btn {{ ($url == 'disclaimer') ? 'btn-primary' : 'btn-outline-primary' }} btn-xs" href="{{ url('short-nak-disclaimer', $id) }}">Disclaimer</a></li>
        <li class="inline"><a style="width:20%" class="btn btn-outline-primary btn-xs" href="{{ url('short-nak-print', $id) }}">Print</a></li>
    </ul>
</div>
