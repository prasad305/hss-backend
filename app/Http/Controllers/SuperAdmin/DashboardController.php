<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Booster;
use App\Models\Center;
use App\Models\PcrTest;
use App\Models\User;
use App\Models\Package;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\InterestType;
use App\Models\FanGroup;
use App\Models\Fan_Group_Join;
use App\Models\FanPost;
use App\Models\LearningSession;
use App\Models\Greeting;
use App\Models\Post;
use App\Models\LiveChat;
use App\Models\LiveChatRegistration;
use App\Models\LearningSessionRegistration;
use App\Models\Marketplace;
use App\Models\Auction;
use App\Models\MeetupEvent;
use App\Models\MeetupEventRegistration;
use App\Models\Vaccination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function dashboard(){
      $january = 150;
      $february = 259;
      $march =  56;
      $april =  800;
      $may =  600;
      $june =  588;
      $july =  38;
      $august =  237;
      $september =  52;
      $octobar =  5;
      $november =  349;
      $december =  429;
      $year = ['Jan','Feb','Mar','Apr','May','Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

      $user = [$january, $february, $march, $april, $may, $june, $july, $august, $september, $octobar, $november, $december];
      // foreach ($year as $key => $value) {
      //     $user[] = User::where(\DB::raw("DATE_FORMAT(created_at, '%Y')"),$value)->count();
      // }
      
      $data['year'] = json_encode($year,JSON_NUMERIC_CHECK);
      $data['user'] = json_encode($user,JSON_NUMERIC_CHECK);

      //All user & count
      $data['userCount'] = User::where('user_type', 'user')->count();
      $data['managerAdminCount'] = User::where('user_type', 'manager-admin')->count();
      $data['starCount'] = User::where('user_type', 'star')->count();
      $data['adminCount'] = User::where('user_type', 'admin')->count();
      $data['categoryCount'] = Category::count();
      $data['subCategoryCount'] = SubCategory::count();
      $data['countryCount'] = Country::count();
      $data['stateCount'] = State::count();
      $data['cityCount'] = City::count();
      $data['interestTypeCount'] = InterestType::count();
      $data['marketplaceCount'] = Marketplace::count();
      $data['auctionCount'] = Auction::count();

    return view('SuperAdmin.dashboard.index', $data);
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
      $data['year'] = json_encode($year,JSON_NUMERIC_CHECK);
      $data['user'] = json_encode($user,JSON_NUMERIC_CHECK);

      $data['meetUpOnlineCount'] = MeetupEvent::where('meetup_type', 'Online')->count();
      $data['meetUpOfflineCount'] = MeetupEvent::where('meetup_type', 'Offline')->count();
      $data['completeMeetUpOfflineCount'] = MeetupEvent::where('meetup_type', 'Offline')->whereDate('date', '>', Carbon::now())->count();
      $data['completeMeetUpOnlineCount'] = MeetupEvent::where('meetup_type', 'Offline')->whereDate('date', '>', Carbon::now())->count();
      $data['upcomingMeetUpOfflineCount'] = MeetupEvent::where('meetup_type', 'Offline')->whereDate('date', '<', Carbon::now())->count();
      $data['upcomingMeetUpOnlineCount'] = MeetupEvent::where('meetup_type', 'Online')->whereDate('date', '<', Carbon::now())->count();

      $data['userMeetUpOnlineCount'] = MeetupEventRegistration::count();
      $data['registerUserAmount'] = MeetupEventRegistration::sum('amount');

    return view('SuperAdmin.dashboard.meetup-events', $data);
    }

    public function learningSessions(){
      $year = ['Jan','Feb','Mar','Apr','May','Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

      $user = ['2017','1158','2019','20','586','2022', '2417','1158','2019','20','586','222'];
      // foreach ($year as $key => $value) {
      //     $user[] = User::where(\DB::raw("DATE_FORMAT(created_at, '%Y')"),$value)->count();
      // }

      $data['year'] = json_encode($year,JSON_NUMERIC_CHECK);
      $data['user'] = json_encode($user,JSON_NUMERIC_CHECK);

      $data['allLearningCount'] = LearningSession::count();
      $data['completeLearningCount'] = LearningSession::whereDate('date', '>', Carbon::now())->count();
      $data['upcomingLearningCount'] = LearningSession::whereDate('date', '<', Carbon::now())->count();
      $data['userLearningCount'] = LearningSessionRegistration::count();
      $data['amountLearningCount'] = LearningSessionRegistration::sum('amount');

    return view('SuperAdmin.dashboard.learning-sessions', $data);
    }

    public function liveChats(){
      $year = ['Jan','Feb','Mar','Apr','May','Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

      $user = ['2017','1158','2019','20','586','2022', '2417','1158','2019','20','586','222'];
      // foreach ($year as $key => $value) {
      //     $user[] = User::where(\DB::raw("DATE_FORMAT(created_at, '%Y')"),$value)->count();
      // }



    $data['year'] = json_encode($year,JSON_NUMERIC_CHECK);
    $data['user'] = json_encode($user,JSON_NUMERIC_CHECK);

    $data['allLiveChatCount'] = LiveChat::count();
    $data['completeLiveChatCount'] = LiveChat::whereDate('date', '>', Carbon::now())->count();
    $data['upcomingLiveChatCount'] = LiveChat::whereDate('date', '<', Carbon::now())->count();
    $data['runningLiveChatCount'] = LiveChat::whereDate('date', '=', Carbon::now())->count();
    $data['userLiveChatCount'] = LiveChatRegistration::count();
    $data['amountLiveChatCount'] = LiveChatRegistration::sum('amount');

    return view('SuperAdmin.dashboard.live-chats', $data);
    }

    public function fanGroup(){
      $year = ['Jan','Feb','Mar','Apr','May','Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

      $user = ['2017','1158','2019','20','586','2022', '2417','1158','2019','20','586','222'];
      // foreach ($year as $key => $value) {
      //     $user[] = User::where(\DB::raw("DATE_FORMAT(created_at, '%Y')"),$value)->count();
      // }

      $data['year'] = json_encode($year,JSON_NUMERIC_CHECK);
      $data['user'] = json_encode($user,JSON_NUMERIC_CHECK);

      $data['allFanGroup'] = FanGroup::count();
      $data['allFanGroupJoin'] = Fan_Group_Join::count();
      $data['allFanPost'] = FanPost::count();

    return view('SuperAdmin.dashboard.fan-group', $data);
    }

    public function greetings(){
      $year = ['Jan','Feb','Mar','Apr','May','Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

      $user = ['2017','1158','2019','20','586','2022', '2417','1158','2019','20','586','222'];
      // foreach ($year as $key => $value) {
      //     $user[] = User::where(\DB::raw("DATE_FORMAT(created_at, '%Y')"),$value)->count();
      // }
      
      $data['year'] = json_encode($year,JSON_NUMERIC_CHECK);
      $data['user'] = json_encode($user,JSON_NUMERIC_CHECK);
      
  
    $data['allGreetingCount'] = Greeting::count();
    $data['completeGreetingCount'] = Greeting::whereDate('date', '>', Carbon::now())->count();
    $data['upcomingGreetingCount'] = Greeting::whereDate('date', '<', Carbon::now())->count();

    return view('SuperAdmin.dashboard.greetings', $data);
    }

    public function userPosts(){
      $year = ['Jan','Feb','Mar','Apr','May','Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

      $user = ['2017','1158','2019','20','586','2022', '2417','1158','2019','20','586','222'];
      // foreach ($year as $key => $value) {
      //     $user[] = User::where(\DB::raw("DATE_FORMAT(created_at, '%Y')"),$value)->count();
      // }

      $data['year'] = json_encode($year,JSON_NUMERIC_CHECK);
      $data['user'] = json_encode($user,JSON_NUMERIC_CHECK);

      $data['allPostCount'] = Post::count();
      $data['dailyPostCount'] = Post::whereDate('created_at', '=', Carbon::now())->count();
      $data['weeklyPostCount'] = Post::whereBetween('created_at', [
                                          Carbon::parse('last monday')->startOfDay(),
                                          Carbon::parse('next friday')->endOfDay(),
                                      ])->count();
      $data['monthlyPostCount'] = Post::whereMonth('created_at',date('m'))->count();

      $data['likesPost'] = Post::sum('react_number');
      $data['commentPost'] = Post::sum('comment_number');
      $data['sharePost'] = Post::sum('share_number');

    return view('SuperAdmin.dashboard.user-posts', $data);
    }
    
    public function wallets(){
      return view('SuperAdmin.dashboard.wallets');
    }
    

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
