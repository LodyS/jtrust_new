<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankSlikData extends Model
{
    protected $table = 't_bank_slik_data';
    protected $primaryKey = 'id';
    protected $fillable = ['id','nama_bank', 'sortnumber', 'modified_datetime', 'modified_by'];
    public $timestamps = false;

    public function scopeSortNumber()
    {
        $data = BankSlikData::max('sortnumber');
        $data = $data + 1;

        return $data ?? 1;
    }
}
