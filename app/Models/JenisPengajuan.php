<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class JenisPengajuan extends Model
{
    protected $table = 'jenis_pengajuan';
    protected $fillable = ['kode_pengajuan', 'nama_pengajuan', 'publish'];
}
