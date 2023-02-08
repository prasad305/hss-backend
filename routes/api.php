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
use App\Http\Controllers\API\SouvinerController;
use App\Http\Controllers\API\WalletController;
use App\Http\Controllers\API\LearningSessionController;
use App\Http\Controllers\API\Audition\Admin\AuditionController;
use App\Http\Controllers\API\Audition\Jury\JuryAuditionController;
use App\Http\Controllers\API\Audition\Judge\JudgeAuditionController;
use App\Http\Controllers\API\DashboardController;
use App\Http\Controllers\API\GuestController;
use App\Http\Controllers\API\PromoVideoController;
use App\Http\Controllers\API\QnaController;
use App\Http\Controllers\API\StarGreetingController;
use App\Http\Controllers\API\StarScheduleController;
use App\Http\Controllers\API\CurrencyController;
use App\Http\Controllers\API\Payment\PaymentController;
use App\Http\Controllers\HomeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\SettingsController;
use App\Http\Controllers\API\SdkController\SdkController;
use App\Http\Con;
use Vonage\Message\Shortcode\Marketing;
use trollers\API\VirtualtourController;





//video for SDK
Route::get('/time-distribute/{event_id}', [UserController::class, 'distributionTime']);

Route::get('/sdk/get-token', [SdkController::class, 'getToken']);
Route::get('/sdk/get-token/user', [SdkController::class, 'getTokenUser']);
Route::get('/sdk/get-token/admin', [SdkController::class, 'getToken']);

Route::get('/sdk/createMeeting/{token}', [SdkController::class, 'createMeetingId']);
Route::post('/sdk/validate-meeting/{roomId}', [SdkController::class, 'roomValidate']);
Route::get('/sdk/videoEnd/{room_id}/{token}', [SdkController::class, 'roomRoomEnd']);

Route::post('/sdk/remove-participants', [SdkController::class, 'RemoveParticipantsMeeting']);
Route::get('/sdk/sdk-session-id/{roomId}', [SdkController::class, 'getSdkAlluser']);
Route::get('/sdk/meeting-record-start/{roomId}', [SdkController::class, 'meetingRecordStart']);
Route::get('/sdk/meeting-record-stop/{roomId}', [SdkController::class, 'meetingRecordStop']);
Route::get('/sdk/meeting-record-download/{roomId}', [SdkController::class, 'meetingRecordDownlode']);

Route::post('/ipay88-success', [PaymentController::class, 'ipay88PaymentSuccess']);





Route::post('/uplad-video', [HomeController::class, 'video_upload']);

//Policy
Route::get('aboutus', [SettingsController::class, 'aboutus']);
Route::get('policy', [SettingsController::class, 'policy']);
Route::get('faq', [SettingsController::class, 'faq']);
Route::get('refund', [SettingsController::class, 'refund']);
Route::get('product-purchase', [SettingsController::class, 'productPurchase']);
Route::get('terms-condition', [SettingsController::class, 'termsCondition']);


//Virtual Tour
Route::get('virtualtourforweb', [VirtualtourController::class, 'virtualtourforweb']);
Route::get('virtualtourforphone', [VirtualtourController::class, 'virtualtourforphone']);

// Authentication API
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('user_forget_password', [AuthController::class, 'UserForgetPassword']);
Route::post('user_forget_password_store', [AuthController::class, 'UserForgetPasswordStore']);
Route::post('user_authentication', [AuthController::class, 'user_authentication']);
Route::post('logout', [AuthController::class, 'logout']);
//
Route::get('getStarInfo/data/{star_id}', [AuthController::class, 'getStarData']);

// OTP Verification API
Route::post('otp_verify', [AuthController::class, 'otp_verify']);
Route::post('verify_user', [AuthController::class, 'verify_user']);
Route::post('verify_to_register_event', [AuthController::class, 'VerifyToRegisterEvent']);
Route::get('resend_otp', [AuthController::class, 'resend_otp']);
Route::get('reset_otp', [AuthController::class, 'reset_otp']);


Route::get('/guest/all_post/with-paginate/{limit}', [GuestController::class, 'paginate_all_post']);

// Currency


Route::get('all/currency/{ip}', [CurrencyController::class, 'allCurrency']);
Route::get('all/sidebar/list', [CategoryController::class, 'allDataList']);
Route::get('user/location', [CurrencyController::class, 'getLocation']);
Route::get('user/current-location/{ip}', [CurrencyController::class, 'getMyLocation']);


// Home Page All Post
Route::get('/user/all_post', [UserController::class, 'all_post']);
Route::get('/user/search/{query}', [UserController::class, 'allSearchData']);
Route::get('/user/all_post/with-paginate/{limit}', [UserController::class, 'paginate_all_post']);
Route::get('/user/post/{type}', [UserController::class, 'single_type_post']);
Route::post('/user/general-post/payment', [UserController::class, 'generalPostPayment']);
Route::get('/user/generalPost/payment/check/{post_id}', [UserController::class, 'generalPostPaymentCheck']);
Route::get('/user/generalPost/payment/check', [UserController::class, 'simplePostPaymentCheck']);

Route::get('/user/post/{type}/with-paginate/{limit}', [UserController::class, 'paginate_single_type_post']);

//User Settings
Route::post('/user/interest/store', [UserController::class, 'interestStore']);
Route::post('/user/educational/store', [UserController::class, 'educationalStore']);
Route::post('/user/employment/store', [UserController::class, 'employmentStore']);
Route::post('/user/personal-data/store', [UserController::class, 'personalDataStore']);
Route::get('/user/educational/list/check', [UserController::class, 'userEducationCheck']);
Route::get('/user/employment/list/check', [UserController::class, 'userEmploymentCheck']);
Route::get('/user/personal/list/check', [UserController::class, 'userPersonalList']);
Route::post('/user/password/changes', [UserController::class, 'userPasswordChanges']);

Route::get('/user/allCountry', [UserController::class, 'allCountry']);
Route::get('/user/educationlavel', [UserController::class, 'educationLavel']);
Route::get('/user/occupation', [UserController::class, 'occupationList']);


//Star Photo and videos
Route::get('/star_photos/{id}', [UserController::class, 'star_photo']);
Route::get('/star_videos/{id}', [UserController::class, 'star_video']);
Route::get('/user/getStarPost/{id}/{type}', [UserController::class, 'getStarPost']);
Route::get('/user/getStarPost/{id}/{type}/with-paginate/{limit}', [UserController::class, 'paginate_getStarPost']);

/**
 * all upcommit events
 */
Route::get('/user/all-upcomming-events', [UserController::class, 'allUpCommingEvents']);


// Data Fetching For Landing Page Right Side Bar

Route::get('/user/live_chat/all', [LiveChatController::class, 'userAll']);


Route::post('/chatting/message', [UserController::class, 'message']);
Route::get('/chatting/message/{id}', [UserController::class, 'get_message']);
Route::post('/group/message', [UserController::class, 'group_message']);
Route::get('/group/message/{id}', [UserController::class, 'get_group_message']);

Route::get('/guest/PromoVideos', [GuestController::class, 'getPromoVideo']);

Route::get('/user/star_list', [UserController::class, 'star_list']);

//after payTM redirect
Route::post('paytm-callback/{redirectTo}/{user_id}/{type}/{event_id}/{reactNum?}', [PaymentController::class, 'paytmCallback']);

//paytm mobile
Route::get('/txn-token-mobile/{amount}', [PaymentController::class, 'txnTokenGenerate']);

//pocket get token
Route::get('/pocket-token', [PaymentController::class, 'pocketToken']);

Route::post('/pocket-signature', [PaymentController::class, 'getPocketSignature']);


