<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ManajemenPertanyaan extends Model
{
    protected $table = 'manajemen_pertanyaan';
    protected $primaryKey = 'id';
    protected $fillable = [
        'kelompok_pertanyaan',
        'sub_kelompok_pertanyaan',
        'detail_pertanyaan',
        'range_skor_minimal',
        'range_skor_maksimal'
    ];
}
