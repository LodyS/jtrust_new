<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResumeHasilObservasi extends Model
{
    protected $table = 'resume_hasil_observasi';
    protected $fillable = ['sandi_bpr', 'keterangan', 'loan_applicant_id'];
}
