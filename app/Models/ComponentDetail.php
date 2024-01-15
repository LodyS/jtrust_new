<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComponentDetail extends Model
{
    protected $table = 'component_detail';
    protected $fillable = [
        'id_komponen',
        'uniq_code',
        'pertanyaan',
        'labeling_hasil_jawaban',
        'tipe_pertanyaan',
        'rupiah_format',
        'id_applicant_collection',
        'formula',
        'jenis_formula',
        'tipe_inputan',
        'publish',
        'sort_number',
        'modified_by'
    ];

    protected $primaryKey = 'id';
}
