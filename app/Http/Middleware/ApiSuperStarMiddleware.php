<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiSuperStarMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(Auth::check())
        {
            //return $next($request);
            if(auth()->user()->user_type == 'star')
            {
                return $next($request);
            }
            // if(auth()->user()->tokenCan('server:admin'))
            // {
            //     return $next($request);
            // }
            else{
                return response()->json([
                    'message' => "Access Denied! You don't have Super Star Access!",
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
