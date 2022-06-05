<?php

use App\Http\Controllers\API\AuctionController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\LiveChatController;
use App\Http\Controllers\API\StarAuthController;
use App\Http\Controllers\API\Audition\Jury\JuryAuthController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\SubCategoryController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\GreetingController;
use App\Http\Controllers\API\MarketplaceController;
use App\Http\Controllers\API\ScheduleController;
use App\Http\Controllers\API\MeetupEventController;
use App\Http\Controllers\API\SimplePostController;
use App\Http\Controllers\API\FanGroupController;
use App\Http\Controllers\API\LearningSessionController;
use App\Http\Controllers\API\Audition\Admin\AuditionController;
use App\Http\Controllers\API\Audition\Jury\JuryAuditionController;
use App\Http\Controllers\API\Audition\Judge\JudgeAuditionController;
use App\Http\Controllers\API\PromoVideoController;
use App\Http\Controllers\API\StarGreetingController;
use App\Http\Controllers\API\StarScheduleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Authentication API
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout']);

// OTP Verification API
Route::post('otp_verify', [AuthController::class, 'otp_verify']);
Route::post('verify_user', [AuthController::class, 'verify_user']);
Route::post('verify_to_register_event', [AuthController::class, 'VerifyToRegisterEvent']);
Route::get('resend_otp', [AuthController::class, 'resend_otp']);
Route::get('reset_otp', [AuthController::class, 'reset_otp']);

// Home Page All Post
Route::get('/user/all_post', [UserController::class, 'all_post']);
Route::get('/user/post/{type}', [UserController::class, 'single_type_post']);


Route::get('/user/getAllLearningSession', [UserController::class, 'getAllLearningSession']);

//Star Photo and videos
Route::get('/star_photos/{id}', [UserController::class, 'star_photo']);
Route::get('/star_videos/{id}', [UserController::class, 'star_video']);
Route::get('/user/getStarPost/{id}', [UserController::class, 'getStarPost']);

// Data Fetching For Landing Page Right Side Bar
Route::get('/user/learning_session/all', [LearningSessionController::class, 'user_all']);
Route::get('/user/live_chat/all', [LiveChatController::class, 'userAll']);


Route::get('/user_info/{id}', [AuthController::class, 'user_data']);
Route::post('/chatting/message', [UserController::class, 'message']);
Route::get('/chatting/message/{id}', [UserController::class, 'get_message']);
Route::post('/group/message', [UserController::class, 'group_message']);
Route::get('/group/message/{id}', [UserController::class, 'get_group_message']);


