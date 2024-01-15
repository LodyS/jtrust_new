<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deviasi extends Model
{
    protected $table = 'deviasi';
    protected $fillable = ['sandi_bpr', 'keterangan', 'ketentuan', 'deviasi', 'pertimbangan_dan_mitigasi'];
}
