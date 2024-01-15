<?php

namespace App\Http\Requests;
use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'code'=>['required', 'unique:product_type,code,'.$this->id], // berdasarkan parameter dari route
            'product_title'=>'required',
            'bunga'=>'required',
            'tabel'=>'',
            'aksi'=>'',
        ];
    }
}
