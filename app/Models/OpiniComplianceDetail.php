<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OpiniComplianceDetail extends Model
{
    protected $table = 'opini_compliance_detail';
    protected $fillable = ['opini_compliance_id', 'pertanyaan_id', 'catatan_rekomendasi_mitigasi', 'identifikasi'];
}