// Registered & Verified User Middleware
Route::middleware(['auth:sanctum', 'isAPIUser'])->group(function () {

    Route::get('/checkingAuthenticated', function () {
        return response()->json(['message' => 'You are in', 'status' => 200], 200);
    });

    //********************************************//
    //******Learning Session Routes Start *******//
    //********************************************//

    //Route::get('/user/learning_session/all', [UserController::class, 'learningSessionUserRightSide']); // Trash API
    
    Route::post('/learning-assinment-upload', [UserController::class, 'lerningSessionAssinmentVideoUplad']);
    Route::get('/user/learning-single/{event_id}', [UserController::class, 'registeredSingleLearning']);
    Route::get('/user/registerLearningSession', [UserController::class, 'registeredLearningSession']);
    Route::get('/learnig-session/{slug}', [UserController::class, 'singleLearnigSession']);
    Route::get('/user/learning-session/{slug}', [UserController::class, 'userSingleLearnigSession']);
    Route::get('/learning-session/result/{slug}', [UserController::class, 'learningSeesionResult']);

    //lerning session registaion
    Route::post('/learnig-session', [UserController::class, 'LearningSessionReg']);

    //Event Registaion By User (Learning Session)
    Route::post('/user/learning_session/register', [UserController::class, 'LearningSessionRegistration']);
    Route::post('/user/learning-session/video-upload', [UserController::class, 'uploadLearningSessionVideo']);
    Route::post('/user/learning-session/saveCertificateInfo', [UserController::class, 'saveCertificateInfo']);
    Route::get('/user/learning-session/getUploadedVideo/{event_id}', [UserController::class, 'getUploadedVideo']);
    Route::get('/user/greeting-leraning-certificate/{event_id}', [UserController::class, 'getCertificateData']);

    //********************************************//
    //******Learning Session Routes End *******//
    //********************************************//

    //delete account
    Route::post('/delet-user', [UserController::class, 'deleteUser']);

    //shurjoy pay
    Route::post('/initiata-shurjo-payment', [PaymentController::class, 'initiataShurjoPayment']);
    //shurjoy pay status
    Route::get('/shurjo-payment-status/{order_id}', [PaymentController::class, 'shurjoPaymentStatus']);



    //stripe mobile
    Route::post('/stripe-make-mobile-payment', [PaymentController::class, 'stripePaymentMobile']);

    //paytm make payment
    Route::post('paytm-payment', [PaymentController::class, 'paymentNow']);

    //paytm mobile payment success
    Route::post('paytm-payment-success', [PaymentController::class, 'paytmPaymentSuccessForMobile']);


    //stripe make payment
    Route::post('/stripe-payment-make', [PaymentController::class, 'stripePaymentMake']);
    Route::get('/stripe-payment-success/{event_id}/{event_type}', [PaymentController::class, 'stripePaymentSuccess']);

    //stripe videoFeedReactStripe
    Route::post('/buy-video-feed-react', [PaymentController::class, 'videoFeedReactBuy']);



    //post search
    Route::get('/search-post/{valu}', [UserController::class, 'searchPost']);



    
    Route::get('/user_info', [AuthController::class, 'user_info']);
    Route::post('/user_info_update', [AuthController::class, 'user_info_update']);
    Route::post('/user_info_update/star_admin', [AuthController::class, 'star_admin_info_update']);
    Route::post('/user_info_update/star_admin_info', [AuthController::class, 'star_admin_info']);
    Route::post('/user_otherInfo_update', [AuthController::class, 'user_OtherInfo_update']);
    Route::get('/user_data/{id}', [AuthController::class, 'user_data']);

    Route::post('user/image-upload', [UserController::class, 'MobileImageUpUser']);

    //User post share
    Route::get('/user/post/share/{postId}', [UserController::class, 'postShare']);
    Route::post('/user/post/share/store/{postId}', [UserController::class, 'postShareStore']);

    //fan post share
    Route::get('/user/fan/post/share/{postId}', [UserController::class, 'fanPostShare']);
    Route::post('/user/fan/post/share/store/{postId}', [UserController::class, 'fanPostShareStore']);
    Route::post('/user/mobile/fan/group/post/store', [FanGroupController::class, 'getMobileFanPostStore']);

    Route::get('/user/total_notification_count', [UserController::class, 'total_notification_count']);
    Route::get('/user/notification/view_status/update/{id}', [UserController::class, 'notification_view_status_update']);


    Route::get('/user/activity_count', [AuthController::class, 'activity_count']);

    //not use
    Route::get('/user/getAllLiveChatEvent', [UserController::class, 'getAllLiveChatEvent']);
    Route::get('/user/getAllLiveChatEventByStar/{id}', [UserController::class, 'getAllLiveChatEventByStar']);
    Route::get('/user/getAllPostWithForSingleStar/{star_id}', [UserController::class, 'getAllPostWithForSingleStar']);


    Route::get('/user/registerMeestup', [UserController::class, 'registeredMeetup']);
    Route::get('/user/registerMeestup-single/{event_id}', [UserController::class, 'registeredSingleMeetup']);
    
    Route::get('/user/registerLivechat', [UserController::class, 'registeredLivechat']);
    
    Route::get('/user/registerGreetings', [UserController::class, 'registerGreetings']);


    Route::get('/user/sinlgeLiveChat/{id}', [UserController::class, 'sinlgeLiveChat']);
    Route::get('/user/getSingleLiveChatEvent/{id}', [UserController::class, 'getSingleLiveChatEvent']);
    Route::get('/user/getSingleLiveChatEvent/{minute}/{id}', [UserController::class, 'getLiveChatTiemSlot']);

    //live chat
    Route::get('/user/live-chat/{slug}', [UserController::class, 'liveChatDetails']);
    Route::get('/user/live-chat/reg_info/{id}', [UserController::class, 'liveChatRegDetails']);


    //Questions And Answers
    Route::get('/user/qna/{slug}', [UserController::class, 'qnaDetails']);
    Route::get('/user/sinlgeQna/{id}', [UserController::class, 'sinlgeQna']);
    Route::get('/user/getSingleQnaEvent/{id}', [UserController::class, 'getSingleQnaEvent']);
    Route::get('/user/getSingleQnaEvent/{minute}/{id}', [UserController::class, 'getLiveQnaTiemSlot']);
    Route::get('/user/qna_activites', [UserController::class, 'qna_activities']);
    Route::get('/user/qnaAll', [UserController::class, 'getQnaAll']);
    Route::get('/user/qnaStarAll/{id}', [UserController::class, 'getStarQna']);
    Route::get('/user/qna/reg_info/{id}', [UserController::class, 'qnaRegDetails']);
    Route::post('/user/wallet/qna-register', [QnaController::class, 'qnaWalletStore']);




    //Meetup Event
    Route::get('/user/meetup/{slug}', [UserController::class, 'meetupDetails']);
    Route::get('view-country', [CategoryController::class, 'index']);
    Route::get('subcategory/{slug}', [SubCategoryController::class, 'index']);

    //not use
    Route::get('/user/registeredLivechat', [UserController::class, 'registeredLivechat']);


    Route::get('/user/interest/type', [UserController::class, 'interestType']);

    // Marketplace Section
    Route::get('/user/marketplace/all', [MarketplaceController::class, 'marketplaceAll']);
    Route::get('/user/marketplace/all/{star_id}', [MarketplaceController::class, 'marketplaceStarAll']);
    Route::get('/user/marketplace/view-country', [MarketplaceController::class, 'viewCountry']);
    Route::get('/user/marketplace/state/{id}', [MarketplaceController::class, 'viewState']);
    Route::get('/user/marketplace/city/{id}', [MarketplaceController::class, 'viewCity']);
    Route::get('/user/marketplace/details/{slug}', [MarketplaceController::class, 'getSlugDetails']);
    Route::post('/user/marketplace/order/store', [MarketplaceController::class, 'viewMarketplaceOrder']);
    Route::get('/user/marketplace/activities', [MarketplaceController::class, 'viewMarketplaceActivities']);
    Route::get('/user/marketplace/order/product-list/view/{id}', [MarketplaceController::class, 'orderAdminProductListView']);

    // Fan Group Section
    Route::get('/user/fan/group/list', [FanGroupController::class, 'getFanGroupList']);
    Route::get('/user/fan/post/list/{starId}', [FanGroupController::class, 'fanPostStarAll']);
    Route::get('/user/fan/group/{slug}', [FanGroupController::class, 'getFanGroupDetails']);
    Route::post('/user/fan/group/store', [FanGroupController::class, 'getFanGroupStore']);
    Route::get('/user/fan/group/join/{join_id}', [FanGroupController::class, 'getFanGroupJoinId']);
    Route::post('/user/fan/group/post/store', [FanGroupController::class, 'getFanPostStore']);
    Route::get('/user/fan/group/post/show/{slug}', [FanGroupController::class, 'getFanPostShow']);
    Route::get('/user/fan/group/post/like/{postId}', [FanGroupController::class, 'getFanPostLike']);
    Route::post('/user/fan/group/post/like/{postId}', [FanGroupController::class, 'postFanPostLike']);
    Route::get('/user/fan/group/analytics/{slug}', [FanGroupController::class, 'showFanGroupAnalytics']);


    Route::get('/user/meetupEventList', [MeetupEventController::class, 'meetup_event_list']);
    Route::get('/user/meetup-event/{star_id}/{event_id}', [MeetupEventController::class, 'meetup_event_booking']);


    // New Marketing

    Route::get('/star_info/{star_id}', [UserController::class, 'star_info']);



    //greetings registation update
    Route::get('/user/greeting-info-to_registration/{greeting_id}', [UserController::class, 'greetingInfoToRegistration']);
    Route::post('/user/greetings_registaion_update', [UserController::class, 'greetingsRegistationUpdate']);

    //user greeting registatin status
    Route::get('/user/greetings_registaion_status/{star_id}', [UserController::class, 'greetingStatus']);
    Route::get('/user/greetings/get_purpose_list', [UserController::class, 'getPurposeList']);

    //greetings Activety check
    Route::get('/user/greetings_star_status/{star_id}', [GreetingController::class, 'greetingsCreateStatus']);
    //greetings reg delete
    Route::get('/user/greetings_reg_delete/{id}', [GreetingController::class, 'greetingsRegDelete']);


    //check user notification
    Route::get('/user/check_notification', [UserController::class, 'checkUserNotifiaction']);
    

    

    // auction product
    Route::get('/auction-product/all', [UserController::class, 'auctionProduct']);
    Route::get('/auction-product/{id}', [UserController::class, 'auctionSingleProduct']);
    Route::get('/user/getStarAuction/{star_id}', [UserController::class, 'starAuction']);
    // Auction
    Route::get('/mobile/getProduct/{product_id}', [UserController::class, 'getAuctionByBidding']);
    Route::get('/mobile/getStarAuctionProduct/{product_id}', [UserController::class, 'starAuctionProductMobile']);
    Route::get('/user/getStarAuctionProduct/{product_id}', [UserController::class, 'starAuctionProduct']);
    Route::post('user/bidding/auction/product', [UserController::class, 'bidNow']);
    Route::get('user/liveBidding/auction/{auction_id}', [UserController::class, 'liveBidding']);
    Route::get('user/auctionApply/auction/{auction_id}', [UserController::class, 'auctionApply']);
    Route::get('user/liveBidding/history/{auction_id}', [UserController::class, 'bidHistory']);
    Route::post('user/aquired/auction', [UserController::class, 'aquiredProduct']);
    Route::get('user/maxbid/auction/{id}', [UserController::class, 'maxBid']);
    Route::get('/user/auction_activites', [UserController::class, 'auction_activites']);


    

    //use this api on react project file path- \src\components\Pages\Profile\profile-components\starProfile\StarChat
    Route::post('/user/liveChat/register', [UserController::class, 'liveChatRigister']);

    Route::post('/user/greetings/register', [UserController::class, 'greetingsRegistation']);
    Route::post('/user/meetup-event/register', [MeetupEventController::class, 'meetup_register']);


    // Audition
    Route::get('/user/audition/all', [UserController::class, 'audition_list']);
    Route::get('/user/audition/participate/{id}', [UserController::class, 'participateAudition']);


    Route::post('/user/video/participate', [UserController::class, 'videoUpload']);
    Route::get('/user/audition/participate/video/{id}', [UserController::class, 'videoDetails']);
    Route::get('/user/audition/enrolled', [UserController::class, 'enrolledAuditions']);
    Route::get('/user/pendingEnrollAudition', [UserController::class, 'enrolledAuditionsPending']);
    Route::get('/user/audition/details/{slug}', [UserController::class, 'UserAuditionDetails']);
    Route::get('/user/audition/round-instruction/{audition_id}/{round_num}', [UserController::class, 'roundInstruction']);
    Route::get('/user/registration_checker/audition/{slug}', [UserController::class, 'UserAuditionRegistrationChecker']);
    Route::post('/user/audition/round-video-upload', [UserController::class, 'userRoundVideoUpload']);
    Route::get('/user/audition/uploaded_round_videos/{audition_id}/{round_info_id}', [UserController::class, 'uploaded_round_videos']);

    // Audition download certificate
    Route::get('user/audition/getAuditionCertificateData/{audition_id}/{round_info_id}', [UserController::class, 'getAuditionCertificateData']);
    Route::post('user/audition/auditionCertificatePayment', [UserController::class, 'auditionCertificatePayment']);
    // Audition Appeal Route
    Route::post('/user/audition/round-appeal-registration', [UserController::class, 'roundAppealRegister']);
    Route::get('user/audition/is_appeal/round/{audition_id}/{round_info_id}', [UserController::class, 'isAppealForThisRound']);

    // Route::post('user/audition/videos/{audition_id}', [UserController::class, 'checkAuditionVideoUpload']);

    Route::get('/user/audition/current_round_info/{event_slug}', [UserController::class, 'current_round_info']);

    // Video Feed

    Route::get('/user/audition/videofeed/videos', [UserController::class, 'videoFeedVideos']);
    Route::post('/user/audition/videos/loveReact', [UserController::class, 'userVideoLoveReact']);
    Route::post('/user/audition/videos/loveReact/payment', [UserController::class, 'userVideoLoveReactPayment']);
    Route::get('/user/audition/getOxygen/videos', [UserController::class, 'getOxygenVideo']);
    Route::post('/user/audition/getOxygenReply/video', [UserController::class, 'oxygenReplyVideo']);
    Route::get('/user/audition/videofeed/loveReact', [UserController::class, 'getVideoFeedLoveReact']);
    // Promo Videos
    Route::get('/user/PromoVideos', [UserController::class, 'getPromoVideo']);

    // Jury Profile
    Route::post('/jury/juryUpdateCover/{id}', [UserController::class, 'juryUpdateCover']);
    Route::post('/jury/juryUpdateProfile/{id}', [UserController::class, 'juryUpdateProfile']);

    // User Profile
    Route::post('/user/coverUpdate', [UserController::class, 'updateCover']);
    Route::post('/user/profileUpdate', [UserController::class, 'updateProfile']);



    // Souviner Section
    Route::get('/user/souviner/view/{starId}', [SouvinerController::class, 'getUserSouvenir']);
    Route::post('/user/souviner/payment/store', [SouvinerController::class, 'userSouvenirPaymentStore']);
    Route::post('/user/souvenir/apply/store/{starId}', [SouvinerController::class, 'applyUserSouvenir']);
    Route::get('/user/souvenir/activities/list', [SouvinerController::class, 'activitiesUserSouvenir']);
    Route::get('/user/souvenir/activities/view/{id}', [SouvinerController::class, 'activitiesDetailsUserSouvenir']);
    Route::get('/user/souvenir/order/view/{id}', [SouvinerController::class, 'orderDetailsSouvenir']);



    // User Photos

    Route::get('/user/purchasedPhotos', [UserController::class, 'purchasedPhotos']);
    Route::get('/user/purchasedVideos', [UserController::class, 'purchasedVideos']);
    Route::get('/user/activitiesData', [UserController::class, 'userActivites']);
    Route::get('/user/activitiesData/with-paginate/{limit}', [UserController::class, 'paginate_userActivites']);
    Route::get('/user/{id}/activitiesData/with-paginate/{limit}', [UserController::class, 'paginate_userActivites_by_id']);

    //Registration Checker
    Route::get('/user/registration_checker/{type}/{slug}', [UserController::class, 'registration_checker']);

    // Wallet
    Route::get('/user/packages/all', [WalletController::class, 'package_list']);
    Route::get('/user/love/all', [WalletController::class, 'love_list']);
    Route::get('/user/wallet/details', [WalletController::class, 'getUserWallet']);
    Route::post('/user/wallet/store', [WalletController::class, 'userWalletStore']);
    Route::post('/user/wallet/love/store', [WalletController::class, 'userWalletLoveStore']);
    Route::get('/user/wallet/history', [WalletController::class, 'userWalletHistory']);
    Route::post('/user/free/wallet/store/{packageId}/{userId}', [WalletController::class, 'userFreeWalletStore']);
    Route::post('/user/love/free/{loveId}/{userId}', [WalletController::class, 'userFreeWalleLovetStore']);
});