// Registered & Verified User Middleware
Route::middleware(['auth:sanctum', 'isAPIUser'])->group(function () {

    Route::get('/checkingAuthenticated', function () {
        return response()->json(['message' => 'You are in', 'status' => 200], 200);
    });

    Route::get('/user_info', [AuthController::class, 'user_info']);
    Route::post('/user_info_update', [AuthController::class, 'user_info_update']);
    Route::post('/user_otherInfo_update', [AuthController::class, 'user_OtherInfo_update']);
    Route::get('/user_data/{id}', [AuthController::class, 'user_data']);

    Route::get('/user/total_notification_count', [UserController::class, 'total_notification_count']);

    Route::get('/user/activity_count', [AuthController::class, 'activity_count']);

    Route::get('/user/getAllLiveChatEvent', [UserController::class, 'getAllLiveChatEvent']);
    Route::get('/user/getAllLiveChatEventByStar/{id}', [UserController::class, 'getAllLiveChatEventByStar']);
    Route::get('/user/getAllPostWithForSingleStar/{star_id}', [UserController::class, 'getAllPostWithForSingleStar']);
    Route::get('/user/registerMeestup', [UserController::class, 'registeredMeetup']);
    Route::get('/user/registerLivechat', [UserController::class, 'registeredLivechat']);
    Route::get('/user/registerLearningSession', [UserController::class, 'registeredLearningSession']);


    Route::get('/user/sinlgeLiveChat/{id}', [UserController::class, 'sinlgeLiveChat']);
    Route::get('/user/getSingleLiveChatEvent/{id}', [UserController::class, 'getSingleLiveChatEvent']);
    Route::get('/user/getSingleLiveChatEvent/{minute}/{id}', [UserController::class, 'getLiveChatTiemSlot']);

    //live chat
    Route::get('/user/live-chat/{slug}', [UserController::class, 'liveChatDetails']);

    //Meetup Event
    Route::get('/user/meetup/{slug}', [UserController::class, 'meetupDetails']);


    Route::get('view-country', [CategoryController::class, 'index']);
    Route::get('subcategory/{slug}', [SubCategoryController::class, 'index']);
    Route::get('/user/registeredLivechat', [UserController::class, 'registeredLivechat']);

    Route::get('/user/interest/type', [UserController::class, 'interestType']);

    // Marketplace Section
    Route::get('/user/marketplace/all', [MarketplaceController::class, 'marketplaceAll']);
    Route::get('/user/marketplace/view-country', [MarketplaceController::class, 'viewCountry']);
    Route::get('/user/marketplace/state/{id}', [MarketplaceController::class, 'viewState']);
    Route::get('/user/marketplace/city/{id}', [MarketplaceController::class, 'viewCity']);
    Route::get('/user/marketplace/details/{slug}', [MarketplaceController::class, 'getSlugDetails']);
    Route::post('/user/marketplace/order/store', [MarketplaceController::class, 'viewMarketplaceOrder']);
    Route::get('/user/marketplace/activities', [MarketplaceController::class, 'viewMarketplaceActivities']);

    // Fan Group Section
    Route::get('user/fan/group/list', [FanGroupController::class, 'getFanGroupList']);
    Route::get('user/fan/group/{slug}', [FanGroupController::class, 'getFanGroupDetails']);
    Route::post('user/fan/group/store', [FanGroupController::class, 'getFanGroupStore']);
    Route::get('user/fan/group/join/{join_id}', [FanGroupController::class, 'getFanGroupJoinId']);
    Route::post('/user/fan/group/post/store', [FanGroupController::class, 'getFanPostStore']);
    Route::get('/user/fan/group/post/show/{slug}', [FanGroupController::class, 'getFanPostShow']);


    Route::get('/user/meetupEventList', [MeetupEventController::class, 'meetup_event_list']);
    Route::get('/user/meetup-event/{star_id}/{event_id}', [MeetupEventController::class, 'meetup_event_booking']);


    Route::get('/star_info/{star_id}', [UserController::class, 'star_info']);

    Route::get('/meetup_event_info/{id}', [MeetupEventController::class, 'event_info']);


    //greetings registation update
    Route::get('/user/greeting-info-to_registration/{greeting_id}', [UserController::class, 'greetingInfoToRegistration']);
    Route::post('/user/greetings_registaion_update', [UserController::class, 'greetingsRegistationUpdate']);

    //user greeting registatin status
    Route::get('/user/greetings_registaion_status/{star_id}', [UserController::class, 'greetingStatus']);

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

    // auction product
    Route::get('/auction-product/all', [UserController::class, 'auctionProduct']);
    Route::get('/auction-product/{id}', [UserController::class, 'auctionSingleProduct']);
    Route::get('/user/getStarAuction/{star_id}', [UserController::class, 'starAuction']);
    // Auction
    Route::get('/user/getStarAuctionProduct/{product_id}', [UserController::class, 'starAuctionProduct']);
    Route::post('user/bidding/auction/product', [UserController::class, 'bidNow']);
    Route::get('user/liveBidding/auction/{auction_id}', [UserController::class, 'liveBidding']);
    Route::get('user/auctionApply/auction/{auction_id}', [UserController::class, 'auctionApply']);
    Route::get('user/liveBidding/history/{auction_id}', [UserController::class, 'bidHistory']);
    Route::post('user/aquired/auction', [UserController::class, 'aquiredProduct']);
    Route::get('user/maxbid/auction/{id}', [UserController::class, 'maxBid']);

    //Event Registaion By User (Learning Session + Live Chat + Greeting + Meetup Event)
    Route::post('/user/learning_session/register', [UserController::class, 'LearningSessionRegistration']);
    Route::post('/user/learning-session/video-upload', [UserController::class, 'uploadLearningSessionVideo']);

    //use this api on react project file path- \src\components\Pages\Profile\profile-components\starProfile\StarChat
    Route::post('/user/liveChat/register', [UserController::class, 'liveChatRigister']);

    Route::post('/user/greetings/register', [UserController::class, 'greetingsRegistation']);
    Route::post('/user/meetup-event/register', [MeetupEventController::class, 'meetup_register']);


    // Audition
    Route::get('/user/audition/all', [UserController::class, 'audition_list']);
    Route::get('/user/audition/participate/{id}', [UserController::class, 'participateAudition']);
    Route::post('/user/register/participate', [UserController::class, 'participantRegister']);
    Route::post('/user/payment/participate', [UserController::class, 'auditionPayment']);
    Route::post('/user/video/participate', [UserController::class, 'videoUpload']);
    Route::get('/user/audition/participate/video/{id}', [UserController::class, 'videoDetails']);
    Route::get('/user/audition/enrolled', [UserController::class, 'enrolledAuditions']);
    Route::get('/user/pendingEnrollAudition', [UserController::class, 'enrolledAuditionsPending']);
    Route::get('/user/audition/details/{slug}', [UserController::class, 'UserAuditionDetails']);
    Route::get('/user/audition/round-instruction/{round_id}', [UserController::class, 'roundInstruction']);
    Route::get('/user/registration_checker/audition/{slug}', [UserController::class, 'UserAuditionRegistrationChecker']);
    Route::post('/user/audition/round-video-upload', [UserController::class, 'userRoundVideoUpload']);
    // Route::post('user/audition/videos/{audition_id}', [UserController::class, 'checkAuditionVideoUpload']);

    // Promo Videos
    Route::get('/user/PromoVideos', [UserController::class, 'getPromoVideo']);

    // User Profile
    Route::post('/user/coverUpdate/{id}', [UserController::class, 'updateCover']);
    Route::post('/user/profileUpdate/{id}', [UserController::class, 'updateProfile']);

    // User Photos
    Route::get('/user/activitiesData', [UserController::class, 'userActivites']);

    //Registration Checker
    Route::get('/user/registration_checker/{type}/{slug}', [UserController::class, 'registration_checker']);
});




