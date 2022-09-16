<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
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
use App\Models\MeetupEvent;
use App\Models\MeetupEventRegistration;
use App\Models\QnA;
use App\Models\QnaRegistration;
use App\Models\SimplePost;
use App\Models\SubCategory;
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
        // foreach($total_assignment_fees as $total_assignment_fee){
        //     $amounts = LearningSession::where('id', $total_assignment_fee->assignment_fee)->get();
        // }
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

        $start_date = Carbon::parse($request->start_date)->format('Y-m-d  H:i:s');
        $end_date = Carbon::parse($request->end_date)->format('Y-m-d  H:i:s');
        // dd($request);

        $total_assignment_fees = LearningSession::whereBetween('created_at', [$start_date, $end_date])->where('category_id', $request['category_id'])->where('sub_category_id', $request['sub_category_id'])->get();
        // dd($total_assignment_fees);

        $assignment_fee = 0;
        $registration_fee = 0;
        $assignment = 0;
        foreach ($total_assignment_fees as $amount) {
            $assignment_fee = $assignment_fee + $amount['assignment_fee'];
            $registration_fee = $registration_fee + $amount['fee'];
            $assignment = $assignment + $amount['assignment'];
        }



        $certificate = LearningSessionCertificate::whereBetween('created_at', [$start_date, $end_date])->count();


        $categories = Category::orderBy('id', 'desc')->get();
        $subCategories = SubCategory::orderBy('id', 'desc')->get();
        // dd($categories);
        // return redirect()->back()->with(compact('categories', 'assignment_fee', 'registration_fee', 'certificate', 'assignment'));
        return response()->json(['categories' => $categories, 'subCategories' => $subCategories, 'assignment_fee' => $assignment_fee, 'registration_fee' => $registration_fee, 'assignment' => $assignment, 'certificate' => $certificate]);

        // return view('SuperAdmin.Report.LearningSession.learningSession_report', compact('categories', 'assignment_fee','registration_fee','certificate','assignment'));
    }



     public function learningSubCategory($id)
    {
        // dd($id);
        $subCategories = SubCategory::where('category_id', $id)->get();
        return response()->json($subCategories);
    }




    public function simplePostReport()
    {
        $all_post = SimplePost::all()->count();
        $free_post = SimplePost::where('type', 'free')->count();
        $paid_post = SimplePost::where('type', 'paid')->count();
        // dd($paid_post);
        return view('SuperAdmin.Report.SimplePost.simplePost_report', compact('free_post', 'paid_post'));
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
        $start_date = Carbon::parse($request->start_date)->format('Y-m-d  H:i:s');
        $end_date = Carbon::parse($request->end_date)->format('Y-m-d  H:i:s');

        $reg_fee = 0;
        $total_reg_fees = LiveChat::whereBetween('created_at', [$start_date, $end_date])->get();
        // dd($total_reg_fee);
        foreach ($total_reg_fees as $amount) {
            $reg_fee = $reg_fee + $amount['fee'];
        }

        $total_live_chat = LiveChatRegistration::whereBetween('created_at', [$start_date, $end_date])->distinct('live_chat_id')->count();

        $slot_fee = 0;
        $total_slot_fees = LiveChatRegistration::whereBetween('created_at', [$start_date, $end_date])->get();
        // dd($total_reg_fee);
        foreach ($total_slot_fees as $amount) {
            $slot_fee = $slot_fee + $amount['amount'];
        }
        // dd($slot_fee);

        $categories = Category::orderBy('id', 'desc')->get();

        // dd( $total_live_chat);
        // return response()->json($request);
        return response()->json(['categories' => $categories, 'reg_fee' => $reg_fee, 'total_live_chat' => $total_live_chat, 'slot_fee' => $slot_fee]);
    }

   

    public function meetupReport()
    {
        $meetUp_event = 0;
        $total_meetup_events = MeetupEventRegistration::all();

        foreach ($total_meetup_events as $amount) {
            $meetUp_event = $amount['id'];
        }
        // dd($meetUp_event);
        // $fee_of_online = MeetupEvent::all()->count();
        $categories = Category::orderBy('id', 'desc')->get();
        $total_fee_online = MeetupEvent::where('meetup_type', 'online')->sum('fee');
        $total_fee_offline = MeetupEvent::where('meetup_type', 'offline')->sum('fee');
        // dd($total_fee_offline);
        // return response()->back();
        return view('SuperAdmin.Report.MeetupEvent.meetupEvent_report', compact('categories', 'meetUp_event', 'total_fee_online', 'total_fee_offline'));
    }

    public function meetupReportFilter(Request $request)
    {
        // dd($request);
        $start_date = Carbon::parse($request->start_date)->format('Y-m-d H:i:s');
        $end_date = Carbon::parse($request->end_date)->format('Y-m-d H:i:s');

        $meetUp_event = 0;
        $total_meetup_events = MeetupEventRegistration::whereBetween('created_at', [$start_date, $end_date])->get();

        foreach ($total_meetup_events as $amount) {
            $meetUp_event = $amount['id'];
        }
        // dd($meetUp_event);
        // $fee_of_online = MeetupEvent::all()->count();
        $start_date = Carbon::parse($request->start_date)->format('Y-m-d H:i:s');
        $end_date = Carbon::parse($request->end_date)->format('Y-m-d H:i:s');

        $total_fee_online = MeetupEvent::whereBetween('created_at', [$start_date, $end_date])->where('meetup_type', 'Online')->sum('fee');
        $total_fee_offline = MeetupEvent::whereBetween('created_at', [$start_date, $end_date])->where('meetup_type', 'Offline')->sum('fee');
        // dd($total_fee_offline);
        $categories = Category::orderBy('id', 'desc')->get();

        return response()->json(['categories' => $categories, 'meetUp_event' => $meetUp_event, 'total_fee_online' => $total_fee_online, 'total_fee_offline' => $total_fee_offline]);
        // return response()->json($request);
    }
    public function greetingReport()
    {
        $total_greetings_users = GreetingsRegistration::distinct('user_id')->count();
        $total_greetings_type = GreetingType::distinct('greeting_type')->count();
        // dd($total_greetings_type);
        $categories = Category::orderBy('id', 'desc')->get();
        return view('SuperAdmin.Report.Greetings.greetings_report', compact('categories', 'total_greetings_users', 'total_greetings_type'));
    }

    public function greetingReportFilter(Request $request)
    {
        $start_date = Carbon::parse($request->start_date)->format('Y-m-d H:i:s');
        $end_date = Carbon::parse($request->end_date)->format('Y-m-d H:i:s');

        $total_greetings_users = GreetingsRegistration::whereBetween('created_at', [$start_date, $end_date])->distinct('user_id')->count();
        $total_greetings_type = GreetingType::whereBetween('created_at', [$start_date, $end_date])->distinct('greeting_type')->count();
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
        $start_date = Carbon::parse($request->start_date)->format('Y-m-d H:i:s');
        $end_date = Carbon::parse($request->end_date)->format('Y-m-d H:i:s');

        $qna_reg_fee = 0;
        $total_qnaReg_fees = QnA::whereBetween('created_at', [$start_date, $end_date])->get();
        // dd($total_reg_fees);
        foreach ($total_qnaReg_fees as $amount) {
            $qna_reg_fee = $qna_reg_fee + $amount['fee'];
        }

        $total_qna = QnaRegistration::whereBetween('created_at', [$start_date, $end_date])->distinct('qna_id')->count();
        // dd($total_qns);

        $qnaSlot_fee = 0;
        $total_qnaSlot_fees = QnaRegistration::whereBetween('created_at', [$start_date, $end_date])->get();
        // dd($total_qnaSlot_fees);
        foreach ($total_qnaSlot_fees as $amount) {
            $qnaSlot_fee = $qnaSlot_fee + $amount['amount'];
        }
        // dd($qnaSlot_fee);

        $categories = Category::orderBy('id', 'desc')->get();

        // dd( $total_live_chat);
        return response()->json(['categories' => $categories, 'qna_reg_fee' => $qna_reg_fee, 'total_qna' => $total_qna, 'qnaSlot_fee' => $qnaSlot_fee]);
    }
    public function marketplaceReport()
    {
        return view('SuperAdmin.Report.SimplePost.simplePost_report');
    }
    public function auctionReport()
    {
        return view('SuperAdmin.Report.SimplePost.simplePost_report');
    }
    public function souvenirReport()
    {
        return view('SuperAdmin.Report.SimplePost.simplePost_report');
    }




    ///kjhkjg
}
