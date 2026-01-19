<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth ;


class JwtUserAuth
{
    public function handle(Request $request, Closure $next)
    {
        $user = null ;
        try{
            $user = JWTAuth::parseToken()->authenticate() ;
        }
        catch(\Exception $e){
            if($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                return response()->json(['success' => false , 'msg' => 'INVALID TOKEN']) ;
            }
            elseif($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                return response()->json(['success' => false , 'msg' => 'EXPIRED TOKEN']) ;
            }
            else{
                return response()->json(['success' => false , 'msg' => 'NOT_FOUND TOKEN']) ;
            }
        }
        return $next($request);
    }
}
