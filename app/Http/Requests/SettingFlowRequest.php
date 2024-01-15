<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingFlowRequest extends FormRequest
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
            'jabatan_id'=>'required',
            'level'=>'required',
            'approval_status'=>'required',
            'return_legal_opini'=>'required',
            //'return_compliance_opini'=>'required',
            'return_worksheet_screening'=>'required',
            'return_cad_opini'=>'required',
            'status_legal_opini'=>'required',
            //'status_compliance_opini'=>'required',
            'status_worksheet_screening'=>'required',
            'status_cad_opini'=>'required'
        ];
    }
}
