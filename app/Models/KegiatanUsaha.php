<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KegiatanUsaha extends Model
{
    protected $table = 'kegiatan_usaha';
    protected $fillable = ['keterangan', 'sandi_bpr', 'loan_applicant_id'];
}
