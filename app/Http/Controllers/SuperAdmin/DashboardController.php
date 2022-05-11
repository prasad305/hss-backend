<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Booster;
use App\Models\Center;
use App\Models\PcrTest;
use App\Models\User;
use App\Models\Package;
use App\Models\Vaccination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboard(){

      $year = ['Jan','Feb','Mar','Apr','May','Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

      $user = ['2017','1158','2019','20','586','2022', '2417','1158','2019','20','586','222'];
      // foreach ($year as $key => $value) {
      //     $user[] = User::where(\DB::raw("DATE_FORMAT(created_at, '%Y')"),$value)->count();
      // }

    return view('SuperAdmin.dashboard.index')->with('year',json_encode($year,JSON_NUMERIC_CHECK))->with('user',json_encode($user,JSON_NUMERIC_CHECK));
      // return view('SuperAdmin.dashboard.index');
    }

    public function auditions(){
      $year = ['Jan','Feb','Mar','Apr','May','Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

      $user = ['2017','1158','2019','20','586','2022', '2417','1158','2019','20','586','222'];
      // foreach ($year as $key => $value) {
      //     $user[] = User::where(\DB::raw("DATE_FORMAT(created_at, '%Y')"),$value)->count();
      // }

    return view('SuperAdmin.dashboard.auditions')->with('year',json_encode($year,JSON_NUMERIC_CHECK))->with('user',json_encode($user,JSON_NUMERIC_CHECK));
    }

    public function meetupEvents(){
      $year = ['Jan','Feb','Mar','Apr','May','Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

      $user = ['2017','1158','2019','20','586','2022', '2417','1158','2019','20','586','222'];
      // foreach ($year as $key => $value) {
      //     $user[] = User::where(\DB::raw("DATE_FORMAT(created_at, '%Y')"),$value)->count();
      // }

    return view('SuperAdmin.dashboard.meetup-events')->with('year',json_encode($year,JSON_NUMERIC_CHECK))->with('user',json_encode($user,JSON_NUMERIC_CHECK));
    }

    public function learningSessions(){
      $year = ['Jan','Feb','Mar','Apr','May','Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

      $user = ['2017','1158','2019','20','586','2022', '2417','1158','2019','20','586','222'];
      // foreach ($year as $key => $value) {
      //     $user[] = User::where(\DB::raw("DATE_FORMAT(created_at, '%Y')"),$value)->count();
      // }

    return view('SuperAdmin.dashboard.learning-sessions')->with('year',json_encode($year,JSON_NUMERIC_CHECK))->with('user',json_encode($user,JSON_NUMERIC_CHECK));
    }

    public function liveChats(){
      $year = ['Jan','Feb','Mar','Apr','May','Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

      $user = ['2017','1158','2019','20','586','2022', '2417','1158','2019','20','586','222'];
      // foreach ($year as $key => $value) {
      //     $user[] = User::where(\DB::raw("DATE_FORMAT(created_at, '%Y')"),$value)->count();
      // }

    return view('SuperAdmin.dashboard.live-chats')->with('year',json_encode($year,JSON_NUMERIC_CHECK))->with('user',json_encode($user,JSON_NUMERIC_CHECK));
    }

    public function fanGroup(){
      $year = ['Jan','Feb','Mar','Apr','May','Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

      $user = ['2017','1158','2019','20','586','2022', '2417','1158','2019','20','586','222'];
      // foreach ($year as $key => $value) {
      //     $user[] = User::where(\DB::raw("DATE_FORMAT(created_at, '%Y')"),$value)->count();
      // }

    return view('SuperAdmin.dashboard.fan-group')->with('year',json_encode($year,JSON_NUMERIC_CHECK))->with('user',json_encode($user,JSON_NUMERIC_CHECK));
    }

    public function greetings(){
      $year = ['Jan','Feb','Mar','Apr','May','Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

      $user = ['2017','1158','2019','20','586','2022', '2417','1158','2019','20','586','222'];
      // foreach ($year as $key => $value) {
      //     $user[] = User::where(\DB::raw("DATE_FORMAT(created_at, '%Y')"),$value)->count();
      // }

    return view('SuperAdmin.dashboard.greetings')->with('year',json_encode($year,JSON_NUMERIC_CHECK))->with('user',json_encode($user,JSON_NUMERIC_CHECK));
    }

    public function userPosts(){
      $year = ['Jan','Feb','Mar','Apr','May','Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

      $user = ['2017','1158','2019','20','586','2022', '2417','1158','2019','20','586','222'];
      // foreach ($year as $key => $value) {
      //     $user[] = User::where(\DB::raw("DATE_FORMAT(created_at, '%Y')"),$value)->count();
      // }

    return view('SuperAdmin.dashboard.user-posts')->with('year',json_encode($year,JSON_NUMERIC_CHECK))->with('user',json_encode($user,JSON_NUMERIC_CHECK));
    }
    
    public function wallets(){
      return view('SuperAdmin.dashboard.wallets');
    }
    
    public function package(){
      return view('SuperAdmin.package.index');
    }

    // public function addPackage(){
    //   return view('SuperAdmin.package.create');
    // }
    public function packageStore(Request $request){
      $package = new Package();
      $package->title = $request->title;
      $package->club_points = $request->club_points;
      $package->auditions = $request->auditions;
      $package->learning_session = $request->learning_session;
      $package->live_chats = $request->live_chats;
      $package->meetup = $request->meetup;
      $package->greetings = $request->greetings;
      $package->price = $request->price;
      $package->status = 1;
      $package->save();


    try {
        $package->save();
        return response()->json([
            'type' => 'success',
            'message' => 'Package created successfully',
        ]);
    } catch (\Exception $exception) {
        return response()->json([
            'type' => 'error',
            'message' => 'Opps somthing went wrong. ' . $exception->getMessage(),
        ]);
    }
    }
   

    public function profile(){
        $user = Auth::user();
        return view('SuperAdmin.profile.index', compact('user'));
    }
}
