<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NilaiKomponenTks extends Model
{
    protected $table = 'nilai_komponen_tks';
    protected $fillable = ['sub_komponen', 'nilai_min', 'nilai_max', 'kategori'];
    protected $primaryKey = 'id';

    public static function kategoriCarKpm($kpm)
    {
        $data = NilaiKomponenTks::selectRaw("
        CASE
            WHEN '$kpm' BETWEEN
                (SELECT nilai_min FROM nilai_komponen_tks
                LEFT JOIN komponen_tks ON komponen_tks.id = nilai_komponen_tks.sub_komponen
                WHERE kategori='Sehat' AND komponen_tks.sub_komponen='CAR/KPMM')

                AND

                (SELECT nilai_max FROM nilai_komponen_tks
                LEFT JOIN komponen_tks ON komponen_tks.id = nilai_komponen_tks.sub_komponen
                WHERE kategori='Sehat' AND komponen_tks.sub_komponen='CAR/KPMM')
            THEN 'Sehat'

            WHEN '$kpm' BETWEEN
                (SELECT nilai_min FROM nilai_komponen_tks
                LEFT JOIN komponen_tks ON komponen_tks.id = nilai_komponen_tks.sub_komponen
                WHERE kategori='Cukup Sehat' AND komponen_tks.sub_komponen='CAR/KPMM')

                AND

                (SELECT nilai_max FROM nilai_komponen_tks
                LEFT JOIN komponen_tks ON komponen_tks.id = nilai_komponen_tks.sub_komponen
                WHERE kategori='Cukup Sehat' AND komponen_tks.sub_komponen='CAR/KPMM')
            THEN 'Cukup Sehat'

            WHEN '$kpm' BETWEEN
                (SELECT nilai_min FROM nilai_komponen_tks
                LEFT JOIN komponen_tks ON komponen_tks.id = nilai_komponen_tks.sub_komponen
                WHERE kategori='Kurang Sehat' AND komponen_tks.sub_komponen='CAR/KPMM')

                AND
                (SELECT nilai_max FROM nilai_komponen_tks
                LEFT JOIN komponen_tks ON komponen_tks.id = nilai_komponen_tks.sub_komponen
                WHERE kategori='Kurang Sehat' AND komponen_tks.sub_komponen='CAR/KPMM')
                THEN 'Kurang Sehat'

            WHEN '$kpm' BETWEEN
                (SELECT nilai_min FROM nilai_komponen_tks
                LEFT JOIN komponen_tks ON komponen_tks.id = nilai_komponen_tks.sub_komponen
                WHERE kategori='Tidak Sehat' AND komponen_tks.sub_komponen='CAR/KPMM')

                AND

                (SELECT nilai_max FROM nilai_komponen_tks
                LEFT JOIN komponen_tks ON komponen_tks.id = nilai_komponen_tks.sub_komponen
                WHERE kategori='Tidak Sehat' AND komponen_tks.sub_komponen='CAR/KPMM')
            THEN 'Tidak Sehat'

        END AS kategori")
       ->leftJoin('komponen_tks', 'komponen_tks.id', 'nilai_komponen_tks.sub_komponen')
       ->where('komponen_tks.sub_komponen',  'CAR/KPMM')
       ->first();

       return $data ?? '';
    }

    public static function kategoriKap($kap)
    {
        $data = NilaiKomponenTks::selectRaw("
        CASE
            WHEN '$kap' BETWEEN
                (SELECT nilai_min FROM nilai_komponen_tks
                LEFT JOIN komponen_tks ON komponen_tks.id = nilai_komponen_tks.sub_komponen
                WHERE kategori='Sehat' AND komponen_tks.sub_komponen='KAP')

                AND

                (SELECT nilai_max FROM nilai_komponen_tks
                LEFT JOIN komponen_tks ON komponen_tks.id = nilai_komponen_tks.sub_komponen
                WHERE kategori='Sehat' AND komponen_tks.sub_komponen='KAP')
            THEN 'Sehat'

            WHEN '$kap' BETWEEN
                (SELECT nilai_min FROM nilai_komponen_tks
                LEFT JOIN komponen_tks ON komponen_tks.id = nilai_komponen_tks.sub_komponen
                WHERE kategori='Cukup Sehat' AND komponen_tks.sub_komponen='KAP')

                AND

                (SELECT nilai_max FROM nilai_komponen_tks
                LEFT JOIN komponen_tks ON komponen_tks.id = nilai_komponen_tks.sub_komponen
                WHERE kategori='Cukup Sehat' AND komponen_tks.sub_komponen='KAP')
            THEN 'Cukup Sehat'

            WHEN '$kap' BETWEEN
                (SELECT nilai_min FROM nilai_komponen_tks
                LEFT JOIN komponen_tks ON komponen_tks.id = nilai_komponen_tks.sub_komponen
                WHERE kategori='Kurang Sehat' AND komponen_tks.sub_komponen='KAP')

                AND
                (SELECT nilai_max FROM nilai_komponen_tks
                LEFT JOIN komponen_tks ON komponen_tks.id = nilai_komponen_tks.sub_komponen
                WHERE kategori='Kurang Sehat' AND komponen_tks.sub_komponen='KAP')
                THEN 'Kurang Sehat'

            WHEN '$kap' BETWEEN
                (SELECT nilai_min FROM nilai_komponen_tks
                LEFT JOIN komponen_tks ON komponen_tks.id = nilai_komponen_tks.sub_komponen
                WHERE kategori='Tidak Sehat' AND komponen_tks.sub_komponen='KAP')

                AND

                (SELECT nilai_max FROM nilai_komponen_tks
                LEFT JOIN komponen_tks ON komponen_tks.id = nilai_komponen_tks.sub_komponen
                WHERE kategori='Tidak Sehat' AND komponen_tks.sub_komponen='KAP')
            THEN 'Tidak Sehat'

        END AS kategori")
        ->leftJoin('komponen_tks', 'komponen_tks.id', 'nilai_komponen_tks.sub_komponen')
        ->where('komponen_tks.sub_komponen',  'KAP')
        ->first();

        return $data ?? '';
    }

    public static function kategoriPpap($ppap)
    {
        $data = NilaiKomponenTks::selectRaw("CASE
        WHEN '$ppap' BETWEEN
            (SELECT nilai_min FROM nilai_komponen_tks
            LEFT JOIN komponen_tks ON komponen_tks.id = nilai_komponen_tks.sub_komponen
            WHERE kategori='Sehat' AND komponen_tks.sub_komponen='PPAP')

            AND

            (SELECT nilai_max FROM nilai_komponen_tks
            LEFT JOIN komponen_tks ON komponen_tks.id = nilai_komponen_tks.sub_komponen
            WHERE kategori='Sehat' AND komponen_tks.sub_komponen='PPAP')
        THEN 'Sehat'

        WHEN '$ppap' BETWEEN
            (SELECT nilai_min FROM nilai_komponen_tks
            LEFT JOIN komponen_tks ON komponen_tks.id = nilai_komponen_tks.sub_komponen
            WHERE kategori='Cukup Sehat' AND komponen_tks.sub_komponen='PPAP')

            AND

            (SELECT nilai_max FROM nilai_komponen_tks
            LEFT JOIN komponen_tks ON komponen_tks.id = nilai_komponen_tks.sub_komponen
            WHERE kategori='Cukup Sehat' AND komponen_tks.sub_komponen='PPAP')
        THEN 'Cukup Sehat'

        WHEN '$ppap' BETWEEN
            (SELECT nilai_min FROM nilai_komponen_tks
            LEFT JOIN komponen_tks ON komponen_tks.id = nilai_komponen_tks.sub_komponen
            WHERE kategori='Kurang Sehat' AND komponen_tks.sub_komponen='PPAP')

            AND
            (SELECT nilai_max FROM nilai_komponen_tks
            LEFT JOIN komponen_tks ON komponen_tks.id = nilai_komponen_tks.sub_komponen
            WHERE kategori='Kurang Sehat' AND komponen_tks.sub_komponen='PPAP')
            THEN 'Kurang Sehat'

        WHEN '$ppap' BETWEEN
            (SELECT nilai_min FROM nilai_komponen_tks
            LEFT JOIN komponen_tks ON komponen_tks.id = nilai_komponen_tks.sub_komponen
            WHERE kategori='Tidak Sehat' AND komponen_tks.sub_komponen='PPAP')

            AND

            (SELECT nilai_max FROM nilai_komponen_tks
            LEFT JOIN komponen_tks ON komponen_tks.id = nilai_komponen_tks.sub_komponen
            WHERE kategori='Tidak Sehat' AND komponen_tks.sub_komponen='PPAP')
        THEN 'Tidak Sehat'

        END AS kategori ")
        ->leftJoin('komponen_tks', 'komponen_tks.id', 'nilai_komponen_tks.sub_komponen')
        ->where('komponen_tks.sub_komponen',  'PPAP')
        ->first();

        return $data ?? '';
    }

    public static function kategoriManajemenUmum($manajemen_umum)
    {
        $data = NilaiKomponenTks::selectRaw("CASE
        WHEN '$manajemen_umum' BETWEEN 81 AND 100 THEN 'Sehat'
        WHEN '$manajemen_umum' BETWEEN 66 AND 80 THEN 'Cukup Sehat'
        WHEN '$manajemen_umum' BETWEEN 51 AND 65.99 THEN 'Kurang Sehat'
        WHEN '$manajemen_umum' BETWEEN 0 AND 50.99 THEN 'Tidak Sehat'  END AS kategori ")
        ->leftJoin('komponen_tks', 'komponen_tks.id', 'nilai_komponen_tks.sub_komponen')
        ->where('komponen_tks.sub_komponen',  'MANAGEMENT UMUM')
        ->orWhere('komponen_tks.sub_komponen', 'Manajemen Umum')
        ->first();

        return $data ?? '';
    }

    public static function kategoriManajemenRisiko($manajemen_risiko)
    {
        $data = NilaiKomponenTks::selectRaw("CASE
        WHEN '$manajemen_risiko' BETWEEN 81 AND 100 THEN 'Sehat'
        WHEN '$manajemen_risiko' BETWEEN 66 AND 80 THEN 'Cukup Sehat'
        WHEN '$manajemen_risiko' BETWEEN 51 AND 65.99 THEN 'Kurang Sehat'
        WHEN '$manajemen_risiko' BETWEEN 0 AND 50.99 THEN 'Tidak Sehat'  END AS kategori ")
        ->leftJoin('komponen_tks', 'komponen_tks.id', 'nilai_komponen_tks.sub_komponen')
        ->where('komponen_tks.sub_komponen',  'MANAGEMENT RISIKO')
        ->orWhere('komponen_tks.sub_komponen', 'Manajemen Risiko')
        ->first();

        return $data ?? '';
    }

    public static function kategoriRoa($roa)
    {
        $data = NilaiKomponenTks::selectRaw("CASE
        WHEN '$roa' BETWEEN
            (SELECT nilai_min FROM nilai_komponen_tks
            LEFT JOIN komponen_tks ON komponen_tks.id = nilai_komponen_tks.sub_komponen
            WHERE kategori='Sehat' AND komponen_tks.sub_komponen='ROA')

            AND

            (SELECT nilai_max FROM nilai_komponen_tks
            LEFT JOIN komponen_tks ON komponen_tks.id = nilai_komponen_tks.sub_komponen
            WHERE kategori='Sehat' AND komponen_tks.sub_komponen='ROA')
        THEN 'Sehat'

        WHEN '$roa' BETWEEN
            (SELECT nilai_min FROM nilai_komponen_tks
            LEFT JOIN komponen_tks ON komponen_tks.id = nilai_komponen_tks.sub_komponen
            WHERE kategori='Cukup Sehat' AND komponen_tks.sub_komponen='ROA')

            AND

            (SELECT nilai_max FROM nilai_komponen_tks
            LEFT JOIN komponen_tks ON komponen_tks.id = nilai_komponen_tks.sub_komponen
            WHERE kategori='Cukup Sehat' AND komponen_tks.sub_komponen='ROA')
        THEN 'Cukup Sehat'

        WHEN '$roa' BETWEEN
            (SELECT nilai_min FROM nilai_komponen_tks
            LEFT JOIN komponen_tks ON komponen_tks.id = nilai_komponen_tks.sub_komponen
            WHERE kategori='Kurang Sehat' AND komponen_tks.sub_komponen='ROA')

            AND
            (SELECT nilai_max FROM nilai_komponen_tks
            LEFT JOIN komponen_tks ON komponen_tks.id = nilai_komponen_tks.sub_komponen
            WHERE kategori='Kurang Sehat' AND komponen_tks.sub_komponen='ROA')
            THEN 'Kurang Sehat'

        WHEN '$roa' BETWEEN
            (SELECT nilai_min FROM nilai_komponen_tks
            LEFT JOIN komponen_tks ON komponen_tks.id = nilai_komponen_tks.sub_komponen
            WHERE kategori='Tidak Sehat' AND komponen_tks.sub_komponen='ROA')

            AND

            (SELECT nilai_max FROM nilai_komponen_tks
            LEFT JOIN komponen_tks ON komponen_tks.id = nilai_komponen_tks.sub_komponen
            WHERE kategori='Tidak Sehat' AND komponen_tks.sub_komponen='ROA')
        THEN 'Tidak Sehat'

        END AS kategori  ")
        ->leftJoin('komponen_tks', 'komponen_tks.id', 'nilai_komponen_tks.sub_komponen')
        ->where('komponen_tks.sub_komponen',  'ROA')
        ->first();

        return $data ?? '';
    }

    public static function kategoriBopo($bopo)
    {
        $data = NilaiKomponenTks::selectRaw("CASE
        WHEN '$bopo' BETWEEN
            (SELECT nilai_min FROM nilai_komponen_tks
            LEFT JOIN komponen_tks ON komponen_tks.id = nilai_komponen_tks.sub_komponen
            WHERE kategori='Sehat' AND komponen_tks.sub_komponen='BOPO')

            AND

            (SELECT nilai_max FROM nilai_komponen_tks
            LEFT JOIN komponen_tks ON komponen_tks.id = nilai_komponen_tks.sub_komponen
            WHERE kategori='Sehat' AND komponen_tks.sub_komponen='BOPO')
        THEN 'Sehat'

        WHEN '$bopo' BETWEEN
            (SELECT nilai_min FROM nilai_komponen_tks
            LEFT JOIN komponen_tks ON komponen_tks.id = nilai_komponen_tks.sub_komponen
            WHERE kategori='Cukup Sehat' AND komponen_tks.sub_komponen='BOPO')

            AND

            (SELECT nilai_max FROM nilai_komponen_tks
            LEFT JOIN komponen_tks ON komponen_tks.id = nilai_komponen_tks.sub_komponen
            WHERE kategori='Cukup Sehat' AND komponen_tks.sub_komponen='BOPO')
        THEN 'Cukup Sehat'

        WHEN '$bopo' BETWEEN
            (SELECT nilai_min FROM nilai_komponen_tks
            LEFT JOIN komponen_tks ON komponen_tks.id = nilai_komponen_tks.sub_komponen
            WHERE kategori='Kurang Sehat' AND komponen_tks.sub_komponen='BOPO')

            AND
            (SELECT nilai_max FROM nilai_komponen_tks
            LEFT JOIN komponen_tks ON komponen_tks.id = nilai_komponen_tks.sub_komponen
            WHERE kategori='Kurang Sehat' AND komponen_tks.sub_komponen='BOPO')
            THEN 'Kurang Sehat'

        WHEN '$bopo' BETWEEN
            (SELECT nilai_min FROM nilai_komponen_tks
            LEFT JOIN komponen_tks ON komponen_tks.id = nilai_komponen_tks.sub_komponen
            WHERE kategori='Tidak Sehat' AND komponen_tks.sub_komponen='BOPO')

            AND

            (SELECT nilai_max FROM nilai_komponen_tks
            LEFT JOIN komponen_tks ON komponen_tks.id = nilai_komponen_tks.sub_komponen
            WHERE kategori='Tidak Sehat' AND komponen_tks.sub_komponen='BOPO')
        THEN 'Tidak Sehat'

        END AS kategori")
        ->leftJoin('komponen_tks', 'komponen_tks.id', 'nilai_komponen_tks.sub_komponen')
        ->where('komponen_tks.sub_komponen',  'BOPO')
        ->first();

        return $data ?? '';
    }

    public static function kategoriCr($cr)
    {
        $data = NilaiKomponenTks::selectRaw("CASE
        WHEN '$cr' BETWEEN
            (SELECT nilai_min FROM nilai_komponen_tks
            LEFT JOIN komponen_tks ON komponen_tks.id = nilai_komponen_tks.sub_komponen
            WHERE kategori='Sehat' AND komponen_tks.sub_komponen='CR')

            AND

            (SELECT nilai_max FROM nilai_komponen_tks
            LEFT JOIN komponen_tks ON komponen_tks.id = nilai_komponen_tks.sub_komponen
            WHERE kategori='Sehat' AND komponen_tks.sub_komponen='CR')
        THEN 'Sehat'

        WHEN '$cr' BETWEEN
            (SELECT nilai_min FROM nilai_komponen_tks
            LEFT JOIN komponen_tks ON komponen_tks.id = nilai_komponen_tks.sub_komponen
            WHERE kategori='Cukup Sehat' AND komponen_tks.sub_komponen='CR')

            AND

            (SELECT nilai_max FROM nilai_komponen_tks
            LEFT JOIN komponen_tks ON komponen_tks.id = nilai_komponen_tks.sub_komponen
            WHERE kategori='Cukup Sehat' AND komponen_tks.sub_komponen='CR')
        THEN 'Cukup Sehat'

        WHEN '$cr' BETWEEN
            (SELECT nilai_min FROM nilai_komponen_tks
            LEFT JOIN komponen_tks ON komponen_tks.id = nilai_komponen_tks.sub_komponen
            WHERE kategori='Kurang Sehat' AND komponen_tks.sub_komponen='CR')

            AND
            (SELECT nilai_max FROM nilai_komponen_tks
            LEFT JOIN komponen_tks ON komponen_tks.id = nilai_komponen_tks.sub_komponen
            WHERE kategori='Kurang Sehat' AND komponen_tks.sub_komponen='CR')
            THEN 'Kurang Sehat'

        WHEN '$cr' BETWEEN
            (SELECT nilai_min FROM nilai_komponen_tks
            LEFT JOIN komponen_tks ON komponen_tks.id = nilai_komponen_tks.sub_komponen
            WHERE kategori='Tidak Sehat' AND komponen_tks.sub_komponen='CR')

            AND

            (SELECT nilai_max FROM nilai_komponen_tks
            LEFT JOIN komponen_tks ON komponen_tks.id = nilai_komponen_tks.sub_komponen
            WHERE kategori='Tidak Sehat' AND komponen_tks.sub_komponen='CR')
        THEN 'Tidak Sehat'

        END AS kategori ")
        ->leftJoin('komponen_tks', 'komponen_tks.id', 'nilai_komponen_tks.sub_komponen')
        ->where('komponen_tks.sub_komponen',  'CR')
        ->first();

        return $data ?? '';
    }

    public static function kategoriLdr($ldr)
    {
        $data = NilaiKomponenTks::selectRaw("CASE
        WHEN '$ldr' BETWEEN
            (SELECT nilai_min FROM nilai_komponen_tks
            LEFT JOIN komponen_tks ON komponen_tks.id = nilai_komponen_tks.sub_komponen
            WHERE kategori='Sehat' AND komponen_tks.sub_komponen='LDR')

            AND

            (SELECT nilai_max FROM nilai_komponen_tks
            LEFT JOIN komponen_tks ON komponen_tks.id = nilai_komponen_tks.sub_komponen
            WHERE kategori='Sehat' AND komponen_tks.sub_komponen='LDR')
        THEN 'Sehat'

        WHEN '$ldr' BETWEEN
            (SELECT nilai_min FROM nilai_komponen_tks
            LEFT JOIN komponen_tks ON komponen_tks.id = nilai_komponen_tks.sub_komponen
            WHERE kategori='Cukup Sehat' AND komponen_tks.sub_komponen='LDR')

            AND

            (SELECT nilai_max FROM nilai_komponen_tks
            LEFT JOIN komponen_tks ON komponen_tks.id = nilai_komponen_tks.sub_komponen
            WHERE kategori='Cukup Sehat' AND komponen_tks.sub_komponen='LDR')
        THEN 'Cukup Sehat'

        WHEN '$ldr' BETWEEN
            (SELECT nilai_min FROM nilai_komponen_tks
            LEFT JOIN komponen_tks ON komponen_tks.id = nilai_komponen_tks.sub_komponen
            WHERE kategori='Kurang Sehat' AND komponen_tks.sub_komponen='LDR')

            AND
            (SELECT nilai_max FROM nilai_komponen_tks
            LEFT JOIN komponen_tks ON komponen_tks.id = nilai_komponen_tks.sub_komponen
            WHERE kategori='Kurang Sehat' AND komponen_tks.sub_komponen='LDR')
            THEN 'Kurang Sehat'

        WHEN '$ldr' BETWEEN
            (SELECT nilai_min FROM nilai_komponen_tks
            LEFT JOIN komponen_tks ON komponen_tks.id = nilai_komponen_tks.sub_komponen
            WHERE kategori='Tidak Sehat' AND komponen_tks.sub_komponen='LDR')

            AND

            (SELECT nilai_max FROM nilai_komponen_tks
            LEFT JOIN komponen_tks ON komponen_tks.id = nilai_komponen_tks.sub_komponen
            WHERE kategori='Tidak Sehat' AND komponen_tks.sub_komponen='LDR')
        THEN 'Tidak Sehat'

        END AS kategori")
        ->leftJoin('komponen_tks', 'komponen_tks.id', 'nilai_komponen_tks.sub_komponen')
        ->where('komponen_tks.sub_komponen',  'LDR')
        ->first();

       return $data ?? '';
    }

    public function komponen()
    {
        return $this->hasOne('App\Models\KomponenTks', 'id', 'sub_komponen');
    }
}
