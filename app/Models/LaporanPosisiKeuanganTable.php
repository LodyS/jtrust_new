<?php

namespace App\Models;
use DB;
use Illuminate\Database\Eloquent\Model;

class LaporanPosisiKeuanganTable extends Model
{
    protected $table = 'laporan_posisi_keuangan_table';
    protected $fillable = ['pos', 'posisi_tanggal_laporan', 'posisi_yang_sama_tahun_sebelumnya', 'header_import_id', 'sandi_bpr', 'sandi_coa', 'bulan', 'tahun'];

    public function header_import()
    {
        return $this->hasOne(HeaderImport::class, 'id', 'header_import_id');
    }

    public static function spreadSheet($req)
    {
        $data = DB::table('laporan_posisi_keuangan_table')
        ->where('bulan', $req['bulan'])
        ->where('sandi_bpr', $req['sandi_bpr'])
        ->where('tahun', $req['tahun'])
        ->get();

        return $data;
    }

    public static function search_one_column($req)
    {
        return LaporanPosisiKeuanganTable::where([
            'bulan'=>$req['bulan'], 
            'sandi_bpr'=>$req['sandi_bpr'], 
            'tahun'=>$req['tahun'], 
            'pos'=>$req['pos']])
        ->value('posisi_tanggal_laporan');
    }

    public static function max_tahun($req)
    {
        return LaporanPosisiKeuanganTable::where('sandi_bpr', $req['sandi_bpr'])->max('tahun');
    }

    public static function max_bulan($req)
    {
        return LaporanPosisiKeuanganTable::where('sandi_bpr', $req['sandi_bpr'])->where('tahun', $req['tahun'])->max('bulan');
    }

    public static function spreadsheet_tiga($req)
    {
        return DB::table('laporan_posisi_keuangan_table')->where('sandi_bpr', $req['sandi_bpr'])->where('bulan', $req['bulan'])->where('tahun', $req['tahun'])->get();
    }

    public function scopeFilterDelete($query)
    {
        $query->where(function($q){
            $q->where('pos', null);
        })
        ->orWhere(function($q){
            $q->where('posisi_tanggal_laporan', null);
        })
        ->orWhere('posisi_tanggal_laporan', 'Ribuan Rp.')
        ->orWhere('posisi_yang_sama_tahun_sebelumnya', null);
    }

    public function scopeDeleteFilter($query)
    {
        $query->where('posisi_tanggal_laporan', 'Ribuan Rp.')->Orwhere('pos', 'Pos');
    }

    public function scopeDeleteJalan($query)
    {
        $query->where('pos', 'like', 'Jl%')->orWhere('pos', 'like', 'Jalan %');
    }

    public static function getPerhitunganPpapWajib($req)
    {
        $data = $req['data'];
         // section satu
        $section_satu = $req['data']->where('sandi_coa', 1104010101)->sum('posisi_tanggal_laporan') * 0.005;
        // section dua
        $kurang_lancar = $req['data']->where('sandi_coa', 1104010103)->sum('posisi_tanggal_laporan');
        $kurang_lancar = ($kurang_lancar - ($kurang_lancar * 0.5)) * 0.1;
        $section_dua = ($kurang_lancar < 0) ? 0 : $kurang_lancar;
        // section tiga
        $diragukan = $req['data']->where('sandi_coa', 1104010104)->sum('posisi_tanggal_laporan');
        $diragukan = ($diragukan - ($diragukan * 0.66)) * 0.5;
        $section_tiga = ($diragukan < 0) ? 0 : $diragukan;
        // section empat
        $macet = $req['data']->where('sandi_coa', 1104010105)->sum('posisi_tanggal_laporan');
        $macet = $macet - ($macet * 0.85);
        // section_empat
        $section_empat = ($macet < 0) ? 0 : $macet + ($req['data']->where('sandi_coa', 1103010000)->sum('posisi_tanggal_laporan') * 0.005);
        // perhitungan PPAP
        $perhitungan_ppap_wajib = $section_satu + $section_dua + $section_tiga + $section_empat;

        return $perhitungan_ppap_wajib;
    }

