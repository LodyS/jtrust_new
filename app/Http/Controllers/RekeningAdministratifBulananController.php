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

class RekeningAdministratifBulananController extends Controller
{
    public function index ($sandi_bpr)
    {
        $coa = DB::table('coa')->where('bagian', 'Rekening Administratif')->get();

        return view('laporan-keuangan-bulanan/rekening-administratif', compact('coa', 'sandi_bpr'));
    }

    public function store (LaporanBulananRequest $request)
    {
        $jumlah = count($request->coa_id);
        for ($i=0; $i<$jumlah; $i++):

            DB::table('rekening_administratif')
            ->insert([
                'pos'=>$request->coa_id[$i] ?? '',
                'nominal'=>preg_replace('/[^0-9]/', '', $request->nominal[$i]) ?? 0,
                'sandi_bpr'=>$request->sandi_bpr,
                'bulan'=>$request->bulan,
                'tahun'=>$request->tahun,
                'sandi_coa'=>$request->sandi_coa[$i],
                'created_at'=>\Carbon\Carbon::now(),
                'updated_at'=>\Carbon\Carbon::now(),
            ]);

        endfor;

        return back()->with('success', 'Berhasil simpan rekening administratif');
    }

    public function cari(Request $request)
    {
        $req['sandi_bpr'] = $request->sandi_bpr;
        $req['tahun'] = $request->tahun ?? RekeningAdministratif::max_tahun($req);
        $req['bulan'] = $request->bulan ?? RekeningAdministratif::max_bulan($req);
   
        $parsing = [
            'sandi_bpr'=>$req['sandi_bpr'],
            'bulan'=>$req['bulan'],
            'tahun'=>$req['tahun'],
            'data'=>RekeningAdministratif::spreadsheet($req),
        ];

        return view('laporan-keuangan-bulanan/cari-rekening-administratif')->with($parsing);    
    }

    public function update(Request $request)
    {
        $jumlah = count($request->id);
        for ($i=0; $i<$jumlah; $i++):
            
            DB::table('rekening_administratif')
            ->where('id', $request->id[$i])
            ->update([
                'nominal'=>preg_replace('/[^0-9]/', '', $request->nominal[$i]) ?? 0,
                'updated_at'=>\Carbon\Carbon::now(),
            ]);

        endfor;

        return redirect('cari-rekening-administratif/'.$request->sandi_bpr)->with('success', 'Berhasil update Rekening Administratif');
    }
}
