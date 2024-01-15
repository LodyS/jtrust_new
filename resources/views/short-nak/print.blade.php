<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css">

<style>
 *{
    font-size:11px;
 }

.center {
    display: block;
    margin-left: auto;
    margin-right: auto;
}
</style>

<title>SHORT NAK - {{ strtoupper(\App\Models\InformasiPokokBprPelapor::namaBpr($data->sandi_bpr)->nama_bpr) ?? '' }}</title>

<div class="ariel">
    <div style="height:30px"></div>

    <table class="table table-bordered table-sm">
        <tr>
            <td colspan="2" style="text-align:center; vertical-align:middle; width:60%"><b>NOTA ANALISA KREDIT (NAK) SHORT FORM</b></td>
            <td><img src="{{ url('logo/jtrust.jpg') }}" width="180px" class="center"></td>
        </tr>
    </table> 
            
    <table class="table table-bordered table-sm">
        <tr>
            <td style="width:25%"><b>No NAK Short Form</b></td>
            <td>{{ $data->no_nak_short ?? '' }}</td>
        </tr>

        <tr>
            <td><b>Tanggal NAK Short</b></td>
            <td>{{ ($data->tanggal_nak_short == null) ? '' : date('d-m-Y', strtotime($data->tanggal_nak_short))  }}</td>
        </tr>
    </table>

    <table class="table table-bordered table-sm">
        <tr>
            <td style="width:25%"><b>No Surat Debitur</b></td>
            <td>{{ $data->no_surat_debitur ?? '' }}</td>
            <td><b>Tanggal Surat Debitur</b></td>
            <td>{{ $data->tanggal_surat_debitur ?? '' }}</td>
        </tr>

        <tr>
            <td><b>Jenis Pengajuan</b></td>
            <td>{{ $data->jenis_pengajuan }}</td>
            <td><b>BWMK</b></td>
            <td>{{ App\Models\Bwmk::statusBwmk($data->baki_debet) ?? '' }}</td>
        </tr>

        <tr>
            <td><b>Divisi/Cabang Pengusul</b></td>
            <td>{{ $data->divisi_bisnis_pengusul ?? '' }}</td>
            <td><b>Kode BUC</b></td>
            <td>{{ $data->kode_buc ?? '' }}</td>
        </tr>

        <tr>
            <td><b>AO/RM/BM</b></td>
            <td>{{ $relationshipManager->name ?? ''}}</td>
            <td><b>Kode RM/AO/BM</b></td>
            <td>{{ $relationshipManager->kode_rm ?? '' }}</td>
        </tr>

        <tr>
            <td><b>Departemen Head</b></td>
            <td>{{ $departemenHead->name ?? '' }}</td>
            <td><b>Kode Departemen Head</b></td>
            <td>{{ $departemenHead->kode_rm ?? '' }}</td>
        </tr>

        <tr>
            <td><b>Division Head</b></td>
            <td>{{ $divisionHead->name ?? '' }}</td>
            <td><b>Kode Division Head</b></td>
            <td>{{ $divisionHead->kode_rm ?? '' }}</td>
        </tr>

        <tr>
            <td><b>Tanggal Kunjungan Terakhir</b></td>
            <td>{{ ($data->tanggal_kunjungan_terakhir == null) ? '' :  date('d-m-Y', strtotime($data->tanggal_kunjungan_terakhir)) }}</td>
            <td><b>Tanggal Call Report</b></td>
            <td>{{ ($data->tanggal_call_report == null) ? '' : date('d-m-Y', strtotime($data->tanggal_call_report)) }}</td>
        </tr>
    </table>

    <div style="height:30px"></div>

    <hr/><h4 style="text-align:center;">A. Informasi Debitur</h4><hr/>

    <table class="table table-bordered table-sm">
        <tr>
            <td style="width:25%"><b>Nama Debitur</b></td>
            <td>{{ $bpr->nama_bpr ?? '' }}</td>
            <td><b>No Rekening</b></td>
            <td></td>
        </tr>

        <tr>
            <td><b>Nama Perusahaan <small><br/><i>(Diisi apabila Debitur Percabangan)</i></small></b></td>
            <td></td>
            <td><b>No KTP <small><br/><i>(Diisi apabila Debitur Perorangan)</i></b></td>
            <td></td>
        </tr>

        <tr>
            <td><b>Tahun Pendirian</b></td>
            <td>{{ $bpr->tahun_pendirian_usaha ?? ''}}</td>
            <td><b>No NPWP</b></td>
            <td>{{ $bpr->npwp ?? ''  }}</td>
        </tr>

        <tr>
            <td><b>Menjadi Debitur sejak</b></td>
            <td>{{ date('Y', strtotime($bpr->created_at)) ?? '' }}</td>
            <td><b>No CIF</b></td>
            <td>{{ $bpr->nomor_cif ?? ''  }}</td>
        </tr>
    </table>

    <div style="height:30px"></div>
    
    <hr/><h4 style="text-align:center;">B. Latar Belakang</h4><hr/>{!! $dataa->latar_belakang ?? '' !!}
    
    <div style="height:auto; page-break-before: always"></div>
    <hr/><h4 style="text-align:center;">C. Pembahasan</h4><hr/>{!! $dataa->pembahasan ?? '' !!}
    
    <div style="height:auto; page-break-before: always"></div>
    <hr/><h4 style="text-align:center;">D. Usulan</h4><hr/>{!! $dataa->usulan ?? '' !!}
    
    <div style="height:auto; page-break-before: always"></div>
    <hr/><h4 style="text-align:center;">E. Disclaimer</h4><hr/>

    <p align="justify">
        Business Unit bertanggung jawab terhadap kebenaran, validasi, dan kekinian data yang digunakan untuk menyusun NAK long form.
    </p>

    <p align="justify">
        Masa berlaku NAK long form adalah 90 (Sembilan puluh) hari yang dihitung sejak tanggal NAK disetujui oleh Komite Kredit
        (setelah approval kredit) sampai dengan tanggal penandatanganan Perjanjian Kredit.
    </p>

    <p align="justify">
        Apabila Debitur mengajukan ketentuan dan kondisi yang berbeda,
        maka NAK harus dilakukan perubahan dan wajib dilakukan kaji ulang oleh Credit Risk Reviewer
        awal dan diajukan kembali kepada Komite Kredit awal. Kecuali,
        apabila terdapat perubahan ketentuan dan kondisi yang khusus berkaitan dengan perubahan suku bunga;
        provisi; biaya admin dan jaminan atas fasilitas kredit maka Business Unit membuat Memo Internal tanpa
        NAK Short Form tidak melebihi 90 hari dari Perjanjian Kredit.
        Memo internal merupakan memo persetujuan sirkuler by Garoon sesuai BWMK.
    </p>

    <p align="justify">
        Apabila Perjanjian Kredit ditandatangani lebih dari 30 (tiga puluh)
        hari sampai dengan 90 (sembilan puluh) hari, maka NAK long form wajib dilakukan analisa kembali yang dituangkan
        ke dalam NAK short form dan wajib dilakukan kaji ulang oleh Credit Risk Reviewer awal dan diajukan kembali
        kepada Komite Kredit awal dengan melampirkan SLIK checking dan rekening koran posisi terakhir.
    </p>
      
    <p align="justify">
        Apabila Perjanjian Kredit belum ditandatangani setelah 90 (sembilan puluh) hari,
        maka NAK long form dianggap sudah tidak berlaku lagi.
    </p>
</div>