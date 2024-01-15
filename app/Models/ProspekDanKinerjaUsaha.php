<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProspekDanKinerjaUsaha extends Model
{
    protected $table = 'prospek_dan_kinerja_usaha';
    protected $fillable = ['keterangan', 'sandi_bpr', 'loan_applicant_id'];
}
