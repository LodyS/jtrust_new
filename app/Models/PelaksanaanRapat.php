<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PelaksanaanRapat extends Model
{
    protected $table = 'pelaksanaan_rapat';
    protected $fillable = [
        'tanggal',
        'ruang_alamat',
        'waktu_rapat',
        'loan_applicant_id'
    ];
}
