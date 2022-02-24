<?php

use App\Http\Controllers\API\AuctionController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\LiveChatController;
use App\Http\Controllers\API\StarAuthController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\SubCategoryController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\GreetingController;
use App\Http\Controllers\API\ScheduleController;
use App\Http\Controllers\API\MeetupEventController;
use App\Http\Controllers\API\SimplePostController;
use App\Http\Controllers\API\LearningSessionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout']);


Route::post('otp_verify', [AuthController::class, 'otp_verify']);
Route::post('verify_user', [AuthController::class, 'verify_user']);

Route::get('resend_otp', [AuthController::class, 'resend_otp']);
Route::get('reset_otp', [AuthController::class, 'reset_otp']);

// Change You
Route::get('/user/getAllLiveChatEventWith', [UserController::class, 'getAllLiveChatEventWith']);
Route::get('/user/getAllLearningSession', [UserController::class, 'getAllLearningSession']);


//Star Photo and videos
Route::get('/star_photos/{id}', [UserController::class, 'star_photo']);
Route::get('/star_videos/{id}', [UserController::class, 'star_video']);


Route::get('/user/getStarPost/{id}', [UserController::class, 'getStarPost']);

// Data Fetching For Landing Page Right Side Bar
Route::get('/user/learning_session/all', [LearningSessionController::class, 'user_all']);
Route::get('/user/live_chat/all', [LiveChatController::class, 'userAll']);


// Verified User Middleware
Route::middleware(['auth:sanctum', 'isAPIUser'])->group(function () {

    Route::get('/checkingAuthenticated', function () {
        return response()->json(['message' => 'You are in', 'status' => 200], 200);
    });

    Route::get('/user_info', [AuthController::class, 'user_info']);
    Route::post('/user_info_update', [AuthController::class, 'user_info_update']);
    Route::post('/user_otherInfo_update', [AuthController::class, 'user_OtherInfo_update']);



    Route::get('/user/getAllLiveChatEvent', [UserController::class, 'getAllLiveChatEvent']);



    Route::get('/user/registerMeestup', [UserController::class, 'registeredMeetup']);
    Route::get('/user/registerLivechat', [UserController::class, 'registeredLivechat']);

    Route::get('/user/sinlgeLiveChat/{id}', [UserController::class, 'sinlgeLiveChat']);
    Route::get('/user/getSingleLiveChatEvent/{id}', [UserController::class, 'getSingleLiveChatEvent']);
    Route::get('/user/getSingleLiveChatEvent/{minute}/{id}', [UserController::class, 'getLiveChatTiemSlot']);
    Route::post('/user/liveChatRigister/', [UserController::class, 'liveChatRigister']);

    //Route::get('view-category', [CategoryController::class, 'index']);
    //Route::get('view-category', [CategoryController::class, 'index']);

    Route::get('/user/registeredLivechat', [UserController::class, 'registeredLivechat']);

    Route::get('/user/interest/type', [UserController::class, 'interestType']);


    Route::get('/user/meetupEventList', [MeetupEventController::class, 'meetup_event_list']);
    Route::get('/user/meetup-event/{star_id}/{event_id}', [MeetupEventController::class, 'meetup_event_booking']);
    Route::post('/user/meetup-event/register', [MeetupEventController::class, 'meetup_register']);

    Route::get('/star_info/{star_id}', [UserController::class, 'star_info']);


    Route::get('/meetup_event_info/{id}', [MeetupEventController::class, 'event_info']);

    //greetings registation
    Route::post('/user/greetings_registaion', [UserController::class, 'greetingsRegistation']);

    //greetings registation update
    Route::post('/user/greetings_registaion_update', [UserController::class, 'greetingsRegistationUpdate']);

    //user greeting registatin status
    Route::get('/user/greetings_registaion_status', [UserController::class, 'greetingStatus']);

    //greetings Activety check
    Route::get('/user/greetings_star_status/{star_id}', [GreetingController::class, 'greetingsCreateStatus']);
    //greetings reg delete
    Route::get('/user/greetings_reg_delete/{id}', [GreetingController::class, 'greetingsRegDelete']);

    Route::get('/meetup_event_info/{id}', [MeetupEventController::class, 'event_info']);

    //check user notification
    Route::get('/user/check_notification', [UserController::class, 'checkUserNotifiaction']);
    Route::get('/learnig-session/{slug}', [UserController::class, 'singleLearnigSession']);
    //lerning session registaion
    Route::post('/learnig-session', [UserController::class, 'LearningSessionReg']);
});




