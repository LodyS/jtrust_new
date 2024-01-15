<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name'=>'required|string',
            'email'=>'required|string',
            'jabatan'=>'required',
            'divisi'=>'',
            'atasan_id'=>'',
            'kode_rm'=>'',
            'relationship_manager'=>'',
            'password'=>'required',
            'password_confirm'=>'required'
        ];
    }
}
