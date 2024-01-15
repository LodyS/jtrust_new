<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pemasaran extends Model
{
    protected $table = 'pemasaran';
    protected $primaryKey = 'id';
    protected $fillable = [
        'keterangan',
        'sandi_bpr',
        'loan_applicant_id'
    ];
}
