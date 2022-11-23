<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Auction;
use App\Models\Audition\Audition;
use App\Models\Audition\AuditionParticipant;
use App\Models\Audition\AuditionRoundInfo;
use App\Models\Audition\AuditionRoundMarkTracking;
use App\Models\Audition\AuditionUploadVideo;
use App\Models\AuditionCertification;
use App\Models\Bidding;
use App\Models\Fan_Group_Join;
use App\Models\FanGroup;
use App\Models\GeneralPostPayment;
use App\Models\Greeting;
use App\Models\GreetingsRegistration;
use App\Models\LearningSession;
use App\Models\LearningSessionRegistration;
use App\Models\LiveChat;
use App\Models\LiveChatRegistration;
use App\Models\Marketplace;
use App\Models\MarketplaceOrder;
use App\Models\MeetupEvent;
use App\Models\MeetupEventRegistration;
use App\Models\ProfitShare;
use App\Models\ProfitWalletWithdrawHistory;
use App\Models\QnA;
use App\Models\QnaRegistration;
use App\Models\SimplePost;
use App\Models\SouvenirApply;
use App\Models\SouvenirCreate;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use function PHPSTORM_META\type;

class DashboardController extends Controller
{
    public function adminDashboard()
    {

        // Income Statement simple post


        $simplepost['simplePostTotalIncome'] = GeneralPostPayment::whereHas('simpleposts', function ($q) {
            $q->where([['admin_id', auth()->user()->id]])->orWhere([['star_id', auth()->user()->id]]);
        })->sum('amount');

        $simplepost['simplePostDailyIncome'] = GeneralPostPayment::whereHas('simpleposts', function ($q) {
            $q->where([['admin_id', auth()->user()->id]])->orWhere([['star_id', auth()->user()->id]])->orWhere([['star_id', auth()->user()->id]]);
        })->where('created_at', '>', Carbon::now()->startOfDay())->where('created_at', '<', Carbon::now()->endOfDay())->sum('amount');

        $simplepost['simplePostWeeklyIncome'] = GeneralPostPayment::whereHas('simpleposts', function ($q) {
            $q->where([['admin_id', auth()->user()->id]])->orWhere([['star_id', auth()->user()->id]]);
        })->where('created_at', '>', Carbon::now()->startOfWeek())->where('created_at', '<', Carbon::now()->endOfWeek())->sum('amount');

        $simplepost['simplePostMonthlyIncome'] = GeneralPostPayment::whereHas('simpleposts', function ($q) {
            $q->where([['admin_id', auth()->user()->id]])->orWhere([['star_id', auth()->user()->id]]);
        })->where('created_at', '>', Carbon::now()->startOfMonth())->where('created_at', '<', Carbon::now()->endOfMonth())->sum('amount');

        $simplepost['simplePostYearlyIncome'] = GeneralPostPayment::whereHas('simpleposts', function ($q) {
            $q->where([['admin_id', auth()->user()->id]])->orWhere([['star_id', auth()->user()->id]]);
        })->where('created_at', '>', Carbon::now()->startOfYear())->where('created_at', '<', Carbon::now()->endOfYear())->sum('amount');


        // Income Statement meetup

        $meetup['meetupTotalIncome'] = MeetupEventRegistration::whereHas('meetupEvent', function ($q) {
            $q->where([['admin_id', auth()->user()->id]])->orWhere([['star_id', auth()->user()->id]]);
        })->sum('amount');
        // return response()->json($meetup['meetupTotalIncome']);
        $meetup['meetupDailyIncome'] = MeetupEventRegistration::whereHas('meetupEvent', function ($q) {
            $q->where([['admin_id', auth()->user()->id]])->orWhere([['star_id', auth()->user()->id]]);
        })->where('created_at', '>', Carbon::now()->startOfDay())->where('created_at', '<', Carbon::now()->endOfDay())->sum('amount');
        $meetup['meetupWeeklyIncome'] = MeetupEventRegistration::whereHas('meetupEvent', function ($q) {
            $q->where([['admin_id', auth()->user()->id]])->orWhere([['star_id', auth()->user()->id]]);
        })->where('created_at', '>', Carbon::now()->startOfWeek())->where('created_at', '<', Carbon::now()->endOfWeek())->sum('amount');
        $meetup['meetupMonthlyIncome'] = MeetupEventRegistration::whereHas('meetupEvent', function ($q) {
            $q->where([['admin_id', auth()->user()->id]])->orWhere([['star_id', auth()->user()->id]]);
        })->where('created_at', '>', Carbon::now()->startOfMonth())->where('created_at', '<', Carbon::now()->endOfMonth())->sum('amount');
        $meetup['meetupYearlyIncome'] = MeetupEventRegistration::whereHas('meetupEvent', function ($q) {
            $q->where([['admin_id', auth()->user()->id]])->orWhere([['star_id', auth()->user()->id]]);
        })->where('created_at', '>', Carbon::now()->startOfYear())->where('created_at', '<', Carbon::now()->endOfYear())->sum('amount');

        // Income Statement meetup

        $learning['learningSessionTotalIncome'] = LearningSessionRegistration::whereHas('learningSession', function ($q) {
            $q->where([['admin_id', auth()->user()->id]])->orWhere([['star_id', auth()->user()->id]]);
        })->sum('amount');
        $learning['learningSessionDailyIncome'] = LearningSessionRegistration::whereHas('learningSession', function ($q) {
            $q->where([['admin_id', auth()->user()->id]])->orWhere([['star_id', auth()->user()->id]]);
        })->where('created_at', '>', Carbon::now()->startOfDay())->where('created_at', '<', Carbon::now()->endOfDay())->sum('amount');
        $learning['learningSessionWeeklyIncome'] = LearningSessionRegistration::whereHas('learningSession', function ($q) {
            $q->where([['admin_id', auth()->user()->id]])->orWhere([['star_id', auth()->user()->id]]);
        })->where('created_at', '>', Carbon::now()->startOfWeek())->where('created_at', '<', Carbon::now()->endOfWeek())->sum('amount');
        $learning['learningSessionMonthlyIncome'] = LearningSessionRegistration::whereHas('learningSession', function ($q) {
            $q->where([['admin_id', auth()->user()->id]])->orWhere([['star_id', auth()->user()->id]]);
        })->where('created_at', '>', Carbon::now()->startOfMonth())->where('created_at', '<', Carbon::now()->endOfMonth())->sum('amount');
        $learning['learningSessionYearlyIncome'] = LearningSessionRegistration::whereHas('learningSession', function ($q) {
            $q->where([['admin_id', auth()->user()->id]])->orWhere([['star_id', auth()->user()->id]]);
        })->where('created_at', '>', Carbon::now()->startOfYear())->where('created_at', '<', Carbon::now()->endOfYear())->sum('amount');

        // Income Statement Live Chat

        $liveChat['liveChatTotalIncome'] = LiveChatRegistration::whereHas('liveChat', function ($q) {
            $q->where([['admin_id', auth()->user()->id]])->orWhere([['star_id', auth()->user()->id]]);
        })->sum('amount');
        $liveChat['liveChatDailyIncome'] = LiveChatRegistration::whereHas('liveChat', function ($q) {
            $q->where([['admin_id', auth()->user()->id]])->orWhere([['star_id', auth()->user()->id]]);
        })->where('created_at', '>', Carbon::now()->startOfDay())->where('created_at', '<', Carbon::now()->endOfDay())->sum('amount');
        $liveChat['liveChatWeeklyIncome'] = LiveChatRegistration::whereHas('liveChat', function ($q) {
            $q->where([['admin_id', auth()->user()->id]])->orWhere([['star_id', auth()->user()->id]]);
        })->where('created_at', '>', Carbon::now()->startOfWeek())->where('created_at', '<', Carbon::now()->endOfWeek())->sum('amount');
        $liveChat['liveChatMonthlyIncome'] = LiveChatRegistration::whereHas('liveChat', function ($q) {
            $q->where([['admin_id', auth()->user()->id]])->orWhere([['star_id', auth()->user()->id]]);
        })->where('created_at', '>', Carbon::now()->startOfMonth())->where('created_at', '<', Carbon::now()->endOfMonth())->sum('amount');
        $liveChat['liveChatYearlyIncome'] = LiveChatRegistration::whereHas('liveChat', function ($q) {
            $q->where([['admin_id', auth()->user()->id]])->orWhere([['star_id', auth()->user()->id]]);
        })->where('created_at', '>', Carbon::now()->startOfYear())->where('created_at', '<', Carbon::now()->endOfYear())->sum('amount');

        // Income Statement Q&A

        $qna['qnaTotalIncome'] = QnaRegistration::whereHas('qna', function ($q) {
            $q->where([['admin_id', auth()->user()->id]])->orWhere([['star_id', auth()->user()->id]]);
        })->sum('amount');
        $qna['qnaDailyIncome'] = QnaRegistration::whereHas('qna', function ($q) {
            $q->where([['admin_id', auth()->user()->id]])->orWhere([['star_id', auth()->user()->id]]);
        })->where('created_at', '>', Carbon::now()->startOfDay())->where('created_at', '<', Carbon::now()->endOfDay())->sum('amount');
        $qna['qnaWeeklyIncome'] = QnaRegistration::whereHas('qna', function ($q) {
            $q->where([['admin_id', auth()->user()->id]])->orWhere([['star_id', auth()->user()->id]]);
        })->where('created_at', '>', Carbon::now()->startOfWeek())->where('created_at', '<', Carbon::now()->endOfWeek())->sum('amount');
        $qna['qnaMonthlyIncome'] = QnaRegistration::whereHas('qna', function ($q) {
            $q->where([['admin_id', auth()->user()->id]])->orWhere([['star_id', auth()->user()->id]]);
        })->where('created_at', '>', Carbon::now()->startOfMonth())->where('created_at', '<', Carbon::now()->endOfMonth())->sum('amount');
        $qna['qnaYearlyIncome'] = QnaRegistration::whereHas('qna', function ($q) {
            $q->where([['admin_id', auth()->user()->id]])->orWhere([['star_id', auth()->user()->id]]);
        })->where('created_at', '>', Carbon::now()->startOfYear())->where('created_at', '<', Carbon::now()->endOfYear())->sum('amount');

        // Income Statement Greetings

        $greeting['greetingTotalIncome'] = GreetingsRegistration::whereHas('greeting', function ($q) {
            $q->where([['admin_id', auth()->user()->id]])->orWhere([['star_id', auth()->user()->id]]);
        })->sum('amount');
        $greeting['greetingDailyIncome'] = GreetingsRegistration::whereHas('greeting', function ($q) {
            $q->where([['admin_id', auth()->user()->id]])->orWhere([['star_id', auth()->user()->id]]);
        })->where('created_at', '>', Carbon::now()->startOfDay())->where('created_at', '<', Carbon::now()->endOfDay())->sum('amount');
        $greeting['greetingWeeklyIncome'] = GreetingsRegistration::whereHas('greeting', function ($q) {
            $q->where([['admin_id', auth()->user()->id]])->orWhere([['star_id', auth()->user()->id]]);
        })->where('created_at', '>', Carbon::now()->startOfWeek())->where('created_at', '<', Carbon::now()->endOfWeek())->sum('amount');
        $greeting['greetingMonthlyIncome'] = GreetingsRegistration::whereHas('greeting', function ($q) {
            $q->where([['admin_id', auth()->user()->id]])->orWhere([['star_id', auth()->user()->id]]);
        })->where('created_at', '>', Carbon::now()->startOfMonth())->where('created_at', '<', Carbon::now()->endOfMonth())->sum('amount');
        $greeting['greetingYearlyIncome'] = GreetingsRegistration::whereHas('greeting', function ($q) {
            $q->where([['admin_id', auth()->user()->id]])->orWhere([['star_id', auth()->user()->id]]);
        })->where('created_at', '>', Carbon::now()->startOfYear())->where('created_at', '<', Carbon::now()->endOfYear())->sum('amount');

        // Income Statement Auction

        $auction['auctionTotalIncome'] = Bidding::whereHas('auction', function ($q) {
            $q->where([['admin_id', auth()->user()->id]])->orWhere([['star_id', auth()->user()->id]]);
        })->sum('amount');
        $auction['auctionDailyIncome'] = Bidding::whereHas('auction', function ($q) {
            $q->where([['admin_id', auth()->user()->id]])->orWhere([['star_id', auth()->user()->id]]);
        })->where('created_at', '>', Carbon::now()->startOfDay())->where('created_at', '<', Carbon::now()->endOfDay())->sum('amount');
        $auction['auctionWeeklyIncome'] = Bidding::whereHas('auction', function ($q) {
            $q->where([['admin_id', auth()->user()->id]])->orWhere([['star_id', auth()->user()->id]]);
        })->where('created_at', '>', Carbon::now()->startOfWeek())->where('created_at', '<', Carbon::now()->endOfWeek())->sum('amount');
        $auction['auctionMonthlyIncome'] = Bidding::whereHas('auction', function ($q) {
            $q->where([['admin_id', auth()->user()->id]])->orWhere([['star_id', auth()->user()->id]]);
        })->where('created_at', '>', Carbon::now()->startOfMonth())->where('created_at', '<', Carbon::now()->endOfMonth())->sum('amount');
        $auction['auctionYearlyIncome'] = Bidding::whereHas('auction', function ($q) {
            $q->where([['admin_id', auth()->user()->id]])->orWhere([['star_id', auth()->user()->id]]);
        })->where('created_at', '>', Carbon::now()->startOfYear())->where('created_at', '<', Carbon::now()->endOfYear())->sum('amount');

        // Income Statement fangroup

        // $marketplace['marketplaceTotalIncome'] = MarketplaceOrder::whereHas('marketplace', function ($q) {
        //     $q->where([['superstar_admin_id', auth()->user()->id]]);
        // })->sum('total_price');
        // $marketplace['marketplaceDailyIncome'] = MarketplaceOrder::whereHas('marketplace', function ($q) {
        //     $q->where([['superstar_admin_id', auth()->user()->id]]);
        // })->where('created_at', '>', Carbon::now()->startOfDay())->where('created_at', '<', Carbon::now()->endOfDay())->sum('total_price');
        // $marketplace['marketplaceWeeklyIncome'] = MarketplaceOrder::whereHas('marketplace', function ($q) {
        //     $q->where([['superstar_admin_id', auth()->user()->id]]);
        // })->where('created_at', '>', Carbon::now()->startOfWeek())->where('created_at', '<', Carbon::now()->endOfWeek())->sum('total_price');
        // $marketplace['marketplaceMonthlyIncome'] = MarketplaceOrder::whereHas('marketplace', function ($q) {
        //     $q->where([['superstar_admin_id', auth()->user()->id]]);
        // })->where('created_at', '>', Carbon::now()->startOfMonth())->where('created_at', '<', Carbon::now()->endOfMonth())->sum('total_price');
        // $marketplace['marketplaceYearlyIncome'] = MarketplaceOrder::whereHas('marketplace', function ($q) {
        //     $q->where([['superstar_admin_id', auth()->user()->id]]);
        // })->where('created_at', '>', Carbon::now()->startOfYear())->where('created_at', '<', Carbon::now()->endOfYear())->sum('total_price');

        // Income Statement Marketplace

        $marketplace['marketplaceTotalIncome'] = MarketplaceOrder::whereHas('marketplace', function ($q) {
            $q->where([['superstar_admin_id', auth()->user()->id]])->orWhere([['superstar_id', auth()->user()->id]]);
        })->sum('total_price');
        $marketplace['marketplaceDailyIncome'] = MarketplaceOrder::whereHas('marketplace', function ($q) {
            $q->where([['superstar_admin_id', auth()->user()->id]])->orWhere([['superstar_id', auth()->user()->id]]);
        })->where('created_at', '>', Carbon::now()->startOfDay())->where('created_at', '<', Carbon::now()->endOfDay())->sum('total_price');
        $marketplace['marketplaceWeeklyIncome'] = MarketplaceOrder::whereHas('marketplace', function ($q) {
            $q->where([['superstar_admin_id', auth()->user()->id]])->orWhere([['superstar_id', auth()->user()->id]]);
        })->where('created_at', '>', Carbon::now()->startOfWeek())->where('created_at', '<', Carbon::now()->endOfWeek())->sum('total_price');
        $marketplace['marketplaceMonthlyIncome'] = MarketplaceOrder::whereHas('marketplace', function ($q) {
            $q->where([['superstar_admin_id', auth()->user()->id]])->orWhere([['superstar_id', auth()->user()->id]]);
        })->where('created_at', '>', Carbon::now()->startOfMonth())->where('created_at', '<', Carbon::now()->endOfMonth())->sum('total_price');
        $marketplace['marketplaceYearlyIncome'] = MarketplaceOrder::whereHas('marketplace', function ($q) {
            $q->where([['superstar_admin_id', auth()->user()->id]])->orWhere([['superstar_id', auth()->user()->id]]);
        })->where('created_at', '>', Carbon::now()->startOfYear())->where('created_at', '<', Carbon::now()->endOfYear())->sum('total_price');


        // Income Statement Souvenir

        $souvenir['souvenirTotalIncome'] = SouvenirApply::whereHas('souvenir', function ($q) {
            $q->where([['admin_id', auth()->user()->id]])->orWhere([['star_id', auth()->user()->id]]);
        })->sum('total_amount');
        $souvenir['souvenirDailyIncome'] = SouvenirApply::whereHas('souvenir', function ($q) {
            $q->where([['admin_id', auth()->user()->id]])->orWhere([['star_id', auth()->user()->id]]);
        })->where('created_at', '>', Carbon::now()->startOfDay())->where('created_at', '<', Carbon::now()->endOfDay())->sum('total_amount');
        $souvenir['souvenirWeeklyIncome'] = SouvenirApply::whereHas('souvenir', function ($q) {
            $q->where([['admin_id', auth()->user()->id]])->orWhere([['star_id', auth()->user()->id]]);
        })->where('created_at', '>', Carbon::now()->startOfWeek())->where('created_at', '<', Carbon::now()->endOfWeek())->sum('total_amount');
        $souvenir['souvenirMonthlyIncome'] = SouvenirApply::whereHas('souvenir', function ($q) {
            $q->where([['admin_id', auth()->user()->id]])->orWhere([['star_id', auth()->user()->id]]);
        })->where('created_at', '>', Carbon::now()->startOfMonth())->where('created_at', '<', Carbon::now()->endOfMonth())->sum('total_amount');
        $souvenir['souvenirYearlyIncome'] = SouvenirApply::whereHas('souvenir', function ($q) {
            $q->where([['admin_id', auth()->user()->id]])->orWhere([['star_id', auth()->user()->id]]);
        })->where('created_at', '>', Carbon::now()->startOfYear())->where('created_at', '<', Carbon::now()->endOfYear())->sum('total_amount');

        //Total Statement
        $totalIncomeStatement['totalIncome'] = $meetup['meetupTotalIncome'] + $simplepost['simplePostTotalIncome'] + $learning['learningSessionTotalIncome'] + $liveChat['liveChatTotalIncome'] + $qna['qnaTotalIncome'] + $greeting['greetingTotalIncome'] + $auction['auctionTotalIncome'] + $marketplace['marketplaceTotalIncome'] + $souvenir['souvenirTotalIncome'];
        $totalIncomeStatement['dailyTotalIncome'] = $meetup['meetupDailyIncome'] + $simplepost['simplePostDailyIncome'] + $learning['learningSessionDailyIncome'] + $liveChat['liveChatDailyIncome'] + $qna['qnaDailyIncome'] + $greeting['greetingDailyIncome'] + $auction['auctionDailyIncome'] + $marketplace['marketplaceDailyIncome'] + $souvenir['souvenirDailyIncome'];
        $totalIncomeStatement['weeklyTotalIncome'] = $meetup['meetupWeeklyIncome'] + $simplepost['simplePostWeeklyIncome'] + $learning['learningSessionWeeklyIncome'] + $liveChat['liveChatWeeklyIncome'] + $qna['qnaWeeklyIncome'] + $greeting['greetingWeeklyIncome'] + $auction['auctionWeeklyIncome'] + $marketplace['marketplaceWeeklyIncome'] + $souvenir['souvenirWeeklyIncome'];
        $totalIncomeStatement['monthlyTotalIncome'] = $meetup['meetupMonthlyIncome'] + $simplepost['simplePostMonthlyIncome'] + $learning['learningSessionMonthlyIncome'] + $liveChat['liveChatMonthlyIncome'] + $qna['qnaMonthlyIncome'] + $greeting['greetingMonthlyIncome'] + $auction['auctionMonthlyIncome'] + $marketplace['marketplaceMonthlyIncome'] + $souvenir['souvenirMonthlyIncome'];
        $totalIncomeStatement['yearlyTotalIncome'] = $meetup['meetupYearlyIncome'] + $simplepost['simplePostYearlyIncome'] + $learning['learningSessionYearlyIncome'] + $liveChat['liveChatYearlyIncome'] + $qna['qnaYearlyIncome'] + $greeting['greetingYearlyIncome'] + $auction['auctionYearlyIncome'] + $marketplace['marketplaceYearlyIncome'] + $souvenir['souvenirYearlyIncome'];

        //Star showcase


        $totalIncomeStatementStarShowcase['totalIncome'] =  $auction['auctionTotalIncome'] + $marketplace['marketplaceTotalIncome'] + $souvenir['souvenirTotalIncome'];
        $totalIncomeStatementStarShowcase['dailyTotalIncome'] = $auction['auctionDailyIncome'] + $marketplace['marketplaceDailyIncome'] + $souvenir['souvenirDailyIncome'];
        $totalIncomeStatementStarShowcase['weeklyTotalIncome'] = $auction['auctionWeeklyIncome'] + $marketplace['marketplaceWeeklyIncome'] + $souvenir['souvenirWeeklyIncome'];
        $totalIncomeStatementStarShowcase['monthlyTotalIncome'] = $auction['auctionMonthlyIncome'] + $marketplace['marketplaceMonthlyIncome'] + $souvenir['souvenirMonthlyIncome'];
        $totalIncomeStatementStarShowcase['yearlyTotalIncome'] = $auction['auctionYearlyIncome'] + $marketplace['marketplaceYearlyIncome'] + $souvenir['souvenirYearlyIncome'];


        return response()->json([
            'status' => 200,
            'totalIncomeStatement' => $totalIncomeStatement,
            'simplepost' => $simplepost,
            'meetup' => $meetup,
            'learning' => $learning,
            'liveChat' => $liveChat,
            'qna' => $qna,
            'greeting' => $greeting,
            'totalIncomeStatementStarShowcase' => $totalIncomeStatementStarShowcase
        ]);
    }
    public function starShowCaseProductsCount(){
        $auction = Auction::where('star_id', auth('sanctum')->user()->id)->count();
        $marketplace = Marketplace::where('superstar_id', auth('sanctum')->user()->id)->count();
        $souvenirCreate = SouvenirCreate::where('star_id', auth('sanctum')->user()->id)->count();
        return response()->json([
            'status' => 200,
            'auction' => $auction,
            'marketplace' => $marketplace,
            'souvenirCreate' => $souvenirCreate,
        ]);
    }
    public function notification()
    {
        $pendingLiveChat = LiveChat::where([['star_id', auth('sanctum')->user()->id], ['status' , 0]])->get();
        $pendingLearningSessions = LearningSession::where([['star_id', auth('sanctum')->user()->id],['status', 0]])->get();
        $pendingQna = QnA::where([['star_id', auth('sanctum')->user()->id],['star_approval', 0]])->get();
        $pendingMeetupEvent = MeetupEvent::where([['star_id', auth('sanctum')->user()->id],['status', 0]])->get();
        $pendingPost = SimplePost::where([['star_id', auth('sanctum')->user()->id],['star_approval', 0]])->get();
        $pendingGreeting = Greeting::where([['star_id', auth('sanctum')->user()->id], ['star_approve_status', 0]])->get();
        $pendingFanGroup = FanGroup::where([['my_star', auth('sanctum')->user()->id],['my_star_status', 0]])->orWhere([['another_star', auth('sanctum')->user()->id],['another_star_status', 0]])->get();
        $pendingMarketplace = Marketplace::where([['superstar_id', auth('sanctum')->user()->id], ['post_status', 0]])->get();
        $pendingAuction = Auction::where([['star_id', auth('sanctum')->user()->id], ['star_approval', 0]])->get();
        $pendingSouvenir = SouvenirCreate::where([['star_id', auth('sanctum')->user()->id], ['approval_status', 0]])->get();
        return response()->json([
            'status' => 200,
            'pendingLiveChat' => $pendingLiveChat,
            'pendingLearningSessions' => $pendingLearningSessions,
            'pendingQna' => $pendingQna,
            'pendingMeetupEvent' => $pendingMeetupEvent,
            'pendingPost' => $pendingPost,
            'pendingGreeting' => $pendingGreeting,
            'pendingFanGroup' => $pendingFanGroup,
            'pendingMarketplace' => $pendingMarketplace,
            'pendingAuction' => $pendingAuction,
            'pendingSouvenir' => $pendingSouvenir,
        ]);

    }
    public function starDashboardCount(){
        $post = SimplePost::where('star_id', auth('sanctum')->user()->id)->count();
        $liveChat = LiveChat::where('star_id', auth('sanctum')->user()->id)->count();
        $qna = QnA::where('star_id', auth('sanctum')->user()->id)->count();
        $meetupEvent = MeetupEvent::where('star_id', auth('sanctum')->user()->id)->count();
        $learningSession = LearningSession::where('star_id', auth('sanctum')->user()->id)->count();
        $greeting = Greeting::where('star_id', auth('sanctum')->user()->id)->count();
        $fanGroup = FanGroup::where('my_star', auth('sanctum')->user()->id)->orWhere('another_star', auth('sanctum')->user()->id)->count();

        $auction = Auction::where('star_id', auth('sanctum')->user()->id)->count();
        $marketplace = Marketplace::where('superstar_id', auth('sanctum')->user()->id)->count();
        $souvenirCreate = SouvenirCreate::where('star_id', auth('sanctum')->user()->id)->count();

        $totalShowCase = $auction + $marketplace + $souvenirCreate;

        return response()->json([
            'status' => 200,
            'post' => $post,
            'liveChat' => $liveChat,
            'qna' => $qna,
            'meetupEvent' => $meetupEvent,
            'learningSession' => $learningSession,
            'greeting' => $greeting,
            'fanGroup' => $fanGroup,
            'totalShowCase' => $totalShowCase,
        ]);
    }
    public function adminPost($type)
    {
        if ($type == "Simple-Post") {
            $post = SimplePost::where('admin_id', auth('sanctum')->user()->id)->orWhere('star_id', auth('sanctum')->user()->id)->latest()->get();
        } elseif ($type == "Live-Chat") {
            $post = LiveChat::with('registeredLiveChats')->where('admin_id', auth('sanctum')->user()->id)->orWhere('star_id', auth('sanctum')->user()->id)->latest()->get();
        } elseif ($type == "Q&A") {
            $post = QnA::with('registeredQna')->where('admin_id', auth('sanctum')->user()->id)->where('star_id', auth('sanctum')->user()->id)->latest()->get();
        } elseif ($type == "Meetup-Event") {
            $post = MeetupEvent::with('registeredMeetupEvents')->where('admin_id', auth('sanctum')->user()->id)->orWhere('star_id', auth('sanctum')->user()->id)->latest()->get();
        } elseif ($type == "Learning-Session") {
            $post = LearningSession::with('registeredLearningSessions')->where('admin_id', auth('sanctum')->user()->id)->orWhere('star_id', auth('sanctum')->user()->id)->latest()->get();
        } elseif ($type == "Greeting") {
            $post = Greeting::with('registeredGreeting')->where('admin_id', auth('sanctum')->user()->id)->orWhere('star_id', auth('sanctum')->user()->id)->latest()->get();
        } elseif ($type == "Fan-Group") {
            $post = FanGroup::where('created_by', auth('sanctum')->user()->id)->orWhere('star_id', auth('sanctum')->user()->id)->orWhere('another_star_admin_id', auth('sanctum')->user()->id)->latest()->get();
        } elseif ($type == "Auction") {
            $post = Auction::with('bidding')->where('admin_id', auth('sanctum')->user()->id)->orWhere('star_id', auth('sanctum')->user()->id)->latest()->get();
        } elseif ($type == "Marketplace") {
            $post = Marketplace::with('marketplace_order')->where('superstar_admin_id', auth('sanctum')->user()->id)->orWhere('star_id', auth('sanctum')->user()->id)->latest()->get();
        } elseif ($type == "Souvenir") {
            $post = SouvenirCreate::with('souvenirApply')->where('admin_id', auth('sanctum')->user()->id)->orWhere('star_id', auth('sanctum')->user()->id)->latest()->get();
        } elseif ($type == "Audition") {
            $post = Audition::with('participant')->where('audition_admin_id', auth('sanctum')->user()->id)->latest()->get();
        } else {
            return response()->json([
                'status' => 403,
            ]);
        }

        return response()->json([
            'status' => 200,
            'post' => $post

        ]);
    }
    public function postDeatils($id, $type)
    {

        if ($type == "Simple-Post") {
            $post = SimplePost::where('admin_id', auth('sanctum')->user()->id)->orWhere('star_id', auth('sanctum')->user()->id)->where('id', $id)->first();
            $participant = GeneralPostPayment::whereHas('simpleposts', function ($q) {
                $q->where([['admin_id', auth()->user()->id]])->orWhere('star_id', auth('sanctum')->user()->id);
            })->where('post_id', $id)->get();
        } elseif ($type == "Live-Chat") {
            $post = LiveChat::where('admin_id', auth('sanctum')->user()->id)->orWhere('star_id', auth('sanctum')->user()->id)->where('id', $id)->first();
            $participant = LiveChatRegistration::whereHas('liveChat', function ($q) {
                $q->where([['admin_id', auth()->user()->id]])->orWhere('star_id', auth('sanctum')->user()->id);
            })->where('live_chat_id', $id)->get();
        } elseif ($type == "Q&A") {
            $post = QnA::where('admin_id', auth('sanctum')->user()->id)->orWhere('star_id', auth('sanctum')->user()->id)->where('id', $id)->first();
            $participant = QnaRegistration::whereHas('qna', function ($q) {
                $q->where([['admin_id', auth()->user()->id]])->orWhere('star_id', auth('sanctum')->user()->id);
            })->where('qna_id', $id)->get();
        } elseif ($type == "Meetup-Event") {
            $post = MeetupEvent::where('admin_id', auth('sanctum')->user()->id)->orWhere('star_id', auth('sanctum')->user()->id)->where('id', $id)->first();
            $participant = MeetupEventRegistration::whereHas('meetupEvent', function ($q) {
                $q->where([['admin_id', auth()->user()->id]])->orWhere('star_id', auth('sanctum')->user()->id);
            })->where('meetup_event_id', $id)->get();
        } elseif ($type == "Learning-Session") {
            $post = LearningSession::where('admin_id', auth('sanctum')->user()->id)->orWhere('star_id', auth('sanctum')->user()->id)->where('id', $id)->first();
            $participant = LearningSessionRegistration::whereHas('learningSession', function ($q) {
                $q->where([['admin_id', auth()->user()->id]])->orWhere('star_id', auth('sanctum')->user()->id);
            })->where('learning_session_id', $id)->get();
        } elseif ($type == "Greeting") {
            $post = Greeting::where('admin_id', auth('sanctum')->user()->id)->orWhere('star_id', auth('sanctum')->user()->id)->where('id', $id)->first();
            $participant = GreetingsRegistration::whereHas('greeting', function ($q) {
                $q->where([['admin_id', auth()->user()->id]])->orWhere('star_id', auth('sanctum')->user()->id);
            })->where('greeting_id', $id)->get();
        } elseif ($type == "Auction") {
            $post = Auction::where('admin_id', auth('sanctum')->user()->id)->orWhere('star_id', auth('sanctum')->user()->id)->where('id', $id)->first();
            $participant = Bidding::whereHas('auction', function ($q) {
                $q->where([['admin_id', auth()->user()->id]])->orWhere('star_id', auth('sanctum')->user()->id);
            })->where('auction_id', $id)->get();
        } elseif ($type == "Marketplace") {
            $post = Marketplace::where('superstar_admin_id', auth('sanctum')->user()->id)->orWhere('star_id', auth('sanctum')->user()->id)->where('id', $id)->first();
            $participant = MarketplaceOrder::whereHas('marketplace', function ($q) {
                $q->where([['superstar_admin_id', auth()->user()->id]])->orWhere('star_id', auth('sanctum')->user()->id);
            })->where('marketplace_id', $id)->get();
        } elseif ($type == "Souvenir") {
            $post = SouvenirCreate::where('admin_id', auth('sanctum')->user()->id)->orWhere('star_id', auth('sanctum')->user()->id)->where('id', $id)->first();
            $participant = SouvenirApply::whereHas('souvenir', function ($q) {
                $q->where([['admin_id', auth()->user()->id]])->orWhere('star_id', auth('sanctum')->user()->id);
            })->where('souvenir_id', $id)->get();
        } elseif ($type == "Fan-Group") {
            $post = FanGroup::where('created_by', auth('sanctum')->user()->id)->orWhere('star_id', auth('sanctum')->user()->id)->orWhere('another_star_admin_id', auth('sanctum')->user()->id)->where('id', $id)->first();

            $participant = json_decode($post->my_user_join);
            $another_user = json_decode($post->another_user_join);
        } elseif ($type == "Audition") {
            $post = Audition::find($id);
            $uploadedVideo = AuditionUploadVideo::where('audition_id', $id)->count();
            $participant = $uploadedVideo ? $uploadedVideo : 0;
        } else {
            return response()->json([
                'status' => 403,
            ]);
        }

        return response()->json([
            'status' => 200,
            'post' => $post,
            'participant' => $participant
        ]);
    }