// Approved Star Admin Middleware
Route::middleware(['auth:sanctum', 'isAPIAdmin'])->group(function () {

    Route::get('/checkingAdmin', function () {
        return response()->json(['message' => 'You are in as Admin', 'status' => 200], 200);
    });

    // Simple Post Section
    Route::post('admin/add_simple_post', [SimplePostController::class, 'add']);
    Route::get('/admin/simple_post/all', [SimplePostController::class, 'all']);
    Route::get('/admin/simple_post/count', [SimplePostController::class, 'count']);
    Route::get('/admin/simple_post/pending', [SimplePostController::class, 'pending_list']);
    Route::get('/admin/simple_post/pending/{id}', [SimplePostController::class, 'pending_details']);
    Route::get('/admin/simple_post/approved', [SimplePostController::class, 'approved_list']);

    // Learning Session Section
    Route::post('admin/add_learning_session', [LearningSessionController::class, 'add']);
    Route::get('/admin/learning_session/all', [LearningSessionController::class, 'all']);
    Route::get('/admin/learning_session/count', [LearningSessionController::class, 'count']);
    Route::get('/admin/learning_session/pending', [LearningSessionController::class, 'pending_list']);
    Route::get('/admin/learning_session/pending/{id}', [LearningSessionController::class, 'pending_details']);
    Route::get('/admin/learning_session/approved', [LearningSessionController::class, 'approved_list']);

    // Live Session Section
    Route::post('admin/add_live_session', [LiveChatController::class, 'add_live_session']);
    Route::get('/admin/livechat', [LiveChatController::class, 'admin_livechat']);
    Route::get('/admin/sinlgeLiveChat/{id}', [LiveChatController::class, 'admin_sinlgeLiveChat']);
    Route::get('/admin/livechatListByDate/{date}', [LiveChatController::class, 'admin_livechatListByDate']);
    Route::get('/admin/registeredUserList/{live_chat_id}', [LiveChatController::class, 'admin_registeredUserList']);


    Route::get('admin/star_list', [CategoryController::class, 'star_list']);
    Route::get('admin/agreement_paper/{star_id}', [CategoryController::class, 'agreement_paper']);


    Route::post('admin/add_greetings', [GreetingController::class, 'add']);
    Route::get('admin/greeting/{id}', [GreetingController::class, 'show']);


    Route::get('admin/greeting/check_status', [LiveChatController::class, 'greetingsCreateStatus']);


    Route::post('/admin/add_meetup', [MeetupEventController::class, 'add']);
    Route::get('/admin/meetup_event/pending', [MeetupEventController::class, 'pending_list']);
    Route::get('/admin/meetup_event/approved', [MeetupEventController::class, 'approved_list']);
    Route::get('/admin/meetup_event_details/{id}', [MeetupEventController::class, 'details']);
    Route::get('/admin/meetup_event_slots/{id}', [MeetupEventController::class, 'slots']);

    Route::post('/admin/add_livechat_profile', [LiveChatController::class, 'profile_create']);
    Route::get('/admin/livechat_event_profile', [LiveChatController::class, 'profile']);
    Route::post('/admin/add_live_chat', [LiveChatController::class, 'add']);
    Route::get('/admin/live_chat/pending', [LiveChatController::class, 'pending_list']);
    Route::get('/admin/live_chat/approved', [LiveChatController::class, 'approved_list']);
    Route::get('/admin/livechat_event_details/{id}', [LiveChatController::class, 'details']);
    Route::get('/admin/live_chat_slots/{id}', [LiveChatController::class, 'slots']);
    Route::get('/admin/live_chat/count', [LiveChatController::class, 'count']);


    Route::post('/admin/add_schedule', [ScheduleController::class, 'add_schedule']);
    Route::get('/admin/schedule', [ScheduleController::class, 'selected_schedule']);
    Route::get('/admin/schedule_list', [ScheduleController::class, 'schedule_list']);

    //greetings Activety check
    Route::get('/admin/greetings_star_status', [GreetingController::class, 'greetingsCreateStatusAdmin']);
    //user greetings register list
    Route::get('/admin/greetings_register_list/{greetings_id}', [GreetingController::class, 'greetingsRegisterListByGreetingsId']);

    //Sent Notification to user
    Route::post('/admin/sent_notofiaction_user', [GreetingController::class, 'sentNotificationToUser']);
});



