<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IkhtisarLaporanKeuangan extends Model
{
    protected $table = 'ikhtisar_laporan_keuangan';
    protected $fillable = ['periode', 'kap', 'registered', 'auditor', 'opinion', 'sandi_bpr'];
}
