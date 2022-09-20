<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Auction;
use App\Models\Bidding;
use App\Models\Category;
use App\Models\Greeting;
use App\Models\GreetingsRegistration;
use App\Models\GreetingType;
use App\Models\LearningSession;
use App\Models\LearningSessionAssignment;
use App\Models\LearningSessionCertificate;
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
use Carbon\Carbon;

use function PHPSTORM_META\map;

class ReportController extends Controller
{
    public function allReport()
    {
        return view('SuperAdmin.Report.AllReport.all_report');
    }

    public function learningSessionReport()
    {
        // dd($request);
        $assignment_fee = 0;
        $total_assignment_fees = LearningSession::all();

        foreach ($total_assignment_fees as $amount) {
            $assignment_fee = $assignment_fee + $amount['assignment_fee'];
        }

        $registration_fee = 0;
        $total_registration_fees = LearningSession::all();

        foreach ($total_registration_fees as $amount) {
            $registration_fee = $registration_fee + $amount['fee'];
        }

        $certificate = LearningSessionCertificate::all()->count();


        $assignment = 0;
        $total_assignments = LearningSession::all();

        foreach ($total_assignments as $amount) {
            $assignment = $assignment + $amount['assignment'];
        }

        // dd($assignment);

        // dd($total_assignment_fee);

        $categories = Category::orderBy('id', 'desc')->get();

        $subCategories = SubCategory::orderBy('id', 'desc')->get();


        return view('SuperAdmin.Report.LearningSession.learningSession_report', compact('categories', 'subCategories', 'assignment_fee', 'registration_fee', 'certificate', 'assignment'));
    }
    public function learningFilter(Request $request)
    {

        $categoryId =  $request->category_id;
        // return ($categoryId );
        $start_date = $request['start_date'];
        $end_date = $request['end_date'];
        // $start_date = Carbon::parse($request['start_date'])->format('Y-m-d g:i a');
        // $end_date = Carbon::parse($request['end_date'])->format('Y-m-d g:i a');
        // dd($request);




        $total_assignment_fees = LearningSession::whereRaw(
            "(created_at >= ? AND created_at <= ?)",
            [
                $start_date . " 00:00:00",
                $end_date . " 23:59:59"
            ]
        )->where('category_id', $request['category_id'])->where('sub_category_id', $request['sub_category_id'])->get();
        // dd($total_assignment_fees);

        $assignment_fee = 0;
        $registration_fee = 0;
        $assignment = 0;

        foreach ($total_assignment_fees as $amount) {
            $assignment_fee = $assignment_fee + $amount['assignment_fee'];
            $registration_fee = $registration_fee + $amount['fee'];
            $assignment = $assignment + $amount['assignment'];
        }



        $certificate = LearningSessionCertificate::whereHas('learningSession', function ($q) use ($categoryId) {
            $q->where('category_id',  $categoryId);
        })->whereRaw(
            "(created_at >= ? AND created_at <= ?)",
            [
                $start_date . " 00:00:00",
                $end_date . " 23:59:59"
            ]
        )->count();
        // return response()->json($certificate);
        // die();

        $categories = Category::orderBy('id', 'desc')->get();
        $subCategories = SubCategory::orderBy('id', 'desc')->get();

        return response()->json(['categories' => $categories, 'subCategories' => $subCategories, 'assignment_fee' => $assignment_fee, 'registration_fee' => $registration_fee, 'assignment' => $assignment, 'certificate' => $certificate]);

        // return view('SuperAdmin.Report.LearningSession.learningSession_report', compact('categories', 'assignment_fee','registration_fee','certificate','assignment'));
    }



    public function allSubCategory($id)
    {
        // dd($id);
        $subCategories = SubCategory::where('category_id', $id)->get();
        return response()->json($subCategories);
    }




