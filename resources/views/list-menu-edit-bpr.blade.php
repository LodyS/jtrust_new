<style>
ul { list-style: none outside none; margin:0; padding: 0; text-align: center }
li { display: inline; margin: 0 10px; }
</style>

<ul>
    <li><a style="width: 20%;" class="btn btn-outline-primary btn-xs" href="{{ url('edit-list-bpr', $id)}}">Informasi Pokok</a></li>
    <li><a style="width: 20%;" class="btn btn-outline-primary btn-xs" href="{{ url('kepemilikan-bpr', $id)}}">Kepemilikan</a></li>
    <li><a style="width: 20%;" class="btn btn-outline-primary btn-xs" href="{{ url('anggota-direksi-komisaris',  $id ?? '')}}">Anggota Direksi Komisaris</a></li>
    <li><a style="width: 20%;" class="btn btn-outline-primary btn-xs" href="{{ url('organ-pelaksana-bpr', $id)}}">Organ Pelaksana</a></li>
</ul>

<div style="height:10px"></div>

<ul>
    <li><a style="width: 20%;" class="btn btn-outline-primary btn-xs" href="{{ url('rincian-kantor-bpr', $id)}}">Daftar Rincian Kantor</a></li>
    <li><a style="width: 20%;" class="btn btn-outline-primary btn-xs" href="{{ url('pihak-terkait-bpr', $id)}}">Pihak Terkait BPR</a></li>
    <li><a style="width: 20%;" class="btn btn-outline-primary btn-xs" href="{{ url('slik', $id)}}">SLIK</a></li>
    <li><a style="width: 20%;" class="btn btn-outline-primary btn-xs" href="{{ url('import-slik-txt', $id)}}">Impor file SLIK</a></li>
</ul>
