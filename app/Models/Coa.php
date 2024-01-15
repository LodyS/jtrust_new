<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coa extends Model
{
    protected $table = 'coa';
    protected $primaryKey = 'id';
    protected $fillable = ['sandi_coa', 'nama_coa', 'bagian'];
}
