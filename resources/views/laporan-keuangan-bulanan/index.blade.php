@extends('tema.app')
@section('content')

<?php use Illuminate\Support\Str; ?>

<style>
ul { list-style: none outside none; margin:0; padding: 0; text-align: center }
li { display: inline; margin: 0 10px; }

.feather {
    width:16px;
    height:10px;
}

</style>

<div class="card border-white" style="width: 100rem;">
    <div class="card-body">
        <h5 style="text-align:center;">INPUT LAPORAN NERACA <br/>{{ strtoupper(\App\Models\InformasiPokokBprPelapor::namaBpr($sandi_bpr)->nama_bpr) ?? '' }}</h5>

        <div style="height:30px" ></div>

        <form action="{{ url('simpan-laporan-neraca') }}" method="POST">@csrf

            <input type="hidden" name="sandi_bpr" value="{{ $sandi_bpr ?? '' }}">

            @include('menu-laporan-bulanan')
            <div style="height:30px"></div>
            @include('flash-message')

            <div class="form-group row">
                <label class="col-md-3">Pilih Bulan</label>
                    <div class="col-md-7">
                    <select name="bulan" class="form-control" required>
                        <option>Pilih</option>
                        <option value="1">Januari</option>
                        <option value="2">Februari</option>
                        <option value="3">Maret</option>
                        <option value="4">April</option>
                        <option value="5">Mei</option>
                        <option value="6">Juni</option>
                        <option value="7">Juli</option>
                        <option value="8">Agustus</option>
                        <option value="9">September</option>
                        <option value="10">Oktober</option>
                        <option value="11">November</option>
                        <option value="12">Desember</option>
                    </select>
                </div>
            </div>

            <?php $tahun = date('Y'); ?>
            <div class="form-group row">
                <label class="col-md-3">Pilih Tahun</label>
                    <div class="col-md-7">
                    <select name="tahun" id="tahun" class="form-control select" required>
                        <option value="">Pilih</option>
                        @for($i=2019; $i<=$tahun; $i++)
                        <option value="{{ $i }}">{{ $i}} </option>
                        @endfor
                    </select>
                </div>
            </div>

            <div style="height:20px"></div>

            <table class="table table-stripped" id="table">
                <tr>
                    <th>No</th>
                    <th>POS/AKTIVITAS/ACCOUNT</th>
                    <th>Sandi</th>
                    <th>Nominal</th>
                </tr>

                @foreach($coa as $key=>$c)
                    <tr>
                        <td style="font-size:11px">{{ $key+1 }}</td>
                        <td style="font-size:11px"><input type="hidden" name="coa_id[]"  value="{{ $c->nama_coa }}">{{ $c->nama_coa }}</td>
                        <td style="font-size:11px"><input type="hidden" name="sandi_coa[]" value="{{ $c->sandi_coa }}">{{ $c->sandi_coa }}</td>

                        @php $array = array(3,6,13,28,32,35,38,47,48,57,64,65)@endphp <!-- Index array yang belum ditambah 1 -->
                        @if(in_array($key, $array))
                            <td style="font-size:11px"><input type="text" name="nominal[]" value="{{ old("nominal") }}" id="{{ $key+1 }}" class="form-control nominal" readonly style="text-align:right;"></td>
                        @else
                            <td style="font-size:11px"><input type="text" name="nominal[]" value="{{ old("nominal") }}" id="{{ $key+1 }}" class="form-control nominal" style="text-align:right;"></td>
                        @endif

                    </tr>
                @endforeach

                <tr>
                    <td><b>BALANCE</b></td>
                    <td colspan="2"><input type="text" readonly class="form-control" id="alert"></td>
                    <td><input type="text" name="balance" id="balance" style="text-align:right" class="form-control" disabled></td>
                </tr>
            </table>

            <div style="height:30px"></div>

            <div>
                <button type="submit" class="btn btn-primary" id="tombol" style="float:right" disabled>Save</button>
            </div>
        </form>

    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
