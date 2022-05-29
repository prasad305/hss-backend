<?php

namespace App\Http\Controllers\ManagerAdmin;

use App\Http\Controllers\Controller;
use App\Models\Auction;
use App\Models\Greeting;
use App\Models\Marketplace;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GreetingController extends Controller
{
    public function dashboard()
    {
        // all of those are dummy for greeting dashboard
        $totalUser = User::where('user_type', 'user')->count();
        $totalAdmin = User::where('user_type', 'admin')->where('parent_user', auth()->user()->id)->count();
        $totalStar = User::where('user_type', 'star')->where('parent_user', auth()->user()->id)->count();
        $totalAuctionProduct = Auction::where('category_id', auth()->user()->category_id)->count();
        $totalMarketPlaceProduct = Marketplace::where('category_id', auth()->user()->category_id)->count();
        return view('ManagerAdmin.greeting.dashboard', compact(['totalUser', 'totalAdmin', 'totalStar', 'totalAuctionProduct', 'totalMarketPlaceProduct']));
    }

    public function request()
    {
        $greetings = Greeting::where([['category_id', Auth::user()->category_id],['status', 1]])->get();
        return view('ManagerAdmin.greeting.request', compact('greetings'));
    }
}
