<title>LEMBAR KERTAS KERJA SCREENING CALON DEBITUR {{ strtoupper(\App\Models\InformasiPokokBprPelapor::namaBpr($data->sandi_bpr)->nama_bpr) }}</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    
<style>
* {
    font-size:12px;
}
</style>

<div class="card border-white">
    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <td style="text-align:center; vertical-align:middle"><b>Kertas Kerja Screening Calon Debitur</b></td>
                <td><img src="{{ url('logo/jtrust.jpg') }}" width="200px"></td>
            </tr>
        </table>

        <hr/>        
        <h6 align="center">PENGUSUL KREDIT</h6>
        <hr/>

        <table class="table table-bordered">
            <tr>
                <td>Nomor</td>
                <td style="width:70%">{{ $data->no_nak_long_form ?? '' }}</td>
            </tr>

            <tr>
                <td>Nama Calon Debitur</td>
                <td>{{ \App\Models\InformasiPokokBprPelapor::namaBpr($data->sandi_bpr)->nama_bpr }}</td>
            </tr>
        </table>
    </div> 
</div>

<div class="card border-white">
    <div class="card-body">
        <hr/>        
        <h6 align="center">CATATAN</h6>
        <hr/>

        {!! $data->kertas_kerja_screening_cadeb ?? '' !!}
        </hr/>
    </div> 
</div> 

<div style="height:auto; page-break-before: always"></div>

<div class="card border-white">
    <div class="card-body">
        <table class="table table-bordered table-sm wrap">
            <tr>
                <td style="height:2cm; width:33%"></td>
                <td style="height:2cm; width:33%"></td>
                <td style="height:2cm; width:33%"></td>
            </tr>

            <tr>
                <td style="width:33%; text-align:center">{{ $aml_cft_section_head ?? ''}}</td>
                <td style="width:33%; text-align:center">{{ $aml_cft_dep_head ?? '' }}</td>
                <td style="width:33%; text-align:center">{{ $compliance_div_head ?? '' }}</td>
            </tr>

            <tr>
                <td style="width:3%; text-align:center">AML & CFT Sect. Head </td>
                <td style="width:33%; text-align:center">AML & CFT Dept. Head </td>
                <td style="width:33%; text-align:center">Div. Head Compliance </td>
            </tr>
        </table>
    </div>
</div>