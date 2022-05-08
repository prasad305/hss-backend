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
      return view('SuperAdmin.dashboard.index');
    }
    public function auditions(){
      return view('SuperAdmin.dashboard.auditions');
    }
    public function meetupEvents(){
      return view('SuperAdmin.dashboard.meetup-events');
    }
    public function learningSessions(){
      return view('SuperAdmin.dashboard.learning-sessions');
    }
    public function liveChats(){
      return view('SuperAdmin.dashboard.live-chats');
    }
    public function fanGroup(){
      return view('SuperAdmin.dashboard.fan-group');
    }
    public function greetings(){
      return view('SuperAdmin.dashboard.greetings');
    }
    public function userPosts(){
      return view('SuperAdmin.dashboard.user-posts');
    }
    public function wallets(){
      return view('SuperAdmin.dashboard.wallets');
    }
   

    public function profile(){
        $user = Auth::user();
        return view('SuperAdmin.profile.index', compact('user'));
    }
}
