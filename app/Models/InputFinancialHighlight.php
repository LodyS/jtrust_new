<?php

namespace App\Models;
use DB;
use Illuminate\Database\Eloquent\Model;

class InputFinancialHighlight extends Model
{
    protected $table = 'input_financial_highlight';
    protected $fillable = [
        'sandi_bpr',
        'keterangan',
        'bulan',
        'tahun',
        'nominal',
        'jenis',
        'sub_jenis'
    ];

    public static function cariBulanMax($req)
    {
        $tahun = $req['tahun'];
        $data = InputFinancialHighlight::when($tahun, function($query, $tahun){
            $query->where('tahun', $tahun);
        })
        ->where('sandi_bpr', $req['sandi_bpr'])
        //->where('jenis', $req['jenis'])
        ->max('bulan');

        return $data;
    }

    public static function max_tahun($req)
    {
        return InputFinancialHighlight::where('sandi_bpr', $req['sandi_bpr'])->max('tahun');
    }

    public static function max_bulan($req)
    {
        return InputFinancialHighlight::where('sandi_bpr', $req['sandi_bpr'])->where('tahun', $req['tahun'])->max('bulan');
    }

    public static function report($req)
    {
        $sandi_bpr = $req['sandi_bpr'];
        $tahun_satu = $req['tahun_satu'];
        $tahun_dua = $req['tahun_dua'];
        $tahun_tiga = $req['tahun_tiga'];
        $tahun_ini = $req['tahun_ini'];
        $tahun_depan = $req['tahun_depan'];
        $bulan_berjalan = $req['bulan_berjalan'];
      	$tahun_berjalan = $req['tahun_berjalan'];

      	$tahun_max_rkat = $req['tahun_max_rkat'];
      	$tahun_rkat_sebelum = $req['tahun_rkat_sebelumnya'];
    
        $data = DB::select("SELECT a.keterangan,
        coalesce(b.nominal,0) AS b_nominal,
        coalesce(c.nominal,0) AS c_nominal,
        coalesce(d.nominal,0) AS d_nominal,
        coalesce(e.nominal,0) AS e_nominal,
        coalesce(f.nominal,0) AS f_nominal,
        coalesce(g.nominal,0) AS g_nominal
        FROM

        (SELECT DISTINCT(keterangan) AS keterangan FROM input_financial_highlight) a

        LEFT JOIN
        (SELECT keterangan, nominal FROM input_financial_highlight
        WHERE tahun='$tahun_ini' AND bulan='12' AND sandi_bpr='$sandi_bpr' AND jenis='Realisasi' AND sub_jenis='Audit') b ON b.keterangan = a.keterangan

        LEFT JOIN
        (SELECT keterangan, nominal FROM input_financial_highlight
        WHERE tahun='$tahun_dua' AND bulan='12' AND sandi_bpr='$sandi_bpr' AND jenis='Realisasi' AND sub_jenis='Audit') c ON c.keterangan = a.keterangan

        LEFT JOIN
        (SELECT keterangan, nominal FROM input_financial_highlight
        WHERE tahun='$tahun_satu' AND bulan='12' AND sandi_bpr='$sandi_bpr' AND jenis='Realisasi' AND sub_jenis='Audit') d ON d.keterangan = a.keterangan

        LEFT JOIN
        (SELECT keterangan, nominal FROM input_financial_highlight
        WHERE tahun='$tahun_berjalan' AND bulan='$bulan_berjalan' AND sandi_bpr='$sandi_bpr' AND jenis='Realisasi' AND sub_jenis='OJK Publikasi')
        e ON e.keterangan = a.keterangan

        LEFT JOIN
        (SELECT keterangan, nominal FROM input_financial_highlight
        WHERE tahun='$tahun_rkat_sebelum' AND bulan='12' AND sandi_bpr='$sandi_bpr' AND jenis='RKAT' AND sub_jenis = 'Disampaikan ke OJK')
        f ON f.keterangan = a.keterangan

        LEFT JOIN
        (SELECT keterangan, nominal FROM input_financial_highlight
        WHERE tahun='$tahun_max_rkat' AND bulan='12' AND sandi_bpr='$sandi_bpr' AND jenis='RKAT' AND sub_jenis = 'Disampaikan ke OJK')
        g ON g.keterangan = a.keterangan");

        return $data;
    }

    public static function laporan($bulan, $tahun, $jenis, $sub_jenis)
    {
        return DB::table('input_financial_highlight')->where([
            'tahun'=>$tahun,
            'bulan'=>$bulan,
            'jenis'=>$jenis,
            'sub_jenis'=>$sub_jenis
        ])
        ->orderBy('id', 'asc')
        ->get();
    }

    public static function cari_max($sandi_bpr, $filter, $jenis)
    {
        return DB::table('input_financial_highlight')
        ->where([
            'tahun'=>DB::table('input_financial_highlight')->where('sandi_bpr', $sandi_bpr)->where($filter, $jenis)->max('tahun'),
            'sandi_bpr'=>$sandi_bpr, 
        ])
        ->when($jenis !== 'OJK Publikasi', function($query){
            $query->where('bulan', 12);
        })
        ->first();
    }
}
