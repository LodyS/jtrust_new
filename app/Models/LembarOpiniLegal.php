<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LembarOpiniLegal extends Model
{
    protected $table = 'lembar_opini_legal';
    protected $fillable = [
        'lembar_opini',
        'section_head',
        'division_head',
        'tanggal',
        'no_legal_opini',
        'catatan',
        'rekomendasi',
        'loan_applicant_id',
        'status'
    ];
}
