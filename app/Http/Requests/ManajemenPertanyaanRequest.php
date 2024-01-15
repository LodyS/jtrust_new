<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ManajemenPertanyaanRequest extends FormRequest
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
            'kelompok_pertanyaan'=>'required',
            'sub_kelompok_pertanyaan'=>'required',
            'detail_pertanyaan'=>'required',
            'range_skor_minimal'=>'required',
            'range_skor_maksimal'=>'required'
        ];
    }
}
