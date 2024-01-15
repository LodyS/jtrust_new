<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CreditType extends Model
{
    protected $table = 't_credit_type';
    protected $fillable = ['t_product_id', 'code', 'title', 'maksimal_rpc_persentase', 'sortnumber', 'modified_datetime', 'modified_by'];
    protected $primaryKey = 'id';
    public $timestamps = false;
}
