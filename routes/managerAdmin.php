<?php

use App\Http\Controllers\ManagerAdmin\AuditionAdminController;
use App\Http\Controllers\ManagerAdmin\JuryBoardController;
use App\Http\Controllers\ManagerAdmin\AdminController;
use App\Http\Controllers\ManagerAdmin\JobAssign;
use App\Http\Controllers\ManagerAdmin\DashboardController;
use App\Http\Controllers\ManagerAdmin\LiveChatController;
use App\Http\Controllers\ManagerAdmin\LiveEventController;
use App\Http\Controllers\ManagerAdmin\LearningSessionController;
use App\Http\Controllers\ManagerAdmin\SimplePostController;
use App\Http\Controllers\ManagerAdmin\MarketplaceController;
use App\Http\Controllers\ManagerAdmin\FanGroupController;
use App\Http\Controllers\API\MeetupEventController;
use App\Http\Controllers\ManagerAdmin\AuctionController;
use App\Http\Controllers\ManagerAdmin\GreetingController;
use App\Http\Controllers\ManagerAdmin\PromoVideoController;
use App\Http\Controllers\ManagerAdmin\QnaController;
use App\Http\Controllers\ManagerAdmin\ScheduleController;
use App\Http\Controllers\ManagerAdmin\StarAssignedController;
use App\Http\Controllers\ManagerAdmin\SuperStarController;
use Illuminate\Support\Facades\Route;

