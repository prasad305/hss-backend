<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\MeetupEvent;
use App\Models\MeetupEventRegistration;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function adminDashboard()
    {

        // Income Statement meetup

        $meetupTotalIncome = MeetupEventRegistration::whereHas('meetupEvent', function ($q) {
            $q->where([['admin_id', auth()->user()->id]]);
        })->sum('amount');
        $meetupDailyIncome = MeetupEventRegistration::whereHas('meetupEvent', function ($q) {
            $q->where([['admin_id', auth()->user()->id]]);
        })->where('created_at', '>', Carbon::now()->startOfDay())->where('created_at', '<', Carbon::now()->endOfDay())->sum('amount');
        $meetupWeeklyIncome = MeetupEventRegistration::whereHas('meetupEvent', function ($q) {
            $q->where([['admin_id', auth()->user()->id]]);
        })->where('created_at', '>', Carbon::now()->startOfWeek())->where('created_at', '<', Carbon::now()->endOfWeek())->sum('amount');
        $meetupMonthlyIncome = MeetupEventRegistration::whereHas('meetupEvent', function ($q) {
            $q->where([['admin_id', auth()->user()->id]]);
        })->where('created_at', '>', Carbon::now()->startOfMonth())->where('created_at', '<', Carbon::now()->endOfMonth())->sum('amount');
        $meetupYearlyIncome = MeetupEventRegistration::whereHas('meetupEvent', function ($q) {
            $q->where([['admin_id', auth()->user()->id]]);
        })->where('created_at', '>', Carbon::now()->startOfYear())->where('created_at', '<', Carbon::now()->endOfYear())->sum('amount');



        return response()->json([
            'status' => 200,
            'meetupTotalIncome' => $meetupTotalIncome
        ]);
    }
}
