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

class InputProfilBulananController extends Controller
{
    public function index($sandi_bpr)
    {
        return view('laporan-keuangan-bulanan/input-profil', compact('sandi_bpr'));
    }

    public function store(InputProfilRequest $request)
    {
        InputProfil::create($request->validated());

        return back()->with('success', 'Berhasil simpan');
    }

    public function cari(Request $request)
    {
        $req['sandi_bpr'] = $request->sandi_bpr;
        $req['tahun'] = $request->tahun ?? InputProfil::max_tahun($req);
        $req['bulan'] = $request->bulan ?? InputProfil::max_bulan($req);
       
        $parsing = [
            'tahun'=>$req['tahun'],
            'bulan'=>$req['bulan'],
            'sandi_bpr'=>$req['sandi_bpr'],
            'data'=>InputProfil::where(['bulan'=>$req['bulan'], 'tahun'=>$req['tahun'], 'sandi_bpr'=>$req['sandi_bpr']])->toBase()->first(),
        ];

        return view('laporan-keuangan-bulanan/cari-input-profil')->with($parsing);       
    }

    public function update(Request $request)
    {
        InputProfil::where('id', $request->id)->update($request->except('_token', 'tahun', 'action', 'bulan'));
        return redirect('cari-input-profil/'.$request->sandi_bpr)->with('success', 'Berhasil update Input Profil');
    }
}