// Approved Star Admin Middleware
Route::middleware(['auth:sanctum', 'isAPIAdmin'])->group(function () {

    Route::get('/checkingAdmin', function () {
        return response()->json(['message' => 'You are in as Admin', 'status' => 200], 200);
    });

    //********************************************//
    //******Learning Session Routes Start *******//
    //********************************************//

    // Learning Session Section
    Route::post('admin/learning_session/create', [LearningSessionController::class, 'add_learning']);
    Route::post('/admin/update_learning_session/{id}', [LearningSessionController::class, 'adminUpdateLearning']);
    Route::get('/admin/learning_session/all', [LearningSessionController::class, 'all']);
    Route::get('/admin/learning_session/count', [LearningSessionController::class, 'count']);
    Route::get('/admin/learning_session/rejected', [LearningSessionController::class, 'rejected_list']);
    Route::get('/admin/learning_session/pending', [LearningSessionController::class, 'pending_list']);
    Route::get('/admin/learning_session/live', [LearningSessionController::class, 'live_list']);
    Route::get('/admin/learning_session/evaluation', [LearningSessionController::class, 'evaluation_list']);
    Route::get('/admin/learning_session/completed', [LearningSessionController::class, 'completed_list']);
    Route::get('/admin/learning_session/details/{id}', [LearningSessionController::class, 'details']);
    Route::get('/admin/learning_session/registered_user/{id}', [LearningSessionController::class, 'registured_user']);
    Route::get('/admin/learning_session/pending/{id}', [LearningSessionController::class, 'pending_details']);
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
    Route::get('/admin/learning_session/result', [LearningSessionController::class, 'showLearninSessionResult']);
    Route::get('/admin/learning_session/showResult/{eventId}', [LearningSessionController::class, 'showLearninSessionResultData']);


    //********************************************//
    //******Learning Session Routes End *******//
    //********************************************//

    Route::get('admin/dashboard', [DashboardController::class, 'adminDashboard']);
    Route::get('admin/dashboard/posts/{type}', [DashboardController::class, 'dashboardPosts']);
    Route::get('admin/dashboard/post-details/{id}/{type}', [DashboardController::class, 'postDeatils']);
    Route::get('admin/star_list', [CategoryController::class, 'star_list']);
    Route::get('admin/agreement_paper/{star_id}', [CategoryController::class, 'agreement_paper']);

    Route::get('/admin/profitShare', [DashboardController::class, 'profitShare']);
    Route::post('/admin/profit/withdraw', [DashboardController::class, 'profitWithdraw']);

    // Fan Group Section
    Route::post('admin/fan-group/store', [FanGroupController::class, 'fanGroupStore']);
    Route::get('/admin/fan-group/star/list', [FanGroupController::class, 'allStarList']);
    Route::get('/admin/fan-group/star/list/{data}', [FanGroupController::class, 'someStarList']);
    Route::get('/admin/fan/group/adminlist/status', [FanGroupController::class, 'statusAdminStar']);
    Route::get('/admin/fan/group/show/{slug}', [FanGroupController::class, 'showFanGroup']);
    Route::get('/admin/fan/group/analytics/{slug}', [FanGroupController::class, 'showFanGroupAnalytics']);
    Route::post('/admin/fan/group/update/{slug}', [FanGroupController::class, 'updateFanGroup']);
    Route::delete('/admin/fan/group/delete/{slug}', [FanGroupController::class, 'deleteFanGroup']);
    Route::post('/admin/fan/member/approve/{joinMemberId}', [FanGroupController::class, 'approveFanMember']);
    Route::post('/admin/fan/member/post/{postId}', [FanGroupController::class, 'approveFanPost']);
    Route::post('/admin/fan/group/deline/nofification/{postId}', [FanGroupController::class, 'declineFanPostNotification']);

    Route::post('/admin/fan-group/join/{slug}/{data}', [FanGroupController::class, 'joinFanGroup']);
    Route::post('/admin/fan-group/post/{slug}/{data}', [FanGroupController::class, 'postFanGroup']);
    Route::post('/admin/fan/group/image/update/{slug}', [FanGroupController::class, 'updateImageFanGroup']);
    Route::post('/admin/fan-group/manager/approval/{slug}', [FanGroupController::class, 'fanGroupManagerApproval']);
    Route::get('/admin/fan/group/settings/delete/{fanJoinId}', [FanGroupController::class, 'deleteSettingsFan']);
    Route::post('/admin/fan/group/settings/no-warning/{warningId}', [FanGroupController::class, 'noWarningSettingsFan']);
    Route::post('/admin/fan/group/approval/warning/{fanUserId}/{fanGroupId}', [FanGroupController::class, 'warningSettingsFan']);

    // Marketplace Section
    Route::post('admin/marketplace/store', [MarketplaceController::class, 'marketplaceStore']);
    Route::get('/admin/marketplace/product-list/approved', [MarketplaceController::class, 'allProductList']);
    Route::get('/admin/marketplace/product-list/pending', [MarketplaceController::class, 'pendingProductList']);
    Route::get('/admin/marketplace/product-list/live', [MarketplaceController::class, 'liveProductList']);
    Route::get('/admin/marketplace/product-edit/{id}', [MarketplaceController::class, 'editAdminProductList']);
    Route::post('/admin/marketplace/product-store/{id}', [MarketplaceController::class, 'storeAdminProductList']);
    Route::get('/admin/marketplace/order/product-list', [MarketplaceController::class, 'orderAdminProductList']);
    Route::get('/admin/marketplace/order/product-list/view/{id}', [MarketplaceController::class, 'orderAdminProductListView']);
    Route::post('/admin/marketplace/order/product/status/{status}/{id}', [MarketplaceController::class, 'orderAdminProductListStatus']);


    // Souviner Section
    Route::post('/admin/souviner/store', [SouvinerController::class, 'souvinerStore']);
    Route::post('/admin/souviner/update/{id}', [SouvinerController::class, 'souvinerUpdate']);
    Route::get('/admin/souviner/view/{id}', [SouvinerController::class, 'souvinerView']);
    Route::get('/admin/souviner/check', [SouvinerController::class, 'souvinerCheck']);
    Route::get('/admin/souvenir/register/list', [SouvinerController::class, 'registerUserSouvenirList']);
    Route::get('/admin/souvenir/status/change/{status}/{souvenirId}', [SouvinerController::class, 'statusSouvenirChange']);
    Route::get('/admin/souvenir/register/approve/{id}', [SouvinerController::class, 'registerSouvenirApprove']);
    Route::get('/admin/souvenir/register/decline/{id}', [SouvinerController::class, 'registerSouvenirDecline']);
    Route::get('/admin/souvenir/apply/view/{id}', [SouvinerController::class, 'registerSouvenirView']);
    Route::get('/admin/souvenir/order/view/{id}', [SouvinerController::class, 'orderDetailsSouvenir']);

    // Simple Post Section
    Route::post('admin/add_simple_post', [SimplePostController::class, 'add']);
    Route::get('/admin/simple_post/all', [SimplePostController::class, 'all']);
    Route::post('/admin/simple_post/update/{id}', [SimplePostController::class, 'simplePostUpdate']);
    Route::get('/admin/simple_post/count', [SimplePostController::class, 'count']);
    Route::get('/admin/simple_post/pending', [SimplePostController::class, 'pending_list']);
    Route::get('/admin/simple_post/pending/{id}', [SimplePostController::class, 'pending_details']);
    Route::get('/admin/simple_post/approved', [SimplePostController::class, 'approved_list']);
    Route::get('/admin/simple_post/rejected', [SimplePostController::class, 'rejected_list']);



    // Live Session Section
    Route::get('/admin/livechat', [LiveChatController::class, 'admin_livechat']);
    Route::get('/admin/sinlgeLiveChat/{id}', [LiveChatController::class, 'admin_sinlgeLiveChat']);
    Route::get('/admin/livechatListByDate/{date}', [LiveChatController::class, 'admin_livechatListByDate']);
    Route::get('/admin/registeredUserList/{live_chat_id}', [LiveChatController::class, 'admin_registeredUserList']);


    // Question and Answers

    Route::post('/admin/add_qna', [QnaController::class, 'add_qna']);
    Route::get('/admin/pending/qna', [QnaController::class, 'pendingQna']);
    Route::get('/admin/qna/count', [QnaController::class, 'count']);
    Route::get('/admin/qna/{id}', [QnaController::class, 'details']);
    Route::get('/admin/qna_live', [QnaController::class, 'liveQnalist']);
    Route::get('/admin/qna_completed', [QnaController::class, 'qna_completed']);
    Route::get('/admin/qna_rejected', [QnaController::class, 'qna_rejected']);
    Route::get('/admin/registeredList/{id}', [QnaController::class, 'registeredList']);
    Route::post('/admin/admin_update_Qna', [QnaController::class, 'admin_update_Qna']);

    //Meetup Session Section
    Route::post('/admin/add_meetup', [MeetupEventController::class, 'add_by_admin']);
    Route::post('/admin/edit_meetup/{id}', [MeetupEventController::class, 'update_by_admin']);
    Route::get('/admin/meetup_event/pending', [MeetupEventController::class, 'pending_list']);
    Route::get('/admin/meetup_event/live', [MeetupEventController::class, 'live_list']);
    Route::get('/admin/meetup_event/completed', [MeetupEventController::class, 'completed']);
    Route::get('/admin/meetup_event/details/{id}', [MeetupEventController::class, 'details']);
    Route::get('/admin/meetup_event_slots/{slug}', [MeetupEventController::class, 'slots']);


    Route::post('/admin/add_livechat_profile', [LiveChatController::class, 'profile_create']);
    Route::get('/admin/livechat_event_profile', [LiveChatController::class, 'profile']);
    Route::post('/admin/live-chat/add', [LiveChatController::class, 'add_by_admin']);
    Route::post('/admin/live-chat/update', [LiveChatController::class, 'update_by_admin']);
    Route::get('/admin/live_chat/pending', [LiveChatController::class, 'pending_list']);
    Route::get('/admin/live_chat/live', [LiveChatController::class, 'live_list']);
    Route::get('/admin/live_chat/completed', [LiveChatController::class, 'completed_list']);
    Route::get('/admin/live-chat/details/{id}', [LiveChatController::class, 'details']);
    Route::get('/admin/live-chat/registered_user_list/{id}', [LiveChatController::class, 'slots']);
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
    Route::get('/admin/rejected/auction/product', [AuctionController::class, 'rejectedProduct']);
    Route::get('/admin/live/allProduct', [AuctionController::class, 'allLiveProduct']);
    Route::get('/admin/liveBidding/auction/{auction_id}', [AuctionController::class, 'liveBidding']);
    Route::get('/admin/topBidder/auction/{auction_id}', [AuctionController::class, 'topBidder']);
    Route::post('/admin/topBidder/auction/notify', [AuctionController::class, 'notify_bidder']);
    Route::get('/admin/allBidderList/auction/{id}', [AuctionController::class, 'allBidderList']);
    Route::post('/admin/winner/auction/{id}', [AuctionController::class, 'makeWinner']);
    Route::post('/admin/topBidder/auction/reject/{id}', [AuctionController::class, 'rejectBidder']);
    Route::get('/admin/bidderInfo/auction/{id}', [AuctionController::class, 'bidderInfo']);

    // audition routes

    Route::get('/admin/auditions', [AuditionController::class, 'getAdminAuditions']);
    Route::get('/admin/audition/details/{id}', [AuditionController::class, 'starAdminDetailsAudition']);


    // Promo Videos
    Route::get('/admin/promoVideo/all', [PromoVideoController::class, 'adminAllPromoVideos']);
    Route::post('/admin/promoVideo/store', [PromoVideoController::class, 'videoStore']);
    Route::get('/admin/promoVideo/edit/{id}', [PromoVideoController::class, 'adminEdit']);
    Route::post('/admin/promoVideo/update', [PromoVideoController::class, 'adminUpdate']);
    Route::get('/admin/promoVideo/pending', [PromoVideoController::class, 'pendingVideos']);
    Route::get('/admin/promoVideoApproved', [PromoVideoController::class, 'approvedVideos']);
    Route::get('/admin/promoVideo/{promo_id}', [PromoVideoController::class, 'videoDetails']);
    Route::get('/admin/promoVideoLive', [PromoVideoController::class, 'liveVideos']);
    Route::get('/admin/promoVideoReject', [PromoVideoController::class, 'rejectVideos']);
    Route::get('/admin/promoVideoCount', [PromoVideoController::class, 'promoVideoCount']);
    //Category
    Route::get('/admin/view-category', [CategoryController::class, 'index']);
});

