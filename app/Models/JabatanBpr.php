<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JabatanBpr extends Model
{
    protected $table = 'jabatan_bpr';
    protected $primaryKey = 'id';
    protected $fillable = ['jabatan', 'kode'];
}
