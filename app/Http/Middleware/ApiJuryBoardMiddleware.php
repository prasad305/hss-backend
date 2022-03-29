<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiJuryBoardMiddleware
{
   
    public function handle(Request $request, Closure $next)
    {
        if(Auth::check())
        {
            if(auth()->user()->user_type == 'jury')
            {
                return $next($request);
            }
            else{
                return response()->json([
                    'message' => "Access Denied! You don't have Jury Board Access!",
                ], 403);
            }

        }else{
            return response()->json([
                'status'=> 401,
                'message'=> 'Please Login First',
            ]);
        }
        return $next($request);
    }
}
