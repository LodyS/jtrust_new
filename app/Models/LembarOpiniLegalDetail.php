<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LembarOpiniLegalDetail extends Model
{
    protected $table = 'lembar_opini_legal_detail';
    protected $fillable = [
        'legal_opini_id',
        'catatan_rekomendasi_mitigasi',
        'terpenuhi',
        'profil_risiko',
        'pertanyaan_id',
        'sub_judul'
    ];
}
