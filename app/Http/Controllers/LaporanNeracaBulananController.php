<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Support\Facades\Redirect;
use App\Models\LaporanPosisiKeuanganTable;
use App\Models\InformasiPokokBprPelapor;
use App\Models\RekeningAdministratif;
use App\Models\HeaderImport;
use App\Models\InputProfil;
use App\Models\LaporanLabaRugiTable;
use App\Http\Requests\LaporanBulananRequest;
use App\Http\Requests\InputProfilRequest;
use App\Models\InputFinancialHighlight;
use App\Models\LaporanAsetProduktif;
use Illuminate\Http\Request;

class LaporanNeracaBulananController extends Controller
{
    public function index($sandi_bpr)
    {
        $coa = DB::table('coa')->where('bagian', 'Laporan Neraca')->get();

        return view('laporan-keuangan-bulanan/index', compact('sandi_bpr', 'coa'));
    }

    public function search (Request $request)
    {  
        $req['sandi_bpr'] = $request->sandi_bpr;
        $req['tahun'] = $request->tahun ?? LaporanPosisiKeuanganTable::max_tahun($req);
        $req['bulan'] = $request->bulan ?? LaporanPosisiKeuanganTable::max_bulan($req); 
   
        $parsing = [
            'sandi_bpr'=>$req['sandi_bpr'],
            'bulan'=>$req['bulan'],
            'tahun'=>$req['tahun'],
            'data'=>LaporanPosisiKeuanganTable::spreadsheet_tiga($req),
        ];

        return view('laporan-keuangan-bulanan/cari-laporan-neraca')->with($parsing);
    }

    public function store (LaporanBulananRequest $request)
    {
        if($request->balance > 0 or $request->balance !== 0):
            return back()->withError('Balance belum sama');
        endif;
        
        $jumlah = count($request->coa_id);
        
        for ($i=0; $i<$jumlah; $i++):
            DB::table('laporan_posisi_keuangan_table')
            ->insert([
                'pos'=>$request->coa_id[$i] ?? '',
                'posisi_tanggal_laporan'=>preg_replace('/[^0-9]/', '',$request->nominal[$i]) ?? 0,
                'sandi_bpr'=>$request->sandi_bpr,
                'sandi_coa'=>$request->sandi_coa[$i],
                'tahun'=>$request->tahun,
                'bulan'=>$request->bulan,
                'excel_status'=>'N',
                'created_at'=>\Carbon\Carbon::now(),
                'updated_at'=>\Carbon\Carbon::now(),
            ]);

        endfor;

        return back()->with('success', 'Berhasil simpan');
    }

    public function update(Request $request)
    {
        $jumlah = count($request->id);
        for ($i=0; $i<$jumlah; $i++):

            DB::table('laporan_posisi_keuangan_table')
            ->where('id', $request->id[$i])
            ->update([
                'posisi_tanggal_laporan'=>preg_replace('/[^0-9]/', '', $request->nominal[$i]) ?? 0,
                'updated_at'=>\Carbon\Carbon::now(),
            ]);

        endfor;

        return redirect('cari-laporan-keuangan-bulanan/'.$request->sandi_bpr)->with('Berhasil update Laporan Neraca');
    }
}
