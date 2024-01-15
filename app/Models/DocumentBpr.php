<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentBpr extends Model
{
    protected $table = 'document_bpr';
    protected $fillable = [
        'lampiran',
        'keterangan',
        'sandi_bpr',
        'status'
    ];
}
