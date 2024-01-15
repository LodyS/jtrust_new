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

class SpreadSheetController extends Controller
{
    public function ppap(Request $request)
    {
        $req['sandi_bpr'] = $request->sandi_bpr;
        $req['tahun'] = $request->tahun ?? LaporanPosisiKeuanganTable::max_tahun($req);
        $req['bulan'] = $request->bulan ?? LaporanPosisiKeuanganTable::max_bulan($req);
        $req['data'] = LaporanPosisiKeuanganTable::spreadSheet($req);
        $req['perhitungan_ppap_wajib'] = LaporanPosisiKeuanganTable::getPerhitunganPpapWajib($req);

        $parsing = [
            'sandi_bpr'=>$req['sandi_bpr'],
            'tahun'=>$req['tahun'],
            'bulan'=>$req['bulan'],
            'data'=>$req['data'],
            'perhitungan_ppap_wajib'=>$req['perhitungan_ppap_wajib']
        ];

        return view('laporan-keuangan-bulanan/ppap')->with($parsing);
    }
}
