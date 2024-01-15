<?php

namespace App\Http\Controllers;
use DB;
use App\Models\InputFinancialHighlight;
use Illuminate\Http\Request;

class FinancialHighlightController extends Controller
{
    public function index($sandi_bpr)
    {
        $cek = DB::table('input_financial_highlight')->where('sandi_bpr', $sandi_bpr)->first();

        $bulan_berjalan = DB::table('input_financial_highlight')
        ->where('tahun', DB::table('input_financial_highlight')->where('sandi_bpr', $sandi_bpr)->where('sub_jenis', 'OJK Publikasi')->max('tahun'))
        ->where('sandi_bpr', $sandi_bpr)
        ->first();

      	$desember_akhir = DB::table('input_financial_highlight')
        ->where('tahun', DB::table('input_financial_highlight')->where('sandi_bpr', $sandi_bpr)->where('sub_jenis', 'Audit')->max('tahun'))
        ->where('sandi_bpr', $sandi_bpr)
        ->where('bulan', '12')
        ->first();

      	$tahun_max_rkat = DB::table('input_financial_highlight')
        ->where('tahun', DB::table('input_financial_highlight')->where('sandi_bpr', $sandi_bpr)->where('jenis', 'RKAT')->max('tahun'))
        ->where('sandi_bpr', $sandi_bpr)
        ->where('bulan', '12')
        ->first();

        if ($cek == null):
            return back()->withError('Belum isi input financial highlight');
        endif;

        $tahun_ini = $desember_akhir->tahun ?? date('Y')-1;

        $tahun_max_rkat = $tahun_max_rkat->tahun ?? '';
        $tahun_rkat_sebelumnya = ($tahun_max_rkat == null) ? '' : $tahun_max_rkat - 1;

        $req['tahun_ini'] = $tahun_ini;
        $req['tahun_satu'] = ($tahun_ini == null) ? '' : $req['tahun_ini'] -1;
        $req['tahun_dua'] = ($tahun_ini == null) ? '' : $req['tahun_ini'] -2;
        $req['tahun_tiga'] = ($tahun_ini == null) ? '' : $req['tahun_ini'] -3;
        $req['tahun_depan'] = ($tahun_ini == null) ? '' : $req['tahun_ini'] +1;
        $req['sandi_bpr'] = $sandi_bpr;
        $req['bulan_berjalan'] = $bulan_berjalan->bulan ?? '';
      	$req['tahun_berjalan'] = $bulan_berjalan->tahun ?? '';
      	$req['tahun_max_rkat'] = $tahun_max_rkat ?? '';
      	$req['tahun_rkat_sebelumnya'] = ($tahun_max_rkat== null) ? '' : $tahun_max_rkat - 1 ?? '';
		  //dd($req);

        $tahun_ini = $desember_akhir->tahun ?? '';

        $data = InputFinancialHighlight::report($req);

        return view('financial-highlight/index', compact('data', 'sandi_bpr', 'bulan_berjalan', 'tahun_ini', 'tahun_max_rkat', 'tahun_rkat_sebelumnya'));
    }
}