// Approved Star Admin Middleware
Route::middleware(['auth:sanctum', 'isAPIAdmin'])->group(function () {

    Route::get('/checkingAdmin', function () {
        return response()->json(['message' => 'You are in as Admin', 'status' => 200], 200);
    });

    Route::get('admin/star_list', [CategoryController::class, 'star_list']);
    Route::get('admin/agreement_paper/{star_id}', [CategoryController::class, 'agreement_paper']);



    // Fan Group Section
    Route::post('admin/fan-group/store', [FanGroupController::class, 'fanGroupStore']);
    Route::get('/admin/fan-group/star/list', [FanGroupController::class, 'allStarList']);
    Route::get('/admin/fan-group/star/list/{data}', [FanGroupController::class, 'someStarList']);
    Route::get('/admin/fan/group/adminlist/status', [FanGroupController::class, 'statusAdminStar']);
    Route::get('/admin/fan/group/show/{slug}', [FanGroupController::class, 'showFanGroup']);
    Route::post('/admin/fan/group/update/{slug}', [FanGroupController::class, 'updateFanGroup']);
    Route::delete('/admin/fan/group/delete/{slug}', [FanGroupController::class, 'deleteFanGroup']);
    Route::post('/admin/fan/member/approve/{id}', [FanGroupController::class, 'approveFanMember']);
    Route::post('/admin/fan/member/post/{id}', [FanGroupController::class, 'approveFanPost']);

    Route::post('/admin/fan-group/join/{slug}/{data}', [FanGroupController::class, 'joinFanGroup']);
    Route::post('/admin/fan-group/post/{slug}/{data}', [FanGroupController::class, 'postFanGroup']);
    Route::post('/admin/fan/group/image/update/{slug}', [FanGroupController::class, 'updateImageFanGroup']);
    Route::get('/admin/fan/group/settings/delete/{id}', [FanGroupController::class, 'deleteSettingsFan']);
    Route::post('/admin/fan/group/settings/no-warning/{id}', [FanGroupController::class, 'noWarningSettingsFan']);
    Route::post('/admin/fan/group/approval/warning/{id}/{fanid}', [FanGroupController::class, 'warningSettingsFan']);

    // Marketplace Section
    Route::post('admin/marketplace/store', [MarketplaceController::class, 'marketplaceStore']);
    Route::get('/admin/marketplace/product-list/approved', [MarketplaceController::class, 'allProductList']);
    Route::get('/admin/marketplace/product-list/pending', [MarketplaceController::class, 'pendingProductList']);
    Route::get('/admin/marketplace/product-list/live', [MarketplaceController::class, 'liveProductList']);
    Route::get('/admin/marketplace/product-edit/{id}', [MarketplaceController::class, 'editAdminProductList']);
    Route::post('/admin/marketplace/product-store/{id}', [MarketplaceController::class, 'storeAdminProductList']);
    Route::get('/admin/marketplace/order/product-list', [MarketplaceController::class, 'orderAdminProductList']);

    // Simple Post Section
    Route::post('admin/add_simple_post', [SimplePostController::class, 'add']);
    Route::get('/admin/simple_post/all', [SimplePostController::class, 'all']);
    Route::get('/admin/simple_post/count', [SimplePostController::class, 'count']);
    Route::get('/admin/simple_post/pending', [SimplePostController::class, 'pending_list']);
    Route::get('/admin/simple_post/pending/{id}', [SimplePostController::class, 'pending_details']);
    Route::get('/admin/simple_post/approved', [SimplePostController::class, 'approved_list']);

    // Learning Session Section
    // Route::post('admin/add_learning_session', [LearningSessionController::class, 'add']);

    Route::post('admin/learning_session/create', [SimplePostController::class, 'add_learning']);

    // Route::post('admin/learning_session/create', [LearningSessionController::class, 'add_learning']);
    Route::get('/admin/learning_session/all', [LearningSessionController::class, 'all']);
    Route::get('/admin/learning_session/count', [LearningSessionController::class, 'count']);
    Route::get('/admin/learning_session/pending', [LearningSessionController::class, 'pending_list']);
    Route::get('/admin/learning_session/live', [LearningSessionController::class, 'live_list']);
    Route::get('/admin/learning_session/evaluation', [LearningSessionController::class, 'evaluation_list']);
    Route::get('/admin/learning_session/completed', [LearningSessionController::class, 'completed_list']);
    Route::get('/admin/learning_session/details/{slug}', [LearningSessionController::class, 'details']);
    Route::get('/admin/learning_session/registered_user/{slug}', [LearningSessionController::class, 'registured_user']);
    Route::get('/admin/learning_session/pending/{slug}', [LearningSessionController::class, 'pending_details']);
    Route::get('/admin/learning_session/approved', [LearningSessionController::class, 'approved_list']);
    Route::get('/admin/learning_session/assignment/{id}', [LearningSessionController::class, 'assignment_details']);
    Route::post('/admin/learning_session/add_assignment_rules', [LearningSessionController::class, 'assignment_rule_add']);
    Route::post('admin/learning_session/assignment/approval/{type}/{id}', [LearningSessionController::class, 'assignment_set_approval']);
    Route::post('admin/learning_session/assignment/approval/withMark/{type}/{id}', [LearningSessionController::class, 'assignment_set_approval_with_mark']);
    Route::get('admin/learning_session/assignment/send_to_manager/{slug}', [LearningSessionController::class, 'assignment_send_to_manager']);
    Route::get('admin/learning_session/assignment/send_to_star/{id}', [LearningSessionController::class, 'assignment_send_to_star']);
    Route::get('/admin/learning_session/assignment/marks/{slug}', [LearningSessionController::class, 'admin_assignment_marks']);
    Route::get('/admin/learning_session/setComplete/{id}', [LearningSessionController::class, 'admin_assignment_set_complete']);
    Route::get('/admin/learning_session/setAssignment/{id}', [LearningSessionController::class, 'admin_assignment_set_assignment']);


    // Live Session Section
    Route::post('admin/add_live_session', [LiveChatController::class, 'add_live_session']);
    Route::get('/admin/livechat', [LiveChatController::class, 'admin_livechat']);
    Route::get('/admin/sinlgeLiveChat/{id}', [LiveChatController::class, 'admin_sinlgeLiveChat']);
    Route::get('/admin/livechatListByDate/{date}', [LiveChatController::class, 'admin_livechatListByDate']);
    Route::get('/admin/registeredUserList/{live_chat_id}', [LiveChatController::class, 'admin_registeredUserList']);


    //Meetup Session Section
    Route::post('/admin/add_meetup', [MeetupEventController::class, 'add']);
    Route::get('/admin/meetup_event/pending', [MeetupEventController::class, 'pending_list']);
    Route::get('/admin/meetup_event/live', [MeetupEventController::class, 'live_list']);
    Route::get('/admin/meetup_event/completed', [MeetupEventController::class, 'completed']);
    Route::get('/admin/meetup_event/details/{slug}', [MeetupEventController::class, 'details']);
    Route::get('/admin/meetup_event_slots/{slug}', [MeetupEventController::class, 'slots']);


    Route::post('/admin/add_livechat_profile', [LiveChatController::class, 'profile_create']);
    Route::get('/admin/livechat_event_profile', [LiveChatController::class, 'profile']);
    Route::post('/admin/add_live_chat', [LiveChatController::class, 'add']);
    Route::get('/admin/live_chat/pending', [LiveChatController::class, 'pending_list']);
    Route::get('/admin/live_chat/live', [LiveChatController::class, 'live_list']);
    Route::get('/admin/live_chat/completed', [LiveChatController::class, 'completed_list']);
    Route::get('/admin/livechat_event_details/{slug}', [LiveChatController::class, 'details']);
    Route::get('/admin/live-chat/registered_user_list/{slug}', [LiveChatController::class, 'slots']);
    Route::get('/admin/live_chat/count', [LiveChatController::class, 'count']);



    Route::post('/admin/add_schedule/', [ScheduleController::class, 'add_schedule']);

    Route::get('/admin/schedule', [ScheduleController::class, 'selected_schedule']);

    Route::get('admin/schedule/notification', [ScheduleController::class, 'notification']);

    Route::get('admin/schedule/{date}', [ScheduleController::class, 'dateWiseSchedule']);

    Route::get('/admin/schedule_list', [ScheduleController::class, 'schedule_list']);
    Route::get('/admin/current_year_schedule_list', [ScheduleController::class, 'current_year_schedule_list']);

    //greetings Activety check
    Route::post('admin/add_greetings', [GreetingController::class, 'add']);
    Route::post('admin/edit_greetings', [GreetingController::class, 'edit_greetings']);
    Route::get('/admin/greetings_star_status', [GreetingController::class, 'greetingsCreateStatusAdmin']);
    Route::get('/admin/greetings_register_list', [GreetingController::class, 'greetingsRegisterListByGreetingsId']);
    Route::get('/admin/greetings_register_list_with_payment_complete', [GreetingController::class, 'adminGreetingsRegisterListWithPaymentComplete']);
    Route::get('/admin/greetings_video_uploaded_list', [GreetingController::class, 'greetingsVideoUploadedList']);
    Route::get('/admin/greetings_forwarded_to_user_list', [GreetingController::class, 'greetingsForwardedToUserList']);
    Route::get('/admin/greeting_approve', [GreetingController::class, 'greetingsApprovedByStar']);
    Route::get('admin/greeting/{id}', [GreetingController::class, 'show']);
    Route::get('admin/greeting/forwardToManagerAdmin/{id}', [GreetingController::class, 'forwardToManagerAdmin']);
    // Route::get('admin/greeting/check_status', [GreetingController::class, 'greetingsCreateStatus']);
    Route::post('admin/greeting/forward_to_user', [GreetingController::class, 'forwardToUser']);

    //Sent Notification to user
    Route::post('/admin/sent_notofiaction_user', [GreetingController::class, 'sentNotificationToUser']);

    //<======================== Auction Route ========================>

    Route::post('/admin/add/auction/product', [AuctionController::class, 'addProduct']);
    Route::get('/admin/editOrConfirm/auction/editOrConfirm', [AuctionController::class, 'editOrConfirm']);
    Route::get('/admin/edit/auction/{id}', [AuctionController::class, 'editProduct']);
    Route::post('/admin/update/auction/{id}', [AuctionController::class, 'updateProduct']);
    Route::get('/admin/all/auction/product', [AuctionController::class, 'allProduct']);
    Route::get('/admin/show/auction/product/{id}', [AuctionController::class, 'showProductDetails']);
    Route::get('/admin/total/auction/product', [AuctionController::class, 'totalProduct']);
    Route::get('/admin/pending/auction/product', [AuctionController::class, 'pendingProduct']);
    Route::get('/admin/sold/auction/product', [AuctionController::class, 'soldProduct']);
    Route::get('/admin/unSold/auction/product', [AuctionController::class, 'unSoldProduct']);
    Route::get('/admin/live/allProduct', [AuctionController::class, 'allLiveProduct']);
    Route::get('/admin/liveBidding/auction/{auction_id}', [AuctionController::class, 'liveBidding']);
    Route::get('/admin/topBidder/auction/{auction_id}', [AuctionController::class, 'topBidder']);
    Route::get('/admin/topBidder/auction/notify/{id}', [AuctionController::class, 'notify_bidder']);
    Route::get('/admin/allBidderList/auction/{id}', [AuctionController::class, 'allBidderList']);

    // audition routes
    //Route::get('/admin/audition/status', [AuditionController::class, 'starAdminPendingAudtion']);
    Route::get('/admin/audition/pendings', [AuditionController::class, 'starAdminPendingAudition']);
    Route::get('/admin/audition/live', [AuditionController::class, 'starAdminLiveAudition']);
    Route::get('/admin/audition/details/{id}', [AuditionController::class, 'starAdminDetailsAudition']);


    // Promo Videos
    Route::get('/admin/promoVideo/all', [PromoVideoController::class, 'adminAllPromoVideos']);
    Route::post('/admin/promoVideo/store', [PromoVideoController::class, 'videoStore']);
    Route::get('/admin/promoVideo/pending', [PromoVideoController::class, 'pendingVideos']);
    Route::get('/admin/promoVideo/live', [PromoVideoController::class, 'liveVideos']);
    Route::get('/admin/promoVideo/count', [PromoVideoController::class, 'promoVideoCount']);
    //Category
    Route::get('/admin/view-category', [CategoryController::class, 'index']);
});



