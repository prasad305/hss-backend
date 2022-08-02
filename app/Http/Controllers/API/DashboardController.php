<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Auction;
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
use App\Models\QnA;
use App\Models\QnaRegistration;
use App\Models\SimplePost;
use App\Models\SouvenirApply;
use Carbon\Carbon;
use Illuminate\Http\Request;

use function PHPSTORM_META\type;

class DashboardController extends Controller
{
    public function adminDashboard()
    {

        // Income Statement simple post

        $simplepost['simplePostTotalIncome'] = GeneralPostPayment::whereHas('simpleposts', function ($q) {
            $q->where([['admin_id', auth()->user()->id]]);
        })->sum('amount');
        $simplepost['simplePostDailyIncome'] = GeneralPostPayment::whereHas('simpleposts', function ($q) {
            $q->where([['admin_id', auth()->user()->id]]);
        })->where('created_at', '>', Carbon::now()->startOfDay())->where('created_at', '<', Carbon::now()->endOfDay())->sum('amount');
        $simplepost['simplePostWeeklyIncome'] = GeneralPostPayment::whereHas('simpleposts', function ($q) {
            $q->where([['admin_id', auth()->user()->id]]);
        })->where('created_at', '>', Carbon::now()->startOfWeek())->where('created_at', '<', Carbon::now()->endOfWeek())->sum('amount');
        $simplepost['simplePostMonthlyIncome'] = GeneralPostPayment::whereHas('simpleposts', function ($q) {
            $q->where([['admin_id', auth()->user()->id]]);
        })->where('created_at', '>', Carbon::now()->startOfMonth())->where('created_at', '<', Carbon::now()->endOfMonth())->sum('amount');
        $simplepost['simplePostYearlyIncome'] = GeneralPostPayment::whereHas('simpleposts', function ($q) {
            $q->where([['admin_id', auth()->user()->id]]);
        })->where('created_at', '>', Carbon::now()->startOfYear())->where('created_at', '<', Carbon::now()->endOfYear())->sum('amount');

        // Income Statement meetup

        $meetup['meetupTotalIncome'] = MeetupEventRegistration::whereHas('meetupEvent', function ($q) {
            $q->where([['admin_id', auth()->user()->id]]);
        })->sum('amount');
        $meetup['meetupDailyIncome'] = MeetupEventRegistration::whereHas('meetupEvent', function ($q) {
            $q->where([['admin_id', auth()->user()->id]]);
        })->where('created_at', '>', Carbon::now()->startOfDay())->where('created_at', '<', Carbon::now()->endOfDay())->sum('amount');
        $meetup['meetupWeeklyIncome'] = MeetupEventRegistration::whereHas('meetupEvent', function ($q) {
            $q->where([['admin_id', auth()->user()->id]]);
        })->where('created_at', '>', Carbon::now()->startOfWeek())->where('created_at', '<', Carbon::now()->endOfWeek())->sum('amount');
        $meetup['meetupMonthlyIncome'] = MeetupEventRegistration::whereHas('meetupEvent', function ($q) {
            $q->where([['admin_id', auth()->user()->id]]);
        })->where('created_at', '>', Carbon::now()->startOfMonth())->where('created_at', '<', Carbon::now()->endOfMonth())->sum('amount');
        $meetup['meetupYearlyIncome'] = MeetupEventRegistration::whereHas('meetupEvent', function ($q) {
            $q->where([['admin_id', auth()->user()->id]]);
        })->where('created_at', '>', Carbon::now()->startOfYear())->where('created_at', '<', Carbon::now()->endOfYear())->sum('amount');

        // Income Statement meetup

        $learning['learningSessionTotalIncome'] = LearningSessionRegistration::whereHas('learningSession', function ($q) {
            $q->where([['admin_id', auth()->user()->id]]);
        })->sum('amount');
        $learning['learningSessionDailyIncome'] = LearningSessionRegistration::whereHas('learningSession', function ($q) {
            $q->where([['admin_id', auth()->user()->id]]);
        })->where('created_at', '>', Carbon::now()->startOfDay())->where('created_at', '<', Carbon::now()->endOfDay())->sum('amount');
        $learning['learningSessionWeeklyIncome'] = LearningSessionRegistration::whereHas('learningSession', function ($q) {
            $q->where([['admin_id', auth()->user()->id]]);
        })->where('created_at', '>', Carbon::now()->startOfWeek())->where('created_at', '<', Carbon::now()->endOfWeek())->sum('amount');
        $learning['learningSessionMonthlyIncome'] = LearningSessionRegistration::whereHas('learningSession', function ($q) {
            $q->where([['admin_id', auth()->user()->id]]);
        })->where('created_at', '>', Carbon::now()->startOfMonth())->where('created_at', '<', Carbon::now()->endOfMonth())->sum('amount');
        $learning['learningSessionYearlyIncome'] = LearningSessionRegistration::whereHas('learningSession', function ($q) {
            $q->where([['admin_id', auth()->user()->id]]);
        })->where('created_at', '>', Carbon::now()->startOfYear())->where('created_at', '<', Carbon::now()->endOfYear())->sum('amount');

        // Income Statement Live Chat

        $liveChat['liveChatTotalIncome'] = LiveChatRegistration::whereHas('liveChat', function ($q) {
            $q->where([['admin_id', auth()->user()->id]]);
        })->sum('amount');
        $liveChat['liveChatDailyIncome'] = LiveChatRegistration::whereHas('liveChat', function ($q) {
            $q->where([['admin_id', auth()->user()->id]]);
        })->where('created_at', '>', Carbon::now()->startOfDay())->where('created_at', '<', Carbon::now()->endOfDay())->sum('amount');
        $liveChat['liveChatWeeklyIncome'] = LiveChatRegistration::whereHas('liveChat', function ($q) {
            $q->where([['admin_id', auth()->user()->id]]);
        })->where('created_at', '>', Carbon::now()->startOfWeek())->where('created_at', '<', Carbon::now()->endOfWeek())->sum('amount');
        $liveChat['liveChatMonthlyIncome'] = LiveChatRegistration::whereHas('liveChat', function ($q) {
            $q->where([['admin_id', auth()->user()->id]]);
        })->where('created_at', '>', Carbon::now()->startOfMonth())->where('created_at', '<', Carbon::now()->endOfMonth())->sum('amount');
        $liveChat['liveChatYearlyIncome'] = LiveChatRegistration::whereHas('liveChat', function ($q) {
            $q->where([['admin_id', auth()->user()->id]]);
        })->where('created_at', '>', Carbon::now()->startOfYear())->where('created_at', '<', Carbon::now()->endOfYear())->sum('amount');

        // Income Statement Q&A

        $qna['qnaTotalIncome'] = QnaRegistration::whereHas('qna', function ($q) {
            $q->where([['admin_id', auth()->user()->id]]);
        })->sum('amount');
        $qna['qnaDailyIncome'] = QnaRegistration::whereHas('qna', function ($q) {
            $q->where([['admin_id', auth()->user()->id]]);
        })->where('created_at', '>', Carbon::now()->startOfDay())->where('created_at', '<', Carbon::now()->endOfDay())->sum('amount');
        $qna['qnaWeeklyIncome'] = QnaRegistration::whereHas('qna', function ($q) {
            $q->where([['admin_id', auth()->user()->id]]);
        })->where('created_at', '>', Carbon::now()->startOfWeek())->where('created_at', '<', Carbon::now()->endOfWeek())->sum('amount');
        $qna['qnaMonthlyIncome'] = QnaRegistration::whereHas('qna', function ($q) {
            $q->where([['admin_id', auth()->user()->id]]);
        })->where('created_at', '>', Carbon::now()->startOfMonth())->where('created_at', '<', Carbon::now()->endOfMonth())->sum('amount');
        $qna['qnaYearlyIncome'] = QnaRegistration::whereHas('qna', function ($q) {
            $q->where([['admin_id', auth()->user()->id]]);
        })->where('created_at', '>', Carbon::now()->startOfYear())->where('created_at', '<', Carbon::now()->endOfYear())->sum('amount');

        // Income Statement Greetings

        $greeting['greetingTotalIncome'] = GreetingsRegistration::whereHas('greeting', function ($q) {
            $q->where([['admin_id', auth()->user()->id]]);
        })->sum('amount');
        $greeting['greetingDailyIncome'] = GreetingsRegistration::whereHas('greeting', function ($q) {
            $q->where([['admin_id', auth()->user()->id]]);
        })->where('created_at', '>', Carbon::now()->startOfDay())->where('created_at', '<', Carbon::now()->endOfDay())->sum('amount');
        $greeting['greetingWeeklyIncome'] = GreetingsRegistration::whereHas('greeting', function ($q) {
            $q->where([['admin_id', auth()->user()->id]]);
        })->where('created_at', '>', Carbon::now()->startOfWeek())->where('created_at', '<', Carbon::now()->endOfWeek())->sum('amount');
        $greeting['greetingMonthlyIncome'] = GreetingsRegistration::whereHas('greeting', function ($q) {
            $q->where([['admin_id', auth()->user()->id]]);
        })->where('created_at', '>', Carbon::now()->startOfMonth())->where('created_at', '<', Carbon::now()->endOfMonth())->sum('amount');
        $greeting['greetingYearlyIncome'] = GreetingsRegistration::whereHas('greeting', function ($q) {
            $q->where([['admin_id', auth()->user()->id]]);
        })->where('created_at', '>', Carbon::now()->startOfYear())->where('created_at', '<', Carbon::now()->endOfYear())->sum('amount');

        // Income Statement Auction

        $auction['auctionTotalIncome'] = Bidding::whereHas('auction', function ($q) {
            $q->where([['admin_id', auth()->user()->id]]);
        })->sum('amount');
        $auction['auctionDailyIncome'] = Bidding::whereHas('auction', function ($q) {
            $q->where([['admin_id', auth()->user()->id]]);
        })->where('created_at', '>', Carbon::now()->startOfDay())->where('created_at', '<', Carbon::now()->endOfDay())->sum('amount');
        $auction['auctionWeeklyIncome'] = Bidding::whereHas('auction', function ($q) {
            $q->where([['admin_id', auth()->user()->id]]);
        })->where('created_at', '>', Carbon::now()->startOfWeek())->where('created_at', '<', Carbon::now()->endOfWeek())->sum('amount');
        $auction['auctionMonthlyIncome'] = Bidding::whereHas('auction', function ($q) {
            $q->where([['admin_id', auth()->user()->id]]);
        })->where('created_at', '>', Carbon::now()->startOfMonth())->where('created_at', '<', Carbon::now()->endOfMonth())->sum('amount');
        $auction['auctionYearlyIncome'] = Bidding::whereHas('auction', function ($q) {
            $q->where([['admin_id', auth()->user()->id]]);
        })->where('created_at', '>', Carbon::now()->startOfYear())->where('created_at', '<', Carbon::now()->endOfYear())->sum('amount');

        // Income Statement Marketplace

        $marketplace['marketplaceTotalIncome'] = MarketplaceOrder::whereHas('marketplace', function ($q) {
            $q->where([['superstar_admin_id', auth()->user()->id]]);
        })->sum('total_price');
        $marketplace['marketplaceDailyIncome'] = MarketplaceOrder::whereHas('marketplace', function ($q) {
            $q->where([['superstar_admin_id', auth()->user()->id]]);
        })->where('created_at', '>', Carbon::now()->startOfDay())->where('created_at', '<', Carbon::now()->endOfDay())->sum('total_price');
        $marketplace['marketplaceWeeklyIncome'] = MarketplaceOrder::whereHas('marketplace', function ($q) {
            $q->where([['superstar_admin_id', auth()->user()->id]]);
        })->where('created_at', '>', Carbon::now()->startOfWeek())->where('created_at', '<', Carbon::now()->endOfWeek())->sum('total_price');
        $marketplace['marketplaceMonthlyIncome'] = MarketplaceOrder::whereHas('marketplace', function ($q) {
            $q->where([['superstar_admin_id', auth()->user()->id]]);
        })->where('created_at', '>', Carbon::now()->startOfMonth())->where('created_at', '<', Carbon::now()->endOfMonth())->sum('total_price');
        $marketplace['marketplaceYearlyIncome'] = MarketplaceOrder::whereHas('marketplace', function ($q) {
            $q->where([['superstar_admin_id', auth()->user()->id]]);
        })->where('created_at', '>', Carbon::now()->startOfYear())->where('created_at', '<', Carbon::now()->endOfYear())->sum('total_price');



        // Income Statement Souvenir

        $souvenir['souvenirTotalIncome'] = SouvenirApply::whereHas('souvenir', function ($q) {
            $q->where([['admin_id', auth()->user()->id]]);
        })->sum('total_amount');
        $souvenir['souvenirDailyIncome'] = SouvenirApply::whereHas('souvenir', function ($q) {
            $q->where([['admin_id', auth()->user()->id]]);
        })->where('created_at', '>', Carbon::now()->startOfDay())->where('created_at', '<', Carbon::now()->endOfDay())->sum('total_amount');
        $souvenir['souvenirWeeklyIncome'] = SouvenirApply::whereHas('souvenir', function ($q) {
            $q->where([['admin_id', auth()->user()->id]]);
        })->where('created_at', '>', Carbon::now()->startOfWeek())->where('created_at', '<', Carbon::now()->endOfWeek())->sum('total_amount');
        $souvenir['souvenirMonthlyIncome'] = SouvenirApply::whereHas('souvenir', function ($q) {
            $q->where([['admin_id', auth()->user()->id]]);
        })->where('created_at', '>', Carbon::now()->startOfMonth())->where('created_at', '<', Carbon::now()->endOfMonth())->sum('total_amount');
        $souvenir['souvenirYearlyIncome'] = SouvenirApply::whereHas('souvenir', function ($q) {
            $q->where([['admin_id', auth()->user()->id]]);
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
    public function adminPost($type)
    {
        if ($type == "Simple-Post") {
            $post = SimplePost::where('admin_id', auth('sanctum')->user()->id)->latest()->get();
        } elseif ($type == "Live-Chat") {
            $post = LiveChat::with('registeredLiveChats')->where('admin_id', auth('sanctum')->user()->id)->latest()->get();
        } elseif ($type == "Q&A") {
            $post = QnA::with('registeredQna')->where('admin_id', auth('sanctum')->user()->id)->latest()->get();
        } elseif ($type == "Meetup-Event") {
            $post = MeetupEvent::with('registeredMeetupEvents')->where('admin_id', auth('sanctum')->user()->id)->latest()->get();
        } elseif ($type == "Learning-Session") {
            $post = LearningSession::with('registeredLearningSessions')->where('admin_id', auth('sanctum')->user()->id)->latest()->get();
        } elseif ($type == "Greeting") {
            $post = Greeting::with('registeredGreeting')->where('admin_id', auth('sanctum')->user()->id)->latest()->get();
        } elseif ($type == "Fan-Group") {
            $post = FanGroup::where('created_by', auth('sanctum')->user()->id)->orWhere('another_star_admin_id', auth('sanctum')->user()->id)->latest()->get();

            // $participant = Fan_Group_Join::whereHas('greeting', function ($q) {
            //     $q->where([['admin_id', auth()->user()->id]]);
            // })->latest()->get();
        } elseif ($type == "Auction") {
            $post = Auction::with('bidding')->where('admin_id', auth('sanctum')->user()->id)->latest()->get();
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
            $post = SimplePost::where('admin_id', auth('sanctum')->user()->id)->where('id', $id)->first();
            $participant = GeneralPostPayment::whereHas('simpleposts', function ($q) {
                $q->where([['admin_id', auth()->user()->id]]);
            })->where('post_id', $id)->get();
        } elseif ($type == "Live-Chat") {
            $post = LiveChat::where('admin_id', auth('sanctum')->user()->id)->where('id', $id)->first();
            $participant = LiveChatRegistration::whereHas('liveChat', function ($q) {
                $q->where([['admin_id', auth()->user()->id]]);
            })->where('live_chat_id', $id)->get();
        } elseif ($type == "Q&A") {
            $post = QnA::where('admin_id', auth('sanctum')->user()->id)->where('id', $id)->first();
            $participant = QnaRegistration::whereHas('qna', function ($q) {
                $q->where([['admin_id', auth()->user()->id]]);
            })->where('qna_id', $id)->get();
        } elseif ($type == "Meetup-Event") {
            $post = MeetupEvent::where('admin_id', auth('sanctum')->user()->id)->where('id', $id)->first();
            $participant = MeetupEventRegistration::whereHas('meetupEvent', function ($q) {
                $q->where([['admin_id', auth()->user()->id]]);
            })->where('meetup_event_id', $id)->get();
        } elseif ($type == "Learning-Session") {
            $post = LearningSession::where('admin_id', auth('sanctum')->user()->id)->where('id', $id)->first();
            $participant = LearningSessionRegistration::whereHas('learningSession', function ($q) {
                $q->where([['admin_id', auth()->user()->id]]);
            })->where('learning_session_id', $id)->get();
        } elseif ($type == "Greeting") {
            $post = Greeting::where('admin_id', auth('sanctum')->user()->id)->where('id', $id)->first();
            $participant = GreetingsRegistration::whereHas('greeting', function ($q) {
                $q->where([['admin_id', auth()->user()->id]]);
            })->where('greeting_id', $id)->get();
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
}
