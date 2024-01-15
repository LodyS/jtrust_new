<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RincianKantorBprRequest extends FormRequest
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
            'sandi_kantor'=>'required|string',
            'nama_kantor'=>'required|string',
            'nama_jalan_dan_no'=>'required|string',
            'desa_kecamatan'=>'required|string',
            'kab_kota'=>'required|string',
            'kode_pos'=>'required|string',
            'koordinat_kantor'=>'',
            'nama_pimpinan'=>'string|required',
            'no_telp'=>'string|required',
            'jumlah_kantor_kas'=>'',
            'status_kepemilikan_gedung'=>'string|required',
            'sandi_bpr'=>''
        ];
    }
}
