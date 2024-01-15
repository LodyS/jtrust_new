<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InformasiGrupUsaha extends Model
{
    protected $table = 'informasi_grup_usaha';
    protected $fillable = ['sandi', 'nama_perusahaan', 'bidang_usaha', 'tahun_pendirian'];
}

// Untuk master awal