    public function simplePostReport()
    {
        $all_post = SimplePost::all()->count();
        $total_free_post = SimplePost::where('type', 'free')->count();
        $total_paid_post = SimplePost::where('type', 'paid')->count();
        $categories = Category::orderBy('id', 'desc')->get();
        $total_published_post = SimplePost::where('status', '1')->count();
        $total_pending_post = SimplePost::where('status', '0')->count();
        $total_paid_post_fees = SimplePost::sum('fee');


        // dd($paid_post);
        return view('SuperAdmin.Report.SimplePost.simplePost_report', compact('total_free_post', 'total_paid_post', 'categories', 'total_published_post', 'total_pending_post', 'total_paid_post_fees'));
    }

    public function simplePostFilter(Request $request)
    {

        // $start_date = Carbon::parse($request->start_date)->format('Y-m-d  H:i:s');
        // $end_date = Carbon::parse($request->end_date)->format('Y-m-d  H:i:s');

        $start_date = $request['start_date'];
        $end_date = $request['end_date'];
        // // dd($request);
        // return response()->json($request);
        $enter  = false;
        if ($request['user_type'] == "manager-admin") {
            $enter = true;
            $total_free_post = SimplePost::whereRaw(
                "(created_at >= ? AND created_at <= ?)",
                [
                    $start_date . " 00:00:00",
                    $end_date . " 23:59:59"
                ]
            )->where('type', "free")->where('category_id', $request['category_id'])->where('subcategory_id', $request['subcategory_id'])->where('created_by_id', $request['user_name'])->count();
            $total_paid_post = SimplePost::whereRaw(
                "(created_at >= ? AND created_at <= ?)",
                [
                    $start_date . " 00:00:00",
                    $end_date . " 23:59:59"
                ]
            )->where('type', "paid")->where('category_id', $request['category_id'])->where('subcategory_id', $request['subcategory_id'])->where('created_by_id', $request['user_name'])->count();
            $categories = Category::orderBy('id', 'desc')->get();
            $total_published_post = SimplePost::whereRaw(
                "(created_at >= ? AND created_at <= ?)",
                [
                    $start_date . " 00:00:00",
                    $end_date . " 23:59:59"
                ]
            )->where('status', '1')->where('category_id', $request['category_id'])->where('subcategory_id', $request['subcategory_id'])->where('created_by_id', $request['user_name'])->count();
            $total_pending_post = SimplePost::whereRaw(
                "(created_at >= ? AND created_at <= ?)",
                [
                    $start_date . " 00:00:00",
                    $end_date . " 23:59:59"
                ]
            )->where('status', '0')->where('category_id', $request['category_id'])->where('subcategory_id', $request['subcategory_id'])->where('created_by_id', $request['user_name'])->count();
            $total_paid_post_fees = SimplePost::whereRaw(
                "(created_at >= ? AND created_at <= ?)",
                [
                    $start_date . " 00:00:00",
                    $end_date . " 23:59:59"
                ]
            )->where('category_id', $request['category_id'])->where('subcategory_id', $request['subcategory_id'])->where('created_by_id', $request['user_name'])->sum('fee');
        } else if ($request['user_type'] == "star") {
            $enter = true;
            $total_free_post = SimplePost::whereRaw(
                "(created_at >= ? AND created_at <= ?)",
                [
                    $start_date . " 00:00:00",
                    $end_date . " 23:59:59"
                ]
            )->where('type', "free")->where('category_id', $request['category_id'])->where('subcategory_id', $request['subcategory_id'])->where('created_by_id', $request['user_name'])->count();
            $total_paid_post = SimplePost::whereRaw(
                "(created_at >= ? AND created_at <= ?)",
                [
                    $start_date . " 00:00:00",
                    $end_date . " 23:59:59"
                ]
            )->where('type', "paid")->where('category_id', $request['category_id'])->where('subcategory_id', $request['subcategory_id'])->where('created_by_id', $request['user_name'])->count();
            $categories = Category::orderBy('id', 'desc')->get();
            $total_published_post = SimplePost::whereRaw(
                "(created_at >= ? AND created_at <= ?)",
                [
                    $start_date . " 00:00:00",
                    $end_date . " 23:59:59"
                ]
            )->where('status', '1')->where('category_id', $request['category_id'])->where('subcategory_id', $request['subcategory_id'])->where('created_by_id', $request['user_name'])->count();
            $total_pending_post = SimplePost::whereRaw(
                "(created_at >= ? AND created_at <= ?)",
                [
                    $start_date . " 00:00:00",
                    $end_date . " 23:59:59"
                ]
            )->where('status', '0')->where('category_id', $request['category_id'])->where('subcategory_id', $request['subcategory_id'])->where('created_by_id', $request['user_name'])->count();
            $total_paid_post_fees = SimplePost::whereRaw(
                "(created_at >= ? AND created_at <= ?)",
                [
                    $start_date . " 00:00:00",
                    $end_date . " 23:59:59"
                ]
            )->where('category_id', $request['category_id'])->where('subcategory_id', $request['subcategory_id'])->where('created_by_id', $request['user_name'])->sum('fee');
        } else if ($request['user_type'] == "admin") {
            $enter = true;
            $total_free_post = SimplePost::whereRaw(
                "(created_at >= ? AND created_at <= ?)",
                [
                    $start_date . " 00:00:00",
                    $end_date . " 23:59:59"
                ]
            )->where('type', "free")->where('category_id', $request['category_id'])->where('subcategory_id', $request['subcategory_id'])->where('created_by_id', $request['user_name'])->count();
            $total_paid_post = SimplePost::whereRaw(
                "(created_at >= ? AND created_at <= ?)",
                [
                    $start_date . " 00:00:00",
                    $end_date . " 23:59:59"
                ]
            )->where('type', "paid")->where('category_id', $request['category_id'])->where('subcategory_id', $request['subcategory_id'])->where('created_by_id', $request['user_name'])->count();
            $categories = Category::orderBy('id', 'desc')->get();
            $total_published_post = SimplePost::whereRaw(
                "(created_at >= ? AND created_at <= ?)",
                [
                    $start_date . " 00:00:00",
                    $end_date . " 23:59:59"
                ]
            )->where('status', '1')->where('category_id', $request['category_id'])->where('subcategory_id', $request['subcategory_id'])->where('created_by_id', $request['user_name'])->count();
            $total_pending_post = SimplePost::whereRaw(
                "(created_at >= ? AND created_at <= ?)",
                [
                    $start_date . " 00:00:00",
                    $end_date . " 23:59:59"
                ]
            )->where('status', '0')->where('category_id', $request['category_id'])->where('subcategory_id', $request['subcategory_id'])->where('created_by_id', $request['user_name'])->count();
            $total_paid_post_fees = SimplePost::whereRaw(
                "(created_at >= ? AND created_at <= ?)",
                [
                    $start_date . " 00:00:00",
                    $end_date . " 23:59:59"
                ]
            )->where('category_id', $request['category_id'])->where('subcategory_id', $request['subcategory_id'])->where('created_by_id', $request['user_name'])->sum('fee');
        }


        return response()->json(['total_free_post' => $total_free_post, 'total_paid_post' => $total_paid_post, 'total_published_post' => $total_published_post, 'total_pending_post' => $total_pending_post, 'total_paid_post_fees' => $total_paid_post_fees]);
        // return response()->json($total_free_post);
    }

