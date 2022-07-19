<?php

namespace App\Http\Controllers\ManagerAdmin;

use App\Http\Controllers\Controller;
use App\Models\AssignJury;
use App\Models\Auction;
use App\Models\Audition\AssignJudge;
use App\Models\Audition\Audition;
use App\Models\AuditionEventRegistration;
use App\Models\Bidding;
use App\Models\Category;
use App\Models\Fan_Group_Join;
use App\Models\FanGroup;
use App\Models\FanPost;
use App\Models\GeneralPostPayment;
use App\Models\Greeting;
use App\Models\GreetingsRegistration;
use App\Models\JuryBoard;
use App\Models\LearningSession;
use App\Models\LearningSessionRegistration;
use App\Models\LiveChat;
use App\Models\LiveChatRegistration;
use App\Models\Marketplace;
use App\Models\MarketplaceOrder;
use App\Models\MeetupEvent;
use App\Models\MeetupEventRegistration;
use App\Models\QnA;
use App\Models\QnaRegistration;
use App\Models\SimplePost;
use App\Models\SouvenirApply;
use App\Models\SouvenirCreate;
use App\Models\SubCategory;
use App\Models\User;
use Barryvdh\DomPDF\PDF;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


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

    public function category()
    {
        $categories = Category::all();
        return view('ManagerAdmin.dashboard', compact('categories'));
    }
    public function profile()
    {
        $user = Auth::user();
        return view('ManagerAdmin.profile.index', compact('user'));
    }

    public function learningSessions()

    {

        $categories = SubCategory::with(['subLearningSession'])->where('category_id', auth()->user()->category_id)->get();


        // Total
        $total = LearningSession::where('category_id', auth()->user()->category_id)->count();
        $running = LearningSession::where('status', 2)->where('category_id', auth()->user()->category_id)->count();
        $complete = LearningSession::where('status', 10)->where('category_id', auth()->user()->category_id)->count();
        $admin = LearningSession::distinct('admin_id')->where('category_id', auth()->user()->category_id)->count();
        $superstar = LearningSession::distinct('star_id')->where('category_id', auth()->user()->category_id)->count();


        // Registered User

        $weeklyUser = LearningSessionRegistration::whereHas('learningSession', function ($q) {
            $q->where([['category_id', auth()->user()->category_id]]);
        })->where('created_at', '>', Carbon::now()->startOfWeek())->where('created_at', '<', Carbon::now()->endOfWeek())->count();
        $monthlyUser = LearningSessionRegistration::whereHas('learningSession', function ($q) {
            $q->where([['category_id', auth()->user()->category_id]]);
        })->where('created_at', '>', Carbon::now()->startOfMonth())->where('created_at', '<', Carbon::now()->endOfMonth())->count();
        $yearlyUser = LearningSessionRegistration::whereHas('learningSession', function ($q) {
            $q->where([['category_id', auth()->user()->category_id]]);
        })->where([['created_at', '>', Carbon::now()->startOfYear()], ['created_at', '<', Carbon::now()->endOfYear()]])->count();

        // Income Statement

        $weeklyIncome = LearningSessionRegistration::whereHas('learningSession', function ($q) {
            $q->where([['category_id', auth()->user()->category_id]]);
        })->where('created_at', '>', Carbon::now()->startOfWeek())->where('created_at', '<', Carbon::now()->endOfWeek())->sum('amount');
        $monthlyIncome = LearningSessionRegistration::whereHas('learningSession', function ($q) {
            $q->where([['category_id', auth()->user()->category_id]]);
        })->where('created_at', '>', Carbon::now()->startOfMonth())->where('created_at', '<', Carbon::now()->endOfMonth())->sum('amount');
        $yearlyIncome = LearningSessionRegistration::whereHas('learningSession', function ($q) {
            $q->where([['category_id', auth()->user()->category_id]]);
        })->where('created_at', '>', Carbon::now()->startOfYear())->where('created_at', '<', Carbon::now()->endOfYear())->sum('amount');


        $labels = LearningSessionRegistration::whereHas('learningSession', function ($q) {
            $q->where([['category_id', auth()->user()->category_id]]);
        })->get(['id', 'created_at', 'amount'])->groupBy(function ($date) {
            return Carbon::parse($date->created_at)->format('M');
        });

        $months = [];
        $amountCount = [];
        foreach ($labels as $month => $values) {
            $months[] = $month;
            $amountCount[] = $values->sum('amount');
        }

        // dd($monthCount);



        return view('ManagerAdmin.LearningSession.dashboard', compact(['total', 'running', 'complete', 'weeklyUser', 'monthlyUser', 'yearlyUser', 'weeklyIncome', 'monthlyIncome', 'yearlyIncome', 'categories', 'admin', 'superstar']))->with('months', json_encode($months, JSON_NUMERIC_CHECK))->with('amountCount', json_encode($amountCount, JSON_NUMERIC_CHECK));
    }
    public function learninSessionData($type)
    {

        if ($type == 'total') {
            $portalData = LearningSession::with(['star', 'category'])->orderBy('id', 'DESC')->where('category_id', auth()->user()->category_id)->get();
        } elseif ($type == 'running') {
            $portalData = LearningSession::with(['star', 'category'])->where('status', 2)->where('category_id', auth()->user()->category_id)->get();
        } else {
            $portalData = LearningSession::with(['star', 'category'])->where('status', 10)->where('category_id', auth()->user()->category_id)->get();
        }

        return view('ManagerAdmin.LearningSession.learningSessionData', compact('portalData'));
    }
    public function learninSessionDetails($id)
    {
        $totalParticipant = LearningSessionRegistration::where('learning_session_id', $id)->count();
        $totalFee = LearningSessionRegistration::where('learning_session_id', $id)->where('payment_status', 1)->sum('amount');
        $data = LearningSession::with(['star', 'category'])->where('category_id', auth()->user()->category_id)->find($id);

        return view('ManagerAdmin.LearningSession.sessionDetails', compact(['data', 'totalParticipant', 'totalFee']));
    }
    public function sublearningSessionList($subcategoryId)
    {
        $postList = LearningSession::where('sub_category_id', $subcategoryId)->latest()->get();
        return view('ManagerAdmin.LearningSession.postList', compact('postList'));
    }

    public function learningSessionAdminList()
    {
        $admins = LearningSession::with('starAdmin')->where('category_id', auth()->user()->category_id)->distinct()->whereNotNull('admin_id')->get(['admin_id']);
        return view('ManagerAdmin.LearningSession.Admin.admin', compact('admins'));
    }
    public function learningSessionAdminEvents($adminId)
    {
        $learningSession = LearningSession::where('admin_id', $adminId)->latest()->get();
        return view('ManagerAdmin.LearningSession.Admin.admin_events', compact('learningSession'));
    }
    public function learningSessionSuperstarList()
    {
        $superstars = LearningSession::with('starSession')->where('category_id', auth()->user()->category_id)->distinct()->whereNotNull('star_id')->get(['star_id']);
        return view('ManagerAdmin.LearningSession.Superstar.superstar', compact('superstars'));
    }
    public function learningSessionSuperstarEvents($starId)
    {
        $learningSession = LearningSession::where('star_id', $starId)->latest()->get();
        return view('ManagerAdmin.LearningSession.Superstar.superstar_events', compact('learningSession'));
    }
    public function meetupEvents()
    {
        $categories = SubCategory::with(['submeetup'])->where('category_id', auth()->user()->category_id)->get();

        // Total
        $total = MeetupEvent::where('category_id', auth()->user()->category_id)->count();
        $running = MeetupEvent::where('status', 2)->where('category_id', auth()->user()->category_id)->count();
        $complete = MeetupEvent::where('status', 10)->where('category_id', auth()->user()->category_id)->count();
        $admin = MeetupEvent::distinct('admin_id')->where('category_id', auth()->user()->category_id)->count();
        $superstar = MeetupEvent::distinct('star_id')->where('category_id', auth()->user()->category_id)->count();


        // Registered User

        $weeklyUser = MeetupEventRegistration::whereHas('meetupEvent', function ($q) {
            $q->where([['category_id', auth()->user()->category_id]]);
        })->where('created_at', '>', Carbon::now()->startOfWeek())->where('created_at', '<', Carbon::now()->endOfWeek())->count();
        $monthlyUser = MeetupEventRegistration::whereHas('meetupEvent', function ($q) {
            $q->where([['category_id', auth()->user()->category_id]]);
        })->where('created_at', '>', Carbon::now()->startOfMonth())->where('created_at', '<', Carbon::now()->endOfMonth())->count();
        $yearlyUser = MeetupEventRegistration::whereHas('meetupEvent', function ($q) {
            $q->where([['category_id', auth()->user()->category_id]]);
        })->where('created_at', '>', Carbon::now()->startOfYear())->where('created_at', '<', Carbon::now()->endOfYear())->count();

        // Income Statement

        $weeklyIncome = MeetupEventRegistration::whereHas('meetupEvent', function ($q) {
            $q->where([['category_id', auth()->user()->category_id]]);
        })->where('created_at', '>', Carbon::now()->startOfWeek())->where('created_at', '<', Carbon::now()->endOfWeek())->sum('amount');
        $monthlyIncome = MeetupEventRegistration::whereHas('meetupEvent', function ($q) {
            $q->where([['category_id', auth()->user()->category_id]]);
        })->where('created_at', '>', Carbon::now()->startOfMonth())->where('created_at', '<', Carbon::now()->endOfMonth())->sum('amount');
        $yearlyIncome = MeetupEventRegistration::whereHas('meetupEvent', function ($q) {
            $q->where([['category_id', auth()->user()->category_id]]);
        })->where('created_at', '>', Carbon::now()->startOfYear())->where('created_at', '<', Carbon::now()->endOfYear())->sum('amount');

        $labels = MeetupEventRegistration::whereHas('meetupEvent', function ($q) {
            $q->where([['category_id', auth()->user()->category_id]]);
        })->get(['id', 'created_at', 'amount'])->groupBy(function ($date) {
            return Carbon::parse($date->created_at)->format('M');
        });

        $months = [];
        $amountCount = [];
        foreach ($labels as $month => $values) {
            $months[] = $month;
            $amountCount[] = $values->sum('amount');
        }


        return view('ManagerAdmin.MeetupEvents.dashboard', compact(['total', 'running', 'complete', 'weeklyUser', 'monthlyUser', 'yearlyUser', 'weeklyIncome', 'monthlyIncome', 'yearlyIncome', 'categories', 'admin', 'superstar']))->with('months', json_encode($months, JSON_NUMERIC_CHECK))->with('amountCount', json_encode($amountCount, JSON_NUMERIC_CHECK));
    }

    public function meetupEventsData($type)

    {
        if ($type == 'total') {
            $portalData = MeetupEvent::with(['star', 'category'])->where('category_id', auth()->user()->category_id)->get();
        } elseif ($type == 'running') {
            $portalData = MeetupEvent::with(['star', 'category'])->where('status', 2)->where('category_id', auth()->user()->category_id)->get();
        } else {
            $portalData = MeetupEvent::with(['star', 'category'])->where('status', 10)->where('category_id', auth()->user()->category_id)->get();
        }
        return view('ManagerAdmin.MeetupEvents.meetupEventsData', compact('portalData'));
    }
    public function meetupEventsDetails($id)
    {
        $totalParticipant = MeetupEventRegistration::where('meetup_event_id', $id)->where('payment_status', 1)->count();
        $totalFee = MeetupEventRegistration::where('meetup_event_id', $id)->where('payment_status', 1)->sum('amount');
        $data = MeetupEvent::with(['star', 'category'])->where('category_id', auth()->user()->category_id)->find($id);

        return view('ManagerAdmin.MeetupEvents.meetupEventsDetails', compact(['data', 'totalParticipant', 'totalFee']));
    }
    public function submeetupList($subcategoryId)
    {
        $postList = MeetupEvent::where('sub_category_id', $subcategoryId)->latest()->get();
        return view('ManagerAdmin.MeetupEvents.postList', compact('postList'));
    }

    public function meetupAdminList()
    {
        $admins = MeetupEvent::with('admin')->where('category_id', auth()->user()->category_id)->distinct()->whereNotNull('admin_id')->get(['admin_id']);
        return view('ManagerAdmin.MeetupEvents.Admin.admin', compact('admins'));
    }
    public function meetupAdminEvents($adminId)
    {
        $meetup = MeetupEvent::where('admin_id', $adminId)->latest()->get();
        return view('ManagerAdmin.MeetupEvents.Admin.admin_events', compact('meetup'));
    }
    public function meetupSuperstarList()
    {
        $superstars = MeetupEvent::with('star')->where('category_id', auth()->user()->category_id)->distinct()->whereNotNull('star_id')->get(['star_id']);
        return view('ManagerAdmin.MeetupEvents.Superstar.superstar', compact('superstars'));
    }
    public function meetupSuperstarEvents($starId)
    {
        $meetup = MeetupEvent::where('star_id', $starId)->latest()->get();
        return view('ManagerAdmin.MeetupEvents.Superstar.superstar_events', compact('meetup'));
    }

    public function simplePost()

    {

        $categories = SubCategory::with(['subSimplePosts'])->where('category_id', auth()->user()->category_id)->get();


        // Total
        $total = SimplePost::where('category_id', auth()->user()->category_id)->count();
        $upcoming = SimplePost::where('status', 0)->where('category_id', auth()->user()->category_id)->count();
        $complete = SimplePost::where('status', 1)->where('category_id', auth()->user()->category_id)->count();
        $admin = simplePost::distinct('admin_id')->where('category_id', auth()->user()->category_id)->count();
        $superstar = simplePost::distinct('star_id')->where('category_id', auth()->user()->category_id)->count();

        // Registered User
        $weeklyUser = GeneralPostPayment::whereHas('simpleposts', function ($q) {
            $q->where([['category_id', auth()->user()->category_id]]);
        })->where('created_at', '>', Carbon::now()->startOfWeek())->where('created_at', '<', Carbon::now()->endOfWeek())->count();
        $monthlyUser = GeneralPostPayment::whereHas('simpleposts', function ($q) {
            $q->where([['category_id', auth()->user()->category_id]]);
        })->where('created_at', '>', Carbon::now()->startOfMonth())->where('created_at', '<', Carbon::now()->endOfMonth())->count();
        $yearlyUser = GeneralPostPayment::whereHas('simpleposts', function ($q) {
            $q->where([['category_id', auth()->user()->category_id]]);
        })->where('created_at', '>', Carbon::now()->startOfYear())->where('created_at', '<', Carbon::now()->endOfYear())->count();

        // Income Statement
        $weeklyIncome = GeneralPostPayment::whereHas('simpleposts', function ($q) {
            $q->where([['category_id', auth()->user()->category_id]]);
        })->where('created_at', '>', Carbon::now()->startOfWeek())->where('created_at', '<', Carbon::now()->endOfWeek())->sum('amount');
        $monthlyIncome = GeneralPostPayment::whereHas('simpleposts', function ($q) {
            $q->where([['category_id', auth()->user()->category_id]]);
        })->where('created_at', '>', Carbon::now()->startOfMonth())->where('created_at', '<', Carbon::now()->endOfMonth())->sum('amount');
        $yearlyIncome = GeneralPostPayment::whereHas('simpleposts', function ($q) {
            $q->where([['category_id', auth()->user()->category_id]]);
        })->where('created_at', '>', Carbon::now()->startOfYear())->where('created_at', '<', Carbon::now()->endOfYear())->sum('amount');

        $labels = GeneralPostPayment::get(['id', 'created_at', 'amount'])->groupBy(function ($date) {
            return Carbon::parse($date->created_at)->format('M');
        });

        $months = [];
        $amountCount = [];
        foreach ($labels as $month => $values) {
            $months[] = $month;
            $amountCount[] = $values->sum('amount');
        }

        return view('ManagerAdmin.SimplePost.dashboard', compact(['total', 'upcoming', 'complete', 'weeklyUser', 'monthlyUser', 'yearlyUser', 'weeklyIncome', 'monthlyIncome', 'yearlyIncome', 'categories', 'admin', 'superstar']))->with('months', json_encode($months, JSON_NUMERIC_CHECK))->with('amountCount', json_encode($amountCount, JSON_NUMERIC_CHECK));
    }
    public function simplePostData($type)
    {
        if ($type == 'total') {
            $portalData = SimplePost::with(['star', 'category'])->where('category_id', auth()->user()->category_id)->get();
        } elseif ($type == 'upcoming') {
            $portalData = SimplePost::with(['star', 'category'])->where('status', 0)->where('category_id', auth()->user()->category_id)->get();
        } else {
            $portalData = SimplePost::with(['star', 'category'])->where('status', 1)->where('category_id', auth()->user()->category_id)->get();
        }
        return view('ManagerAdmin.SimplePost.simplePostData', compact('portalData'));
    }
    public function simplePostDetails($id)
    {
        $totalParticipant = GeneralPostPayment::where('post_id', $id)->where('status', 1)->count();
        $totalFee = GeneralPostPayment::where('post_id', $id)->where('status', 1)->sum('amount');
        $data = SimplePost::with(['star', 'category'])->where('category_id', auth()->user()->category_id)->find($id);

        return view('ManagerAdmin.SimplePost.simplePostDetails', compact(['data', 'totalParticipant', 'totalFee']));
    }
    public function subsimplepostList($subcategoryId)
    {
        $postList = SimplePost::where('subcategory_id', $subcategoryId)->latest()->get();
        return view('ManagerAdmin.SimplePost.postList', compact('postList'));
    }

    public function simplePostAdminList()
    {
        $admins = SimplePost::with('starAdmin')->where('category_id', auth()->user()->category_id)->distinct()->whereNotNull('admin_id')->get(['admin_id']);
        return view('ManagerAdmin.SimplePost.Admin.admin', compact('admins'));
    }
    public function simplePostAdminEvents($adminId)
    {
        $simplePost = SimplePost::where('admin_id', $adminId)->latest()->get();
        return view('ManagerAdmin.SimplePost.Admin.admin_events', compact('simplePost'));
    }
    public function simplePostSuperstarList()
    {
        $superstars = SimplePost::with('starPosts')->where('category_id', auth()->user()->category_id)->distinct()->whereNotNull('star_id')->get(['star_id']);
        return view('ManagerAdmin.SimplePost.Superstar.superstar', compact('superstars'));
    }
    public function simplePostSuperstarEvents($starId)
    {
        $simplePost = SimplePost::where('star_id', $starId)->latest()->get();
        return view('ManagerAdmin.SimplePost.Superstar.superstar_events', compact('simplePost'));
    }
    public function liveChats()
    {
        $categories = SubCategory::with(['subliveChat'])->where('category_id', auth()->user()->category_id)->get();
        // Total
        $total = LiveChat::where('category_id', auth()->user()->category_id)->count();
        $running = LiveChat::where('status', 2)->where('category_id', auth()->user()->category_id)->count();
        $complete = LiveChat::where('status', 10)->where('category_id', auth()->user()->category_id)->count();
        $admin = LiveChat::distinct('admin_id')->where('category_id', auth()->user()->category_id)->count();
        $superstar = LiveChat::distinct('star_id')->where('category_id', auth()->user()->category_id)->count();


        // Registered User

        $weeklyUser = LiveChatRegistration::whereHas('liveChat', function ($q) {
            $q->where([['category_id', auth()->user()->category_id]]);
        })->where('created_at', '>', Carbon::now()->startOfWeek())->where('created_at', '<', Carbon::now()->endOfWeek())->count();
        $monthlyUser = LiveChatRegistration::whereHas('liveChat', function ($q) {
            $q->where([['category_id', auth()->user()->category_id]]);
        })->where('created_at', '>', Carbon::now()->startOfMonth())->where('created_at', '<', Carbon::now()->endOfMonth())->count();
        $yearlyUser = LiveChatRegistration::whereHas('liveChat', function ($q) {
            $q->where([['category_id', auth()->user()->category_id]]);
        })->where('created_at', '>', Carbon::now()->startOfYear())->where('created_at', '<', Carbon::now()->endOfYear())->count();

        // Income Statement

        $weeklyIncome = LiveChatRegistration::whereHas('liveChat', function ($q) {
            $q->where([['category_id', auth()->user()->category_id]]);
        })->where('created_at', '>', Carbon::now()->startOfWeek())->where('created_at', '<', Carbon::now()->endOfWeek())->sum('amount');
        $monthlyIncome = LiveChatRegistration::whereHas('liveChat', function ($q) {
            $q->where([['category_id', auth()->user()->category_id]]);
        })->where('created_at', '>', Carbon::now()->startOfMonth())->where('created_at', '<', Carbon::now()->endOfMonth())->sum('amount');
        $yearlyIncome = LiveChatRegistration::whereHas('liveChat', function ($q) {
            $q->where([['category_id', auth()->user()->category_id]]);
        })->where('created_at', '>', Carbon::now()->startOfYear())->where('created_at', '<', Carbon::now()->endOfYear())->sum('amount');

        $labels = LiveChatRegistration::whereHas('liveChat', function ($q) {
            $q->where([['category_id', auth()->user()->category_id]]);
        })->get(['id', 'created_at', 'amount'])->groupBy(function ($date) {
            return Carbon::parse($date->created_at)->format('M');
        });

        $months = [];
        $amountCount = [];
        foreach ($labels as $month => $values) {
            $months[] = $month;
            $amountCount[] = $values->sum('amount');
        }

        return view('ManagerAdmin.LiveChat.dashboard', compact(['total', 'running', 'complete', 'weeklyUser', 'monthlyUser', 'yearlyUser', 'weeklyIncome', 'monthlyIncome', 'yearlyIncome', 'categories', 'admin', 'superstar']))->with('months', json_encode($months, JSON_NUMERIC_CHECK))->with('amountCount', json_encode($amountCount, JSON_NUMERIC_CHECK));;
    }
    public function liveChatsData($type)
    {
        if ($type == 'total') {
            $portalData = LiveChat::with(['star', 'category'])->where('category_id', auth()->user()->category_id)->get();
        } elseif ($type == 'running') {
            $portalData = LiveChat::with(['star', 'category'])->where('status', 2)->where('category_id', auth()->user()->category_id)->get();
        } else {
            $portalData = LiveChat::with(['star', 'category'])->where('status', 10)->where('category_id', auth()->user()->category_id)->get();
        }
        return view('ManagerAdmin.LiveChat.liveChatsData', compact('portalData'));
    }
    public function liveChatsDetails($id)
    {
        $totalParticipant = LiveChatRegistration::where('live_chat_id', $id)->where('payment_status', 1)->count();
        $totalFee = LiveChatRegistration::where('live_chat_id', $id)->where('payment_status', 1)->sum('amount');
        $data = LiveChat::with(['star', 'category'])->where('category_id', auth()->user()->category_id)->find($id);

        return view('ManagerAdmin.LiveChat.liveChatsDetails', compact(['totalParticipant', 'totalFee', 'data']));
    }
    public function subliveChatList($subcategoryId)
    {
        $postList = LiveChat::where('sub_category_id', $subcategoryId)->latest()->get();
        return view('ManagerAdmin.LiveChat.postList', compact('postList'));
    }

    public function liveChatAdminList()
    {
        $admins = LiveChat::with('admin')->where('category_id', auth()->user()->category_id)->distinct()->whereNotNull('admin_id')->get(['admin_id']);
        return view('ManagerAdmin.LiveChat.Admin.admin', compact('admins'));
    }
    public function liveChatAdminEvents($adminId)
    {
        $liveChat = LiveChat::where('admin_id', $adminId)->latest()->get();
        return view('ManagerAdmin.LiveChat.Admin.admin_events', compact('liveChat'));
    }
    public function liveChatSuperstarList()
    {
        $superstars = LiveChat::with('star')->where('category_id', auth()->user()->category_id)->distinct()->whereNotNull('star_id')->get(['star_id']);
        return view('ManagerAdmin.LiveChat.Superstar.superstar', compact('superstars'));
    }
    public function liveChatSuperstarEvents($starId)
    {
        $liveChat = LiveChat::where('star_id', $starId)->latest()->get();
        return view('ManagerAdmin.LiveChat.Superstar.superstar_events', compact('liveChat'));
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
    public function auditionsDetails($id)
    {

        $judges = AssignJudge::with('user')->where('audition_id', $id)->get();
        $totalJudge = AssignJudge::where('category_id', auth()->user()->category_id)->count();
        $totalJury = AssignJury::where('category_id', auth()->user()->category_id)->count();
        $totalParticipant = AuditionEventRegistration::where('audition_event_id', $id)->where('payment_status', 1)->count();
        $totalFee = AuditionEventRegistration::where('audition_event_id', $id)->where('payment_status', 1)->sum('amount');
        $data = Audition::with(['star', 'category'])->where('category_id', auth()->user()->category_id)->find($id);

        return view('ManagerAdmin.Audition.auditionsDetails', compact(['totalParticipant', 'totalFee', 'data', 'totalJudge', 'totalJury', 'judges']));
    }
    public function fanGroups()
    {

        $categories = SubCategory::with(['subfangroup'])->where('category_id', auth()->user()->category_id)->get();
        // $admin = FanGroup::distinct('admin_id')->where('category_id', auth()->user()->category_id)->count();
        // $superstar = FanGroup::distinct('star_id')->where('category_id', auth()->user()->category_id)->count();


        $total = FanGroup::where('category_id', auth()->user()->category_id)->count();
        $pending = FanGroup::where('status', 0)->where('category_id', auth()->user()->category_id)->count();
        $published = FanGroup::where('status', 1)->where('category_id', auth()->user()->category_id)->count();
        $totalFanPost = FanPost::whereHas('fangroup', function ($q) {
            $q->where([['category_id', auth()->user()->category_id]]);
        })->count();
        $totalUser = Fan_Group_Join::count();

        $weeklyUser = Fan_Group_Join::whereHas('fangroup', function ($q) {
            $q->where([['category_id', auth()->user()->category_id]]);
        })->distinct('user_id')->where('created_at', '>', Carbon::now()->startOfWeek())->where('created_at', '<', Carbon::now()->endOfWeek())->count();
        $monthlyUser = Fan_Group_Join::whereHas('fangroup', function ($q) {
            $q->where([['category_id', auth()->user()->category_id]]);
        })->distinct('user_id')->where('created_at', '>', Carbon::now()->startOfMonth())->where('created_at', '<', Carbon::now()->endOfMonth())->count();
        $yearlyUser = Fan_Group_Join::whereHas('fangroup', function ($q) {
            $q->where([['category_id', auth()->user()->category_id]]);
        })->distinct('user_id')->where('created_at', '>', Carbon::now()->startOfYear())->where('created_at', '<', Carbon::now()->endOfYear())->count();

        // $labels = FanGroup::get(['id', 'created_at', 'amount'])->groupBy(function ($date) {
        //     return Carbon::parse($date->created_at)->format('M');
        // });

        // $months = [];
        // $amountCount = [];
        // foreach ($labels as $month => $values) {
        //     $months[] = $month;
        //     $amountCount[] = $values->sum('amount');
        // }

        return view('ManagerAdmin.fangroup.dashboard', compact(['total', 'totalFanPost', 'totalUser', 'weeklyUser', 'monthlyUser', 'yearlyUser', 'categories', 'pending', 'published']));
    }
    public function fanGroupsData($type)
    {

        if ($type == 'total') {
            $portalData = FanGroup::with(['star', 'category'])->where('category_id', auth()->user()->category_id)->get();
        } elseif ($type == 'pending') {
            $portalData = FanGroup::with(['star', 'category'])->where('status', 0)->where('category_id', auth()->user()->category_id)->get();
        } elseif ($type == 'published') {
            $portalData = FanGroup::with(['star', 'category'])->where('status', 1)->where('category_id', auth()->user()->category_id)->get();
        } else {
            $portalData = FanGroup::with(['star', 'category'])->where('status', 1)->where('category_id', auth()->user()->category_id)->get();
        }

        return view('ManagerAdmin.fangroup.fanGroupData', compact('portalData'));
    }
    // public function fanGroupsPost()
    // {

    //     $portalData = FanPost::whereHas('fangroup', function ($q) {
    //         $q->where([['category_id', auth()->user()->category_id]]);
    //     })->get();

    //     return view('ManagerAdmin.fangroup.fanGroupData', compact('portalData'));
    // }

    public function fanGroupsDetails($id)
    {
        $data = FanGroup::with(['star', 'category'])->where('category_id', auth()->user()->category_id)->find($id);
        return view('ManagerAdmin.fangroup.fanGroupDetails', compact('data'));
    }
    public function subFanGroupList($subcategoryId)
    {
        $postList = FanGroup::where('sub_category_id', $subcategoryId)->latest()->get();
        return view('ManagerAdmin.fangroup.postList', compact('postList'));
    }

    public function fanGroupAdminList()
    {
        $admins = FanGroup::with('admin')->where('category_id', auth()->user()->category_id)->distinct()->whereNotNull('admin_id')->get(['admin_id']);
        return view('ManagerAdmin.fangroup.Admin.admin', compact('admins'));
    }
    public function fanGroupAdminEvents($adminId)
    {
        $fanGroup = FanGroup::where('admin_id', $adminId)->latest()->get();
        return view('ManagerAdmin.fangroup.Admin.admin_events', compact('fanGroup'));
    }
    public function fanGroupSuperstarList()
    {
        $superstars = FanGroup::with('star')->where('category_id', auth()->user()->category_id)->distinct()->whereNotNull('star_id')->get(['star_id']);
        return view('ManagerAdmin.fangroup.Superstar.superstar', compact('superstars'));
    }
    public function fanGroupSuperstarEvents($starId)
    {
        $fanGroup = FanGroup::where('star_id', $starId)->latest()->get();
        return view('ManagerAdmin.fangroup.Superstar.superstar_events', compact('fanGroup'));
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

    public function qna()
    {
        $categories = SubCategory::with(['subqna'])->where('category_id', auth()->user()->category_id)->get();
        // Total
        $total = Qna::where('category_id', auth()->user()->category_id)->count();
        $running = Qna::where('status', 2)->where('category_id', auth()->user()->category_id)->count();
        $complete = Qna::where('status', 10)->where('category_id', auth()->user()->category_id)->count();
        $admin = Qna::distinct('admin_id')->where('category_id', auth()->user()->category_id)->count();
        $superstar = Qna::distinct('star_id')->where('category_id', auth()->user()->category_id)->count();


        // Registered User

        $weeklyUser = QnaRegistration::whereHas('qna', function ($q) {
            $q->where([['category_id', auth()->user()->category_id]]);
        })->where('payment_status', 1)->where('created_at', '>', Carbon::now()->startOfWeek())->where('created_at', '<', Carbon::now()->endOfWeek())->count();
        $monthlyUser = QnaRegistration::whereHas('qna', function ($q) {
            $q->where([['category_id', auth()->user()->category_id]]);
        })->where('created_at', '>', Carbon::now()->startOfMonth())->where('created_at', '<', Carbon::now()->endOfMonth())->count();
        $yearlyUser = QnaRegistration::whereHas('qna', function ($q) {
            $q->where([['category_id', auth()->user()->category_id]]);
        })->where('created_at', '>', Carbon::now()->startOfYear())->where('created_at', '<', Carbon::now()->endOfYear())->count();

        // Income Statement

        $weeklyIncome = QnaRegistration::whereHas('qna', function ($q) {
            $q->where([['category_id', auth()->user()->category_id]]);
        })->where('created_at', '>', Carbon::now()->startOfWeek())->where('created_at', '<', Carbon::now()->endOfWeek())->sum('amount');
        $monthlyIncome = QnaRegistration::whereHas('qna', function ($q) {
            $q->where([['category_id', auth()->user()->category_id]]);
        })->where('created_at', '>', Carbon::now()->startOfMonth())->where('created_at', '<', Carbon::now()->endOfMonth())->sum('amount');
        $yearlyIncome = QnaRegistration::whereHas('qna', function ($q) {
            $q->where([['category_id', auth()->user()->category_id]]);
        })->where('created_at', '>', Carbon::now()->startOfYear())->where('created_at', '<', Carbon::now()->endOfYear())->sum('amount');

        $labels = QnaRegistration::whereHas('qna', function ($q) {
            $q->where([['category_id', auth()->user()->category_id]]);
        })->get(['id', 'created_at', 'amount'])->groupBy(function ($date) {
            return Carbon::parse($date->created_at)->format('M');
        });

        $months = [];
        $amountCount = [];
        foreach ($labels as $month => $values) {
            $months[] = $month;
            $amountCount[] = $values->sum('amount');
        }

        return view('ManagerAdmin.QnA.dashboard', compact(['total', 'running', 'complete', 'weeklyUser', 'monthlyUser', 'yearlyUser', 'weeklyIncome', 'monthlyIncome', 'yearlyIncome', 'categories', 'admin', 'superstar']))->with('months', json_encode($months, JSON_NUMERIC_CHECK))->with('amountCount', json_encode($amountCount, JSON_NUMERIC_CHECK));
    }
    public function qnaData($type)
    {
        if ($type == 'total') {
            $portalData = QnA::with(['star', 'category'])->where('category_id', auth()->user()->category_id)->get();
        } elseif ($type == 'running') {
            $portalData = Qna::with(['star', 'category'])->where('status', 2)->where('category_id', auth()->user()->category_id)->get();
        } else {
            $portalData = Qna::with(['star', 'category'])->where('status', 10)->where('category_id', auth()->user()->category_id)->get();
        }
        return view('ManagerAdmin.QnA.qnaData', compact('portalData'));
    }
    public function qnaDetails($id)
    {
        $totalParticipant = QnaRegistration::where('qna_id', $id)->where('payment_status', 1)->count();
        $totalFee = QnaRegistration::where('qna_id', $id)->where('payment_status', 1)->sum('amount');
        $data = Qna::with(['star', 'category'])->where('category_id', auth()->user()->category_id)->find($id);

        return view('ManagerAdmin.QnA.qnaDetails', compact(['totalParticipant', 'totalFee', 'data']));
    }
    public function subqnaList($subcategoryId)
    {
        $postList = Qna::where('sub_category_id', $subcategoryId)->latest()->get();
        return view('ManagerAdmin.QnA.postList', compact('postList'));
    }

    public function qnaAdminList()
    {
        $admins = Qna::with('admin')->where('category_id', auth()->user()->category_id)->distinct()->whereNotNull('admin_id')->get(['admin_id']);
        return view('ManagerAdmin.QnA.Admin.admin', compact('admins'));
    }
    public function qnaAdminEvents($adminId)
    {
        $qna = Qna::where('admin_id', $adminId)->latest()->get();
        return view('ManagerAdmin.QnA.Admin.admin_events', compact('qna'));
    }
    public function qnaSuperstarList()
    {
        $superstars = Qna::with('star')->where('category_id', auth()->user()->category_id)->distinct()->whereNotNull('star_id')->get(['star_id']);
        return view('ManagerAdmin.QnA.Superstar.superstar', compact('superstars'));
    }
    public function qnaSuperstarEvents($starId)
    {
        $qna = Qna::where('star_id', $starId)->latest()->get();
        return view('ManagerAdmin.QnA.Superstar.superstar_events', compact('qna'));
    }

    // Greeting

    public function greeting()
    {
        $categories = SubCategory::with(['subgreeting'])->where('category_id', auth()->user()->category_id)->get();
        // Total
        $total = Greeting::where('category_id', auth()->user()->category_id)->count();
        $upcoming = Greeting::where('status', 1)->where('category_id', auth()->user()->category_id)->count();
        $complete = Greeting::where('status', 2)->where('category_id', auth()->user()->category_id)->count();
        $admin = Greeting::distinct('admin_id')->where('category_id', auth()->user()->category_id)->count();
        $superstar = Greeting::distinct('star_id')->where('category_id', auth()->user()->category_id)->count();


        // Registered User

        $weeklyUser = GreetingsRegistration::whereHas('greeting', function ($q) {
            $q->where([['category_id', auth()->user()->category_id]]);
        })->where('created_at', '>', Carbon::now()->startOfWeek())->where('created_at', '<', Carbon::now()->endOfWeek())->count();
        $monthlyUser = GreetingsRegistration::whereHas('greeting', function ($q) {
            $q->where([['category_id', auth()->user()->category_id]]);
        })->where('created_at', '>', Carbon::now()->startOfMonth())->where('created_at', '<', Carbon::now()->endOfMonth())->count();
        $yearlyUser = GreetingsRegistration::whereHas('greeting', function ($q) {
            $q->where([['category_id', auth()->user()->category_id]]);
        })->where('created_at', '>', Carbon::now()->startOfYear())->where('created_at', '<', Carbon::now()->endOfYear())->count();

        // Income Statement

        $weeklyIncome = GreetingsRegistration::whereHas('greeting', function ($q) {
            $q->where([['category_id', auth()->user()->category_id]]);
        })->where('created_at', '>', Carbon::now()->startOfWeek())->where('created_at', '<', Carbon::now()->endOfWeek())->sum('amount');
        $monthlyIncome = GreetingsRegistration::whereHas('greeting', function ($q) {
            $q->where([['category_id', auth()->user()->category_id]]);
        })->where('created_at', '>', Carbon::now()->startOfMonth())->where('created_at', '<', Carbon::now()->endOfMonth())->sum('amount');
        $yearlyIncome = GreetingsRegistration::whereHas('greeting', function ($q) {
            $q->where([['category_id', auth()->user()->category_id]]);
        })->where('created_at', '>', Carbon::now()->startOfYear())->where('created_at', '<', Carbon::now()->endOfYear())->sum('amount');

        $labels = GreetingsRegistration::whereHas('greeting', function ($q) {
            $q->where([['category_id', auth()->user()->category_id]]);
        })->get(['id', 'created_at', 'amount'])->groupBy(function ($date) {
            return Carbon::parse($date->created_at)->format('M');
        });

        $months = [];
        $amountCount = [];
        foreach ($labels as $month => $values) {
            $months[] = $month;
            $amountCount[] = $values->sum('amount');
        }

        return view('ManagerAdmin.greeting.dashboard', compact(['total', 'upcoming', 'complete', 'weeklyUser', 'monthlyUser', 'yearlyUser', 'weeklyIncome', 'monthlyIncome', 'yearlyIncome', 'categories', 'admin', 'superstar']))->with('months', json_encode($months, JSON_NUMERIC_CHECK))->with('amountCount', json_encode($amountCount, JSON_NUMERIC_CHECK));
    }
    public function greetingData($type)
    {
        if ($type == 'total') {
            $portalData = Greeting::with(['star', 'category'])->where('category_id', auth()->user()->category_id)->get();
        } elseif ($type == 'upcoming') {
            $portalData = Greeting::with(['star', 'category'])->where('status', 1)->where('category_id', auth()->user()->category_id)->get();
        } else {
            $portalData = Greeting::with(['star', 'category'])->where('status', 2)->where('category_id', auth()->user()->category_id)->get();
        }
        return view('ManagerAdmin.greeting.greetingData', compact('portalData'));
    }
    public function greetingDetails($id)
    {
        $totalParticipant = GreetingsRegistration::where('greeting_id', $id)->where('payment_status', 1)->count();
        $totalFee = GreetingsRegistration::where('greeting_id', $id)->where('payment_status', 1)->sum('amount');
        $data = Greeting::with(['star', 'category'])->where('category_id', auth()->user()->category_id)->find($id);

        return view('ManagerAdmin.greeting.show', compact(['totalParticipant', 'totalFee', 'data']));
    }
    public function subgreetingList($subcategoryId)
    {
        $postList = Greeting::where('sub_category_id', $subcategoryId)->latest()->get();
        return view('ManagerAdmin.greeting.postList', compact('postList'));
    }

    public function greetingAdminList()
    {
        $admins = Greeting::with('admin')->where('category_id', auth()->user()->category_id)->distinct()->whereNotNull('admin_id')->get(['admin_id']);
        return view('ManagerAdmin.greeting.Admin.admin', compact('admins'));
    }
    public function greetingAdminEvents($adminId)
    {
        $greeting = Greeting::where('admin_id', $adminId)->latest()->get();
        return view('ManagerAdmin.greeting.Admin.admin_events', compact('greeting'));
    }
    public function greetingSuperstarList()
    {
        $superstars = Greeting::with('star')->where('category_id', auth()->user()->category_id)->distinct()->whereNotNull('star_id')->get(['star_id']);
        return view('ManagerAdmin.greeting.Superstar.superstar', compact('superstars'));
    }
    public function greetingSuperstarEvents($starId)
    {
        $greeting = Greeting::where('star_id', $starId)->latest()->get();
        return view('ManagerAdmin.greeting.Superstar.superstar_events', compact('greeting'));
    }

    // Auction

    public function auction()
    {
        $categories = SubCategory::with(['subauction'])->where('category_id', auth()->user()->category_id)->get();
        // Total
        $total = Auction::where('category_id', auth()->user()->category_id)->count();
        $running = Auction::where('status', 1)->where('product_status', 0)->where('category_id', auth()->user()->category_id)->count();
        $complete = Auction::where('product_status', 1)->where('category_id', auth()->user()->category_id)->count();
        $admin = Auction::distinct('admin_id')->where('category_id', auth()->user()->category_id)->count();
        $superstar = Auction::distinct('star_id')->where('category_id', auth()->user()->category_id)->count();


        // Registered User

        $weeklyUser = Bidding::whereHas('auction', function ($q) {
            $q->where([['category_id', auth()->user()->category_id]]);
        })->distinct('user_id')->where('created_at', '>', Carbon::now()->startOfWeek())->where('created_at', '<', Carbon::now()->endOfWeek())->count();
        $monthlyUser = Bidding::whereHas('auction', function ($q) {
            $q->where([['category_id', auth()->user()->category_id]]);
        })->distinct('user_id')->where('created_at', '>', Carbon::now()->startOfMonth())->where('created_at', '<', Carbon::now()->endOfMonth())->count();
        $yearlyUser = Bidding::whereHas('auction', function ($q) {
            $q->where([['category_id', auth()->user()->category_id]]);
        })->distinct('user_id')->where('created_at', '>', Carbon::now()->startOfYear())->where('created_at', '<', Carbon::now()->endOfYear())->count();

        // Income Statement

        $weeklyIncome = Bidding::whereHas('auction', function ($q) {
            $q->where([['category_id', auth()->user()->category_id]]);
        })->where('win_status', 1)->where('created_at', '>', Carbon::now()->startOfWeek())->where('created_at', '<', Carbon::now()->endOfWeek())->distinct()->get('amount')->sum('amount');
        $monthlyIncome = Bidding::whereHas('auction', function ($q) {
            $q->where([['category_id', auth()->user()->category_id]]);
        })->where('win_status', 1)->where('created_at', '>', Carbon::now()->startOfMonth())->where('created_at', '<', Carbon::now()->endOfMonth())->distinct()->get('amount')->sum('amount');
        $yearlyIncome = Bidding::whereHas('auction', function ($q) {
            $q->where([['category_id', auth()->user()->category_id]]);
        })->where('win_status', 1)->where('created_at', '>', Carbon::now()->startOfYear())->where('created_at', '<', Carbon::now()->endOfYear())->distinct()->get('amount')->sum('amount');

        $labels = Bidding::whereHas('auction', function ($q) {
            $q->where([['category_id', auth()->user()->category_id]]);
        })->where('win_status', 1)->get(['id', 'created_at', 'amount'])->groupBy(function ($date) {
            return Carbon::parse($date->created_at)->format('M');
        });

        $months = [];
        $amountCount = [];
        foreach ($labels as $month => $values) {
            $months[] = $month;
            $amountCount[] = $values->sum('amount');
        }

        return view('ManagerAdmin.Auction.dashboard', compact(['total', 'running', 'complete', 'weeklyUser', 'monthlyUser', 'yearlyUser', 'weeklyIncome', 'monthlyIncome', 'yearlyIncome', 'categories', 'admin', 'superstar']))->with('months', json_encode($months, JSON_NUMERIC_CHECK))->with('amountCount', json_encode($amountCount, JSON_NUMERIC_CHECK));
    }
    public function auctionData($type)
    {
        if ($type == 'total') {
            $portalData = Auction::with(['star', 'category'])->where('category_id', auth()->user()->category_id)->get();
        } elseif ($type == 'running') {
            $portalData = Auction::with(['star', 'category'])->where('status', 1)->where('product_status', 0)->where('category_id', auth()->user()->category_id)->get();
        } else {
            $portalData = Auction::with(['star', 'category'])->where('product_status', 1)->where('category_id', auth()->user()->category_id)->get();
        }
        return view('ManagerAdmin.Auction.auctionData', compact('portalData'));
    }

    public function subauctionList($subcategoryId)
    {
        $postList = Auction::where('subcategory_id', $subcategoryId)->latest()->get();
        return view('ManagerAdmin.Auction.postList', compact('postList'));
    }

    public function auctionAdminList()
    {
        $admins = Auction::with('admin')->where('category_id', auth()->user()->category_id)->distinct()->whereNotNull('admin_id')->get(['admin_id']);
        return view('ManagerAdmin.Auction.Admin.admin', compact('admins'));
    }
    public function auctionAdminEvents($adminId)
    {
        $auction = Auction::where('admin_id', $adminId)->latest()->get();
        return view('ManagerAdmin.Auction.Admin.admin_events', compact('auction'));
    }
    public function auctionSuperstarList()
    {
        $superstars = Auction::with('star')->where('category_id', auth()->user()->category_id)->distinct()->whereNotNull('star_id')->get(['star_id']);
        return view('ManagerAdmin.Auction.Superstar.superstar', compact('superstars'));
    }
    public function auctionSuperstarEvents($starId)
    {
        $auction = Auction::where('star_id', $starId)->latest()->get();
        return view('ManagerAdmin.Auction.Superstar.superstar_events', compact('auction'));
    }

    // Marketplace

    public function marketplace()
    {
        $categories = SubCategory::with(['submarketplace'])->where('category_id', auth()->user()->category_id)->get();

        // Total
        $total = Marketplace::where('category_id', auth()->user()->category_id)->sum('total_items');
        $soldItem = Marketplace::where('status', 1)->where('category_id', auth()->user()->category_id)->sum('total_selling');

        $admin = Marketplace::distinct('superstar_admin_id')->where('category_id', auth()->user()->category_id)->count();
        $superstar = Marketplace::distinct('superstar_id')->where('category_id', auth()->user()->category_id)->count();


        // Registered User

        $weeklyUser = MarketplaceOrder::whereHas('marketplace', function ($q) {
            $q->where([['category_id', auth()->user()->category_id]]);
        })->distinct('user_id')->where('created_at', '>', Carbon::now()->startOfWeek())->where('created_at', '<', Carbon::now()->endOfWeek())->count();
        $monthlyUser = MarketplaceOrder::whereHas('marketplace', function ($q) {
            $q->where([['category_id', auth()->user()->category_id]]);
        })->distinct('user_id')->where('created_at', '>', Carbon::now()->startOfMonth())->where('created_at', '<', Carbon::now()->endOfMonth())->count();
        $yearlyUser = MarketplaceOrder::whereHas('marketplace', function ($q) {
            $q->where([['category_id', auth()->user()->category_id]]);
        })->distinct('user_id')->where('created_at', '>', Carbon::now()->startOfYear())->where('created_at', '<', Carbon::now()->endOfYear())->count();

        // Income Statement

        $weeklyIncome = MarketplaceOrder::whereHas('marketplace', function ($q) {
            $q->where([['category_id', auth()->user()->category_id]]);
        })->where('created_at', '>', Carbon::now()->startOfWeek())->where('created_at', '<', Carbon::now()->endOfWeek())->sum('total_price');
        $monthlyIncome = MarketplaceOrder::whereHas('marketplace', function ($q) {
            $q->where([['category_id', auth()->user()->category_id]]);
        })->where('created_at', '>', Carbon::now()->startOfMonth())->where('created_at', '<', Carbon::now()->endOfMonth())->sum('total_price');
        $yearlyIncome = MarketplaceOrder::whereHas('marketplace', function ($q) {
            $q->where([['category_id', auth()->user()->category_id]]);
        })->where('created_at', '>', Carbon::now()->startOfYear())->where('created_at', '<', Carbon::now()->endOfYear())->sum('total_price');

        $labels = MarketplaceOrder::whereHas('marketplace', function ($q) {
            $q->where([['category_id', auth()->user()->category_id]]);
        })->get(['id', 'created_at', 'total_price'])->groupBy(function ($date) {
            return Carbon::parse($date->created_at)->format('M');
        });

        $months = [];
        $amountCount = [];
        foreach ($labels as $month => $values) {
            $months[] = $month;
            $amountCount[] = $values->sum('total_price');
        }

        return view('ManagerAdmin.marketplace.dashboard', compact(['total', 'soldItem', 'weeklyUser', 'monthlyUser', 'yearlyUser', 'weeklyIncome', 'monthlyIncome', 'yearlyIncome', 'categories', 'admin', 'superstar']))->with('months', json_encode($months, JSON_NUMERIC_CHECK))->with('amountCount', json_encode($amountCount, JSON_NUMERIC_CHECK));
    }
    public function marketplaceData($type)
    {
        if ($type == 'total') {
            $portalData = Marketplace::with(['superstar', 'category'])->where('category_id', auth()->user()->category_id)->get();
        } elseif ($type == 'instock') {
            $portalData = Marketplace::with(['superstar', 'category'])->where('total_items', '>', 0)->where('category_id', auth()->user()->category_id)->get();
        } else {
            $portalData = Marketplace::with(['superstar', 'category'])->where('total_items', '>', 0)->where('category_id', auth()->user()->category_id)->get();
        }
        return view('ManagerAdmin.marketplace.marketplaceData', compact('portalData'));
    }

    public function submarketplaceList($subcategoryId)
    {
        $postList = Marketplace::where('subcategory_id', $subcategoryId)->latest()->get();
        return view('ManagerAdmin.marketplace.postList', compact('postList'));
    }

    public function marketplaceAdminList()
    {
        $admins = Marketplace::with('starAdmin')->where('category_id', auth()->user()->category_id)->distinct()->whereNotNull('superstar_admin_id')->get(['superstar_admin_id']);
        return view('ManagerAdmin.marketplace.Admin.admin', compact('admins'));
    }
    public function marketplaceAdminEvents($adminId)
    {
        $marketplace = Marketplace::where('superstar_admin_id', $adminId)->latest()->get();
        return view('ManagerAdmin.marketplace.Admin.admin_events', compact('marketplace'));
    }
    public function marketplaceSuperstarList()
    {
        $superstars = Marketplace::with('superstar')->where('category_id', auth()->user()->category_id)->distinct()->whereNotNull('superstar_id')->get(['superstar_id']);
        return view('ManagerAdmin.marketplace.Superstar.superstar', compact('superstars'));
    }
    public function marketplaceSuperstarEvents($starId)
    {
        $marketplace = Marketplace::where('superstar_id', $starId)->latest()->get();
        return view('ManagerAdmin.marketplace.Superstar.superstar_events', compact('marketplace'));
    }


    // Souvenir 

    public function souvenir()
    {
        $categories = SubCategory::with(['subsouvenir'])->where('category_id', auth()->user()->category_id)->get();

        // Total
        $total = SouvenirCreate::where('category_id', auth()->user()->category_id)->count();
        $available = SouvenirCreate::where('status', 1)->where('category_id', auth()->user()->category_id)->count();
        $notAvailable = SouvenirCreate::where('status', 0)->where('category_id', auth()->user()->category_id)->count();

        $admin = SouvenirCreate::distinct('admin_id')->where('category_id', auth()->user()->category_id)->count();
        $superstar = SouvenirCreate::distinct('star_id')->where('category_id', auth()->user()->category_id)->count();


        // Registered User

        $weeklyUser = SouvenirApply::whereHas('souvenir', function ($q) {
            $q->where([['category_id', auth()->user()->category_id]]);
        })->distinct('user_id')->where('created_at', '>', Carbon::now()->startOfWeek())->where('created_at', '<', Carbon::now()->endOfWeek())->count();
        $monthlyUser = SouvenirApply::whereHas('souvenir', function ($q) {
            $q->where([['category_id', auth()->user()->category_id]]);
        })->distinct('user_id')->where('created_at', '>', Carbon::now()->startOfMonth())->where('created_at', '<', Carbon::now()->endOfMonth())->count();
        $yearlyUser = SouvenirApply::whereHas('souvenir', function ($q) {
            $q->where([['category_id', auth()->user()->category_id]]);
        })->distinct('user_id')->where('created_at', '>', Carbon::now()->startOfYear())->where('created_at', '<', Carbon::now()->endOfYear())->count();

        // Income Statement

        $weeklyIncome = SouvenirApply::whereHas('souvenir', function ($q) {
            $q->where([['category_id', auth()->user()->category_id]]);
        })->where('created_at', '>', Carbon::now()->startOfWeek())->where('created_at', '<', Carbon::now()->endOfWeek())->sum('total_amount');
        $monthlyIncome = SouvenirApply::whereHas('souvenir', function ($q) {
            $q->where([['category_id', auth()->user()->category_id]]);
        })->where('created_at', '>', Carbon::now()->startOfMonth())->where('created_at', '<', Carbon::now()->endOfMonth())->sum('total_amount');
        $yearlyIncome = SouvenirApply::whereHas('souvenir', function ($q) {
            $q->where([['category_id', auth()->user()->category_id]]);
        })->where('created_at', '>', Carbon::now()->startOfYear())->where('created_at', '<', Carbon::now()->endOfYear())->sum('total_amount');

        $labels = SouvenirApply::whereHas('souvenir', function ($q) {
            $q->where([['category_id', auth()->user()->category_id]]);
        })->get(['id', 'created_at', 'total_amount'])->groupBy(function ($date) {
            return Carbon::parse($date->created_at)->format('M');
        });

        $months = [];
        $amountCount = [];
        foreach ($labels as $month => $values) {
            $months[] = $month;
            $amountCount[] = $values->sum('total_amount');
        }

        return view('ManagerAdmin.souvenir.dashboard', compact(['total', 'available', 'notAvailable', 'weeklyUser', 'monthlyUser', 'yearlyUser', 'weeklyIncome', 'monthlyIncome', 'yearlyIncome', 'categories', 'admin', 'superstar']))->with('months', json_encode($months, JSON_NUMERIC_CHECK))->with('amountCount', json_encode($amountCount, JSON_NUMERIC_CHECK));
    }
    public function souvenirData($type)
    {
        if ($type == 'total') {
            $portalData = SouvenirCreate::with(['star', 'category'])->where('category_id', auth()->user()->category_id)->get();
        } elseif ($type == 'available') {
            $portalData = SouvenirCreate::with(['star', 'category'])->where('status', 1)->where('category_id', auth()->user()->category_id)->get();
        } else {
            $portalData = SouvenirCreate::with(['star', 'category'])->where('status', 0)->where('category_id', auth()->user()->category_id)->get();
        }
        return view('ManagerAdmin.souvenir.souvenirData', compact('portalData'));
    }

    public function subsouvenirList($subcategoryId)
    {
        $postList = SouvenirCreate::where('sub_category_id', $subcategoryId)->latest()->get();
        return view('ManagerAdmin.souvenir.postList', compact('postList'));
    }

    public function souvenirAdminList()
    {
        $admins = SouvenirCreate::with('admin')->where('category_id', auth()->user()->category_id)->distinct()->whereNotNull('admin_id')->get(['admin_id']);
        return view('ManagerAdmin.souvenir.Admin.admin', compact('admins'));
    }
    public function souvenirAdminEvents($adminId)
    {
        $souvenir = SouvenirCreate::where('admin_id', $adminId)->latest()->get();
        return view('ManagerAdmin.souvenir.Admin.admin_events', compact('souvenir'));
    }
    public function souvenirSuperstarList()
    {
        $superstars = SouvenirCreate::with('star')->where('category_id', auth()->user()->category_id)->distinct()->whereNotNull('star_id')->get(['star_id']);
        return view('ManagerAdmin.souvenir.Superstar.superstar', compact('superstars'));
    }
    public function souvenirSuperstarEvents($starId)
    {
        $souvenir = SouvenirCreate::where('star_id', $starId)->latest()->get();
        return view('ManagerAdmin.souvenir.Superstar.superstar_events', compact('souvenir'));
    }
}
