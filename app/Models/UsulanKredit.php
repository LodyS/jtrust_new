<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsulanKredit extends Model
{
    protected $table = 'usulan_kredit';
    protected $fillable = ['sandi_bpr', 'keterangan', 'loan_applicant_id'];
}
