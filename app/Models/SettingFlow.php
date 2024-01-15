<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettingFlow extends Model
{
    protected $fillable = [
        'jabatan_id', 
        'level', 
        'approval_status', 
        'return_legal_opini', 
        'return_compliance_opini', 
        'return_worksheet_screening', 
        'return_cad_opini',
        'status_legal_opini',
        'status_compliance_opini',
        'status_cad_opini',
        'status_worksheet_screening',
        'status_division_head',
        'divisi',
    ];
}
