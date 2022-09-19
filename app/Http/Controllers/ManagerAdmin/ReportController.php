<?php

namespace App\Http\Controllers\ManagerAdmin;

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
        return view('ManagerAdmin.Report.AllReport.all_report');
    }

    public function learningSessionReport()
    {
        $user_id = Auth::id();
        $assignment_fee = 0;
        $total_assignment_fees = LearningSession::where('created_by_id', $user_id)->get();
        foreach ($total_assignment_fees as $amount) {
            $assignment_fee = $assignment_fee + $amount['assignment_fee'];
        }

        $registration_fee = 0;
        $total_registration_fees = LearningSession::where('created_by_id', $user_id)->get();

        foreach ($total_registration_fees as $amount) {
            $registration_fee = $registration_fee + $amount['fee'];
        }

        $certificate = LearningSessionCertificate::whereHas('learningSession', function ($q) {
            $q->where('category_id', auth()->user()->category_id);
        })->count();


        $assignment = 0;
        $total_assignments = LearningSession::where('created_by_id', $user_id)->get();

        foreach ($total_assignments as $amount) {
            $assignment = $assignment + $amount['assignment'];
        }

        // dd($assignment);

        // dd($total_assignment_fee);

        $user_category_id = Auth::user()->category_id;
        $categories = Category::where('id', $user_category_id)->get();

        $subCategories = SubCategory::orderBy('id', 'desc')->get();


        return view('ManagerAdmin.Report.LearningSession.learningSession_report', compact('categories', 'subCategories', 'assignment_fee', 'registration_fee', 'certificate', 'assignment'));
    }
    public function learningFilter(Request $request)
    {
        $user_id = $request->user_name;
        $start_date = $request['start_date'];
        $end_date = $request['end_date'];

        if ($request['user_type'] == "star") {
            $enter = true;

            $registration_fee = LearningSession::whereBetween('created_at', [$start_date, $end_date])->where('star_id', $request['user_name'])->where('category_id', $request['category_id'])->where('sub_category_id', $request['sub_category_id'])->sum('fee');
            $assignment_fee = LearningSession::whereBetween('created_at', [$start_date, $end_date])->where('star_id', $request['user_name'])->where('category_id', $request['category_id'])->where('sub_category_id', $request['sub_category_id'])->sum('assignment_fee');

            $assignment = LearningSession::whereBetween('created_at', [$start_date, $end_date])->where('star_id', $request['user_name'])->where('category_id', $request['category_id'])->where('sub_category_id', $request['sub_category_id'])->count();


            $certificate = LearningSessionCertificate::whereBetween('created_at', [$start_date, $end_date])->count();


            $user_category_id = Auth::user()->category_id;
            $categories = Category::where('id', $user_category_id)->get();
            $subCategories = SubCategory::orderBy('id', 'desc')->get();
        } else if ($request['user_type'] == "admin") {

            $registration_fee = LearningSession::whereBetween('created_at', [$start_date, $end_date])->where('admin_id', $request['user_name'])->where('category_id', $request['category_id'])->where('sub_category_id', $request['sub_category_id'])->sum('fee');
            $assignment_fee = LearningSession::whereBetween('created_at', [$start_date, $end_date])->where('admin_id', $request['user_name'])->where('category_id', $request['category_id'])->where('sub_category_id', $request['sub_category_id'])->sum('assignment_fee');

            $assignment = LearningSession::whereBetween('created_at', [$start_date, $end_date])->where('admin_id', $request['user_name'])->where('category_id', $request['category_id'])->where('sub_category_id', $request['sub_category_id'])->count();


            $certificate = LearningSessionCertificate::whereHas('learningSession', function ($q) use ($user_id) {
                $q->where('admin_id',  $user_id);
            })->whereBetween('created_at', [$start_date, $end_date])->count();


            $categories = Category::orderBy('id', 'desc')->get();
            $subCategories = SubCategory::orderBy('id', 'desc')->get();
        }

        return response()->json(['categories' => $categories, 'subCategories' => $subCategories, 'assignment_fee' => $assignment_fee, 'registration_fee' => $registration_fee, 'assignment' => $assignment, 'certificate' => $certificate]);
    }



    public function allSubCategory($id)
    {
        // dd($id);
        $subCategories = SubCategory::where('category_id', $id)->get();
        return response()->json($subCategories);
    }




    public function simplePostReport()
    {
        $user_id = Auth::id();
        // dd($user_id);
        $all_post = SimplePost::where('created_by_id', $user_id)->count();
        $total_free_post = SimplePost::where('created_by_id', $user_id)->where('type', 'free')->count();
        $total_paid_post = SimplePost::where('created_by_id', $user_id)->where('type', 'paid')->count();
        $user_category_id = Auth::user()->category_id;
        $categories = Category::where('id', $user_category_id)->get();
        $total_published_post = SimplePost::where('created_by_id', $user_id)->where('status', '1')->count();
        $total_pending_post = SimplePost::where('created_by_id', $user_id)->where('status', '0')->count();
        $total_paid_post_fees = SimplePost::where('created_by_id', $user_id)->sum('fee');


        // dd($paid_post);
        return view('ManagerAdmin.Report.SimplePost.simplePost_report', compact('total_free_post', 'total_paid_post', 'categories', 'total_published_post', 'total_pending_post', 'total_paid_post_fees'));
    }

    public function simplePostFilter(Request $request)
    {


        $user_id = Auth::id();
        $start_date = $request['start_date'];
        $end_date = $request['end_date'];

        $enter  = false;
        if ($request['user_type'] == "star") {
            $enter = true;
            $total_free_post = SimplePost::whereBetween('created_at', [$start_date, $end_date])->where('star_id', $request['user_name'])->where('created_by_id', $user_id)->count();

            $total_paid_post = SimplePost::whereBetween('created_at', [$start_date, $end_date])->where('star_id', $request['user_name'])->where('created_by_id', $user_id)->where('type', "paid")->where('category_id', $request['category_id'])->where('subcategory_id', $request['subcategory_id'])->count();

            $categories = Category::orderBy('id', 'desc')->get();

            $total_published_post = SimplePost::whereBetween('created_at', [$start_date, $end_date])->where('star_id', $request['user_name'])->where('created_by_id', $user_id)->where('status', '1')->where('category_id', $request['category_id'])->where('subcategory_id', $request['subcategory_id'])->count();

            $total_pending_post = SimplePost::whereBetween('created_at', [$start_date, $end_date])->where('star_id', $request['user_name'])->where('created_by_id', $user_id)->where('status', '0')->where('category_id', $request['category_id'])->where('subcategory_id', $request['subcategory_id'])->count();

            $total_paid_post_fees = SimplePost::whereBetween('created_at', [$start_date, $end_date])->where('star_id', $request['user_name'])->where('created_by_id', $user_id)->where('category_id', $request['category_id'])->where('subcategory_id', $request['subcategory_id'])->sum('fee');
        } else if ($request['user_type'] == "admin") {
            $enter = true;
            $total_free_post = SimplePost::whereBetween('created_at', [$start_date, $end_date])->where('admin_id', $request['user_name'])->where('created_by_id', $user_id)->where('type', "free")->where('category_id', $request['category_id'])->where('subcategory_id', $request['subcategory_id'])->count();

            $total_paid_post = SimplePost::whereBetween('created_at', [$start_date, $end_date])->where('admin_id', $request['user_name'])->where('created_by_id', $user_id)->where('type', "paid")->where('category_id', $request['category_id'])->where('subcategory_id', $request['subcategory_id'])->count();

            $categories = Category::orderBy('id', 'desc')->get();

            $total_published_post = SimplePost::whereBetween('created_at', [$start_date, $end_date])->where('admin_id', $request['user_name'])->where('created_by_id', $user_id)->where('status', '1')->where('category_id', $request['category_id'])->where('subcategory_id', $request['subcategory_id'])->count();

            $total_pending_post = SimplePost::whereBetween('created_at', [$start_date, $end_date])->where('admin_id', $request['user_name'])->where('created_by_id', $user_id)->where('status', '0')->where('category_id', $request['category_id'])->where('subcategory_id', $request['subcategory_id'])->count();

            $total_paid_post_fees = SimplePost::whereBetween('created_at', [$start_date, $end_date])->where('admin_id', $request['user_name'])->where('created_by_id', $user_id)->where('category_id', $request['category_id'])->where('subcategory_id', $request['subcategory_id'])->sum('fee');
        }


        return response()->json(['total_free_post' => $total_free_post, 'total_paid_post' => $total_paid_post, 'total_published_post' => $total_published_post, 'total_pending_post' => $total_pending_post, 'total_paid_post_fees' => $total_paid_post_fees]);
        // return response()->json($total_free_post);
    }

    public function simplePostUserName($name)
    {
        $user_id = Auth::id();

        $user_names = User::where('created_by', $user_id)->where('user_type', $name)->get();
        return response()->json($user_names);
    }


    public function liveChatReport()
    {


        $reg_fee = LiveChat::where('category_id', auth()->user()->category_id)->sum('fee');

        $total_live_chat = LiveChat::where('category_id', auth()->user()->category_id)->count();

        $slot_fee = LiveChatRegistration::whereHas('liveChat', function ($q) {
            $q->where('category_id', auth()->user()->category_id);
        })->sum('amount');

        // dd($slot_fee);

        $user_category_id = Auth::user()->category_id;
        $categories = Category::where('id', $user_category_id)->get();

        // dd( $total_live_chat);
        return view('ManagerAdmin.Report.LiveChat.liveChat_report', compact('categories', 'reg_fee', 'total_live_chat', 'slot_fee'));
    }

    public function liveChatReportFilter(Request $request)
    {
        $user_id = $request->user_name;

        $start_date = $request['start_date'];
        $end_date = $request['end_date'];
        $user_id = Auth::id();

        if ($request['user_type'] == "star") {
            $enter = true;
            $reg_fee = LiveChat::whereBetween('created_at', [$start_date, $end_date])->where('star_id', $request['user_name'])->where('category_id', $request['category_id'])->where('sub_category_id', $request['sub_category_id'])->sum('fee');

            $total_live_chat = LiveChat::whereBetween('created_at', [$start_date, $end_date])->where('star_id', $request['user_name'])->where('category_id', $request['category_id'])->where('sub_category_id', $request['sub_category_id'])->count();

            $slot_fee = LiveChatRegistration::whereHas('liveChat', function ($q) use ($user_id) {
                $q->where('star_id',  $user_id);
            })->whereBetween('created_at', [$start_date, $end_date])->sum('amount');
            // return response()->json($slot_fee);

            // dd($slot_fee);


        } else if ($request['user_type'] == "admin") {

            $reg_fee = LiveChat::whereBetween('created_at', [$start_date, $end_date])->where('admin_id', $request['user_name'])->where('category_id', $request['category_id'])->where('sub_category_id', $request['sub_category_id'])->sum('fee');

            $total_live_chat = LiveChat::whereBetween('created_at', [$start_date, $end_date])->where('admin_id', $request['user_name'])->where('category_id', $request['category_id'])->where('sub_category_id', $request['sub_category_id'])->count();

            $slot_fee = LiveChatRegistration::whereHas('liveChat', function ($q) use ($user_id) {
                $q->where('admin_id',  $user_id);
            })->whereBetween('created_at', [$start_date, $end_date])->sum('amount');
            // return response()->json($slot_fee);
            // dd($slot_fee);

            $categories = Category::orderBy('id', 'desc')->get();
        }



        return response()->json(['categories' => $categories, 'reg_fee' => $reg_fee, 'total_live_chat' => $total_live_chat, 'slot_fee' => $slot_fee]);
    }



    public function meetupReport()
    {
        $user_id = Auth::id();
        $meetUp_event = MeetupEvent::where('created_by_id', $user_id)->count();
        $user_category_id = Auth::user()->category_id;
        $categories = Category::where('id', $user_category_id)->get();
        $total_fee_online = MeetupEvent::where('created_by_id', $user_id)->where('meetup_type', "Online")->sum('fee');
        $total_fee_offline = MeetupEvent::where('created_by_id', $user_id)->where('meetup_type', "Offline")->sum('fee');

        return view('ManagerAdmin.Report.MeetupEvent.meetupEvent_report', compact('categories', 'meetUp_event', 'total_fee_online', 'total_fee_offline'));
    }

    public function meetupReportFilter(Request $request)
    {

        $start_date = $request['start_date'];
        $end_date = $request['end_date'];

        if ($request['user_type'] == "star") {
            $enter = true;

            $meetUp_event = MeetupEvent::whereBetween('created_at', [$start_date, $end_date])->where('star_id', $request['user_name'])->where('category_id', $request['category_id'])->where('sub_category_id', $request['sub_category_id'])->count();
            // return response()->json($meetUp_event);

            $total_fee_online = MeetupEvent::whereBetween('created_at', [$start_date, $end_date])->where('star_id', $request['user_name'])->where('category_id', $request['category_id'])->where('sub_category_id', $request['sub_category_id'])->where('meetup_type', "Online")->sum('fee');

            $total_fee_offline = MeetupEvent::whereBetween('created_at', [$start_date, $end_date])->where('star_id', $request['user_name'])->where('category_id', $request['category_id'])->where('sub_category_id', $request['sub_category_id'])->where('meetup_type', "Offline")->sum('fee');

            $categories = Category::orderBy('id', 'desc')->get();
        } else if ($request['user_type'] == "admin") {

            $meetUp_event = MeetupEvent::whereBetween('created_at', [$start_date, $end_date])->where('admin_id', $request['user_name'])->where('category_id', $request['category_id'])->where('sub_category_id', $request['sub_category_id'])->count();
            // return response()->json($meetUp_event);

            $total_fee_online = MeetupEvent::whereBetween('created_at', [$start_date, $end_date])->where('admin_id', $request['user_name'])->where('category_id', $request['category_id'])->where('sub_category_id', $request['sub_category_id'])->where('meetup_type', "Online")->sum('fee');

            $total_fee_offline = MeetupEvent::whereBetween('created_at', [$start_date, $end_date])->where('admin_id', $request['user_name'])->where('category_id', $request['category_id'])->where('sub_category_id', $request['sub_category_id'])->where('meetup_type', "Offline")->sum('fee');

            $user_category_id = Auth::user()->category_id;
            $categories = Category::where('id', $user_category_id)->get();
        }
        return response()->json(['categories' => $categories, 'meetUp_event' => $meetUp_event, 'total_fee_online' => $total_fee_online, 'total_fee_offline' => $total_fee_offline]);
        // return response()->json($request);
    }
    public function greetingReport()
    {
        $user_id = Auth::id();
        $total_greetings_users = GreetingsRegistration::whereHas('greeting', function ($q) {
            $q->where('category_id', auth()->user()->category_id);
        })->distinct('user_id')->count();
        // dd($total_greetings_users);
        $total_greetings_type = GreetingsRegistration::whereHas('greeting', function ($q) {
            $q->where('category_id', auth()->user()->category_id);
        })->distinct('purpose')->count();
        // dd($total_greetings_type);
        $user_category_id = Auth::user()->category_id;
        $categories = Category::where('id', $user_category_id)->get();
        return view('ManagerAdmin.Report.Greetings.greetings_report', compact('categories', 'total_greetings_users', 'total_greetings_type'));
    }

    public function greetingReportFilter(Request $request)
    {
        $user_id = $request->user_name;

        $start_date = $request['start_date'];
        $end_date = $request['end_date'];




        if ($request['user_type'] == "star") {
            $enter = true;
            $total_greetings_users = GreetingsRegistration::whereHas('greeting', function ($q) use ($user_id) {
                $q->where('star_id',  $user_id);
            })->whereBetween('created_at', [$start_date, $end_date])->distinct('user_id')->count();

            $total_greetings_type = GreetingsRegistration::whereHas('greeting', function ($q) use ($user_id) {
                $q->where('star_id',  $user_id);
            })->whereBetween('created_at', [$start_date, $end_date])->distinct('purpose')->count();
            // dd($total_greetings_type);
            $categories = Category::orderBy('id', 'desc')->get();
        } else if ($request['user_type'] == "admin") {

            $total_greetings_users = GreetingsRegistration::whereHas('greeting', function ($q) use ($user_id) {
                $q->where('admin_id',  $user_id);
            })->whereBetween('created_at', [$start_date, $end_date])->distinct('user_id')->count();

            $total_greetings_type = GreetingsRegistration::whereHas('greeting', function ($q) use ($user_id) {
                $q->where('admin_id',  $user_id);
            })->whereBetween('created_at', [$start_date, $end_date])->distinct('purpose')->count();
            // dd($total_greetings_type);
            $categories = Category::orderBy('id', 'desc')->get();
        }

        return response()->json(['categories' => $categories, 'total_greetings_users' => $total_greetings_users, 'total_greetings_type' => $total_greetings_type]);
    }
    public function fanGroupReport()
    {
        return view('ManagerAdmin.Report.SimplePost.simplePost_report');
    }
    public function auditionReport()
    {
        return view('ManagerAdmin.Report.SimplePost.simplePost_report');
    }
    public function qnaReport()
    {
        $user_id = Auth::id();


        $qna_reg_fee = QnA::where('created_by_id', $user_id)->sum('fee');
        // dd($qna_reg_fee);

        $total_qna = QnaRegistration::whereHas('qna', function ($q) {
            $q->where('category_id', auth()->user()->category_id);
        })->distinct('qna_id')->count();
        // dd($total_qna);


        $qnaSlot_fee = QnaRegistration::whereHas('qna', function ($q) {
            $q->where('category_id', auth()->user()->category_id);
        })->sum('amount');
        // dd($qnaSlot_fee);

        $user_category_id = Auth::user()->category_id;
        $categories = Category::where('id', $user_category_id)->get();

        // dd( $total_live_chat);
        return view('ManagerAdmin.Report.QnA.QnA_report', compact('categories', 'qna_reg_fee', 'total_qna', 'qnaSlot_fee'));
    }

    public function qnaReportFilter(Request $request)
    {
        $user_id = $request->user_name;
        $start_date = $request['start_date'];
        $end_date = $request['end_date'];

        if ($request['user_type'] == "star") {

            $qna_reg_fee = QnA::whereBetween('created_at', [$start_date, $end_date])->where('star_id', $request['user_name'])->where('category_id', $request['category_id'])->where('sub_category_id', $request['sub_category_id'])->sum('fee');
            // dd($qna_reg_fee);

            $total_qna = QnaRegistration::whereHas('qna', function ($q) use ($user_id) {
                $q->where('star_id',  $user_id);
            })->whereBetween('created_at', [$start_date, $end_date])->distinct('qna_id')->count();
            // dd($total_qna);


            $qnaSlot_fee = QnaRegistration::whereHas('qna', function ($q) use ($user_id) {
                $q->where('star_id',  $user_id);
            })->whereBetween('created_at', [$start_date, $end_date])->sum('amount');
            // dd($qnaSlot_fee);

            $categories = Category::orderBy('id', 'desc')->get();
        } else if ($request['user_type'] == "admin") {

            $qna_reg_fee = QnA::whereBetween('created_at', [$start_date, $end_date])->where('admin_id', $request['user_name'])->where('category_id', $request['category_id'])->where('sub_category_id', $request['sub_category_id'])->sum('fee');
            // dd($qna_reg_fee);

            $total_qna = QnaRegistration::whereHas('qna', function ($q) use ($user_id) {
                $q->where('admin_id',  $user_id);
            })->whereBetween('created_at', [$start_date, $end_date])->distinct('qna_id')->count();
            // dd($total_qna);
            // return response()->json($total_qna);

            $qnaSlot_fee = QnaRegistration::whereHas('qna', function ($q) use ($user_id) {
                $q->where('admin_id',  $user_id);
            })->whereBetween('created_at', [$start_date, $end_date])->sum('amount');
            // dd($qnaSlot_fee);
            // return response()->json($qnaSlot_fee);
            $categories = Category::orderBy('id', 'desc')->get();
        }

        // return response()->json($request);
        return response()->json(['categories' => $categories, 'qna_reg_fee' => $qna_reg_fee, 'total_qna' => $total_qna, 'qnaSlot_fee' => $qnaSlot_fee]);
    }
    public function marketplaceReport()
    {
        $user_id = Auth::id();

        $unit_Product_price = Marketplace::where('created_by_id', $user_id)->sum('unit_price');

        $tax = Marketplace::where('created_by_id', $user_id)->sum('tax');
        // dd($total_qnaSlot_fees);

        // $total_items_quantity = Marketplace::sum('total_items');
        $total_items = Marketplace::where('created_by_id', $user_id)->count();

        $total_order = MarketplaceOrder::whereHas('marketplace', function ($q) {
            $q->where('category_id', auth()->user()->category_id);
        })->count();
        $user_category_id = Auth::user()->category_id;
        $categories = Category::where('id', $user_category_id)->get();

        // dd($total_order);
        return view('ManagerAdmin.Report.MarketPlace.marketPlace_report', compact('categories', 'unit_Product_price', 'tax', 'total_items', 'total_order'));
    }

    public function marketPlaceFilter(Request $request)
    {

        $user_id = $request->user_name;
        $start_date = $request['start_date'];
        $end_date = $request['end_date'];
        // return([$start_date , $end_date]);

        if ($request['user_type'] == "star") {

            $unit_Product_price = Marketplace::whereBetween('created_at', [$start_date, $end_date])->where('superstar_id', $request['user_name'])->where('category_id', $request['category_id'])->where('subcategory_id', $request['subcategory_id'])->sum('unit_price');
            // return response()->json($unit_Product_price);
            $tax = Marketplace::whereBetween('created_at', [$start_date, $end_date])->where('superstar_id', $request['user_name'])->where('category_id', $request['category_id'])->where('subcategory_id', $request['subcategory_id'])->sum('tax');
            // dd($total_qnaSlot_fees);

            // $total_items_quantity = Marketplace::sum('total_items');
            $total_items = Marketplace::whereBetween('created_at', [$start_date, $end_date])->where('superstar_id', $request['user_name'])->where('category_id', $request['category_id'])->where('sub_category_id', $request['sub_category_id'])->count();

            $total_order = MarketplaceOrder::whereHas('marketplace', function ($q) use ($user_id) {
                $q->where('superstar_id',  $user_id);
            })->whereBetween('created_at', [$start_date, $end_date])->count();

            $categories = Category::orderBy('id', 'desc')->get();
        } else if ($request['user_type'] == "admin") {

            $unit_Product_price = Marketplace::whereBetween('created_at', [$start_date, $end_date])->where('superstar_admin_id', $request['user_name'])->where('category_id', $request['category_id'])->where('subcategory_id', $request['subcategory_id'])->sum('unit_price');
            // return response()->json($unit_Product_price);
            $tax = Marketplace::whereBetween('created_at', [$start_date, $end_date])->where('superstar_admin_id', $request['user_name'])->where('category_id', $request['category_id'])->where('subcategory_id', $request['subcategory_id'])->sum('tax');
            // dd($total_qnaSlot_fees);

            $total_items = Marketplace::whereBetween('created_at', [$start_date, $end_date])->where('superstar_admin_id', $request['user_name'])->where('category_id', $request['category_id'])->where('subcategory_id', $request['subcategory_id'])->count();

            $total_order = MarketplaceOrder::whereHas('marketplace', function ($q) use ($user_id) {
                $q->where('superstar_admin_id',  $user_id);
            })->whereBetween('created_at', [$start_date, $end_date])->count();

            $categories = Category::orderBy('id', 'desc')->get();
        }
        // return response()->json($request);

        return response()->json(['categories' => $categories, 'unit_Product_price' => $unit_Product_price, 'tax' => $tax, 'total_items' => $total_items, 'total_order' => $total_order]);
    }
    public function auctionReport()
    {
        $user_id = Auth::id();
        $base_price = Auction::where('created_by_id', $user_id)->sum('base_price');

        $total_auction = Auction::where('created_by_id', $user_id)->count();

        $total_bidding = Bidding::whereHas('auction', function ($q) {
            $q->where('category_id', auth()->user()->category_id);
        })->distinct('auction_id')->count();
        $total_bidding_price = Bidding::whereHas('auction', function ($q) {
            $q->where('category_id', auth()->user()->category_id);
        })->sum('amount');

        $user_category_id = Auth::user()->category_id;
        $categories = Category::where('id', $user_category_id)->get();
        // dd($total_bidding_price);
        return view('ManagerAdmin.Report.Auction.auction_report', compact('categories', 'base_price', 'total_auction', 'total_bidding', 'total_bidding_price'));
    }
    public function auctionReportFilter(Request $request)
    {
        $user_id = $request->user_name;
        $start_date = $request['start_date'];
        $end_date = $request['end_date'];


        if ($request['user_type'] == "star") {

            $base_price = Auction::whereBetween('created_at', [$start_date, $end_date])->where('star_id', $request['user_name'])->where('category_id', $request['category_id'])->where('subcategory_id', $request['subcategory_id'])->sum('base_price');

            $total_auction = Auction::whereBetween('created_at', [$start_date, $end_date])->where('star_id', $request['user_name'])->where('category_id', $request['category_id'])->where('subcategory_id', $request['subcategory_id'])->count();

            $total_bidding = Bidding::whereHas('auction', function ($q) use ($user_id) {
                $q->where('star_id',  $user_id);
            })->whereBetween('created_at', [$start_date, $end_date])->distinct('auction_id')->count();

            $total_bidding_price = Bidding::whereHas('auction', function ($q) use ($user_id) {
                $q->where('star_id',  $user_id);
            })->whereBetween('created_at', [$start_date, $end_date])->sum('amount');

            $categories = Category::orderBy('id', 'desc')->get();
        } else if ($request['user_type'] == "admin") {

            $base_price = Auction::whereBetween('created_at', [$start_date, $end_date])->where('admin_id', $request['user_name'])->where('category_id', $request['category_id'])->where('subcategory_id', $request['subcategory_id'])->sum('base_price');

            $total_auction = Auction::whereBetween('created_at', [$start_date, $end_date])->where('admin_id', $request['user_name'])->where('category_id', $request['category_id'])->where('subcategory_id', $request['subcategory_id'])->count();

            $total_bidding = Bidding::whereHas('auction', function ($q) use ($user_id) {
                $q->where('admin_id',  $user_id);
            })->whereBetween('created_at', [$start_date, $end_date])->distinct('auction_id')->count();
            // return response()->json($total_bidding);
            $total_bidding_price = Bidding::whereHas('auction', function ($q) use ($user_id) {
                $q->where('admin_id',  $user_id);
            })->whereBetween('created_at', [$start_date, $end_date])->sum('amount');
            // return response()->json($total_bidding_price);
            $categories = Category::orderBy('id', 'desc')->get();
        }

        // return response()->json($request);

        return response()->json(['categories' => $categories, 'base_price' => $base_price, 'total_auction' => $total_auction, 'total_bidding' => $total_bidding, 'total_bidding_price' => $total_bidding_price]);
    }
    public function souvenirReport()
    {
        $user_id = User::where('created_by', Auth::id())->get();
        $total_sounenir_item = 0;
        $total_sounenir_item_price = 0;
        $total_souvenir = 0;
        $total_amount = 0;
        foreach ($user_id as $admin_id) {
            $total_sounenir_item = $total_sounenir_item + SouvenirApply::where('admin_id', $admin_id['id'])->count();
            $total_sounenir_item_price = $total_sounenir_item_price + SouvenirApply::where('admin_id', $admin_id['id'])->sum('total_amount');
            $total_souvenir = $total_souvenir + SouvenirCreate::where('admin_id', $admin_id['id'])->count();
            $total_amount = $total_amount + SouvenirCreate::where('admin_id', $admin_id['id'])->sum('price');
        }

        $user_category_id = Auth::user()->category_id;
        $categories = Category::where('id', $user_category_id)->get();
        // dd($total_souvenir,$total_amount);
        return view('ManagerAdmin.Report.Souvenir.Souvenir_report', compact('categories', 'total_souvenir', 'total_amount', 'total_sounenir_item', 'total_sounenir_item_price'));
    }
    public function souvenirReportFilter(Request $request)
    {
        $user_id = $request['user_name'];
        $start_date = $request['start_date'];
        $end_date = $request['end_date'];

        // $total_souvenir = SouvenirApply::count();
        // $total_amount = SouvenirApply::sum('total_amount');
        // $total_sounenir_item = SouvenirCreate::whereBetween('created_at', [$start_date, $end_date])->where('category_id', $request['category_id'])->where('sub_category_id', $request['sub_category_id'])->count();
        // $total_sounenir_item_price = SouvenirCreate::whereBetween('created_at', [$start_date, $end_date])->where('category_id', $request['category_id'])->where('sub_category_id', $request['sub_category_id'])->sum('price');
        // $categories = Category::orderBy('id', 'desc')->get();

        if ($request['user_type'] == "star") {

            $total_sounenir_item = 0;
            $total_sounenir_item_price = 0;


            $total_sounenir_item = SouvenirApply::whereBetween('created_at', [$start_date, $end_date])->where('star_id',  $user_id)->count();

            $total_sounenir_item_price = SouvenirApply::whereBetween('created_at', [$start_date, $end_date])->where('star_id',  $user_id)->sum('total_amount');



            $categories = Category::orderBy('id', 'desc')->get();
        } else if ($request['user_type'] == "admin") {

            $total_sounenir_item = 0;
            $total_sounenir_item_price = 0;


            $total_sounenir_item = SouvenirApply::whereBetween('created_at', [$start_date, $end_date])->where('admin_id',  $user_id)->count();
            // return response()->json($total_sounenir_item);
            $total_sounenir_item_price = SouvenirApply::whereBetween('created_at', [$start_date, $end_date])->where('admin_id',  $user_id)->sum('total_amount');
            // return response()->json($total_sounenir_item_price);
            // $categories = Category::orderBy('id', 'desc')->get();
        }

        return response()->json(['total_sounenir_item' => $total_sounenir_item, 'total_sounenir_item_price' => $total_sounenir_item_price]);
    }




    ///kjhkjg
}
