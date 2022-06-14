<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiUserMiddleware
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
            if(auth()->user()->user_type == 'user')
            {
                return $next($request);
            }
            // if(auth()->user()->user_type == 'admin' && auth()->user()->status == '1')
            // {
            //     return $next($request);
            // }
            // if(auth()->user()->user_type == 'star' && auth()->user()->status == '1')
            // {
            //     return $next($request);
            // }
            if(auth()->user()->user_type == null){
                $user = auth('sanctum')->user();
        
                // send sms via helper function
                send_sms('Welcome to Hello SuperStars, your otp is : ' . $user->otp, $user->phone);

                return response()->json([
                    'message' => 'Verify Phone Number',
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
