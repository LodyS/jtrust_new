<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CovenantCheckList extends Model
{
    protected $table = 'covenant_check_list';
    protected $fillable = ['loan_applicant_id', 'pertanyaan_id', 'keterangan', 'catatan'];
}
