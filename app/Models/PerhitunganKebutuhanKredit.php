<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PerhitunganKebutuhanKredit extends Model
{
    protected $table = 'perhitungan_kebutuhan_kredit';
    protected $fillable = ['sandi_bpr', 'keterangan', 'perhitungan_limit_executing', 'pembiayaan_yang_dapat_diberikan', 'loan_applicant_id'];
}