    public function simplePostUserName($name)
    {

        $user_names = User::where('user_type', $name)->get();
        return response()->json($user_names);
    }


    public function liveChatReport()
    {

        $reg_fee = 0;
        $total_reg_fees = LiveChat::all();
        // dd($total_reg_fee);
        foreach ($total_reg_fees as $amount) {
            $reg_fee = $reg_fee + $amount['fee'];
        }
        $total_live_chat = LiveChatRegistration::distinct('live_chat_id')->count();

        $slot_fee = 0;
        $total_slot_fees = LiveChatRegistration::all();
        // dd($total_reg_fee);
        foreach ($total_slot_fees as $amount) {
            $slot_fee = $slot_fee + $amount['amount'];
        }
        // dd($slot_fee);

        $categories = Category::orderBy('id', 'desc')->get();

        // dd( $total_live_chat);
        return view('SuperAdmin.Report.LiveChat.liveChat_report', compact('categories', 'reg_fee', 'total_live_chat', 'slot_fee'));
    }

    public function liveChatReportFilter(Request $request)
    {
        $categoryId =  $request->category_id;
        $start_date = $request['start_date'];
        $end_date = $request['end_date'];

        $reg_fee = 0;
        $total_reg_fees = LiveChat::whereRaw(
            "(created_at >= ? AND created_at <= ?)",
            [
                $start_date . " 00:00:00",
                $end_date . " 23:59:59"
            ]
        )->where('category_id', $request['category_id'])->where('sub_category_id', $request['sub_category_id'])->get();
        // dd($total_reg_fee);
        foreach ($total_reg_fees as $amount) {
            $reg_fee = $reg_fee + $amount['fee'];
        }

        $total_live_chat = LiveChatRegistration::whereHas('liveChat', function ($q) use ($categoryId) {
            $q->where('category_id',  $categoryId);
        })->whereRaw(
            "(created_at >= ? AND created_at <= ?)",
            [
                $start_date . " 00:00:00",
                $end_date . " 23:59:59"
            ]
        )->distinct('live_chat_id')->count();

        $slot_fee = 0;
        $slot_fee = LiveChatRegistration::whereHas('liveChat', function ($q) use ($categoryId) {
            $q->where('category_id',  $categoryId);
        })->whereRaw(
            "(created_at >= ? AND created_at <= ?)",
            [
                $start_date . " 00:00:00",
                $end_date . " 23:59:59"
            ]
        )->sum('amount');
        // dd($total_reg_fee);
        // foreach ($total_slot_fees as $amount) {
        //     $slot_fee = $slot_fee + $amount['amount'];
        // }
        // dd($slot_fee);

        $categories = Category::orderBy('id', 'desc')->get();

        return response()->json(['categories' => $categories, 'reg_fee' => $reg_fee, 'total_live_chat' => $total_live_chat, 'slot_fee' => $slot_fee]);
    }



