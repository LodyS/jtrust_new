<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductType extends Model
{
    protected $table = 'product_type';
    protected $fillable = ['code', 'product_title', 'sortnumber', 'modified_datetime', 'modified_by', 'bunga'];
    protected $primaryKey = 'id';
    public $timestamps = false;

    public static function namaProduk($id)
    {
        $data = ProductType::where('id', $id)->value('product_title');

        return $data;
    }
}
