<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiwayatPinjamanGrupUsaha extends Model
{
    protected $table = 'riwayat_pinjaman_grup_usaha';
    protected $fillable = ['sandi_bpr', 'nama_perusahaan', 'plafond', 'informasi_grup_usaha', 'kol', 'fasilitas'];
}