// manager Admin route
Route::group(['prefix' => 'manager-admin/', 'as' => 'managerAdmin.', 'middleware' => ['auth', 'managerAdmin']], function () {

    Route::get('dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('profile', [DashboardController::class, 'profile'])->name('profile');

    // Dashboard Routes By Srabon

    Route::get('profile', [DashboardController::class, 'profile'])->name('profile');
    // Schedule Routes By Monir

    Route::resource('schedule', ScheduleController::class);
    Route::post('schdeule/updateAll/{admin_id}', [ScheduleController::class, 'update_all'])->name('schedule.update_all');


    // Meetup Events
    Route::get('meetup-events', [DashboardController::class, 'meetupEvents'])->name('dashboard.meetupEvent');
    Route::get('meetup-events-data/{type}', [DashboardController::class, 'meetupEventsData'])->name('dashboard.meetupEventData');
    Route::get('meetup-events-details/{id}', [DashboardController::class, 'meetupEventsDetails'])->name('dashboard.meetupEventDetails');
    // Live Chats

    Route::get('live-chats', [DashboardController::class, 'liveChats'])->name('dashboard.liveChat');
    Route::get('live-chats-data/{type}', [DashboardController::class, 'liveChatsData'])->name('dashboard.liveChatData');
    Route::get('live-chats-details/{id}', [DashboardController::class, 'liveChatsDetails'])->name('dashboard.liveChatDetails');
    
    //Question And Answers


    // Auditions
    Route::get('auditions', [DashboardController::class, 'auditions'])->name('dashboard.audition');
    Route::get('auditions-data/{type}', [DashboardController::class, 'auditionsData'])->name('dashboard.auditionData');
    Route::get('auditions-details/{id}', [DashboardController::class, 'auditionsDetails'])->name('dashboard.auditionDetails');
    Route::get('auditions-judge', [DashboardController::class, 'auditionsJudgeData'])->name('dashboard.auditionsJudgeData');
    Route::get('auditions-jury', [DashboardController::class, 'auditionsJuryData'])->name('dashboard.auditionsJuryData');

    // fan Group
    Route::get('fan-group', [DashboardController::class, 'fanGroups'])->name('dashboard.fanGroup');
    Route::get('fan-group-data', [DashboardController::class, 'fanGroupsData'])->name('dashboard.fanGroupData');
    Route::get('fan-group-post', [DashboardController::class, 'fanGroupsPost'])->name('dashboard.fanGroupsPost');
    Route::get('fan-group-details/{id}', [DashboardController::class, 'fanGroupsDetails'])->name('dashboard.fanGroupDetails');

    //  learing Session


    Route::get('learning-sessions', [DashboardController::class, 'learningSessions'])->name('dashboard.learningSession');
    Route::get('learning-session/{type}', [DashboardController::class, 'learninSessionData'])->name('dashboard.learningSessionData');
    Route::get('learning-session-details/{id}', [DashboardController::class, 'learninSessionDetails'])->name('dashboard.learninSessionDetails');


    //up commingevent
    Route::get('upcomming-events', [LiveEventController::class, 'UpcommingEvent'])->name('UpcommingEvent');
    //event details
    Route::get('event-details/{id}/{categoryId}', [LiveEventController::class, 'detailsEvent'])->name('detailsEvent');

    //event publish
    Route::get('approved-event/{id}/{categoryId}', [LiveEventController::class, 'approvedEvent'])->name('approvedEvent');

    //all events
    Route::get('event-all', [LiveEventController::class, 'categorys'])->name('allEvent');

    //category base events
    Route::get('category/{id}', [LiveEventController::class, 'events'])->name('events');


    //For Super Star Admin route
    Route::resource('admin', AdminController::class);
    Route::post('admin/active/{id}', [AdminController::class, 'activeNow'])->name('admin.activeNow');
    Route::post('admin/inactive/{id}', [AdminController::class, 'inactiveNow'])->name('admin.inactiveNow');

    //For Super Star route
    Route::resource('star', SuperStarController::class);
    Route::post('star/active/{id}', [AdminController::class, 'activeNow'])->name('star.activeNow');
    Route::post('star/inactive/{id}', [AdminController::class, 'inactiveNow'])->name('star.inactiveNow');



    // Route::get('admin-assinged', [AdminController::class, 'assinged'])->name('admin_assinged');
    // Route::get('admin-free', [AdminController::class, 'notAssinged'])->name('admin_notAssinged');



    // Audition Admin route
    Route::resource('auditionAdmin', AuditionAdminController::class);
    // Route::get('auditionAdmin/{search_text}/', [AuditionAdminController::class, 'customSearch']);
    Route::post('auditionAdmin/active/{id}', [AuditionAdminController::class, 'activeNow'])->name('auditionAdmin.activeNow');
    Route::post('auditionAdmin/inactive/{id}', [AuditionAdminController::class, 'inactiveNow'])->name('auditionAdmin.inactiveNow');

    Route::get('auditionAdmin-assinged', [AuditionAdminController::class, 'assinged'])->name('auditionAdmin_assinged');
    Route::get('auditionAdmin-free', [AuditionAdminController::class, 'notAssinged'])->name('auditionAdmin_notAssinged');

    Route::get('audition/registration/rules', [AuditionAdminController::class, 'registrationRules'])->name('audition.registration.rules');
    Route::get('audition/registration/rules/create', [AuditionAdminController::class, 'createRegistrationRules'])->name('audition.registration.rules.create');
    Route::get('audition/registration/rules/edit', [AuditionAdminController::class, 'editRegistrationRules'])->name('audition.registration.rules.edit');

    // Jury Board route
    Route::resource('jury', JuryBoardController::class);

    Route::post('jury/active/{id}', [JuryBoardController::class, 'activeNow'])->name('jury.activeNow');
    Route::post('jury/inactive/{id}', [JuryBoardController::class, 'inactiveNow'])->name('jury.inactiveNow');

    Route::get('jury-assinged', [JuryBoardController::class, 'assinged'])->name('juryBoard_assinged');
    Route::get('jury-free', [JuryBoardController::class, 'notAssinged'])->name('juryBoard_notAssinged');
    Route::get('jury-view/{jury_id}', [JuryBoardController::class, 'views'])->name('jury.views');


    Route::post('jury-video-assign', [JuryBoardController::class, 'assignVideo'])->name('jury.AssingVideos');


    // assigned route for admin to star or star to admin
    Route::resource('assigned', StarAssignedController::class);


    // Live route
    Route::get('liveChat', [LiveChatController::class, 'index'])->name('liveChat.index');
    Route::put('liveChat/approve/{id}', [LiveChatController::class, 'approve'])->name('liveChat.approve');
    Route::get('liveChat/details/{id}', [LiveChatController::class, 'show'])->name('liveChat.details');

    Route::get('livechat/edit/{id}', [LiveChatController::class, 'edit'])->name('liveChat.edit');
    Route::put('livechat/edit/{id}', [LiveChatController::class, 'update'])->name('liveChat.update');

    //Simple Post
    Route::get('post/pending', [SimplePostController::class, 'pending'])->name('simplePost.pending');
    Route::get('post/published', [SimplePostController::class, 'published'])->name('simplePost.published');
    Route::get('post/all', [SimplePostController::class, 'all'])->name('simplePost.all');

    Route::get('post/details/{id}', [SimplePostController::class, 'details'])->name('simplePost.details');
    Route::get('post/edit/{id}', [SimplePostController::class, 'edit'])->name('simplePost.edit');
    Route::put('post/edit/{id}', [SimplePostController::class, 'update'])->name('simplePost.update');
    Route::get('post/set_publish/{id}', [SimplePostController::class, 'set_publish'])->name('simplePost.set_publish');


    // StarShowcase Auction
    Route::get('auction/pending', [AuctionController::class, 'pending'])->name('auctionProduct.pending');
    Route::get('auction/published', [AuctionController::class, 'published'])->name('auctionProduct.published');
    Route::get('auction/all', [AuctionController::class, 'all'])->name('auctionProduct.all');

    Route::get('auction/details/{id}', [AuctionController::class, 'details'])->name('auctionProduct.details');
    Route::get('auction/edit/{id}', [AuctionController::class, 'edit'])->name('auctionProduct.edit');
    Route::put('auction/edit/{id}', [AuctionController::class, 'update'])->name('auctionProduct.update');
    Route::get('auction/set_publish/{id}', [AuctionController::class, 'set_publish'])->name('auctionProduct.set_publish');


    // Audition Routes
    Route::group(['prefix' => 'audition/', 'as' => 'audition.'], function () {
        // audition
        Route::post('store', [App\Http\Controllers\ManagerAdmin\Audition\AuditionController::class, 'store'])->name('store');
        // audition admin
        Route::resource('auditionAdmin', App\Http\Controllers\ManagerAdmin\Audition\AuditionAdminController::class);
        Route::get('assinged', [App\Http\Controllers\ManagerAdmin\Audition\AuditionAdminController::class, 'assinged'])->name('auditionAdmin.assinged');
        Route::get('free', [App\Http\Controllers\ManagerAdmin\Audition\AuditionAdminController::class, 'notAssinged'])->name('auditionAdmin.notAssinged');

        Route::get('instruction/{audition_id}', [AuditionAdminController::class, 'instruction'])->name('instruction');
        Route::get('send-instruction/{audition_id}', [AuditionAdminController::class, 'sendInstructionToParticipant'])->name('sendInstruction');

        Route::get('pending', [AuditionAdminController::class, 'pending'])->name('pending');
        Route::get('published', [AuditionAdminController::class, 'published'])->name('published');
        Route::get('all', [AuditionAdminController::class, 'all'])->name('all');

        Route::get('details/{id}', [AuditionAdminController::class, 'details'])->name('details');
        Route::get('edit/{id}', [AuditionAdminController::class, 'auditionEdit'])->name('edit');
        Route::put('update/{id}', [AuditionAdminController::class, 'auditionUpdate'])->name('update');
        Route::get('set_publish/{id}', [AuditionAdminController::class, 'set_publish'])->name('set_publish');

        //admins
        Route::get('admin-assign', [AuditionAdminController::class, 'adminAssign'])->name('adminAssign');
        Route::get('admin-assign-submit', [AuditionAdminController::class, 'adminAssignSubmit'])->name('adminAssignSubmit');
        Route::get('dashboard', [AuditionAdminController::class, 'auditionDashboard'])->name('auditionDashboard');
        Route::get('juries', [AuditionAdminController::class, 'auditionJuries'])->name('juries');
        Route::get('events', [AuditionAdminController::class, 'auditionEvents'])->name('events');

        // Jury Audition Routes
        Route::get('jury-published/{id}', [AuditionAdminController::class, 'juryPublished'])->name('jury_published');
        Route::get('jury-published/{id}', [AuditionAdminController::class, 'juryPublished'])->name('jury_published');
    });


    // greeting
    Route::group(['prefix' => 'greeting/', 'as' => 'greeting.'], function () {
        Route::get('dashboard', [GreetingController::class, 'dashboard'])->name('dashboard');
        Route::get('request', [GreetingController::class, 'request'])->name('request');
        Route::get('show/{id}', [GreetingController::class, 'show'])->name('show');
        Route::post('publish/{id}', [GreetingController::class, 'publish'])->name('publish');
    });


    //Marketplace Post
    Route::get('marketplace/pending', [MarketplaceController::class, 'pending'])->name('marketplace.pending');
    Route::get('marketplace/published', [MarketplaceController::class, 'published'])->name('marketplace.published');
    Route::get('marketplace/all', [MarketplaceController::class, 'all'])->name('marketplace.all');
    Route::get('marketplace/order/list', [MarketplaceController::class, 'allOrderList'])->name('marketplace.allOrderList');
    Route::get('marketplace/order/list/{id}', [MarketplaceController::class, 'allOrderDetails'])->name('marketplace.allOrderDetails');

    Route::get('marketplace/details/{id}', [MarketplaceController::class, 'details'])->name('marketplace.details');
    Route::get('marketplace/edit/{id}', [MarketplaceController::class, 'edit'])->name('marketplace.edit');
    Route::put('marketplace/update/{id}', [MarketplaceController::class, 'update'])->name('marketplace.update');
    Route::get('marketplace/set_publish/{id}', [MarketplaceController::class, 'set_publish'])->name('marketplace.set_publish');

    //Fan Group
    Route::get('fangroup/pending', [FanGroupController::class, 'pending'])->name('fangroup.pending');
    Route::get('fangroup/published', [FanGroupController::class, 'published'])->name('fangroup.published');
    Route::get('fangroup/all', [FanGroupController::class, 'all'])->name('fangroup.all');
    Route::get('fangroup/list', [FanGroupController::class, 'allFangroupList'])->name('fangroup.allFangroupList');
    Route::get('fangroup/list/{id}', [FanGroupController::class, 'allFangroupDetails'])->name('fangroup.allFangroupDetails');
    Route::get('fangroup/details/{id}', [FanGroupController::class, 'details'])->name('fangroup.details');
    Route::get('fangroup/set_publish/{id}', [FanGroupController::class, 'set_publish'])->name('fangroup.set_publish');
    Route::get('fangroup/edit/{id}', [FanGroupController::class, 'edit'])->name('fangroup.edit');
    Route::put('fangroup/update/{id}', [FanGroupController::class, 'update'])->name('fangroup.update');

    //Meetup-events
    Route::get('meetupEvents/pending', [MeetupEventController::class, 'manager_pending'])->name('meetupEvent.pending');
    Route::get('meetupEvents/published', [MeetupEventController::class, 'manager_published'])->name('meetupEvent.published');
    Route::get('meetupEvents/all', [MeetupEventController::class, 'manager_all'])->name('meetupEvent.all');

    Route::get('meetupEvents/details/{id}', [MeetupEventController::class, 'manager_event_details'])->name('meetupEvent.details');
    Route::get('meetupEvents/edit/{id}', [MeetupEventController::class, 'edit'])->name('meetupEvent.edit');
    Route::put('meetupEvents/edit/{id}', [MeetupEventController::class, 'update'])->name('meetupEvent.update');
    Route::get('meetupEvents/set_publish/{id}', [MeetupEventController::class, 'manager_event_set_publish'])->name('meetupEvent.set_publish');

    // Live Chat Events
    Route::get('liveChat/pending', [LiveChatController::class, 'pending'])->name('liveChat.pending');
    Route::get('liveChat/published', [LiveChatController::class, 'published'])->name('liveChat.published');
    Route::get('liveChat/all', [LiveChatController::class, 'all'])->name('liveChat.all');

    Route::get('LiveChatEvents/details/{id}', [LiveChatController::class, 'manager_event_details'])->name('LiveChatEvents.details');
    Route::get('LiveChatEvents/set_publish/{id}', [LiveChatController::class, 'manager_event_set_publish'])->name('liveChat.set_publish');

    // Questions and Answers
    Route::get('qna/pending', [QnaController::class, 'pending'])->name('qna.pending');
    Route::get('qna/published', [QnaController::class, 'published'])->name('qna.published');
    Route::get('qna/all', [QnaController::class, 'all'])->name('qna.all');
    Route::get('qna/details/{id}', [QnaController::class, 'manager_event_details'])->name('qna.details');
    Route::get('qna/set_publish/{id}', [QnaController::class, 'manager_event_set_publish'])->name('qna.set_publish');

    Route::get('qna', [QnaController::class, 'index'])->name('qna.index');
    Route::put('qna/approve/{id}', [QnaController::class, 'approve'])->name('qna.approve');
    // Route::get('qna/details/{id}', [QnaController::class, 'show'])->name('qna.details');

    Route::get('qna/edit/{id}', [QnaController::class, 'edit'])->name('qna.edit');
    Route::put('qna/edit/{id}', [QnaController::class, 'update'])->name('qna.update');

    //Learning Session
    Route::get('learningSession/pending', [LearningSessionController::class, 'manager_pending'])->name('learningSession.pending');
    Route::get('learningSession/evaluation', [LearningSessionController::class, 'learningEvaluation'])->name('learningSession.evaluation');
    Route::get('learningSession/evaluation/{id}', [LearningSessionController::class, 'evaluationDetails'])->name('learningSession.evaluationDetails');
    Route::get('learningSession/evaluationResult/{id}', [LearningSessionController::class, 'evaluationResult'])->name('learningSession.evaluationResult');
    Route::post('learningSession/evaluation/accept/{id}', [LearningSessionController::class, 'evaluationAccept'])->name('learningSession.evaluationAccept');
    Route::post('learningSession/evaluation/reject/{id}', [LearningSessionController::class, 'evaluationReject'])->name('learningSession.evaluationReject');
    Route::get('learningSession/published', [LearningSessionController::class, 'manager_published'])->name('learningSession.published');
    Route::get('learningSession/all', [LearningSessionController::class, 'manager_all'])->name('learningSession.all');
    Route::get('learningSession/details/{id}', [LearningSessionController::class, 'manager_event_details'])->name('learningSession.details');
    Route::get('learningSession/edit/{id}', [LearningSessionController::class, 'edit'])->name('learningSession.edit');
    Route::put('learningSession/edit/{id}', [LearningSessionController::class, 'update'])->name('learningSession.update');
    Route::get('learningSession/set_publish/{id}', [LearningSessionController::class, 'manager_event_set_publish'])->name('learningSession.set_publish');

    //audition create
    Route::post('audition-assign/{admin_id}', [JobAssign::class, 'auditionStore'])->name('AuditionAssign');

    // Promo Video
    Route::get('promoVideo/pending', [PromoVideoController::class, 'pending'])->name('promoVideo.pending');
    Route::get('promoVideo/published', [PromoVideoController::class, 'published'])->name('promoVideo.published');
    Route::get('promoVideo/all', [PromoVideoController::class, 'all'])->name('promoVideo.all');

    Route::get('promoVideo/details/{id}', [PromoVideoController::class, 'details'])->name('promoVideo.details');
    Route::get('promoVideo/edit/{id}', [PromoVideoController::class, 'edit'])->name('promoVideo.edit');
    Route::put('promoVideo/edit/{id}', [PromoVideoController::class, 'update'])->name('promoVideo.update');
    Route::get('promoVideo/set_publish/{id}', [PromoVideoController::class, 'set_publish'])->name('promoVideo.set_publish');
});
