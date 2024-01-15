<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatusNak extends Model
{
    protected $table = 'status_nak';
    protected $fillable = [
        'header',
        'informasi_debitur',
        'permohonan_debitur',
        'fasilitas_debitur',
        'informasi_grup_usaha',
        'financial_highlight',
        'kondisi_keuangan_debitur',
        'prospek_dan_kinerja_usaha',
        'kegiatan_usaha',
        'manajemen_perusahaan',
        'pemasaran',
        'perhitungan_kebutuhan_kredit',
        'legalitas',
        'resume_hasil_observasi',
        'agunan',
        'kepatuhan',
        'deviasi',
        'usulan_kredit',
        'disclaimer',
        'loan_applicant_id',
        'slik'
    ];
}
