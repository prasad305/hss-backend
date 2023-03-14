<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Currency;
use Illuminate\Support\Carbon;

class RaffleDrowController extends Controller
{
    public function allUser()
    {
        $countries = Currency::get();
        $users = User::where([['user_type', 'user'], ['status', 1]])->get();
        return view('SuperAdmin.raffleDrow.index', compact('users', 'countries'));
    }

    public function countryUser(Request $request)
    {
        $request->validate([
            'country_code' => 'required',
        ]);
        $country_code = $request->country_code;
        $users = User::where([['user_type', 'user'], ['country_code', $country_code], ['status', 1]])->get();
        $checkNotify = User::where(function ($query) {
            $query->where('notify_status', 1)->orWhere('notify_status', 2);
        })->where([['country_code', $country_code], ['status', 1]])->first();
        return view('SuperAdmin.raffleDrow.countryuser', compact('users', 'country_code', 'checkNotify'));
    }

    public function selectedUser(Request $request)
    {
        $request->validate([
            'start_date' => 'required',
            'end_date' => 'required',
            'number_of_user' => 'required',
        ]);
        $country_code = $request->country_code;
        $number_of_user = $request->number_of_user;
        $start_date = Carbon::parse($request->start_date);
        $end_date = Carbon::parse($request->end_date);
        $getusers = User::where([['user_type', 'user'], ['created_at', '>=', $start_date], ['created_at', '<=', $end_date], ['country_code', $country_code], ['status', 1]])->inRandomOrder()->limit($number_of_user)->get();
        $checkNotify = User::where([['notify_status', 2], ['country_code', $country_code], ['status', 1]])->first();
        $checkWinner = User::where([['raffle_drow_status', 1], ['country_code', $country_code], ['status', 1]])->first();
        if (!isset($checkWinner->raffle_drow_status)) {
            foreach ($getusers as $user) {
                $user->raffle_drow_status = 1;
                $user->update();
            }
        }
        $users = User::where([['country_code', $country_code], ['raffle_drow_status', 1], ['status', 1]])->get();
        return view('SuperAdmin.raffleDrow.selectuser', compact('users', 'country_code', 'checkNotify'));
    }

    public function allWinnerUser()
    {
        $countries = Currency::get();
        $users = User::where([['raffle_drow_status', 1], ['status', 1]])->get();
        return view('SuperAdmin.raffleDrow.allwinneruser', compact('users', 'countries'));
    }

    public function countryWinnerUser(Request $request)
    {
        $request->validate([
            'country_code' => 'required',
        ]);
        $country_code = $request->country_code;
        $users = User::where([['raffle_drow_status', 1], ['country_code', $country_code], ['status', 1]])->get();
        return view('SuperAdmin.raffleDrow.countrywinneruser', compact('users', 'country_code'));
    }

    public function countryUserGeneralmessage(Request $request, $code)
    {
        return view('SuperAdmin.raffleDrow.generalMessage', compact('code'));
    }

    public function countryUserNotify(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);
        $country_code = $request->country_code;
        $title = $request->title;
        $description = $request->description;
        $getusers = User::where([['country_code', $country_code], ['status', 1]])->get();
        foreach ($getusers as $user) {
            $user->notify_status = 1;
            $user->update();
        }
        return response()->json([
            'type' => 'success',
            'message' => 'Notification send successfully',
        ]);
    }

    public function countryUserWinnermessage(Request $request, $code)
    {
        return view('SuperAdmin.raffleDrow.winnerMessage', compact('code'));
    }

    public function winnerUserNotify(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);
        $country_code = $request->country_code;
        $title = $request->title;
        $description = $request->description;
        $getusers = User::where([['raffle_drow_status', 1], ['country_code', $country_code], ['status', 1]])->get();
        foreach ($getusers as $user) {
            $user->notify_status = 2;
            $user->update();
        }
        return response()->json([
            'type' => 'success',
            'message' => 'Notification send successfully',
        ]);
    }

    public function reseteUser(Request $request)
    {
        $country_code = $request->country_code;
        $getusers = User::where([['country_code', $country_code], ['status', 1]])->get();
        foreach ($getusers as $user) {
            $user->raffle_drow_status = 0;
            $user->notify_status = 0;
            $user->update();
        }
        return redirect()->back();
    }
}
