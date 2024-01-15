<?php

namespace App\Http\Controllers;
use App\Models\LaporanAsetProduktif;
use DB;
use App\Models\Header;
use App\Models\HeaderImport;
use App\Models\InformasiPokokBprPelapor;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\LaporanAsetProduktifImport;
use App\Http\Requests\ExcelRequest;

class LaporanAsetProduktifController extends Controller
{
    public function index(Request $request)
    {
        $sandi_bpr = $request->sandi_bpr;
       
        return view('financial-highlight/laporan-aset-produktif/import', compact('sandi_bpr'));
    }

    public function store(ExcelRequest $request)
    {
        DB::beginTransaction();

        try {

            $req = $request->all();
            $req['periode_waktu'] = $request->periode_waktu;
            $req['status_excel'] = 'Y';
            $cek = HeaderImport::checkLaporanAsetProduktif($req)->value('id');

            if (isset($cek)):
                return back()->withError('Gagal import karena sudah sudah di import');
            else:

                $header = HeaderImport::create($req);
                $id_header = $header->id;

                Excel::import(new LaporanAsetProduktifImport($id_header), $request->file('file'));

                LaporanAsetProduktif::where('pos', null)
                ->orWhere('pos', 'pos')
                ->orWhere('pos', 'like', 'Jl.%')
                ->orWhere('pos', 'like', 'Jln%')
                ->orWhere('pos', 'like', 'Jalan%')
                ->orWhere('l', 'Ribuan Rp.')
                ->orWhere('pos', '1.')
                ->orWhere('pos', '2.')
                ->orWhere('pos', '3.')
                ->orWhere('pos', '4.')
                ->orWhere('pos', '5.')
                ->orWhere('l', 'L')
                ->orWhere('pos', 'like', 'Provinsi%')
                ->delete();

                DB::commit();
                return back()->with('success', 'Berhasil import laporan aset produktif');

            endif;

        } catch (Exception $e){
            DB::rollback();
            return back()->withError('Gagal Import');
        }
    }

    public function report (Request $request)
    {
        $req['sandi_bpr'] = $request->sandi_bpr;
        $req['tahun'] = $request->tahun ?? LaporanAsetProduktif::max_tahun($req);
        $req['bulan'] = LaporanAsetProduktif::max_bulan($req);
       
        $param = [
            'tahun'=>$req['tahun'],
            'sandi_bpr'=>$request->sandi_bpr,
            'data'=>DB::table('laporan_aset_produktif')->where(['sandi_bpr'=>$request->sandi_bpr, 'bulan'=>$req['bulan'], 'tahun'=>$req['tahun']])->get(['pos']),
            'jan'=>LaporanAsetProduktif::report_bulanan($request->sandi_bpr, $req['tahun'], 1),
            'feb'=>LaporanAsetProduktif::report_bulanan($request->sandi_bpr, $req['tahun'], 2),
            'mar'=>LaporanAsetProduktif::report_bulanan($request->sandi_bpr, $req['tahun'], 3),
            'apr'=>LaporanAsetProduktif::report_bulanan($request->sandi_bpr, $req['tahun'], 4),
            'mei'=>LaporanAsetProduktif::report_bulanan($request->sandi_bpr, $req['tahun'], 5),
            'jun'=>LaporanAsetProduktif::report_bulanan($request->sandi_bpr, $req['tahun'], 6),
            'jul'=>LaporanAsetProduktif::report_bulanan($request->sandi_bpr, $req['tahun'], 7),
            'ags'=>LaporanAsetProduktif::report_bulanan($request->sandi_bpr, $req['tahun'], 8),
            'sep'=>LaporanAsetProduktif::report_bulanan($request->sandi_bpr, $req['tahun'], 9),
            'okt'=>LaporanAsetProduktif::report_bulanan($request->sandi_bpr, $req['tahun'], 10),
            'nov'=>LaporanAsetProduktif::report_bulanan($request->sandi_bpr, $req['tahun'], 11),
            'des'=>LaporanAsetProduktif::report_bulanan($request->sandi_bpr, $req['tahun'], 12),
        ];

        return view('financial-highlight/laporan-aset-produktif/report')->with($param);
    }
}
