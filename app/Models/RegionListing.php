<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegionListing extends Model
{
    protected $table = 'region_listing';
    protected $fillable = ['region_code', 'region_title', 'publish', 'sortnumber', 'modified_datetime', 'modified_by'];
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function scopeSortNumber()
    {
        $data = RegionListing::max('sortnumber');
        $data = $data + 1;

        return $data ?? 1;
    }
}
