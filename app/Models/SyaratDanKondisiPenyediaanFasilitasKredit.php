<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SyaratDanKondisiPenyediaanFasilitasKredit extends Model
{
    protected $table = 'syarat_dan_kondisi_penyediaan_fasilitas_kredit';
    protected $fillable = [
        'loan_applicant_id',
        'pertanyaan_id',
        'pelaksana',
        'sifat_frekuensi_target_waktu',
        'keterangan'
    ];
}
