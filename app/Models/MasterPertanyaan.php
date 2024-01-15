<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterPertanyaan extends Model
{
    protected $table = 'master_pertanyaan';
    protected $fillable = ['pertanyaan', 'jenis_pertanyaan', 'sub_jenis_pertanyaan', 'keterangan', 'no_urut', 'bagian', 'sub_bagian'];

    public static function getId($pertanyaan)
    {
        $data = MasterPertanyaan::where('pertanyaan', $pertanyaan)->value('id');

        return $data;
    }
}