Route::get('/star/registeredUserList/{live_chat_id}', [LiveChatController::class, 'registeredUserList']);



// Approved Superstar Middleware
Route::middleware(['auth:sanctum', 'isAPIStar'])->group(function () {
    Route::get('/checkingSuperStar', function () {
        return response()->json(['message' => 'You are in as Superstar', 'status' => 200], 200);
    });

    //********************************************//
    //******Learning Session Routes Start *******//
    //********************************************//

    Route::get('/star/learning_session/registered_user/{id}', [LearningSessionController::class, 'registured_user']);
    Route::get('/star/learning_session/allInOneMobile', [LearningSessionController::class, 'allInOneMobileLearning']);
    Route::post('/star/learning_session/create', [LearningSessionController::class, 'star_add']);
    Route::post('/star/update_learning_session/{id}', [LearningSessionController::class, 'update']);
    Route::get('/star/learning_session/all', [LearningSessionController::class, 'star_all']);
    Route::get('/star/learning_session/count', [LearningSessionController::class, 'star_count']);
    Route::get('/star/learning_session/pending', [LearningSessionController::class, 'star_pending_list']);
    Route::get('/star/learning_session/pending/{id}', [LearningSessionController::class, 'star_pending_details']);
    Route::get('/star/learning_session/approved', [LearningSessionController::class, 'star_approved_list']);
    Route::get('/star/learning_session/reject', [LearningSessionController::class, 'star_reject_list']);
    Route::get('/star/learning_session/approve/{id}', [LearningSessionController::class, 'approve_post']);
    Route::get('/star/learning_session/reject/{id}', [LearningSessionController::class, 'reject']);
    Route::get('/star/learning_session/completed', [LearningSessionController::class, 'star_completed_list']);
    Route::get('/star/learning_session/evaluation', [LearningSessionController::class, 'star_evaluation_list']);
    Route::get('/star/learning_session/details/{id}', [LearningSessionController::class, 'details']);
    Route::get('/star/learning_session/assignment/{id}', [LearningSessionController::class, 'star_assignment_details']);
    Route::post('/star/learning_session/add_assignment_rules', [LearningSessionController::class, 'assignment_rule_add']);
    Route::post('/star/learning_session/assignment/approval/{type}/{id}', [LearningSessionController::class, 'star_assignment_set_approval']);
    Route::get('/star/learning_session/result', [LearningSessionController::class, 'starShowLearninSessionResult']);
    Route::get('/star/learning_session/showResult/{eventId}', [LearningSessionController::class, 'starShowLearninSessionResultData']);

    //Learning Session For Mobile
    Route::post('/star/mobile/learning_session/create', [LearningSessionController::class, 'star_add_mobile']);

    //********************************************//
    //******Learning Session Routes End *******//
    //********************************************//
    Route::get('star/getInformation', [DashboardController::class, 'getInformation']);
    Route::get('star/dashboard/posts/{type}', [DashboardController::class, 'adminPost']);
    Route::get('star/dashboard/post-details/{id}/{type}', [DashboardController::class, 'postDeatils']);
    Route::get('star/dashboard/mobile', [DashboardController::class, 'starDashboardCount']);
    Route::get('star/dashboard', [DashboardController::class, 'adminDashboard']);
    Route::get('star/dashboard/posts/{type}', [DashboardController::class, 'dashboardPosts']);
    Route::get('star/dashboard/post-details/{id}/{type}', [DashboardController::class, 'postDeatils']);
    Route::get('/livechat', [LiveChatController::class, 'livechat']);
    Route::get('/sinlgeLiveChat/{id}', [LiveChatController::class, 'sinlgeLiveChat']);
    Route::get('star/profitShare', [DashboardController::class, 'profitShare']);
    Route::post('/star/profit/withdraw', [DashboardController::class, 'profitWithdraw']);

    //notification
    Route::get('star/notification', [DashboardController::class, 'notification']);
    Route::get('star/notificationCount', [DashboardController::class, 'notificationCount']);

    // schdedule
    Route::post('/star/addScheduleMobile', [StarScheduleController::class, 'addSchedule']);
    Route::post('/star/add_schedule/', [StarScheduleController::class, 'add_schedule']);
    Route::get('/star/schedule', [StarScheduleController::class, 'selected_schedule']);
    Route::get('/star/schedule/{date}', [StarScheduleController::class, 'dateWiseSchedule']);
    Route::get('/star/schedule_list', [StarScheduleController::class, 'schedule_list']);
    Route::get('/star/current_month_schedule_list', [StarScheduleController::class, 'current_month_schedule_list']);
    Route::get('/star/deleteSchedule/{id}', [StarScheduleController::class, 'deleteSchedule']);
    Route::get('/star/schedule/notification', [StarScheduleController::class, 'notification']);

    // Fan Group Section
    Route::get('star/fan/group/starlist/status', [FanGroupController::class, 'statusStar']);
    Route::post('star/fan/group/update/{slug}', [FanGroupController::class, 'starUpdate']);
    Route::get('star/fan/group/details/{slug}', [FanGroupController::class, 'fanGroupDetails']);
    Route::get('star/fan/group/active/{slug}', [FanGroupController::class, 'fanGroupActive']);
    Route::get('star/fan/group/ignore/{slug}', [FanGroupController::class, 'fanGroupIgnore']);
    Route::get('/star/fan/group/show/{slug}', [FanGroupController::class, 'showStarFanGroup']);
    Route::post('/star/fan/member/approve/{joinMemberId}', [FanGroupController::class, 'approveFanMember']);
    Route::post('/star/fan/member/post/{postId}', [FanGroupController::class, 'approveFanPost']);
    Route::post('/star/fan-group/join/{slug}/{data}', [FanGroupController::class, 'joinFanGroup']);
    Route::post('/star/fan-group/post/{slug}/{data}', [FanGroupController::class, 'postFanGroup']);
    Route::post('/star/fan/group/image/update/{slug}', [FanGroupController::class, 'updateImageFanGroup']);
    Route::get('/star/fan/group/settings/delete/{fanJoinId}', [FanGroupController::class, 'deleteSettingsFan']);
    Route::post('/star/fan/group/settings/no-warning/{warningId}', [FanGroupController::class, 'noWarningSettingsFan']);
    Route::post('/star/fan/group/approval/warning/{fanUserId}/{fanGroupId}', [FanGroupController::class, 'warningSettingsFan']);
    Route::get('/star/fan/group/analytics/{slug}', [FanGroupController::class, 'showFanGroupAnalytics']);
    Route::post('/star/fan/group/deline/nofification/{postId}', [FanGroupController::class, 'declineFanPostNotification']);

    // StarShowCase API for Mobile count
    Route::get('/star/showcase/count/mobile', [DashboardController::class, 'starShowCaseProductsCount']);
    Route::get('/star/showcase/MarketplaceProductMobile/mobile', [MarketplaceController::class, 'MarketplaceProductMobile']);
    Route::post('star/marketplace/store/mobile', [MarketplaceController::class, 'starMarketplaceStoreMobile']);
    Route::get('/star/getStarAuctionProduct/{product_id}', [UserController::class, 'starAuctionProduct']);
    Route::get('/star/liveBidding/auction/{auction_id}', [AuctionController::class, 'liveBidding']);

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
    Route::get('/star/simple_post/all/mobile', [SimplePostController::class, 'star_all_mobile']);
    Route::post('/star/add_simple_post/mobile', [SimplePostController::class, 'star_add_mobile']);
    Route::post('/star/add_simple_post', [SimplePostController::class, 'star_add']);
    Route::get('/star/simple_post/all', [SimplePostController::class, 'star_all']);
    Route::get('/star/simple_post/count', [SimplePostController::class, 'star_count']);
    Route::get('/star/simple_post/pending', [SimplePostController::class, 'star_pending_list']);
    Route::get('/star/simple_post/pending/{id}', [SimplePostController::class, 'star_pending_details']);
    Route::post('/star/simple_post/update/{id}', [SimplePostController::class, 'star_post_update']);
    Route::get('/star/simple_post/approved', [SimplePostController::class, 'star_approved_list']);
    Route::get('/star/approve_post/{id}', [SimplePostController::class, 'approve_post']);
    Route::get('/star/decline_post/{id}', [SimplePostController::class, 'decline_post']);

    // Souviner Section
    Route::post('/star/souviner/store/mobile', [SouvinerController::class, 'souvinerStarStoreMobile']);
    Route::post('/star/souviner/store', [SouvinerController::class, 'souvinerStarStore']);
    Route::get('/star/souviner/check', [SouvinerController::class, 'souvinerStarCheck']);
    Route::get('/star/souviner/edit/{id}', [SouvinerController::class, 'souvinerStarEdit']);
    Route::post('/star/souviner/update/{id}', [SouvinerController::class, 'souvinerStarUpdate']);
    Route::post('/star/souviner/approve/{id}', [SouvinerController::class, 'souvinerStarApprove']);
    Route::post('/star/souviner/decline/{id}', [SouvinerController::class, 'souvinerStarDecline']);
    Route::get('/star/souvenir/register/list', [SouvinerController::class, 'starRegisterUserSouvenirList']);
    Route::get('/star/souvenir/register/approve/{id}', [SouvinerController::class, 'registerSouvenirApprove']);
    Route::get('/star/souvenir/register/decline/{id}', [SouvinerController::class, 'registerSouvenirDecline']);
    Route::get('/star/souvenir/apply/view/{id}', [SouvinerController::class, 'registerSouvenirView']);



    // Question and Answers
    Route::get('/star/qna/allInOneMobile', [QnaController::class, 'allInOneMobileQna']);
    Route::post('/star/qna/add_qna_mobile', [QnaController::class, 'star_add_qna_mobile']);
    Route::post('/star/add_qna', [QnaController::class, 'star_add_qna']);
    Route::get('/star/pending/qna', [QnaController::class, 'star_pendingQna']);
    Route::get('/star/qna/count', [QnaController::class, 'star_count']);
    Route::get('/star/qna/{slug}', [QnaController::class, 'star_details']);
    Route::get('/star/qna_live', [QnaController::class, 'star_liveQnalist']);
    Route::get('/star/qna_completed', [QnaController::class, 'star_qna_completed']);
    Route::get('/star/qna_details/{id}', [QnaController::class, 'qna_details']);
    Route::get('/star/qna/approved/{id}', [QnaController::class, 'setApprovedQna']);
    Route::get('/star/qna/rejected/{id}', [QnaController::class, 'setRejectedQna']);
    Route::post('/star/update_Qna', [QnaController::class, 'update_Qna']);
    Route::get('/star/registeredList/{id}', [QnaController::class, 'QnaRegisteredList']);
    Route::get('/star/qna_enrolluser_status_update/{id}', [QnaController::class, 'QnaUserStatusUpdate']);





    // Live Session Section
    Route::get('/star/live-chat/registered_user_list/{id}', [LiveChatController::class, 'slots']);
    Route::get('/star/live-chat/{type}', [LiveChatController::class, 'liveChatList']);
    // Route::get('/star/live-chat/registered_user_list/{slug}', [LiveChatController::class, 'slots']);
    Route::get('/star/live-chat/details/{id}', [LiveChatController::class, 'details']);
    Route::get('/star/live-chat/setApprove/{id}', [LiveChatController::class, 'setApproveLiveChat']);
    Route::get('/star/live-chat/setReject/{id}', [LiveChatController::class, 'set_reject_by_star']);

    Route::post('/star/add_live_session', [LiveChatController::class, 'add_by_star']);
    Route::post('/star/update_live_session', [LiveChatController::class, 'update_by_star']);
    Route::get('/livechatListByDate/{date}', [LiveChatController::class, 'livechatListByDate']);
    Route::get('/star/liveChat/allInOneMobile', [LiveChatController::class, 'allInOneMobileLiveChat']);


    // Meetup Event Section
    Route::get('/star/meetup_event/mobile/count', [MeetupEventController::class, 'star_meetup_list_count']);
    Route::get('/star/meetup_event/{type}', [MeetupEventController::class, 'star_meetup_list']);
    Route::post('/star/add_meetup/mobile', [MeetupEventController::class, 'star_add_meetup_mobile']);
    Route::post('/star/add_meetup', [MeetupEventController::class, 'star_add_meetup']);
    Route::get('/star/meetup_event/details/{id}', [MeetupEventController::class, 'details']);
    Route::get('/star/meetup_event/set_approve/{id}', [MeetupEventController::class, 'set_approve']);
    Route::get('/star/rejectMeetup/{id}', [MeetupEventController::class, 'set_reject']);
    Route::post('/star/meetup_event/edit/{id}', [MeetupEventController::class, 'star_edit']);
    Route::get('/star/meetup_event_slots/{slug}', [MeetupEventController::class, 'starSlots']);

    Route::get('/star/live_chat/count', [LiveChatController::class, 'count2']);

    // star greeting related list
    Route::post('/star/add_greetings/mobile', [StarGreetingController::class, 'add_greetings_mobile']);
    Route::post('/star/add_greetings', [StarGreetingController::class, 'add_greetings']);
    Route::post('/star/edit_greetings', [StarGreetingController::class, 'edit_greetings']);
    Route::get('/star/approve_greeting/{greeting_id}', [StarGreetingController::class, 'approve_greeting']);
    Route::get('/star/decline_greeting/{greeting_id}', [StarGreetingController::class, 'decline_greeting']);
    Route::get('/star/greetings_star_status', [StarGreetingController::class, 'greetings_star_status']);

    //user greetings register list
    // Route::get('/star/greetings_reg_list/{greetings_id}', [StarGreetingController::class, 'greetingsRegisterListByGreetingsId']);
    // Route::get('/star/greetings_reg_payment_list', [StarGreetingController::class, 'greetingsRegisterWithPaymentList']);
    // Route::get('/star/greetings', [StarGreetingController::class, 'view_star_greeting']);
    Route::get('/star/allGreetingInfo/mobile', [StarGreetingController::class, 'allGreetingInfo']);
    Route::get('/star/greetings_register_list_with_payment_complete', [StarGreetingController::class, 'registerListWithPaymentComplete']);
    Route::get('/star/greetings_video_uploaded_list', [StarGreetingController::class, 'greetingsVideoUploadedList']);
    Route::get('/star/greetings_forwarded_to_user_list', [StarGreetingController::class, 'greetingsForwardedToUserList']);
    Route::get('/star/single_greeting_registration/{greeting_registration_id}', [StarGreetingController::class, 'singleGreetingRegistration']);
    Route::post('/star/greeting_video_upload', [StarGreetingController::class, 'videoUpload']);

    //<======================== Auction Route ========================>

    Route::get('/star/add/auction/product/mobile', [AuctionController::class, 'auctionHomeMobile']);
    Route::post('/star/add/auction/mobile', [AuctionController::class, 'star_addProduct_mobile']);
    Route::post('/star/add/auction/product', [AuctionController::class, 'star_addProduct']);
    Route::get('/star/editOrConfirm/auction/editOrConfirm/{id}', [AuctionController::class, 'star_editOrConfirm']);
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


    // Super Star Audition Routes
    Route::get('superstar/audition/mobile', [JudgeAuditionController::class, 'auditionDashboardMobile']);
    Route::get('superstar/audition/promo-instruction-pending', [JudgeAuditionController::class, 'starPromoInstructionPending']);
    Route::get('superstar/audition/by-promo-instruction-pending/{id}', [JudgeAuditionController::class, 'starAuditionByPromoInstructionPending']);
    Route::get('superstar/audition/get-round-instruction-by-judge/{audition_id}/{round_id}', [JudgeAuditionController::class, 'getRoundInstructionByJudge']);
    Route::post('superstar/audition/by-promo-instruction-update', [JudgeAuditionController::class, 'starAuditionByPromoInstructionUpdate']);
    Route::post('superstar/audition/by-round-instruction-update', [JudgeAuditionController::class, 'starAuditionByRoundInstructionUpdate']);
    Route::get('superstar/audition/pendings', [JudgeAuditionController::class, 'starPendingAudtion']);
    Route::get('superstar/audition/live', [JudgeAuditionController::class, 'starLiveAudtion']);
    Route::get('superstar/audition/details/{audition_id}', [JudgeAuditionController::class, 'starAudtionDetails']);
    Route::get('/star/pending-audition/{id}', [JudgeAuditionController::class, 'starSingleAudition']);
    Route::put('/star/approved/audition/{id}', [JudgeAuditionController::class, 'starApprovedAudition']);
    Route::put('/star/decline/audition/{id}', [JudgeAuditionController::class, 'starDeclineAudition']);
    Route::post('/star/audition/video/marking', [JudgeAuditionController::class, 'judgeVideoMarking']);

    Route::get('/star/selectVideo/{id}', [AuditionController::class, 'getStarVideos']);
    Route::post('/star/starMarking', [AuditionController::class, 'starMarking']);

    Route::get('/superstar/audition/videos/{round_info_id}', [JudgeAuditionController::class, 'round_judges_videos']);
    Route::get('superstar/audition/liveEditInstructions/{audition_id}', [JudgeAuditionController::class, 'liveEditInstructions']);
    Route::post('superstar/audition/updateAuditionInstruction/{audition_instruction_id}', [JudgeAuditionController::class, 'updateAuditionInstruction']);
    //srabon
    Route::get('superstar/audition/pending/roundInstructionVideos', [JudgeAuditionController::class, 'pendingRoundInstructionVideo']);
    Route::get('superstar/audition/pending/roundInstructionVideosAccepted', [JudgeAuditionController::class, 'acceptedRoundInstructionVideo']);
    Route::get('superstar/audition/round-instruction-video/details/{id}', [JudgeAuditionController::class, 'roundInstructionVideoDetails']);
    Route::post('superstar/audition/round-instruction-video/update/{id}', [JudgeAuditionController::class, 'roundInstructionVideoUpdate']);

    // Partha ghose
    Route::get('/superstar/promotional/video/list', [AuditionController::class, 'judgePromotionalList']);
    Route::get('/superstar/promotional/accepted/video/list', [AuditionController::class, 'acceptedJudgePromotionalList']);
    Route::post('/superstar/audition/promotional/video/store', [AuditionController::class, 'superstarPromotionalVideoStore']);
    Route::get('/superstar/audition/promotional/video/view/{id}', [AuditionController::class, 'judgePromotionalView']);

    Route::get('/superstar/audition/view', [AuditionController::class, 'getAllAudition']);

    Route::get('/superstar/audition/promotional/video/accepted/{id}', [AuditionController::class, 'judgePromotionalViewAccepted']);
    Route::get('/superstar/audition/promotional/video/declined/{id}', [AuditionController::class, 'judgePromotionalViewDecline']);
    Route::get('/superstar/audition/promotional/video/check/{auditionId}', [AuditionController::class, 'judgePromotionalVideoCheck']);

    // Promo Vidoes
    Route::get('/star/promoVideo/all', [PromoVideoController::class, 'starPromovideoAll']);
    Route::post('/star/promoVideo/store', [PromoVideoController::class, 'starPromovideoStore']);
    Route::get('/star/promoVideo/pending', [PromoVideoController::class, 'starPromopendingVideos']);
    Route::get('/star/promoVideoApproved', [PromoVideoController::class, 'starPromoApprovedVideos']);
    Route::get('/star/promoVideoReject', [PromoVideoController::class, 'starPromoRejectedVideos']);
    Route::get('/star/promoVideo/edit/{id}', [PromoVideoController::class, 'edit']);
    Route::post('/star/promoVideo/update', [PromoVideoController::class, 'update']);
    Route::get('/star/promoVideo/pending/{id}', [PromoVideoController::class, 'starVideosDetails']);
    Route::get('/star/promoVideoLive', [PromoVideoController::class, 'starPromoliveVideos']);
    Route::get('/star/promoVideo/count', [PromoVideoController::class, 'starPromoVideoCount']);
    Route::get('/star/promoVideo/approved/{id}', [PromoVideoController::class, 'starPromoVideoApproved']);
    Route::get('/star/promoVideo/decline/{id}', [PromoVideoController::class, 'starPromoVideoDecline']);
});


