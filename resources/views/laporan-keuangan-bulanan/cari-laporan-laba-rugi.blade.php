@extends('tema.app')
@section('content')

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
            
        <div class="card border-white">
            <div class="card-body">
                <h5 style="text-align:center;">LAPORAN LABA RUGI <br/>{{ strtoupper(\App\Models\InformasiPokokBprPelapor::namaBpr($sandi_bpr)->nama_bpr) ?? '' }}<br/>{{ strtoupper(bulan($bulan)) }} {{ $tahun }}</h5>
                <div style="height:30px"></div>
                @include('menu-cari-laporan-bulanan')
                @include('flash-message')
            </div> 
        </div>

        <div style="height:10px"></div>

        <form action="{{ url('search-laporan-laba-rugi') }}" method="POST">@csrf

            <input type="hidden" name="sandi_bpr" value="{{ $sandi_bpr ?? '' }}">
            
            <div class="card border-white">
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-md-3">Pilih Bulan</label>
                            <div class="col-md-7">
                            <select name="bulan" class="form-control">
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
                            <select name="tahun" id="tahun" class="form-control select" >
                                <option value="">Pilih</option>
                                @for($i=2019; $i<=$tahun; $i++)
                                <option value="{{ $i }}">{{ $i}} </option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary" name="action" value="cari">Cari</button>
                  
                </div> 
            </div>
        </form>

        <div style="height:10px"></div>

        
        <div class="card border-white">
            <div class="card-body">
                <form action="{{ url('update-laporan-laba-rugi') }}" method="POST">@csrf

                    <input type="hidden" name="sandi_bpr" value="{{ $sandi_bpr ?? '' }}">
                    <table class="table table-hover">
                        <tr>
                            <th>NO</th>
                            <th>POS</th>
                            <th >Nominal</th>
                        </tr>

                
                        @foreach($data as $key=> $d)
                        <tr>
                            <?php $array = array(0,1,2,3,8,12,15,17,20,27,28,29,30,34,40,44,45,47,50,55,56,61,70,74,75,76,83,89,90,92);?>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $d->pos }}</td>
                            <input type="hidden" name="id[]" value="{{ $d->id }}">
                            @if(in_array($key, $array))
                            <td><input type="text" class="form-control nominal" name="nominal[]" id="{{ $key+1 }}" style="text-align:right" value="{{ number_format((float)$d->posisi_tanggal_laporan) }}" readonly></td>
                            @else
                            <td><input type="text" class="form-control nominal" name="nominal[]" id="{{ $key+1 }}" style="text-align:right" value="{{ number_format((float)$d->posisi_tanggal_laporan) }}"></td>
                            @endif
                        @endforeach
                        </tr>
                    </table>

                    <div style="height:30px"></div>

                  
                    <button type="submit" class="btn btn-primary" name="action" value="edit" style="float:right">Edit</button>
                  
                </form>
            </div> 
        </div>
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

    $('#5, #6, #7, #8').on('change keyup',function()
    {
        var giro = $('#5').val().replace(/\D/g, "");
        var tabungan = $('#6').val().replace(/\D/g, "");
        var deposito = $('#7').val().replace(/\D/g, "");
        var sertifikat_deposito = $('#8').val().replace(/\D/g, "");

        var penempatan_pada_bank_lain = Number(giro) + Number(tabungan) + Number(deposito) + Number(sertifikat_deposito);

        $('#4').val(numberFormat(penempatan_pada_bank_lain)).change();
    });

    $('#10, #11').on('change keyup',function()
    {
        var kepada_bank_lain = $('#10').val().replace(/\D/g, "");
        var pihak_ketiga_bukan_bank = $('#11').val().replace(/\D/g, "");

        var kredit_yang_diberikan = Number(kepada_bank_lain) + Number(pihak_ketiga_bukan_bank);

        $('#9').val(numberFormat(kredit_yang_diberikan)).change();
    });

    $('#4, #9, #12').on('change keyup',function()
    {
        var penempatan_pada_bank_lain = $('#4').val().replace(/\D/g, "");
        var kredit_yang_diberikan = $('#9').val().replace(/\D/g, "");
        var surat_berharga = $('#12').val().replace(/\D/g, "");

        var bunga_kontraktual = Number(penempatan_pada_bank_lain) + Number(kredit_yang_diberikan) + Number(surat_berharga);

        $('#3').val(numberFormat(bunga_kontraktual)).change();
    });

    $('#14, #15').on('change keyup',function()
    {
        var kepada_bank_lain = $('#14').val().replace(/\D/g, "");
        var pihak_ketiga_bukan_bank = $('#15').val().replace(/\D/g, "");

        var provisi_kredit = Number(kepada_bank_lain) + Number(pihak_ketiga_bukan_bank);

        $('#13').val(numberFormat(provisi_kredit)).change();
    });

    $('#3, #14, #16').on('change',function()
    {
        var bunga_kontraktual = $('#3').val().replace(/\D/g, "");
        var kepada_bank_lain = $('#14').val().replace(/\D/g, "");
        var biaya_transaksi = $('#16').val().replace(/\D/g, "");

        var pendapatan_bunga = Number(bunga_kontraktual) + Number(kepada_bank_lain) - Number(biaya_transaksi);

        $('#2').val(numberFormat(pendapatan_bunga)).change();
    });

    $('#17, #18').on('change',function()
    {
        var surat_berharga = $('#17').val().replace(/\D/g, "");
        var kredit_yang_diberikan = $('#18').val().replace(/\D/g, "");

        var biaya_transaksi = Number(surat_berharga) + Number(kredit_yang_diberikan);

        $('#16').val(numberFormat(biaya_transaksi)).change();
    });

    $('#19, #20').on('change keyup',function()
    {
        var kepada_bank_lain = $('#19').val().replace(/\D/g, "");
        var pihak_ketiga_bukan_bank = $('#20').val().replace(/\D/g, "");

        var kredit_yang_diberikan = Number(kepada_bank_lain) + Number(pihak_ketiga_bukan_bank);

        $('#18').val(numberFormat(kredit_yang_diberikan)).change();
    });

    $('#2, #21').on('change keyup',function()
    {
        var pendapatan_lainnya = $('#21').val().replace(/\D/g, "");
        var pendapatan_bunga = $('#2').val().replace(/\D/g, "");

        var total_pendapatan_operasional = Number(pendapatan_lainnya) + Number(pendapatan_bunga);

        $('#1').val(numberFormat(total_pendapatan_operasional)).change();
        $('#28').val(numberFormat(total_pendapatan_operasional)).change();
    });

    $('#22, #23, #24, #25, #26, #27').on('change keyup',function()
    {
        var pendapatan_jasa_transaksi = $('#22').val().replace(/\D/g, "");
        var keuntungan_penjualan_valuta_asing = $('#23').val().replace(/\D/g, "");
        var keuntungan_surat_berharga = $('#24').val().replace(/\D/g, "");
        var penerimaan_kredit_yang_dihapus_buku = $('#25').val().replace(/\D/g, "");
        var pemulihan_penyisihan_penghapusan_aset_produktif = $('#26').val().replace(/\D/g, "");
        var lainnya = $('#27').val().replace(/\D/g, "");

        var pendapatan_lainnya = Number(pendapatan_jasa_transaksi) + Number(keuntungan_penjualan_valuta_asing);
        var pendapatan_lainnya = Number(pendapatan_lainnya) + Number(keuntungan_surat_berharga) + Number(penerimaan_kredit_yang_dihapus_buku);
        var pendapatan_lainnya = Number(pendapatan_lainnya) + Number(pemulihan_penyisihan_penghapusan_aset_produktif) + Number(lainnya);

        $('#21').val(numberFormat(pendapatan_lainnya)).change();
    });

    $('#36, #37, #38, #39').on('change keyup',function()
    {
        var a = $('#36').val().replace(/\D/g, "");
        var b = $('#37').val().replace(/\D/g, "");
        var c = $('#38').val().replace(/\D/g, "");
        var d = $('#39').val().replace(/\D/g, "");

        var pinjaman_yang_diterima = Number(a) + Number(b) + Number(c) + Number(d);

        $('#35').val(numberFormat(pinjaman_yang_diterima)).change();
    });

    $('#32, #33, #34, #40').on('change keyup',function()
    {
        var tabungan = $('#32').val().replace(/\D/g, "");
        var deposito = $('#33').val().replace(/\D/g, "");
        var simpanan_dari_bank_lain = $('#34').val().replace(/\D/g, "");
        var pinjaman_yang_diterima = $('#35').val().replace(/\D/g, "");
        var lainnya = $('#40').val().replace(/\D/g, "");

        var beban_bunga_kontraktual = Number(tabungan) + Number(deposito) + Number(simpanan_dari_bank_lain) + Number(pinjaman_yang_diterima);
        var beban_bunga_kontraktual = Number(beban_bunga_kontraktual)  + Number(lainnya);

        $('#31').val(numberFormat(beban_bunga_kontraktual)).change();
    });

    $('#42, #43').on('change keyup',function()
    {
        var kepada_bank_lain = $('#42').val().replace(/\D/g, "");
        var kepada_pihak_ketiga_bukan_bank = $('#43').val().replace(/\D/g, "");

        var biaya_transaksi = Number(kepada_bank_lain) + Number(kepada_pihak_ketiga_bukan_bank);

        $('#41').val(numberFormat(biaya_transaksi)).change();
    });

    $('#31, #41, #44').on('change keyup',function()
    {
        var beban_bunga_kontraktual = $('#31').val().replace(/\D/g, "");
        var biaya_transaksi = $('#41').val().replace(/\D/g, "");
        var koreksi_atas_pendapatan_bunga = $('#44').val().replace(/\D/g, "");

        var sub_total_beban_bunga = Number(beban_bunga_kontraktual) + Number(biaya_transaksi) + Number(koreksi_atas_pendapatan_bunga);

        $('#30').val(numberFormat(sub_total_beban_bunga)).change();
        $('#45').val(numberFormat(sub_total_beban_bunga)).change();
    });

    $('#28, #45').on('change keyup',function()
    {
        var total_pendapatan_operasional = $('#28').val().replace(/\D/g, "");
        var sub_total_beban_bunga = $('#45').val().replace(/\D/g, "");

        var pendapatan_operasional_setelah_beban_bunga = Number(total_pendapatan_operasional) - Number(sub_total_beban_bunga)

        $('#46').val(numberFormat(pendapatan_operasional_setelah_beban_bunga)).change();
    });

    $('#50, #52, #53').on('change keyup',function()
    {
        var kepada_bank_lain = $('#52').val().replace(/\D/g, "");
        var kepada_pihak_ketiga_bukan_bank = $('#53').val().replace(/\D/g, "");

        var kredit_yang_diberikan = Number(kepada_bank_lain) + Number(kepada_pihak_ketiga_bukan_bank)
        var penempatan_pada_bank_lain = $('#50').val().replace(/\D/g, "");
        var beban_penyisihan_penghapusan_aset_produktif = Number(penempatan_pada_bank_lain) + Number(kredit_yang_diberikan);

        $('#48').val(numberFormat(beban_penyisihan_penghapusan_aset_produktif)).change();
        $('#51').val(numberFormat(kredit_yang_diberikan)).change();
    });

    $('#58, #59, #60').on('change keyup',function()
    {
        var gaji_upah = $('#58').val().replace(/\D/g, "");
        var honorarium = $('#59').val().replace(/\D/g, "");
        var lainnya = $('#60').val().replace(/\D/g, "");

        var beban_tenaga_kerja = Number(gaji_upah) + Number(honorarium) + Number(lainnya);

        $('#57').val(numberFormat(beban_tenaga_kerja)).change();
    });

    $('#63, #64').on('change keyup',function()
    {
        var gedung_kantor = $('#63').val().replace(/\D/g, "");
        var lainnya = $('#64').val().replace(/\D/g, "");

        var beban_sewa = Number(gedung_kantor) + Number(lainnya);

        $('#62').val(numberFormat(beban_sewa)).change();
    });

    $('#72, #73, #74').on('change keyup',function()
    {
        var kerugian_penjualan_valuta_asing = $('#72').val().replace(/\D/g, "");
        var kerugian_penjualan_surat_berharga = $('#73').val().replace(/\D/g, "");
        var lainnya = $('#74').val().replace(/\D/g, "");

        var beban_lainnya = Number(kerugian_penjualan_valuta_asing) + Number(kerugian_penjualan_surat_berharga) + Number(lainnya);

        $('#71').val(numberFormat(beban_lainnya)).change();
    });

    $('#57, #61, #62, #65, #66, #67, #68, #69, #70').on('change keyup', function(){
        var beban_tenaga_kerja = $('#57').val().replace(/\D/g, "");
        var biaya_pendidikan_dan_pelatihan = $('#61').val().replace(/\D/g, "");
        var beban_sewa = $('#62').val().replace(/\D/g, "");
        var beban_penyusutan = $('#65').val().replace(/\D/g, "");
        var beban_amortisasi_aset_tidak_berwujud = $('#66').val().replace(/\D/g, "");
        var beban_premi_asuransi = $('#67').val().replace(/\D/g, "");
        var beban_pemeliharaan_dan_perbaikan = $('#68').val().replace(/\D/g, "");
        var beban_barang_dan_jasa = $('#69').val().replace(/\D/g, "");
        var pajak_pajak = $('#70').val().replace(/\D/g, "");

        var beban_administrasi_dan_umum = Number(beban_tenaga_kerja) + Number(biaya_pendidikan_dan_pelatihan) + Number(beban_sewa);
        var beban_administrasi_dan_umum = Number(beban_administrasi_dan_umum) + Number(beban_penyusutan) + Number(beban_amortisasi_aset_tidak_berwujud);
        var beban_administrasi_dan_umum = Number(beban_administrasi_dan_umum) + Number(beban_premi_asuransi) + Number(beban_pemeliharaan_dan_perbaikan);
        var beban_administrasi_dan_umum = Number(beban_administrasi_dan_umum) + Number(beban_barang_dan_jasa) + Number(pajak_pajak);

        $('#56').val(numberFormat(beban_administrasi_dan_umum)).change();
    });

    $('#45, #47, #48, #54, #55, #56, #71').on('change keyup',function()
    {
        var sub_total_beban_bunga = $('#45').val().replace(/\D/g, "");
        var kerugian_rektrukturisasi_kredit = $('#47').val().replace(/\D/g, "");
        var beban_penyisihan_penghapusan_aset_produktif = $('#48').val().replace(/\D/g, "");
        var beban_pemasaran = $('#54').val().replace(/\D/g, "");
        var beban_penelitian_dan_pengembangan = $('#55').val().replace(/\D/g, "");
        var beban_administrasi_dan_umum = $('#56').val().replace(/\D/g, "");
        var beban_lainnya = $('#71').val().replace(/\D/g, "");

        // 
        var pinjaman_yang_diterima = $('#35').val().replace(/\D/g, "");

        var sub_total_beban_operasional = Number(sub_total_beban_bunga) + Number(kerugian_rektrukturisasi_kredit) + Number(beban_penyisihan_penghapusan_aset_produktif);
        var sub_total_beban_operasional = Number(sub_total_beban_operasional) + Number(beban_pemasaran) + Number(beban_penelitian_dan_pengembangan);
        var sub_total_beban_operasional = Number(sub_total_beban_operasional) + Number(beban_administrasi_dan_umum) + Number(beban_lainnya);
        //var sub_total_beban_operasional = Number(sub_total_beban_operasional) - Number(pinjaman_yang_diterima);

        var total_pendapatan_operasional = $('#28').val().replace(/\D/g, "");

        var laba_rugi_operasional = Number(total_pendapatan_operasional) - sub_total_beban_operasional;

        $('#29').val(numberFormat(sub_total_beban_operasional)).change();
        $('#75').val(numberFormat(sub_total_beban_operasional)).change();
        $('#76').val(numberFormat(laba_rugi_operasional)).change();
    });

    $('#78, #79, #80, #81, #82, #83').on('change keyup', function(){
        var keuntungan_karena_penjualan_aktiva_tetap_dan_invetaris = $('#78').val().replace(/\D/g, "");
        var pemulihan_penurunan_nilai = $('#79').val().replace(/\D/g, "");
        var pendapatan_ganti_rugi_asuransi = $('#80').val().replace(/\D/g, "");
        var bunga_antar_kantor = $('#81').val().replace(/\D/g, "");
        var selisih_kurs = $('#82').val().replace(/\D/g, "");
        var lainnya = $('#83').val().replace(/\D/g, "");

        var pendapatan_non_operasional = Number(keuntungan_karena_penjualan_aktiva_tetap_dan_invetaris) + Number(pemulihan_penurunan_nilai);
        var pendapatan_non_operasional = Number(pendapatan_non_operasional) + Number(pendapatan_ganti_rugi_asuransi) + Number(bunga_antar_kantor);
        var pendapatan_non_operasional = Number(pendapatan_non_operasional) + Number(selisih_kurs) + Number(lainnya);

        $('#77').val(numberFormat(pendapatan_non_operasional)).change();
    });

    $('#85, #86, #87, #88, #89').on('change keyup', function(){
        var kerugian_penjualan_kehilangan = $('#85').val().replace(/\D/g, "");
        var kerugian_penurunan_nilai = $('#86').val().replace(/\D/g, "");
        var bunga_antar_kantor = $('#87').val().replace(/\D/g, "");
        var selisih_kurs = $('#88').val().replace(/\D/g, "");
        var lainnya = $('#89').val().replace(/\D/g, "");

        var beban_non_operasional = Number(kerugian_penjualan_kehilangan) + Number(kerugian_penurunan_nilai) + Number(bunga_antar_kantor);
        var beban_non_operasional = Number(beban_non_operasional) + Number(selisih_kurs) + Number(lainnya);

        var pendapatan_non_operasional = $('#77').val().replace(/\D/g, "");
        var laba_rugi_non_operasional = Number(pendapatan_non_operasional) - beban_non_operasional;

        var laba_rugi_operasional = $('#76').val().replace(/\D/g, "");

        var laba_rugi_tahun_berjalan_sebelum_pajak = Number(laba_rugi_operasional) + Number(pendapatan_non_operasional);
        var laba_rugi_tahun_berjalan_sebelum_pajak = Number(laba_rugi_tahun_berjalan_sebelum_pajak) - Number(beban_non_operasional);

        $('#84').val(numberFormat(beban_non_operasional)).change();
        $('#90').val(numberFormat(laba_rugi_non_operasional)).change();
        $('#91').val(numberFormat(laba_rugi_tahun_berjalan_sebelum_pajak)).change();
    });

    $('#91, #92').on('change keyup', function(){
        var taksiran_pajak_penghasilan = $('#92').val().replace(/\D/g, "");
        var laba_rugi_tahun_berjalan_sebelum_pajak = $('#91').val().replace(/\D/g, "");

        var laba_rugi_bersih_tahun_berjalan = Number(laba_rugi_tahun_berjalan_sebelum_pajak) - Number(taksiran_pajak_penghasilan);

        $('#93').val(numberFormat(laba_rugi_bersih_tahun_berjalan)).change();
    });
});
</script>
@endpush
