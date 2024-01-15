<!DOCTYPE html>
@extends('tema.app')
@section('content')

<div class="card border-white" style="width: 100rem;">
    <div class="card-body">
    
        <div class="card border-white">
			<div class="card-body">
                <h5 style="text-align:center">DISCLAIMER - {{ strtoupper(\App\Models\InformasiPokokBprPelapor::namaBpr($sandi_bpr)->nama_bpr) }}</h5>
                <div style="height:30px"></div>
                @include('short-nak')
            </div>
        </div>
    
        <div style="height:10px"></div>

        <div class="card border-white">
			<div class="card-body">
                <p class="paragraf" style="font-size:12px">
                    Business Unit bertanggung jawab terhadap kebenaran, validasi, dan kekinian data yang digunakan untuk menyusun NAK long form.
                </p>

                <p class="paragraf" style="font-size:12px">
                    Masa berlaku NAK long form adalah 90 (Sembilan puluh) hari yang dihitung sejak tanggal NAK disetujui oleh Komite Kredit
                    (setelah approval kredit) sampai dengan tanggal penandatanganan Perjanjian Kredit.
                </p>
    
                <p class="paragraf" style="font-size:12px">
                    Apabila Debitur mengajukan ketentuan dan kondisi yang berbeda,
                    maka NAK harus dilakukan perubahan dan wajib dilakukan kaji ulang oleh Credit Risk Reviewer
                    awal dan diajukan kembali kepada Komite Kredit awal. Kecuali,
                    apabila terdapat perubahan ketentuan dan kondisi yang khusus berkaitan dengan perubahan suku bunga;
                    provisi; biaya admin dan jaminan atas fasilitas kredit maka Business Unit membuat Memo Internal tanpa
                    NAK Short Form tidak melebihi 90 hari dari Perjanjian Kredit.
                    Memo internal merupakan memo persetujuan sirkuler by Garoon sesuai BWMK.
                </p>

                <p class="paragraf" style="font-size:12px">
                    Apabila Perjanjian Kredit ditandatangani lebih dari 30 (tiga puluh)
                    hari sampai dengan 90 (sembilan puluh) hari, maka NAK long form wajib dilakukan analisa kembali yang dituangkan
                    ke dalam NAK short form dan wajib dilakukan kaji ulang oleh Credit Risk Reviewer awal dan diajukan kembali
                    kepada Komite Kredit awal dengan melampirkan SLIK checking dan rekening koran posisi terakhir.
                </p>
                    
                <p class="paragraf" style="font-size:12px">
                    Apabila Perjanjian Kredit belum ditandatangani setelah 90 (sembilan puluh) hari,
                    maka NAK long form dianggap sudah tidak berlaku lagi.
                </p>
            </div>
        </div>  
    </div>
</div>
@endsection
