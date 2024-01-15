<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fiducia extends Model
{
    protected $table = 'fiducia';
    protected $fillable = [
        'tanggal_menjadi_anggota',
        'no_akad',
        'produk',
        'nama_peminjam',
        'cabang',
        'kota',
        'plafond',
        'os',
        'tanggal_pencairan',
        'jangka_waktu',
        'status',
        'tujuan_penggunaan',
        'hari_tunggakan',
        'kolektibilitas',
        'loan_applicant_id'
    ];
}