// Approved Superstar Middleware
Route::middleware(['auth:sanctum', 'isAPIStar'])->group(function () {
    Route::get('/checkingSuperStar', function () {
        return response()->json(['message' => 'You are in as Superstar', 'status' => 200], 200);
    });

    Route::get('/livechat', [LiveChatController::class, 'livechat']);
    Route::get('/sinlgeLiveChat/{id}', [LiveChatController::class, 'sinlgeLiveChat']);


    // Simple Post Section
    Route::post('/star/add_simple_post', [SimplePostController::class, 'star_add']);
    Route::get('/star/simple_post/all', [SimplePostController::class, 'star_all']);
    Route::get('/star/simple_post/count', [SimplePostController::class, 'star_count']);
    Route::get('/star/simple_post/pending', [SimplePostController::class, 'star_pending_list']);
    Route::get('/star/simple_post/pending/{id}', [SimplePostController::class, 'star_pending_details']);
    Route::get('/star/simple_post/approved', [SimplePostController::class, 'star_approved_list']);
    Route::get('/star/approve_post/{id}', [SimplePostController::class, 'approve_post']);

    // Learning Session Section
    Route::post('/star/add_learning_session', [LearningSessionController::class, 'add']);
    Route::get('/star/learning_session/all', [LearningSessionController::class, 'star_all']);
    Route::get('/star/learning_session/count', [LearningSessionController::class, 'star_count']);
    Route::get('/star/learning_session/pending', [LearningSessionController::class, 'star_pending_list']);
    Route::get('/star/learning_session/pending/{id}', [LearningSessionController::class, 'star_pending_details']);
    Route::get('/star/learning_session/approved', [LearningSessionController::class, 'star_approved_list']);
    Route::get('/star/approve_learning_session/{id}', [LearningSessionController::class, 'approve_post']);


    Route::get('/star/pendingLiveChat', [LiveChatController::class, 'pendingLiveChat']);
    Route::get('/star/approvedLiveChat', [LiveChatController::class, 'approveLiveChat']);
    Route::get('/star/approveLiveChat/{id}', [LiveChatController::class, 'setApproveLiveChat']);
    Route::get('/star/livechat_event_details/{id}', [LiveChatController::class, 'details']);

    Route::get('/deleteLiveChat/{id}', [LiveChatController::class, 'deleteLiveChat']);
    Route::get('/livechatListByDate/{date}', [LiveChatController::class, 'livechatListByDate']);
    Route::get('/registeredUserList/{live_chat_id}', [LiveChatController::class, 'registeredUserList']);

    Route::post('/star/add_live_session', [LiveChatController::class, 'add_live_session']);
    Route::post('/star/update_live_session', [LiveChatController::class, 'update_live_session']);

    Route::get('/star/greetings', [GreetingController::class, 'view_star_greeting']);
    Route::get('/admin/greeting_approve', [GreetingController::class, 'greetingsApprovedByStar']);

    Route::get('/star/meetup_event/pending', [MeetupEventController::class, 'star_pending_list']);
    Route::get('/star/meetup_event/approved', [MeetupEventController::class, 'star_approved_list']);
    Route::get('/star/meetup_event_details/{id}', [MeetupEventController::class, 'details']);


    Route::get('/star/meetup_event/set_approve/{id}', [MeetupEventController::class, 'set_approve']);


    Route::get('/admin/greeting_approve', [GreetingController::class, 'greetingsApprovedByStar']);

    Route::get('/star/live_chat/count', [LiveChatController::class, 'count2']);

    //user greetings register list
    Route::get('/star/greetings_reg_list/{greetings_id}', [GreetingController::class, 'greetingsRegisterListByGreetingsId']);

    Route::get('/star/greetings_reg_payment_list/{greetings_id}', [GreetingController::class, 'greetingsRegisterWithPaymentList']);
});






Route::get('account_info', [AuthController::class, 'account_info']);


Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



// Route for Star Panel
Route::post('superStar/register', [StarAuthController::class, 'superStar_register']);
Route::post('star_login', [StarAuthController::class, 'login']);
Route::post('star_otp_verify', [StarAuthController::class, 'otp_verify']);
Route::post('star_qr_verify', [StarAuthController::class, 'qr_verify']);

Route::post('star_register', [StarAuthController::class, 'register']);

Route::get('view-category', [CategoryController::class, 'index']);
Route::get('subcategory/{slug}', [SubCategoryController::class, 'index']);


Route::post('select_category', [CategoryController::class, 'select_category']);
Route::get('fetch-subcategory/{id}', [CategoryController::class, 'fetch_subcategory']);


Route::post('select_sub_category', [SubCategoryController::class, 'select_sub_category']);
Route::get('fetch-star/{id}', [SubCategoryController::class, 'fetch_subcategory']);
Route::post('select_star', [SubCategoryController::class, 'select_star']);
Route::get('submit_react/{id}', [UserController::class, 'submit_react']);
Route::get('check_react/{id}', [UserController::class, 'check_react']);
Route::get('checkchoice', [CategoryController::class, 'check']);

//<======================== Auction Route ========================>

Route::post('/add/auction/product',[AuctionController::class,'addProduct']);
Route::get('/show/auction/product',[AuctionController::class,'showProduct']);
Route::get('/total/auction/product',[AuctionController::class,'totalProduct']);
Route::get('/sold/auction/product',[AuctionController::class,'soldProduct']);
Route::get('/unSold/auction/product',[AuctionController::class,'unSoldProduct']);