    public function meetupReport()
    {
        $meetUp_event = MeetupEvent::all()->count();
        $categories = Category::orderBy('id', 'desc')->get();
        $total_fee_online = MeetupEvent::where('meetup_type', "Online")->sum('fee');
        $total_fee_offline = MeetupEvent::where('meetup_type', "Offline")->sum('fee');
        // dd($total_fee_online, $total_fee_offline);
        return view('SuperAdmin.Report.MeetupEvent.meetupEvent_report', compact('categories', 'meetUp_event', 'total_fee_online', 'total_fee_offline'));
    }

    public function meetupReportFilter(Request $request)
    {

        $start_date = $request['start_date'];
        $end_date = $request['end_date'];

        $meetUp_event = MeetupEvent::whereRaw(
            "(created_at >= ? AND created_at <= ?)",
            [
                $start_date . " 00:00:00",
                $end_date . " 23:59:59"
            ]
        )->count();
        // return response()->json($meetUp_event);

        $total_fee_online = MeetupEvent::whereRaw(
            "(created_at >= ? AND created_at <= ?)",
            [
                $start_date . " 00:00:00",
                $end_date . " 23:59:59"
            ]
        )->where('category_id', $request['category_id'])->where('sub_category_id', $request['sub_category_id'])->where('meetup_type', "Online")->sum('fee');

        $total_fee_offline = MeetupEvent::whereRaw(
            "(created_at >= ? AND created_at <= ?)",
            [
                $start_date . " 00:00:00",
                $end_date . " 23:59:59"
            ]
        )->where('category_id', $request['category_id'])->where('sub_category_id', $request['sub_category_id'])->where('meetup_type', "Offline")->sum('fee');

        $categories = Category::orderBy('id', 'desc')->get();

        return response()->json(['categories' => $categories, 'meetUp_event' => $meetUp_event, 'total_fee_online' => $total_fee_online, 'total_fee_offline' => $total_fee_offline]);
        // return response()->json($request);
    }
    public function greetingReport()
    {
        $total_greetings_users = GreetingsRegistration::distinct('user_id')->count();
        $total_greetings_type = GreetingsRegistration::distinct('purpose')->count();
        // dd($total_greetings_type);
        $categories = Category::orderBy('id', 'desc')->get();
        return view('SuperAdmin.Report.Greetings.greetings_report', compact('categories', 'total_greetings_users', 'total_greetings_type'));
    }

