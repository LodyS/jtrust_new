<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Disclaimer extends Model
{
    protected $table ='disclaimer';
    protected $fillable = ['sandi_bpr', 'keterangan'];
}
