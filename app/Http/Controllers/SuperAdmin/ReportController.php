<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\LearningSession;
use App\Models\LearningSessionAssignment;
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
        $total_assignment_fee = LearningSession::all();
        // dd($total_assignment_fee);
        $data = [
            'categories' => Category::orderBy('id', 'desc')->get(),
        ];
        return view('SuperAdmin.Report.LearningSession.learningSession_report', $data);
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