    public function greetingReportFilter(Request $request)
    {
        $categoryId =  $request->category_id;
        $start_date = $request['start_date'];
        $end_date = $request['end_date'];

        $total_greetings_users = GreetingsRegistration::whereHas('greeting', function ($q) use ($categoryId) {
            $q->where('category_id',  $categoryId);
        })->whereRaw(
            "(created_at >= ? AND created_at <= ?)",
            [
                $start_date . " 00:00:00",
                $end_date . " 23:59:59"
            ]
        )->distinct('user_id')->count();
        $total_greetings_type = GreetingsRegistration::whereHas('greeting', function ($q) use ($categoryId) {
            $q->where('category_id',  $categoryId);
        })->whereRaw(
            "(created_at >= ? AND created_at <= ?)",
            [
                $start_date . " 00:00:00",
                $end_date . " 23:59:59"
            ]
        )->distinct('purpose')->count();
        // dd($total_greetings_type);
        $categories = Category::orderBy('id', 'desc')->get();
        // return response()->json($request);

        return response()->json(['categories' => $categories, 'total_greetings_users' => $total_greetings_users, 'total_greetings_type' => $total_greetings_type]);
    }
    public function fanGroupReport()
    {
        return view('SuperAdmin.Report.SimplePost.simplePost_report');
    }
    public function auditionReport()
    {
        return view('SuperAdmin.Report.SimplePost.simplePost_report');
    }
    public function qnaReport()
    {
        $qna_reg_fee = 0;
        $total_qnaReg_fees = QnA::all();
        // dd($total_reg_fees);
        foreach ($total_qnaReg_fees as $amount) {
            $qna_reg_fee = $qna_reg_fee + $amount['fee'];
        }

        $total_qna = QnaRegistration::distinct('qna_id')->count();
        // dd($total_qns);

        $qnaSlot_fee = 0;
        $total_qnaSlot_fees = QnaRegistration::all();
        // dd($total_qnaSlot_fees);
        foreach ($total_qnaSlot_fees as $amount) {
            $qnaSlot_fee = $qnaSlot_fee + $amount['amount'];
        }
        // dd($qnaSlot_fee);

        $categories = Category::orderBy('id', 'desc')->get();

        // dd( $total_live_chat);
        return view('SuperAdmin.Report.QnA.QnA_report', compact('categories', 'qna_reg_fee', 'total_qna', 'qnaSlot_fee'));
    }

