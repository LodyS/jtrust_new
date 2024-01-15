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
        <h5 style="text-align:center;">ATMR {{ strtoupper(\App\Models\InformasiPokokBprPelapor::namaBpr($sandi_bpr)->nama_bpr) ?? '' }}</h5>

        <div style="height:30px" align="centre"></div>

        <form action="{{ url('cari-atmr') }}" method="POST" name="action" value="simpan">@csrf

            <input type="hidden" name="sandi_bpr" value="{{ $sandi_bpr ?? '' }}">

            @include('menu-laporan-bulanan')
            <br/>
            @include('flash-message')

            <br/>

            <div class="form-group row">
                <label class="col-md-3">Pilih Bulan </label>
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

            <?php $tahun_pilih = date('Y'); ?>
            <div class="form-group row">
                <label class="col-md-3">Pilih Tahun</label>
                    <div class="col-md-7">
                    <select name="tahun" id="tahun" class="form-control select">
                        <option value="">Pilih</option>
                        @for($i=2019; $i<=$tahun_pilih; $i++)
                        <option value="{{ $i }}">{{ $i}} </option>
                        @endfor
                    </select>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Cari</button>
            </div>
        </form>

        <div style="height:20px"></div>

        <form action="{{ url('store-atmr') }}" method="POST" name="action" value="simpan">@csrf

            <input type="hidden" name="sandi_bpr" value="{{ $sandi_bpr ?? '' }}">

            <table class="table table-stripped" id="table">
                <tr>
                    <th style="font-size:11px">No</th>
                    <th style="font-size:11px">KETERANGAN</th>
                    <th style="text-align:right; font-size: 11px;">Periode Laporan Keuangan <br/>{{ bulan($bulan) }} {{ $tahun }}</th>
                    <th style="text-align:right; font-size: 11px;">Risiko</th>
                    <th style="text-align:right; font-size: 11px;">Nominal ATMR</th>
                </tr>

                <input type="hidden" name="bulann" value="{{ $bulan }}">
                <input type="hidden" name="tahunn" value="{{ $tahun }}">

                <?php $kas = $data->where('sandi_coa', '1101010000')->sum('posisi_tanggal_laporan'); ?>
                <tr class="sum">
                    <td style="font-size:11px">1</td>
                    <td style="font-size:11px"><textarea rows="5" name="keterangan[]" class="form-control">Kas</textarea></td>
                    <td style="text-align:right; font-size: 11px;"><input type="text" name="nominal[]" class="form-control nominal" value="{{ number_format($kas) }}" style="text-align:right;"></td>
                    <td style="text-align:right; font-size: 11px;"><input type="number" name="persen[]" class="form-control persen" value="0" style="text-align:right;"></td>
                    <td style="text-align:right; font-size: 11px;"><input type="text" class="form-control total" name="total[]" readonly  value="{{ number_format($kas * 0) }}" style="text-align:right;"></td>
                </tr>

                <tr class="sum">
                    <td style="font-size:11px"></td>
                    <td style="font-size:11px"><textarea rows="5" name="keterangan[]" class="form-control">Sertifikat Bank Indonesia</textarea></td>
                    <td style="text-align:right; font-size: 11px;"><input type="text" name="nominal[]" value="0" class="form-control nominal" style="text-align:right;"></td>
                    <td style="text-align:right; font-size: 11px;"><input type="number" name="persen[]" value="0" class="form-control persen" style="text-align:right;"></td>
                    <td style="text-align:right; font-size: 11px;"><input type="text" class="form-control total" name="total[]" readonly value="0" style="text-align:right;"></td>
                </tr>

                <tr class="sum">
                    <td style="font-size:11px"></td>
                    <td style="font-size:11px"><textarea rows="5" name="keterangan[]" class="form-control">Kredit dengan agunan berupa SBI, tabungan dan deposito yang diblokir pada BPR yang bersangkutan disertai dengan surat kuasa pencairan, emas dan logam mulia,sebesar nilai terendah antara agunan dan baki debet</textarea></td>
                    <td style="text-align:right; font-size: 11px;"><input type="text" name="nominal[]" value="0" class="form-control nominal" style="text-align:right;"></td>
                    <td style="text-align:right; font-size: 11px;"><input type="number" name="persen[]" value="0" class="form-control persen" style="text-align:right;"></td>
                    <td style="text-align:right; font-size: 11px;"><input type="text" class="form-control total" name="total[]" readonly value="0" style="text-align:right;"></td>
                </tr>

                <tr class="sum">
                    <td style="font-size:11px"></td>
                    <td style="font-size:11px"><textarea rows="5" name="keterangan[]" class="form-control">Kredit kepada pemerintah pusat</textarea></td>
                    <td style="text-align:right; font-size: 11px;"><input type="text" name="nominal[]" value="0" class="form-control nominal" style="text-align:right;"></td>
                    <td style="text-align:right; font-size: 11px;"><input type="number" name="persen[]" value="0" class="form-control persen" style="text-align:right;"></td>
                    <td style="text-align:right; font-size: 11px;"><input type="text" class="form-control total"  name="total[]" value="0" readonly  style="text-align:right;"></td>
                </tr>

                <?php $dua = $data->where('sandi_coa', 1103010000)->sum('posisi_tanggal_laporan'); ?>
                <tr class="sum">
                    <td style="font-size:11px">2</td>
                    <td style="font-size:11px"><textarea rows="5" name="keterangan[]" class="form-control">Giro, deposito, sertifikat deposito, tabungan serta tagihan lainnya kepada bank lain</textarea></td>
                    <td style="text-align:right; font-size: 11px;"><input type="text" name="nominal[]" class="form-control nominal" value="{{ number_format($dua) }}" style="text-align:right;"></td>
                    <td style="text-align:right; font-size: 11px;"><input type="number" name="persen[]"  class="form-control persen" value="20" style="text-align:right;"></td>
                    <td style="text-align:right; font-size: 11px;"><input type="text" class="form-control total" name="total[]" readonly  value="{{ number_format($dua * 0.2) }}" style="text-align:right;"></td>
                </tr>

                <tr class="sum">
                    <td style="font-size:11px"></td>
                    <td style="font-size:11px"><textarea rows="5" name="keterangan[]" class="form-control">Kredit kepada atau yang dijamin bank lain atau pemerintah daerah</textarea></td>
                    <td style="text-align:right; font-size: 11px;"><input type="text" name="nominal[]" value="0" class="form-control nominal" style="text-align:right;"></td>
                    <td style="text-align:right; font-size: 11px;"><input type="number" name="persen[]" value="0" class="form-control persen" style="text-align:right;"></td>
                    <td style="text-align:right; font-size: 11px;"><input type="text" class="form-control total" value="0" name="total[]" readonly style="text-align:right;"></td>
                </tr>

                <tr class="sum">
                    <td style="font-size:11px">3</td>
                    <td style="font-size:11px"><textarea rows="5" name="keterangan[]" class="form-control">Kredit Pemilikan Rumah (KPR) yang dijamin oleh hak tanggungan pertama dengan tujuan untuk dihuni</textarea></td>
                    <td style="font-size:11px"><input type="text" name="nominal[]" class="form-control nominal" value="0" style="text-align:right;"></td>
                    <td style="text-align:right; font-size: 11px;"><input type="number" name="persen[]" value="0" class="form-control persen" placeholder="40" style="text-align:right;"></td></td>
                    <td style="font-size:11px"><input type="text" class="form-control total" name="total[]" value="0" readonly style="text-align:right;"></td>
                </tr>

                <tr class="sum">
                    <td style="font-size:11px">4</td>
                    <td style="font-size:11px"><textarea rows="5" name="keterangan[]" class="form-control">Kredit kepada atau yang dijamin oleh; BUMD, peorangan, koperasi, perusahaan swasta dan lain-lain.</textarea></td>
                    <td style="font-size:11px"><input type="text" name="nominal[]" class="form-control nominal" value="0" style="text-align:right;"></td>
                    <td style="text-align:right; font-size: 11px;"><input type="number" name="persen[]" value="0" class="form-control persen" placeholder="50" style="text-align:right;"></td>
                    <td style="font-size:11px"><input type="text" class="form-control total" name="total[]" value="0" readonly style="text-align:right;"></td>
                </tr>

                <tr class="sum">
                    <td style="font-size:11px"></td>
                    <td style="font-size:11px"><textarea rows="5" name="keterangan[]" class="form-control">Kredit kepada pegawai/pensiunan, yang memenuhi persyaratan sebagai berikut: </textarea></td>
                    <td style="font-size:11px"><input type="text" name="nominal[]" class="form-control nominal" value="0" style="text-align:right;"></td>
                    <td style="text-align:right; font-size: 11px;"><input type="number" name="persen[]" value="0" class="form-control persen" style="text-align:right;"></td>
                    <td style="font-size:11px"><input type="text" class="form-control total" name="total[]" value="0" readonly style="text-align:right;"></td>
                </tr>

                <tr class="sum">
                    <td style="font-size:11px"></td>
                    <td style="font-size:11px"><textarea rows="5" name="keterangan[]" class="form-control">A. Pegawai atau pensiunan PNS, anggota TNI/POLRI, pegawai lembaga negara atau pegawai BUMN/BUMD</textarea></td>
                    <td style="font-size:11px"><input type="text" name="nominal[]" class="form-control nominal" value="0" style="text-align:right;"></td>
                    <td style="text-align:right; font-size: 11px;"><input type="number" name="persen[]" value="0" class="form-control persen" style="text-align:right;"></td>
                    <td style="font-size:11px"><input type="text" class="form-control total" name="total[]" value="0" readonly style="text-align:right;"></td>
                </tr>

                <tr class="sum">
                    <td style="font-size:11px"></td>
                    <td style="font-size:11px"><textarea rows="5" name="keterangan[]" class="form-control">B. Pegawai atau pensiun yang dijamin dengan asuransi jiwa dari perusahaan asuransi yang memiliki izin usaha, laporan terakhir diaudit oleh akuntan publik dan bukan pihak terkait dengan BPR</textarea></td>
                    <td style="font-size:11px"><input type="text" name="nominal[]" class="form-control nominal" value="0" style="text-align:right;"></td>
                    <td style="text-align:right; font-size: 11px;"><input type="number" name="persen[]" value="0" class="form-control persen" style="text-align:right;"></td>
                    <td style="font-size:11px"><input type="text" class="form-control total" name="total[]" value="0" readonly style="text-align:right;"></td>
                </tr>

                <tr class="sum">
                    <td style="font-size:11px"></td>
                    <td style="font-size:11px"><textarea rows="5" name="keterangan[]" class="form-control">C. Pembayaran angsuran/pelunasan bersumber dari gaji/pensiun berdasarkan surat kuasa memotong gaji/pensiun;</textarea></td>
                    <td style="font-size:11px"><input type="text" name="nominal[]" class="form-control nominal" value="0" style="text-align:right;"></td>
                    <td style="text-align:right; font-size: 11px;"><input type="number" name="persen[]" value="0" class="form-control persen" style="text-align:right;"></td>
                    <td style="font-size:11px"><input type="text" class="form-control total" name="total[]" value="0" readonly style="text-align:right;"></td>
                </tr>

                <tr class="sum">
                    <td style="font-size:11px"></td>
                    <td style="font-size:11px"><textarea rows="5" name="keterangan[]" class="form-control">D. BPR menyimpan asli surat pengangkatan pegawai/surat keputusan pensiun/kartu registrasi induk pasien dan polis pertanggungan asuransi jiwa debitur</textarea></td>
                    <td style="font-size:11px"><input type="text" name="nominal[]" class="form-control nominal" value="0" style="text-align:right;"></td>
                    <td style="text-align:right; font-size: 11px;"><input type="number" name="persen[]" value="0" class="form-control persen" style="text-align:right;"></td>
                    <td style="font-size:11px"><input type="text" class="form-control total" name="total[]" value="0" readonly style="text-align:right;"></td>
                </tr>

                <tr class="sum">
                    <td style="font-size:11px"></td>
                    <td style="font-size:11px"><textarea rows="5" name="keterangan[]" class="form-control">E. Kredit kepada usaha mikro dan kecil</textarea></td>
                    <td style="font-size:11px"><input type="text" name="nominal[]" class="form-control nominal" value="0" style="text-align:right;"></td>
                    <td style="text-align:right; font-size: 11px;"><input type="number" name="persen[]" value="0" class="form-control persen" style="text-align:right;"></td>
                    <td style="font-size:11px"><input type="text" class="form-control total" name="total[]" value="0" readonly style="text-align:right;"></td>
                </tr>

                <tr class="sum">
                    <td style="font-size:11px">5</td>
                    <td style="font-size:11px"><textarea rows="5" name="keterangan[]" class="form-control">Kredit kepada usaha mikro dan kecil</textarea></td>
                    <td style="font-size:11px"><input type="text" name="nominal[]"value="0" class="form-control nominal" style="text-align:right;"></td>
                    <td style="text-align:right; font-size: 11px;"><input type="number" name="persen[]" value="0" class="form-control persen" placeholder="85" style="text-align:right;"></td>
                    <td style="font-size:11px"><input type="text" class="form-control total" name="total[]" value="0" readonly style="text-align:right;"></td>
                </tr>

                <?php $enam = $data->where('sandi_coa', 1104010100)->sum('posisi_tanggal_laporan'); ?>
                <tr class="sum">
                    <td style="font-size:11px">6</td>
                    <td style="font-size:11px"><textarea rows="5" name="keterangan[]" class="form-control">Kredit kepada atau yang dijamin oleh perorangan, koperasi, atau kelompok dan perusahaan lainnya</textarea></td>
                    <td style="text-align:right; font-size: 11px;"><input type="text" name="nominal[]" class="form-control nominal" id="nominal6" value="{{ number_format($enam) }}" style="text-align:right;"></td>
                    <td style="text-align:right; font-size: 11px;"><input type="number" name="persen[]" class="form-control persen" value="100" style="text-align:right;"></td>
                    <td style="text-align:right; font-size: 11px;"><input type="text" class="form-control total" name="total[]" value="{{ number_format($enam) }}" readonly style="text-align:right;"></td>
                </tr>

                <?php $nilai_buku = $data->where('sandi_coa', 1202010000)->sum('posisi_tanggal_laporan') - $data->where('sandi_coa', 1202020000)->sum('posisi_tanggal_laporan') +
                    $data->where('sandi_coa', 1203010000)->sum('posisi_tanggal_laporan') - $data->where('sandi_coa', 1203020000)->sum('posisi_tanggal_laporan'); ?>
                <tr class="sum">
                    <td style="font-size:11px">7</td>
                    <td style="font-size:11px"><textarea rows="5" name="keterangan[]" class="form-control">Aktiva Tetap dan Inventaris (nilai buku).</textarea></td>
                    <td style="text-align:right; font-size: 11px;"><input type="text" name="nominal[]" class="form-control nominal" id="nominal7" value="{{ number_format($nilai_buku) }}" style="text-align:right;">
                    <td style="text-align:right; font-size: 11px;"><input type="number" name="persen[]" class="form-control persen" value="100" style="text-align:right;"></td>
                    <td style="text-align:right; font-size: 11px;"><input type="text" class="form-control total" name="total[]" value="{{ number_format($nilai_buku) }}" readonly style="text-align:right;"></td>
                </tr>

                <tr class="sum">
                    <td style="font-size:11px">8</td>
                    <td style="font-size:11px"><textarea rows="5" name="keterangan[]" class="form-control">Aktiva Lainnya</textarea></td>
                    <td style="text-align:right; font-size: 11px;"><input type="text" name="nominal[]" class="form-control nominal" value="{{ number_format($aktiva_lainnya) }}" style="text-align:right;"></td>
                    <td style="text-align:right; font-size: 11px;"><input type="number" name="persen[]" class="form-control persen" value="100" style="text-align:right;"></td>
                    <td style="text-align:right; font-size: 11px;"><input type="text" class="form-control total" name="total[]" value="{{ number_format($aktiva_lainnya) }}" readonly style="text-align:right;"></td>
                </tr>

                <?php $total_atmr = number_format($aktiva_lainnya + $nilai_buku + $enam + ($dua * 0.2) + ($kas * 0)); ?>
                <tr>
                    <td></td>
                    <td style="font-size:11px"><b>TOTAL ATMR</b></td>
                    <td></td>
                    <td></td>
                    <td style="text-align:right; font-size: 11px;"><span id="total_atmr" style="text-align:right;">{{ number_format($aktiva_lainnya + $nilai_buku + $enam + ($dua * 0.2) + ($kas * 0))}}</span></td>
                </tr>
            </table>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" name="action" value="simpan">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>

<script type="text/javascript">
function numberFormat(total)
{
    return total.toString().replace(/(?!\,)\D/g, "").replace(/(?<=\,,*)\./g, "").replace(/(?<=\.\d\d).*/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

$(document).ready(function(){

    $('.nominal').on('change click keyup input paste',(function (event) {
        $(this).val(function (index, value) {
            return value.replace(/(?!\,)\D/g, "").replace(/(?<=\,,*)\./g, "").replace(/(?<=\.\d\d).*/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        });
    }));

    $(".sum input").keyup(multInputs);

    function multInputs()
    {
        var total_atmr = 0;

        $("tr.sum").each(function ()
        {
            var nominal = $('.nominal', this).val().replace(/\D/g, "");
            var persen = $('.persen', this).val();
            var total = (parseInt(persen)  * parseInt(nominal))/100

            $('.total', this).val(numberFormat(total));
            total_atmr += total;
        });

        $("#total_atmr").text(numberFormat(total_atmr));
    }
});
</script>
