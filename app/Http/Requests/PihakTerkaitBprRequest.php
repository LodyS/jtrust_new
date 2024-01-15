<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PihakTerkaitBprRequest extends FormRequest
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
            'nama_pihak_terkait'=>'required|string',
            'hubungan_pihak_terkait'=>'required|string',
            'no_identitas'=>'required|string',
            'jenis_pihak_terkait'=>'required',
            'alamat_pihak_terkait'=>'required',
            'sandi_bpr'=>''
        ];
    }
}
