<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InfoGrupUsaha extends Model
{
    protected $table = 'info_grup_usaha';
    protected $fillable = ['sandi_bpr', 'nama_perusahaan', 'bidang_usaha', 'tahun_pendirian'];
}
