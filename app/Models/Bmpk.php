<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bmpk extends Model
{
    protected $table = 'bmpk';
    protected $fillable = [
        'sandi_bpr',
        'tanggal_posisi',
        'modal_inti_bank',
        'inhouse_modal_inti_bank',
        'debitur_individu',
        'inhouse_debitur_individu',
        'debitur_group',
        'inhouse_debitur_group'
    ];

    public function setModalIntiBankAttribute($value)
    {
        $this->attributes['modal_inti_bank'] = preg_replace('/[^0-9]/', '', $value);
    }

    public function setInhouseModalIntiBankAttribute($value)
    {
        $this->attributes['inhouse_modal_inti_bank'] = preg_replace('/[^0-9]/', '', $value);
    }

    public function setDebiturIndividuAttribute($value)
    {
        $this->attributes['debitur_individu'] = preg_replace('/[^0-9]/', '', $value);
    }

    public function setInhouseDebiturIndividuAttribute($value)
    {
        $this->attributes['inhouse_debitur_individu'] = preg_replace('/[^0-9]/', '', $value);
    }

    public function setDebiturGroupAttribute($value)
    {
        $this->attributes['debitur_group'] = preg_replace('/[^0-9]/', '', $value);
    }

    public function setInhouseDebiturGroupAttribute($value)
    {
        $this->attributes['inhouse_debitur_group'] = preg_replace('/[^0-9]/', '', $value);
    }
}
