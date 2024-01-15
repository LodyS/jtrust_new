<?php

namespace App\Models;
use DB;
use Illuminate\Database\Eloquent\Model;

class HeaderImport extends Model
{
    protected $table = 'header_import';
    protected $fillable = ['jenis_laporan', 'periode_waktu', 'tahun', 'sandi_bpr', 'nama_bpr', 'status_excel'];

    public function scopeCheckLaporanAsetProduktif ($query, $req)
    {
        return $query->where('sandi_bpr', $req['sandi_bpr'])
        ->where('nama_bpr', $req['nama_bpr'])
        ->where('tahun', $req['tahun'])
        ->where('periode_waktu', $req['periode_waktu'])
        ->where('jenis_laporan', 'Laporan Aset Produktif');
    }

    public function scopeCheckLaporanLabaRugi ($query, $req)
    {
        return $query->where('sandi_bpr', $req['sandi_bpr'])
        ->where('nama_bpr', $req['nama_bpr'])
        ->where('tahun', $req['tahun'])
        ->where('periode_waktu', $req['periode_waktu'])
        ->where('jenis_laporan', 'Laporan Laba Rugi');
    }

    public function scopeCheckLaporanPosisiKeuangan ($query, $req)
    {
        return $query->where('sandi_bpr', $req['sandi_bpr'])
        ->where('nama_bpr', $req['nama_bpr'])
        ->where('tahun', $req['tahun'])
        ->where('periode_waktu', $req['periode_waktu'])
        ->where('jenis_laporan', 'Laporan Posisi Keuangan');
    }

    public static function bulanMax($req)
    {
        $tahun = $req['tahun'];
        $jenis_laporan = $req['jenis_laporan'] ?? null;
        $query = HeaderImport::where('tahun', $tahun)
        ->where('sandi_bpr', $req['sandi_bpr'])
        //->where('status_excel', )
        ->when($jenis_laporan, function($query, $jenis_laporan){
            return $query->where('jenis_laporan', $jenis_laporan);
        })
        ->max('periode_waktu');

        return $query;
    }

    public static function bulanMaks($req)
    {
        $tahun = $req['tahun'];
        $jenis_laporan = $req['jenis_laporan'] ?? null;
        $query = HeaderImport::where('tahun', $tahun)
        ->where('sandi_bpr', $req['sandi_bpr'])
        ->where('status_excel', 'N')
        ->when($jenis_laporan, function($query, $jenis_laporan){
            return $query->where('jenis_laporan', $jenis_laporan);
        })
        ->max('periode_waktu');

        return $query;
    }

    public static function tahunMaks($req)
    {
        $jenis_laporan = $req['jenis_laporan'] ?? null;
        $query = HeaderImport::where('sandi_bpr', $req['sandi_bpr'])
        ->where('status_excel', 'N')
        ->when($jenis_laporan, function($query, $jenis_laporan){
            return $query->where('jenis_laporan', $jenis_laporan);
        })
        ->max('tahun');

        return $query;
    }

    public static function id_header($req)
    {
        $tahun = $req['tahun'];
        $jenis_laporan = $req['jenis_laporan'] ?? null;
        $query = HeaderImport::where('tahun', $tahun)
        ->where('sandi_bpr', $req['sandi_bpr'])
        ->where('periode_waktu', $req['bulan'])
        ->where('jenis_laporan', $jenis_laporan)
        ->value('id');

        return $query;
    }

    public static function cariBulanMax($req)
    {
        $tahun = $req['tahun'];
        $jenis_laporan = $req['jenis_laporan'] ?? null;
        $query = DB::table('header_import')->selectRaw("
        MAX(
            CASE
                WHEN periode_waktu = 'Januari' THEN 1
                WHEN periode_waktu = 'Februari' THEN 2
                WHEN periode_waktu = 'Maret' THEN 3
                WHEN periode_waktu = 'April' THEN 4
                WHEN periode_waktu = 'Juni' THEN 6
                WHEN periode_waktu = 'Juli' THEN 7
                WHEN periode_waktu = 'Agustus' THEN 8
                WHEN periode_waktu = 'September' THEN 9
                WHEN periode_waktu = 'Oktober' THEN 10
                WHEN periode_waktu = 'November' THEN 11
                WHEN periode_waktu = 'Desember' THEN 12
            ELSE
            0
            END) AS periode_waktu, nama_bpr, sandi_bpr
        ")
        ->where('tahun', $tahun)
        ->where('sandi_bpr', $req['sandi_bpr'])
        ->when($jenis_laporan, function($query, $jenis_laporan){
            return $query->where('jenis_laporan', $jenis_laporan);
        })
        ->first();

        return $query;
    }
}
