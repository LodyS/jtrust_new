<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RekomendasiArr extends Model
{
    protected $table = 'rekomendasi_arr';
    protected $fillable = [
        'sandi_bpr',
        'keterangan',
        // tambahan
        'jenis_fasilitas_kredit',
        'limit_fasilitas_kredit',
        'sifat_fasilitas_kredit',
        'tujuan_penggunaan',
        'jangka_waktu_fasilitas_kredit',
        'jangka_waktu_penarikan_fasilitas_kredit',
        'jangka_waktu_angsuran',
        'suku_bunga',
        'provisi',
        'biaya_administrasi',
        'grace_period',
        'lain_lain',
        'total_fasilitas_kredit',
        'loan_applicant_id',
    ];
}
