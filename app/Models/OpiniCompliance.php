<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OpiniCompliance extends Model
{
    protected $table = 'opini_compliance';
    protected $fillable = ['section_head', 'division_head', 'catatan', 'lembar_opini', 'loan_applicant_id', 'status', 'departemen_head'];
}
