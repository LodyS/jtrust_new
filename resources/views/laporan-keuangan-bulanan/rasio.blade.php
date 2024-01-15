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
        <h5 style="text-align:center;">RASIO <br/>{{ strtoupper(\App\Models\InformasiPokokBprPelapor::namaBpr($sandi_bpr)->nama_bpr) ?? '' }}</h5>

        <div style="height:30px"></div>

        <form action="{{ url('cari-rasio') }}" method="POST">@csrf

            <input type="hidden" name="sandi_bpr" value="{{ $sandi_bpr ?? '' }}">

            @include('menu-laporan-bulanan')
            <div style="height:30px"></div>
            @include('flash-message')

            <br/>

            <div class="form-group row">
                <label class="col-md-3">Pilih Bulan</label>
                    <div class="col-md-7">
                    <select name="bulan" class="form-control nominal">
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
                <button type="submit" class="btn btn-primary" name="action" value="cari">Cari</button>
            </div>
        </form>


        <div style="height:30px"></div>

        <form action="{{ url('simpan-rasio') }}" method="POST">@csrf

            <input type="hidden" name="sandi_bpr" value="{{ $sandi_bpr ?? '' }}">
            <input type="hidden" name="bulann" value="{{ $bulan }}">
            <input type="hidden" name="tahunn" value="{{ $tahun }}">

            <table class="table table-stripped" id="bawah">
                <tr>
                    <th>Tanggal </th>
                    <th style="text-align:right;">{{ bulan($bulan) }} {{ $tahun }}</th>
                </tr>

                <tr>
                    <td><b>Aktiva</b></td>
                    <td style="text-align:right; font-size: 14px;"><b>Rp. {{ number_format($aktiva = $total_aktiva)}}</b></td>
                </tr>

                <tr>
                    <td>Kas</td>
                    <td style="text-align:right; font-size: 14px;">Rp. {{ number_format($data->where('sandi_coa', 1101010000)->sum('posisi_tanggal_laporan') <= 0) ? $kas =0 : number_format($kas= $data->where('sandi_coa', 1101010000)->sum('posisi_tanggal_laporan')) }}</td>
                </tr>

                <tr>
                    <td>Penempatan pada Bank Indonesia</td>
                    <td style="text-align:right; font-size: 14px;">Rp. {{ ($data->where('sandi_coa', '1101020000')->sum('posisi_tanggal_laporan') < 0) ? $penempatan_pada_bank_lain = 0 : number_format($penempatan_pada_bank_lain = $data->where('sandi_coa', '1101020000')->sum('posisi_tanggal_laporan')) }}</td>
                </tr>

                <tr>
                    <td>Giro Pada Bank Lain</td>
                    <td style="text-align:right; font-size: 14px;">Rp. {{ ($data->where('sandi_coa', '1103010001')->sum('posisi_tanggal_laporan') < 0) ? $giro_pada_bank_lain = 0 : number_format($giro_pada_bank_lain = $data->where('sandi_coa', '1103010001')->sum('posisi_tanggal_laporan')) }}</td>
                </tr>

                <tr>
                    <td>Tabungan pada bank lain</td>
                    <td style="text-align:right; font-size: 14px;">Rp. {{ ($data->where('sandi_coa', '1103010002')->sum('posisi_tanggal_laporan') < 0) ? $tabungan_pada_bank_lain = 0 : number_format($tabungan_pada_bank_lain = $data->where('sandi_coa', '1103010002')->sum('posisi_tanggal_laporan')) }}</td>
                </tr>

                <tr>
                    <td>Deposito pada Bank lain</td>
                    <td style="text-align:right; font-size: 14px;">Rp. {{ ($data->where('sandi_coa', '1103010003')->sum('posisi_tanggal_laporan') < 0) ? $deposito_pada_bank_lain = 0 : number_format($deposito_pada_bank_lain = $data->where('sandi_coa', '1103010003')->sum('posisi_tanggal_laporan')) }}</td>
                </tr>

                <tr>
                    <td>Pembiayaan/Kredit</td>
                    <td style="text-align:right; font-size: 14px;">Rp. {{ ($data->where('sandi_coa', '1104010100')->sum('posisi_tanggal_laporan') < 0) ? $pembiayaan_kredit = 0 : number_format($pembiayaan_kredit = $data->where('sandi_coa', '1104010100')->sum('posisi_tanggal_laporan')) }}</td>
                </tr>

                <input type="hidden" name="pos[]" value="Pembiayaan Yang Diberikan">
                <input type="hidden" name="jumlah[]" value="{{ $pembiayaan_kredit }}">

                <tr>
                    <td>Kolektibilitas Kurang Lancar</td>
                    <td style="text-align:right; font-size: 14px;">Rp. {{ ($data->where('sandi_coa', '1104010103')->sum('posisi_tanggal_laporan') < 0) ? $kol_kurang_lancar = 0 : number_format($kol_kurang_lancar = $data->where('sandi_coa', '1104010103')->sum('posisi_tanggal_laporan')) }}</td>
                </tr>

                <tr>
                    <td>Kolektibilitas Diragukan</td>
                    <td style="text-align:right; font-size: 14px;">Rp. {{ ($data->where('sandi_coa', '1104010104')->sum('posisi_tanggal_laporan') < 0) ? $kol_diragukan = 0 : number_format($kol_diragukan =$data->where('sandi_coa', '1104010104')->sum('posisi_tanggal_laporan')) }}</td>
                </tr>

                <tr>
                    <td>Kolektibilitas Macet</td>
                    <td style="text-align:right; font-size: 14px;">Rp. {{ ($data->where('sandi_coa', '1104010105')->sum('posisi_tanggal_laporan') < 0) ? $kol_macet = 0 : number_format($kol_macet = $data->where('sandi_coa', '1104010105')->sum('posisi_tanggal_laporan')) }}</td>
                </tr>

                <input type="hidden" name="pos[]" value="Pembiayaan Yang Diberikan Bermasalah">
                <input type="hidden" name="jumlah[]" value="{{ $kol_kurang_lancar + $kol_diragukan + $kol_macet }}">

                <tr>
                    <td>PPAP Tersedia</td>
                    <td style="text-align:right; font-size: 14px;">Rp. {{ number_format($papp_tersedia = $data->where('sandi_coa', '1104020000')->sum('posisi_tanggal_laporan') + $data->where('sandi_coa', '1103020000')->sum('posisi_tanggal_laporan')) }}</td>
                </tr>

                <!-- Passiva -->

                <tr>
                    <td><b>Passiva</b></td>
                    <td style="text-align:right; font-size: 14px;"><b>Rp. {{ number_format($total_passiva = $data->where('pos', 'TOTAL  KEWAJIBAN DAN EKUITAS')->sum('posisi_tanggal_laporan')) }}</b></td>
                </tr>

                <tr>
                    <td>Kewajiban Segera</td>
                    <td style="text-align:right; font-size: 14px;">Rp. {{ ($data->where('sandi_coa', '2101000000')->sum('posisi_tanggal_laporan') < 0) ? $kewajiban_segera = 0 : number_format($kewajiban_segera = $data->where('sandi_coa', '2101000000')->sum('posisi_tanggal_laporan')) }}</td>
                </tr>

                <tr>
                    <td>Tabungan</td>
                    <td style="text-align:right; font-size: 14px;">Rp. {{ ($data->where('sandi_coa', '2102010100')->sum('posisi_tanggal_laporan') < 0) ? $tabungan = 0 : number_format($tabungan = $data->where('sandi_coa', '2102010100')->sum('posisi_tanggal_laporan')) }}</td>
                </tr>

                <input type="hidden" name="pos[]" value="Tabungan">
                <input type="hidden" name="jumlah[]" value="{{ $tabungan }}">

                <tr>
                    <td>Deposito</td>
                    <td style="text-align:right; font-size: 14px;">Rp. {{ ($data->where('sandi_coa', '2102020100')->sum('posisi_tanggal_laporan') < 0) ? $deposito = 0 : number_format($deposito = $data->where('sandi_coa', '2102020100')->sum('posisi_tanggal_laporan')) }}</td>
                </tr>

                <input type="hidden" name="pos[]" value="Deposito">
                <input type="hidden" name="jumlah[]" value="{{ $deposito }}">

                <tr>
                    <td>Tabungan Dari Bank Lain</td>
                    <td style="text-align:right; font-size: 14px;">Rp. {{ ($data->where('pos', 'Tabungan dari bank lain')->sum('posisi_tanggal_laporan') < 0) ? $tabungan_dari_bank_lain = 0 : number_format($tabungan_dari_bank_lain = $data->where('pos', 'Tabungan dari bank lain')->sum('posisi_tanggal_laporan')) }}</td>
                </tr>

                <input type="hidden" name="pos[]" value="Tabungan Dari Bank Lain">
                <input type="hidden" name="jumlah[]" value="{{ $tabungan_dari_bank_lain }}">

                <tr>
                    <td>Deposito Dari Bank Lain</td>
                    <td style="text-align:right; font-size: 14px;">Rp. {{ ($data->where('pos', 'Deposito dari bank lain')->sum('posisi_tanggal_laporan') < 0) ? $deposito_dari_bank_lain = 0 : number_format($deposito_dari_bank_lain = $data->where('pos', 'Deposito dari bank lain')->sum('posisi_tanggal_laporan')) }}</td>
                </tr>

                <input type="hidden" name="pos[]" value="Deposito Dari Bank Lain">
                <input type="hidden" name="jumlah[]" value="{{ $deposito_dari_bank_lain }}">

                <tr>
                    <td>Pembiayaan yg diterima dengan jatuh tempo <= 3 bln</td>
                    <td style="text-align:right; font-size: 14px;">Rp. {{ ($data->where('sandi_coa', '2201010100')->sum('posisi_tanggal_laporan') < 0) ? $pembiayaan_kurang_tiga_bulan = 0 : number_format($pembiayaan_kurang_tiga_bulan = $data->where('sandi_coa', '2201010100')->sum('posisi_tanggal_laporan')) }}</td>
                </tr>

                <input type="hidden" name="pos[]" value="Pembiayaan yg diterima dengan jatuh tempo <= 3 bln">
                <input type="hidden" name="jumlah[]" value="{{ $pembiayaan_kurang_tiga_bulan }}">

                <tr>
                    <td>Pembiayaan yg diterima dengan jatuh tempo > 3 bln</td>
                    <td style="text-align:right; font-size: 14px;">Rp. {{ ($data->where('sandi_coa', '2201010200')->sum('posisi_tanggal_laporan') < 0) ? $pembiayaan_lebih_tiga_bulan= 0 : number_format($pembiayaan_lebih_tiga_bulan = $data->where('sandi_coa', '2201010200')->sum('posisi_tanggal_laporan')) }}</td>
                </tr>

                <input type="hidden" name="pos[]" value="Pembiayaan yg diterima dengan jatuh tempo > 3 bln">
                <input type="hidden" name="jumlah[]" value="{{ $pembiayaan_lebih_tiga_bulan }}">

                <tr>
                    <td>Rupa-rupa Pasiva</td>
                    <td style="text-align:right; font-size: 14px;">Rp. {{ ($data->where('pos', 'Modal pinjaman')->sum('posisi_tanggal_laporan') < 0) ? 0 : number_format($data->where('pos', 'Modal pinjaman')->sum('posisi_tanggal_laporan')) }}</td>
                </tr>

                <tr>
                    <td>Pinjaman subordinasi</td>
                    <td style="text-align:right; font-size: 14px;">Rp. {{ ($data->where('pos', 'Pinjaman subordinasi')->sum('posisi_tanggal_laporan') < 0) ? $pinjaman_subordinasi = 0 : number_format($pinjaman_subordinasi = $data->where('pos', 'Pinjaman subordinasi')->sum('posisi_tanggal_laporan')) }}</td>
                </tr>

                <?php $jumlah_ekuitas = $data->where('sandi_coa', 3000000000)->sum('posisi_tanggal_laporan'); ?>
                <tr>
                    <td>Jumlah Ekuitas</td>
                    <td style="text-align:right; font-size: 14px;">Rp. {{ ($jumlah_ekuitas < 0) ? 0 : number_format($jumlah_ekuitas) }}</td>
                </tr>

                <tr>
                    <td>Modal Disetor</td>
                    <td style="text-align:right; font-size: 14px;">Rp. {{ ($data->where('pos', 'Komponen Modal')->sum('posisi_tanggal_laporan') < 0) ? $modal_disetor = 0 : number_format($modal_disetor = $data->where('pos', 'Komponen Modal')->sum('posisi_tanggal_laporan')) }}</td>
                </tr>

                <?php $modal_pinjaman = $data->where('sandi_coa', 2298000000)->sum('posisi_tanggal_laporan'); ?>
                <tr>
                    <td>Modal Pinjaman</td>
                    <td style="text-align:right; font-size: 14px;">Rp. {{ ($modal_pinjaman < 0 || $modal_pinjaman == 0 ) ? $modal_pinjaman = 0 : number_format($modal_pinjaman = $modal_pinjaman - $data->where('sandi_coa', 3101020000)->sum('posisi_tanggal_laporan')) }}</td>
                </tr>

                <tr>
                    <td></td>
                    <td></td>
                </tr>

                <tr>
                    <th>Laba (Rugi)</th>
                    <th style="text-align:right;">{{ bulan($bulan)}} {{ $tahun }}</th>
                </tr>

                <tr>
                    <td>Pendapatan Bunga</td>
                    <td style="text-align:right; font-size: 14px;">Rp. {{ ($laba_rugi->where('sandi_coa', '4101000000')->sum('posisi_tanggal_laporan')  < 0) ? $pendapatan_bunga = 0 : number_format($pendapatan_bunga = $laba_rugi->where('sandi_coa', '4101000000')->sum('posisi_tanggal_laporan')) }}</td>
                </tr>

                <tr>
                    <td>Beban Bunga</td>
                    <td style="text-align:right; font-size: 14px;">Rp. {{ ($beban_bunga  < 0) ? 0 : number_format($beban_bunga) }}</td>
                </tr>

                <?php $pendapatan_operasional_satu = ($pendapatan_operasional  < 0) ?  0 :  $total_pendapatan_operasional ?>
                <tr>
                    <td>Pendapatan Operasional</td>
                    <td style="text-align:right; font-size: 14px;">Rp. {{ number_format($pendapatan_operasional_satu) }}</td>
                </tr>

                <?php $beban_operasional_non_bunga = $sub_total_beban_operasional - $sub_total_beban_bunga; ?>
                <tr>
                    <td>Beban operasional (non beban bunga)</td>
                    <td style="text-align:right; font-size: 14px;">Rp. {{ ($beban_operasional_non_bunga < 0) ? 0 : number_format($beban_operasional_non_bunga) }}</td>
                </tr>

                <tr>
                    <td>Beban Operasional</td>
                    <td style="text-align:right; font-size: 14px;">Rp. {{ ($sub_total_beban_operasional < 0) ? 0 : number_format($sub_total_beban_operasional)}}</td>
                </tr>

                <?php $laba_rugi_sebelum_pajak = $laba_rugi->where('pos', 'LABA/(RUGI) TAHUN BERJALAN SEBELUM PAJAK')->sum('posisi_tanggal_laporan'); ?>
                <tr>
                    <td>LABA/(RUGI) TAHUN BERJALAN SEBELUM PAJAK</td>
                    <td style="text-align:right; font-size: 14px;">Rp. {{ ( $laba_rugi_sebelum_pajak < 0) ? $laba_rugi_sebelum_pajak = 0 : number_format($laba_rugi_sebelum_pajak)}}</td>
                </tr>

                <tr>
                    <td></td>
                    <td></td>
                </tr>

                <tr>
                    <td>Penempatan Pada Bank Lain</td>
                    <td style="text-align:right; font-size: 14px;">Rp. {{ ($data->where('sandi_coa', 1103010000)->sum('posisi_tanggal_laporan') < 0) ? 0 : number_format($data->where('sandi_coa', 1103010000)->sum('posisi_tanggal_laporan'))}}</td>
                </tr>

                <input type="hidden" name="pos[]" value="Penempatan Pada Bank Lain">
                <input type="hidden" name="jumlah[]" value="{{ ($data->where('sandi_coa', 1103010000)->sum('posisi_tanggal_laporan') < 0) ? 0 : $data->where('sandi_coa', 1103010000)->sum('posisi_tanggal_laporan') }}">

                <tr>
                    <td>Kewajiban Kepada Bank Lain</td>
                    <td style="text-align:right; font-size: 14px;">Rp. {{ ($data->whereIn('sandi_coa', [2103010000, 2201010000])->sum('posisi_tanggal_laporan') <= 0) ? 0 : number_format($data->whereIn('sandi_coa', [2103010000, 2201010000])->sum('posisi_tanggal_laporan'))}}</td>
                </tr>

                <tr>
                    <td>PPAP Wajib</td>
                    <td style="text-align:right; font-size: 14px;">Rp. {{ ($perhitungan_ppap_wajib <= 0) ? 0 : number_format($perhitungan_ppap_wajib)}}</td>
                </tr>

                <tr>
                    <td>Total Aktiva Produktif</td>
                    <td style="text-align:right; font-size: 14px;">Rp. {{ ($total_aktiva_produktif <= 0) ? 0 : number_format($total_aktiva_produktif)}}</td>
                </tr>

                <tr>
                    <td>Modal Inti</td>
                    <td style="text-align:right; font-size: 14px;">Rp. {{ ($modal_inti <= 0) ? 0 : number_format($modal_inti)}}</td>
                </tr>

                <tr>
                    <td>Modal CAR</td>
                    <td style="text-align:right; font-size: 14px;">Rp. {{ ($jumlah_modal_inti_pelengkap <= 0) ? 0 : number_format($modal_car = $jumlah_modal_inti_pelengkap)}}</td>
                </tr>

                <tr>
                    <td>ATMR</td>
                    <td style="text-align:right; font-size: 14px;">Rp. {{ ($atmr <= 0) ? 0 : number_format($atmr)}}</td>
                </tr>

            </table>

            <div style="height:30px"></div>

            <table class="table table-stripped" id="atas">

                <tr>
                    <th></th>
                    <th>Tanggal</th>
                    <th style="text-align:right;">{{ bulan($bulan) }} {{ $tahun }}</th>
                </tr>

                <?php
                    $ldr_dua = $tabungan + $deposito + $deposito_dari_bank_lain + $pembiayaan_lebih_tiga_bulan + $modal_pinjaman + $modal_inti;
                ?>
                <tr>
                    <td><b>1</b></td>
                    <td><b>LDR</b></td>
                    <td style="text-align:right; font-size: 14px;"><b>{{ ($ldr_dua == 0 || $pembiayaan_kredit == 0) ? $ldrr = 0 : $ldrr = round(($pembiayaan_kredit/$ldr_dua) *100,2)  }} %</b></td>
                </tr>

                <input type="hidden" name="pos[]" value="LDR">
                <input type="hidden" name="jumlah[]" value="{{ $ldrr }}">

                <tr>
                    <td></td>
                    <td>Pembiayaan yang diberikan</td>
                    <td style="text-align:right; font-size: 14px;">Rp. {{ number_format($pembiayaan_kredit) }}</td>
                </tr>

                <tr>
                    <td></td>
                    <td>(Tabungan + Deposito + Bank Indonesia + Deposito dari bank lain + <br/>Pinjaman diterima + Modal pinjaman + modal inti)</td>
                    <td style="text-align:right; font-size: 14px;">Rp. {{ number_format($ldr_dua) }}</td>
                </tr>

                <?php $antar_bank_pasiva_aktiva =($tabungan_dari_bank_lain + $deposito_dari_bank_lain + $pembiayaan_kurang_tiga_bulan)
                - ($giro_pada_bank_lain + $tabungan_pada_bank_lain + $deposito_pada_bank_lain);  ?>
                <tr>
                    <td><b>2</b></td>
                    <td><b>Kewajiban bersih terhadap modal inti</b></td>
                    <td style="text-align:right; font-size: 14px;"><b>{{ ($modal_inti ==0 || $antar_bank_pasiva_aktiva == 0) ? $kewajiban_bersih_terhadap_modal_intii = 0 : $kewajiban_bersih_terhadap_modal_intii = round(($antar_bank_pasiva_aktiva/$modal_inti) *100,2)  }} %</b></td>
                </tr>

                <input type="hidden" name="pos[]" value="Kewajiban bersih terhadap modal inti">
                <input type="hidden" name="jumlah[]" value="{{ $kewajiban_bersih_terhadap_modal_intii }}">

                <tr>
                    <td></td>
                    <td>(Antar Bank Pasiva - Antar Bank Aktiva)</td>
                    <td style="text-align:right; font-size: 14px;">Rp. {{ number_format($antar_bank_pasiva_aktiva) }}</td>
                </tr>

                <tr>
                    <td></td>
                    <td>Modal Inti</td>
                    <td style="text-align:right; font-size: 14px;">Rp. {{ number_format($modal_inti) }}</td>
                </tr>

                <?php
                $cash_ratio_satu = ($kas + $giro_pada_bank_lain + $tabungan_pada_bank_lain) - $tabungan_dari_bank_lain;
                $cash_ratio_dua = $kewajiban_segera + $tabungan + $deposito;
                ?>
                <tr>
                    <td><b>3</b></td>
                    <td><b>Cash Ratio</b></td>
                    <td style="text-align:right; font-size: 14px;"><b>{{ ($modal_inti ==0 || $antar_bank_pasiva_aktiva == 0) ? $cash_ratioo = 0 : $cash_ratioo = round(($cash_ratio_satu/$cash_ratio_dua) * 100,2)  }} %</b></td>
                </tr>

                <input type="hidden" name="pos[]" value="Cash Ratio">
                <input type="hidden" name="jumlah[]" value="{{ $cash_ratioo }}">

                <tr>
                    <td></td>
                    <td style="font-size:14px">(Kas + SBI + Giro pada bank lain + tabungan antar bank aktiva) - (tabungan dari bank lain)</td>
                    <td style="text-align:right; font-size: 14px;">Rp. {{ number_format($cash_ratio_satu) }}</td>
                </tr>

                <tr>
                    <td></td>
                    <td>(Kewajiban segera + Tabungan + Deposito)</td>
                    <td style="text-align:right; font-size: 14px;">Rp. {{ number_format($cash_ratio_dua) }}</td>
                </tr>

                <?php $kewajiban_segera_satu = $kol_kurang_lancar + $kol_diragukan + $kol_macet;?>
                <tr>
                    <td>4</td>
                    <td><b>NPL (Gross)<b></td>
                    <td style="text-align:right; font-size: 14px;"><b>{{ ($pembiayaan_kredit ==0) ? $npll = 0 : $npll = round(($kewajiban_segera_satu/$pembiayaan_kredit) * 100,2)  }} %</b></td>
                </tr>

                <input type="hidden" name="pos[]" value="NPL (Gross)">
                <input type="hidden" name="jumlah[]" value="{{ $npll }}">

                <tr>
                    <td></td>
                    <td>Pembiayaan kol. 2 + kol. 3 + kol. 4</td>
                    <td style="text-align:right; font-size: 14px;">Rp. {{ number_format($kewajiban_segera_satu) }}</td>
                </tr>

                <tr>
                    <td></td>
                    <td>Pembiayaan yang diberikan</td>
                    <td style="text-align:right; font-size: 14px;">Rp. {{ number_format($pembiayaan_kredit) }}</td>
                </tr>

                <?php $npl_net = $kewajiban_segera_satu - $papp_tersedia; ?>
                <tr>
                    <td></td>
                    <td><b>NPL (Nett)</b></td>
                    <td style="text-align:right; font-size: 14px;"><b>{{ ($pembiayaan_kredit !== 0) ? round(($npl_net/$pembiayaan_kredit) *100,2) : 0}} %</b></td>
                </tr>


                <input type="hidden" name="pos[]" value="NPL (Nett)">
                <input type="hidden" name="jumlah[]" value="{{ ($pembiayaan_kredit !== 0) ? round(($npl_net/$pembiayaan_kredit) *100,2) : 0 }}">

                <tr>
                    <td></td>
                    <td>(Pembiayaan kol. 2 + kol. 3 + kol. 4) - PPAP</td>
                    <td style="text-align:right; font-size: 14px;">Rp. {{ number_format($npl_net) }}</td>
                </tr>
                <tr>
                    <td></td>
                    <td>Pembiayaan yang diberikan</td>
                    <td style="text-align:right; font-size: 14px;">Rp. {{ ($pembiayaan_kredit == 0) ? 0 : number_format($pembiayaan_kredit) }}</td>
                </tr>

                <?php $roa = ($laba_rugi_sebelum_pajak == 0) ? 0 : ($laba_rugi_sebelum_pajak/$bulan) * 12;

                $laba_rugi_sebelum_pajak_disetahunkan = ($laba_rugi_sebelum_pajak == 0) ? 0 : ($laba_rugi_sebelum_pajak/$bulan) * 12;
                $total_aktiva = $data->whereIn('sandi_coa', [1101010000,1101020000,1102000000,1103000000,1103010000,1104010100,1201000000,1202010000,1203010000,1204000000,1299000000])->sum('posisi_tanggal_laporan');
                $total_aktiva = $total_aktiva - $data->whereIn('sandi_coa', [1103020000,1104020000,1104010200,1202020000,1203020000])->sum('posisi_tanggal_laporan');
                ?>
                <tr>
                    <td>5</td>
                    <td><b>ROAA (Return of Average Asset)<b></td>
                    <td style="text-align:right; font-size: 14px;"><b>{{ ($pembiayaan_kredit ==0) ? $roaaa = 0 : $roaaa = round(($laba_rugi_sebelum_pajak_disetahunkan/$total_aktiva) * 100,2) }} %</b></td>
                </tr>

                <input type="hidden" name="pos[]" value="ROAA (Return of Average Asset)">
                <input type="hidden" name="jumlah[]" value="{{ $roaaa }}">

                <tr>
                    <td></td>
                    <td>Laba/(rugi) sebelum pajak (disetahunkan)</td>
                    <td style="text-align:right; font-size: 14px;">Rp. {{ ($roa == 0) ? $laba_rugi_sebelum_pajak_disetahunkan = 0 : number_format($laba_rugi_sebelum_pajak_disetahunkan) }}</td>
                </tr>

                <tr>
                    <td></td>
                    <td>(Total Aktiva periode N + Total Aktiva periode N-1) / 2</td>
                    <td style="text-align:right; font-size: 14px;">Rp. {{ number_format($total_aktiva = $data->whereIn('sandi_coa', [1101010000,1101020000,1102000000,1103000000,1103010000,1104010100,1201000000,1202010000,1203010000,1204000000,1299000000])->sum('posisi_tanggal_laporan')
                        - $data->whereIn('sandi_coa', [1103020000,1104020000,1104010200,1202020000,1203020000])->sum('posisi_tanggal_laporan')) }}</td>
                </tr>

                <?php $roae = $laba_rugi_sebelum_pajak;?>
                <tr>
                    <td>6</td>
                    <td><b>ROAE (Return of Average Equity)<b></td>
                    <td style="text-align:right; font-size: 14px;"><b>{{ ($pembiayaan_kredit !==0) ? $roaee = round(($laba_rugi_sebelum_pajak_disetahunkan/$jumlah_ekuitas) *100,2) : $roaee = 0 }} %</b></td>
                </tr>

                <input type="hidden" name="pos[]" value="ROAE (Return of Average Equity)">
                <input type="hidden" name="jumlah[]" value="{{ $roaee }}">

                <tr>
                    <td></td>
                    <td>Laba/(rugi) sebelum pajak (disetahunkan)</td>
                    <td style="text-align:right; font-size: 14px;">Rp. {{ number_format($laba_rugi_sebelum_pajak_disetahunkan) }}</td>
                </tr>

                <tr>
                    <td></td>
                    <td>(Komp. Modal periode N + Komp. Modal periode N-1) / 2</td>
                    <td style="text-align:right; font-size: 14px;">Rp. {{ number_format($jumlah_ekuitas) }}</td>
                </tr>

                <?php $bopo = $laba_rugi_sebelum_pajak;?>
                <tr>
                    <td>7</td>
                    <td><b>BOPO (Biaya Operasional thd Pendapatan Ops.)<b></td>
                    <td style="text-align:right; font-size: 14px;"><b>{{ $bopoo = ($pembiayaan_kredit ==0 || $sub_total_beban_operasional==0) ? 0 : round(($sub_total_beban_operasional/$pendapatan_operasional_satu) * 100,2) }} %</b></td>
                </tr>

                <input type="hidden" name="pos[]" value="BOPO (Biaya Operasional thd Pendapatan Ops.)">
                <input type="hidden" name="jumlah[]" value="{{ $bopoo }}">

                <tr>
                    <td></td>
                    <td>Total Biaya Operasional</td>
                    <td style="text-align:right; font-size: 14px;">Rp. {{ number_format($sub_total_beban_operasional) }}</td>
                </tr>

                <tr>
                    <td></td>
                    <td>Total Pendapatan Operasional</td>
                    <td style="text-align:right; font-size: 14px;">Rp. {{ number_format($pendapatan_operasional_satu) }}</td>
                </tr>

                <tr>
                    <td></td>
                    <td>OSS</td>
                    <td style="text-align:right; font-size: 14px;">{{ ($pendapatan_operasional ==0 || $sub_total_beban_operasional == 0) ? 0 : round(($pendapatan_operasional_satu/$sub_total_beban_operasional) *100,2)}} %</td>
                </tr>

                <?php $total_kewajiban_ekuitas = $jumlah_ekuitas + $jumlah_kewajiban;?>
                <tr>
                    <td>8</td>
                    <td><b>DER (Debt to Equity Ratio)<b></td>
                    <td style="text-align:right; font-size: 14px;"><b>{{ ($jumlah_ekuitas ==0 || $jumlah_kewajiban == 0) ? $derr = 0 : $derr = round($jumlah_kewajiban/$jumlah_ekuitas,2) }} %</b></td>
                </tr>

                <input type="hidden" name="pos[]" value="DER (Debt to Equity Ratio)">
                <input type="hidden" name="jumlah[]" value="{{ $derr }}">

                <tr>
                    <td></td>
                    <td>(Total Pasiva - Komponen Modal)</td>
                    <td style="text-align:right; font-size: 14px;">Rp. {{ number_format($total_passiva_komponen_modal = $jumlah_kewajiban) }}</td>
                </tr>

                <tr>
                    <td></td>
                    <td>Komponen Modal</td>
                    <td style="text-align:right; font-size: 14px;">Rp. {{ number_format($jumlah_ekuitas) }}</td>
                </tr>

                <?php
                    $ngr = $kewajiban_segera + $tabungan;
                    $ngr = $ngr + $deposito + $tabungan_dari_bank_lain;
                    $ngr = $ngr + $deposito_dari_bank_lain;
                    $ngr = $ngr + $pembiayaan_kurang_tiga_bulan;
                    $ngr = $ngr + $pembiayaan_lebih_tiga_bulan;
                    $ngr = $ngr - ($kas + $penempatan_pada_bank_lain + $giro_pada_bank_lain + $tabungan_pada_bank_lain + $deposito_pada_bank_lain);
                ?>
                <tr>
                    <td>9</td>
                    <td><b>NGR (Net Gearing Ratio)<b></td>
                    <td style="text-align:right; font-size: 14px;"><b>{{ ($ngr ==0 || $modal_inti == 0) ? $ngrr = 0 : $ngrr= round($ngr/$modal_inti,2) }} %</b></td>
                </tr>

                <input type="hidden" name="pos[]" value="NGR (Net Gearing Ratio)">
                <input type="hidden" name="jumlah[]" value="{{ $ngrr }}">

                <tr>
                    <td></td>
                    <td style="font-size:14px">(Kewajiban Segera + Tabungan + deposito + Antar Bank Pasiva) - (Kas + SBI + Antar Bank Aktiva)</td>
                    <td style="text-align:right; font-size: 14px;">Rp. {{ number_format($ngr) }}</td>
                </tr>

                <tr>
                    <td></td>
                    <td>Modal Inti</td>
                    <td style="text-align:right; font-size: 14px;">Rp. {{ number_format($modal_inti) }}</td>
                </tr>

                <?php $car;
                ?>
                <tr>
                    <td>10</td>
                    <td><b>CAR (Capital Adequacy Ratio)<b></td>
                    <?php $modal_car = $jumlah_modal_inti_pelengkap; ?>
                    <td style="text-align:right; font-size: 14px;"><b>{{ ($modal_car == 0 || $atmr == 0) ? $carr = 0 : $carr = round(($modal_car/$atmr) * 100,2) }} %</b></td>
                </tr>

                <input type="hidden" name="pos[]" value="CAR (Capital Adequacy Ratio)">
                <input type="hidden" name="jumlah[]" value="{{ $carr }}">

                <tr>
                    <td></td>
                    <td>Modal CAR (Modal inti + Modal Pelengkap)</td>
                    <td style="text-align:right; font-size: 14px;">Rp. {{ number_format($modal_car) }}</td>
                </tr>

                <tr>
                    <td></td>
                    <td>Aktiva Tertimbang Menurut Risiko</td>
                    <td style="text-align:right; font-size: 14px;">Rp. {{ number_format($atmr) }}</td>
                </tr>

                <?php $nim = ($pendapatan_bunga == 0 || $beban_bunga == 0) ? 0 : (($pendapatan_bunga - $beban_bunga)/$bulan) *12; ?>
                <tr>
                    <td>11</td>
                    <td><b>NIM (Net Interest Margin)<b></td>
                    <td style="text-align:right; font-size: 14px;"><b>{{ ($nim ==0 || $total_aktiva_produktif == 0) ? $nimm = 0 : $nimm = round(($nim/$total_aktiva_produktif) *100,2) }} %</b></td>
                </tr>

                <input type="hidden" name="pos[]" value="NIM (Net Interest Margin)">
                <input type="hidden" name="jumlah[]" value="{{ $nimm }}">

                <tr>
                    <td></td>
                    <td style="font-size:14px">Pendapatan Bunga Bersih (Pendapatan bunga - Biaya bunga) (disetahunkan)</td>
                    <td style="text-align:right; font-size: 14px;">Rp. {{ number_format($nim) }}</td>
                </tr>

                <tr>
                    <td></td>
                    <td>Total Aktiva Produktif</td>
                    <td style="text-align:right; font-size: 14px;">Rp. {{ number_format($total_aktiva_produktif) }}</td>
                </tr>

                <?php $nim = ($pendapatan_bunga - $beban_bunga) *12; ?>
                <tr>
                    <td>12</td>
                    <td><b>Rasio Pemenuhan PPAP<b></td>
                    <td style="text-align:right; font-size: 14px;"><b>{{ ($papp_tersedia ==0 || $perhitungan_ppap_wajib == 0) ? $rasio_pemenuhan_ppap = 0 : $rasio_pemenuhan_ppap = round(($papp_tersedia/$perhitungan_ppap_wajib) *100,2) }} %</b></td>
                </tr>

                <input type="hidden" name="pos[]" value="Rasio Pemenuhan PPAP">
                <input type="hidden" name="jumlah[]" value="{{ $rasio_pemenuhan_ppap }}">

                <tr>
                    <td></td>
                    <td>PPAP Tersedia</td>
                    <td style="text-align:right; font-size: 14px;">Rp. {{ number_format($papp_tersedia) }}</td>
                </tr>

                <tr>
                    <td></td>
                    <td>PPAP Wajib</td>
                    <td style="text-align:right; font-size: 14px;">Rp. {{ number_format($perhitungan_ppap_wajib) }}</td>
                </tr>

                <?php

                    $net_kredit_terhadap_total_aktiva = $pembiayaan_kredit + $papp_tersedia *12;
                    $kredit_diberikan_ppap_tersedia = $pembiayaan_kredit + $papp_tersedia;
                ?>
                <tr>
                    <td>13</td>
                    <td><b>Net Kredit terhadap Total Aktiva<b></td>
                    <td style="text-align:right; font-size: 14px;"><b>{{ ($net_kredit_terhadap_total_aktiva ==0 || $aktiva == 0) ? $net__kredit__total__aktiva = 0 : $net__kredit__total__aktiva = round(($kredit_diberikan_ppap_tersedia/$aktiva) *100,2) }} %</b></td>
                </tr>

                <input type="hidden" name="pos[]" value="Net Kredit Terhadap Total Aktiva">
                <input type="hidden" name="jumlah[]" value="{{ $net__kredit__total__aktiva }}">

                <tr>
                    <td></td>
                    <td>(Kredit diberikan - PPAP Tersedia)</td>
                    <td style="text-align:right; font-size: 14px;">Rp. {{ number_format($kredit_diberikan_ppap_tersedia) }}</td>
                </tr>

                <tr>
                    <td></td>
                    <td>Total Aktiva</td>
                    <td style="text-align:right; font-size: 14px;">Rp. {{ number_format($aktiva) }}</td>
                </tr>

                <?php $bdr = ($kol_kurang_lancar * 0.5) + ($kol_diragukan * 0.75) + $kol_macet; ?>
                <tr>
                    <td>14</td>
                    <td><b>BDR (Bad Debt Ratio)<b></td>
                    <td style="text-align:right; font-size: 14px;"><b>{{ ($bdr ==0 || $total_aktiva_produktif == 0) ? $net__kredit__total__terhadap__aktiva = 0 : $net__kredit__total__terhadap__aktiva = round(($bdr/$total_aktiva_produktif) *100,2) }} %</b></td>
                </tr>

                <input type="hidden" name="pos[]" value="BDR (Bad Debt Ratio)">
                <input type="hidden" name="jumlah[]" value="{{ $net__kredit__total__terhadap__aktiva }}">

                <tr>
                    <td></td>
                    <td>Aktiva Produktif diklasifikasikan</td>
                    <td style="text-align:right; font-size: 14px;">Rp. {{ number_format($bdr) }}</td>
                </tr>

                <tr>
                    <td></td>
                    <td>Total Aktiva Produktif</td>
                    <td style="text-align:right; font-size: 14px;">Rp. {{ number_format($total_aktiva_produktif) }}</td>
                </tr>

                <?php
                $return_paid_capital = ($laba_rugi_sebelum_pajak == 0) ? 0 : $laba_rugi_sebelum_pajak *12;
                $laba_rugi_sebelum_pajak_disetahunkan = ($laba_rugi_sebelum_pajak == 0) ? 0 : ($laba_rugi_sebelum_pajak/$bulan) * 12;
                ?>
                <tr>
                    <td>15</td>
                    <td><b>Return on Paid In Capital<b></td>
                    <td style="text-align:right; font-size: 14px;"><b>{{ ($modal_disetor == 0) ? $return__paid__capital = 0 : $return__paid__capital = round(( $laba_rugi_sebelum_pajak_disetahunkan /$modal_disetor) *100,2) }} %</b></td>
                </tr>

                <input type="hidden" name="pos[]" value="Return on Paid In Capital">
                <input type="hidden" name="jumlah[]" value="{{ $return__paid__capital }}">

                <tr>
                    <td></td>
                    <td>Laba/(rugi) sebelum pajak (disetahunkan)</td>
                    <td style="text-align:right; font-size: 14px;">Rp. {{ number_format( $laba_rugi_sebelum_pajak_disetahunkan) }}</td>
                </tr>

                <tr>
                    <td></td>
                    <td>Modal disetor</td>
                    <td style="text-align:right; font-size: 14px;">Rp. {{ number_format($modal_disetor) }}</td>
                </tr>

                <?php
                    $biaya_bunga_tabungan = $laba_rugi->whereIn('sandi_coa', [5101010100, 5101020100])->sum('posisi_tanggal_laporan');
                    $biaya_bunga_deposito = $laba_rugi->whereIn('sandi_coa', [5101010200, 5101020200])->sum('posisi_tanggal_laporan');
                    $nominal_tabungan = $tabungan + $tabungan_dari_bank_lain;
                    $nominal_deposito = $data->whereIn('sandi_coa', [2299020000, 2102020100])->sum('posisi_tanggal_laporan');
                    $biaya_bunga_pinjaman = $laba_rugi->where('sandi_coa', 5101010400)->sum('posisi_tanggal_laporan');
                    $nominal_pinjaman = $data->where('sandi_coa', 2201010000)->sum('posisi_tanggal_laporan');
                ?>
                <tr>
                    <td>16</td>
                    <td><b>Cost of Fund Funding<b></td>
                    <td style="text-align:right; font-size: 14px;"><b>{{ (($nominal_tabungan + $nominal_deposito + $nominal_pinjaman) == 0) ? $cost_fund_funding = 0 : $cost_fund_funding = round(($biaya_bunga_tabungan + $biaya_bunga_deposito + $biaya_bunga_pinjaman)/($nominal_tabungan + $nominal_deposito + $nominal_pinjaman) *100,2) }} %</b></td>
                </tr>

                <input type="hidden" name="pos[]" value="Cost of Fund Funding">
                <input type="hidden" name="jumlah[]" value="{{ $cost_fund_funding }}">

                <tr>
                    <td></td>
                    <td>Biaya Bunga Tabungan</td>
                    <td style="text-align:right; font-size: 14px;">Rp. {{ number_format($biaya_bunga_tabungan) }}</td>
                </tr>

                <tr>
                    <td></td>
                    <td>Nominal Tabungan</td>
                    <td style="text-align:right; font-size: 14px;">Rp. {{ number_format($nominal_tabungan) }}</td>
                </tr>

                <tr>
                    <td></td>
                    <td><b>COF Tabungan<b></td>
                    <td style="text-align:right; font-size: 14px;"><b>{{ ($nominal_tabungan == 0) ? 0 : round(($biaya_bunga_tabungan/$nominal_tabungan) *100,2) }} %</b></td>
                </tr>

                <tr>
                    <td></td>
                    <td>Biaya bunga deposito</td>
                    <td style="text-align:right; font-size: 14px;">Rp. {{ number_format($biaya_bunga_deposito) }}</td>
                </tr>

                <tr>
                    <td></td>
                    <td>Nominal Deposito</td>
                    <td style="text-align:right; font-size: 14px;">Rp. {{ number_format($nominal_deposito) }}</td>
                </tr>

                <tr>
                    <td></td>
                    <td><b>COF Deposito<b></td>
                    <td style="text-align:right; font-size: 14px;"><b>{{ ($nominal_deposito == 0) ? 0 : round(($biaya_bunga_deposito/$nominal_deposito) *100,2) }} %</b></td>
                </tr>

                <tr>
                    <td></td>
                    <td>Biaya Bunga Pinjaman</td>
                    <td style="text-align:right; font-size: 14px;">Rp. {{ number_format($biaya_bunga_pinjaman = $laba_rugi->where('sandi_coa', 5101010400)->sum('posisi_tanggal_laporan')) }}</td>
                </tr>

                <tr>
                    <td></td>
                    <td>Nominal Pinjaman </td>
                    <td style="text-align:right; font-size: 14px;">Rp. {{ number_format($nominal_pinjaman) }}</td>
                </tr>

                <tr>
                    <td></td>
                    <td><b>COF Pinjaman<b></td>
                    <td style="text-align:right; font-size: 14px;"><b>{{ ($nominal_pinjaman == 0) ? 0 : round(($biaya_bunga_pinjaman/$nominal_pinjaman) *100,2) }} %</b></td>
                </tr>

                <?php
                    $loan_revenue = ($laba_rugi->where('sandi_coa', 4101010300)->sum('posisi_tanggal_laporan') == 0) ? 0 : ($laba_rugi->where('sandi_coa', 4101010300)->sum('posisi_tanggal_laporan')/$bulan) * 12;
                    $loan_outstanding = $data->where('sandi_coa', 1104010100)->sum('posisi_tanggal_laporan');
                ?>
                <tr>
                    <td>17</td>
                    <td><b>Yield KYD<b></td>
                    <td style="text-align:right; font-size: 14px;"><b>{{ ($loan_outstanding == 0) ? $yield_kydd = 0 : $yield_kydd = round(($loan_revenue/$loan_outstanding) *100,2) }} %</b></td>
                </tr>

                <input type="hidden" name="pos[]" value="Yield KYD">
                <input type="hidden" name="jumlah[]" value="{{ $yield_kydd }}">

                <tr>
                    <td></td>
                    <td>Loan Revenue</td>
                    <td style="text-align:right; font-size: 14px;">Rp. {{ number_format($loan_revenue) }}</td>
                </tr>

                <tr>
                    <td></td>
                    <td>Loan Outstanding</td>
                    <td style="text-align:right; font-size: 14px;">Rp. {{ number_format($loan_outstanding) }}</td>
                </tr>

                <?php
                    $average_book = ($jumlah_peminjam ==0 || $data->where('sandi_coa', 1104010100)->sum('posisi_tanggal_laporan')== 0) ? 0 : $data->where('sandi_coa', 1104010100)->sum('posisi_tanggal_laporan')/$jumlah_peminjam;
                    $bad_deb_write_off = $rekening_administratif->where('sandi_coa', 6201020000)->sum('nominal');
                ?>
                <tr>
                    <td>18</td>
                    <td><b>Bad Debt Write Off Ratio<b></td>
                    <td style="text-align:right; font-size: 14px;"><b>{{ ($average_book == 0) ? $bad_debt_write_off_ratioo = 0 : $bad_debt_write_off_ratioo = round(($bad_deb_write_off/$average_book) *100 ,2) }} %</b></td>
                </tr>

                <input type="hidden" name="pos[]" value="Bad Debt Write Off Ratio">
                <input type="hidden" name="jumlah[]" value="{{ $bad_debt_write_off_ratioo }}">

                <tr>
                    <td></td>
                    <td>Bad Debt Write Off</td>
                    <td style="text-align:right; font-size: 14px;">Rp. {{ number_format($bad_deb_write_off) }}</td>
                </tr>

                <tr>
                    <td></td>
                    <td>Average book</td>
                    <td style="text-align:right; font-size: 14px;">Rp. {{ number_format($average_book) }}</td>
                </tr>

                <?php
                    $bad_deb_provisions = $papp_tersedia;
                ?>
                <tr>
                    <td>19</td>
                    <td><b>Bad debt ratio<b></td>
                    <td style="text-align:right; font-size: 14px;"><b>{{ ($bad_deb_provisions == 0 || $average_book == 0) ? $bad_deb_ratio = 0 : $bad_deb_ratio = round(($bad_deb_provisions/$average_book),2) }} %</b></td>
                </tr>

                <input type="hidden" name="pos[]" value="Bad Debt Ratio">
                <input type="hidden" name="jumlah[]" value="{{ $bad_deb_ratio }}">

                <tr>
                    <td></td>
                    <td>Bad debt provisions</td>
                    <td style="text-align:right; font-size: 14px;">Rp. {{ number_format($bad_deb_provisions) }}</td>
                </tr>

                <tr>
                    <td></td>
                    <td>Average book</td>
                    <td style="text-align:right; font-size: 14px;">Rp. {{ number_format($average_book) }}</td>
                </tr>

            </table>

            <div style="height:20px"></div>

            <button type="submit" class="btn btn-primary" name="action" value="Simpan">Simpan</button>
        </form>
    </div>
</div>
@endsection