    public function qnaReportFilter(Request $request)
    {
        $categoryId =  $request->category_id;
        $start_date = $request['start_date'];
        $end_date = $request['end_date'];

        $qna_reg_fee = 0;
        $total_qnaReg_fees = QnA::whereRaw(
            "(created_at >= ? AND created_at <= ?)",
            [
                $start_date . " 00:00:00",
                $end_date . " 23:59:59"
            ]
        )->where('category_id', $request['category_id'])->where('sub_category_id', $request['sub_category_id'])->get();
        // dd($total_reg_fees);
        foreach ($total_qnaReg_fees as $amount) {
            $qna_reg_fee = $qna_reg_fee + $amount['fee'];
        }

        $total_qna = QnaRegistration::whereHas('qna', function ($q) use ($categoryId) {
            $q->where('category_id',  $categoryId);
        })->whereRaw(
            "(created_at >= ? AND created_at <= ?)",
            [
                $start_date . " 00:00:00",
                $end_date . " 23:59:59"
            ]
        )->distinct('qna_id')->count();
        // dd($total_qns);

        $qnaSlot_fee = 0;
        $qnaSlot_fee = QnaRegistration::whereHas('qna', function ($q) use ($categoryId) {
            $q->where('category_id',  $categoryId);
        })->whereRaw(
            "(created_at >= ? AND created_at <= ?)",
            [
                $start_date . " 00:00:00",
                $end_date . " 23:59:59"
            ]
        )->sum('amount');
        // dd($total_qnaSlot_fees);
        // foreach ($total_qnaSlot_fees as $amount) {
        //     $qnaSlot_fee = $qnaSlot_fee + $amount['amount'];
        // }
        // dd($qnaSlot_fee);

        $categories = Category::orderBy('id', 'desc')->get();

        // dd( $total_live_chat);
        return response()->json(['categories' => $categories, 'qna_reg_fee' => $qna_reg_fee, 'total_qna' => $total_qna, 'qnaSlot_fee' => $qnaSlot_fee]);
    }
    public function marketplaceReport()
    {
        $unit_Product_price = 0;
        $tax = 0;
        $total_unit_Product_price = Marketplace::all();
        // dd($total_qnaSlot_fees);
        foreach ($total_unit_Product_price as $amount) {
            $unit_Product_price = $unit_Product_price + $amount['unit_price'];
            $tax = $tax + $amount['tax'];
        }
        // $total_items_quantity = Marketplace::sum('total_items');
        $total_items = Marketplace::count();

        $total_order = MarketplaceOrder::count();
        $categories = Category::orderBy('id', 'desc')->get();

        // dd($total_order);
        return view('SuperAdmin.Report.MarketPlace.marketPlace_report', compact('categories', 'unit_Product_price', 'tax', 'total_items', 'total_order'));
    }