    public function profitShare()
    {
        $profitShare = ProfitShare::with('withdrawHistory')->where('user_id', auth('sanctum')->user()->id)->first();
        $profitShareHistory = ProfitWalletWithdrawHistory::where('user_id', auth('sanctum')->user()->id)->sum('withdraw_amount');
        return response()->json([
            'status' => 200,
            'profitShare' => $profitShare,
            'profitShareHistory' => $profitShareHistory,
        ]);
    }
    public function profitWithdraw(Request $request)
    {

        // return $request->all();


        $validator = Validator::make($request->all(), [
            'withdraw_amount' => 'required',
        ], [
            "withdraw_amount.required" => "Please Enter Amount"
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->errors(),
            ]);
        }

        ProfitWalletWithdrawHistory::create([
            'user_id' => auth('sanctum')->user()->id,
            'profit_share_id' => $request->profit_share_id,
            'user_type' =>  auth()->user()->user_type,
            'withdraw_id' => uniqid(),
            'withdraw_amount' => $request->withdraw_amount,
            'status' => 0
        ]);

        return response()->json([
            'status' => 200,

        ]);
    }

    public function auditionCount()
    {
        $audition = Audition::where('audition_admin_id', auth('sanctum')->user()->id)->get();

        return response()->json([
            'status' => 200,
            'totalAudition' => $audition->count(),
            'pendingAudition' => $audition->where('status', 0)->count(),
            'liveAudition' => $audition->where('status', 3)->count(),
            'completedAudition' => $audition->where('status', 4)->count(),
        ]);
    }
    public function auditionRoundInfos($id)
    {
        $auditionRoundInfos = AuditionRoundInfo::find($id);
        $roundParticipant = AuditionUploadVideo::where('round_info_id', $id)->distinct()->count('user_id');
        $roundParticipantVideos = AuditionUploadVideo::where('round_info_id', $id)->count();
        $roundAppeal = AuditionUploadVideo::where([['round_info_id', $id], ['type', 'appeal']])->distinct()->count('user_id');
        $roundCertification = AuditionCertification::where('round_info_id', $id)->distinct()->count('participant_id');
        $roundWinner = AuditionRoundMarkTracking::where([['round_info_id', $id], ['wining_status', 1]])->distinct()->count('user_id');
        $roundFailed = AuditionRoundMarkTracking::where([['round_info_id', $id], ['wining_status', 0]])->distinct()->count('user_id');
        $roundCertification = AuditionCertification::where('round_info_id', $id)->distinct()->count('participant_id');

        return response()->json([
            'status' => 200,
            'auditionRoundInfos' => $auditionRoundInfos,
            'roundParticipant' => $roundParticipant,
            'roundCertification' => $roundCertification,
            'roundAppeal' => $roundAppeal,
            'roundWinner' => $roundWinner,
            'roundFailed' => $roundFailed,
            'roundParticipantVideos' => $roundParticipantVideos,


        ]);
    }

    public function auditionIncome()
    {

        // Income Statement Audition

        $auditionIncome['auditionTotalIncome'] = AuditionParticipant::whereHas('audition', function ($q) {
            $q->where([['audition_admin_id', auth()->user()->id]]);
        })->sum('amount');
        $auditionIncome['auditionDailyIncome'] = AuditionParticipant::whereHas('audition', function ($q) {
            $q->where([['audition_admin_id', auth()->user()->id]]);
        })->where('created_at', '>', Carbon::now()->startOfDay())->where('created_at', '<', Carbon::now()->endOfDay())->sum('amount');
        $auditionIncome['auditionWeeklyIncome'] = AuditionParticipant::whereHas('audition', function ($q) {
            $q->where([['audition_admin_id', auth()->user()->id]]);
        })->where('created_at', '>', Carbon::now()->startOfWeek())->where('created_at', '<', Carbon::now()->endOfWeek())->sum('amount');
        $auditionIncome['auditionMonthlyIncome'] = AuditionParticipant::whereHas('audition', function ($q) {
            $q->where([['audition_admin_id', auth()->user()->id]]);
        })->where('created_at', '>', Carbon::now()->startOfMonth())->where('created_at', '<', Carbon::now()->endOfMonth())->sum('amount');
        $auditionIncome['auditionYearlyIncome'] = AuditionParticipant::whereHas('audition', function ($q) {
            $q->where([['audition_admin_id', auth()->user()->id]]);
        })->where('created_at', '>', Carbon::now()->startOfYear())->where('created_at', '<', Carbon::now()->endOfYear())->sum('amount');

        return response()->json([
            'status' => 200,
            'auditionIncome' => $auditionIncome
        ]);
    }

    public function juryDashboard()
    {
        $audition = Audition::with('participant')->whereHas('assignedJuries', function ($q) {
            return $q->distinct('audition_id')->where('jury_id', auth('sanctum')->user()->id);
        })->get();
        return response()->json([
            'status' => 200,
            'audition' => $audition,
        ]);
    }

    public function auditionRoundInfosJury($id)
    {
        $auditionRoundInfos = AuditionRoundInfo::find($id);
        $roundParticipant = AuditionUploadVideo::where('round_info_id', $id)->distinct()->count('user_id');

        $groupB_Videos = AuditionUploadVideo::where('round_info_id', $id)->where('group_b_jury_id', auth()->user()->id)->count();
        $groupC_Videos = AuditionUploadVideo::where('round_info_id', $id)->where('group_c_jury_id', auth()->user()->id)->count();
        $groupA_Random_Videos = AuditionUploadVideo::where('round_info_id', $id)->where('group_a_ran_jury_id', auth()->user()->id)->count();
        $groupA_Per_Videos = AuditionUploadVideo::where('round_info_id', $id)->where('group_a_per_jury_id', auth()->user()->id)->count();

        return response()->json([
            'status' => 200,
            'auditionRoundInfos' => $auditionRoundInfos,
            'roundParticipant' => $roundParticipant,
            'groupB_Videos' => $groupB_Videos,
            'groupC_Videos' => $groupC_Videos,
            'groupA_Random_Videos' => $groupA_Random_Videos,
            'groupA_Per_Videos' => $groupA_Per_Videos,
        ]);
    }
}
