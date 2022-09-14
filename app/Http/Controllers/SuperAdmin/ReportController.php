<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\LearningSession;
use App\Models\LearningSessionAssignment;
use App\Models\LearningSessionCertificate;
use App\Models\LearningSessionRegistration;
use Illuminate\Http\Request;

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

        dd($assignment);

        // dd($total_assignment_fee);

        $categories = Category::orderBy('id', 'desc')->get();;


        return view('SuperAdmin.Report.LearningSession.learningSession_report', compact('categories', 'assignment_fee', 'registration_fee', 'certificate', 'assignment'));
    }
    public function learningFilter(Request $request)
    {
        // dd($request);
        $assignment_fee = 0;
        $total_assignment_fees = LearningSession::where('created_at', '>=', $request['start_date'])->where('created_at', '<=', $request['end_date'])->get();
        // dd($total_assignment_fees);

        foreach ($total_assignment_fees as $amount) {
            $assignment_fee = $assignment_fee + $amount['assignment_fee'];
        }

        // dd($assignment_fee);

        $registration_fee = 0;
        $total_registration_fees = LearningSession::where('created_at', '>=', $request['start_date'])->where('created_at', '<=', $request['end_date'])->get();

        foreach ($total_registration_fees as $amount) {
            $registration_fee = $registration_fee + $amount['fee'];
        }
        // dd($registration_fee);
        $certificate = LearningSessionCertificate::where('created_at', '>=', $request['start_date'])->where('created_at', '<=', $request['end_date'])->count();
        // dd($certificate);

        $assignment = 0;
        $total_assignments = LearningSession::where('created_at', '>=', $request['start_date'])->where('created_at', '<=', $request['end_date'])->get();

        foreach ($total_assignments as $amount) {
            $assignment = $assignment + $amount['assignment'];
        }

        // dd($assignment);

        // dd($total_assignment_fee);

        $categories = Category::orderBy('id', 'desc')->get();;
        // dd($categories);
        return redirect()->back()->with(compact('categories', 'assignment_fee','registration_fee','certificate','assignment'));

        // return view('SuperAdmin.Report.LearningSession.learningSession_report', compact('categories', 'assignment_fee','registration_fee','certificate','assignment'));
    }





    public function simplePostReport()
    {
        return view('SuperAdmin.Report.SimplePost.simplePost_report');
    }
    public function liveChatReport()
    {
        return view('SuperAdmin.Report.LiveChat.liveChat_report');
    }
    public function meetupReport()
    {
        return view('SuperAdmin.Report.MeetupEvent.meetupEvent_report');
    }
    public function greetingReport()
    {
        return view('SuperAdmin.Report.Greetings.greetings_report');
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
        return view('SuperAdmin.Report.QnA.QnA_report');
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
