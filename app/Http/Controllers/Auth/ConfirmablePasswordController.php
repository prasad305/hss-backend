<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class ConfirmablePasswordController extends Controller
{
    /**
     * Show the confirm password view.
     *
     * @return \Illuminate\View\View
     */
    public function show()
    {
        return view('auth.confirm-password');
    }

    /**
     * Confirm the user's password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function store(Request $request)
    {
        if (! Auth::guard('web')->validate([
            'email' => $request->user()->email,
            'password' => $request->password,
        ])) {
            throw ValidationException::withMessages([
                'password' => __('auth.password'),
            ]);
        }

        $request->session()->put('auth.password_confirmed_at', time());

        // Super Admin
        if (Auth::user()->hasRole('super-admin')) {
            return redirect()->intended(RouteServiceProvider::SuperAdminDashboard);
        }
        // Others
        // if (Auth::user()->hasRole('Others')) {
        //     return redirect()->intended(RouteServiceProvider::Others);
        // }

        //Unknown type
        else {
            session()->flash('message', 'Non-permitted role.');
            session()->flash('type', 'danger');
            Auth::logout();
            return redirect('/');
        }
    }
}
