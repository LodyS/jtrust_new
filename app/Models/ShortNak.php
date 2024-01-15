<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShortNak extends Model
{
    protected $table = 'short_nak';
    protected $fillable = ['latar_belakang', 'pembahasan', 'usulan', 'disclaimer', 'loan_applicant_id'];
}