    public static function getAtmr($req)
    {
        $data = $req['data'];
        $kas_atmr = $data->where('sandi_coa', 1101010000)->sum('posisi_tanggal_laporan') * 0;
        $dua_atmr = $data->where('sandi_coa', 1103010000)->sum('posisi_tanggal_laporan') * 0.2;
        $enam_atmr = $data->where('sandi_coa', 1104010100)->sum('posisi_tanggal_laporan');
        $nilai_buku = $data->where('sandi_coa', 1202010000)->sum('posisi_tanggal_laporan');
        $nilai_buku = $nilai_buku - $data->where('sandi_coa', 1202020000)->sum('posisi_tanggal_laporan');
        $nilai_buku = $nilai_buku+ $data->where('sandi_coa', 1203010000)->sum('posisi_tanggal_laporan');
        $nilai_buku = $nilai_buku - $data->where('sandi_coa', 1203020000)->sum('posisi_tanggal_laporan');
        $aktiva_lainnya = $data->whereIn('sandi_coa', [1103000000,1204000000,1299000000,1201000000])->sum('posisi_tanggal_laporan');
        $atmr = $kas_atmr + $dua_atmr + $enam_atmr + $nilai_buku + $aktiva_lainnya;

        return $atmr;
    }

    public static function getTotalAktiva ($req)
    {
        $data = $req['data'];
        $total_aktiva = $data->whereIn('sandi_coa', [1101010000,1101020000,1102000000])->sum('posisi_tanggal_laporan');
        $total_aktiva = $total_aktiva + $data->whereIn('sandi_coa', [1103000000,1103010000,1104010100])->sum('posisi_tanggal_laporan');
        $total_aktiva = $total_aktiva + $data->whereIn('sandi_coa', [1201000000,1202010000,1203010000,1204000000])->sum('posisi_tanggal_laporan');
        $total_aktiva = $total_aktiva - $data->whereIn('sandi_coa', [1103020000,1104020000,1104010200,1202020000,1203020000])->sum('posisi_tanggal_laporan');
        $total_aktiva = $total_aktiva + $data->where('sandi_coa', 1299000000)->sum('posisi_tanggal_laporan');

        return $total_aktiva;
    }

    public static function getSubTotal ($req)
    {
        $data = $req['data'];
        $sub_total = $data->where('pos', 'Komponen Modal')->sum('posisi_tanggal_laporan');
        $sub_total = $sub_total - $data->where('sandi_coa', 3102020000)->sum('posisi_tanggal_laporan');
        $sub_total = $sub_total + $data->whereIn('sandi_coa', [3102030000,3104010000])->sum('posisi_tanggal_laporan');
        $sub_total = $sub_total + 0; // ditambah laba ditahan
        $sub_total = $sub_total + $data->whereIn('sandi_coa', [3105010000])->sum('posisi_tanggal_laporan');
        $sub_total = $sub_total - $data->where('sandi_coa', 3105010100)->sum('posisi_tanggal_laporan');
        $sub_total = $sub_total + ($data->where('sandi_coa', 3105020000)->sum('posisi_tanggal_laporan')/2);
        $sub_total = $sub_total - ($data->where('sandi_coa', 3105020100)->sum('posisi_tanggal_laporan')/2);
        $sub_total = $sub_total + $data->where('sandi_coa', 3102010000)->sum('posisi_tanggal_laporan');
        $sub_total = $sub_total - $data->where('sandi_coa', 3102010100)->sum('posisi_tanggal_laporan');
        $sub_total = $sub_total + $data->where('sandi_coa', 3102030000)->sum('posisi_tanggal_laporan');

        return $sub_total;
    }

    public static function getJumlahKewajiban ($req)
    {
        $data = $req['data'];
        $jumlah_kewajiban = $data->whereIn('sandi_coa', [2101000000, 2299010000,2299020000])->sum('posisi_tanggal_laporan');

      	$jumlah_kewajiban = $jumlah_kewajiban + $data->whereIn('sandi_coa', [2102010000,2103010000,2201010000])->sum('posisi_tanggal_laporan');
      	$jumlah_kewajiban = $jumlah_kewajiban + $data->whereIn('sandi_coa', [2202000000,2299030000,2297000000])->sum('posisi_tanggal_laporan');
      	$jumlah_kewajiban = $jumlah_kewajiban + $data->whereIn('sandi_coa', [2298000000,2203000000,2299000000])->sum('posisi_tanggal_laporan');

        return $jumlah_kewajiban;
    }