// Approved Superstar Middleware
Route::middleware(['auth:sanctum', 'isAPIStar'])->group(function () {
    Route::get('/checkingSuperStar', function () {
        return response()->json(['message' => 'You are in as Superstar', 'status' => 200], 200);
    });

    Route::get('/livechat', [LiveChatController::class, 'livechat']);
    Route::get('/sinlgeLiveChat/{id}', [LiveChatController::class, 'sinlgeLiveChat']);

    // schdedule
    Route::post('/star/add_schedule/', [StarScheduleController::class, 'add_schedule']);

    Route::get('/star/schedule', [StarScheduleController::class, 'selected_schedule']);
    Route::get('/star/schedule/{date}', [StarScheduleController::class, 'dateWiseSchedule']);
    Route::get('/star/schedule_list', [StarScheduleController::class, 'schedule_list']);
    Route::get('/star/current_week_schedule_list', [StarScheduleController::class, 'current_week_schedule_list']);
    Route::get('/star/schedule/notification', [StarScheduleController::class, 'notification']);

    // Fan Group Section
    Route::get('star/fan/group/starlist/status', [FanGroupController::class, 'statusStar']);
    Route::post('star/fan/group/update/{slug}', [FanGroupController::class, 'starUpdate']);
    Route::get('star/fan/group/details/{slug}', [FanGroupController::class, 'fanGroupDetails']);
    Route::get('star/fan/group/active/{slug}/{id}', [FanGroupController::class, 'fanGroupActive']);
    Route::get('star/fan/group/ignore/{slug}/{id}', [FanGroupController::class, 'fanGroupIgnore']);
    Route::get('/star/fan/group/show/{slug}', [FanGroupController::class, 'showStarFanGroup']);
    Route::post('/star/fan/member/approve/{id}', [FanGroupController::class, 'approveFanMember']);
    Route::post('/star/fan/member/post/{id}', [FanGroupController::class, 'approveFanPost']);

    Route::post('/star/fan-group/join/{slug}/{data}', [FanGroupController::class, 'joinFanGroup']);
    Route::post('/star/fan-group/post/{slug}/{data}', [FanGroupController::class, 'postFanGroup']);
    Route::post('/star/fan/group/image/update/{slug}', [FanGroupController::class, 'updateImageFanGroup']);
    Route::get('/star/fan/group/settings/delete/{id}', [FanGroupController::class, 'deleteSettingsFan']);
    Route::post('/star/fan/group/settings/no-warning/{id}', [FanGroupController::class, 'noWarningSettingsFan']);
    Route::post('/star/fan/group/approval/warning/{id}/{fanid}', [FanGroupController::class, 'warningSettingsFan']);

    // Marketplace Section
    Route::post('star/marketplace/store', [MarketplaceController::class, 'starMarketplaceStore']);
    Route::get('/star/marketplace/product-list/approved', [MarketplaceController::class, 'allStarProductList']);
    Route::get('/star/marketplace/product-list/pending', [MarketplaceController::class, 'pendingStarProductList']);
    Route::get('/star/marketplace/product-list/live', [MarketplaceController::class, 'liveStarProductList']);
    Route::get('/star/marketplace/product-edit/{id}', [MarketplaceController::class, 'editStarProductList']);
    Route::post('/star/marketplace/product-store/{id}', [MarketplaceController::class, 'storeStarProductList']);
    Route::get('/star/marketplace/product-approved/{id}', [MarketplaceController::class, 'approvedStarProductList']);
    Route::get('/star/marketplace/product-decline/{id}', [MarketplaceController::class, 'declineStarProductList']);


    // Simple Post Section
    Route::post('/star/add_simple_post', [SimplePostController::class, 'star_add']);
    Route::get('/star/simple_post/all', [SimplePostController::class, 'star_all']);
    Route::get('/star/simple_post/count', [SimplePostController::class, 'star_count']);
    Route::get('/star/simple_post/pending', [SimplePostController::class, 'star_pending_list']);
    Route::get('/star/simple_post/pending/{id}', [SimplePostController::class, 'star_pending_details']);
    Route::get('/star/simple_post/approved', [SimplePostController::class, 'star_approved_list']);
    Route::get('/star/approve_post/{id}', [SimplePostController::class, 'approve_post']);
    Route::get('/star/decline_post/{id}', [SimplePostController::class, 'decline_post']);

    // Learning Session Section
    Route::post('/star/add_learning_session', [LearningSessionController::class, 'star_add']);
    Route::get('/star/learning_session/all', [LearningSessionController::class, 'star_all']);
    Route::get('/star/learning_session/count', [LearningSessionController::class, 'star_count']);
    Route::get('/star/learning_session/pending', [LearningSessionController::class, 'star_pending_list']);
    Route::get('/star/learning_session/pending/{id}', [LearningSessionController::class, 'star_pending_details']);
    Route::get('/star/learning_session/approved', [LearningSessionController::class, 'star_approved_list']);
    Route::get('/star/learning_session/approve/{id}', [LearningSessionController::class, 'approve_post']);
    Route::get('/star/learning_session/completed', [LearningSessionController::class, 'star_completed_list']);
    Route::get('/star/learning_session/evaluation', [LearningSessionController::class, 'star_evaluation_list']);
    Route::get('/star/learning_session/details/{slug}', [LearningSessionController::class, 'details']);
    Route::get('/star/learning_session/assignment/{id}', [LearningSessionController::class, 'star_assignment_details']);
    Route::post('/star/learning_session/add_assignment_rules', [LearningSessionController::class, 'assignment_rule_add']);
    Route::post('/star/learning_session/assignment/approval/{type}/{id}', [LearningSessionController::class, 'star_assignment_set_approval']);





    Route::get('/star/live-chat/pending', [LiveChatController::class, 'pendingLiveChat']);
    Route::get('/star/live-chat/approved', [LiveChatController::class, 'approveLiveChat']);
    Route::get('/star/live-chat/completed', [LiveChatController::class, 'completedLiveChat']);
    Route::get('/star/live-chat/details/{slug}', [LiveChatController::class, 'details']);
    Route::get('/star/approveLiveChat/{id}', [LiveChatController::class, 'setApproveLiveChat']);
    Route::get('/star/pendingLiveChat', [LiveChatController::class, 'pendingLiveChat']);
    Route::get('/star/approvedLiveChat', [LiveChatController::class, 'approveLiveChat']);
    Route::get('/star/livechat_event_details/{id}', [LiveChatController::class, 'details']);
    Route::get('/star/live-chat/setReject/{id}', [LiveChatController::class, 'star_set_reject']);


    Route::get('/deleteLiveChat/{id}', [LiveChatController::class, 'deleteLiveChat']);
    Route::get('/livechatListByDate/{date}', [LiveChatController::class, 'livechatListByDate']);
    Route::get('/registeredUserList/{live_chat_id}', [LiveChatController::class, 'registeredUserList']);

    Route::post('/star/add_live_session', [LiveChatController::class, 'add_live_session']);
    Route::post('/star/update_live_session', [LiveChatController::class, 'update_live_session']);

    Route::get('/star/meetup_event/pending', [MeetupEventController::class, 'star_pending_list']);
    Route::get('/star/meetup_event/approved', [MeetupEventController::class, 'star_approved_list']);
    Route::get('/star/meetup_event/completed', [MeetupEventController::class, 'star_completed_list']);
    Route::get('/star/meetup_event/details/{slug}', [MeetupEventController::class, 'details']);
    Route::get('/star/meetup_event/set_approve/{id}', [MeetupEventController::class, 'set_approve']);

    Route::get('/star/live_chat/count', [LiveChatController::class, 'count2']);

    // star greeting related list
    Route::post('/star/add_greetings', [StarGreetingController::class, 'add_greetings']);
    Route::post('/star/edit_greetings', [StarGreetingController::class, 'edit_greetings']);
    Route::get('/star/approve_greeting/{greeting_id}', [StarGreetingController::class, 'approve_greeting']);
    Route::get('/star/decline_greeting/{greeting_id}', [StarGreetingController::class, 'decline_greeting']);
    Route::get('/star/greetings_star_status', [StarGreetingController::class, 'greetings_star_status']);

    //user greetings register list
    // Route::get('/star/greetings_reg_list/{greetings_id}', [StarGreetingController::class, 'greetingsRegisterListByGreetingsId']);
    // Route::get('/star/greetings_reg_payment_list', [StarGreetingController::class, 'greetingsRegisterWithPaymentList']);
    // Route::get('/star/greetings', [StarGreetingController::class, 'view_star_greeting']);
    Route::get('/star/greetings_register_list_with_payment_complete', [StarGreetingController::class, 'registerListWithPaymentComplete']);
    Route::get('/star/greetings_video_uploaded_list', [StarGreetingController::class, 'greetingsVideoUploadedList']);
    Route::get('/star/greetings_forwarded_to_user_list', [StarGreetingController::class, 'greetingsForwardedToUserList']);
    Route::get('/star/single_greeting_registration/{greeting_registration_id}', [StarGreetingController::class, 'singleGreetingRegistration']);
    Route::post('/star/greeting_video_upload', [StarGreetingController::class, 'videoUpload']);

    //<======================== Auction Route ========================>

    Route::post('/star/add/auction/product', [AuctionController::class, 'star_addProduct']);
    Route::get('/star/editOrConfirm/auction/editOrConfirm', [AuctionController::class, 'star_editOrConfirm']);
    Route::get('/star/edit/auction/{id}', [AuctionController::class, 'star_editProduct']);
    Route::get('/star/approvedOrDecline/auction/{id}', [AuctionController::class, 'star_approvedOrDecline']);
    Route::put('/star/approved/auction/{id}', [AuctionController::class, 'star_approved']);
    Route::put('/star/decline/auction/{id}', [AuctionController::class, 'decline']);
    Route::post('/star/update/auction/{id}', [AuctionController::class, 'star_updateProduct']);
    Route::get('/star/all/auction/product', [AuctionController::class, 'star_allProduct']);
    Route::get('/star/show/auction/product/{id}', [AuctionController::class, 'star_showProduct']);
    Route::get('/star/total/auction/product', [AuctionController::class, 'star_totalProduct']);
    Route::get('/star/pending/auction/product', [AuctionController::class, 'star_pendingProduct']);
    Route::get('/star/pending/auction/product/all', [AuctionController::class, 'star_pendingProductList']);
    Route::get('/star/unSold/auction/product/all', [AuctionController::class, 'star_unSoldProductList']);
    Route::get('/star/sold/auction/product/all', [AuctionController::class, 'star_soldProductList']);
    Route::get('/star/sold/auction/product', [AuctionController::class, 'star_soldProduct']);
    Route::get('/star/unSold/auction/product', [AuctionController::class, 'star_unSoldProduct']);
    Route::get('/star/live/allProduct', [AuctionController::class, 'star_allLiveProduct']);
    Route::get('/star/all/bidders', [AuctionController::class, 'star_allBidders']);
    Route::get('/star/allBidderList/auction/{id}', [AuctionController::class, 'allBidderList']);


    // Super Star Audtion Routes
    Route::get('superstar/audition/pendings', [JudgeAuditionController::class, 'starPendingAudtion']);
    Route::get('superstar/audition/live', [JudgeAuditionController::class, 'starLiveAudtion']);
    Route::get('/star/pending-audition/{id}', [JudgeAuditionController::class, 'starSingleAudition']);
    Route::put('/star/approved/audition/{id}', [JudgeAuditionController::class, 'starApprovedAudition']);
    Route::put('/star/decline/audition/{id}', [JudgeAuditionController::class, 'starDeclineAudition']);

    Route::get('/star/selectVideo/{id}', [AuditionController::class, 'getStarVideos']);
    Route::post('/star/starMarking', [AuditionController::class, 'starMarking']);
    Route::get('/star/starMarkingDone/videos/{id}', [AuditionController::class, 'starMarkingDone']);

    Route::get('superstar/audition/liveEditInstructions/{audition_id}', [JudgeAuditionController::class, 'liveEditInstructions']);
    Route::post('superstar/audition/updateAuditionInstruction/{audition_instruction_id}', [JudgeAuditionController::class, 'updateAuditionInstruction']);

    // Promo Vidoes
    Route::get('/star/promoVideo/all', [PromoVideoController::class, 'starPromovideoAll']);
    Route::post('/star/promoVideo/store', [PromoVideoController::class, 'starPromovideoStore']);
    Route::get('/star/promoVideo/pending', [PromoVideoController::class, 'starPromopendingVideos']);
    Route::get('/star/promoVideo/pending/{id}', [PromoVideoController::class, 'starVideosDetails']);
    Route::get('/star/promoVideo/live', [PromoVideoController::class, 'starPromoliveVideos']);
    Route::get('/star/promoVideo/count', [PromoVideoController::class, 'starPromoVideoCount']);
    Route::get('/star/promoVideo/approved/{id}', [PromoVideoController::class, 'starPromoVideoApproved']);
    Route::get('/star/promoVideo/decline/{id}', [PromoVideoController::class, 'starPromoVideoDecline']);
});