// Approved Star Audition Admin Middleware
Route::middleware(['auth:sanctum', 'isAPIAuditionAdmin'])->group(function () {

    Route::get('/checkingAuditionAdmin', function () {
        return response()->json(['message' => 'You are in as Audition Admin', 'status' => 200], 200);
    });

    Route::get('audition-admin/dashboard/posts/{type}', [DashboardController::class, 'dashboardPosts']);
    Route::get('audition-admin/dashboard/total-income', [DashboardController::class, 'auditionIncome']);
    Route::get('audition-admin/dashboard/post-details/{id}/{type}', [DashboardController::class, 'postDeatils']);
    Route::get('audition-admin/dashboard/audition/count', [DashboardController::class, 'auditionCount']);
    Route::get('audition-admin/dashboard/audition/roundInfo/{id}', [DashboardController::class, 'auditionRoundInfos']);

    Route::get('/audition-admin/audition/events', [AuditionController::class, 'events']);
    Route::post('/audition-admin/audition/status/update', [AuditionController::class, 'statusUpdate']);
    Route::post('/audition-admin/audition/post-content/store', [AuditionController::class, 'storePostContent']);
    Route::get('/audition-admin/audition/post_list', [AuditionController::class, 'postList']);
    Route::get('/audition-admin/audition/count', [AuditionController::class, 'count']);
    Route::post('/audition-admin/audition/assign-juries', [AuditionController::class, 'assignJuries']);
    Route::post('/audition-admin/audition/assign-judges', [AuditionController::class, 'assignJudges']);
    Route::get('/audition-admin/audition/singleAuditionRounds/{audition_id}', [AuditionController::class, 'singleAuditionRounds']);
    Route::get('/audition-admin/audition/singleAuditionRoundWithRoundId/{audition_id}/{audition_round_id}', [AuditionController::class, 'singleAuditionRoundWithRoundId']);
    Route::get('/audition-admin/audition/singleAuditionApprovedVideoWithRoundId/{audition_id}/{audition_round_info_id}', [AuditionController::class, 'singleAuditionApprovedVideoWithRoundId']);
    Route::get('/audition-admin/audition/appealApprovedVideoWithRoundId/{audition_id}/{audition_round_info_id}', [AuditionController::class, 'appealApprovedVideoWithRoundId']);
    Route::get('/audition-admin/audition/singleAuditionRoundAssessmentResult/{audition_id}/{audition_round_info_id}/{type}', [AuditionController::class, 'singleAuditionRoundAssessmentResult']);
    Route::get('/audition-admin/audition/singleAuditionRoundVideoMerge/{audition_id}/{audition_round_info_id}/{type}', [AuditionController::class, 'singleAuditionRoundVideoMerge']);
    Route::get('/audition-admin/audition/singleAuditionRoundVideoResultByPercentage/{audition_id}/{audition_round_info_id}/{precentage}/{type}', [AuditionController::class, 'singleAuditionRoundVideoResultByPercentage']);
    Route::get('/audition-admin/audition/singleAuditionRoundVideoResultByFilterNumber/{audition_id}/{audition_round_info_id}/{filter_number}/{type}', [AuditionController::class, 'singleAuditionRoundVideoResultByFilterNumber']);
    Route::get('/audition-admin/audition/videoReportBasedOnSingleJury/{audition_id}/{audition_round_info_id}/{jury_id}/{type}', [AuditionController::class, 'videoReportBasedOnSingleJury']);
    Route::get('/audition-admin/audition/singleAuditionVideoWithRoundId/{audition_id}/{audition_round_id}', [AuditionController::class, 'singleAuditionVideoWithRoundId']);
    Route::get('/audition-admin/audition/singleAuditionInstruction/{instruction_id}', [AuditionController::class, 'singleAuditionInstruction']);
    Route::post('/audition-admin/audition/promo-instruction/store', [AuditionController::class, 'storePromoInstruction']);
    Route::get('/audition-admin/audition/promo-instruction/{audition_id}', [AuditionController::class, 'promoInstrucction']);
    Route::post('/audition-admin/audition/super-star-promo/store', [AuditionController::class, 'superStarStorePromo']);
    Route::post('/audition-admin/audition/promotional/video/store', [AuditionController::class, 'promotionalVideoStore']);
    Route::get('/audition-admin/promotional/video', [AuditionController::class, 'promotionalList']);
    Route::get('/audition-admin/promotional/video/view/{id}', [AuditionController::class, 'auditionJudgePromotionalView']);
    Route::get('/audition-admin/promotional/accepted-video', [AuditionController::class, 'acceptedPromotionalList']);
    Route::post('/audition-admin/audition/round-instruction/store', [AuditionController::class, 'storeRoundInstruction']);
    Route::post('/audition-admin/audition/round-instruction/update', [AuditionController::class, 'updateRoundInstruction']);
    Route::get('/audition-admin/audition/get-round-instruction/{audition_id}/{round_info_id}', [AuditionController::class, 'getRoundInstruction']);
    Route::get('audition-admin/audition/get-round-info/{audition_id}/{round_info_id}/{type}', [AuditionController::class, 'getRoundInfo']);
    Route::get('audition-admin/audition/get-jury-percentage-videos/{audition_id}/{round_info_id}/{value}/{type}', [AuditionController::class, 'getPercentageVideoForJury']);
    Route::get('audition-admin/audition/get-jury-random-videos/{audition_id}/{round_info_id}/{value}/{type}', [AuditionController::class, 'getRandomForJury']);
    Route::post('/audition-admin/audition/promo-instruction/update', [AuditionController::class, 'updatePromoInstruction']);
    Route::post('/audition-admin/audition/assign-main-juries-for-percentage', [AuditionController::class, 'assignMainJuriesForPercentage']);
    Route::post('/audition-admin/audition/assign-main-juries', [AuditionController::class, 'assignMainJuries']);
    Route::get('/audition-admin/audition/videos/{round_info_id}', [AuditionController::class, 'round_videos']);
    Route::get('/audition-admin/audition/appeal-videos/{round_info_id}', [AuditionController::class, 'round_appeal_videos']);
    Route::post('/audition-admin/audition/videos/set_approved/{id}', [AuditionController::class, 'round_videos_set_approved']);
    Route::post('/audition-admin/audition/videos/set_reject/{id}', [AuditionController::class, 'round_videos_set_reject']);
    Route::post('/audition-admin/audition/round-instruction-video/store', [AuditionController::class, 'storeRoundInstructionVideo']);
    Route::get('/audition-admin/audition/round-instruction-video/list', [AuditionController::class, 'storeRoundInstructionVideoList']);
    Route::get('/audition-admin/audition/round-instruction-video/accept-list', [AuditionController::class, 'acceptRoundInstructionVideoList']);
    Route::get('/audition-admin/audition/round-instruction-video/details/{id}', [AuditionController::class, 'getVideoDetails']);
    Route::post('/audition-admin/audition/sendDummyInstructionToJudges', [AuditionController::class, 'sendDummyInstructionToJudges']);
    Route::get('/audition-admin/audition/pendings', [AuditionController::class, 'pending']);
    Route::get('/audition-admin/audition/request', [AuditionController::class, 'request']);
    Route::get('/audition-admin/assigned-audition', [AuditionController::class, 'assignedAudition']);
    Route::get('/audition-admin/audition/lives', [AuditionController::class, 'live']);
    Route::get('/audition-admin/audition/online-round', [AuditionController::class, 'onlineRound']);
    Route::get('/audition-admin/audition_single/{slug}', [AuditionController::class, 'getAudition']);
    Route::get('/audition-admin/audition_single_by_id/{audition_id}', [AuditionController::class, 'getAuditionById']);
    Route::get('/audition-admin/audition/round-instruction-judges/{audition_id}/{round_id}', [AuditionController::class, 'getRoundInstructionJudges']);
    Route::get('/audition-admin/audition/total-judge-approval/{slug}', [AuditionController::class, 'totalJudgeApproval']);
    Route::get('audition-admin/audtion-videos/{audition_id}', [AuditionController::class, 'getAuditionVideos']);
    Route::post('audition-admin/filter-video/submit', [AuditionController::class, 'submitFilterVideo']);
    Route::get('audition-admin/accepted-videos/{audition_id}', [AuditionController::class, 'acceptedVideo']);
    Route::get('audition-admin/rejected-videos/{audition_id}', [AuditionController::class, 'rejectedVideo']);
    Route::post('audition-admin/send-manager-admin', [AuditionController::class, 'videoSendManagerAdmin']);
    Route::get('/audition-admin/participant/list/{id}', [AuditionController::class, 'participantList']);
    Route::post('audition-admin/audition-round-instruction', [AuditionController::class, 'saveRoundInstruction']);
    Route::get('audition-admin/audition/group_juries/{audition_id}/{group_id}', [AuditionController::class, 'group_juries']);
    Route::post('audition-admin/audition/roundResultSendToManager', [AuditionController::class, 'roundResultSendToManager']);

    Route::get('audition-admin/audition/judgeMark/{audition_id}/{round_info_id}', [AuditionController::class, 'getJudgeMark']);
    Route::get('audition-admin/audition/auditionRoundVideoMerge/{audition_id}/{round_info_id}', [AuditionController::class, 'makeRoundResultMerge']);
    Route::get('audition-admin/audition/getEligibleParticipant/{audition_id}/{round_info_id}', [AuditionController::class, 'getEligibleParticipant']);
    Route::post('audition-admin/audition/uploadLiveUserVideo', [AuditionController::class, 'liveAuditionVideoUpload']);
    Route::post('audition-admin/audition/liveJudgeMarkUpload', [AuditionController::class, 'liveJudgeMarkUpload']);
    Route::get('audition-admin/audition-mark/uploadedVideo/{user_id}/{audition_id}/{round_info_id}', [AuditionController::class, 'userUploadedVideos']);
    Route::get('audition-admin/audition-wildcard-mark/wildcardLoveReact/{audition_id}/{round_info_id}', [AuditionController::class, 'wildcardLoveReact']);
    Route::post('audition-admin/audition/wildcardResultSendToManager', [AuditionController::class, 'wildcardResultSendToManager']);
    Route::post('audition-admin/audition/OxygenVideoUpload', [AuditionController::class, 'OxygenVideoUpload']);
    Route::get('audition-admin/audition/oxygen-reply-videos/{audition_id}/{round_info_id}/{user_id}', [AuditionController::class, 'getReplyVideos']);
    Route::get('audition-admin/audition/make-oxygen-winner/{audition_id}/{round_info_id}/{user_id}', [AuditionController::class, 'makeOxygenWinner']);
    Route::post('audition-admin/audition/make-certificate/{audition_id}', [AuditionController::class, 'makeCertificate']);
});


