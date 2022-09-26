<?php

namespace App\Http\Controllers\ManagerAdmin;

use App\Http\Controllers\Controller;
use App\Models\Auction;
use App\Models\Audition\Audition;
use App\Models\Bidding;
use App\Models\Category;
use App\Models\FanGroup;
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
use App\Models\SouvenirCreate;
use App\Models\SubCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountsController extends Controller
{
    public function index()
    {

        $user_subcategory_id = Auth::user()->category_id;
    
        $subCategories = SubCategory::where('category_id', $user_subcategory_id)->get();


        return view('ManagerAdmin.Accounts.index', compact('subCategories'));
    }

    public function accountSuperStarName($subCat_id)
    {
        // $sub_cat= $subCat_id;
        // $cate_id = $cat_id;

        $superstar = User::where('sub_category_id', $subCat_id)->where('user_type', "star")->get();
        // dd($superstar);
        return response()->json($superstar);
    }

    // public function allSubCategory()
    // {
    //     $user_subcategory_id = Auth::user()->category_id;
    //     $subCategories = SubCategory::where('id', $user_subcategory_id)->get();
    //     return response()->json($subCategories);

    //     // return view('ManagerAdmin.Accounts.index', compact('subCategories'));
    // }

    public function accountFilter(Request $request)
    {
        $subCate_id = $request['sub_category_id'];
        $star_id = $request['user_name'];
        $module = $request['module'];
        $start_date = $request['start_date'];
        $end_date = $request['end_date'];
        // $categoryId =  $request->category_id;
        // Module selected Learning Session
        if ($module == "1") {
            //code here..
            $simple_post = SimplePost::where('subcategory_id', $subCate_id)->where('star_id', $star_id)->whereRaw(
                "(created_at >= ? AND created_at <= ?)",
                [
                    $start_date . " 00:00:00",
                    $end_date . " 23:59:59"
                ]
            )->get();


            return response()->json($simple_post);
        } else if ($module == "2") {
            //code here..
            $user_id = Auth::id();
            
            $live_chat = LiveChat::where('created_by_id', $user_id)->where('sub_category_id', $subCate_id)->where('star_id', $star_id)->whereRaw(
                "(created_at >= ? AND created_at <= ?)",
                [
                    $start_date . " 00:00:00",
                    $end_date . " 23:59:59"
                ]
            )->get();

            $i = 0;
            foreach ($live_chat as $leSess) {
                $userReg[$i] = LiveChatRegistration::where('live_chat_id', $leSess['id'])->distinct('user_id')->count();
                $i++;
            }
;
            $i = 0;
            foreach ($live_chat as $leSess) {
                $total_amount[$i] = LiveChatRegistration::where('live_chat_id', $leSess['id'])->sum('amount');
                $i++;
            }
            return response()->json(['live_chat' => $live_chat, 'userReg' => $userReg, 'total_amount' => $total_amount, 'module' => $module]);

        } else if ($module == "3") {
            //code here..
            $user_id = Auth::id();
            $greetings = Greeting::where('created_by_id', $user_id)->where('sub_category_id', $subCate_id)->where('star_id', $star_id)->whereRaw(
                "(created_at >= ? AND created_at <= ?)",
                [
                    $start_date . " 00:00:00",
                    $end_date . " 23:59:59"
                ]
            )->get();

            $i = 0;
            foreach ($greetings as $leSess) {
                $userReg[$i] = GreetingsRegistration::where('greeting_id', $leSess['id'])->distinct('user_id')->count();
                $i++;
            }

            $i = 0;
            foreach ($greetings as $leSess) {
                $total_amount[$i] = GreetingsRegistration::where('greeting_id', $leSess['id'])->sum('amount');
                $i++;
            }



            return response()->json(['greetings' => $greetings, 'userReg' => $userReg, 'total_amount' => $total_amount, 'module' => $module]);
        } else if ($module == "4") {
            //code here..
            $user_id = Auth::id();
            $learning_seassion = LearningSession::where('created_by_id', $user_id)->where('sub_category_id', $subCate_id)->where('star_id', $star_id)->whereRaw(
                "(created_at >= ? AND created_at <= ?)",
                [
                    $start_date . " 00:00:00",
                    $end_date . " 23:59:59"
                ]
            )->get();

            $i = 0;
            foreach ($learning_seassion as $leSess) {
                // $userReg_id[$i] = LearningSessionRegistration::select('id')->where('learning_session_id', $leSess['id'])->get();
                $userReg[$i] = LearningSessionRegistration::where('learning_session_id', $leSess['id'])->distinct('user_id')->count();
                $i++;
            }

            $i = 0;
            foreach ($learning_seassion as $leSess) {
                $total_amount[$i] = LearningSessionRegistration::where('learning_session_id', $leSess['id'])->sum('amount');
                $i++;
            }


            return response()->json(['learning_seassion' => $learning_seassion, 'userReg' => $userReg, 'total_amount' => $total_amount, 'module' => $module,]);
        } else if ($module == "5") {
            //code here..
            $user_id = Auth::id();
            $meetup_event = MeetupEvent::where('created_by_id', $user_id)->where('sub_category_id', $subCate_id)->where('star_id', $star_id)->whereRaw(
                "(created_at >= ? AND created_at <= ?)",
                [
                    $start_date . " 00:00:00",
                    $end_date . " 23:59:59"
                ]
            )->get();


            $i = 0;
            foreach ($meetup_event as $leSess) {
                $userReg[$i] = MeetupEventRegistration::where('meetup_event_id', $leSess['id'])->distinct('user_id')->count();
                $i++;
            }

            $i = 0;
            foreach ($meetup_event as $leSess) {
                $total_amount[$i] = MeetupEventRegistration::where('meetup_event_id', $leSess['id'])->sum('amount');
                $i++;
            }
            return response()->json(['meetup_event' => $meetup_event, 'userReg' => $userReg, 'total_amount' => $total_amount, 'module' => $module]);
        }

        // else if ($module == "6") {
        //     //code here..
        //     $audition = Audition::where('sub_category_id', $subCate_id)->where('star_id', $star_id)->whereRaw(
        //         "(created_at >= ? AND created_at <= ?)",
        //         [
        //             $start_date . " 00:00:00",
        //             $end_date . " 23:59:59"
        //         ]
        //     )->get();
        //     return response()->json( $audition);
        // }

        else if ($module == "7") {
            //code here..
            $user_id = Auth::id();
            $qna = QnA::where('created_by_id', $user_id)->where('sub_category_id', $subCate_id)->where('star_id', $star_id)->whereRaw(
                "(created_at >= ? AND created_at <= ?)",
                [
                    $start_date . " 00:00:00",
                    $end_date . " 23:59:59"
                ]
            )->get();

            $i = 0;
            foreach ($qna as $leSess) {
                $userReg[$i] = QnaRegistration::where('qna_id', $leSess['id'])->distinct('user_id')->count();
                $i++;
            }

            $i = 0;
            foreach ($qna as $leSess) {
                $total_amount[$i] = QnaRegistration::where('qna_id', $leSess['id'])->sum('amount');
                $i++;
            }

            return response()->json(['qna' => $qna, 'userReg' => $userReg, 'total_amount' => $total_amount, 'module' => $module]);
        } else if ($module == "6") {
            //code here..
            $audition = Audition::where('subcategory_id', $subCate_id)->where('star_id', $star_id)->whereRaw(
                "(created_at >= ? AND created_at <= ?)",
                [
                    $start_date . " 00:00:00",
                    $end_date . " 23:59:59"
                ]
            )->get();
            return response()->json($audition);
        } else if ($module == "9") {
            //code here..
            $user_id = Auth::id();
            $marketPlace = Marketplace::where('created_by_id', $user_id)->where('subcategory_id', $subCate_id)->where('superstar_id', $star_id)->whereRaw(
                "(created_at >= ? AND created_at <= ?)",
                [
                    $start_date . " 00:00:00",
                    $end_date . " 23:59:59"
                ]
            )->get();

            $i = 0;
            foreach ($marketPlace as $leSess) {
                $userReg[$i] = MarketplaceOrder::where('marketplace_id', $leSess['id'])->distinct('user_id')->count();
                $i++;
            }

            $i = 0;
            foreach ($marketPlace as $leSess) {
                $total_amount[$i] = MarketplaceOrder::where('marketplace_id', $leSess['id'])->sum('unit_price');
                $i++;
            }

            return response()->json(['marketPlace' => $marketPlace, 'userReg' => $userReg, 'total_amount' => $total_amount, 'module' => $module]);
        } else if ($module == "10") {
            //code here..

            $souvenir = SouvenirCreate::where('sub_category_id', $subCate_id)->where('star_id', $star_id)->whereRaw(
                "(created_at >= ? AND created_at <= ?)",
                [
                    $start_date . " 00:00:00",
                    $end_date . " 23:59:59"
                ]
            )->get();

            $i = 0;
            foreach ($souvenir as $leSess) {
                $userReg[$i] = SouvenirApply::where('souvenir_id', $leSess['id'])->distinct('user_id')->count();
                $i++;
            }

            $i = 0;
            foreach ($souvenir as $leSess) {
                $total_amount[$i] = SouvenirApply::where('souvenir_id', $leSess['id'])->sum('total_amount');
                $i++;
            }
            return response()->json(['souvenir' => $souvenir, 'userReg' => $userReg, 'total_amount' => $total_amount, 'module' => $module]);
        }else if ($module == "8") {
            //code here..
            $user_id = Auth::id();
            $auction = Auction::where('created_by_id', $user_id)->where('subcategory_id', $subCate_id)->where('star_id', $star_id)->whereRaw(
                "(created_at >= ? AND created_at <= ?)",
                [
                    $start_date . " 00:00:00",
                    $end_date . " 23:59:59"
                ]
            )->get();

            $i = 0;
            foreach ($auction as $leSess) {
                $userReg[$i] = Bidding::where('auction_id', $leSess['id'])->distinct('user_id')->count();
                $i++;
            }
            $i = 0;
            foreach ($auction as $leSess) {
                $total_amount[$i] = Bidding::where('auction_id', $leSess['id'])->sum('amount');
                $i++;
            }
            return response()->json(['auction' => $auction, 'userReg' => $userReg, 'total_amount' => $total_amount, 'module' => $module]);

        } else if ($module == "11") {
            //code here..
            $fanGroup = FanGroup::where('sub_category_id', $subCate_id)->where('my_star', $star_id)->whereRaw(
                "(created_at >= ? AND created_at <= ?)",
                [
                    $start_date . " 00:00:00",
                    $end_date . " 23:59:59"
                ]
            )->get();
            return response()->json($fanGroup);
        }
    }

    public function superstarList($id, $module)
    {

        if ($module == "4") {
            $learning_seassion_reg = LearningSessionRegistration::where('learning_session_id', $id)->get();
            $user_info = User::where('id',$id)->get();

            return view('ManagerAdmin.Accounts.Superstar.superstarEventList', compact('module','learning_seassion_reg'));
        }
       else if ($module == "5") {

            $learning_seassion_reg = MeetupEventRegistration::where('meetup_event_id', $id)->get();

            return view('ManagerAdmin.Accounts.Superstar.superstarEventList', compact('module','learning_seassion_reg'));
        }
        else if ($module == "7") {

            $learning_seassion_reg = QnaRegistration::where('qna_id', $id)->get();

            return view('ManagerAdmin.Accounts.Superstar.superstarEventList', compact('module','learning_seassion_reg'));
        }
        else if ($module == "2") {

            $learning_seassion_reg = LiveChatRegistration::where('live_chat_id', $id)->get();

            return view('ManagerAdmin.Accounts.Superstar.superstarEventList', compact('module','learning_seassion_reg'));
        }
        else if ($module == "3") {

            $learning_seassion_reg = GreetingsRegistration::where('greeting_id', $id)->get();

            return view('ManagerAdmin.Accounts.Superstar.superstarEventList', compact('module','learning_seassion_reg'));
        }  else if ($module == "8") {

            $learning_seassion_reg = Bidding::where('auction_id', $id)->get();

            return view('ManagerAdmin.Accounts.Superstar.superstarEventList', compact('module','learning_seassion_reg'));
        }
        else if ($module == "9") {

            $learning_seassion_reg = MarketplaceOrder::where('marketplace_id', $id)->get();

            return view('ManagerAdmin.Accounts.Superstar.superstarEventList', compact('module','learning_seassion_reg'));
        }
        else if ($module == "10") {

            $learning_seassion_reg = SouvenirApply::where('souvenir_id', $id)->get();

            return view('ManagerAdmin.Accounts.Superstar.superstarEventList', compact('module','learning_seassion_reg'));
        }
    }

    // public function totalEvents()
    // {

    //     return view('SuperAdmin.Accounts.Events.totalEvents');
    // }
    // public function dailyEvents()
    // {

    //     return view('SuperAdmin.Accounts.Events.dailyEvents');
    // }
    // public function weeklyEvents()
    // {

    //     return view('SuperAdmin.Accounts.Events.weeklyEvents');
    // }
    // public function monthlyEvents()
    // {

    //     return view('SuperAdmin.Accounts.Events.monthlyEvents');
    // }
    // public function yearlyEvents()
    // {

    //     return view('SuperAdmin.Accounts.Events.yearlyEvents');
    // }


    // Simple Post


    // public function simplePostTotalIncome()
    // {

    //     return view('SuperAdmin.Accounts.Events.SimplePost.simplePostTotalIncome');
    // }
    // public function simplePostDailyIncome()
    // {

    //     return view('SuperAdmin.Accounts.Events.SimplePost.simplePostDailyIncome');
    // }
    // public function simplePostWeeklyIncome()
    // {

    //     return view('SuperAdmin.Accounts.Events.SimplePost.simplePostWeeklyIncome');
    // }
    // public function simplePostMonthlyIncome()
    // {

    //     return view('SuperAdmin.Accounts.Events.SimplePost.simplePostMonthlyIncome');
    // }
    // public function simplePostYearlyIncome()
    // {

    //     return view('SuperAdmin.Accounts.Events.SimplePost.simplePostYearlyIncome');
    // }

    // // live chats
    // public function liveChatTotalIncome()
    // {

    //     return view('SuperAdmin.Accounts.Events.LiveChat.liveChatTotalIncome');
    // }
    // public function liveChatDailyIncome()
    // {

    //     return view('SuperAdmin.Accounts.Events.LiveChat.liveChatDailyIncome');
    // }
    // public function liveChatWeeklyIncome()
    // {

    //     return view('SuperAdmin.Accounts.Events.LiveChat.liveChatWeeklyIncome');
    // }
    // public function liveChatMonthlyIncome()
    // {

    //     return view('SuperAdmin.Accounts.Events.LiveChat.liveChatMonthlyIncome');
    // }
    // public function liveChatYearlyIncome()
    // {

    //     return view('SuperAdmin.Accounts.Events.LiveChat.liveChatYearlyIncome');
    // }
    // // meetup events
    // public function meetupTotalIncome()
    // {

    //     return view('SuperAdmin.Accounts.Events.Meetup.meetupTotalIncome');
    // }
    // public function meetupDailyIncome()
    // {

    //     return view('SuperAdmin.Accounts.Events.Meetup.meetupDailyIncome');
    // }
    // public function meetupWeeklyIncome()
    // {

    //     return view('SuperAdmin.Accounts.Events.Meetup.meetupWeeklyIncome');
    // }
    // public function meetupMonthlyIncome()
    // {

    //     return view('SuperAdmin.Accounts.Events.Meetup.meetupMonthlyIncome');
    // }
    // public function meetupYearlyIncome()
    // {

    //     return view('SuperAdmin.Accounts.Events.Meetup.meetupYearlyIncome');
    // }

    // // Greetings

    // public function greetingTotalIncome()
    // {

    //     return view('SuperAdmin.Accounts.Events.Greeting.greetingTotalIncome');
    // }
    // public function greetingDailyIncome()
    // {

    //     return view('SuperAdmin.Accounts.Events.Greeting.greetingDailyIncome');
    // }
    // public function greetingWeeklyIncome()
    // {

    //     return view('SuperAdmin.Accounts.Events.Greeting.greetingWeeklyIncome');
    // }
    // public function greetingMonthlyIncome()
    // {

    //     return view('SuperAdmin.Accounts.Events.Greeting.greetingMonthlyIncome');
    // }
    // public function greetingYearlyIncome()
    // {

    //     return view('SuperAdmin.Accounts.Events.Greeting.greetingYearlyIncome');
    // }
    // // learningSession
    // public function learningSessionTotalIncome()
    // {

    //     return view('SuperAdmin.Accounts.Events.LearningSession.learningSessionTotalIncome');
    // }
    // public function learningSessionDailyIncome()
    // {

    //     return view('SuperAdmin.Accounts.Events.LearningSession.learningSessionDailyIncome');
    // }
    // public function learningSessionWeeklyIncome()
    // {

    //     return view('SuperAdmin.Accounts.Events.LearningSession.learningSessionWeeklyIncome');
    // }
    // public function learningSessionMonthlyIncome()
    // {

    //     return view('SuperAdmin.Accounts.Events.LearningSession.learningSessionMonthlyIncome');
    // }
    // public function learningSessionYearlyIncome()
    // {

    //     return view('SuperAdmin.Accounts.Events.LearningSession.learningSessionYearlyIncome');
    // }
    // // Audition
    // public function auditionTotalIncome()
    // {

    //     return view('SuperAdmin.Accounts.Events.Audition.auditionTotalIncome');
    // }
    // public function auditionDailyIncome()
    // {

    //     return view('SuperAdmin.Accounts.Events.Audition.auditionDailyIncome');
    // }
    // public function auditionWeeklyIncome()
    // {

    //     return view('SuperAdmin.Accounts.Events.Audition.auditionWeeklyIncome');
    // }
    // public function auditionMonthlyIncome()
    // {

    //     return view('SuperAdmin.Accounts.Events.Audition.auditionMonthlyIncome');
    // }
    // public function auditionYearlyIncome()
    // {

    //     return view('SuperAdmin.Accounts.Events.Audition.auditionYearlyIncome');
    // }
    // // Qna
    // public function qnaTotalIncome()
    // {

    //     return view('SuperAdmin.Accounts.Events.QnA.qnaTotalIncome');
    // }
    // public function qnaDailyIncome()
    // {

    //     return view('SuperAdmin.Accounts.Events.QnA.qnaDailyIncome');
    // }
    // public function qnaWeeklyIncome()
    // {

    //     return view('SuperAdmin.Accounts.Events.QnA.qnaWeeklyIncome');
    // }
    // public function qnaMonthlyIncome()
    // {

    //     return view('SuperAdmin.Accounts.Events.QnA.qnaMonthlyIncome');
    // }
    // public function qnaYearlyIncome()
    // {

    //     return view('SuperAdmin.Accounts.Events.QnA.qnaYearlyIncome');
    // }
    // // marketplace
    // public function marketplaceTotalIncome()
    // {

    //     return view('SuperAdmin.Accounts.Events.StarShowcase.Marketplace.marketplaceTotalIncome');
    // }
    // public function marketplaceDailyIncome()
    // {

    //     return view('SuperAdmin.Accounts.Events.StarShowcase.Marketplace.marketplaceDailyIncome');
    // }
    // public function marketplaceWeeklyIncome()
    // {

    //     return view('SuperAdmin.Accounts.Events.StarShowcase.Marketplace.marketplaceWeeklyIncome');
    // }
    // public function marketplaceMonthlyIncome()
    // {

    //     return view('SuperAdmin.Accounts.Events.StarShowcase.Marketplace.marketplaceMonthlyIncome');
    // }
    // public function marketplaceYearlyIncome()
    // {

    //     return view('SuperAdmin.Accounts.Events.StarShowcase.Marketplace.marketplaceYearlyIncome');
    // }
    // // souvenir
    // public function souvenirTotalIncome()
    // {

    //     return view('SuperAdmin.Accounts.Events.StarShowcase.Souvenir.souvenirTotalIncome');
    // }
    // public function souvenirDailyIncome()
    // {

    //     return view('SuperAdmin.Accounts.Events.StarShowcase.Souvenir.souvenirDailyIncome');
    // }
    // public function souvenirWeeklyIncome()
    // {

    //     return view('SuperAdmin.Accounts.Events.StarShowcase.Souvenir.souvenirWeeklyIncome');
    // }
    // public function souvenirMonthlyIncome()
    // {

    //     return view('SuperAdmin.Accounts.Events.StarShowcase.Souvenir.souvenirMonthlyIncome');
    // }
    // public function souvenirYearlyIncome()
    // {

    //     return view('SuperAdmin.Accounts.Events.StarShowcase.Souvenir.souvenirYearlyIncome');
    // }
    // // auction
    // public function auctionTotalIncome()
    // {

    //     return view('SuperAdmin.Accounts.Events.StarShowcase.Auction.auctionTotalIncome');
    // }
    // public function auctionDailyIncome()
    // {

    //     return view('SuperAdmin.Accounts.Events.StarShowcase.Auction.auctionDailyIncome');
    // }
    // public function auctionWeeklyIncome()
    // {

    //     return view('SuperAdmin.Accounts.Events.StarShowcase.Auction.auctionWeeklyIncome');
    // }
    // public function auctionMonthlyIncome()
    // {

    //     return view('SuperAdmin.Accounts.Events.StarShowcase.Auction.auctionMonthlyIncome');
    // }
    // public function auctionYearlyIncome()
    // {

    //     return view('SuperAdmin.Accounts.Events.StarShowcase.Auction.auctionYearlyIncome');
    // }

    // // fan gorup
    // public function fanGroupTotalIncome()
    // {

    //     return view('SuperAdmin.Accounts.Events.FanGroup.fanGroupTotalIncome');
    // }
    // public function fanGroupDailyIncome()
    // {

    //     return view('SuperAdmin.Accounts.Events.FanGroup.fanGroupDailyIncome');
    // }
    // public function fanGroupWeeklyIncome()
    // {

    //     return view('SuperAdmin.Accounts.Events.FanGroup.fanGroupWeeklyIncome');
    // }
    // public function fanGroupMonthlyIncome()
    // {

    //     return view('SuperAdmin.Accounts.Events.FanGroup.fanGroupMonthlyIncome');
    // }
    // public function fanGroupYearlyIncome()
    // {

    //     return view('SuperAdmin.Accounts.Events.FanGroup.fanGroupYearlyIncome');
    // }
    // public function managerAdminList()
    // {

    //     return view('SuperAdmin.Accounts.ManagerAdmin.managerAdminList');
    // }
    // public function managerAdminIncome()
    // {

    //     return view('SuperAdmin.Accounts.ManagerAdmin.managerAdminIncome');
    // }
    // public function adminList()
    // {

    //     return view('SuperAdmin.Accounts.Admin.adminList');
    // }
    // public function adminIncome()
    // {

    //     return view('SuperAdmin.Accounts.Admin.adminIncome');
    // }

    // public function superstarIncome()
    // {

    //     return view('SuperAdmin.Accounts.Superstar.superstarIncome');
    // }
    // public function auditionAdminList()
    // {

    //     return view('SuperAdmin.Accounts.AuditionAdmin.auditionAdminList');
    // }
    // public function auditionAdminIncome()
    // {

    //     return view('SuperAdmin.Accounts.AuditionAdmin.auditionAdminIncome');
    // }
}
