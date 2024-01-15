<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KeyRiskIssue extends Model
{
    protected $table = 'key_risk_issue';
    protected $fillable = ['loan_applicant_id', 'risk_issue', 'jawaban', 'risk_mitigation'];
}
