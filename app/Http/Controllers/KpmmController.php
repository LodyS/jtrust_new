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

class KpmmController extends Controller
{
    public function index(Request $request)
    {
        $req['sandi_bpr'] = $request->sandi_bpr;
        $req['tahun'] = $request->tahun ?? LaporanPosisiKeuanganTable::max_tahun($req);
        $req['bulan'] = $request->bulan ?? LaporanPosisiKeuanganTable::max_bulan($req);

        $data = LaporanPosisiKeuanganTable::spreadSheet($req);   
        //atmr
        $req['data'] = $data;
        $atmr = LaporanPosisiKeuanganTable::getAtmr($req);
        // kekurangan pembentukan ppap
        $ppap_tersedia= $data->whereIn('sandi_coa', [1104020000,1103020000])->sum('posisi_tanggal_laporan');
        // perhitungan PPAP
        $perhitungan_ppap_wajib = LaporanPosisiKeuanganTable::getPerhitunganPpapWajib($req);
        $kekurangan_pembentukan_ppap = ($ppap_tersedia > $perhitungan_ppap_wajib) ? 0 : $ppap_tersedia - $perhitungan_ppap_wajib;

        $parsing = [
            'sandi_bpr'=>$request->sandi_bpr,
            'tahun'=>$req['tahun'],
            'bulan'=>$req['bulan']
        ];

        return view('laporan-keuangan-bulanan/kpmm', compact('data', 'atmr', 'kekurangan_pembentukan_ppap'))->with($parsing);
    }
}
