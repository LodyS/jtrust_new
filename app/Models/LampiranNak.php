<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LampiranNak extends Model
{
    protected $table = 'lampiran_nak';
    protected $fillable = ['loan_applicant_id', 'foto', 'catatan', 'bagian'];
}
