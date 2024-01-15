<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InputProfilRequest extends FormRequest
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
            'sandi_bpr'=>'required',
            'bulan'=>'required',
            'tahun'=>'required',
            'jumlah_peminjam'=>'required|int',
            'jumlah_nasabah_simpanan'=>'required|int'
        ];
    }
}
