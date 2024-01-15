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

class AtmrController extends Controller
{
    public function index($sandi_bpr)
    {        
        $req['sandi_bpr'] = $sandi_bpr;
        $req['tahun'] = LaporanPosisiKeuanganTable::max_tahun($req);
        $req['bulan'] = LaporanPosisiKeuanganTable::max_bulan($req);
         
        $data = LaporanPosisiKeuanganTable::spreadSheet($req);
        $aktiva_lainnya = $data->whereIn('sandi_coa', [1103000000,1103000000,1299000000,1201000000])->sum('posisi_tanggal_laporan');

        $parsing = [
            'bulan'=>$req['bulan'],
            'tahun'=>$req['tahun'],
            'data'=>$data,
            'aktiva_lainnya'=> $aktiva_lainnya,
            'sandi_bpr'=>$req['sandi_bpr']
        ];

        return view('laporan-keuangan-bulanan/atmr')->with($parsing);
    }

    public function show(Request $request)
    {        
        $req['sandi_bpr'] = $request->sandi_bpr;
        $req['tahun'] = $request->tahun; 
        $req['bulan'] = $request->bulan;
         
        $data = LaporanPosisiKeuanganTable::spreadSheet($req);
        $aktiva_lainnya = $data->whereIn('sandi_coa', [1103000000,1103000000,1299000000,1201000000])->sum('posisi_tanggal_laporan');

        $parsing = [
            'bulan'=>$req['bulan'],
            'tahun'=>$req['tahun'],
            'data'=>$data,
            'aktiva_lainnya'=> $aktiva_lainnya,
            'sandi_bpr'=>$req['sandi_bpr']
        ];

        return view('laporan-keuangan-bulanan/atmr')->with($parsing);
    }

    public function store(Request $request)
    {
        $cek = DB::table('atmr')->where(['sandi_bpr'=>$request->sandi_bpr, 'tahun'=>$request->tahunn, 'bulan'=>$request->bulan])->value('id');

        if($cek == null):
            $jumlah = count($request->keterangan);

            for ($i=0; $i<$jumlah; $i++):

                DB::table('atmr')->insert([
                    'keterangan'=>$request->keterangan[$i],
                    'sandi_bpr'=>$request->sandi_bpr ?? '',
                    'tahun'=>$request->tahunn ?? 0,
                    'bulan'=>$request->bulann ?? 0,
                    'nominal'=>preg_replace('/[^0-9]/', '', $request->nominal[$i]) ?? 0,
                    'persen'=>$request->persen[$i] ?? 0,
                    'total'=>preg_replace('/[^0-9]/', '', $request->total[$i]) ?? 0,
                    'created_at'=>\Carbon\Carbon::now(),
                    'updated_at'=>\Carbon\Carbon::now(),
                ]);

            endfor;
        else:
            return redirect('atmr/'.$request->sandi_bpr)->withError('ATMR sudah ada');
        endif;

        return redirect('atmr/'.$request->sandi_bpr)->with('success', 'Berhasil simpan ATMR');
        
    }
}
