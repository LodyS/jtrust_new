<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Legalitas extends Model
{
    protected $table = 'legalitas';
    protected $fillable = ['sandi_bpr', 'keterangan', 'loan_applicant_id'];
}
