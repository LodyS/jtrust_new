<?php

namespace App\Http\Controllers;
use DB;
use App\Models\LaporanPosisiKeuanganTable;
use App\Models\LaporanLabaRugiTable;
use App\Models\HeaderImport;
use App\Models\InputProfil;
use App\Models\RekeningAdministratif;
use App\Models\InformasiPokokBprPelapor;
use Illuminate\Http\Request;

class RasioController extends Controller
{
    public function index(Request $request)
    {
        $sandi_bpr = $request->sandi_bpr;
        $req['sandi_bpr'] = $sandi_bpr;
        $req['tahun'] = $request->tahun ?? LaporanPosisiKeuanganTable::max_tahun($req);
        $req['bulan'] = $request->bulan ?? LaporanPosisiKeuanganTable::max_bulan($req);
            
        $tahun = $req['tahun'];
        $bulan = $req['bulan'];
        // master data
        $data = LaporanPosisiKeuanganTable::spreadSheet($req);
        // Laporan laba rugi
        
        $req['tahun'] = $request->tahun ?? LaporanLabaRugiTable::max_tahun($req);
        $req['bulan'] = $request->bulan ?? LaporanLabaRugiTable::max_bulan($req);
        $laba_rugi = LaporanLabaRugiTable::spreadsheet($req);
        // rekening administratif

        $req['tahun'] = $request->tahun ?? RekeningAdministratif::max_tahun($req);
        $req['bulan'] = $request->bulan ?? RekeningAdministratif::max_bulan($req);
        $rekening_administratif = RekeningAdministratif::spreadsheet($req);
        
        // input profil
        $req['tahun'] = $request->tahun ?? InputProfil::max_tahun($req);
        $req['bulan'] = $request->bulan ?? InputProfil::max_bulan($req);
        $input_profil = InputProfil::spreadSheet($req);
        $jumlah_peminjam = $input_profil->jumlah_peminjam ?? 0;

        $req['data'] = $data;
        $req['laba_rugi'] = $laba_rugi;
        // perhitungan PPAP wajib
        $perhitungan_ppap_wajib = LaporanPosisiKeuanganTable::getPerhitunganPpapWajib($req);
        $ppap_tersedia= $data->whereIn('sandi_coa', [1104020000,1103020000])->sum('posisi_tanggal_laporan');
        $kekurangan_pembentukan_ppap = ($ppap_tersedia > $perhitungan_ppap_wajib) ? 0 : $ppap_tersedia - $perhitungan_ppap_wajib;
         // hitung modal inti
        $sub_total = LaporanPosisiKeuanganTable::getSubTotal($req);
        $modal_inti = $sub_total + $kekurangan_pembentukan_ppap +0;
        //total_aktiva_produktif
        $piutang = $data->whereIn('sandi_coa', [1104010100])->sum('posisi_tanggal_laporan');
        $total_aktiva_produktif = $piutang + $data->where('sandi_coa', 1103010000)->sum('posisi_tanggal_laporan');

        $jumlah_kewajiban = LaporanPosisiKeuanganTable::getJumlahKewajiban($req);
        $komponen_modal = LaporanPosisiKeuanganTable::getKomponenModal($req);
        // Gabungan dengan laba rugi yang belum di realisasi + surplus revaluasi aset tetap
        $dana_setoran_modal_ekuitas = $data->whereIn('sandi_coa', [3102030000,3102040000,3103020000])->sum('posisi_tanggal_laporan');
        $saldo_laba = $data->whereIn('sandi_coa', [3104010000,3104020000,3105010000,3105020000])->sum('posisi_tanggal_laporan');
        $jumlah_ekuitas = $komponen_modal + $dana_setoran_modal_ekuitas + $saldo_laba;
        $beban_bunga = LaporanLabaRugiTable::getBebanBunga($req);
        $pendapatan_operasional = $laba_rugi->whereIn('sandi_coa', [4101000000,4102000000])->sum('posisi_tanggal_laporan');
        $beban_operasional_non_bunga = LaporanLabaRugiTable::getBebanOperasionalNonBunga($req) - $beban_bunga;
        // atmr
        $atmr = LaporanPosisiKeuanganTable::getAtmr($req);
        $req['atmr'] = $atmr;
        // jumlah modal pelengkap
        $cadangan_revaluasi = 0;
        $modal_pinjaman_kuasi = $data->where('sandi_coa', 2299030002)->sum('posisi_tanggal_laporan');
        $pinjaman_subordinasi = $data->where('pos', 'Pinjaman subordinasi')->sum('posisi_tanggal_laporan');
        $penyisihan_penghapusan_aktiva = LaporanPosisiKeuanganTable::getPenyisihanPenghapusanAktiva($req);
        $jumlah_modal_pelengkap = $modal_pinjaman_kuasi + $pinjaman_subordinasi + $penyisihan_penghapusan_aktiva + $cadangan_revaluasi;
        // hitung jumlah modal inti pelengkap
        $cadangan_revaluasi = 0;
        $penyisihan_penghapusan_aktiva = LaporanPosisiKeuanganTable::getPenyisihanPenghapusanAktiva($req);
        $modal_pinjaman_kuasi = $data->where('sandi_coa', 2299030002)->sum('posisi_tanggal_laporan');
        $pinjaman_subordinasi = $data->where('sandi_coa', 2299030002)->sum('posisi_tanggal_laporan');
        $jumlah_modal_pelengkap = $modal_pinjaman_kuasi + $pinjaman_subordinasi + $penyisihan_penghapusan_aktiva + $cadangan_revaluasi;
        $req['jumlah_modal_inti'] = $modal_inti;
        $req['jumlah_modal_pelengkap'] = $jumlah_modal_pelengkap;
        $jumlah_modal_pelengkap_yang_dipertahankan = LaporanPosisiKeuanganTable::getJumlahModalPelengkapYangDipertahankan($req);
        $jumlah_modal_inti_pelengkap = $modal_inti + $jumlah_modal_pelengkap_yang_dipertahankan;
        //laba rugi berjalan sebelum pajak
        $total_pendapatan_operasional = $laba_rugi->whereIn('sandi_coa', [4102000000,4101000000])->sum('posisi_tanggal_laporan');
        $sub_total_beban_bunga = LaporanLabaRugiTable::getSubTotalBebanBunga($req);
        $req['sub_total_beban_bunga'] = $sub_total_beban_bunga;
        $sub_total_beban_operasional = LaporanLabaRugiTable::getSubTotalBebanBungaOperasional($req);
        $laba_rugi_operasional = $total_pendapatan_operasional - $sub_total_beban_operasional;
        // total aktiva
        $total_aktiva = LaporanPosisiKeuanganTable::getTotalAktiva($req);
        // total passiva
        $jumlah_kewajiban = LaporanPosisiKeuanganTable::getJumlahKewajiban($req);
        $total_passiva = $jumlah_ekuitas + $jumlah_kewajiban;

        return view('laporan-keuangan-bulanan/rasio', compact(
            'data',
            'sandi_bpr',
            'jumlah_kewajiban',
            'jumlah_ekuitas',
            'laba_rugi',
            'beban_bunga',
            'beban_operasional_non_bunga',
            'perhitungan_ppap_wajib',
            'pendapatan_operasional',
            'total_aktiva_produktif',
            'modal_inti',
            'jumlah_modal_inti_pelengkap',
            'atmr',
            'bulan',
            'tahun',
            'sub_total_beban_operasional',
            'sub_total_beban_bunga',
            'total_pendapatan_operasional',
            'total_passiva',
            'total_aktiva',
            'komponen_modal',
            'rekening_administratif',
            'input_profil',
            'jumlah_peminjam',
        ));
    }

    public function store(Request $request)
    {
        $cek =  DB::table('laporan_aset_produktif')->where(['bulan'=>$request->bulann, 'tahun'=>$request->tahunn, 'sandi_bpr'=>$request->sandi_bpr])->value('id');

        if ($cek == null):

            $jumlah = count($request->pos);
            for ($i=0; $i<$jumlah; $i++):
                    
                DB::table('laporan_aset_produktif')
                ->insert([
                    'pos'=>$request->pos[$i] ?? '',
                    'jumlah'=>$request->jumlah[$i] ?? 0,
                    'excel_status'=>'N',
                    'created_at'=>\Carbon\Carbon::now(),
                    'updated_at'=>\Carbon\Carbon::now(),
                    'sandi_bpr'=>$request->sandi_bpr,
                    'bulan'=>$request->bulann,
                    'tahun'=>$request->tahunn
                ]);

            endfor;

            return back()->with('success', 'Berhasil simpan Ratio');
        else:
            return back()->withError('Gagal simpan Ratio karena sudah ada');
        endif;
    }
}
