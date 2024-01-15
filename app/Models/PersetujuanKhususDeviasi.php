<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersetujuanKhususDeviasi extends Model
{
    protected $table = 'persetujuan_khusus_deviasi';
    protected $fillable = ['loan_applicant_id', 'keterangan'];
}