// Approved Star Audition Admin Middleware
Route::middleware(['auth:sanctum', 'isAPIAuditionAdmin'])->group(function () {

    Route::get('/checkingAuditionAdmin', function () {
        return response()->json(['message' => 'You are in as Audition Admin', 'status' => 200], 200);
    });

    // Audition Route For Audition Admin
    Route::get('/audition-admin/audition/count', [AuditionController::class, 'count']);
    Route::get('/audition-admin/audition/singleAuditionRounds/{audition_id}', [AuditionController::class, 'singleAuditionRounds']);
    Route::get('/audition-admin/audition/singleAuditionVideos/{audition_id}', [AuditionController::class, 'singleAuditionVideos']);
    Route::get('/audition-admin/audition/singleAuditionRoundWithRoundId/{audition_id}/{audition_round_id}', [AuditionController::class, 'singleAuditionRoundWithRoundId']);
    Route::get('/audition-admin/audition/singleAuditionVideoWithRoundId/{audition_id}/{audition_round_id}', [AuditionController::class, 'singleAuditionVideoWithRoundId']);
    Route::get('/audition-admin/audition/singleAuditionInstruction/{instruction_id}', [AuditionController::class, 'singleAuditionInstruction']);
    Route::post('/audition-admin/audition/sendDummyInstructionToJudges', [AuditionController::class, 'sendDummyInstructionToJudges']);
    Route::post('/audition-admin/videoStatusChange', [AuditionController::class, 'videoStatusChange']);
    Route::get('/audition-admin/audition/pendings', [AuditionController::class, 'pending']);
    Route::get('/audition-admin/audition/request', [AuditionController::class, 'request']);
    Route::get('/audition-admin/audition/lives', [AuditionController::class, 'live']);

    Route::get('/audition-admin/audition/{slug}', [AuditionController::class, 'getAudition']);
    Route::get('/audition-admin/audition/assigned-judge/{slug}', [AuditionController::class, 'getAssignedJudge']);
    Route::get('/audition-admin/audition/total-judge-approval/{slug}', [AuditionController::class, 'totalJudgeApproval']);
    Route::get('/audition-admin/audition/approval-request-for-manager-admin/{slug}', [AuditionController::class, 'approvalRequestForManagerAdmin']);

    Route::get('/audition-admin/audition/stars/{category_id}', [AuditionController::class, 'stars']);
    Route::post('/audition-admin/audition/add', [AuditionController::class, 'store']);

    Route::get('/audition-admin/auditionStatus/{audition_id}', [AuditionController::class, 'auditionStatus']);
    Route::get('/audition-admin/sendManager/{audition_id}', [AuditionController::class, 'sendManager']);
    Route::put('/audition-admin/confirmed/audition/{audition_id}', [AuditionController::class, 'confirmedAudition']);

    Route::get('audition-admin/audtion-videos/{audition_id}', [AuditionController::class, 'getAuditionVideos']);
    Route::post('audition-admin/filter-video/submit', [AuditionController::class, 'submitFilterVideo']);
    Route::get('audition-admin/accepted-videos/{audition_id}', [AuditionController::class, 'acceptedVideo']);
    Route::get('audition-admin/rejected-videos/{audition_id}', [AuditionController::class, 'rejectedVideo']);
    Route::post('audition-admin/send-manager-admin', [AuditionController::class, 'videoSendManagerAdmin']);

    // Selected Jury Marking on Audition Video
    Route::get('audition-admin/jury-selected-videos/{audition_id}', [AuditionController::class, 'juryMarkingVideos']);
    Route::get('audition-admin/jury-marking-videos/{jury_id}', [AuditionController::class, 'getJuryMarkingVideos']);
    Route::get('audition-admin/get-mark-wise-videos/{audition_id}/{mark}', [AuditionController::class, 'getMarkWiseVideos']);

    Route::post('audition-admin/selected-top-videos', [AuditionController::class, 'selectedTop']);
    Route::post('audition-admin/rejected-videos-message', [AuditionController::class, 'rejectedMessage']);
    Route::get('/audition-admin/participant/list/{id}', [AuditionController::class, 'participantList']);

    Route::get('audition-admin/participant/list', [AuditionController::class, 'participantList']);


    Route::post('audition-admin/audition-round-instruction', [AuditionController::class, 'saveRoundInstruction']);

    Route::get('audition-admin/jury-num-assinged-videos/{audition_id}/{round_rule_id}', [AuditionController::class, 'juryNumberOfVideosApply']);
    Route::post('audition-admin/submit-jury-assign-video', [AuditionController::class, 'updateJuryAssignVideo']);
    Route::post('audition-admin/submit-jury-auto-assign-video', [AuditionController::class, 'updateJuryAutoAssignVideo']);
    Route::get('audition-admin/jury-mark-on-videos-status/{audition_id}/{round_rule_id}', [AuditionController::class, 'juryMarkOnVideosStatus']);
});


