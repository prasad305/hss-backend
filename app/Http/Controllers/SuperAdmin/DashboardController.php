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
use App\Models\GeneralPostPayment;
use App\Models\GreetingsRegistration;
use App\Models\MeetupEvent;
use App\Models\MeetupEventRegistration;
use App\Models\QnA;
use App\Models\QnaRegistration;
use App\Models\SimplePost;
use App\Models\Vaccination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

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

    return view('SuperAdmin.dashboard.index', $data);
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
    $data['completeGreetingCount'] = Greeting::whereDate('event_date', '>', Carbon::now())->count();
    $data['upcomingGreetingCount'] = Greeting::whereDate('event_date', '<', Carbon::now())->count();

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
    $labels = MeetupEventRegistration::get(['id', 'created_at', 'amount'])->groupBy(function ($date) {
      return Carbon::parse($date->created_at)->format('M');
    });

    $months = [];
    $amountCount = [];
    foreach ($labels as $month => $values) {
      $months[] = $month;
      $amountCount[] = $values->sum('amount');
    }

    return view('SuperAdmin.dashboard.Meetup.dashboard', compact('categories', 'total', 'published', 'pending', 'rejected'))->with('months', json_encode($months, JSON_NUMERIC_CHECK))->with('amountCount', json_encode($amountCount, JSON_NUMERIC_CHECK));
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

    $months = [];
    $amountCount = [];
    foreach ($labels as $month => $values) {
      $months[] = $month;
      $amountCount[] = $values->sum('amount');
    }

    return view('SuperAdmin.dashboard.LearningSession.dashboard', compact('categories', 'total', 'published', 'pending', 'rejected'))->with('months', json_encode($months, JSON_NUMERIC_CHECK))->with('amountCount', json_encode($amountCount, JSON_NUMERIC_CHECK));
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
    $labels = LiveChatRegistration::get(['id', 'created_at', 'amount'])->groupBy(function ($date) {
      return Carbon::parse($date->created_at)->format('M');
    });

    $months = [];
    $amountCount = [];
    foreach ($labels as $month => $values) {
      $months[] = $month;
      $amountCount[] = $values->sum('amount');
    }

    return view('SuperAdmin.dashboard.LiveChat.dashboard', compact('categories', 'total', 'published', 'pending', 'rejected'))->with('months', json_encode($months, JSON_NUMERIC_CHECK))->with('amountCount', json_encode($amountCount, JSON_NUMERIC_CHECK));
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
    $labels = GreetingsRegistration::get(['id', 'created_at', 'amount'])->groupBy(function ($date) {
      return Carbon::parse($date->created_at)->format('M');
    });

    $months = [];
    $amountCount = [];
    foreach ($labels as $month => $values) {
      $months[] = $month;
      $amountCount[] = $values->sum('amount');
    }

    return view('SuperAdmin.dashboard.Greeting.dashboard', compact('categories', 'total', 'published', 'pending', 'rejected'))->with('months', json_encode($months, JSON_NUMERIC_CHECK))->with('amountCount', json_encode($amountCount, JSON_NUMERIC_CHECK));
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
    return view('SuperAdmin.dashboard.FanGroup.dashboard');
  }
  public function fanGroupManagerAdminList()
  {
    return view('SuperAdmin.dashboard.FanGroup.ManagerAdmin.manager_admin');
  }
  public function fanGroupManagerAdminEvents()
  {
    return view('SuperAdmin.dashboard.FanGroup.ManagerAdmin.manager_admin_events');
  }
  public function fanGroupAdminList()
  {
    return view('SuperAdmin.dashboard.FanGroup.Admin.admin');
  }
  public function fanGroupAdminEvents()
  {
    return view('SuperAdmin.dashboard.FanGroup.Admin.admin_events');
  }
  public function fanGroupSuperstarList()
  {
    return view('SuperAdmin.dashboard.FanGroup.Superstar.superstar');
  }
  public function fanGroupSuperstarEvents()
  {
    return view('SuperAdmin.dashboard.FanGroup.Superstar.superstar_events');
  }


  // Dashboard Q&A

  public function qnaEventsDashboard()
  {
    $categories = Category::get();
    $total = QnA::count();
    $published = QnA::where('status', 2)->count();
    $pending = QnA::where('status', '<', 2)->count();
    $rejected = QnA::where('status', 11)->count();
    $labels = QnaRegistration::get(['id', 'created_at', 'amount'])->groupBy(function ($date) {
      return Carbon::parse($date->created_at)->format('M');
    });

    $months = [];
    $amountCount = [];
    foreach ($labels as $month => $values) {
      $months[] = $month;
      $amountCount[] = $values->sum('amount');
    }

    return view('SuperAdmin.dashboard.QnA.dashboard', compact('categories', 'total', 'published', 'pending', 'rejected'))->with('months', json_encode($months, JSON_NUMERIC_CHECK))->with('amountCount', json_encode($amountCount, JSON_NUMERIC_CHECK));
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
    $labels = GeneralPostPayment::get(['id', 'created_at', 'amount'])->groupBy(function ($date) {
      return Carbon::parse($date->created_at)->format('M');
    });

    $months = [];
    $amountCount = [];
    foreach ($labels as $month => $values) {
      $months[] = $month;
      $amountCount[] = $values->sum('amount');
    }

    return view('SuperAdmin.dashboard.SimplePost.dashboard', compact('categories', 'total', 'published', 'pending', 'rejected'))->with('months', json_encode($months, JSON_NUMERIC_CHECK))->with('amountCount', json_encode($amountCount, JSON_NUMERIC_CHECK));
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
}