$('.nominal').on('change click keyup input paste',(function (event) {
    $(this).val(function (index, value) {
        return value.replace(/(?!\,)\D/g, "").replace(/(?<=\,,*)\./g, "").replace(/(?<=\.\d\d).*/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    });
}));

function numberFormat(total)
{
    return total.toString().replace(/(?!\,)\D/g, "").replace(/(?<=\,,*)\./g, "").replace(/(?<=\.\d\d).*/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

$(document).ready(function(){

    $('#5, #6').on('change keyup',function()
    {
        var satu = $('#5').val().replace(/\D/g, "");
        var dua = $('#6').val().replace(/\D/g, "");
        var hasil_satu = Number(satu) + Number(dua);

        $('#4').val(numberFormat(hasil_satu)).change();
    });

    $('#8, #9, #10, #11, #12, #13').on('change keyup',function()
    {
        var giro_pada_bank_lain = $('#8').val().replace(/\D/g, "");
        var tabungan_pada_bank_lain = $('#9').val().replace(/\D/g, "");
        var deposito_pada_bank_lain = $('#10').val().replace(/\D/g, "");
        var sertifikat_deposito = $('#11').val().replace(/\D/g, "");
        var kredit_yang_diberikan = $('#12').val().replace(/\D/g, "");
        var penyisihan_penghapusan_aktiva_produktif = $('#13').val().replace(/\D/g, "");

        var hasil_dua = Number(giro_pada_bank_lain) + Number(tabungan_pada_bank_lain) + Number(deposito_pada_bank_lain);
        var hasil_dua = hasil_dua + Number(sertifikat_deposito) + Number(kredit_yang_diberikan);

        $('#7').val(numberFormat(hasil_dua)).change();
    });

    $('#15, #16, #17, #18, #19').on('change keyup',function()
    {
        var kol_lancar = $('#15').val().replace(/\D/g, "");
        var kol_dpk = $('#16').val().replace(/\D/g, "");
        var kol_kurang_lancar = $('#17').val().replace(/\D/g, "");
        var kol_diragukan = $('#18').val().replace(/\D/g, "");
        var kol_macet = $('#19').val().replace(/\D/g, "");

        var hasil_tiga = Number(kol_lancar) + Number(kol_dpk) + Number(kol_kurang_lancar);
        var hasil_tiga = hasil_tiga + Number(kol_diragukan) + Number(kol_macet);

        $('#14').val(numberFormat(hasil_tiga)).change();
    });

    $('#1, #2, #3, #4, #7, #14, #22, #23, #25, #27, #13, #20, #21, #24, #26, #28').on('change keyup',function()
    {
        var kas = $('#1').val().replace(/\D/g, "");
        var kas_dalam_valuta_asing = $('#2').val().replace(/\D/g, "");
        var surat_berharga = $('#3').val().replace(/\D/g, "");
        var pendapatan_bunga_yang_akan_diterima = $('#4').val().replace(/\D/g, "");

        var penempatan_pada_bank_lain = $('#7').val().replace(/\D/g, "");
        var kredit_yang_diberikan = $('#14').val().replace(/\D/g, "");
        var agunan_yang_diambil_alih = $('#22').val().replace(/\D/g, "");
        var aset_tetap_dan_inventaris = $('#23').val().replace(/\D/g, "");

        var aset_tidak_berwujud = $('#25').val().replace(/\D/g, "");
        var aset_antar_kantor = $('#27').val().replace(/\D/g, "");
        var penyisihan_penghapusan_aktiva_produktif = $('#13').val().replace(/\D/g, "");
        var penyisihan_penghapusan_aktiva_produktif_dua = $('#20').val().replace(/\D/g, "");

        var provisi_belum_diamortisasi = $('#21').val().replace(/\D/g, "");
        var akumulasi_penyusutan_dan_penurunan_nilai = $('#24').val().replace(/\D/g, "");
        var akumulasi_amortisasi_dan_penurunan_nilai = $('#26').val().replace(/\D/g, "");
        var aset_lain_lain = $('#28').val().replace(/\D/g, "");

        var hasil_empat = Number(kas) + Number(kas_dalam_valuta_asing) + Number(surat_berharga) + Number(pendapatan_bunga_yang_akan_diterima);
        var hasil_empat = Number(hasil_empat) + Number(penempatan_pada_bank_lain) + Number(kredit_yang_diberikan) + Number(agunan_yang_diambil_alih) + Number(aset_tetap_dan_inventaris);
        var hasil_empat = Number(hasil_empat) + Number(aset_tidak_berwujud) + Number(aset_antar_kantor);
        var hasil_empat = Number(hasil_empat) - Number(penyisihan_penghapusan_aktiva_produktif) - Number(penyisihan_penghapusan_aktiva_produktif_dua);
        var hasil_empat = Number(hasil_empat) - Number(provisi_belum_diamortisasi) - Number(akumulasi_penyusutan_dan_penurunan_nilai);
        var hasil_empat = Number(hasil_empat) - Number(akumulasi_amortisasi_dan_penurunan_nilai);
        var hasil_empat = Number(hasil_empat) + Number(aset_lain_lain);

        $('#29').val(numberFormat(hasil_empat)).change();
    });

    $('#34, #35').on('change keyup',function()
    {
        var tabungan = $('#34').val().replace(/\D/g, "");
        var deposito = $('#35').val().replace(/\D/g, "");
        var hasil_lima = Number(tabungan) + Number(deposito);

        $('#33').val(numberFormat(hasil_lima)).change();
    });

    $('#37, #38').on('change keyup',function()
    {
        var tabungan_dari_bank_lain = $('#37').val().replace(/\D/g, "");
        var deposito_dari_bank_lain = $('#38').val().replace(/\D/g, "");
        var hasil_enam = Number(tabungan_dari_bank_lain) + Number(deposito_dari_bank_lain);

        $('#36').val(numberFormat(hasil_enam)).change();
    });

    $('#40, #41').on('change keyup',function()
    {
        var pinjaman_jatuh_tempo_dibawah_tiga_bulan = $('#40').val().replace(/\D/g, "");
        var pinjaman_jatuh_tempo_diatas_tiga_bulan = $('#41').val().replace(/\D/g, "");
        var hasil_enam = Number(pinjaman_jatuh_tempo_dibawah_tiga_bulan) + Number(pinjaman_jatuh_tempo_diatas_tiga_bulan);

        $('#39').val(numberFormat(hasil_enam)).change();
    });

    $('#30, #31, #32, #33, #36, #39, #42, #43, #44, #45, #46, #47').on('change keyup',function()
    {
        var kewajiban_segera = $('#30').val().replace(/\D/g, "");
        var utang_bunga = $('#31').val().replace(/\D/g, "");
        var utang_pajak = $('#32').val().replace(/\D/g, "");
        var simpanan = $('#33').val().replace(/\D/g, "");
        var simpanan_dari_bank_lain = $('#36').val().replace(/\D/g, "");
        var pinjaman_diterima = $('#39').val().replace(/\D/g, "");
        var dana_setoran_modal_kewajiban = $('#42').val().replace(/\D/g, "");
        var kewajiban_imbalan_kerja = $('#43').val().replace(/\D/g, "");
        var pinjaman_subordinasi = $('#44').val().replace(/\D/g, "");
        var modal_pinjaman = $('#45').val().replace(/\D/g, "");
        var kewajiban_antar_kantor = $('#46').val().replace(/\D/g, "");
        var kewajiban_lain_lain = $('#47').val().replace(/\D/g, "");

        var hasil_tujuh = Number(kewajiban_segera) + Number(utang_bunga) + Number(utang_pajak) + Number(simpanan);
        var hasil_tujuh = Number(hasil_tujuh) + Number(simpanan_dari_bank_lain) + Number(pinjaman_diterima) + Number(dana_setoran_modal_kewajiban);
        var hasil_tujuh = Number(hasil_tujuh) + Number(kewajiban_imbalan_kerja) + Number(pinjaman_subordinasi) + Number(modal_pinjaman);
        var hasil_tujuh = Number(hasil_tujuh) + Number(kewajiban_antar_kantor) + Number(kewajiban_lain_lain);

        $('#48').val(numberFormat(hasil_tujuh)).change();
    });

    $('#50, #51, #52, #54').on('change keyup',function()
    {
        var modal_dasar = $('#50').val().replace(/\D/g, "");
        var modal_yang_belum_disetor = $('#51').val().replace(/\D/g, "");
        var agio = $('#52').val().replace(/\D/g, "");
        var modal_sumbangan = $('#54').val().replace(/\D/g, "");

        var hasil_delapan = Number(modal_dasar) - Number(modal_yang_belum_disetor);
        var hasil_delapan = Number(hasil_delapan) + Number(agio) + Number(modal_sumbangan);

        $('#49').val(numberFormat(hasil_delapan)).change();
    });

    $('#59, #60, #61, #63').on('change keyup',function()
    {
        var cadangan_umum = $('#59').val().replace(/\D/g, "");
        var cadangan_tujuan = $('#60').val().replace(/\D/g, "");
        var laba_tahun_tahun_yang_lalu = $('#61').val().replace(/\D/g, "");
        var laba_tahun_berjalan = $('#63').val().replace(/\D/g, "");

        var hasil_sembilan = Number(cadangan_umum) + Number(cadangan_tujuan);
        var hasil_sembilan = Number(hasil_sembilan) + Number(laba_tahun_tahun_yang_lalu) + Number(laba_tahun_berjalan);

        $('#58').val(numberFormat(hasil_sembilan)).change();
    });

    $('#49, #55, #56, #57, #58').on('change',function()
    {
        var komponen_modal = $('#49').val().replace(/\D/g, "");
        var dana_setoran_modal_ekuitas = $('#55').val().replace(/\D/g, "");
        var laba_rugi_yang_belum_direalisasi = $('#56').val().replace(/\D/g, "");
        var surplus_revaluasi_aset_tetap = $('#57').val().replace(/\D/g, "");
        var saldo_laba = $('#58').val().replace(/\D/g, "");

        var jumlah_ekuitas = Number(komponen_modal) + Number(dana_setoran_modal_ekuitas);
        var jumlah_ekuitas = Number(jumlah_ekuitas) + Number(laba_rugi_yang_belum_direalisasi) + Number(surplus_revaluasi_aset_tetap);
        var jumlah_ekuitas = Number(jumlah_ekuitas) + Number(saldo_laba);

        $('#65').val(numberFormat(jumlah_ekuitas)).change();
    });

    $('#48, #65').on('change',function()
    {
        var jumlah_ekuitas = $('#65').val().replace(/\D/g, "");
        var jumlah_kewajiban = $('#48').val().replace(/\D/g, "");

        var total_kewajiban_ekuitas = Number(jumlah_ekuitas) + Number(jumlah_kewajiban);

        $('#66').val(numberFormat(total_kewajiban_ekuitas)).change();
    });

    $('#29, #66').on('change',function()
    {
        var total_aktiva = $('#29').val().replace(/\D/g, "");
        var total_passiva = $('#66').val().replace(/\D/g, "");

        var balance = Number(total_aktiva) - Number(total_passiva);

        $('#balance').val(numberFormat(balance)).change();
    });

    $("#balance").on('change',function(){
        
        var total_aktiva = $('#29').val().replace(/\D/g, "");
        var total_passiva = $('#66').val().replace(/\D/g, "");

        if(this.value == '0'){
            $("#tombol").attr('disabled',false);
            $("#alert").val('Sudah Balance').css("color", "green");
        } else if(this.value == ''){
            $("#tombol").attr('disabled',true);
        } else {
            $("#tombol").attr('disabled',true);

            let status = (total_aktiva > total_passiva) ? 'Aktiva lebih besar dari Ekuitas dengan selisih' : 'Ekuitas lebih besar dari Aktiva dengan selisih';

            $("#alert").val(`Belum Balance karena, ${status}`).css("color", "red");
        }
    }).trigger("change");
});
/* pada proses perhitungan jQuery key array + 1 */
</script>
@endpush


