<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Marketplace;
use App\Models\Auction;
use App\Models\MeetupEvent;

class DashboardInfoController extends Controller
{
    public function allUser(){
        $data['allUser'] = User::where('user_type', 'user')->latest()->get();
        return view('SuperAdmin.dashboardInfo.user', $data);
    }
    public function allStar(){
        $data['allStar'] = User::where('user_type', 'star')->latest()->get();
        return view('SuperAdmin.dashboardInfo.star', $data);
    }
    public function allAdmin(){
        $data['allAdmin'] = User::where('user_type', 'admin')->latest()->get();
        return view('SuperAdmin.dashboardInfo.admin', $data);
    }
    public function allMarketplace(){
        $data['allMarketplace'] = Marketplace::latest()->get();
        return view('SuperAdmin.dashboardInfo.marketplace', $data);
    }
    public function allAuction(){
        $data['allAuction'] = Auction::latest()->get();
        return view('SuperAdmin.dashboardInfo.auction', $data);
    }
    public function allMeetUp(){
        $data['allMeetUp'] = MeetupEvent::latest()->get();
        return view('SuperAdmin.dashboardInfo.meetup', $data);
    }
}