    public function marketPlaceFilter(Request $request)
    {
        $categoryId =  $request->category_id;
        $start_date = $request['start_date'];
        $end_date = $request['end_date'];

        $unit_Product_price = 0;
        $tax = 0;
        $total_unit_Product_price = Marketplace::whereRaw(
            "(created_at >= ? AND created_at <= ?)",
            [
                $start_date . " 00:00:00",
                $end_date . " 23:59:59"
            ]
        )->where('category_id', $request['category_id'])->where('subcategory_id', $request['subcategory_id'])->get();
        // dd($total_qnaSlot_fees);
        foreach ($total_unit_Product_price as $amount) {
            $unit_Product_price = $unit_Product_price + $amount['unit_price'];
            $tax = $tax + $amount['tax'];
        }
        // $total_items_quantity = Marketplace::sum('total_items');
        $total_items = Marketplace::whereRaw(
            "(created_at >= ? AND created_at <= ?)",
            [
                $start_date . " 00:00:00",
                $end_date . " 23:59:59"
            ]
        )->where('category_id', $request['category_id'])->where('subcategory_id', $request['subcategory_id'])->count();

        $total_order = MarketplaceOrder::whereHas('marketplace', function ($q) use ($categoryId) {
            $q->where('category_id',  $categoryId);
        })->whereRaw(
            "(created_at >= ? AND created_at <= ?)",
            [
                $start_date . " 00:00:00",
                $end_date . " 23:59:59"
            ]
        )->count();
        $categories = Category::orderBy('id', 'desc')->get();
        // return response()->json($request);

        return response()->json(['categories' => $categories, 'unit_Product_price' => $unit_Product_price, 'tax' => $tax, 'total_items' => $total_items, 'total_order' => $total_order]);
    }
    public function auctionReport()
    {
        $base_price = 0;
        $total_base_price = Auction::all();
        // dd($total_qnaSlot_fees);
        foreach ($total_base_price as $amount) {
            $base_price = $base_price + $amount['base_price'];
        }
        $total_auction = Auction::count();
        $total_bidding = Bidding::count();
        $total_bidding_price = Bidding::sum('amount');
        $categories = Category::orderBy('id', 'desc')->get();
        // dd($total_bidding_price);
        return view('SuperAdmin.Report.Auction.auction_report', compact('categories', 'base_price', 'total_auction', 'total_bidding', 'total_bidding_price'));
    }
    public function auctionReportFilter(Request $request)
    {
        $categoryId =  $request->category_id;
        $start_date = $request['start_date'];
        $end_date = $request['end_date'];

        $base_price = 0;
        $total_base_price = Auction::whereRaw(
            "(created_at >= ? AND created_at <= ?)",
            [
                $start_date . " 00:00:00",
                $end_date . " 23:59:59"
            ]
        )->where('category_id', $request['category_id'])->where('subcategory_id', $request['subcategory_id'])->get();
        // dd($total_qnaSlot_fees);
        foreach ($total_base_price as $amount) {
            $base_price = $base_price + $amount['base_price'];
        }
        $total_auction = Auction::whereRaw(
            "(created_at >= ? AND created_at <= ?)",
            [
                $start_date . " 00:00:00",
                $end_date . " 23:59:59"
            ]
        )->where('category_id', $request['category_id'])->where('subcategory_id', $request['subcategory_id'])->count();

        $total_bidding = Bidding::whereHas('auction', function ($q) use ($categoryId) {
            $q->where('category_id',  $categoryId);
        })->whereRaw(
            "(created_at >= ? AND created_at <= ?)",
            [
                $start_date . " 00:00:00",
                $end_date . " 23:59:59"
            ]
        )->count();
        $total_bidding_price = Bidding::whereHas('auction', function ($q) use ($categoryId) {
            $q->where('category_id',  $categoryId);
        })->whereRaw(
            "(created_at >= ? AND created_at <= ?)",
            [
                $start_date . " 00:00:00",
                $end_date . " 23:59:59"
            ]
        )->sum('amount');
        $categories = Category::orderBy('id', 'desc')->get();

        // return response()->json($request);

        return response()->json(['categories' => $categories, 'base_price' => $base_price, 'total_auction' => $total_auction, 'total_bidding' => $total_bidding, 'total_bidding_price' => $total_bidding_price]);
    }
    public function souvenirReport()
    {
        $total_souvenir = SouvenirApply::count();
        $total_amount = SouvenirApply::sum('total_amount');
        $total_sounenir_item = SouvenirCreate::count();
        $total_sounenir_item_price = SouvenirCreate::sum('price');
        $categories = Category::orderBy('id', 'desc')->get();
        // dd($total_souvenir,$total_amount);
        return view('SuperAdmin.Report.Souvenir.Souvenir_report', compact('categories', 'total_souvenir', 'total_amount', 'total_sounenir_item', 'total_sounenir_item_price'));
    }
    public function souvenirReportFilter(Request $request)
    {
        $start_date = $request['start_date'];
        $end_date = $request['end_date'];

        $total_souvenir = SouvenirApply::count();
        $total_amount = SouvenirApply::sum('total_amount');
        $total_sounenir_item = SouvenirCreate::whereRaw(
            "(created_at >= ? AND created_at <= ?)",
            [
                $start_date . " 00:00:00",
                $end_date . " 23:59:59"
            ]
        )->where('category_id', $request['category_id'])->where('sub_category_id', $request['sub_category_id'])->count();

        $total_sounenir_item_price = SouvenirCreate::whereRaw(
            "(created_at >= ? AND created_at <= ?)",
            [
                $start_date . " 00:00:00",
                $end_date . " 23:59:59"
            ]
        )->where('category_id', $request['category_id'])->where('sub_category_id', $request['sub_category_id'])->sum('price');
        $categories = Category::orderBy('id', 'desc')->get();
        // dd($total_souvenir,$total_amount);
        // return response()->json($request);

        return response()->json(['categories' => $categories, 'total_souvenir' => $total_souvenir, 'total_amount' => $total_amount, 'total_sounenir_item' => $total_sounenir_item, 'total_sounenir_item_price' => $total_sounenir_item_price]);
    }




    ///kjhkjg
}
