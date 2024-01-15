<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BungaProduk extends Model
{
    protected $table = 't_bunga_product';
    protected $fillable = ['t_credit_type_id', 'bulan', 'flat_rates', 'anuitas_rates', 'admin_fee', 'asuransi_fee'];
    protected $primaryKey = 'id';
    public $timestamps = false;
}
