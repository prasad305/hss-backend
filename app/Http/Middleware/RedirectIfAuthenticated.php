<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  ...$guards
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check() ) {
                //Super Admin
                if (Auth::user()->user_type == 'super-admin') {
                    return redirect()->intended(RouteServiceProvider::SuperAdminDashboard);
                }elseif(Auth::user()->user_type == 'manager-admin'){
                    return redirect()->intended(RouteServiceProvider::ManagerAdminDashboard);
                }
                // // Other's
                // if (Auth::user()->role == 'Other's') {
                //     return redirect()->intended(RouteServiceProvider::Other's);
                // }
            }
        }

        return $next($request);
    }
}
