<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KomponenTksRequest extends FormRequest
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
            'komponen'=>'required',
            'sub_komponen'=>'required',
            'bobot'=>'required',
            'minimum_ratio'=>'required',
            'perubahan_ratio'=>'required',
            'nilai_minimum_kredit'=>'required',
            'perubahan_nilai_kredit'=>'required'
        ];
    }
}
