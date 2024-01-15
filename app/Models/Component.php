<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Component extends Model
{
    protected $table = 'component';
    protected $fillable = ['product_id', 'nama_komponen', 'bobot_persentase', 'max_score', 'sortnumber', 'modified_by'];
    protected $primaryKey = 'id';

    public function product ()
    {
        return $this->hasMany('App\Models\ProductType');
    }
}
