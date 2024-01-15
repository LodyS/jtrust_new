<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BwmkRequest extends FormRequest
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
            'karakter'=>'required',
            'nilai_kredit_minimum'=>'required',
            'nilai_kredit_maksimum'=>'required',
            'voting_member'=>'required',
            'non_voting_member'=>'required'
        ];
    }
}
