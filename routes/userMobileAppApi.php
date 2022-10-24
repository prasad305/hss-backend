<?php

use App\Http\Controllers\API\UserMobileAppController;
use App\Http\Controllers\API\MarketplaceMobileAppController;
use App\Http\Controllers\API\AuthController;
use Illuminate\Support\Facades\Route;


// Registered & Verified User Middleware
Route::middleware(['auth:sanctum', 'isAPIUser'])->group(function () {

    Route::group(['prefix' => 'user/', 'as' => 'user.'], function () {
        Route::post('event-register', [UserMobileAppController::class, 'eventRegister']);
        Route::group(['prefix' => 'mobile-app/', 'as' => 'mobileApp.'], function () {
            Route::get('greeting-status/{star_id}', [UserMobileAppController::class, 'greetingStatus']);
            Route::get('menu', [UserMobileAppController::class, 'menu']);
            Route::post('marketplace-store', [MarketplaceMobileAppController::class, 'marketplaceStore']);
            Route::post('marketplace-update/{marketplace_order_id}', [MarketplaceMobileAppController::class, 'marketplaceUpdate']);
            Route::get('check-payment-uncompleted-order/{marketplace_id}', [MarketplaceMobileAppController::class, 'checkPaymentUncompletedOrder']);
        });
    });

    Route::post('mobile/userInformation_update', [UserMobileAppController::class, 'userInformationUpdate']);
    Route::post('mobile/user-photo-upload', [UserMobileAppController::class, 'userMediaUpload']);

    /**
     * post media upload
     */
    Route::post('mobile/post-media-upload', [UserMobileAppController::class, 'uploadPostMedia']);
    Route::post('mobile/only-media-upload', [UserMobileAppController::class, 'uploadPostVideo']);


    /**
     * all upcomming events get
     */
    Route::get('/mobile/all-upcomming-event', [UserMobileAppController::class, 'allUpcommingEvent']);
    /**
     * all star list
     */
    Route::get('/mobile/all-star-list', [UserMobileAppController::class, 'allStarList']);
    /**
     * user chat list
     */
    Route::get('/mobile/all-chat-list', [UserMobileAppController::class, 'MyChatList']);
    /**
     * message history get
     */
    Route::get('/mobile/fan-group-chat-history/{group_id}', [UserMobileAppController::class, 'getFanGroupMessage']);
    Route::get('/mobile/qna-chat-history/{qna_id}', [UserMobileAppController::class, 'getQnaMessage']);

    /**
     * Download PDF For invoice
     */
    Route::post('/mobile/getInvoice/data', [UserMobileAppController::class, 'getInvoice']);
    /**
     * create form information get
     */
    Route::get('/user/create-user-info', [UserMobileAppController::class, 'getGetInfos']);
    Route::post('/user/upload-audition-round-videos', [UserMobileAppController::class, 'userRoundVideoUpload']);

    /**
     * fan group join member list
     */
    Route::get('/user/fangroup-member/{fangroup_id}', [UserMobileAppController::class, 'ganGroupJoinMemebers']);


    //test server
    Route::get('/sdkTestUrl/{room_id}', [UserMobileAppController::class, 'sdktestUrl']);

    /**
     *  Download audition certificate
     */
    Route::get('mobile/audition/getAuditionCertificate/{audition_id}/{round_info_id}', [UserMobileAppController::class, 'getCertificate']);

    /**
     *  Download learning session certificate
     */
    Route::post('mobile/audition/getLearningSessionCertificate/{slug}', [UserMobileAppController::class, 'getLearningSessionCertificate']);
    /**
     * tiket for offline meetup
     */
    Route::get('/offlineMeetup/ticketDownload/{id}', [UserMobileAppController::class, 'meetUpTicketDownload']);
    /**
     * oxygenReplyVideo
     */
    Route::post('/mobile/audition/getOxygenReply/video', [UserMobileAppController::class, 'oxygenReplyVideo']);
});
