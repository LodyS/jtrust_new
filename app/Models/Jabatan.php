<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    protected $table = 'jabatan';
    protected $fillable = ['nama_jabatan', 'member_of_credit_committee', 'kode'];

    public static function getNamaJabatan($id)
    {
        $data = Jabatan::select('nama_jabatan', 'kode')->where('id', $id)->first();
        return $data;
    }
}
