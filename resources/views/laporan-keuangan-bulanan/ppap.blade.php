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
        <h5 style="text-align:center;">PPAP {{ \App\Models\InformasiPokokBprPelapor::namaBpr($sandi_bpr)->nama_bpr ?? '' }}</h5>

        <div style="height:30px" align="centre"></div>

        <form action="{{ url('cari-ppap') }}" method="POST">@csrf

            <input type="hidden" name="sandi_bpr" value="{{ $sandi_bpr ?? '' }}">

            @include('menu-laporan-bulanan')
            @include('flash-message')

            <br/>

            <div class="form-group row">
                <label class="col-md-3">Pilih Bulan</label>
                    <div class="col-md-7">
                    <select name="bulan" class="form-control nominal" required>
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

            <?php $tahun_pilihan = date('Y'); ?>
            <div class="form-group row">
                <label class="col-md-3">Pilih Tahun</label>
                    <div class="col-md-7">
                    <select name="tahun" id="tahun" class="form-control select" required>
                        <option value="">Pilih</option>
                        @for($i=2019; $i<=$tahun_pilihan; $i++)
                        <option value="{{ $i }}">{{ $i}} </option>
                        @endfor
                    </select>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Cari</button>
            </div>


            <div style="height:20px"></div>

            <table class="table table-stripped" id="table">
                <tr>
                    <th>AKTIVA PRODUKTIF</th>
                    <th style="text-align:right;">PERIODE LAPORAN KEUANGAN {{ strtoupper(bulan($bulan)) }} {{ $tahun }}</th>
                    <th>SANDI COA</th>
                </tr>

                <tr>
                    <td style="font-size:11px"><b>SBI Lancar</b></td>
                    <td></td>
                    <td style="font-size:11px">P01000000</td>
                </tr>

                <tr>
                    <td style="font-size:11px"><b>Penempatan Pada Bank Lain</b></td>
                    <td style="text-align:right; font-size: 11px;">Rp. {{ number_format($penempatan_pada_bank_lain = $data->where('sandi_coa', 1103010000)->sum('posisi_tanggal_laporan'))}}</td>
                    <td style="font-size:11px">P02000000</td>
                </tr>

                <tr>
                    <td style="font-size:11px">Lancar</td>
                    <td style="text-align:right; font-size: 11px;">Rp. {{ number_format($penempatan_pada_bank_lain)}}</td>
                    <td style="font-size:11px">P02010000</td>
                </tr>

                <tr>
                    <td style="font-size:11px">Kurang Lancar</td>
                    <td style="font-size:11px"></td>
                    <td style="font-size:11px">P03020000</td>
                </tr>

                <tr>
                    <td style="font-size:11px">Macet</td>
                    <td></td>
                    <td style="font-size:11px">P02030000</td>
                </tr>

                <tr>
                    <td style="font-size:11px"><b>Piutang</b></td>
                    <td style="text-align:right; font-size: 11px;">Rp. {{ number_format($piutang = $data->where('sandi_coa', 1104010100)->sum('posisi_tanggal_laporan')) }}</td>
                    <td style="font-size:11px">P03000000</td>
                </tr>

                <tr>
                    <td style="font-size:11px">Lancar</td>
                    <td style="text-align:right; font-size: 11px;">Rp. {{ number_format($data->where('sandi_coa', 1104010101)->sum('posisi_tanggal_laporan'))}}</td>
                    <td style="font-size:11px">P03010000</td>
                </tr>

                <tr>
                    <td style="font-size:11px">Kurang Lancar</td>
                    <td style="text-align:right; font-size: 11px;">Rp. {{ number_format($piutang_kurang_lancar = $data->where('sandi_coa', 1104010103)->sum('posisi_tanggal_laporan'))}}</td>
                    <td style="font-size:11px">P03020000</td>
                </tr>

                <tr>
                    <td style="font-size:11px">Diragukan</td>
                    <td style="text-align:right; font-size: 11px;">Rp. {{ number_format($piutang_diragukan = $data->where('sandi_coa', 1104010104)->sum('posisi_tanggal_laporan'))}}</td>
                    <td style="font-size:11px">P03030000</td>
                </tr>

                <tr>
                    <td style="font-size:11px">Macet</td>
                    <td style="text-align:right; font-size: 11px;">Rp. {{ number_format($piutang_macet = $data->where('sandi_coa', 1104010105)->sum('posisi_tanggal_laporan'))}}</td>
                    <td style="font-size:11px">P03040000</td>
                </tr>

                <tr>
                    <td style="font-size:11px"><b>Total Aktiva Produktif</b></td>
                    <td style="text-align:right; font-size: 11px;"><b>Rp. {{ $total_aktiva_produktif = number_format($piutang + $penempatan_pada_bank_lain)}}</b></td>
                    <td style="font-size:11px"><b>P04000000</b></td>
                </tr>

                <tr>
                    <td style="font-size:11px"><i>Agunan Pembiayaan</i></td>
                    <td></td>
                    <td></td>
                </tr>

                <tr>
                    <td style="font-size:11px">Kurang Lancar</td>
                    <td style="text-align:right; font-size: 11px;">Rp. {{ number_format($data->where('sandi_coa', 1104010103)->sum('posisi_tanggal_laporan') * 0.5) }}</td>
                    <td style="font-size:11px">P03020000</td>
                </tr>

                <tr>
                    <td style="font-size:11px">Diragukan</td>
                    <td style="text-align:right; font-size: 11px;">Rp. {{ number_format($data->where('sandi_coa', 1104010104)->sum('posisi_tanggal_laporan') * 0.66)}}</td>
                    <td style="font-size:11px">P03030000</td>
                </tr>

                <tr>
                    <td style="font-size:11px">Macet</td>
                    <td style="text-align:right; font-size: 11px;">Rp. {{ number_format($data->where('sandi_coa', 1104010105)->sum('posisi_tanggal_laporan') * 0.85) }} </td>
                    <td style="font-size:11px">P04030000</td>
                </tr>

                <tr>
                    <td style="font-size:11px">Perhitungan PPAP WAJIB</td>
                    <td style="text-align:right; font-size: 11px;">Rp. {{ number_format($perhitungan_ppap_wajib) }}</td>
                    <td style="font-size:11px">P05000000</td>
                </tr>

                <tr>
                    <td style="font-size:11px">PPAP Tersedia</td>
                    <td style="text-align:right; font-size: 11px;">Rp. {{ number_format( $ppap_tersedia=$data->where('sandi_coa', 1104020000)->sum('posisi_tanggal_laporan') + $data->where('sandi_coa', 1103020000)->sum('posisi_tanggal_laporan')) }}</td>
                    <td style="font-size:11px">P06000000</td>
                </tr>

                <?php $sum_rasio_npl = $piutang_kurang_lancar + $piutang_diragukan + $piutang_macet; ?>
                <tr>
                    <td style="font-size:11px">Rasio NPL (Gross)</td>
                    <td style="text-align:right; font-size: 11px;">{{ $rasio_npl = ($piutang_kurang_lancar ==0 || $piutang_macet == 0) ? 0 : round(($sum_rasio_npl)/$piutang *100,2) }} %</td>
                    <td style="font-size:11px">P07000000</td>
                </tr>

                <tr>
                    <td style="font-size:11px">Rasio PPAP</td>
                    <td style="text-align:right; font-size: 11px;">{{ ($ppap_tersedia == 0 || $perhitungan_ppap_wajib == 0) ? 0 : round($ppap_tersedia/$perhitungan_ppap_wajib *100, 2) }} %</td>
                    <td style="font-size:11px">P08000000</td>
                </tr>

                <tr>
                    <td style="font-size:11px">Kekurangan PPAP</td>
                    <td style="text-align:right; font-size: 11px;">{{ ($ppap_tersedia > $perhitungan_ppap_wajib) ? 0 : $ppap_tersedia - $perhitungan_ppap_wajib }} </td>
                    <td style="font-size:11px">P09000000</td>
                </tr>

            </table>
        </form>
    </div>
</div>
@endsection
