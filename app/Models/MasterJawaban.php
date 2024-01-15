<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterJawaban extends Model
{
    protected $table = 'master_jawaban';
    protected $fillable = ['pertanyaan_id', 'jawaban', 'profil_risiko'];
}
