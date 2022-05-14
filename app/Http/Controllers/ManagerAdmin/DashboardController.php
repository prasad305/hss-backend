<?php

namespace App\Http\Controllers\ManagerAdmin;

use App\Http\Controllers\Controller;
use App\Models\AssignJury;
use App\Models\Auction;
use App\Models\Audition\AssignJudge;
use App\Models\Audition\Audition;
use App\Models\AuditionEventRegistration;
use App\Models\Category;
use App\Models\Fan_Group_Join;
use App\Models\FanGroup;
use App\Models\FanPost;
use App\Models\Greeting;
use App\Models\LearningSession;
use App\Models\LearningSessionRegistration;
use App\Models\LiveChat;
use App\Models\LiveChatRegistration;
use App\Models\Marketplace;
use App\Models\MeetupEvent;
use App\Models\MeetupEventRegistration;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class DashboardController extends Controller
{
    public function dashboard()
    {

        $totalUser = User::where('user_type', 'user')->count();
        $totalAdmin = User::where('user_type', 'admin')->where('parent_user', auth()->user()->id)->count();
        $totalStar = User::where('user_type', 'star')->where('parent_user', auth()->user()->id)->count();
        $totalAuctionProduct = Auction::where('category_id', auth()->user()->category_id)->count();
        $totalMarketPlaceProduct = Marketplace::where('category_id', auth()->user()->category_id)->count();
        return view('ManagerAdmin.dashboard', compact(['totalUser', 'totalAdmin', 'totalStar', 'totalAuctionProduct', 'totalMarketPlaceProduct']));
    }

    public function profile()
    {
        $user = Auth::user();
        return view('ManagerAdmin.profile.index', compact('user'));
    }

    public function learningSessions()
    {
        // Total
        $total = LearningSession::where('category_id', auth()->user()->category_id)->count();
        $upcoming = LearningSession::where('status', 0)->where('category_id', auth()->user()->category_id)->count();
        $complete = LearningSession::where('status', 10)->where('category_id', auth()->user()->category_id)->count();

        // Registered User

        $weeklyUser = LearningSessionRegistration::where('payment_status', 1)->where('created_at', '>', Carbon::now()->startOfWeek())->where('created_at', '<', Carbon::now()->endOfWeek())->count();
        $monthlyUser = LearningSessionRegistration::where('created_at', '>', Carbon::now()->startOfMonth())->where('created_at', '<', Carbon::now()->endOfMonth())->count();
        $yearlyUser = LearningSessionRegistration::where('created_at', '>', Carbon::now()->startOfYear())->where('created_at', '<', Carbon::now()->endOfYear())->count();

        // Income Statement

        $weeklyIncome = LearningSessionRegistration::where('created_at', '>', Carbon::now()->startOfWeek())->where('created_at', '<', Carbon::now()->endOfWeek())->sum('amount');
        $monthlyIncome = LearningSessionRegistration::where('created_at', '>', Carbon::now()->startOfMonth())->where('created_at', '<', Carbon::now()->endOfMonth())->sum('amount');
        $yearlyIncome = LearningSessionRegistration::where('created_at', '>', Carbon::now()->startOfYear())->where('created_at', '<', Carbon::now()->endOfYear())->sum('amount');

        return view('ManagerAdmin.LearningSession.dashboard', compact(['total', 'upcoming', 'complete', 'weeklyUser', 'monthlyUser', 'yearlyUser', 'weeklyIncome', 'monthlyIncome', 'yearlyIncome']));
    }
    public function learninSessionData($type)
    {

        if ($type == 'total') {
            $portalData = LearningSession::with(['star', 'category'])->where('category_id', auth()->user()->category_id)->get();
        } elseif ($type == 'upcoming') {
            $portalData = LearningSession::with(['star', 'category'])->where('status', 0)->where('category_id', auth()->user()->category_id)->get();
        } else {
            $portalData = LearningSession::with(['star', 'category'])->where('status', 10)->where('category_id', auth()->user()->category_id)->get();
        }

        return view('ManagerAdmin.LearningSession.learningSessionData', compact('portalData'));
    }
    public function learninSessionDetails()
    {
        return view('ManagerAdmin.LearningSession.sessionDetails');
    }
    public function meetupEvents()
    {
        // Total
        $total = MeetupEvent::where('category_id', auth()->user()->category_id)->count();
        $upcoming = MeetupEvent::where('status', 0)->where('category_id', auth()->user()->category_id)->count();
        $complete = MeetupEvent::where('status', 10)->where('category_id', auth()->user()->category_id)->count();

        // Registered User

        $weeklyUser = MeetupEventRegistration::where('payment_status', 1)->where('created_at', '>', Carbon::now()->startOfWeek())->where('created_at', '<', Carbon::now()->endOfWeek())->count();
        $monthlyUser = MeetupEventRegistration::where('created_at', '>', Carbon::now()->startOfMonth())->where('created_at', '<', Carbon::now()->endOfMonth())->count();
        $yearlyUser = MeetupEventRegistration::where('created_at', '>', Carbon::now()->startOfYear())->where('created_at', '<', Carbon::now()->endOfYear())->count();

        // Income Statement

        $weeklyIncome = MeetupEventRegistration::where('created_at', '>', Carbon::now()->startOfWeek())->where('created_at', '<', Carbon::now()->endOfWeek())->sum('amount');
        $monthlyIncome = MeetupEventRegistration::where('created_at', '>', Carbon::now()->startOfMonth())->where('created_at', '<', Carbon::now()->endOfMonth())->sum('amount');
        $yearlyIncome = MeetupEventRegistration::where('created_at', '>', Carbon::now()->startOfYear())->where('created_at', '<', Carbon::now()->endOfYear())->sum('amount');
        return view('ManagerAdmin.MeetupEvents.dashboard', compact(['total', 'upcoming', 'complete', 'weeklyUser', 'monthlyUser', 'yearlyUser', 'weeklyIncome', 'monthlyIncome', 'yearlyIncome']));
    }
    public function meetupEventsData($type)
    {
        if ($type == 'total') {
            $portalData = MeetupEvent::with(['star', 'category'])->where('category_id', auth()->user()->category_id)->get();
        } elseif ($type == 'upcoming') {
            $portalData = MeetupEvent::with(['star', 'category'])->where('status', 0)->where('category_id', auth()->user()->category_id)->get();
        } else {
            $portalData = MeetupEvent::with(['star', 'category'])->where('status', 10)->where('category_id', auth()->user()->category_id)->get();
        }
        return view('ManagerAdmin.MeetupEvents.meetupEventsData', compact('portalData'));
    }
    public function meetupEventsDetails()
    {
        return view('ManagerAdmin.MeetupEvents.meetupEventsDetails');
    }
    public function greetings()
    {
        return view('ManagerAdmin.LearningSession.dashboard');
    }
    public function greetingsData($type)
    {
        if ($type == 'total') {
            $portalData = Greeting::with(['star', 'category'])->where('category_id', auth()->user()->category_id)->get();
        } elseif ($type == 'upcoming') {
            $portalData = Greeting::with(['star', 'category'])->where('status', 0)->where('category_id', auth()->user()->category_id)->get();
        } else {
            $portalData = Greeting::with(['star', 'category'])->where('status', 10)->where('category_id', auth()->user()->category_id)->get();
        }
        return view('ManagerAdmin.LearningSession.dashboard', compact('portalData'));
    }
    public function greetingsDetails()
    {
        return view('ManagerAdmin.LearningSession.dashboard');
    }
    public function liveChats()
    {
        // Total
        $total = LiveChat::where('category_id', auth()->user()->category_id)->count();
        $upcoming = LiveChat::where('status', 0)->where('category_id', auth()->user()->category_id)->count();
        $complete = LiveChat::where('status', 10)->where('category_id', auth()->user()->category_id)->count();

        // Registered User

        $weeklyUser = LiveChatRegistration::where('payment_status', 1)->where('created_at', '>', Carbon::now()->startOfWeek())->where('created_at', '<', Carbon::now()->endOfWeek())->count();
        $monthlyUser = LiveChatRegistration::where('created_at', '>', Carbon::now()->startOfMonth())->where('created_at', '<', Carbon::now()->endOfMonth())->count();
        $yearlyUser = LiveChatRegistration::where('created_at', '>', Carbon::now()->startOfYear())->where('created_at', '<', Carbon::now()->endOfYear())->count();

        // Income Statement

        $weeklyIncome = LiveChatRegistration::where('created_at', '>', Carbon::now()->startOfWeek())->where('created_at', '<', Carbon::now()->endOfWeek())->sum('amount');
        $monthlyIncome = LiveChatRegistration::where('created_at', '>', Carbon::now()->startOfMonth())->where('created_at', '<', Carbon::now()->endOfMonth())->sum('amount');
        $yearlyIncome = LiveChatRegistration::where('created_at', '>', Carbon::now()->startOfYear())->where('created_at', '<', Carbon::now()->endOfYear())->sum('amount');
        return view('ManagerAdmin.LiveChat.dashboard', compact(['total', 'upcoming', 'complete', 'weeklyUser', 'monthlyUser', 'yearlyUser', 'weeklyIncome', 'monthlyIncome', 'yearlyIncome']));
    }
    public function liveChatsData($type)
    {
        if ($type == 'total') {
            $portalData = LiveChat::with(['star', 'category'])->where('category_id', auth()->user()->category_id)->get();
        } elseif ($type == 'upcoming') {
            $portalData = LiveChat::with(['star', 'category'])->where('status', 0)->where('category_id', auth()->user()->category_id)->get();
        } else {
            $portalData = LiveChat::with(['star', 'category'])->where('status', 10)->where('category_id', auth()->user()->category_id)->get();
        }
        return view('ManagerAdmin.LiveChat.liveChatsData', compact('portalData'));
    }
    public function liveChatsDetails()
    {
        return view('ManagerAdmin.LiveChat.liveChatsDetails');
    }
    public function auditions()
    {
        // Total
        $total = Audition::where('category_id', auth()->user()->category_id)->count();
        $upcoming = Audition::where('status', 0)->where('category_id', auth()->user()->category_id)->count();
        $running = Audition::where('status', 1)->where('category_id', auth()->user()->category_id)->count();
        $complete = Audition::where('status', 10)->where('category_id', auth()->user()->category_id)->count();
        $totalJudge = AssignJudge::distinct('judge_id')->count();
        $totalJury = AssignJury::distinct('jury_id')->count();

        // Registered User

        $weeklyUser = AuditionEventRegistration::where('payment_status', 1)->where('created_at', '>', Carbon::now()->startOfWeek())->where('created_at', '<', Carbon::now()->endOfWeek())->count();
        $monthlyUser = AuditionEventRegistration::where('created_at', '>', Carbon::now()->startOfMonth())->where('created_at', '<', Carbon::now()->endOfMonth())->count();
        $yearlyUser = AuditionEventRegistration::where('created_at', '>', Carbon::now()->startOfYear())->where('created_at', '<', Carbon::now()->endOfYear())->count();

        // Income Statement

        $weeklyIncome = AuditionEventRegistration::where('created_at', '>', Carbon::now()->startOfWeek())->where('created_at', '<', Carbon::now()->endOfWeek())->sum('amount');
        $monthlyIncome = AuditionEventRegistration::where('created_at', '>', Carbon::now()->startOfMonth())->where('created_at', '<', Carbon::now()->endOfMonth())->sum('amount');
        $yearlyIncome = AuditionEventRegistration::where('created_at', '>', Carbon::now()->startOfYear())->where('created_at', '<', Carbon::now()->endOfYear())->sum('amount');
        return view('ManagerAdmin.Audition.dashboard', compact(['total', 'upcoming', 'complete', 'weeklyUser', 'monthlyUser', 'yearlyUser', 'weeklyIncome', 'monthlyIncome', 'yearlyIncome', 'running', 'totalJudge', 'totalJury']));
    }
    public function auditionsData($type)
    {
        if ($type == 'total') {
            $portalData = Audition::with(['star', 'category'])->where('category_id', auth()->user()->category_id)->get();
        } elseif ($type == 'upcoming') {
            $portalData = Audition::with(['star', 'category'])->where('status', 0)->where('category_id', auth()->user()->category_id)->get();
        } elseif ($type == 'complete') {
            $portalData = Audition::with(['star', 'category'])->where('status', 10)->where('category_id', auth()->user()->category_id)->get();
        } else {
            $portalData = Audition::with(['star', 'category'])->where('status', 1)->where('category_id', auth()->user()->category_id)->get();
        }
        return view('ManagerAdmin.Audition.auditionsData', compact('portalData'));
    }
    public function auditionsDetails()
    {
        return view('ManagerAdmin.Audition.auditionsDetails');
    }
    public function fanGroups()
    {
        $total = FanGroup::where('category_id', auth()->user()->category_id)->count();
        $totalFanPost = FanPost::count();
        $totalUser = Fan_Group_Join::count();

        $weeklyUser = Fan_Group_Join::distinct('user_id')->where('created_at', '>', Carbon::now()->startOfWeek())->where('created_at', '<', Carbon::now()->endOfWeek())->count();
        $monthlyUser = Fan_Group_Join::distinct('user_id')->where('created_at', '>', Carbon::now()->startOfMonth())->where('created_at', '<', Carbon::now()->endOfMonth())->count();
        $yearlyUser = Fan_Group_Join::distinct('user_id')->where('created_at', '>', Carbon::now()->startOfYear())->where('created_at', '<', Carbon::now()->endOfYear())->count();

        return view('ManagerAdmin.fangroup.dashboard', compact(['total', 'totalFanPost', 'totalUser', 'weeklyUser', 'monthlyUser', 'yearlyUser']));
    }
    public function fanGroupsData()
    {

        $portalData = FanGroup::with(['star', 'category'])->where('category_id', auth()->user()->category_id)->get();

        return view('ManagerAdmin.fangroup.fanGroupData', compact('portalData'));
    }
    public function fanGroupsPost()
    {

        $portalData = FanPost::with(['category'])->where('category_id', auth()->user()->category_id)->get();

        return view('ManagerAdmin.fangroup.fanGroupData', compact('portalData'));
    }

    public function fanGroupsDetails()
    {
        return view('ManagerAdmin.fangroup.fanGroupDetails');
    }

    public function auditionsJudgeData()
    {
        $judgeList = AssignJudge::with(['user', 'auditions'])->where('category_id', auth()->user()->category_id)->get();

        // dd($judgeList);
        return view('ManagerAdmin.Audition.auditionsJudges', compact('judgeList'));
    }
    public function auditionsJuryData()
    {
        $juryList = AssignJury::with(['user', 'auditions'])->where('category_id', auth()->user()->category_id)->get();
        return view('ManagerAdmin.Audition.auditionsJuries', compact('juryList'));
    }
}
