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
        <h5 style="text-align:center;">KPMM {{ strtoupper(\App\Models\InformasiPokokBprPelapor::namaBpr($sandi_bpr)->nama_bpr) ?? '' }}<br/>PERIODE LAPORAN KEUANGAN <br/>{{ strtoupper(bulan($bulan)) }} {{ $tahun }}</h5>

        <div style="height:40px" align="centre"></div>

        <form action="{{ url('cari-kpmm') }}" method="POST">@csrf

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

        <?php $tahun_pilih = date('Y'); ?>
        <div class="form-group row">
		    <label class="col-md-3">Pilih Tahun</label>
			    <div class="col-md-7">
                <select name="tahun" id="tahun" class="form-control select" required>
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

        <div style="height:20px"></div>

        <table class="table table-stripped" id="table">
            <tr>
                <th>KETERANGAN</th>
                <th style="text-align:right;">NOMINAL</th>
                <th>SANDI COA</th>
            </tr>

            <tr>
                <td style="font-size:11px"><b>I. AKTIVA TETAP MENURUT RISIKO (ATMR)</b></td>
                <td style="text-align:right; font-size: 11px;"><b>Rp. {{ number_format($atmr) }}</b></td>
                <td style="font-size:11px"><b>K01000000</b></td>
            </tr>

            <tr>
                <td style="font-size:11px"><b>II. MODAL</b></td>
                <td style="font-size:11px"><b></b></td>
                <td style="font-size:11px"><b>K02000000</b></td>
            </tr>

            <tr>
                <td style="font-size:11px">&emsp;&emsp;1. Modal Inti</td>
                <td style="font-size:11px"></td>
                <td style="font-size:11px">K02010000</td>
            </tr>

            <tr>
                <td style="font-size:11px">&emsp;&emsp;&emsp;&emsp;1.1 Modal Disetor</td>
                <td style="text-align:right; font-size: 11px;">Rp. {{ number_format($modal_disetor = $data->where('pos', 'Komponen Modal')->sum('posisi_tanggal_laporan')) }}</td>
                <td style="font-size:11px">K02010100</td>
            </tr>

            <tr>
                <td style="font-size:11px">&emsp;&emsp;&emsp;&emsp;1.2 Agio</td>
                <td style="text-align:right; font-size: 11px;">Rp. {{ number_format($agio = $data->where('sandi_coa', 3102010000)->sum('posisi_tanggal_laporan')) }}</td>
                <td style="font-size:11px">K02010200</td>
            </tr>

            <tr>
                <td style="font-size:11px">&emsp;&emsp;&emsp;&emsp;1.3 Disagio</td>
                <td style="text-align:right; font-size: 11px;">Rp. {{ number_format($disagio = $data->where('sandi_coa', 3102010001)->sum('posisi_tanggal_laporan')) }}</td>
                <td style="font-size:11px">K02010300</td>
            </tr>

            <tr>
                <td style="font-size:11px">&emsp;&emsp;&emsp;&emsp;1.4 Modal Sumbangan</td>
                <td style="text-align:right; font-size: 11px;">Rp. {{ number_format($modal_sumbangan = $data->where('sandi_coa', 3102020000)->sum('posisi_tanggal_laporan')) }}</td>
                <td style="font-size:11px">K02010300</td>
            </tr>

            <tr>
                <td style="font-size:11px">&emsp;&emsp;&emsp;&emsp;1.5 Dana Setoran Modal</td>
                <td style="text-align:right; font-size: 11px;">Rp. {{ number_format($dana_setoran_modal = $data->where('sandi_coa', 3102030000)->sum('posisi_tanggal_laporan')) }}</td>
                <td style="font-size:11px">K02010600</td>
            </tr>

            <tr>
                <td style="font-size:11px">&emsp;&emsp;&emsp;&emsp;1.6 Cadangan Umum</td>
                <td style="text-align:right; font-size: 11px;">Rp. {{ number_format($cadangan_umum = $data->where('sandi_coa', 3104010000)->sum('posisi_tanggal_laporan')) }}</td>
                <td style="font-size:11px">K02010600</td>
            </tr>

            <tr>
                <td style="font-size:11px">&emsp;&emsp;&emsp;&emsp;1.7 Cadangan Tujuan</td>
                <td style="text-align:right; font-size: 11px;">Rp. {{ number_format($cadangan_tujuan = $data->where('sandi_coa', 3104020000)->sum('posisi_tanggal_laporan')) }}</td>
                <td style="font-size:11px">K02010600</td>
            </tr>

            <tr>
                <td style="font-size:11px">&emsp;&emsp;&emsp;&emsp;1.8 Laba Ditahan</td>
                <td style="text-align:right; font-size: 11px;">Rp. {{ number_format($laba_ditahan = 0) }}</td>
                <td style="font-size:11px">K02010600</td>
            </tr>

            <tr>
                <td style="font-size:11px">&emsp;&emsp;&emsp;&emsp;1.9 Laba Tahun-Tahun Lalu</td>
                <td style="text-align:right; font-size: 11px;">Rp. {{ number_format($laba_tahun_tahun_lalu = $data->where('sandi_coa', 3105010000)->sum('posisi_tanggal_laporan')) }}</td>
                <td style="font-size:11px">K02010600</td>
            </tr>

            <tr>
                <td style="font-size:11px">&emsp;&emsp;&emsp;&emsp;1.10 Rugi Tahun-Tahun Lalu -/-</td>
                <td style="text-align:right; font-size: 11px;">Rp. {{ number_format($rugi_tahun_tahun_lalu = $data->where('sandi_coa', 3105010100)->sum('posisi_tanggal_laporan')) }}</td>
                <td style="font-size:11px">K02010600</td>
            </tr>

            <tr>
                <td style="font-size:11px">&emsp;&emsp;&emsp;&emsp;1.11 Laba Tahun Berjalan (50%)</td>
                <td style="text-align:right; font-size: 11px;">Rp. {{ number_format($laba_tahun_berjalan = ($data->where('sandi_coa', 3105020000)->sum('posisi_tanggal_laporan') < 0) ? 0 : $data->where('sandi_coa', 3105020000)->sum('posisi_tanggal_laporan') * 0.5) }}</td>
                <td style="font-size:11px">K02010600</td>
            </tr>

            <tr>
                <td style="font-size:11px">&emsp;&emsp;&emsp;&emsp;1.12 Rugi Tahun Berjalan +/-</td>
                <td style="text-align:right; font-size: 11px;">Rp. {{ number_format($rugi_tahun_berjalan = ($data->where('sandi_coa', 3105020001)->sum('posisi_tanggal_laporan') < 0) ? 0 : $data->where('sandi_coa', 3105020001)->sum('posisi_tanggal_laporan')) }}</td>
                <td style="font-size:11px">K02010600</td>
            </tr>

            <tr>
                <td style="font-size:11px">&emsp;&emsp;&emsp;&emsp;<b>1.13 Sub Total</b></td>
                <td style="text-align:right; font-size: 11px;"><b>Rp. {{ number_format($sub_total = $modal_disetor - $disagio + $modal_sumbangan + $cadangan_umum + $cadangan_tujuan + $laba_ditahan + $laba_tahun_tahun_lalu - $rugi_tahun_tahun_lalu + $laba_tahun_berjalan - $rugi_tahun_berjalan + $agio - $disagio + $dana_setoran_modal) }}</b></td>
                <td style="font-size:11px"><b>K02010600</b></td>
            </tr>

            <tr>
                <td style="font-size:11px">&emsp;&emsp;&emsp;&emsp;1.14 Kekurangan Pembentukan PPAP</td>
                <td style="text-align:right; font-size: 11px;">Rp. {{ $kekurangan_pembentukan_ppap }}</td>
                <td style="font-size:11px">K02010600</td>
            </tr>

            <tr>
                <td style="font-size:11px">&emsp;&emsp;&emsp;&emsp;1.15 Goodwill</td>
                <td style="text-align:right; font-size: 11px;">Rp. {{ $goodwill =0}}</td>
                <td style="font-size:11px">K02010600</td>
            </tr>

            <tr>
                <td style="font-size:11px">&emsp;&emsp;&emsp;&emsp;<b>1.16 Jumlah Modal Inti</b></td>
                <td style="text-align:right; font-size: 11px;"><b>Rp. {{ number_format($jumlah_modal_inti = $sub_total + $kekurangan_pembentukan_ppap  - $goodwill) }}</b></td>
                <td style="font-size:11px"><b>K02010600</b></td>
            </tr>

            <tr>
                <td style="font-size:11px">2. Modal Pelengkap</td>
                <td style="font-size:11px"></td>
                <td style="font-size:11px">K02020000</td>
            </tr>

            <tr>
                <td style="font-size:11px">&emsp;&emsp;&emsp;&emsp;2.1 Cadangan revaluasi/Selisih penilaian aktiva tetap</td>
                <td style="text-align:right; font-size: 11px;">Rp. {{ $cadangan_revaluasi = 0 }}</td>
                <td style="font-size:11px">K02020100</td>
            </tr>

            <tr>
                <td style="font-size:11px">&emsp;&emsp;&emsp;&emsp;2.2 Penyisihan Penghapusan Aktiva Produktif (maks. 1,25% dari ATMR)</td>
                <td style="text-align:right; font-size: 11px;">Rp. {{  ($atmr * 1.25/100 > $data->where('sandi_coa', 1104020000)->sum('posisi_tanggal_laporan')) ? number_format($penyisihan_penghapusan_aktiva =$data->where('sandi_coa', 1104020000)->sum('posisi_tanggal_laporan')) : number_format($penyisihan_penghapusan_aktiva = $atmr * 1.25/100) }}</td>
                <td style="font-size:11px">K02020100</td>
            </tr>

            <tr>
                <td style="font-size:11px">&emsp;&emsp;&emsp;&emsp;2.3 Modal Pinjaman (Kuasi)</td>
                <td style="text-align:right; font-size: 11px;">Rp. {{ number_format($modal_pinjaman_kuasi = $data->where('sandi_coa', 2299030002)->sum('posisi_tanggal_laporan')) }}</td>
                <td style="font-size:11px">K02020300</td>
            </tr>

            <tr>
                <td style="font-size:11px">&emsp;&emsp;&emsp;&emsp;2.4 Pinjaman Subordinasi (maks. 50% dari modal inti)</td>
                <td style="text-align:right; font-size: 11px;">Rp. {{ number_format($pinjaman_subordinasi = $data->where('sandi_coa', 2299030002)->sum('posisi_tanggal_laporan')) }}</td>
                <td style="font-size:11px">K02020300</td>
            </tr>

            <tr>
                <td style="font-size:11px">&emsp;&emsp;&emsp;&emsp;2.5 Jumlah Modal Pelengkap</td>
                <td style="text-align:right; font-size: 11px;">Rp. {{ number_format($jumlah_modal_pelengkap = $modal_pinjaman_kuasi + $pinjaman_subordinasi + $penyisihan_penghapusan_aktiva + $cadangan_revaluasi) }}</td>
                <td style="font-size:11px">K02020300</td>
            </tr>

            <tr>
                <td style="font-size:11px">&emsp;&emsp;&emsp;&emsp;2.6 Jumlah Modal Pelengkap Yang Diperhitungkan (maks. 100% dari modal inti) </td>
                @if ($jumlah_modal_inti < 0)
                <td style="text-align:right; font-size: 11px;">Rp. {{ $jumlah_modal_pelengkap_yang_dipertahankan = 0}}</td>
                @elseif($jumlah_modal_pelengkap <= $jumlah_modal_inti)
                <td style="text-align:right; font-size: 11px;">Rp. {{ number_format($jumlah_modal_pelengkap_yang_dipertahankan = $jumlah_modal_pelengkap) }}</td>
                @else
                <td style="text-align:right; font-size: 11px;">Rp. {{ number_format($jumlah_modal_pelengkap_yang_dipertahankan = $jumlah_modal_inti) }}</td>
                @endif
                <td style="font-size:11px">K02020300</td>
            </tr>

            <tr>
                <td style="font-size:11px"><b>3. Jumlah Modal Inti Pelengkap</b></td>
                <td style="text-align:right; font-size: 11px;">Rp. {{ number_format($jumlah_modal_inti_pelengkap = $jumlah_modal_inti + $jumlah_modal_pelengkap_yang_dipertahankan) }}</td>
                <td style="font-size:11px">K02020300</td>
            </tr>
            <tr>
                <td style="font-size:11px"><b>III. CAPITAL ADEQUACY RATIO (CAR)</b></td>
                <td style="text-align:right; font-size: 11px;"><b>{{ $car = ($jumlah_modal_inti_pelengkap == 0 || $atmr ==0) ? 0 : round($jumlah_modal_inti_pelengkap/$atmr *100,2) }} %</b></td>
                <td style="font-size:11px"><b>K02020300</b></td>
            </tr>

            <tr>
                <td style="font-size:11px">Kekurangan modal untuk CAR 8%</td>
                <td style="text-align:right; font-size: 11px;">Rp. {{ ($jumlah_modal_inti_pelengkap < ($atmr * 0.08) ? number_format($kekurangan_modal_car =($atmr * 0.08) - $jumlah_modal_inti_pelengkap) : $kekurangan_modal_car =0 ) }} </td>
                <td style="font-size:11px">K02020300</td>
            </tr>

            <tr>
                <td style="font-size:11px">Maksimal BMPK Pihak Terkait (10%)</td>
                <td style="text-align:right; font-size: 11px;">Rp. {{ number_format($jumlah_modal_inti_pelengkap * 0.10) }} </td>
                <td style="font-size:11px">K02020300</td>
            </tr>

            <tr>
                <td style="font-size:11px">Maksimal BMPK perorangan/grup pihak tidak terkait (20%)</td>
                <td style="text-align:right; font-size: 11px;">Rp. {{ number_format($jumlah_modal_inti_pelengkap * 0.20) }} </td>
                <td style="font-size:11px">K02020300</td>
            </tr>

        </table>
    </div>
</div>
@endsection