// Approved Jury Board Middleware
Route::middleware(['auth:sanctum', 'isAPIJuryBoard'])->group(function () {

    Route::get('/checkingJurySuperStar', function () {
        return response()->json(['message' => 'You are in as Jury Audition', 'status' => 200], 200);
    });

    // Route::get('/jury/selectVideo', [AuditionController::class, 'getJuryVideos']);
    // Route::post('/jury/juryMarking', [AuditionController::class, 'juryMarking']);
    // Route::get('/jury/juryMarkingDone/videos', [AuditionController::class, 'markingDone']);

    Route::get('/jury/audition/lives', [JuryAuditionController::class, 'live']);
    Route::get('/jury/audition/singleAuditionVideos/{audition_id}', [JuryAuditionController::class, 'singleAuditionVideos']);
    Route::get('/jury/audition/singleAuditionVideoWithRoundId/{audition_id}/{audition_round_id}', [JuryAuditionController::class, 'singleAuditionVideoWithRoundId']);
    Route::post('/jury/audition/videoStatusChange', [JuryAuditionController::class, 'videoStatusChange']);
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

// Route for Jury Board Panel
Route::post('jury-register', [JuryAuthController::class, 'register']);





Route::get('view-category', [CategoryController::class, 'index']);
Route::get('/user/subcategory/{id}', [CategoryController::class, 'allSubcategoryList']);
Route::get('/user/left/subcategory/{slug}', [CategoryController::class, 'allLeftSubcategoryList']);
Route::get('/user/starcategory/{id}', [CategoryController::class, 'allStarCategoryList']);
Route::get('/user/selected/starcategory', [CategoryController::class, 'starFollowingList']);
Route::get('/user/selected/category', [CategoryController::class, 'selectedCategory']);
Route::post('/user/selected/category/store', [CategoryController::class, 'selectedCategoryStore']);
Route::post('/user/selected/subcategory/store', [CategoryController::class, 'selectedSubCategoryStore']);
Route::post('/user/selected/starcategory/store', [CategoryController::class, 'selectedStarCategoryStore']);
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

Route::post('/add/auction/product', [AuctionController::class, 'addProduct']);
Route::get('/editOrConfirm/auction/editOrConfirm', [AuctionController::class, 'editOrConfirm']);
Route::get('/edit/auction/{id}', [AuctionController::class, 'editProduct']);
Route::put('/update/auction/{id}', [AuctionController::class, 'updateProduct']);
Route::get('/all/auction/product', [AuctionController::class, 'allProduct']);
Route::get('/show/auction/product/{id}', [AuctionController::class, 'showProduct']);
Route::get('/total/auction/product', [AuctionController::class, 'totalProduct']);
Route::get('/pending/auction/product', [AuctionController::class, 'pendingProduct']);
Route::get('/sold/auction/product', [AuctionController::class, 'soldProduct']);
Route::get('/unSold/auction/product', [AuctionController::class, 'unSoldProduct']);
Route::post('/bidding/auction/product/{id}', [AuctionController::class, 'bidNow']);
Route::get('/live/allProduct', [AuctionController::class, 'allLiveProduct']);



require __DIR__ . '/userMobileAppApi.php';
