<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kepatuhan extends Model
{
    protected $table = 'kepatuhan';
    protected $fillable = ['sandi_bpr', 'keterangan', 'loan_applicant_id'];
}
