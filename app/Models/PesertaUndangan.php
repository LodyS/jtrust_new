<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PesertaUndangan extends Model
{
    protected $table = 'peserta_undangan';
    protected $fillable = [
        'nama',
        'jabatan',
        'pelaksanaan_rapat_id'
    ];
}
