<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string|min:5|max:30' ,
            'email' => 'required|email|unique:users,email' ,
            'password'=> 'required|min:8|max:25' ,
            'role' => 'required|in:purchaser,receiver,storekeeper'
        ];
    }
}
