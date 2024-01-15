<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComponentNilaiScore extends Model
{
    protected $table = 'component_nilai_score';
    protected $fillable = ['score_min', 'score_max', 'description'];
    protected $primaryKey = 'id';
}
