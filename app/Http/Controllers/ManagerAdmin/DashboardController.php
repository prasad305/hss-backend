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
use App\Models\GeneralPostPayment;
use App\Models\Greeting;
use App\Models\JuryBoard;
use App\Models\LearningSession;
use App\Models\LearningSessionRegistration;
use App\Models\LiveChat;
use App\Models\LiveChatRegistration;
use App\Models\Marketplace;
use App\Models\MeetupEvent;
use App\Models\MeetupEventRegistration;
use App\Models\QnA;
use App\Models\QnaRegistration;
use App\Models\SimplePost;
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
        $upcoming = LearningSession::where('status', 0)->where('category_id', auth()->user()->category_id)->count();
        $complete = LearningSession::where('status', 10)->where('category_id', auth()->user()->category_id)->count();
        $admin = LearningSession::distinct('admin_id')->where('category_id', auth()->user()->category_id)->count();
        $superstar = LearningSession::distinct('star_id')->where('category_id', auth()->user()->category_id)->count();


        // Registered User

        $weeklyUser = LearningSessionRegistration::where('payment_status', 1)->where('created_at', '>', Carbon::now()->startOfWeek())->where('created_at', '<', Carbon::now()->endOfWeek())->count();
        $monthlyUser = LearningSessionRegistration::where('created_at', '>', Carbon::now()->startOfMonth())->where('created_at', '<', Carbon::now()->endOfMonth())->count();
        $yearlyUser = LearningSessionRegistration::where('created_at', '>', Carbon::now()->startOfYear())->where('created_at', '<', Carbon::now()->endOfYear())->count();

        // Income Statement

        $weeklyIncome = LearningSessionRegistration::where('created_at', '>', Carbon::now()->startOfWeek())->where('created_at', '<', Carbon::now()->endOfWeek())->sum('amount');
        $monthlyIncome = LearningSessionRegistration::where('created_at', '>', Carbon::now()->startOfMonth())->where('created_at', '<', Carbon::now()->endOfMonth())->sum('amount');
        $yearlyIncome = LearningSessionRegistration::where('created_at', '>', Carbon::now()->startOfYear())->where('created_at', '<', Carbon::now()->endOfYear())->sum('amount');

        $labels = ['January', 'February', 'March', 'April', 'May', 'June', 'July'];
        $data = [];
        foreach ($labels as $key => $value) {
            $data[] = LearningSessionRegistration::where('created_at', '>', Carbon::now()->startOfMonth())->where('created_at', '<', Carbon::now()->endOfMonth())->sum('amount');
        }


        return view('ManagerAdmin.LearningSession.dashboard', compact(['total', 'upcoming', 'complete', 'weeklyUser', 'monthlyUser', 'yearlyUser', 'weeklyIncome', 'monthlyIncome', 'yearlyIncome', 'categories', 'admin', 'superstar']))->with('labels', json_encode($labels, JSON_NUMERIC_CHECK))->with('data', json_encode($data, JSON_NUMERIC_CHECK));
    }
    public function learninSessionData($type)
    {

        if ($type == 'total') {
            $portalData = LearningSession::with(['star', 'category'])->orderBy('id', 'DESC')->where('category_id', auth()->user()->category_id)->get();
        } elseif ($type == 'upcoming') {
            $portalData = LearningSession::with(['star', 'category'])->where('status', 0)->where('category_id', auth()->user()->category_id)->get();
        } else {
            $portalData = LearningSession::with(['star', 'category'])->where('status', 10)->where('category_id', auth()->user()->category_id)->get();
        }

        return view('ManagerAdmin.LearningSession.learningSessionData', compact('portalData'));
    }
    public function learninSessionDetails($id)
    {
        $totalParticipant = LearningSessionRegistration::where('learning_session_id', $id)->where('payment_status', 1)->count();
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
    public function meetupEventsDetails($id)
    {
        $totalParticipant = MeetupEventRegistration::where('meetup_event_id', $id)->where('payment_status', 1)->count();
        $totalFee = MeetupEventRegistration::where('meetup_event_id', $id)->where('payment_status', 1)->sum('amount');
        $data = MeetupEvent::with(['star', 'category'])->where('category_id', auth()->user()->category_id)->find($id);

        return view('ManagerAdmin.MeetupEvents.meetupEventsDetails', compact(['data', 'totalParticipant', 'totalFee']));
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
        $weeklyUser = GeneralPostPayment::where('status', 1)->where('created_at', '>', Carbon::now()->startOfWeek())->where('created_at', '<', Carbon::now()->endOfWeek())->count();
        $monthlyUser = GeneralPostPayment::where('created_at', '>', Carbon::now()->startOfMonth())->where('created_at', '<', Carbon::now()->endOfMonth())->count();
        $yearlyUser = GeneralPostPayment::where('created_at', '>', Carbon::now()->startOfYear())->where('created_at', '<', Carbon::now()->endOfYear())->count();

        // Income Statement
        $weeklyIncome = GeneralPostPayment::where('created_at', '>', Carbon::now()->startOfWeek())->where('created_at', '<', Carbon::now()->endOfWeek())->sum('amount');
        $monthlyIncome = GeneralPostPayment::where('created_at', '>', Carbon::now()->startOfMonth())->where('created_at', '<', Carbon::now()->endOfMonth())->sum('amount');
        $yearlyIncome = GeneralPostPayment::where('created_at', '>', Carbon::now()->startOfYear())->where('created_at', '<', Carbon::now()->endOfYear())->sum('amount');
        return view('ManagerAdmin.SimplePost.dashboard', compact(['total', 'upcoming', 'complete', 'weeklyUser', 'monthlyUser', 'yearlyUser', 'weeklyIncome', 'monthlyIncome', 'yearlyIncome', 'categories', 'admin', 'superstar']));
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
        $upcoming = LiveChat::where('status', 0)->where('category_id', auth()->user()->category_id)->count();
        $complete = LiveChat::where('status', 10)->where('category_id', auth()->user()->category_id)->count();
        $admin = LiveChat::distinct('admin_id')->where('category_id', auth()->user()->category_id)->count();
        $superstar = LiveChat::distinct('star_id')->where('category_id', auth()->user()->category_id)->count();


        // Registered User

        $weeklyUser = LiveChatRegistration::where('payment_status', 1)->where('created_at', '>', Carbon::now()->startOfWeek())->where('created_at', '<', Carbon::now()->endOfWeek())->count();
        $monthlyUser = LiveChatRegistration::where('created_at', '>', Carbon::now()->startOfMonth())->where('created_at', '<', Carbon::now()->endOfMonth())->count();
        $yearlyUser = LiveChatRegistration::where('created_at', '>', Carbon::now()->startOfYear())->where('created_at', '<', Carbon::now()->endOfYear())->count();

        // Income Statement

        $weeklyIncome = LiveChatRegistration::where('created_at', '>', Carbon::now()->startOfWeek())->where('created_at', '<', Carbon::now()->endOfWeek())->sum('amount');
        $monthlyIncome = LiveChatRegistration::where('created_at', '>', Carbon::now()->startOfMonth())->where('created_at', '<', Carbon::now()->endOfMonth())->sum('amount');
        $yearlyIncome = LiveChatRegistration::where('created_at', '>', Carbon::now()->startOfYear())->where('created_at', '<', Carbon::now()->endOfYear())->sum('amount');
        return view('ManagerAdmin.LiveChat.dashboard', compact(['total', 'upcoming', 'complete', 'weeklyUser', 'monthlyUser', 'yearlyUser', 'weeklyIncome', 'monthlyIncome', 'yearlyIncome', 'categories', 'admin', 'superstar']));
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

    public function fanGroupsDetails($id)
    {
        $data = FanGroup::with(['star', 'category'])->where('category_id', auth()->user()->category_id)->find($id);
        return view('ManagerAdmin.fangroup.fanGroupDetails', compact('data'));
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
        $upcoming = Qna::where('status', 0)->where('category_id', auth()->user()->category_id)->count();
        $complete = Qna::where('status', 10)->where('category_id', auth()->user()->category_id)->count();
        $admin = Qna::distinct('admin_id')->where('category_id', auth()->user()->category_id)->count();
        $superstar = Qna::distinct('star_id')->where('category_id', auth()->user()->category_id)->count();


        // Registered User

        $weeklyUser = QnaRegistration::where('payment_status', 1)->where('created_at', '>', Carbon::now()->startOfWeek())->where('created_at', '<', Carbon::now()->endOfWeek())->count();
        $monthlyUser = QnaRegistration::where('created_at', '>', Carbon::now()->startOfMonth())->where('created_at', '<', Carbon::now()->endOfMonth())->count();
        $yearlyUser = QnaRegistration::where('created_at', '>', Carbon::now()->startOfYear())->where('created_at', '<', Carbon::now()->endOfYear())->count();

        // Income Statement

        $weeklyIncome = QnaRegistration::where('created_at', '>', Carbon::now()->startOfWeek())->where('created_at', '<', Carbon::now()->endOfWeek())->sum('amount');
        $monthlyIncome = QnaRegistration::where('created_at', '>', Carbon::now()->startOfMonth())->where('created_at', '<', Carbon::now()->endOfMonth())->sum('amount');
        $yearlyIncome = QnaRegistration::where('created_at', '>', Carbon::now()->startOfYear())->where('created_at', '<', Carbon::now()->endOfYear())->sum('amount');
        return view('ManagerAdmin.QnA.dashboard', compact(['total', 'upcoming', 'complete', 'weeklyUser', 'monthlyUser', 'yearlyUser', 'weeklyIncome', 'monthlyIncome', 'yearlyIncome', 'categories', 'admin', 'superstar']));
    }
    public function qnaData($type)
    {
        if ($type == 'total') {
            $portalData = QnA::with(['star', 'category'])->where('category_id', auth()->user()->category_id)->get();
        } elseif ($type == 'upcoming') {
            $portalData = Qna::with(['star', 'category'])->where('status', 0)->where('category_id', auth()->user()->category_id)->get();
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
}