// Approved Jury Board Middleware
Route::middleware(['auth:sanctum', 'isAPIJuryBoard'])->group(function () {

    Route::get('/checkingJurySuperStar', function () {
        return response()->json(['message' => 'You are in as Jury Audition', 'status' => 200], 200);
    });

    Route::get('/jury-board/dashboard/posts/{type}', [DashboardController::class, 'juryDashboard']);
    Route::get('/jury/dashboard/post-details/{id}/{type}', [DashboardController::class, 'postDeatils']);
    Route::get('/jury/dashboard/audition/roundInfo/{id}', [DashboardController::class, 'auditionRoundInfosJury']);
    Route::get('/jury/audition/lives', [JuryAuditionController::class, 'live']);
    Route::post('/jury/audition/mark-assessment', [JuryAuditionController::class, 'markAssessment']);
    Route::post('/jury/audition/mark-assessment-as-main-group', [JuryAuditionController::class, 'markAssessmentAsMainGroup']);
    Route::get('/jury/audition/singleAuditionVideos/{audition_id}', [JuryAuditionController::class, 'singleAuditionVideos']);
    Route::get('/jury/audition/singleAuditionVideoWithRoundId/{audition_id}/{audition_round_id}', [JuryAuditionController::class, 'singleAuditionVideoWithRoundId']);
    Route::post('/jury/audition/videoStatusChange', [JuryAuditionController::class, 'videoStatusChange']);
    Route::get('/jury/audition/singleAuditionVideoAssessmentWithRound/{audition_id}/{audition_round_info_id}/{type}', [JuryAuditionController::class, 'singleAuditionVideoAssessmentWithRound']);
    Route::get('/jury/audition/VideoAssessmentAsMainGroupWithRound/{audition_id}/{audition_round_info_id}/{type}', [JuryAuditionController::class, 'VideoAssessmentAsMainGroupWithRound']);
    Route::get('/jury/audition/{slug}', [JuryAuditionController::class, 'getAudition']);
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
Route::get('star-instrucation', [StarAuthController::class, 'starInstrucation']);

Route::post('star_qr_verify', [StarAuthController::class, 'qr_verify']);

Route::post('star_register', [StarAuthController::class, 'register']);
Route::post('star/image-upload', [StarAuthController::class, 'MobileImageUp']);

// Route for Jury Board Panel
Route::post('jury-register', [JuryAuthController::class, 'register']);
Route::get('view-category', [CategoryController::class, 'index']);

/**
 * all category show for moble user registation
 */
Route::get('view-category-mobile', [CategoryController::class, 'ViewAllCategory']);

Route::get('/user/subcategory/{id}', [CategoryController::class, 'allSubcategoryList']);
Route::get('/user/left/subcategory/{slug}', [CategoryController::class, 'allLeftSubcategoryList']);
Route::get('/user/starcategory/{id}', [CategoryController::class, 'allStarCategoryList']);
Route::get('/user/selected/some/category/{id}', [CategoryController::class, 'allSelectedCategoryList']);
Route::get('/user/selected/starcategory', [CategoryController::class, 'starFollowingList']);
Route::get('/user/selected/category', [CategoryController::class, 'selectedCategory']);
Route::get('/user/sub/category', [CategoryController::class, 'allSubCategory']);
Route::post('/user/selected/category/store', [CategoryController::class, 'selectedCategoryStore']);
Route::post('/user/selected/subcategory/store', [CategoryController::class, 'selectedSubCategoryStore']);
Route::post('/user/selected/starcategory/store', [CategoryController::class, 'selectedStarCategoryStore']);
Route::get('/user/star/category/{slug}', [CategoryController::class, 'selectedStarCategoryList']);
Route::get('subcategory/{slug}', [SubCategoryController::class, 'index']);

Route::get('/user/star-details/{id}', [StarAuthController::class, 'star_details']);


Route::post('select_category', [CategoryController::class, 'select_category']);
Route::get('fetch-subcategory/{id}', [CategoryController::class, 'fetch_subcategory']);


Route::post('select_sub_category', [SubCategoryController::class, 'select_sub_category']);
Route::get('fetch-star/{id}', [SubCategoryController::class, 'fetch_subcategory']);
Route::post('select_star', [SubCategoryController::class, 'select_star']);
Route::post('submit_react/{id}', [UserController::class, 'submit_react']);
Route::get('check_react/{id}', [UserController::class, 'check_react']);
Route::get('checkchoice', [CategoryController::class, 'check']);

//<======================== Admin DashBoard ========================>

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

Route::get('/user_info/{id}', [AuthController::class, 'user_data']);





require __DIR__ . '/userMobileAppApi.php';