    public static function getKomponenModal($req)
    {
        $data = $req['data'];
        $komponen_modal = $data->whereIn('sandi_coa', [3101020000, 3102010000,3102020000])->sum('posisi_tanggal_laporan');
        $komponen_modal = $data->where('sandi_coa', 3101010000)->sum('posisi_tanggal_laporan') - $komponen_modal;

        return $komponen_modal;
    }

    public static function getPenyisihanPenghapusanAktiva($req)
    {
        $data = $req['data'];
        $atmr = $req['atmr'];
        $penyisihan_penghapusan_aktiva = $data->where('sandi_coa', 1104020000)->sum('posisi_tanggal_laporan');
        $penyisihan_penghapusan_aktiva = ($atmr * 1.25/100 >  $penyisihan_penghapusan_aktiva) ? $penyisihan_penghapusan_aktiva : ($atmr * 1.25/100);

        return $penyisihan_penghapusan_aktiva;
    }

    public static function getJumlahModalPelengkapYangDipertahankan($req)
    {
        $jumlah_modal_inti = $req['jumlah_modal_inti'];
        $jumlah_modal_pelengkap = $req['jumlah_modal_pelengkap'];

        if ($jumlah_modal_inti < 0):
            $jumlah_modal_pelengkap_yang_dipertahankan = 0;
        elseif($jumlah_modal_pelengkap <= $jumlah_modal_inti):
            $jumlah_modal_pelengkap_yang_dipertahankan = $jumlah_modal_pelengkap;
        else:
            $jumlah_modal_pelengkap_yang_dipertahankan = $jumlah_modal_inti;
        endif;

        return $jumlah_modal_pelengkap_yang_dipertahankan;
    }

    public static function getLabaTahunBerjalan($req)
    {
        $data = $req['data'];

        if ($data->where('sandi_coa', 3105020000)->sum('posisi_tanggal_laporan') < 0):
            $laba_tahun_berjalan =0;
        else:
            $laba_tahun_berjalan = $data->where('sandi_coa', 3105020000)->sum('posisi_tanggal_laporan') * 0.5;
        endif;

        return $laba_tahun_berjalan;
    }

    public static function getRugiTahunBerjalan($req)
    {
        $data = $req['data'];
        if ($data->where('sandi_coa', 3105020001)->sum('posisi_tanggal_laporan') < 0):
            $rugi_tahun_berjalan = 0;
        else:
            $rugi_tahun_berjalan = $data->where('sandi_coa', 3105020001)->sum('posisi_tanggal_laporan');
        endif;

        return $rugi_tahun_berjalan;
    }

