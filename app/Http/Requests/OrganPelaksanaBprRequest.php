<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrganPelaksanaBprRequest extends FormRequest
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
            'nama_organ_pelaksana'=>'required|string',
            'alamat'=>'required|string',
            'nik'=>'required|numeric',
            'kepatuhan'=>'',
            'manajemen_resiko'=>'',
            'audit_intern'=>'',
            'tanggal_mulai_menjabat'=>'',
            'no_surat_pengangkatan'=>'',
            'tanggal_surat_pengangkatan'=>'',
            'no_surat_penegasa'=>'',
            'tanggal_no_surat_penegasan'=>'',
            'komite_audit'=>'',
            'komite_pemantauan_resiko'=>'',
            'komite_remunerasi_dan_nominasi'=>'',
            'sandi_bpr'=>''
        ];
    }
}
