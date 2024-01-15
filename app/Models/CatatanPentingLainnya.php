<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CatatanPentingLainnya extends Model
{
    protected $table = 'catatan_penting_lainnyas';
    protected $fillable = ['loan_applicant_id', 'keterangan'];
}
