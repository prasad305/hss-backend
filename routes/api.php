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
use App\Http\Controllers\API\Audition\Judge\JudgeAuditionController;
use App\Http\Controllers\API\PromoVideoController;
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

    // auction product
    Route::get('/auction-product/all', [UserController::class, 'auctionProduct']);
    Route::get('/user/getStarAuction/{star_id}', [UserController::class, 'starAuction']);



    //Event Registaion By User (Learning Session + Live Chat + Greeting + Meetup Event)
    Route::post('/user/learning_session/register', [UserController::class, 'LearningSessionRegistration']);
    Route::post('/user/liveChat/register', [UserController::class, 'liveChatRigister']);
    Route::post('/user/greetings/register', [UserController::class, 'greetingsRegistation']);
    Route::post('/user/meetup-event/register', [MeetupEventController::class, 'meetup_register']);

    // Auction
    Route::get('/user/getStarAuctionProduct/{product_id}', [UserController::class, 'starAuctionProduct']);
    Route::post('user/bidding/auction/product', [UserController::class, 'bidNow']);
    Route::get('user/liveBidding/auction/{auction_id}', [UserController::class, 'liveBidding']);
    Route::get('user/liveBidding/history/{auction_id}', [UserController::class, 'bidHistory']);

    // Audition

    Route::get('/user/getUpcomingAuditions', [UserController::class, 'getUpcomingAuditions']);
    Route::get('/user/audition/participate/{id}', [UserController::class, 'participateAudition']);
    Route::post('/user/register/participate', [UserController::class, 'participantRegister']);
    Route::post('/user/payment/participate', [UserController::class, 'auditionPayment']);
    Route::post('/user/video/participate', [UserController::class, 'videoUpload']);
    Route::get('/user/audition/participate/video/{id}', [UserController::class, 'videoDetails']);
    Route::get('/user/audition/enrolled', [UserController::class, 'enrolledAuditions']);
    Route::get('/user/pendingEnrollAudition', [UserController::class, 'enrolledAuditionsPending']);

    // Promo Videos

    Route::get('/user/PromoVideos', [UserController::class, 'getPromoVideo']);

    // User Profile

    Route::post('/user/coverUpdate/{id}', [UserController::class, 'updateCover']);
    Route::post('/user/profileUpdate/{id}', [UserController::class, 'updateProfile']);

    // User Photos

    Route::get('/user/activitiesData', [UserController::class, 'userActivites']);
});




// Approved Star Admin Middleware
Route::middleware(['auth:sanctum', 'isAPIAdmin'])->group(function () {

    Route::get('/checkingAdmin', function () {
        return response()->json(['message' => 'You are in as Admin', 'status' => 200], 200);
    });

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
});



// Approved Superstar Middleware
Route::middleware(['auth:sanctum', 'isAPIStar'])->group(function () {
    Route::get('/checkingSuperStar', function () {
        return response()->json(['message' => 'You are in as Superstar', 'status' => 200], 200);
    });

    Route::get('/livechat', [LiveChatController::class, 'livechat']);
    Route::get('/sinlgeLiveChat/{id}', [LiveChatController::class, 'sinlgeLiveChat']);


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

    // Learning Session Section
    Route::post('/star/add_learning_session', [LearningSessionController::class, 'star_add']);
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

    //<======================== Auction Route ========================>

    Route::post('/star/add/auction/product', [AuctionController::class, 'star_addProduct']);
    Route::get('/star/editOrConfirm/auction/editOrConfirm', [AuctionController::class, 'star_editOrConfirm']);
    Route::get('/star/edit/auction/{id}', [AuctionController::class, 'star_editProduct']);
    Route::get('/star/approvedOrDecline/auction/{id}', [AuctionController::class, 'star_approvedOrDecline']);
    Route::put('/star/approved/auction/{id}', [AuctionController::class, 'star_approved']);
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


    // Super Star Audtion Routes
    Route::get('superstar/audition/pendings', [JudgeAuditionController::class, 'starPendingAudtion']);
    Route::get('superstar/audition/live', [JudgeAuditionController::class, 'starLiveAudtion']);
    Route::get('/star/audition/{id}', [JudgeAuditionController::class, 'starSingleAudition']);
    Route::put('/star/approved/audition/{id}', [JudgeAuditionController::class, 'starApprovedAudition']);
    Route::put('/star/decline/audition/{id}', [JudgeAuditionController::class, 'starDeclineAudition']);

    Route::get('/star/selectVideo/{id}', [AuditionController::class, 'getStarVideos']);
    Route::post('/star/starMarking', [AuditionController::class, 'starMarking']);
    Route::get('/star/starMarkingDone/videos/{id}', [AuditionController::class, 'starMarkingDone']);

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
    Route::get('/audition-admin/audition/pendings', [AuditionController::class, 'pending']);
    Route::get('/audition-admin/audition/request', [AuditionController::class, 'request']);
    Route::get('/audition-admin/audition/lives', [AuditionController::class, 'live']);

    Route::get('/audition-admin/audition/{slug}', [AuditionController::class, 'getAudition']);
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
    Route::get('audition-admin/participant/list', [AuditionController::class, 'participantList']);
});


// Approved Jury Board Middleware
Route::middleware(['auth:sanctum', 'isAPIJuryBoard'])->group(function () {

    Route::get('/checkingJurySuperStar', function () {
        return response()->json(['message' => 'You are in as Jury Audition', 'status' => 200], 200);
    });

    Route::get('/jury/selectVideo', [AuditionController::class, 'getJuryVideos']);
    Route::post('/jury/juryMarking', [AuditionController::class, 'juryMarking']);
    Route::get('/jury/juryMarkingDone/videos', [AuditionController::class, 'markingDone']);

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
