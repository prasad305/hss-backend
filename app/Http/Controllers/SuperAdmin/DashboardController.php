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
use App\Models\Bidding;
use App\Models\GeneralPostPayment;
use App\Models\GreetingsRegistration;
use App\Models\MarketplaceOrder;
use App\Models\MeetupEvent;
use App\Models\MeetupEventRegistration;
use App\Models\QnA;
use App\Models\QnaRegistration;
use App\Models\SimplePost;
use App\Models\SouvenirApply;
use App\Models\SouvenirCreate;
use App\Models\Vaccination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Image;

class DashboardController extends Controller
{
  public function dashboard()
  {
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
    $year = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

    $user = [$january, $february, $march, $april, $may, $june, $july, $august, $september, $octobar, $november, $december];
    // foreach ($year as $key => $value) {
    //     $user[] = User::where(\DB::raw("DATE_FORMAT(created_at, '%Y')"),$value)->count();
    // }

    $data['year'] = json_encode($year, JSON_NUMERIC_CHECK);
    $data['user'] = json_encode($user, JSON_NUMERIC_CHECK);

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
    $data['totalLearningAmount'] = LearningSessionRegistration::sum('amount');
    $data['totalPostAmount'] = GeneralPostPayment::sum('amount');
    $data['totalLiveChatAmount'] = LiveChatRegistration::sum('amount');
    $data['totalGreetingAmount'] = GreetingsRegistration::sum('amount');
    $data['totalMeetUpAmount'] = MeetupEventRegistration::sum('amount');

    return view('SuperAdmin.dashboard.index', $data);
  }

  public function settings()
    {
        $user = User::find(Auth::user()->id);
        // dd($user);
        return view('SuperAdmin.profile.settings', compact('user'));
    }
    public function changeProfile(Request $request){
// dd($request);
    $user = User::find(Auth::user()->id);

    if ($request['image']) {
      // $image = $request->file('image');
      $file_Name = time() . '.' . $request->file('image')->getClientOriginalExtension();
      // $request->image->make('public/uploads/profile/image', $image_Name);
      // Image::make($image)->save('public/uploads/images/' . $image_Name);
      $user->image = $request->file('image')->storeAs('uploads', $file_Name, 'public');
    }
  //  dd($user); 
    $user->first_name = $request->first_name;
    $user->last_name = $request->last_name;
    $user->update();
    return redirect()->back()->with('success', 'Changed Successfully');

    }
    public function changePassword(Request $request){
        // return $request->all();
        $request->validate([
            'oldPassword' => 'required',
            'password' => 'required',
            'confirmPassword' => ['same:password'],
        ]);

        $userId = auth('sanctum')->user()->id;
        $users =User::find($userId);


        // oldPassword);
        // formData.append("newPassword", newPassword);

        if (\Hash::check($request->oldPassword , $users->password )){


            $users->password = bcrypt($request->password);
            $users->save();
            Auth::logout();

            return redirect()->back()->with('success', 'Changed Successfully');
        }else{
            return redirect()->back()->with('success', 'Not Changed');
        }
    }


  public function auditions()
  {
    $year = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

    $user = ['2017', '1158', '2019', '20', '586', '2022', '2417', '1158', '2019', '20', '586', '222'];
    // foreach ($year as $key => $value) {
    //     $user[] = User::where(\DB::raw("DATE_FORMAT(created_at, '%Y')"),$value)->count();
    // }

    return view('SuperAdmin.dashboard.auditions')->with('year', json_encode($year, JSON_NUMERIC_CHECK))->with('user', json_encode($user, JSON_NUMERIC_CHECK));
  }

  public function meetupEvents()
  {
    $year = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

    $user = ['2017', '1158', '2019', '20', '586', '2022', '2417', '1158', '2019', '20', '586', '222'];
    // foreach ($year as $key => $value) {
    //     $user[] = User::where(\DB::raw("DATE_FORMAT(created_at, '%Y')"),$value)->count();
    // }
    $data['year'] = json_encode($year, JSON_NUMERIC_CHECK);
    $data['user'] = json_encode($user, JSON_NUMERIC_CHECK);

    $data['meetUpOnlineCount'] = MeetupEvent::where('meetup_type', 'Online')->count();
    $data['meetUpOfflineCount'] = MeetupEvent::where('meetup_type', 'Offline')->count();
    $data['completeMeetUpOfflineCount'] = MeetupEvent::where('meetup_type', 'Offline')->whereDate('event_date', '>', Carbon::now())->count();
    $data['completeMeetUpOnlineCount'] = MeetupEvent::where('meetup_type', 'Offline')->whereDate('event_date', '>', Carbon::now())->count();
    $data['upcomingMeetUpOfflineCount'] = MeetupEvent::where('meetup_type', 'Offline')->whereDate('event_date', '<', Carbon::now())->count();
    $data['upcomingMeetUpOnlineCount'] = MeetupEvent::where('meetup_type', 'Online')->whereDate('event_date', '<', Carbon::now())->count();

    $data['userMeetUpOnlineCount'] = MeetupEventRegistration::count();
    $data['registerUserAmount'] = MeetupEventRegistration::sum('amount');

    return view('SuperAdmin.dashboard.meetup-events', $data);
  }

  public function learningSessions()
  {
    $year = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

    $user = ['2017', '1158', '2019', '20', '586', '2022', '2417', '1158', '2019', '20', '586', '222'];
    // foreach ($year as $key => $value) {
    //     $user[] = User::where(\DB::raw("DATE_FORMAT(created_at, '%Y')"),$value)->count();
    // }

    $data['year'] = json_encode($year, JSON_NUMERIC_CHECK);
    $data['user'] = json_encode($user, JSON_NUMERIC_CHECK);

    $data['allLearningCount'] = LearningSession::count();
    $data['completeLearningCount'] = LearningSession::whereDate('event_date', '>', Carbon::now())->count();
    $data['upcomingLearningCount'] = LearningSession::whereDate('event_date', '<', Carbon::now())->count();
    $data['userLearningCount'] = LearningSessionRegistration::count();
    $data['amountLearningCount'] = LearningSessionRegistration::sum('amount');

    return view('SuperAdmin.dashboard.learning-sessions', $data);
  }

