<?php

namespace App\Http\Controllers\ManagerAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class DashboardController extends Controller
{
    public function dashboard()
    {
        return view('ManagerAdmin.dashboard');
    }

    public function profile()
    {
        $user = Auth::user();
        return view('ManagerAdmin.profile.index', compact('user'));
    }

    public function learningSessions()
    {
        return view('ManagerAdmin.LearningSession.dashboard');
    }
    public function meetupEvents()
    {
        return view('ManagerAdmin.MeetupEvents.dashboard');
    }
    public function greetings()
    {
        return view('ManagerAdmin.LearningSession.dashboard');
    }
    public function liveChats()
    {
        return view('ManagerAdmin.LiveChat.dashboard');
    }
    public function auditions()
    {
        return view('ManagerAdmin.Audition.dashboard');
    }
    public function fanGroups()
    {
        return view('ManagerAdmin.fangroup.dashboard');
    }
}