    public static function report($req)
    {
        $sandi_bpr = $req['sandi_bpr'];
        $tahun = $req['tahun'];
        $tahun_sebelumnya = $req['tahun_sebelumnya'];

        $data = DB::select("
        SELECT DISTINCT A.pos,
        COALESCE(januari_a.februari,0) as januari,
        COALESCE(januari_b.februari,0) as januari_tahun_lalu,

        COALESCE(februari_a.februari,0) as februari,
        COALESCE(februari_b.februari,0) as februari_tahun_lalu,

        COALESCE(B.maret,0) AS maret,
        COALESCE(BB.maret,0) AS maret_tahun_lalu,

        COALESCE(april_a.april,0) AS april,
        COALESCE(april_b.april,0) AS april_tahun_lalu,

        COALESCE(mei_a.mei,0) AS mei,
        COALESCE(mei_b.mei,0) AS mei_tahun_lalu,

        COALESCE(C.juni,0) AS juni,
        COALESCE(CC.juni,0) AS juni_tahun_lalu,

        COALESCE(juli_a.juli,0) AS juli,
        COALESCE(juli_b.juli,0) AS juli_tahun_lalu,

        COALESCE(agustus_a.agustus,0) AS agustus,
        COALESCE(agustus_b.agustus,0) AS agustus_tahun_lalu,

        COALESCE(D.september,0) AS september,
        COALESCE(DD.september,0) AS september_tahun_lalu,

        COALESCE(oktober_a.oktober,0) AS oktober,
        COALESCE(oktober_b.oktober,0) AS oktober_tahun_lalu,

        COALESCE(november_a.november,0) AS november,
        COALESCE(november_b.november,0) AS november_tahun_lalu,

        COALESCE(E.desember,0) AS desember,
        COALESCE(EE.desember,0) AS desember_tahun_lalu

        FROM (SELECT DISTINCT pos FROM laporan_posisi_keuangan_table) A

        LEFT JOIN
        (SELECT pos, posisi_tanggal_laporan AS februari, posisi_yang_sama_tahun_sebelumnya AS maret_tahun_lalu
        FROM laporan_posisi_keuangan_table WHERE bulan='1' AND tahun='$tahun' AND sandi_bpr='$sandi_bpr') januari_a ON januari_a.pos = A.pos

        LEFT JOIN
        (SELECT pos, posisi_tanggal_laporan AS februari FROM laporan_posisi_keuangan_table   
        WHERE bulan='1' AND tahun='$tahun_sebelumnya' AND sandi_bpr='$sandi_bpr') januari_b ON januari_b.pos = A.pos

        LEFT JOIN
        (SELECT pos, posisi_tanggal_laporan AS februari, posisi_yang_sama_tahun_sebelumnya AS maret_tahun_lalu
        FROM laporan_posisi_keuangan_table WHERE bulan='2' AND tahun='$tahun' AND sandi_bpr='$sandi_bpr') februari_a ON februari_a.pos = A.pos

        LEFT JOIN
        (SELECT pos, posisi_tanggal_laporan AS februari FROM laporan_posisi_keuangan_table       
        WHERE bulan='2' AND tahun='$tahun_sebelumnya' AND sandi_bpr='$sandi_bpr') februari_b ON februari_b.pos = A.pos

        LEFT JOIN
        (SELECT pos, posisi_tanggal_laporan AS maret, posisi_yang_sama_tahun_sebelumnya AS maret_tahun_lalu FROM laporan_posisi_keuangan_table       
        WHERE bulan='3' AND tahun='$tahun' AND sandi_bpr='$sandi_bpr') B ON B.pos = A.pos

        LEFT JOIN
        (SELECT pos, posisi_tanggal_laporan AS maret FROM laporan_posisi_keuangan_table       
        WHERE bulan='3' AND tahun='$tahun_sebelumnya' AND sandi_bpr='$sandi_bpr') BB ON BB.pos = A.pos

        LEFT JOIN
        (SELECT pos, posisi_tanggal_laporan AS april, posisi_yang_sama_tahun_sebelumnya AS maret_tahun_lalu FROM laporan_posisi_keuangan_table       
        WHERE bulan='4' AND tahun='$tahun' AND sandi_bpr='$sandi_bpr') april_a ON april_a.pos = A.pos

        LEFT JOIN
        (SELECT pos, posisi_tanggal_laporan AS april FROM laporan_posisi_keuangan_table       
        WHERE bulan='4' AND tahun='$tahun_sebelumnya' AND sandi_bpr='$sandi_bpr') april_b ON april_b.pos = A.pos

        LEFT JOIN
        (SELECT pos, posisi_tanggal_laporan AS mei, posisi_yang_sama_tahun_sebelumnya AS maret_tahun_lalu FROM laporan_posisi_keuangan_table       
        WHERE bulan='5' AND tahun='$tahun' AND sandi_bpr='$sandi_bpr') mei_a ON mei_a.pos = A.pos

        LEFT JOIN
        (SELECT pos, posisi_tanggal_laporan AS mei FROM laporan_posisi_keuangan_table       
        WHERE bulan='5' AND tahun='$tahun_sebelumnya' AND sandi_bpr='$sandi_bpr') mei_b ON mei_b.pos = A.pos

        LEFT JOIN
        (SELECT pos, posisi_tanggal_laporan AS juni FROM laporan_posisi_keuangan_table       
        WHERE bulan='6' AND tahun='$tahun' AND sandi_bpr='$sandi_bpr') C ON C.pos = A.pos

        LEFT JOIN
        (SELECT pos, posisi_tanggal_laporan AS juni FROM laporan_posisi_keuangan_table       
        WHERE bulan='6' AND tahun='$tahun_sebelumnya' AND sandi_bpr='$sandi_bpr') CC ON CC.pos = A.pos

        LEFT JOIN
        (SELECT pos, posisi_tanggal_laporan AS juli FROM laporan_posisi_keuangan_table           
        WHERE bulan='7' AND tahun='$tahun' AND sandi_bpr='$sandi_bpr') juli_a ON juli_a.pos = A.pos

        LEFT JOIN
        (SELECT pos, posisi_tanggal_laporan AS juli FROM laporan_posisi_keuangan_table           
        WHERE bulan='7' AND tahun='$tahun_sebelumnya' AND sandi_bpr='$sandi_bpr') juli_b ON juli_b.pos = A.pos

        LEFT JOIN
        (SELECT pos, posisi_tanggal_laporan AS agustus FROM laporan_posisi_keuangan_table               
        WHERE bulan='8' AND tahun='$tahun' AND sandi_bpr='$sandi_bpr') agustus_a ON agustus_a.pos = A.pos

        LEFT JOIN
        (SELECT pos, posisi_tanggal_laporan AS agustus FROM laporan_posisi_keuangan_table               
        WHERE bulan='8' AND tahun='$tahun_sebelumnya' AND sandi_bpr='$sandi_bpr') agustus_b ON agustus_b.pos = A.pos

        LEFT JOIN
        (SELECT pos, posisi_tanggal_laporan AS september FROM laporan_posisi_keuangan_table       
        WHERE bulan='9' AND tahun='$tahun' AND sandi_bpr='$sandi_bpr') D ON D.pos = A.pos

        LEFT JOIN
        (SELECT pos, posisi_tanggal_laporan AS september FROM laporan_posisi_keuangan_table       
        WHERE bulan='9' AND tahun='$tahun_sebelumnya' AND sandi_bpr='$sandi_bpr') DD ON DD.pos = A.pos

        LEFT JOIN
        (SELECT pos, posisi_tanggal_laporan AS oktober FROM laporan_posisi_keuangan_table           
        WHERE bulan='10' AND tahun='$tahun' AND sandi_bpr='$sandi_bpr') oktober_a ON oktober_a.pos = A.pos

        LEFT JOIN
        (SELECT pos, posisi_tanggal_laporan AS oktober FROM laporan_posisi_keuangan_table           
        WHERE bulan='10' AND tahun='$tahun_sebelumnya' AND sandi_bpr='$sandi_bpr') oktober_b ON oktober_b.pos = A.pos

        LEFT JOIN
        (SELECT pos, posisi_tanggal_laporan AS november FROM laporan_posisi_keuangan_table               
        WHERE bulan='11' AND tahun='$tahun' AND sandi_bpr='$sandi_bpr') november_a ON november_a.pos = A.pos

        LEFT JOIN
        (SELECT pos, posisi_tanggal_laporan AS november FROM laporan_posisi_keuangan_table           
        WHERE bulan='11' AND tahun='$tahun_sebelumnya' AND sandi_bpr='$sandi_bpr') november_b ON november_b.pos = A.pos

        LEFT JOIN
        (SELECT pos, posisi_tanggal_laporan AS desember FROM laporan_posisi_keuangan_table   
        WHERE bulan='12' AND tahun='$tahun' AND sandi_bpr='$sandi_bpr') E ON E.pos = A.pos

        LEFT JOIN
        (SELECT pos, posisi_tanggal_laporan AS desember FROM laporan_posisi_keuangan_table
        WHERE bulan='12' AND tahun='$tahun_sebelumnya' AND sandi_bpr='$sandi_bpr') EE ON EE.pos = A.pos");

        return $data;
    }
}
