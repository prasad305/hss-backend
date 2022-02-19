<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboard()
    {
        return view('Admin.dashboard');
    }

    public function profile()
    {
        $user = Auth::user();
        return view('Admin.profile.index', compact('user'));
    }
}
