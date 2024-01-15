<?php

namespace App\Models;
use DB;
use Illuminate\Database\Eloquent\Model;

class LaporanAsetProduktif extends Model
{
    protected $table = 'laporan_aset_produktif';
    protected $fillable = ['pos', 'l', 'dpk', 'kl','d','m', 'jumlah', 'header_import_id', 'sandi_bpr', 'tahun', 'bulan'];

    public function scopeFilterDelete($query)
    {
        $query->where('pos', null)->where('pos', 'pos');
    }

    public function scopeDeleteFilter($query)
    {
        $query->where('pos', 'Ribuan Rp.')->Orwhere('pos', 'Pos');
    }

    public function scopeDeleteJalan($query)
    {
        $query->where('pos', 'like', 'Jl%')->orWhere('pos', 'like', 'Jalan %');
    }

    public function scopeNilaiKap($query, $param)
    {
        return $query->where('sandi_bpr', $param['sandi_bpr'])
        ->where('tahun', $param['tahun'])
        ->where('bulan', $param['bulan']);
    }

    public static function max_tahun($req)
    {
        return LaporanAsetProduktif::where('sandi_bpr', $req['sandi_bpr'])->max('tahun') ?? '';
    }

    public static function max_bulan($req)
    {
        return LaporanAsetProduktif::where('sandi_bpr', $req['sandi_bpr'])->where('tahun', $req['tahun'])->max('bulan') ?? '';
    }
    
    public static function report_bulanan($sandi_bpr, $tahun, $bulan)
    {
        return DB::table('laporan_aset_produktif')->where(['bulan'=>$bulan, 'tahun'=>$tahun, 'sandi_bpr'=>$sandi_bpr])->get();
    }
}
