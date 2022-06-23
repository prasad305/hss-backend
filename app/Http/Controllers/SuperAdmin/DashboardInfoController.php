<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Marketplace;
use App\Models\Auction;
use App\Models\LearningSession;
use App\Models\LiveChat;
use App\Models\Post;
use App\Models\MeetupEvent;
use App\Models\Greeting;
use Carbon\Carbon;

class DashboardInfoController extends Controller
{
    public function allUser()
    {
        $data['allUser'] = User::where('user_type', 'user')->latest()->get();
        return view('SuperAdmin.dashboardInfo.user', $data);
    }
    public function allStar()
    {
        $data['allStar'] = User::where('user_type', 'star')->latest()->get();
        return view('SuperAdmin.dashboardInfo.star', $data);
    }
    public function allAdmin()
    {
        $data['allAdmin'] = User::where('user_type', 'admin')->latest()->get();
        return view('SuperAdmin.dashboardInfo.admin', $data);
    }
    public function allMarketplace()
    {
        $data['allMarketplace'] = Marketplace::latest()->get();
        return view('SuperAdmin.dashboardInfo.marketplace', $data);
    }
    public function allAuction()
    {
        $data['allAuction'] = Auction::latest()->get();
        return view('SuperAdmin.dashboardInfo.auction', $data);
    }
    public function allMeetUp()
    {
        $data['allMeetUp'] = MeetupEvent::where('meetup_type', 'Online')->latest()->get();
        $data['meetUpType'] = "Online";
        return view('SuperAdmin.dashboardInfo.meetup', $data);
    }
    public function allOfflineMeetUp()
    {
        $data['allMeetUp'] = MeetupEvent::where('meetup_type', 'Offline')->latest()->get();
        $data['meetUpType'] = "Offline";
        return view('SuperAdmin.dashboardInfo.meetup', $data);
    }
    public function allCompleteOfflineMeetUp()
    {
        $date = Carbon::now();
        $data['allMeetUp'] = MeetupEvent::where('meetup_type', 'Offline')->whereDate('date', '>', $date)->latest()->get();
        $data['meetUpType'] = "Complete Offline";
        return view('SuperAdmin.dashboardInfo.meetup', $data);
    }
    public function allCompleteOnlineMeetUp()
    {
        $date = Carbon::now();
        $data['allMeetUp'] = MeetupEvent::where('meetup_type', 'Online')->whereDate('date', '>', $date)->latest()->get();
        $data['meetUpType'] = "Complete Online";
        return view('SuperAdmin.dashboardInfo.meetup', $data);
    }
    public function allUpcomingOfflineMeetUp()
    {
        $date = Carbon::now();
        $data['allMeetUp'] = MeetupEvent::where('meetup_type', 'Offline')->whereDate('date', '<', $date)->latest()->get();
        $data['meetUpType'] = "Upcoming Offline";
        return view('SuperAdmin.dashboardInfo.meetup', $data);
    }
    public function allUpcomingOnlineMeetUp()
    {
        $date = Carbon::now();
        $data['allMeetUp'] = MeetupEvent::where('meetup_type', 'Online')->whereDate('date', '<', $date)->latest()->get();
        $data['meetUpType'] = "Upcoming Online";
        return view('SuperAdmin.dashboardInfo.meetup', $data);
    }

    public function allLearningSession()
    {
        $data['allMeetUp'] = LearningSession::latest()->get();
        $data['learningType'] = "Total";
        return view('SuperAdmin.dashboardInfo.learning_session', $data);
    }
    public function allCompleteLearningSession()
    {
        $date = Carbon::now();
        $data['allMeetUp'] = LearningSession::whereDate('date', '>', $date)->latest()->get();
        $data['learningType'] = "Complete";
        return view('SuperAdmin.dashboardInfo.learning_session', $data);
    }
    public function allUpcomingLearningSession()
    {
        $date = Carbon::now();
        $data['allMeetUp'] = LearningSession::whereDate('date', '<', $date)->latest()->get();
        $data['learningType'] = "Upcoming";
        return view('SuperAdmin.dashboardInfo.learning_session', $data);
    }

    public function allLiveChat()
    {
        $data['allMeetUp'] = LiveChat::latest()->get();
        $data['learningType'] = "Total";
        return view('SuperAdmin.dashboardInfo.learning_session', $data);
    }
    public function allCompleteLiveChat()
    {
        $date = Carbon::now();
        $data['allMeetUp'] = LiveChat::whereDate('date', '>', $date)->latest()->get();
        $data['learningType'] = "Complete";
        return view('SuperAdmin.dashboardInfo.live-chat', $data);
    }
    public function allUpcomingLiveChat()
    {
        $date = Carbon::now();
        $data['allMeetUp'] = LiveChat::whereDate('date', '<', $date)->latest()->get();
        $data['learningType'] = "Upcoming";
        return view('SuperAdmin.dashboardInfo.live-chat', $data);
    }
    public function allRunningLiveChat()
    {
        $date = Carbon::now();
        $data['allMeetUp'] = LiveChat::whereDate('date', '=', $date)->latest()->get();
        $data['learningType'] = "Running";
        return view('SuperAdmin.dashboardInfo.live-chat', $data);
    }

    //Greeting
    public function allGreeting()
    {
        $data['allMeetUp'] = Greeting::latest()->get();
        $data['learningType'] = "Total";
        return view('SuperAdmin.dashboardInfo.greeting', $data);
    }
    public function allCompleteGreeting()
    {
        $date = Carbon::now();
        $data['allMeetUp'] = Greeting::whereDate('date', '>', $date)->latest()->get();
        $data['learningType'] = "Complete";
        return view('SuperAdmin.dashboardInfo.greeting', $data);
    }
    public function allUpcomingGreeting()
    {
        $date = Carbon::now();
        $data['allMeetUp'] = Greeting::whereDate('date', '<', $date)->latest()->get();
        $data['learningType'] = "Upcoming";
        return view('SuperAdmin.dashboardInfo.greeting', $data);
    }

    //Post
    public function allPost()
    {
        $data['allMeetUp'] = Post::latest()->get();
        // dd($data['allMeetUp']->toArray());
        $data['learningType'] = "Total";
        return view('SuperAdmin.dashboardInfo.post', $data);
    }
    public function dailyPost()
    {
        $date = Carbon::now();
        $data['allMeetUp'] = Post::whereDate('created_at', '=', $date)->latest()->get();
        $data['learningType'] = "Daily";
        return view('SuperAdmin.dashboardInfo.post', $data);
    }
    public function weeklyPost()
    {
        $date = Carbon::now();
        $data['allMeetUp'] = Post::whereBetween('created_at', [
            Carbon::parse('last monday')->startOfDay(),
            Carbon::parse('next friday')->endOfDay(),
        ])->latest()->get();
        $data['learningType'] = "Weekly";
        return view('SuperAdmin.dashboardInfo.post', $data);
    }
    public function monthlyPost()
    {
        $date = Carbon::now();
        $data['allMeetUp'] = Post::whereMonth('created_at', date('m'))->latest()->get();
        $data['learningType'] = "Monthly";
        return view('SuperAdmin.dashboardInfo.post', $data);
    }
}
