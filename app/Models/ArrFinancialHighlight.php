<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArrFinancialHighlight extends Model
{
    protected $table = 'arr_financial_highlight';
    protected $fillable = ['loan_applicant_id', 'keterangan'];
}
