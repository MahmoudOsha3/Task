<?php

namespace App\Http\Controllers\Api\Auth ;

use App\Http\Controllers\Controller;
use App\Traits\ManageApiTrait;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    use ManageApiTrait ;

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return $this->successApi(null , 'Logged out successfully');
    }


}
