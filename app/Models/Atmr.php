<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Atmr extends Model
{
    protected $table = 'atmr';
    protected $fillable = ['sandi_bpr', 'bulan', 'tahun', 'keterangan', 'nominal', 'persen'];
}