  public function liveChats()
  {
    $year = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

    $user = ['2017', '1158', '2019', '20', '586', '2022', '2417', '1158', '2019', '20', '586', '222'];
    // foreach ($year as $key => $value) {
    //     $user[] = User::where(\DB::raw("DATE_FORMAT(created_at, '%Y')"),$value)->count();
    // }



    $data['year'] = json_encode($year, JSON_NUMERIC_CHECK);
    $data['user'] = json_encode($user, JSON_NUMERIC_CHECK);

    $data['allLiveChatCount'] = LiveChat::count();
    $data['completeLiveChatCount'] = LiveChat::whereDate('event_date', '>', Carbon::now())->count();
    $data['upcomingLiveChatCount'] = LiveChat::whereDate('event_date', '<', Carbon::now())->count();
    $data['runningLiveChatCount'] = LiveChat::whereDate('event_date', '=', Carbon::now())->count();
    $data['userLiveChatCount'] = LiveChatRegistration::count();
    $data['amountLiveChatCount'] = LiveChatRegistration::sum('amount');

    return view('SuperAdmin.dashboard.live-chats', $data);
  }

  public function fanGroup()
  {
    $year = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

    $user = ['2017', '1158', '2019', '20', '586', '2022', '2417', '1158', '2019', '20', '586', '222'];
    // foreach ($year as $key => $value) {
    //     $user[] = User::where(\DB::raw("DATE_FORMAT(created_at, '%Y')"),$value)->count();
    // }

    $data['year'] = json_encode($year, JSON_NUMERIC_CHECK);
    $data['user'] = json_encode($user, JSON_NUMERIC_CHECK);

    $data['allFanGroup'] = FanGroup::count();
    $data['allFanGroupJoin'] = Fan_Group_Join::count();
    $data['allFanPost'] = FanPost::count();

    return view('SuperAdmin.dashboard.fan-group', $data);
  }

  public function greetings()
  {
    $year = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

    $user = ['2017', '1158', '2019', '20', '586', '2022', '2417', '1158', '2019', '20', '586', '222'];
    // foreach ($year as $key => $value) {
    //     $user[] = User::where(\DB::raw("DATE_FORMAT(created_at, '%Y')"),$value)->count();
    // }

    $data['year'] = json_encode($year, JSON_NUMERIC_CHECK);
    $data['user'] = json_encode($user, JSON_NUMERIC_CHECK);


    $data['allGreetingCount'] = Greeting::count();
    $data['completeGreetingCount'] = Greeting::whereDate('created_at', '>', Carbon::now())->count();
    $data['upcomingGreetingCount'] = Greeting::whereDate('created_at', '<', Carbon::now())->count();

    return view('SuperAdmin.dashboard.greetings', $data);
  }

  public function userPosts()
  {
    $year = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

    $user = ['2017', '1158', '2019', '20', '586', '2022', '2417', '1158', '2019', '20', '586', '222'];
    // foreach ($year as $key => $value) {
    //     $user[] = User::where(\DB::raw("DATE_FORMAT(created_at, '%Y')"),$value)->count();
    // }

    $data['year'] = json_encode($year, JSON_NUMERIC_CHECK);
    $data['user'] = json_encode($user, JSON_NUMERIC_CHECK);

    $data['allPostCount'] = Post::count();
    $data['dailyPostCount'] = Post::whereDate('created_at', '=', Carbon::now())->count();
    $data['weeklyPostCount'] = Post::whereBetween('created_at', [
      Carbon::parse('last monday')->startOfDay(),
      Carbon::parse('next friday')->endOfDay(),
    ])->count();
    $data['monthlyPostCount'] = Post::whereMonth('created_at', date('m'))->count();

    $data['likesPost'] = Post::sum('react_number');
    $data['commentPost'] = Post::sum('comment_number');
    $data['sharePost'] = Post::sum('share_number');

    return view('SuperAdmin.dashboard.user-posts', $data);
  }

  public function wallets()
  {
    return view('SuperAdmin.dashboard.wallets');
  }


