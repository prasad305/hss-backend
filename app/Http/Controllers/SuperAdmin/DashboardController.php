<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Booster;
use App\Models\Center;
use App\Models\PcrTest;
use App\Models\User;
use App\Models\Vaccination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboard(){
      return view('SuperAdmin.dashboard');
    }

    public function profile(){
        $user = Auth::user();
        return view('SuperAdmin.profile.index', compact('user'));
    }
}
