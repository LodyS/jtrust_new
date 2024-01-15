<style>
ul { 
    list-style: none outside none; 
    margin:0; 
    padding: 0; 
    text-align: center 
}

li { 
    display: inline; 
    margin: 0 10px; 
}

.feather {
    width:16px;
    height:10px;
}

.v4 { 
    list-style: none outside none; 
    margin:0; 
    padding: 0; 
    text-align: center 
}
</style>

<div id="myDiv">
    <ul class="v4">
        <li class="inline"><a style="width: 20%;" class="btn @if (optional($status_nak)->header == 'Yes') btn-primary @else btn-outline-primary @endif btn-xs" href="{{ url('nak', $id) }}">Header</a></li>
        <li class="inline"><a style="width: 20%;" class="btn @if (optional($status_nak)->informasi_debitur == 'Yes') btn-primary @else btn-outline-primary @endif btn-xs" href="{{ url('nak-informasi-debitur', $id) }}">A. Informasi Debitur</a></li>
        <li class="inline"><a style="width: 20%;" class="btn @if (optional($status_nak)->permohonan_debitur == 'Yes') btn-primary @else btn-outline-primary @endif btn-xs" href="{{ url('nak-permohonan-debitur', $id) }}">B. Permohonan Debitur</a></li>
        <li class="inline"><a style="width: 20%;" class="btn @if (optional($status_nak)->fasilitas_debitur == 'Yes') btn-primary @else btn-outline-primary @endif btn-xs" href="{{ url('nak-fasilitas-debitur', $id) }}">C. Fasilitas Debitur</a></li>
    </ul>

    <div style="height:10px"></div>
    <ul class="v4">
        <li class="inline"><a style="width: 20%;" class="btn @if (optional($status_nak)->informasi_grup_usaha == 'Yes') btn-primary @else btn-outline-primary @endif btn-xs" href="{{ url('nak-informasi-group', $id) }}">D. Informasi Grup Usaha</a></li>
        <li class="inline"><a style="width: 20%;" class="btn @if(optional($status_nak)->financial_highlight == 'Yes') btn-primary @else btn-outline-primary @endif btn-xs" href="{{ url('nak-financial-highlight', $id) }}">E.Financial Highlight</a></li>
        <li class="inline"><a style="width: 20%;" class="btn @if(optional($status_nak)->kondisi_keuangan_debitur == 'Yes') btn-primary @else btn-outline-primary @endif btn-xs" href="{{ url('nak-kondisi-keuangan-debitur', $id) }}">F. Kondisi Keuangan Debitur</a></li>
        <li class="inline"><a style="width: 20%;" class="btn @if(optional($status_nak)->prospek_dan_kinerja_usaha == 'Yes') btn-primary @else btn-outline-primary @endif  btn-xs" href="{{ url('nak-prospek-dan-kinerja-usaha', $id) }}">G. Prospek Dan Kinerja Usaha</a></li>   
    </ul>

    <div style="height:10px"></div>

    <ul class="v4">
        <li class="inline"><a style="width: 20%;" class="btn @if(optional($status_nak)->kegiatan_usaha == 'Yes') btn-primary @else btn-outline-primary @endif  btn-xs" href="{{ url('nak-kegiatan-usaha', $id) }}">H. Kegiatan Usaha</a></li>
        <li class="inline"><a style="width: 20%;" class="btn @if(optional($status_nak)->manajemen_perusahaan == 'Yes') btn-primary @else btn-outline-primary @endif btn-xs" href="{{ url('nak-manajemen-perusahaan', $id) }}">I. Manajemen Perusahaan</a></li>
        <li class="inline"><a style="width: 20%;" class="btn @if(optional($status_nak)->pemasaran == 'Yes') btn-primary @else btn-outline-primary @endif btn-xs" href="{{ url('nak-pemasaran', $id) }}">J. Pemasaran</a></li>
        <li class="inline"><a style="width: 20%;" class="btn @if(optional($status_nak)->perhitungan_kebutuhan_kredit == 'Yes') btn-primary @else btn-outline-primary @endif btn-xs" href="{{ url('nak-perhitungan-kredit', $id) }}">K. Perhitungan Kebutuhan Kredit</a></li>
    </ul>

    <div style="height:10px"></div>

    <ul class="v4">
        <li class="inline"><a style="width: 20%;" class="btn @if(optional($status_nak)->legalitas == 'Yes') btn-primary @else btn-outline-primary @endif btn-xs" href="{{ url('nak-legalitas', $id) }}">L. Legalitas</a></li>
        <li class="inline"><a style="width: 20%;" class="btn @if(optional($status_nak)->resume_hasil_observasi == 'Yes') btn-primary @else btn-outline-primary @endif btn-xs" href="{{ url('nak-resume-hasil-observasi', $id) }}">M. Resume Hasil Observasi</a></li>
        <li class="inline"><a style="width: 20%;" class="btn @if(optional($status_nak)->agunan == 'Yes') btn-primary @else btn-outline-primary @endif btn-xs" href="{{ url('nak-agunan', $id) }}">N. Agunan</a></li>
        <li class="inline"><a style="width: 20%;" class="btn @if(optional($status_nak)->kepatuhan == 'Yes') btn-primary @else btn-outline-primary @endif btn-xs" href="{{ url('nak-kepatuhan', $id) }}">O. Kepatuhan</a></li>
    </ul>
    <div style="height:10px"></div>

    <ul class="v4">
        <li class="inline"><a style="width: 20%;" class="btn @if(optional($status_nak)->deviasi == 'Yes') btn-primary @else btn-outline-primary @endif btn-xs" href="{{ url('nak-deviasi', $id) }}">P. Deviasi</a></li>
        <li class="inline"><a style="width: 20%;" class="btn @if(optional($status_nak)->usulan_kredit == 'Yes') btn-primary @else btn-outline-primary @endif btn-xs" href="{{ url('nak-usulan-kredit', $id) }}">Q. Usulan Kredit</a></li>
        <li class="inline"><a style="width: 20%;" class="btn @if(optional($status_nak)->disclaimer == 'Yes') btn-primary @else btn-outline-primary @endif btn-xs" href="{{ url('nak-disclaimer', $id) }}">R. Disclaimer</a></li>
        <li class="inline"><a style="width: 20%;" class="btn btn-outline-primary btn-xs" href="{{ url('nak-print', $id) }}">Print NAK</a></li>
    </ul>

    <div style="height:10px"></div>

    <ul class="v4">
        {{--<li class="inline"><a style="width: 20%;" class="btn btn-outline-primary btn-xs" target="_blank" href="{{ url('kertas-kerja-screening-calon-debitur', $id) }}">Kertas Kerja Screening Calon Debitur</a></li>
        <li class="inline"><a style="width: 20%;" class="btn btn-outline-primary btn-xs" target="_blank" href="{{ url('arr', $id) }}">ARR CRRD</a></li>
        <li class="inline"><a style="width: 20%;" class="btn btn-outline-primary btn-xs" target="_blank" href="{{ url('legal-opini', $id) }}">Opini Legal</a></li>
        <li class="inline"><a style="width: 20%;" class="btn btn-outline-primary btn-xs" target="_blank" href="{{ url('ca-opini', $id) }}">Opini CAD</a></li>--}}
    </ul>

    <div style="height:10px"></div>

    <ul class="v4">
        
        {{-- <li class="inline"><a style="width: 20%;" class="btn btn-outline-primary btn-xs" target="_blank" href="{{ url('compliance-opini', $id) }}">Opini Compliance</a></li> --}}
    </ul>
</div>