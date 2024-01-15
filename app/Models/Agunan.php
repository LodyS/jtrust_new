<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agunan extends Model
{
    protected $table = 'agunan';
    protected $fillable = ['jenis_agunan', 'nilai_pasar', 'nilai_bank', 'nilai_pengikat', 'sandi_bpr'];

    public function setNilaiPasarAttribute($value)
    {
        return $this->attributes['nilai_pasar'] = preg_replace('/[^0-9]/', '', $value);
    }

    public function setNilaiBankAttribute($value)
    {
        return $this->attributes['nilai_bank'] = preg_replace('/[^0-9]/', '', $value);
    }
}
