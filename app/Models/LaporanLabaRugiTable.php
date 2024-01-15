<?php

namespace App\Models;
use DB;
use Illuminate\Database\Eloquent\Model;

class LaporanLabaRugiTable extends Model
{
    protected $table = 'laporan_laba_rugi_table';
    protected $fillable = ['pos', 'posisi_tanggal_laporan', 'posisi_yang_sama_tahun_sebelumnya', 'header_import_id', 'bulan', 'tahun'];

    public function scopeFilterDelete($query)
    {
        $query->where('pos', null)
        ->orWhere('pos', '')
        ->orWhere(function($q){
            $q->where('posisi_tanggal_laporan', null);
        })
        ->orWhere('posisi_tanggal_laporan', 'Ribuan Rp.')
        ->orWhere('posisi_yang_sama_tahun_sebelumnya', null);
    }

    public static function spreadsheet($req)
    {
        $laba_rugi = DB::table('laporan_laba_rugi_table')
        ->where([
            'bulan'=>$req['bulan'],
            'sandi_bpr'=>$req['sandi_bpr'],
            'tahun'=>$req['tahun']
        ])
        ->get();

        return $laba_rugi;
    }

    public static function max_tahun($req)
    {
        return LaporanLabaRugiTable::where('sandi_bpr', $req['sandi_bpr'])->max('tahun');
    }

    public static function max_bulan($req)
    {
        return LaporanLabaRugiTable::where('sandi_bpr', $req['sandi_bpr'])->where('tahun', $req['tahun'])->max('bulan');
    }

    public static function spreadsheet_tiga($req)
    {
        return DB::table('laporan_laba_rugi_table')->where(['sandi_bpr'=>$req['sandi_bpr'], 'bulan'=>$req['bulan'], 'tahun'=>$req['tahun']])->get();
    }

    public function scopeDeleteFilter($query)
    {
        $query->where('posisi_tanggal_laporan', 'Ribuan Rp.')->Orwhere('pos', 'Pos');
    }

    public function scopeDeleteJalan($query)
    {
        $query->where('pos', 'like', 'Jl%')->orWhere('pos', 'like', 'Jalan %');
    }

    public static function getBebanOperasionalNonBunga ($req)
    {
        $laba_rugi = $req['laba_rugi'];
        $beban_operasional_non_bunga = $laba_rugi->whereIn('sandi_coa', [5102000000,5103000000,5104000000])->sum('posisi_tanggal_laporan');
        $beban_operasional_non_bunga = $beban_operasional_non_bunga + $laba_rugi->whereIn('sandi_coa', [5105000000,5106000000,5199000000])->sum('posisi_tanggal_laporan');

        return $beban_operasional_non_bunga;
    }

    public static function getBebanBunga ($req)
    {
        $laba_rugi = $req['laba_rugi'];
        $beban_bunga = $laba_rugi->whereIn('sandi_coa', [5101010000, 5101020000])->sum('posisi_tanggal_laporan');
        $beban_bunga = $beban_bunga + $laba_rugi->where('pos', 'c. Koreksi atas pendapatan bunga')->sum('posisi_tanggal_laporan');

        return $beban_bunga;
    }

    public static function getLabaRugiSebelumPajak($req)
    {
        $laba_rugi = $req['laba_rugi'];
        $laba_rugi_operasional = $req['laba_rugi_operasional'];
        $laba_rugi_sebelum_pajak = $laba_rugi_operasional + $laba_rugi->where('sandi_coa', 4200000000)->sum('posisi_tanggal_laporan');
        $laba_rugi_sebelum_pajak = $laba_rugi_sebelum_pajak - $laba_rugi->where('sandi_coa', 5200000000)->sum('posisi_tanggal_laporan');
        return $laba_rugi_sebelum_pajak;
    }

    public static function getSubTotalBebanBunga($req)
    {
        $laba_rugi = $req['laba_rugi'];
        $sub_total_beban_bunga = $laba_rugi->whereIn('sandi_coa', [5101010000,5101020000])->sum('posisi_tanggal_laporan');
        $sub_total_beban_bunga = $sub_total_beban_bunga + $laba_rugi->where('pos', 'c. Koreksi atas pendapatan bunga')->sum('posisi_tanggal_laporan');

        return $sub_total_beban_bunga;
    }

    public static function getSubTotalBebanBungaOperasional($req)
    {
        $laba_rugi = $req['laba_rugi'];
        $sub_total_beban_bunga = $req['sub_total_beban_bunga'];
        $sub_total_beban_operasional = $sub_total_beban_bunga + $laba_rugi->whereIn('sandi_coa', [5102000000,5103000000,5104000000])->sum('posisi_tanggal_laporan');
        $sub_total_beban_operasional = $sub_total_beban_operasional + $laba_rugi->whereIn('sandi_coa', [5105000000,5106000000,5199000000])->sum('posisi_tanggal_laporan');

        return $sub_total_beban_operasional;
    }
}
