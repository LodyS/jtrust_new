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

class LaporanLabaRugiBulananController extends Controller
{
    public function index($sandi_bpr)
    {
        $coa = DB::table('coa')->where('bagian', 'Laporan Laba Rugi')->get();

        return view('laporan-keuangan-bulanan/laporan-laba-rugi', compact('sandi_bpr', 'coa'));
    }

    public function store (LaporanBulananRequest $request)
    {
        $jumlah = count($request->coa_id);
        for ($i=0; $i<$jumlah; $i++):

            DB::table('laporan_laba_rugi_table')
            ->insert([
                'pos'=>$request->coa_id[$i] ?? '',
                'posisi_tanggal_laporan'=>preg_replace('/[^0-9]/', '', $request->nominal[$i]) ?? 0,
                'sandi_bpr'=>$request->sandi_bpr,
                'sandi_coa'=>$request->sandi_coa[$i],
                'bulan'=>$request->bulan,
                'tahun'=>$request->tahun,
                'excel_status'=>'N',
                'created_at'=>\Carbon\Carbon::now(),
                'updated_at'=>\Carbon\Carbon::now(),
            ]);

        endfor;

        return back()->with('success', 'Berhasil simpan');
    }

    public function search(Request $request)
    {
        $req['sandi_bpr'] = $request->sandi_bpr;
        $req['tahun'] = $request->tahun ?? LaporanLabaRugiTable::max_tahun($req);
        $req['bulan'] = $request->bulan ?? LaporanLabaRugiTable::max_bulan($req); 
      
        $parsing = [
            'sandi_bpr'=>$req['sandi_bpr'],
            'bulan'=>$req['bulan'],
            'tahun'=>$req['tahun'],
            'data'=>LaporanLabaRugiTable::spreadsheet_tiga($req),
        ];

        return view('laporan-keuangan-bulanan/cari-laporan-laba-rugi')->with($parsing);
    }

    public function update(Request $request)
    {

        $jumlah = count($request->id);
        for ($i=0; $i<$jumlah; $i++):

            DB::table('laporan_laba_rugi_table')
            ->where('id', $request->id[$i])
            ->update([
                'posisi_tanggal_laporan'=>preg_replace('/[^0-9]/', '', $request->nominal[$i]) ?? 0,
                'updated_at'=>\Carbon\Carbon::now(),
            ]);

        endfor;

        return redirect('cari-laporan-laba-rugi/'.$request->sandi_bpr)->with('success', 'Berhasil update Laporan Laba Rugi');
    }
}
