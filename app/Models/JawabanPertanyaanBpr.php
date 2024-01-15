<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JawabanPertanyaanBpr extends Model
{
    protected $table = 'jawaban_pertanyaan_bpr';
    protected $primaryKey = 'id';
    protected $fillable = ['sandi_bpr', 'pertanyaan_id', 'score', 'keterangan', 'user_id', 'review_date_month', 'review_date_year'];

    public function scopeScoreManajemenUmum($query, $param)
    {
        return $query->leftJoin('manajemen_pertanyaan', 'manajemen_pertanyaan.id', 'jawaban_pertanyaan_bpr.pertanyaan_id')
        ->where('sandi_bpr', $param['sandi_bpr'])
        ->where('kelompok_pertanyaan', 'Manajemen Umum')
        ->where('review_date_month', $param['bulan'])
        ->where('review_date_year', $param['tahun'])
        ->sum('score');
    }

    public function scopeScoreManajemenResiko($query, $param)
    {
        return $query->leftJoin('manajemen_pertanyaan', 'manajemen_pertanyaan.id', 'jawaban_pertanyaan_bpr.pertanyaan_id')
        ->where('sandi_bpr', $param['sandi_bpr'])
        ->where('kelompok_pertanyaan', 'Manajemen Risiko')
        ->where('review_date_month', $param['bulan'])
        ->where('review_date_year', $param['tahun'])
        ->sum('score');
    }

    public static function scopeManajemen($query, $param)
    {
        $query = JawabanPertanyaanBpr::selectRaw(
            'jawaban_pertanyaan_bpr.id,
            sandi_bpr,
            score,
            keterangan,
            sub_kelompok_pertanyaan,
            detail_pertanyaan,
            manajemen_pertanyaan.id as pertanyaan_id,
            review_date_year,
            review_date_month,
            kelompok_pertanyaan'
        )
        ->leftJoin('manajemen_pertanyaan', 'manajemen_pertanyaan.id', 'jawaban_pertanyaan_bpr.pertanyaan_id')
        ->where('sandi_bpr', $param['sandi_bpr'])
        ->where('review_date_month', $param['bulan'])
        ->where('review_date_year', $param['tahun']);

        return $query;
    }
}
