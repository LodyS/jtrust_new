<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $table = 'branch';
    protected $primaryKey = 'id';
    protected $fillable = ['region_id', 'branch_code', 'branch_title', 'publish', 'sortnumber', 'modified_datetime', 'modified_by'];
    public $timestamps = false;

    public function scopeSortNumber()
    {
        $data = Branch::max('sortnumber');
        $data = $data + 1;

        return $data ?? 1;
    }
}
