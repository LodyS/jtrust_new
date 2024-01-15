<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KomponenTks extends Model
{
    protected $table = 'komponen_tks';
    protected $primaryKey = 'id';
    protected $fillable = [
        'komponen',
        'sub_komponen',
        'bobot',
        'minimum_ratio',
        'perubahan_ratio',
        'nilai_minimum_kredit',
        'perubahan_nilai_kredit'
    ];
}
