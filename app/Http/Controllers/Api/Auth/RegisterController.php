<?php

namespace App\Http\Controllers\Api\Auth ;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\RegisterUserRequest;
use App\Models\User;
use App\Traits\ManageApiTrait;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    use ManageApiTrait;
    
    public function register(RegisterUserRequest $request)
    {
        $data = $request->validated() ;
        $data['password'] = Hash::make($request->password);
        $user = User::create($data) ;
        return $this->createApi($user , ['User created successfully']) ;
    }
}
