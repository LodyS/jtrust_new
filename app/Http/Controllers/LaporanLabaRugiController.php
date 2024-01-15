<?php

namespace App\Http\Controllers;
use App\Models\LaporanLabaRugi;
use DB;
use Auth;
use App\Models\Header;
use App\Models\HeaderImport;
use DataTables;
use App\Models\InformasiPokokBprPelapor;
use App\Models\LaporanLabaRugiTable;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\LaporanLabaRugiImport;
use App\Http\Requests\ExcelRequest;
use App\Http\Requests\TxtRequest;
use Illuminate\Http\Request;

class LaporanLabaRugiController extends Controller
{
    public function import(Request $request)
    {
        $sandi_bpr = $request->sandi_bpr;
        return view('financial-highlight/laporan-laba-rugi/import', compact('sandi_bpr'));
    }

    public function store (ExcelRequest $request)
    {
        DB::beginTransaction();

        try {

            $req = $request->all();
            $req['periode_waktu'] = $request->periode_waktu;
            $req['status_excel'] = 'Y';
            
            $cek = HeaderImport::checkLaporanLabaRugi($req)->value('id');

            if (isset($cek)):
                return back()->withError('Gagal import karena sudah di import');

            else:

                $header = HeaderImport::create($req);
                $id_header = $header->id;

                Excel::import(new LaporanLabaRugiImport($id_header), $request->file('file'));
                LaporanLabaRugiTable::filterDelete()->delete();
                LaporanLabaRugiTable::deleteFilter()->delete();
                LaporanLabaRugiTable::deleteJalan()->delete();

                DB::commit();
                return back()->with('success', 'Berhasil import laporan laba rugi');

            endif;

        } catch (Exception $e){
            DB::rollback();
            return back()->withError('Gagal Import');
        }
    }

    public function report (Request $request)
    {
        $req['sandi_bpr'] = $request->sandi_bpr;
        $tahun = (isset($request->tahun)) ? (int)$request->tahun : date('Y');
        $req['tahun'] = $tahun;
        $bulan = LaporanLabaRugiTable::max_bulan($req);
        $bpr = InformasiPokokBprPelapor::where('uuid', $request->sandi_bpr)->toBase()->first();
     
        $tahun_sebelumnya = $tahun-1;
        $sandi_bpr = $request->sandi_bpr;
        
        $param = [
            'bpr'=>$bpr,
            'tahun'=>$tahun,
            'sandi_bpr'=>$request->sandi_bpr,
            'data'=>DB::table('laporan_laba_rugi_table')->select('pos')->where(['sandi_bpr'=>$sandi_bpr, 'tahun'=>$tahun, 'bulan'=>$bulan])->get(),
            'jan'=>LaporanLabaRugi::report_bulanan($sandi_bpr, $tahun, 1),
            'jan_b'=>LaporanLabaRugi::report_bulanan($sandi_bpr, $tahun_sebelumnya, 1),
            'feb'=>LaporanLabaRugi::report_bulanan($sandi_bpr, $tahun, 2),
            'feb_b'=>LaporanLabaRugi::report_bulanan($sandi_bpr, $tahun_sebelumnya, 2),
            'maret'=>LaporanLabaRugi::report_bulanan($sandi_bpr, $tahun, 3),
            'maret_b'=>LaporanLabaRugi::report_bulanan($sandi_bpr, $tahun_sebelumnya, 3),
            'april'=>LaporanLabaRugi::report_bulanan($sandi_bpr, $tahun, 4),
            'april_b'=>LaporanLabaRugi::report_bulanan($sandi_bpr, $tahun_sebelumnya, 4),
            'mei'=>LaporanLabaRugi::report_bulanan($sandi_bpr, $tahun, 5),
            'mei_b'=>LaporanLabaRugi::report_bulanan($sandi_bpr, $tahun_sebelumnya, 5),
            'juni'=>LaporanLabaRugi::report_bulanan($sandi_bpr, $tahun, 6),
            'juni_b'=>LaporanLabaRugi::report_bulanan($sandi_bpr, $tahun_sebelumnya, 6),
            'juli'=>LaporanLabaRugi::report_bulanan($sandi_bpr, $tahun, 7),
            'juli_b'=>LaporanLabaRugi::report_bulanan($sandi_bpr, $tahun_sebelumnya, 7),
            'agustus'=>LaporanLabaRugi::report_bulanan($sandi_bpr, $tahun, 8),
            'agustus_b'=>LaporanLabaRugi::report_bulanan($sandi_bpr, $tahun_sebelumnya, 8),
            'september'=>LaporanLabaRugi::report_bulanan($sandi_bpr, $tahun, 9),
            'september_b'=>LaporanLabaRugi::report_bulanan($sandi_bpr, $tahun_sebelumnya, 9),
            'oktober'=>LaporanLabaRugi::report_bulanan($sandi_bpr, $tahun, 10),
            'oktober_b'=>LaporanLabaRugi::report_bulanan($sandi_bpr, $tahun_sebelumnya, 10),
            'november'=>LaporanLabaRugi::report_bulanan($sandi_bpr, $tahun, 11),
            'november_b'=>LaporanLabaRugi::report_bulanan($sandi_bpr, $tahun_sebelumnya, 11),
            'desember'=>LaporanLabaRugi::report_bulanan($sandi_bpr, $tahun, 12),
            'desember_b'=>LaporanLabaRugi::report_bulanan($sandi_bpr, $tahun_sebelumnya, 12),
        ];

        return view('financial-highlight/laporan-laba-rugi/report')->with($param);
    }
}
