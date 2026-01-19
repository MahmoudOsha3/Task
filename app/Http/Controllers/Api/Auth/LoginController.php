<?php

namespace App\Http\Controllers\Api\Auth ;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Models\User;
use App\Traits\ManageApiTrait;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    use ManageApiTrait ;

    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return $this->failedApi('Authenticated failed' , 422) ;
        }
        $token = $user->createToken($request->userAgent())->plainTextToken;

        return $this->createApi([
            'user' => $user , 
            'token' => $token ] ,
            'Authenticated successfully'); // 201 status => created because (create token)
    }
    

}
