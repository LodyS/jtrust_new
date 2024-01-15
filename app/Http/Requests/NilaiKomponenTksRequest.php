<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NilaiKomponenTksRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'sub_komponen'=>'required',
            'nilai_min'=>'required',
            'nilai_max'=>'required|gt:nilai_min',
            'kategori'=>'required'
        ];
    }
}
