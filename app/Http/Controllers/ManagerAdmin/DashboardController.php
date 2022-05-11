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
    public function meetupEventsData()
    {
        return view('ManagerAdmin.MeetupEvents.meetupEventsData');
    }
    public function meetupEventsDetails()
    {
        return view('ManagerAdmin.MeetupEvents.meetupEventsDetails');
    }
    public function greetings()
    {
        return view('ManagerAdmin.LearningSession.dashboard');
    }
    public function greetingsData()
    {
        return view('ManagerAdmin.LearningSession.dashboard');
    }
    public function greetingsDetails()
    {
        return view('ManagerAdmin.LearningSession.dashboard');
    }
    public function liveChats()
    {
        return view('ManagerAdmin.LiveChat.dashboard');
    }
    public function liveChatsData()
    {
        return view('ManagerAdmin.LiveChat.liveChatsData');
    }
    public function liveChatsDetails()
    {
        return view('ManagerAdmin.LiveChat.liveChatsDetails');
    }
    public function auditions()
    {
        return view('ManagerAdmin.Audition.dashboard');
    }
    public function auditionsData()
    {
        return view('ManagerAdmin.Audition.auditionsData');
    }
    public function auditionsDetails()
    {
        return view('ManagerAdmin.Audition.auditionsDetails');
    }
    public function fanGroups()
    {
        return view('ManagerAdmin.fangroup.dashboard');
    }
    public function fanGroupsData()
    {
        return view('ManagerAdmin.fangroup.fanGroupData');
    }
    public function fanGroupsDetails()
    {
        return view('ManagerAdmin.fangroup.fanGroupDetails');
    }
    public function learninSessionData()
    {
        return view('ManagerAdmin.LearningSession.learningSessionData');
    }
    public function learninSessionDetails()
    {
        return view('ManagerAdmin.LearningSession.sessionDetails');
    }
    public function auditionsJudgeData()
    {
        return view('ManagerAdmin.Audition.auditionsJudges');
    }
    public function auditionsJuryData()
    {
        return view('ManagerAdmin.Audition.auditionsJuries');
    }
}
