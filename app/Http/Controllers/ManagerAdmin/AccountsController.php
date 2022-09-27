<?php

namespace App\Http\Controllers\ManagerAdmin;

use App\Http\Controllers\Controller;
use App\Models\Auction;
use App\Models\Audition\Audition;
use App\Models\Bidding;
use App\Models\Category;
use App\Models\Fan_Group_Join;
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


        $superstar = User::where('sub_category_id', $subCat_id)->where('user_type', "star")->get();

        return response()->json($superstar);
    }


    public function accountFilter(Request $request)
    {
        $subCate_id = $request['sub_category_id'];
        $star_id = $request['user_name'];
        $module = $request['module'];
        $start_date = $request['start_date'];
        $end_date = $request['end_date'];

        if ($module == "1") {

            $simple_post = SimplePost::where('subcategory_id', $subCate_id)->where('star_id', $star_id)->whereRaw(
                "(created_at >= ? AND created_at <= ?)",
                [
                    $start_date . " 00:00:00",
                    $end_date . " 23:59:59"
                ]
            )->get();


            return response()->json($simple_post);
        } else if ($module == "2") {

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
            };
            $i = 0;
            foreach ($live_chat as $leSess) {
                $total_amount[$i] = LiveChatRegistration::where('live_chat_id', $leSess['id'])->sum('amount');
                $i++;
            }
            return response()->json(['live_chat' => $live_chat, 'userReg' => $userReg, 'total_amount' => $total_amount, 'module' => $module]);
        } else if ($module == "3") {

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

            $audition = Audition::where('subcategory_id', $subCate_id)->where('star_id', $star_id)->whereRaw(
                "(created_at >= ? AND created_at <= ?)",
                [
                    $start_date . " 00:00:00",
                    $end_date . " 23:59:59"
                ]
            )->get();
            return response()->json($audition);
        } else if ($module == "9") {

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

            $user_id = User::where('created_by', Auth::id())->where('user_type', 'admin')->get();



            foreach ($user_id as $usr) {
                $souvenir = SouvenirCreate::where('admin_id', $usr->id)->where('sub_category_id', $subCate_id)->where('star_id', $star_id)->whereRaw(
                    "(created_at >= ? AND created_at <= ?)",
                    [
                        $start_date . " 00:00:00",
                        $end_date . " 23:59:59"
                    ]
                )->first();
                if ($souvenir != null) {
                    break;
                }
            }
            // $userReg = SouvenirApply::where('souvenir_id', $souvenir->id)->distinct('user_id')->count();

            // $total_amount = SouvenirApply::where('souvenir_id', $souvenir->id)->sum('total_amount');
            
            $i = 0;
            foreach ($souvenir as $leSess) {
                $userReg[$i] = SouvenirApply::where('souvenir_id', $leSess['id'])->distinct('user_id')
                ->count();
                $i++;
            }
             return response()->json($userReg);
            die();
            // $i = 0;
            // foreach ($souvenir as $leSess) {
            //     $total_amount[$i] = SouvenirApply::where('admin_id', $user_id)->where('souvenir_id', $leSess['id'])->sum('total_amount');
            //     $i++;
            // }
            // return response()->json(['souvenir' => $souvenir, 'userReg' => $userReg, 'total_amount' => $total_amount, 'module' => $module]);
        } else if ($module == "8") {

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

            $user_id = Auth::id();
            $fanGroup = FanGroup::where('created_by', $user_id)->where('sub_category_id', $subCate_id)->where('my_star', $star_id)->whereRaw(
                "(created_at >= ? AND created_at <= ?)",
                [
                    $start_date . " 00:00:00",
                    $end_date . " 23:59:59"
                ]
            )->get();
            // return response()->json($fanGroup);
            $i = 0;
            foreach ($fanGroup as $leSess) {
                $userReg[$i] = Fan_Group_Join::where('fan_group_id', $leSess['id'])->distinct('user_id')->count();
                $i++;
            }
            $i = 0;
            foreach ($fanGroup as $leSess) {
                $total_amount[$i] = FanGroup::where('id', $leSess['id'])->sum('club_points');
                $i++;
            }
            return response()->json(['fanGroup' => $fanGroup, 'userReg' => $userReg, 'total_amount' => $total_amount, 'module' => $module]);
        }
    }

    public function superstarList($id, $module)
    {

        if ($module == "4") {
            $learning_seassion_reg = LearningSessionRegistration::where('learning_session_id', $id)->get();
            $user_info = User::where('id', $id)->get();

            return view('ManagerAdmin.Accounts.Superstar.superstarEventList', compact('module', 'learning_seassion_reg'));
        } else if ($module == "5") {

            $learning_seassion_reg = MeetupEventRegistration::where('meetup_event_id', $id)->get();

            return view('ManagerAdmin.Accounts.Superstar.superstarEventList', compact('module', 'learning_seassion_reg'));
        } else if ($module == "7") {

            $learning_seassion_reg = QnaRegistration::where('qna_id', $id)->get();

            return view('ManagerAdmin.Accounts.Superstar.superstarEventList', compact('module', 'learning_seassion_reg'));
        } else if ($module == "2") {

            $learning_seassion_reg = LiveChatRegistration::where('live_chat_id', $id)->get();

            return view('ManagerAdmin.Accounts.Superstar.superstarEventList', compact('module', 'learning_seassion_reg'));
        } else if ($module == "3") {

            $learning_seassion_reg = GreetingsRegistration::where('greeting_id', $id)->get();

            return view('ManagerAdmin.Accounts.Superstar.superstarEventList', compact('module', 'learning_seassion_reg'));
        } else if ($module == "8") {

            $learning_seassion_reg = Bidding::where('auction_id', $id)->get();

            return view('ManagerAdmin.Accounts.Superstar.superstarEventList', compact('module', 'learning_seassion_reg'));
        } else if ($module == "9") {

            $learning_seassion_reg = MarketplaceOrder::where('marketplace_id', $id)->get();

            return view('ManagerAdmin.Accounts.Superstar.superstarEventList', compact('module', 'learning_seassion_reg'));
        } else if ($module == "10") {

            $learning_seassion_reg = SouvenirApply::where('souvenir_id', $id)->get();

            return view('ManagerAdmin.Accounts.Superstar.superstarEventList', compact('module', 'learning_seassion_reg'));
        } else if ($module == "11") {

            $learning_seassion_reg = Fan_Group_Join::where('fan_group_id', $id)->get();

            return view('ManagerAdmin.Accounts.Superstar.superstarEventList', compact('module', 'learning_seassion_reg'));
        }
    }
}
