<?php

namespace App\Models;
use DB;
use Illuminate\Database\Eloquent\Model;

class RekeningAdministratif extends Model
{
    protected $table = 'rekening_administratif';
    protected $fillable = ['pos', 'nominal', 'sandi_coa', 'bulan', 'tahun', 'sandi_bpr'];

    public static function cariBulanMax($req)
    {
        $tahun = $req['tahun'];
        $query = RekeningAdministratif::when($tahun, function($query, $tahun){
            $query->where('tahun', $tahun);
        })
        ->where('sandi_bpr', $req['sandi_bpr'])
        ->max('bulan');

        return $query;
    }

    public static function spreadsheet($req)
    {
        $rekening_administratif = DB::table('rekening_administratif')
        ->where('sandi_bpr', $req['sandi_bpr'])
        ->where('bulan', $req['bulan'])
        ->where('tahun', $req['tahun'])
        ->get();

        return $rekening_administratif;
    }

    public static function max_tahun($req)
    {
        return RekeningAdministratif::where('sandi_bpr', $req['sandi_bpr'])->max('tahun');
    }

    public static function max_bulan($req)
    {
        return RekeningAdministratif::where('sandi_bpr', $req['sandi_bpr'])->where('tahun', $req['tahun'])->max('bulan');
    }
}