  public function packageStore(Request $request)
  {
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


  public function profile()
  {
    $user = Auth::user();
    return view('SuperAdmin.profile.index', compact('user'));
  }

  // Dashboard Meetup
  public function meetupEventsDashboard()
  {

    $categories = Category::get();
    $total = MeetupEvent::count();
    $published = MeetupEvent::where('status', 2)->count();
    $pending = MeetupEvent::where('status', '<', 2)->count();
    $rejected = MeetupEvent::where('status', 11)->count();
    // Registered User

    $weeklyUser = MeetupEventRegistration::where('created_at', '>', Carbon::now()->startOfWeek())->where('created_at', '<', Carbon::now()->endOfWeek())->count();
    $monthlyUser = MeetupEventRegistration::where('created_at', '>', Carbon::now()->startOfMonth())->where('created_at', '<', Carbon::now()->endOfMonth())->count();
    $yearlyUser = MeetupEventRegistration::where('created_at', '>', Carbon::now()->startOfYear())->where('created_at', '<', Carbon::now()->endOfYear())->count();

    // Income Statement

    $weeklyIncome = MeetupEventRegistration::where('created_at', '>', Carbon::now()->startOfWeek())->where('created_at', '<', Carbon::now()->endOfWeek())->sum('amount');
    $monthlyIncome = MeetupEventRegistration::where('created_at', '>', Carbon::now()->startOfMonth())->where('created_at', '<', Carbon::now()->endOfMonth())->sum('amount');
    $yearlyIncome = MeetupEventRegistration::where('created_at', '>', Carbon::now()->startOfYear())->where('created_at', '<', Carbon::now()->endOfYear())->sum('amount');


    $labels = MeetupEventRegistration::get(['id', 'created_at', 'amount'])->groupBy(function ($date) {
      return Carbon::parse($date->created_at)->format('M');
    });

    $months = [];
    $amountCount = [];
    foreach ($labels as $month => $values) {
      $months[] = $month;
      $amountCount[] = $values->sum('amount');
    }

    return view('SuperAdmin.dashboard.Meetup.dashboard', compact('categories', 'total', 'published', 'pending', 'rejected', 'weeklyUser', 'monthlyUser', 'yearlyUser', 'weeklyIncome', 'monthlyIncome', 'yearlyIncome'))->with('months', json_encode($months, JSON_NUMERIC_CHECK))->with('amountCount', json_encode($amountCount, JSON_NUMERIC_CHECK));
  }
  public function meetupDataList($type)
  {
    if ($type == 'total') {
      $postList = MeetupEvent::with(['star', 'category'])->get();
    } elseif ($type == 'published') {
      $postList = MeetupEvent::with(['star', 'category'])->where('status', 2)->get();
    } elseif ($type == 'pending') {
      $postList = MeetupEvent::with(['star', 'category'])->where('status', '<', 2)->get();
    } else {
      $postList = MeetupEvent::with(['star', 'category'])->where('status', 11)->get();
    }
    return view('SuperAdmin.dashboard.Meetup.postDataList', compact('postList'));
  }
  public function meetupManagerAdminList()
  {
    $users = User::where('user_type', 'manager-admin')->latest()->get();
    return view('SuperAdmin.dashboard.Meetup.ManagerAdmin.manager_admin', compact('users'));
  }
  public function meetupManagerAdminEvents($id)
  {
    $posts = MeetupEvent::where('category_id', $id)->get();
    return view('SuperAdmin.dashboard.Meetup.ManagerAdmin.manager_admin_events', compact('posts'));
  }
  public function meetupAdminList()
  {
    $users = User::where('user_type', 'admin')->latest()->get();
    return view('SuperAdmin.dashboard.Meetup.Admin.admin', compact('users'));
  }
  public function meetupAdminEvents($id)
  {
    $posts = MeetupEvent::where('admin_id', $id)->get();
    return view('SuperAdmin.dashboard.Meetup.Admin.admin_events', compact('posts'));
  }
  public function meetupSuperstarList()
  {
    $users = User::where('user_type', 'star')->latest()->get();
    return view('SuperAdmin.dashboard.Meetup.Superstar.superstar', compact('users'));
  }
  public function meetupSuperstarEvents($id)
  {

    $posts = MeetupEvent::where('star_id', $id)->get();
    return view('SuperAdmin.dashboard.Meetup.Superstar.superstar_events', compact('posts'));
  }

  // Dashboard Learning Session
  public function learningSessionEventsDashboard()
  {
    $categories = Category::get();
    $total = LearningSession::count();
    $published = LearningSession::where('status', 2)->count();
    $pending = LearningSession::where('status', '<', 2)->count();
    $rejected = LearningSession::where('status', 11)->count();
    $labels = LearningSessionRegistration::get(['id', 'created_at', 'amount'])->groupBy(function ($date) {
      return Carbon::parse($date->created_at)->format('M');
    });

    // Registered User

    $weeklyUser = LearningSessionRegistration::where('created_at', '>', Carbon::now()->startOfWeek())->where('created_at', '<', Carbon::now()->endOfWeek())->count();
    $monthlyUser = LearningSessionRegistration::where('created_at', '>', Carbon::now()->startOfMonth())->where('created_at', '<', Carbon::now()->endOfMonth())->count();
    $yearlyUser = LearningSessionRegistration::where('created_at', '>', Carbon::now()->startOfYear())->where('created_at', '<', Carbon::now()->endOfYear())->count();

    // Income Statement

    $weeklyIncome = LearningSessionRegistration::where('created_at', '>', Carbon::now()->startOfWeek())->where('created_at', '<', Carbon::now()->endOfWeek())->sum('amount');
    $monthlyIncome = LearningSessionRegistration::where('created_at', '>', Carbon::now()->startOfMonth())->where('created_at', '<', Carbon::now()->endOfMonth())->sum('amount');
    $yearlyIncome = LearningSessionRegistration::where('created_at', '>', Carbon::now()->startOfYear())->where('created_at', '<', Carbon::now()->endOfYear())->sum('amount');


    $months = [];
    $amountCount = [];
    foreach ($labels as $month => $values) {
      $months[] = $month;
      $amountCount[] = $values->sum('amount');
    }

    return view('SuperAdmin.dashboard.LearningSession.dashboard', compact('categories', 'total', 'published', 'pending', 'rejected', 'weeklyUser', 'monthlyUser', 'yearlyUser', 'weeklyIncome', 'monthlyIncome', 'yearlyIncome'))->with('months', json_encode($months, JSON_NUMERIC_CHECK))->with('amountCount', json_encode($amountCount, JSON_NUMERIC_CHECK));
  }
  public function learningSessionDataList($type)
  {
    if ($type == 'total') {
      $postList = LearningSession::with(['star', 'category'])->get();
    } elseif ($type == 'published') {
      $postList = LearningSession::with(['star', 'category'])->where('status', 2)->get();
    } elseif ($type == 'pending') {
      $postList = LearningSession::with(['star', 'category'])->where('status', '<', 2)->get();
    } else {
      $postList = LearningSession::with(['star', 'category'])->where('status', 11)->get();
    }
    return view('SuperAdmin.dashboard.LearningSession.postDataList', compact('postList'));
  }
  public function learningSessionManagerAdminList()
  {
    $users = User::where('user_type', 'manager-admin')->latest()->get();
    return view('SuperAdmin.dashboard.LearningSession.ManagerAdmin.manager_admin', compact('users'));
  }
  public function learningSessionManagerAdminEvents($id)
  {
    $posts = LearningSession::where('category_id', $id)->get();
    return view('SuperAdmin.dashboard.LearningSession.ManagerAdmin.manager_admin_events', compact('posts'));
  }
  public function learningSessionAdminList()
  {
    $users = User::where('user_type', 'admin')->latest()->get();
    return view('SuperAdmin.dashboard.LearningSession.Admin.admin', compact('users'));
  }
  public function learningSessionAdminEvents($id)
  {
    $posts = LearningSession::where('admin_id', $id)->get();
    return view('SuperAdmin.dashboard.LearningSession.Admin.admin_events', compact('posts'));
  }
  public function learningSessionSuperstarList()
  {
    $users = User::where('user_type', 'star')->latest()->get();
    return view('SuperAdmin.dashboard.LearningSession.Superstar.superstar', compact('users'));
  }
  public function learningSessionSuperstarEvents($id)
  {
    $posts = LearningSession::where('star_id', $id)->get();
    return view('SuperAdmin.dashboard.LearningSession.Superstar.superstar_events', compact('posts'));
  }
  // Dashboard Live Chat
  public function liveChatEventsDashboard()
  {
    $categories = Category::get();
    $total = LiveChat::count();
    $published = LiveChat::where('status', 2)->count();
    $pending = LiveChat::where('status', '<', 2)->count();
    $rejected = LiveChat::where('status', 11)->count();
    // Registered User

    $weeklyUser = LiveChatRegistration::where('created_at', '>', Carbon::now()->startOfWeek())->where('created_at', '<', Carbon::now()->endOfWeek())->count();
    $monthlyUser = LiveChatRegistration::where('created_at', '>', Carbon::now()->startOfMonth())->where('created_at', '<', Carbon::now()->endOfMonth())->count();
    $yearlyUser = LiveChatRegistration::where('created_at', '>', Carbon::now()->startOfYear())->where('created_at', '<', Carbon::now()->endOfYear())->count();

    // Income Statement

    $weeklyIncome = LiveChatRegistration::where('created_at', '>', Carbon::now()->startOfWeek())->where('created_at', '<', Carbon::now()->endOfWeek())->sum('amount');
    $monthlyIncome = LiveChatRegistration::where('created_at', '>', Carbon::now()->startOfMonth())->where('created_at', '<', Carbon::now()->endOfMonth())->sum('amount');
    $yearlyIncome = LiveChatRegistration::where('created_at', '>', Carbon::now()->startOfYear())->where('created_at', '<', Carbon::now()->endOfYear())->sum('amount');


    $labels = LiveChatRegistration::get(['id', 'created_at', 'amount'])->groupBy(function ($date) {
      return Carbon::parse($date->created_at)->format('M');
    });

    $months = [];
    $amountCount = [];
    foreach ($labels as $month => $values) {
      $months[] = $month;
      $amountCount[] = $values->sum('amount');
    }

    return view('SuperAdmin.dashboard.LiveChat.dashboard', compact('categories', 'total', 'published', 'pending', 'rejected', 'weeklyUser', 'monthlyUser', 'yearlyUser', 'weeklyIncome', 'monthlyIncome', 'yearlyIncome'))->with('months', json_encode($months, JSON_NUMERIC_CHECK))->with('amountCount', json_encode($amountCount, JSON_NUMERIC_CHECK));
  }
  public function liveChatDataList($type)
  {
    if ($type == 'total') {
      $postList = LiveChat::with(['star', 'category'])->get();
    } elseif ($type == 'published') {
      $postList = LiveChat::with(['star', 'category'])->where('status', 2)->get();
    } elseif ($type == 'pending') {
      $postList = LiveChat::with(['star', 'category'])->where('status', '<', 2)->get();
    } else {
      $postList = LiveChat::with(['star', 'category'])->where('status', 11)->get();
    }
    return view('SuperAdmin.dashboard.LiveChat.postDataList', compact('postList'));
  }
  public function liveChatManagerAdminList()
  {
    $users = User::where('user_type', 'manager-admin')->latest()->get();
    return view('SuperAdmin.dashboard.LiveChat.ManagerAdmin.manager_admin', compact('users'));
  }
  public function liveChatManagerAdminEvents($id)
  {
    $posts = LiveChat::where('category_id', $id)->get();
    return view('SuperAdmin.dashboard.LiveChat.ManagerAdmin.manager_admin_events', compact('posts'));
  }
  public function liveChatAdminList()
  {
    $users = User::where('user_type', 'admin')->latest()->get();
    return view('SuperAdmin.dashboard.LiveChat.Admin.admin', compact('users'));
  }
  public function liveChatAdminEvents($id)
  {

    $posts = LiveChat::where('admin_id', $id)->get();
    return view('SuperAdmin.dashboard.LiveChat.Admin.admin_events', compact('posts'));
  }
  public function liveChatSuperstarList()
  {
    $users = User::where('user_type', 'star')->latest()->get();
    return view('SuperAdmin.dashboard.LiveChat.Superstar.superstar', compact('users'));
  }
  public function liveChatSuperstarEvents($id)
  {
    $posts = LiveChat::where('star_id', $id)->get();
    return view('SuperAdmin.dashboard.LiveChat.Superstar.superstar_events', compact('posts'));
  }

  // Dashboard Greeting
  public function greetingEventsDashboard()
  {
    $categories = Category::get();
    $total = Greeting::count();
    $published = Greeting::where('status', 2)->count();
    $pending = Greeting::where('status', '<', 2)->count();
    $rejected = Greeting::where('status', 11)->count();
    // Registered User

    $weeklyUser = GreetingsRegistration::where('created_at', '>', Carbon::now()->startOfWeek())->where('created_at', '<', Carbon::now()->endOfWeek())->count();
    $monthlyUser = GreetingsRegistration::where('created_at', '>', Carbon::now()->startOfMonth())->where('created_at', '<', Carbon::now()->endOfMonth())->count();
    $yearlyUser = GreetingsRegistration::where('created_at', '>', Carbon::now()->startOfYear())->where('created_at', '<', Carbon::now()->endOfYear())->count();

    // Income Statement

    $weeklyIncome = GreetingsRegistration::where('created_at', '>', Carbon::now()->startOfWeek())->where('created_at', '<', Carbon::now()->endOfWeek())->sum('amount');
    $monthlyIncome = GreetingsRegistration::where('created_at', '>', Carbon::now()->startOfMonth())->where('created_at', '<', Carbon::now()->endOfMonth())->sum('amount');
    $yearlyIncome = GreetingsRegistration::where('created_at', '>', Carbon::now()->startOfYear())->where('created_at', '<', Carbon::now()->endOfYear())->sum('amount');


    $labels = GreetingsRegistration::get(['id', 'created_at', 'amount'])->groupBy(function ($date) {
      return Carbon::parse($date->created_at)->format('M');
    });

    $months = [];
    $amountCount = [];
    foreach ($labels as $month => $values) {
      $months[] = $month;
      $amountCount[] = $values->sum('amount');
    }

    return view('SuperAdmin.dashboard.Greeting.dashboard', compact('categories', 'total', 'published', 'pending', 'rejected', 'weeklyUser', 'monthlyUser', 'yearlyUser', 'weeklyIncome', 'monthlyIncome', 'yearlyIncome'))->with('months', json_encode($months, JSON_NUMERIC_CHECK))->with('amountCount', json_encode($amountCount, JSON_NUMERIC_CHECK));
  }
  public function greetingDataList($type)
  {
    if ($type == 'total') {
      $postList = Greeting::with(['star', 'category'])->get();
    } elseif ($type == 'published') {
      $postList = Greeting::with(['star', 'category'])->where('status', 2)->get();
    } elseif ($type == 'pending') {
      $postList = Greeting::with(['star', 'category'])->where('status', '<', 2)->get();
    } else {
      $postList = Greeting::with(['star', 'category'])->where('status', 11)->get();
    }
    return view('SuperAdmin.dashboard.Greeting.postDataList', compact('postList'));
  }
  public function greetingManagerAdminList()
  {
    $users = User::where('user_type', 'manager-admin')->latest()->get();
    return view('SuperAdmin.dashboard.Greeting.ManagerAdmin.manager_admin', compact('users'));
  }
  public function greetingManagerAdminEvents($id)
  {
    $posts = Greeting::where('category_id', $id)->get();
    return view('SuperAdmin.dashboard.Greeting.ManagerAdmin.manager_admin_events', compact('posts'));
  }
  public function greetingAdminList()
  {
    $users = User::where('user_type', 'admin')->latest()->get();
    return view('SuperAdmin.dashboard.Greeting.Admin.admin', compact('users'));
  }
  public function greetingAdminEvents($id)
  {
    $posts = Greeting::where('admin_id', $id)->get();
    return view('SuperAdmin.dashboard.Greeting.Admin.admin_events', compact('posts'));
  }
  public function greetingSuperstarList()
  {
    $users = User::where('user_type', 'star')->latest()->get();
    return view('SuperAdmin.dashboard.Greeting.Superstar.superstar', compact('users'));
  }
  public function greetingSuperstarEvents($id)
  {
    $posts = Greeting::where('star_id', $id)->get();
    return view('SuperAdmin.dashboard.Greeting.Superstar.superstar_events', compact('posts'));
  }
  // Dashboard Fan Group
  public function fanGroupEventsDashboard()
  {
    $categories = Category::get();
    $total = FanGroup::count();
    $published = FanGroup::where('status', 1)->count();
    $pending = FanGroup::where('status', 0)->count();
    $rejected = FanGroup::where('status', 11)->count();

    $weeklyUser = Fan_Group_Join::distinct('user_id')->where('created_at', '>', Carbon::now()->startOfWeek())->where('created_at', '<', Carbon::now()->endOfWeek())->count();
    $monthlyUser = Fan_Group_Join::distinct('user_id')->where('created_at', '>', Carbon::now()->startOfMonth())->where('created_at', '<', Carbon::now()->endOfMonth())->count();
    $yearlyUser = Fan_Group_Join::distinct('user_id')->where('created_at', '>', Carbon::now()->startOfYear())->where('created_at', '<', Carbon::now()->endOfYear())->count();

    // $labels = LiveChatRegistration::get(['id', 'created_at', 'amount'])->groupBy(function ($date) {
    //   return Carbon::parse($date->created_at)->format('M');
    // });

    // $months = [];
    // $amountCount = [];
    // foreach ($labels as $month => $values) {
    //   $months[] = $month;
    //   $amountCount[] = $values->sum('amount');
    // }

    return view('SuperAdmin.dashboard.FanGroup.dashboard', compact('categories', 'total', 'published', 'pending', 'rejected', 'weeklyUser', 'monthlyUser', 'yearlyUser'));
  }
  public function fanGroupDataList($type)
  {
    if ($type == 'total') {
      $postList = FanGroup::with(['star', 'category'])->get();
    } elseif ($type == 'published') {
      $postList = FanGroup::with(['star', 'category'])->where('status', 1)->get();
    } elseif ($type == 'pending') {
      $postList = FanGroup::with(['star', 'category'])->where('status', 0)->get();
    } else {
      $postList = FanGroup::with(['star', 'category'])->where('status', 11)->get();
    }
    return view('SuperAdmin.dashboard.FanGroup.postDataList', compact('postList'));
  }
  public function fanGroupManagerAdminList()
  {
    $users = User::where('user_type', 'manager-admin')->latest()->get();
    return view('SuperAdmin.dashboard.FanGroup.ManagerAdmin.manager_admin', compact('users'));
  }
  public function fanGroupManagerAdminEvents($id)
  {

    $posts = FanGroup::where('category_id', $id)->get();
    return view('SuperAdmin.dashboard.FanGroup.ManagerAdmin.manager_admin_events', compact('posts'));
  }
  public function fanGroupAdminList()
  {
    $users = User::where('user_type', 'admin')->latest()->get();
    return view('SuperAdmin.dashboard.FanGroup.Admin.admin', compact('users'));
  }
  public function fanGroupAdminEvents($id)
  {
    $posts = FanGroup::where('created_by', $id)->orWhere('another_star_admin_id', $id)->get();
    return view('SuperAdmin.dashboard.FanGroup.Admin.admin_events', compact('posts'));
  }
  public function fanGroupSuperstarList()
  {
    $users = User::where('user_type', 'star')->latest()->get();
    return view('SuperAdmin.dashboard.FanGroup.Superstar.superstar', compact('users'));
  }
  public function fanGroupSuperstarEvents($id)
  {
    $posts = FanGroup::where('my_star', $id)->get();
    return view('SuperAdmin.dashboard.FanGroup.Superstar.superstar_events', compact('posts'));
  }


  // Dashboard Q&A

  public function qnaEventsDashboard()
  {
    $categories = Category::get();
    $total = QnA::count();
    $published = QnA::where('status', 2)->count();
    $pending = QnA::where('status', '<', 2)->count();
    $rejected = QnA::where('status', 11)->count();

    // Registered User

    $weeklyUser = QnaRegistration::where('created_at', '>', Carbon::now()->startOfWeek())->where('created_at', '<', Carbon::now()->endOfWeek())->count();
    $monthlyUser = QnaRegistration::where('created_at', '>', Carbon::now()->startOfMonth())->where('created_at', '<', Carbon::now()->endOfMonth())->count();
    $yearlyUser = QnaRegistration::where('created_at', '>', Carbon::now()->startOfYear())->where('created_at', '<', Carbon::now()->endOfYear())->count();

    // Income Statement

    $weeklyIncome = QnaRegistration::where('created_at', '>', Carbon::now()->startOfWeek())->where('created_at', '<', Carbon::now()->endOfWeek())->sum('amount');
    $monthlyIncome = QnaRegistration::where('created_at', '>', Carbon::now()->startOfMonth())->where('created_at', '<', Carbon::now()->endOfMonth())->sum('amount');
    $yearlyIncome = QnaRegistration::where('created_at', '>', Carbon::now()->startOfYear())->where('created_at', '<', Carbon::now()->endOfYear())->sum('amount');


    $labels = QnaRegistration::get(['id', 'created_at', 'amount'])->groupBy(function ($date) {
      return Carbon::parse($date->created_at)->format('M');
    });

    $months = [];
    $amountCount = [];
    foreach ($labels as $month => $values) {
      $months[] = $month;
      $amountCount[] = $values->sum('amount');
    }

    return view('SuperAdmin.dashboard.QnA.dashboard', compact('categories', 'total', 'published', 'pending', 'rejected', 'weeklyUser', 'monthlyUser', 'yearlyUser', 'weeklyIncome', 'monthlyIncome', 'yearlyIncome'))->with('months', json_encode($months, JSON_NUMERIC_CHECK))->with('amountCount', json_encode($amountCount, JSON_NUMERIC_CHECK));
  }
  public function qnaDataList($type)
  {
    if ($type == 'total') {
      $postList = QnA::with(['star', 'category'])->get();
    } elseif ($type == 'published') {
      $postList = QnA::with(['star', 'category'])->where('status', 2)->get();
    } elseif ($type == 'pending') {
      $postList = QnA::with(['star', 'category'])->where('status', '<', 2)->get();
    } else {
      $postList = QnA::with(['star', 'category'])->where('status', 11)->get();
    }
    return view('SuperAdmin.dashboard.QnA.postDataList', compact('postList'));
  }

  public function qnaManagerAdminList()
  {
    $users = User::where('user_type', 'manager-admin')->latest()->get();
    return view('SuperAdmin.dashboard.QnA.ManagerAdmin.manager_admin', compact('users'));
  }
  public function qnaManagerAdminEvents($id)
  {
    $posts = QnA::where('category_id', $id)->get();
    return view('SuperAdmin.dashboard.QnA.ManagerAdmin.manager_admin_events', compact('posts'));
  }
  public function qnaAdminList()
  {
    $users = User::where('user_type', 'admin')->latest()->get();
    return view('SuperAdmin.dashboard.QnA.Admin.admin', compact('users'));
  }
  public function qnaAdminEvents($id)
  {
    $posts = QnA::where('admin_id', $id)->get();
    return view('SuperAdmin.dashboard.QnA.Admin.admin_events', compact('posts'));
  }
  public function qnaSuperstarList()
  {
    $users = User::where('user_type', 'star')->latest()->get();
    return view('SuperAdmin.dashboard.QnA.Superstar.superstar', compact('users'));
  }
  public function qnaSuperstarEvents($id)
  {
    $posts = QnA::where('star_id', $id)->get();
    return view('SuperAdmin.dashboard.QnA.Superstar.superstar_events', compact('posts'));
  }

  // Dashboard simple post
  public function simplePostEventsDashboard()
  {
    $categories = Category::get();
    $total = SimplePost::count();
    $published = SimplePost::where('status', ">=", 1)->count();
    $pending = SimplePost::where('status', 0)->where('star_approval', 1)->count();
    $rejected = SimplePost::where('star_approval', 2)->count();

    // Registered User
    $weeklyUser = GeneralPostPayment::where('created_at', '>', Carbon::now()->startOfWeek())->where('created_at', '<', Carbon::now()->endOfWeek())->count();
    $monthlyUser = GeneralPostPayment::where('created_at', '>', Carbon::now()->startOfMonth())->where('created_at', '<', Carbon::now()->endOfMonth())->count();
    $yearlyUser = GeneralPostPayment::where('created_at', '>', Carbon::now()->startOfYear())->where('created_at', '<', Carbon::now()->endOfYear())->count();

    // Income Statement
    $weeklyIncome = GeneralPostPayment::where('created_at', '>', Carbon::now()->startOfWeek())->where('created_at', '<', Carbon::now()->endOfWeek())->sum('amount');
    $monthlyIncome = GeneralPostPayment::where('created_at', '>', Carbon::now()->startOfMonth())->where('created_at', '<', Carbon::now()->endOfMonth())->sum('amount');
    $yearlyIncome = GeneralPostPayment::where('created_at', '>', Carbon::now()->startOfYear())->where('created_at', '<', Carbon::now()->endOfYear())->sum('amount');

    $labels = GeneralPostPayment::get(['id', 'created_at', 'amount'])->groupBy(function ($date) {
      return Carbon::parse($date->created_at)->format('M');
    });

    $months = [];
    $amountCount = [];
    foreach ($labels as $month => $values) {
      $months[] = $month;
      $amountCount[] = $values->sum('amount');
    }

    return view('SuperAdmin.dashboard.SimplePost.dashboard', compact('categories', 'total', 'published', 'pending', 'rejected', 'weeklyUser', 'monthlyUser', 'yearlyUser', 'weeklyIncome', 'monthlyIncome', 'yearlyIncome'))->with('months', json_encode($months, JSON_NUMERIC_CHECK))->with('amountCount', json_encode($amountCount, JSON_NUMERIC_CHECK));
  }
  public function postDataList($type)
  {
    if ($type == 'total') {
      $postList = SimplePost::with(['star', 'category'])->get();
    } elseif ($type == 'published') {
      $postList = SimplePost::with(['star', 'category'])->where('status', 1)->get();
    } elseif ($type == 'pending') {
      $postList = SimplePost::with(['star', 'category'])->where('status', 0)->where('star_approval', 1)->get();
    } else {
      $postList = SimplePost::with(['star', 'category'])->where('star_approval', 2)->get();
    }
    return view('SuperAdmin.dashboard.SimplePost.postDataList', compact('postList'));
  }
  public function simplePostManagerAdminList()
  {
    $users = User::where('user_type', 'manager-admin')->latest()->get();
    return view('SuperAdmin.dashboard.SimplePost.ManagerAdmin.manager_admin', compact('users'));
  }
  public function simplePostManagerAdminEvents($id)
  {
    $posts = SimplePost::where('category_id', $id)->get();
    return view('SuperAdmin.dashboard.SimplePost.ManagerAdmin.manager_admin_events', compact('posts'));
  }
  public function simplePostAdminList()
  {
    $users = User::where('user_type', 'admin')->latest()->get();
    return view('SuperAdmin.dashboard.SimplePost.Admin.admin', compact('users'));
  }
  public function simplePostAdminEvents($id)
  {
    $posts = SimplePost::where('admin_id', $id)->get();
    return view('SuperAdmin.dashboard.SimplePost.Admin.admin_events', compact('posts'));
  }
  public function simplePostSuperstarList()
  {
    $users = User::where('user_type', 'star')->latest()->get();
    return view('SuperAdmin.dashboard.SimplePost.Superstar.superstar', compact('users'));
  }
  public function simplePostSuperstarEvents($id)
  {
    $posts = SimplePost::where('star_id', $id)->get();
    return view('SuperAdmin.dashboard.SimplePost.Superstar.superstar_events', compact('posts'));
  }
  // Dashboard Audition
  public function auditionEventsDashboard()
  {
    return view('SuperAdmin.dashboard.Audition.dashboard');
  }
  public function auditionManagerAdminList()
  {
    return view('SuperAdmin.dashboard.Audition.ManagerAdmin.manager_admin');
  }
  public function auditionManagerAdminEvents()
  {
    return view('SuperAdmin.dashboard.Audition.ManagerAdmin.manager_admin_events');
  }
  public function adminList()
  {
    return view('SuperAdmin.dashboard.Audition.Admin.admin');
  }
  public function adminEvents()
  {
    return view('SuperAdmin.dashboard.Audition.Admin.admin_events');
  }
  public function auditionAdminList()
  {
    return view('SuperAdmin.dashboard.Audition.AuditionAdmin.audition_admin');
  }
  public function auditionAdminEvents()
  {
    return view('SuperAdmin.dashboard.Audition.AuditionAdmin.audition_admin_events');
  }
  public function auditionSuperstarList()
  {
    return view('SuperAdmin.dashboard.Audition.Superstar.superstar');
  }
  public function auditionSuperstarEvents()
  {
    return view('SuperAdmin.dashboard.Audition.Superstar.superstar_events');
  }

  // Auction

  public function auctionEventsDashboard()
  {
    $categories = Category::get();
    $total = Auction::count();
    $published = Auction::where('product_status', 1)->count();
    $pending = Auction::where('product_status', 0)->count();
    $rejected = Auction::where('star_approval', 2)->count();

    // Registered User

    $weeklyUser = Bidding::distinct('user_id')->where('created_at', '>', Carbon::now()->startOfWeek())->where('created_at', '<', Carbon::now()->endOfWeek())->count();
    $monthlyUser = Bidding::distinct('user_id')->where('created_at', '>', Carbon::now()->startOfMonth())->where('created_at', '<', Carbon::now()->endOfMonth())->count();
    $yearlyUser = Bidding::distinct('user_id')->where('created_at', '>', Carbon::now()->startOfYear())->where('created_at', '<', Carbon::now()->endOfYear())->count();

    // Income Statement

    $weeklyIncome = Bidding::where('win_status', 1)->where('created_at', '>', Carbon::now()->startOfWeek())->where('created_at', '<', Carbon::now()->endOfWeek())->distinct()->get('amount')->sum('amount');
    $monthlyIncome = Bidding::where('win_status', 1)->where('created_at', '>', Carbon::now()->startOfMonth())->where('created_at', '<', Carbon::now()->endOfMonth())->distinct()->get('amount')->sum('amount');
    $yearlyIncome = Bidding::where('win_status', 1)->where('created_at', '>', Carbon::now()->startOfYear())->where('created_at', '<', Carbon::now()->endOfYear())->distinct()->get('amount')->sum('amount');

    $labels = Bidding::where('win_status', 1)->get(['id', 'created_at', 'amount'])->groupBy(function ($date) {
      return Carbon::parse($date->created_at)->format('M');
    });

    $months = [];
    $amountCount = [];
    foreach ($labels as $month => $values) {
      $months[] = $month;
      $amountCount[] = $values->sum('amount');
    }

    return view('SuperAdmin.dashboard.Auction.dashboard', compact('categories', 'total', 'published', 'pending', 'rejected', 'weeklyUser', 'monthlyUser', 'yearlyUser', 'weeklyIncome', 'monthlyIncome', 'yearlyIncome'))->with('months', json_encode($months, JSON_NUMERIC_CHECK))->with('amountCount', json_encode($amountCount, JSON_NUMERIC_CHECK));
  }
  public function auctionDataList($type)
  {
    if ($type == 'total') {
      $postList = Auction::with(['star', 'category'])->get();
    } elseif ($type == 'sold') {
      $postList = Auction::with(['star', 'category'])->where('product_status', 1)->get();
    } elseif ($type == 'unsold') {
      $postList = Auction::with(['star', 'category'])->where('product_status', 0)->get();
    } else {
      $postList = Auction::with(['star', 'category'])->where('star_approval', 2)->get();
    }
    return view('SuperAdmin.dashboard.Auction.postDataList', compact('postList'));
  }
  public function auctionManagerAdminList()
  {
    $users = User::where('user_type', 'manager-admin')->latest()->get();
    return view('SuperAdmin.dashboard.Auction.ManagerAdmin.manager_admin', compact('users'));
  }
  public function auctionManagerAdminEvents($id)
  {
    $posts = Auction::where('category_id', $id)->get();
    return view('SuperAdmin.dashboard.Auction.ManagerAdmin.manager_admin_events', compact('posts'));
  }
  public function auctionAdminList()
  {
    $users = User::where('user_type', 'admin')->latest()->get();
    return view('SuperAdmin.dashboard.Auction.Admin.admin', compact('users'));
  }
  public function auctionAdminEvents($id)
  {
    $posts = Auction::where('admin_id', $id)->get();
    return view('SuperAdmin.dashboard.Auction.Admin.admin_events', compact('posts'));
  }
  public function auctionSuperstarList()
  {
    $users = User::where('user_type', 'star')->latest()->get();
    return view('SuperAdmin.dashboard.Auction.Superstar.superstar', compact('users'));
  }
  public function auctionSuperstarEvents($id)
  {
    $posts = Auction::where('star_id', $id)->get();
    return view('SuperAdmin.dashboard.Auction.Superstar.superstar_events', compact('posts'));
  }

  // Marketplace

  public function marketplaceEventsDashboard()
  {
    $categories = Category::get();
    $total = Marketplace::sum('total_items');
    $soldItem = Marketplace::sum('total_selling');
    // Registered User

    $weeklyUser = MarketplaceOrder::distinct('user_id')->where('created_at', '>', Carbon::now()->startOfWeek())->where('created_at', '<', Carbon::now()->endOfWeek())->count();
    $monthlyUser = MarketplaceOrder::distinct('user_id')->where('created_at', '>', Carbon::now()->startOfMonth())->where('created_at', '<', Carbon::now()->endOfMonth())->count();
    $yearlyUser = MarketplaceOrder::distinct('user_id')->where('created_at', '>', Carbon::now()->startOfYear())->where('created_at', '<', Carbon::now()->endOfYear())->count();

    // Income Statement

    $weeklyIncome = MarketplaceOrder::where('created_at', '>', Carbon::now()->startOfWeek())->where('created_at', '<', Carbon::now()->endOfWeek())->sum('total_price');
    $monthlyIncome = MarketplaceOrder::where('created_at', '>', Carbon::now()->startOfMonth())->where('created_at', '<', Carbon::now()->endOfMonth())->sum('total_price');
    $yearlyIncome = MarketplaceOrder::where('created_at', '>', Carbon::now()->startOfYear())->where('created_at', '<', Carbon::now()->endOfYear())->sum('total_price');

    $labels = MarketplaceOrder::get(['id', 'created_at', 'total_price'])->groupBy(function ($date) {
      return Carbon::parse($date->created_at)->format('M');
    });

    $months = [];
    $amountCount = [];
    foreach ($labels as $month => $values) {
      $months[] = $month;
      $amountCount[] = $values->sum('total_price');
    }

    return view('SuperAdmin.dashboard.Marketplace.dashboard', compact('categories', 'total', 'soldItem', 'weeklyUser', 'monthlyUser', 'yearlyUser', 'weeklyIncome', 'monthlyIncome', 'yearlyIncome'))->with('months', json_encode($months, JSON_NUMERIC_CHECK))->with('amountCount', json_encode($amountCount, JSON_NUMERIC_CHECK));
  }
  public function marketplaceDataList($type)
  {
    if ($type == 'total') {
      $postList = Marketplace::with(['superstar', 'category'])->get();
    } elseif ($type == 'instock') {
      $postList = Marketplace::with(['superstar', 'category'])->where('status', 1)->where('total_items', '>', 0)->get();
    } else {
      $postList = Marketplace::with(['superstar', 'category'])->where('status', 1)->where('total_items', '>', 0)->where('total_selling', '>', 0)->get();
    }
    return view('SuperAdmin.dashboard.Marketplace.postDataList', compact('postList'));
  }
  public function marketplaceManagerAdminList()
  {
    $users = User::where('user_type', 'manager-admin')->latest()->get();
    return view('SuperAdmin.dashboard.Marketplace.ManagerAdmin.manager_admin', compact('users'));
  }
  public function marketplaceManagerAdminEvents($id)
  {
    $posts = Marketplace::where('category_id', $id)->get();
    return view('SuperAdmin.dashboard.Marketplace.ManagerAdmin.manager_admin_events', compact('posts'));
  }
  public function marketplaceAdminList()
  {
    $users = User::where('user_type', 'admin')->latest()->get();
    return view('SuperAdmin.dashboard.Marketplace.Admin.admin', compact('users'));
  }
  public function marketplaceAdminEvents($id)
  {
    $posts = Marketplace::where('superstar_admin_id', $id)->get();
    return view('SuperAdmin.dashboard.Marketplace.Admin.admin_events', compact('posts'));
  }
  public function marketplaceSuperstarList()
  {
    $users = User::where('user_type', 'star')->latest()->get();
    return view('SuperAdmin.dashboard.Marketplace.Superstar.superstar', compact('users'));
  }
  public function marketplaceSuperstarEvents($id)
  {
    $posts = Marketplace::where('superstar_id', $id)->get();
    return view('SuperAdmin.dashboard.Marketplace.Superstar.superstar_events', compact('posts'));
  }
  // Souvenir

  public function souvenirEventsDashboard()
  {
    $categories = Category::get();
    $total = SouvenirCreate::count();
    $published = SouvenirCreate::where('status', 1)->count();
    $pending = SouvenirCreate::where('status', 0)->count();
    $rejected = SouvenirCreate::where('status', 2)->count();
    // Registered User

    $weeklyUser = SouvenirApply::distinct('user_id')->where('created_at', '>', Carbon::now()->startOfWeek())->where('created_at', '<', Carbon::now()->endOfWeek())->count();
    $monthlyUser = SouvenirApply::distinct('user_id')->where('created_at', '>', Carbon::now()->startOfMonth())->where('created_at', '<', Carbon::now()->endOfMonth())->count();
    $yearlyUser = SouvenirApply::distinct('user_id')->where('created_at', '>', Carbon::now()->startOfYear())->where('created_at', '<', Carbon::now()->endOfYear())->count();

    // Income Statement

    $weeklyIncome = SouvenirApply::where('created_at', '>', Carbon::now()->startOfWeek())->where('created_at', '<', Carbon::now()->endOfWeek())->sum('total_amount');
    $monthlyIncome = SouvenirApply::where('created_at', '>', Carbon::now()->startOfMonth())->where('created_at', '<', Carbon::now()->endOfMonth())->sum('total_amount');
    $yearlyIncome = SouvenirApply::where('created_at', '>', Carbon::now()->startOfYear())->where('created_at', '<', Carbon::now()->endOfYear())->sum('total_amount');

    $labels = SouvenirApply::get(['id', 'created_at', 'total_amount'])->groupBy(function ($date) {
      return Carbon::parse($date->created_at)->format('M');
    });

    $months = [];
    $amountCount = [];
    foreach ($labels as $month => $values) {
      $months[] = $month;
      $amountCount[] = $values->sum('total_amount');
    }

    return view('SuperAdmin.dashboard.Souvenir.dashboard', compact('categories', 'total', 'published', 'pending', 'rejected', 'weeklyUser', 'monthlyUser', 'yearlyUser', 'weeklyIncome', 'monthlyIncome', 'yearlyIncome'))->with('months', json_encode($months, JSON_NUMERIC_CHECK))->with('amountCount', json_encode($amountCount, JSON_NUMERIC_CHECK));
  }
  public function souvenirDataList($type)
  {
    if ($type == 'total') {
      $postList = SouvenirCreate::with(['star', 'category'])->get();
    } elseif ($type == 'published') {
      $postList = SouvenirCreate::with(['star', 'category'])->where('status', 1)->get();
    } elseif ($type == 'pending') {
      $postList = SouvenirCreate::with(['star', 'category'])->where('status', 0)->get();
    } else {
      $postList = SouvenirCreate::with(['star', 'category'])->where('status', 2)->get();
    }
    return view('SuperAdmin.dashboard.Souvenir.postDataList', compact('postList'));
  }
  public function souvenirManagerAdminList()
  {
    $users = User::where('user_type', 'manager-admin')->latest()->get();
    return view('SuperAdmin.dashboard.Souvenir.ManagerAdmin.manager_admin', compact('users'));
  }
  public function souvenirManagerAdminEvents($id)
  {
    $posts = SouvenirCreate::where('category_id', $id)->get();
    return view('SuperAdmin.dashboard.Souvenir.ManagerAdmin.manager_admin_events', compact('posts'));
  }
  public function souvenirAdminList()
  {
    $users = User::where('user_type', 'admin')->latest()->get();
    return view('SuperAdmin.dashboard.Souvenir.Admin.admin', compact('users'));
  }
  public function souvenirAdminEvents($id)
  {
    $posts = SouvenirCreate::where('admin_id', $id)->get();
    return view('SuperAdmin.dashboard.Souvenir.Admin.admin_events', compact('posts'));
  }
  public function souvenirSuperstarList()
  {
    $users = User::where('user_type', 'star')->latest()->get();
    return view('SuperAdmin.dashboard.Souvenir.Superstar.superstar', compact('users'));
  }
  public function souvenirSuperstarEvents($id)
  {
    $posts = SouvenirCreate::where('star_id', $id)->get();
    return view('SuperAdmin.dashboard.Souvenir.Superstar.superstar_events', compact('posts'));
  }
}
