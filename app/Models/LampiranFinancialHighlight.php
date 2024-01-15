<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LampiranFinancialHighlight extends Model
{
    protected $table = 'lampiran_financial_highlight';
    protected $fillable = ['loan_applicant_id', 'foto', 'catatan'];
}
