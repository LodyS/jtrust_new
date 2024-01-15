<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LampiranCatatanPentingLainnya extends Model
{
    protected $table = 'lampiran_catatan_penting_lainnya';
    protected $fillable = ['loan_applicant_id', 'foto', 'keterangan'];
}
