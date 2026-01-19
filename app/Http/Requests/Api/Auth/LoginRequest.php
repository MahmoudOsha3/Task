<?php

namespace App\Http\Requests\Api\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true ;
    }


    public function rules()
    {
        return [
            'email' => 'required|exists:users,email' ,
            'password' => 'required|min:8|max:25'
        ];
    }
}
