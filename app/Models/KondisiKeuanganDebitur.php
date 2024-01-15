<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KondisiKeuanganDebitur extends Model
{
    protected $table= 'kondisi_keuangan_debitur';
    protected $fillable = ['keterangan', 'sandi_bpr', 'loan_applicant_id'];
}
