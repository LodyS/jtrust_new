<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PredikatTks extends Model
{
    protected $table = 'predikat_tks';
    protected $fillable = ['predikat', 'nilai_min', 'nilai_max'];
    protected $primaryKey = 'id';

    public static function statusTks ($total)
    {
        $data = PredikatTks::selectRaw("CASE
            WHEN $total BETWEEN
            (SELECT nilai_min FROM predikat_tks WHERE predikat='Sehat' limit 1)
            AND
            (SELECT nilai_max FROM predikat_tks WHERE predikat='Sehat' limit 1)
            THEN 'Sehat'

            WHEN $total BETWEEN
            (SELECT nilai_min FROM predikat_tks WHERE predikat='Cukup Sehat' limit 1)
            AND
            (SELECT nilai_max FROM predikat_tks WHERE predikat='Cukup Sehat' limit 1)
            THEN 'Cukup Sehat'

            WHEN $total BETWEEN
            (SELECT nilai_min FROM predikat_tks WHERE predikat='Kurang Sehat' limit 1)
            AND
            (SELECT nilai_max FROM predikat_tks WHERE predikat='Kurang Sehat' limit 1)
            THEN 'Kurang Sehat'

            WHEN $total BETWEEN
            (SELECT nilai_min FROM predikat_tks WHERE predikat='Tidak Sehat' limit 1)
            AND
            (SELECT nilai_max FROM predikat_tks WHERE predikat='Tidak Sehat' limit 1)
            THEN 'Tidak Sehat'

        END AS status")->first();

        return $data;
    }
}
