<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function allReport()
    {
        return view('SuperAdmin.Report.AllReport.all_report');
    }
    public function learningSessionReport()
    {
        return view('SuperAdmin.Report.LearningSession.learningSession_report');
    }
    public function simplePostReport()
    {
        return view('SuperAdmin.Report.SimplePost.simplePost_report');
    }
    public function liveChatReport()
    {
        return view('SuperAdmin.Report.SimplePost.simplePost_report');
    }
    public function meetupReport()
    {
        return view('SuperAdmin.Report.SimplePost.simplePost_report');
    }
    public function greetingReport()
    {
        return view('SuperAdmin.Report.SimplePost.simplePost_report');
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
        return view('SuperAdmin.Report.SimplePost.simplePost_report');
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
}
