<?php

namespace App\Models;
use DB;
use Illuminate\Database\Eloquent\Model;

class InputProfil extends Model
{
    protected $table = 'input_profil';
    protected $fillable = ['jumlah_peminjam', 'jumlah_nasabah_simpanan', 'sandi_bpr', 'bulan', 'tahun'];

    public static function spreadSheet($req)
    {
        $input_profil = DB::table('input_profil')
        ->where('sandi_bpr', $req['sandi_bpr'])
        ->where('bulan', $req['bulan'])
        ->where('tahun', $req['tahun'])
        ->first();

        return $input_profil;
    }

    public static function cariBulanMax($req)
    {
        $tahun = $req['tahun'];
        $query = InputProfil::when($tahun, function($query, $tahun){
            $query->where('tahun', $tahun);
        })
        ->where('sandi_bpr', $req['sandi_bpr'])
        ->max('bulan');

        return $query;
    }

    public static function max_tahun($req)
    {
        return InputProfil::where('sandi_bpr', $req['sandi_bpr'])->max('tahun');
    }

    public static function max_bulan($req)
    {
        return InputProfil::where('sandi_bpr', $req['sandi_bpr'])->where('tahun', $req['tahun'])->max('bulan');
    }
}
