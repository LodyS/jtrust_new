<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OpiniCadDetail extends Model
{
    protected $table = 'opini_cad_details';
    protected $fillable = ['profil_risiko', 'opini_cad_id', 'sub_judul', 'catatan_rekomendasi_mitigasi', 'pertanyaan_id'];
}
