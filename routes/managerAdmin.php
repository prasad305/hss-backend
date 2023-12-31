<?php

use App\Http\Controllers\ManagerAdmin\AccountsController;
use App\Http\Controllers\ManagerAdmin\AuditionAdminController;
use App\Http\Controllers\ManagerAdmin\JuryBoardController;
use App\Http\Controllers\ManagerAdmin\AdminController;
use App\Http\Controllers\ManagerAdmin\DashboardController;
use App\Http\Controllers\ManagerAdmin\LiveChatController;
use App\Http\Controllers\ManagerAdmin\LiveEventController;
use App\Http\Controllers\ManagerAdmin\LearningSessionController;
use App\Http\Controllers\ManagerAdmin\SimplePostController;
use App\Http\Controllers\ManagerAdmin\MarketplaceController;
use App\Http\Controllers\ManagerAdmin\SouvenirController;
use App\Http\Controllers\ManagerAdmin\FanGroupController;
use App\Http\Controllers\ManagerAdmin\MeetupEventController;
use App\Http\Controllers\ManagerAdmin\AuctionController;
use App\Http\Controllers\ManagerAdmin\GreetingController;
use App\Http\Controllers\ManagerAdmin\PromoVideoController;
use App\Http\Controllers\ManagerAdmin\QnaController;
use App\Http\Controllers\ManagerAdmin\ScheduleController;
use App\Http\Controllers\ManagerAdmin\StarAssignedController;
use App\Http\Controllers\ManagerAdmin\SuperStarController;
use App\Http\Controllers\ManagerAdmin\ReportController;
use App\Http\Controllers\ManagerAdmin\Audition\AuditionController;
use Illuminate\Support\Facades\Route;

// manager Admin route
Route::group(['prefix' => 'manager-admin/', 'as' => 'managerAdmin.', 'middleware' => ['auth', 'managerAdmin', 'prevent-back-history']], function () {

    Route::get('dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('category', [DashboardController::class, 'category'])->name('category');
    Route::get('profile', [DashboardController::class, 'profile'])->name('profile');
    Route::get('/settings', [DashboardController::class, 'settings'])->name('settings');
    Route::post('/change/password/store', [DashboardController::class, 'changePassword'])->name('change.password');
    Route::post('/change/password/updateprofile', [DashboardController::class, 'updateProfile'])->name('change.updateprofile');

    //********************************************//
    //******Learning Session Routes Start *******//
    //********************************************//
    //=================== Dashboard Routes =============//
    Route::get('learning-sessions', [DashboardController::class, 'learningSessions'])->name('dashboard.learningSession');
    Route::get('learning-session/{type}', [DashboardController::class, 'learninSessionData'])->name('dashboard.learningSessionData');
    Route::get('learning-session-details/{id}', [DashboardController::class, 'learninSessionDetails'])->name('dashboard.learninSessionDetails');
    Route::get('learning-sessions-manager-list', [DashboardController::class, 'learningSessionManagerList'])->name('dashboard.learningSessionManagerList');
    Route::get('sublearning-sessions-list/{id}', [DashboardController::class, 'sublearningSessionList'])->name('sublearningSession.list');
    Route::get('learningSession-admin-list', [DashboardController::class, 'learningSessionAdminList'])->name('learningSessionEvents.adminList');
    Route::get('learningSession-admin-events/{adminId}', [DashboardController::class, 'learningSessionAdminEvents'])->name('learningSessionEvents.adminEvents');
    Route::get('learningSession-superstar-list', [DashboardController::class, 'learningSessionSuperstarList'])->name('learningSessionEvents.superstarList');
    Route::get('learningSession-superstar-events/{starId}', [DashboardController::class, 'learningSessionSuperstarEvents'])->name('learningSessionEvents.superstarEvents');
    //******************** Learning Session **********************//
    Route::get('learningSession/pending', [LearningSessionController::class, 'manager_pending'])->name('learningSession.pending');
    Route::get('learningSession/rejected', [LearningSessionController::class, 'manager_rejected'])->name('learningSession.rejected');
    Route::get('learningSession/evaluation', [LearningSessionController::class, 'learningEvaluation'])->name('learningSession.evaluation');
    Route::get('learningSession/evaluation/{id}', [LearningSessionController::class, 'evaluationDetails'])->name('learningSession.evaluationDetails');
    Route::get('learningSession/evaluationResult/{id}', [LearningSessionController::class, 'evaluationResult'])->name('learningSession.evaluationResult');
    Route::post('learningSession/evaluation/accept/{id}', [LearningSessionController::class, 'evaluationAccept'])->name('learningSession.evaluationAccept');
    Route::post('learningSession/evaluation/reject/{id}', [LearningSessionController::class, 'evaluationReject'])->name('learningSession.evaluationReject');
    Route::get('learningSession/evaluation/result/published/{id}', [LearningSessionController::class, 'evaluationResultPublished'])->name('learningSession.evaluationResultPublished');
    Route::get('learningSession/published', [LearningSessionController::class, 'manager_published'])->name('learningSession.published');
    Route::get('learningSession/all', [LearningSessionController::class, 'manager_all'])->name('learningSession.all');
    Route::get('learningSession/details/{id}', [LearningSessionController::class, 'manager_event_details'])->name('learningSession.details');
    Route::get('learningSession/edit/{id}', [LearningSessionController::class, 'edit'])->name('learningSession.edit');
    Route::put('learningSession/edit/{id}', [LearningSessionController::class, 'update'])->name('learningSession.update');
    Route::post('learningSession/set_publish/{id}', [LearningSessionController::class, 'manager_event_set_publish'])->name('learningSession.set_publish');
    //====================== Accounts Routes ======================//
    Route::get('learningSession-totalIncome', [AccountsController::class, 'learningSessionTotalIncome'])->name('learningSessionTotalIncome');
    Route::get('learningSession-dailyIncome', [AccountsController::class, 'learningSessionDailyIncome'])->name('learningSessionDailyIncome');
    Route::get('learningSession-weeklyIncome', [AccountsController::class, 'learningSessionweeklyIncome'])->name('learningSessionWeeklyIncome');
    Route::get('learningSession-monthlyIncome', [AccountsController::class, 'learningSessionMonthlyIncome'])->name('learningSessionMonthlyIncome');
    Route::get('learningSession-yearlyIncome', [AccountsController::class, 'learningSessionYearlyIncome'])->name('learningSessionYearlyIncome');
    //===================== Reports Routes =========================//
    Route::get('/learningSession-report', [ReportController::class, 'learningSessionReport'])->name('report.learningSession');
    Route::post('/learningSession-report-filter', [ReportController::class, 'learningFilter'])->name('report.filter.learningSession');
    //********************************************//
    //******Learning Session Routes Start *******//
    //********************************************//

    //********************************************//
    //******MeetUp Routes Start *******//
    //********************************************//
    //*********  Dashboard Routes ****************//
    Route::get('meetup-events', [DashboardController::class, 'meetupEvents'])->name('dashboard.meetupEvent');
    Route::get('meetup-events-data/{type}', [DashboardController::class, 'meetupEventsData'])->name('dashboard.meetupEventData');
    Route::get('meetup-events-details/{id}', [DashboardController::class, 'meetupEventsDetails'])->name('dashboard.meetupEventDetails');
    Route::get('submeetup-list/{id}', [DashboardController::class, 'submeetupList'])->name('submeetup.list');
    Route::get('meetup-admin-list', [DashboardController::class, 'meetupAdminList'])->name('meetupEvents.adminList');
    Route::get('meetup-admin-events/{adminId}', [DashboardController::class, 'meetupAdminEvents'])->name('meetupEvents.adminEvents');
    Route::get('meetup-superstar-list', [DashboardController::class, 'meetupSuperstarList'])->name('meetupEvents.superstarList');
    Route::get('meetup-superstar-events/{starId}', [DashboardController::class, 'meetupSuperstarEvents'])->name('meetupEvents.superstarEvents');
    //**************** Income Routes *******************//
    Route::get('meetup-totalIncome', [AccountsController::class, 'meetupTotalIncome'])->name('meetupTotalIncome');
    Route::get('meetup-dailyIncome', [AccountsController::class, 'meetupDailyIncome'])->name('meetupDailyIncome');
    Route::get('meetup-weeklyIncome', [AccountsController::class, 'meetupweeklyIncome'])->name('meetupWeeklyIncome');
    Route::get('meetup-monthlyIncome', [AccountsController::class, 'meetupMonthlyIncome'])->name('meetupMonthlyIncome');
    Route::get('meetup-yearlyIncome', [AccountsController::class, 'meetupYearlyIncome'])->name('meetupYearlyIncome');
    //**************** Report Routes *******************//
    Route::get('/meetup-report', [ReportController::class, 'meetupReport'])->name('report.meetup');
    Route::post('/meetup-report-filter', [ReportController::class, 'meetupReportFilter'])->name('report.filter.meetupevent');
    //**************** Events Routes *******************//
    Route::get('meetupEvents/pending', [MeetupEventController::class, 'manager_pending'])->name('meetupEvent.pending');
    Route::get('meetupEvents/published', [MeetupEventController::class, 'manager_published'])->name('meetupEvent.published');
    Route::get('meetupEvents/all', [MeetupEventController::class, 'manager_all'])->name('meetupEvent.all');
    Route::get('meetupEvents/details/{id}', [MeetupEventController::class, 'manager_event_details'])->name('meetupEvent.details');
    Route::get('meetupEvents/edit/{id}', [MeetupEventController::class, 'edit'])->name('meetupEvent.edit');
    Route::put('meetupEvents/edit/{id}', [MeetupEventController::class, 'update'])->name('meetupEvent.update');
    Route::post('meetupEvents/set_publish/{id}', [MeetupEventController::class, 'manager_event_set_publish'])->name('meetupEvent.set_publish');
    //********************************************//
    //************ MeetUp Routes End **************//
    //********************************************//


    //********************************************//
    //******Marketplace Routes Start *******//
    //********************************************//
    //********************* Marketplace Post ***************//
    Route::get('marketplace/pending', [MarketplaceController::class, 'pending'])->name('marketplace.pending');
    Route::get('marketplace/published', [MarketplaceController::class, 'published'])->name('marketplace.published');
    Route::get('marketplace/all', [MarketplaceController::class, 'all'])->name('marketplace.all');
    Route::get('marketplace/order/list', [MarketplaceController::class, 'allOrderList'])->name('marketplace.allOrderList');
    Route::get('marketplace/details/{id}', [MarketplaceController::class, 'details'])->name('marketplace.details');
    Route::get('marketplace/edit/{id}', [MarketplaceController::class, 'edit'])->name('marketplace.edit');
    Route::put('marketplace/update/{id}', [MarketplaceController::class, 'update'])->name('marketplace.update');
    Route::get('marketplace/set_publish/{id}', [MarketplaceController::class, 'set_publish'])->name('marketplace.set_publish');
    //********************* dashboard ************************//
    Route::get('marketplace-dashboard', [DashboardController::class, 'marketplace'])->name('dashboard.marketplace');
    Route::get('marketplace-data/{type}', [DashboardController::class, 'marketplaceData'])->name('dashboard.marketplaceData');
    Route::get('submarketplace-list/{id}', [DashboardController::class, 'submarketplaceList'])->name('submarketplace.list');
    Route::get('marketplace-admin-list', [DashboardController::class, 'marketplaceAdminList'])->name('marketplaceEvents.adminList');
    Route::get('marketplace-admin-events/{adminId}', [DashboardController::class, 'marketplaceAdminEvents'])->name('marketplaceEvents.adminEvents');
    Route::get('marketplace-superstar-list', [DashboardController::class, 'marketplaceSuperstarList'])->name('marketplaceEvents.superstarList');
    Route::get('marketplace-superstar-events/{starId}', [DashboardController::class, 'marketplaceSuperstarEvents'])->name('marketplaceEvents.superstarEvents');
    Route::get('marketplace/order/list/{id}', [MarketplaceController::class, 'allOrderDetails'])->name('marketplace.allOrderDetails');
    //************************* Reports *************************//
    Route::get('/marketplace-report', [ReportController::class, 'marketplaceReport'])->name('report.marketplace');
    Route::post('/marketplace-report-filter', [ReportController::class, 'marketPlaceFilter'])->name('report.filter.marketPlace');
    //************************* Accounts *************************//
    Route::get('marketplace-totalIncome', [AccountsController::class, 'marketplaceTotalIncome'])->name('marketplaceTotalIncome');
    Route::get('marketplace-dailyIncome', [AccountsController::class, 'marketplaceDailyIncome'])->name('marketplaceDailyIncome');
    Route::get('marketplace-weeklyIncome', [AccountsController::class, 'marketplaceweeklyIncome'])->name('marketplaceWeeklyIncome');
    Route::get('marketplace-monthlyIncome', [AccountsController::class, 'marketplaceMonthlyIncome'])->name('marketplaceMonthlyIncome');
    Route::get('marketplace-yearlyIncome', [AccountsController::class, 'marketplaceYearlyIncome'])->name('marketplaceYearlyIncome');
    //********************************************//
    //******Marketplace Routes End *******//
    //********************************************//

    //********************************************//
    //******Souvenir Routes Start *******//
    //********************************************//
    //**************** Souviner *****************//
    Route::get('souvenir/pending', [SouvenirController::class, 'pending'])->name('souvenir.pending');
    Route::get('souvenir/published', [SouvenirController::class, 'published'])->name('souvenir.published');
    Route::get('souvenir/all', [SouvenirController::class, 'all'])->name('souvenir.all');
    Route::get('souvenir/details/{id}', [SouvenirController::class, 'details'])->name('souvenir.details');
    Route::get('souvenir/edit/{id}', [SouvenirController::class, 'edit'])->name('souvenir.edit');
    Route::get('souvenir/apply/show', [SouvenirController::class, 'showApplySouvenir'])->name('souvenir.showApply');
    Route::get('souvenir/apply/delete/list', [SouvenirController::class, 'deleteApplySouvenir'])->name('souvenir.showApplyDelete');
    Route::put('souvenir/update/{id}', [SouvenirController::class, 'update'])->name('souvenir.update');
    Route::get('souvenir/set_publish/{id}', [SouvenirController::class, 'set_publish'])->name('souvenir.set_publish');
    Route::post('souvenir/restore/{id}', [SouvenirController::class, 'restoreNow'])->name('souvenir.restoreNow');
    Route::post('souvenir/delete/{id}', [SouvenirController::class, 'deleteNow'])->name('souvenir.deleteNow');
    //*********** Dashboard ******************/
    Route::get('souvenir-dashboard', [DashboardController::class, 'souvenir'])->name('dashboard.souvenir');
    Route::get('souvenir-data/{type}', [DashboardController::class, 'souvenirData'])->name('dashboard.souvenirData');
    Route::get('subsouvenir-list/{id}', [DashboardController::class, 'subsouvenirList'])->name('subsouvenir.list');
    Route::get('souvenir-admin-list', [DashboardController::class, 'souvenirAdminList'])->name('souvenirEvents.adminList');
    Route::get('souvenir-admin-events/{adminId}', [DashboardController::class, 'souvenirAdminEvents'])->name('souvenirEvents.adminEvents');
    Route::get('souvenir-superstar-list', [DashboardController::class, 'souvenirSuperstarList'])->name('souvenirEvents.superstarList');
    Route::get('souvenir-superstar-events/{starId}', [DashboardController::class, 'souvenirSuperstarEvents'])->name('souvenirEvents.superstarEvents');
    //************** Accounts ************//
    Route::get('souvenir-totalIncome', [AccountsController::class, 'souvenirTotalIncome'])->name('souvenirTotalIncome');
    Route::get('souvenir-dailyIncome', [AccountsController::class, 'souvenirDailyIncome'])->name('souvenirDailyIncome');
    Route::get('souvenir-weeklyIncome', [AccountsController::class, 'souvenirweeklyIncome'])->name('souvenirWeeklyIncome');
    Route::get('souvenir-monthlyIncome', [AccountsController::class, 'souvenirMonthlyIncome'])->name('souvenirMonthlyIncome');
    Route::get('souvenir-yearlyIncome', [AccountsController::class, 'souvenirYearlyIncome'])->name('souvenirYearlyIncome');
    //************** Reports ************//
    Route::get('/souvenir-report', [ReportController::class, 'souvenirReport'])->name('report.souvenir');
    Route::post('/souvenir-report-filter', [ReportController::class, 'souvenirReportFilter'])->name('report.filter.souvenirReport');
    //********************************************//
    //******Souvenir Routes End *******//
    //********************************************//

    //********************************************//
    //******Auction Routes Start *******//
    //********************************************//
    //*********** Auction ******************/
    Route::get('auction/pending', [AuctionController::class, 'pending'])->name('auctionProduct.pending');
    Route::get('auction/published', [AuctionController::class, 'published'])->name('auctionProduct.published');
    Route::get('auction/all', [AuctionController::class, 'all'])->name('auctionProduct.all');
    Route::get('auction/details/{id}', [AuctionController::class, 'details'])->name('auctionProduct.details');
    Route::get('auction/edit/{id}', [AuctionController::class, 'edit'])->name('auctionProduct.edit');
    Route::put('auction/edit/{id}', [AuctionController::class, 'update'])->name('auctionProduct.update');
    Route::get('auction/set_publish/{id}', [AuctionController::class, 'set_publish'])->name('auctionProduct.set_publish');
    Route::get('auction-totalIncome', [AccountsController::class, 'auctionTotalIncome'])->name('auctionTotalIncome');
    Route::get('auction-dailyIncome', [AccountsController::class, 'auctionDailyIncome'])->name('auctionDailyIncome');
    Route::get('auction-weeklyIncome', [AccountsController::class, 'auctionweeklyIncome'])->name('auctionWeeklyIncome');
    Route::get('auction-monthlyIncome', [AccountsController::class, 'auctionMonthlyIncome'])->name('auctionMonthlyIncome');
    Route::get('auction-yearlyIncome', [AccountsController::class, 'auctionYearlyIncome'])->name('auctionYearlyIncome');
    //*********** Dashboard ******************/
    Route::get('auction-dashboard', [DashboardController::class, 'auction'])->name('dashboard.auction');
    Route::get('auction-data/{type}', [DashboardController::class, 'auctionData'])->name('dashboard.auctionData');
    Route::get('subauction-list/{id}', [DashboardController::class, 'subauctionList'])->name('subauction.list');
    Route::get('auction-admin-list', [DashboardController::class, 'auctionAdminList'])->name('auctionEvents.adminList');
    Route::get('auction-admin-events/{adminId}', [DashboardController::class, 'auctionAdminEvents'])->name('auctionEvents.adminEvents');
    Route::get('auction-superstar-list', [DashboardController::class, 'auctionSuperstarList'])->name('auctionEvents.superstarList');
    Route::get('auction-superstar-events/{starId}', [DashboardController::class, 'auctionSuperstarEvents'])->name('auctionEvents.superstarEvents');
    //*********** Report ******************/
    Route::get('/auction-report', [ReportController::class, 'auctionReport'])->name('report.auction');
    Route::post('/auction-report-filter', [ReportController::class, 'auctionReportFilter'])->name('report.filter.auctionReport');
    //********************************************//
    //******Auction Routes End *******//
    //********************************************//

    //********************************************//
    //******Greetings Routes Start *******//
    //********************************************//
    //************ greeting ****************//
    Route::group(['prefix' => 'greeting/', 'as' => 'greeting.'], function () {
        // Route::get('dashboard', [GreetingController::class, 'dashboard'])->name('dashboard');
        // Route::get('subcategory/{id}', [GreetingController::class, 'subcategory'])->name('subcategory');
        Route::get('request', [GreetingController::class, 'request'])->name('request');
        Route::get('published', [GreetingController::class, 'published'])->name('published');
        Route::get('show/{id}', [GreetingController::class, 'show'])->name('show');
        Route::get('edit/{id}', [GreetingController::class, 'edit'])->name('edit');
        Route::put('update/{id}', [GreetingController::class, 'update'])->name('update');
        Route::post('publish/{id}', [GreetingController::class, 'publish'])->name('publish');
        // Route::get('setPublish/{id}', [GreetingController::class, 'setPublish'])->name('setPublish');
    });
    //*********** Dashboard ************//
    Route::get('greeting-dashboard', [DashboardController::class, 'greeting'])->name('dashboard.greeting');
    Route::get('greeting-data/{type}', [DashboardController::class, 'greetingData'])->name('dashboard.greetingData');
    Route::get('greeting-details/{id}', [DashboardController::class, 'greetingDetails'])->name('dashboard.greetingDetails');
    Route::get('subgreeting-list/{id}', [DashboardController::class, 'subgreetingList'])->name('subgreeting.list');
    Route::get('greeting-admin-list', [DashboardController::class, 'greetingAdminList'])->name('greetingEvents.adminList');
    Route::get('greeting-admin-events/{adminId}', [DashboardController::class, 'greetingAdminEvents'])->name('greetingEvents.adminEvents');
    Route::get('greeting-superstar-list', [DashboardController::class, 'greetingSuperstarList'])->name('greetingEvents.superstarList');
    Route::get('greeting-superstar-events/{starId}', [DashboardController::class, 'greetingSuperstarEvents'])->name('greetingEvents.superstarEvents');
    //********** Accounts *************//
    Route::get('greeting-totalIncome', [AccountsController::class, 'greetingTotalIncome'])->name('greetingTotalIncome');
    Route::get('greeting-dailyIncome', [AccountsController::class, 'greetingDailyIncome'])->name('greetingDailyIncome');
    Route::get('greeting-weeklyIncome', [AccountsController::class, 'greetingweeklyIncome'])->name('greetingWeeklyIncome');
    Route::get('greeting-monthlyIncome', [AccountsController::class, 'greetingMonthlyIncome'])->name('greetingMonthlyIncome');
    Route::get('greeting-yearlyIncome', [AccountsController::class, 'greetingYearlyIncome'])->name('greetingYearlyIncome');
    Route::get('/greeting-report', [ReportController::class, 'greetingReport'])->name('report.greeting');
    Route::post('/greeting-report-filter', [ReportController::class, 'greetingReportFilter'])->name('report.filter.greeting');
    //********************************************//
    //******Greetings Routes End *******//
    //********************************************//

    //********************************************//
    //****** Simple Post Routes Start *******//
    //********************************************//
    //************ Simple Post *************//
    Route::get('post/pending', [SimplePostController::class, 'pending'])->name('simplePost.pending');
    Route::get('post/published', [SimplePostController::class, 'published'])->name('simplePost.published');
    Route::get('post/all', [SimplePostController::class, 'all'])->name('simplePost.all');

    Route::get('post/details/{id}', [SimplePostController::class, 'details'])->name('simplePost.details');
    Route::get('post/edit/{id}', [SimplePostController::class, 'edit'])->name('simplePost.edit');
    Route::put('post/edit/{id}', [SimplePostController::class, 'update'])->name('simplePost.update');
    Route::get('post/set_publish/{id}', [SimplePostController::class, 'set_publish'])->name('simplePost.set_publish');
    //************ Dashboard *************//
    Route::get('simple-post', [DashboardController::class, 'simplePost'])->name('dashboard.simplePost');
    Route::get('subsimplepost-list/{id}', [DashboardController::class, 'subsimplepostList'])->name('subsimplePost.list');
    Route::get('simple-post-data/{type}', [DashboardController::class, 'simplePostData'])->name('dashboard.simplePostData');
    Route::get('simple-post-details/{id}', [DashboardController::class, 'simplePostDetails'])->name('dashboard.simplePostDetails');
    Route::get('simplePost-admin-list', [DashboardController::class, 'simplePostAdminList'])->name('simplePostEvents.adminList');
    Route::get('simplePost-admin-events/{adminId}', [DashboardController::class, 'simplePostAdminEvents'])->name('simplePostEvents.adminEvents');
    Route::get('simplePost-superstar-list', [DashboardController::class, 'simplePostSuperstarList'])->name('simplePostEvents.superstarList');
    Route::get('simplePost-superstar-events/{starId}', [DashboardController::class, 'simplePostSuperstarEvents'])->name('simplePostEvents.superstarEvents');
    //************ Accounts *************//
    Route::get('simplePost-totalIncome', [AccountsController::class, 'simplePostTotalIncome'])->name('simplePostTotalIncome');
    Route::get('simplePost-dailyIncome', [AccountsController::class, 'simplePostDailyIncome'])->name('simplePostDailyIncome');
    Route::get('simplePost-weeklyIncome', [AccountsController::class, 'simplePostweeklyIncome'])->name('simplePostWeeklyIncome');
    Route::get('simplePost-monthlyIncome', [AccountsController::class, 'simplePostMonthlyIncome'])->name('simplePostMonthlyIncome');
    Route::get('simplePost-yearlyIncome', [AccountsController::class, 'simplePostYearlyIncome'])->name('simplePostYearlyIncome');
    //************ Report *************//
    Route::get('/simplePost-report', [ReportController::class, 'simplePostReport'])->name('report.simplePost');
    Route::post('/simplePost-report-filter', [ReportController::class, 'simplePostFilter'])->name('report.filter.simplePost');
    Route::get('/simplePost-report-filter-userType/{name}', [ReportController::class, 'simplePostUserName']);
    //********************************************//
    //****** Simple Post Routes End *******//
    //********************************************//

    //********************************************//
    //****** Promo Video Routes Start *******//
    //********************************************//
    Route::get('promoVideo/pending', [PromoVideoController::class, 'pending'])->name('promoVideo.pending');
    Route::get('promoVideo/published', [PromoVideoController::class, 'published'])->name('promoVideo.published');
    Route::get('promoVideo/all', [PromoVideoController::class, 'all'])->name('promoVideo.all');
    Route::get('promoVideo/details/{id}', [PromoVideoController::class, 'details'])->name('promoVideo.details');
    Route::get('promoVideo/edit/{id}', [PromoVideoController::class, 'edit'])->name('promoVideo.edit');
    Route::put('promoVideo/edit/{id}', [PromoVideoController::class, 'update'])->name('promoVideo.update');
    Route::post('promoVideo/set_publish/{id}', [PromoVideoController::class, 'set_publish'])->name('promoVideo.set_publish');
    //********************************************//
    //****** Promo Video Routes End *******//
    //********************************************//

    //********************************************//
    //****** Fan Group Routes Start *******//
    //********************************************//
    //============ Fan Group ============//
    Route::get('fangroup/pending', [FanGroupController::class, 'pending'])->name('fangroup.pending');
    Route::get('fangroup/published', [FanGroupController::class, 'published'])->name('fangroup.published');
    Route::get('fangroup/all', [FanGroupController::class, 'all'])->name('fangroup.all');
    Route::get('fangroup/list', [FanGroupController::class, 'allFangroupList'])->name('fangroup.allFangroupList');
    Route::get('fangroup/list/{id}', [FanGroupController::class, 'allFangroupDetails'])->name('fangroup.allFangroupDetails');
    Route::get('fangroup/details/{id}', [FanGroupController::class, 'details'])->name('fangroup.details');
    Route::post('fangroup/set_publish', [FanGroupController::class, 'set_publish'])->name('fangroup.set_publish');
    Route::get('fangroup/edit/{id}', [FanGroupController::class, 'edit'])->name('fangroup.edit');
    Route::put('fangroup/update/{id}', [FanGroupController::class, 'update'])->name('fangroup.update');
    //============ Dashboard ============//
    Route::get('fan-group', [DashboardController::class, 'fanGroups'])->name('dashboard.fanGroup');
    Route::get('fan-group-data/{type}', [DashboardController::class, 'fanGroupsData'])->name('dashboard.fanGroupData');
    // Route::get('fan-group-post', [DashboardController::class, 'fanGroupsPost'])->name('dashboard.fanGroupsPost');
    Route::get('fan-group-details/{id}', [DashboardController::class, 'fanGroupsDetails'])->name('dashboard.fanGroupDetails');
    Route::get('subFanGroup-list/{id}', [DashboardController::class, 'subFanGroupList'])->name('subFanGroup.list');
    Route::get('fanGroup-admin-list', [DashboardController::class, 'fanGroupAdminList'])->name('fanGroupEvents.adminList');
    Route::get('fanGroup-admin-events/{adminId}', [DashboardController::class, 'fanGroupAdminEvents'])->name('fanGroupEvents.adminEvents');
    Route::get('fanGroup-superstar-list', [DashboardController::class, 'fanGroupSuperstarList'])->name('fanGroupEvents.superstarList');
    Route::get('fanGroup-superstar-events/{starId}', [DashboardController::class, 'fanGroupSuperstarEvents'])->name('fanGroupEvents.superstarEvents');
    //============ Accounts ============//
    Route::get('fanGroup-totalIncome', [AccountsController::class, 'fanGroupTotalIncome'])->name('fanGroupTotalIncome');
    Route::get('fanGroup-dailyIncome', [AccountsController::class, 'fanGroupDailyIncome'])->name('fanGroupDailyIncome');
    Route::get('fanGroup-weeklyIncome', [AccountsController::class, 'fanGroupweeklyIncome'])->name('fanGroupWeeklyIncome');
    Route::get('fanGroup-monthlyIncome', [AccountsController::class, 'fanGroupMonthlyIncome'])->name('fanGroupMonthlyIncome');
    Route::get('fanGroup-yearlyIncome', [AccountsController::class, 'fanGroupYearlyIncome'])->name('fanGroupYearlyIncome');
    //============ Reports ============//
    Route::get('/fanGroup-report', [ReportController::class, 'fanGroupReport'])->name('report.fanGroup');
    //********************************************//
    //****** Fan Group Routes End *******//
    //********************************************//
    
    //********************************************//
    //****** Live Chat Routes Start *******//
    //********************************************//
    Route::get('liveChat', [LiveChatController::class, 'index'])->name('liveChat.index');
    Route::put('liveChat/approve/{id}', [LiveChatController::class, 'approve'])->name('liveChat.approve');
    Route::get('liveChat/details/{id}', [LiveChatController::class, 'show'])->name('liveChat.details');
    Route::get('livechat/edit/{id}', [LiveChatController::class, 'edit'])->name('liveChat.edit');
    Route::put('livechat/edit/{id}', [LiveChatController::class, 'update'])->name('liveChat.update');
    Route::get('liveChat/pending', [LiveChatController::class, 'pending'])->name('liveChat.pending');
    Route::get('liveChat/published', [LiveChatController::class, 'published'])->name('liveChat.published');
    Route::get('liveChat/all', [LiveChatController::class, 'all'])->name('liveChat.all');
    Route::get('LiveChatEvents/details/{id}', [LiveChatController::class, 'manager_event_details'])->name('LiveChatEvents.details');
    Route::post('LiveChatEvents/set_publish/{id}', [LiveChatController::class, 'manager_event_set_publish'])->name('liveChat.set_publish');
    //=========== Dashboard ==========//
    Route::get('live-chats', [DashboardController::class, 'liveChats'])->name('dashboard.liveChat');
    Route::get('live-chats-data/{type}', [DashboardController::class, 'liveChatsData'])->name('dashboard.liveChatData');
    Route::get('live-chats-details/{id}', [DashboardController::class, 'liveChatsDetails'])->name('dashboard.liveChatDetails');
    Route::get('subliveChat-list/{id}', [DashboardController::class, 'subliveChatList'])->name('subliveChat.list');
    Route::get('liveChat-admin-list', [DashboardController::class, 'liveChatAdminList'])->name('liveChatEvents.adminList');
    Route::get('liveChat-admin-events/{adminId}', [DashboardController::class, 'liveChatAdminEvents'])->name('liveChatEvents.adminEvents');
    Route::get('liveChat-superstar-list', [DashboardController::class, 'liveChatSuperstarList'])->name('liveChatEvents.superstarList');
    Route::get('liveChat-superstar-events/{starId}', [DashboardController::class, 'liveChatSuperstarEvents'])->name('liveChatEvents.superstarEvents');
    //=========== Accounts ==========//
    Route::get('liveChat-totalIncome', [AccountsController::class, 'liveChatTotalIncome'])->name('liveChatTotalIncome');
    Route::get('liveChat-dailyIncome', [AccountsController::class, 'liveChatDailyIncome'])->name('liveChatDailyIncome');
    Route::get('liveChat-weeklyIncome', [AccountsController::class, 'liveChatweeklyIncome'])->name('liveChatWeeklyIncome');
    Route::get('liveChat-monthlyIncome', [AccountsController::class, 'liveChatMonthlyIncome'])->name('liveChatMonthlyIncome');
    Route::get('liveChat-yearlyIncome', [AccountsController::class, 'liveChatYearlyIncome'])->name('liveChatYearlyIncome');
    //=========== Report ==========//
    Route::get('/liveChat-report', [ReportController::class, 'liveChatReport'])->name('report.liveChat');
    Route::post('/liveChat-report', [ReportController::class, 'liveChatReportFilter'])->name('report.Filter.liveChat');
    //********************************************//
    //****** Live Chat Routes End *******//
    //********************************************//

    //********************************************//
    //****** QNA Routes Start *******//
    //********************************************//
    //=========== QNA ==========//
    Route::get('qna/pending', [QnaController::class, 'pending'])->name('qna.pending');
    Route::get('qna/published', [QnaController::class, 'published'])->name('qna.published');
    Route::get('qna/all', [QnaController::class, 'all'])->name('qna.all');
    Route::get('qna/details/{id}', [QnaController::class, 'manager_event_details'])->name('qna.details');
    Route::post('qna/set_publish/{id}', [QnaController::class, 'manager_event_set_publish'])->name('qna.set_publish');
    Route::get('qna', [QnaController::class, 'index'])->name('qna.index');
    Route::put('qna/approve/{id}', [QnaController::class, 'approve'])->name('qna.approve');
    // Route::get('qna/details/{id}', [QnaController::class, 'show'])->name('qna.details');
    Route::get('qna/edit/{id}', [QnaController::class, 'edit'])->name('qna.edit');
    Route::put('qna/edit/{id}', [QnaController::class, 'update'])->name('qna.update');
    //=========== Dashboard ==========//
    Route::get('qna-dashboard', [DashboardController::class, 'qna'])->name('dashboard.qna');
    Route::get('qna-data/{type}', [DashboardController::class, 'qnaData'])->name('dashboard.qnaData');
    Route::get('qna-details/{id}', [DashboardController::class, 'qnaDetails'])->name('dashboard.qnaDetails');
    Route::get('subqna-list/{id}', [DashboardController::class, 'subqnaList'])->name('subqna.list');
    Route::get('qna-admin-list', [DashboardController::class, 'qnaAdminList'])->name('qnaEvents.adminList');
    Route::get('qna-admin-events/{adminId}', [DashboardController::class, 'qnaAdminEvents'])->name('qnaEvents.adminEvents');
    Route::get('qna-superstar-list', [DashboardController::class, 'qnaSuperstarList'])->name('qnaEvents.superstarList');
    Route::get('qna-superstar-events/{starId}', [DashboardController::class, 'qnaSuperstarEvents'])->name('qnaEvents.superstarEvents');
    //=========== Accounts ==========//
    Route::get('qna-totalIncome', [AccountsController::class, 'qnaTotalIncome'])->name('qnaTotalIncome');
    Route::get('qna-dailyIncome', [AccountsController::class, 'qnaDailyIncome'])->name('qnaDailyIncome');
    Route::get('qna-weeklyIncome', [AccountsController::class, 'qnaweeklyIncome'])->name('qnaWeeklyIncome');
    Route::get('qna-monthlyIncome', [AccountsController::class, 'qnaMonthlyIncome'])->name('qnaMonthlyIncome');
    Route::get('qna-yearlyIncome', [AccountsController::class, 'qnaYearlyIncome'])->name('qnaYearlyIncome');
    //=========== Report ==========//
    Route::get('/qna-report', [ReportController::class, 'qnaReport'])->name('report.qna');
    Route::post('/qna-report-filter', [ReportController::class, 'qnaReportFilter'])->name('report.Filter.qna');
    //********************************************//
    //****** QNA Routes End *******//
    //********************************************//

    // Dashboard Routes By Srabon
    Route::get('profile', [DashboardController::class, 'profile'])->name('profile');

    // Schedule Routes By Monir
    Route::resource('schedule', ScheduleController::class);
    Route::post('schdeule/updateAll/{admin_id}', [ScheduleController::class, 'update_all'])->name('schedule.update_all');

    // Audition routes starts here
    Route::get('auditions', [DashboardController::class, 'auditions'])->name('dashboard.audition');
    Route::get('auditions-data/{type}', [DashboardController::class, 'auditionsData'])->name('dashboard.auditionData');
    Route::get('auditions-details/{id}', [DashboardController::class, 'auditionsDetails'])->name('dashboard.auditionDetails');
    Route::get('audition-events/round/details/{id}', [DashboardController::class, 'auditionsRoundDetails'])->name('audition.roundDetails');
    Route::get('auditions-manager-list', [DashboardController::class, 'auditionManagerList'])->name('dashboard.auditionManagerList');
    Route::resource('auditionAdmin', AuditionAdminController::class);
    Route::post('auditionAdmin/active/{id}', [AuditionAdminController::class, 'activeNow'])->name('auditionAdmin.activeNow');
    Route::post('auditionAdmin/inactive/{id}', [AuditionAdminController::class, 'inactiveNow'])->name('auditionAdmin.inactiveNow');
    Route::get('audition/registration/rules', [AuditionAdminController::class, 'registrationRules'])->name('audition.registration.rules');
    Route::get('audition/registration/rules/create/{audition_id}', [AuditionAdminController::class, 'createRegistrationRules'])->name('audition.registration.rules.create');
    Route::post('audition/registration/rules/store', [AuditionAdminController::class, 'storeRegistrationRules'])->name('audition.registration.rules.store');
    Route::get('audition/registration/rules/{audition_id}/edit', [AuditionAdminController::class, 'editRegistrationRules'])->name('audition.registration.rules.edit');
    Route::get('audition/registration-rules/{round_id}', [AuditionAdminController::class, 'getRoundInfo']);
    Route::post('audition/registration/round/update/{round_id}', [AuditionAdminController::class, 'updateRegistrationRound'])->name('audition.registration.round.update');
    Route::group(['prefix' => 'audition/', 'as' => 'audition.'], function () {
        Route::get('create', [AuditionController::class, 'create'])->name('create');
        Route::get('assign-manpower/{audition_id}', [AuditionController::class, 'assignManpower'])->name('assignManpower');
        Route::post('assign-manpower-store', [AuditionController::class, 'assignManpowerStore'])->name('assignManpowerStore');
        Route::post('store', [AuditionController::class, 'store'])->name('store');
        Route::resource('auditionAdmin', App\Http\Controllers\ManagerAdmin\Audition\AuditionAdminController::class);
        Route::get('assinged', [App\Http\Controllers\ManagerAdmin\Audition\AuditionAdminController::class, 'assinged'])->name('auditionAdmin.assinged');
        Route::get('free', [App\Http\Controllers\ManagerAdmin\Audition\AuditionAdminController::class, 'notAssinged'])->name('auditionAdmin.notAssinged');
        Route::get('pending', [AuditionController::class, 'pending'])->name('pending');
        Route::get('details/{id}', [AuditionController::class, 'details'])->name('details');
        Route::post('set_publish/{audition_id}', [AuditionController::class, 'manager_audition_set_publish'])->name('set_publish');
        Route::get('published', [AuditionController::class, 'published'])->name('published');
        Route::get('all', [AuditionAdminController::class, 'all'])->name('all');
        Route::get('instruction/{audition_id}', [AuditionAdminController::class, 'instruction'])->name('instruction');
        Route::get('send-instruction/{audition_id}', [AuditionAdminController::class, 'sendInstructionToParticipant'])->name('sendInstruction');
        Route::get('round-instruction/{audition_id}/{round_info_id}', [AuditionController::class, 'getRoundInstruction']);
        Route::post('round-instruction/published/{instruction_id}', [AuditionController::class, 'roundInstructionPublished'])->name('roundInstruction.published');
        Route::get('edit/{id}', [AuditionAdminController::class, 'auditionEdit'])->name('edit');
        Route::put('update/{id}', [AuditionAdminController::class, 'auditionUpdate'])->name('update');
        Route::get('admin-assign', [AuditionAdminController::class, 'adminAssign'])->name('adminAssign');
        Route::get('admin-assign-submit', [AuditionAdminController::class, 'adminAssignSubmit'])->name('adminAssignSubmit');
        Route::get('juries', [AuditionAdminController::class, 'auditionJuries'])->name('juries');
        Route::get('events', [AuditionAdminController::class, 'auditionEvents'])->name('events');
        Route::get('promoInstruction/{audition_id}', [AuditionAdminController::class, 'getPromoInstruction'])->name('promoInstruction');
        Route::get('roundInstruction/{audition_id}', [AuditionAdminController::class, 'getRoundInstruction'])->name('roundInstruction');
        Route::get('roundResult', [AuditionAdminController::class, 'getRoundResult'])->name('roundResult');
        Route::get('roundResult/{audition_id}', [AuditionAdminController::class, 'showRoundResult'])->name('showRoundResult');
        Route::get('viewRoundAppealResult/{audition_id}', [AuditionAdminController::class, 'viewRoundAppealResult'])->name('viewRoundAppealResult');
        Route::get('round-result/{audition_id}/{round_info_id}/{type}', [AuditionController::class, 'getResultByRound']);
        Route::post('round-result-publish', [AuditionController::class, 'roundResultPublish'])->name('roundResultPublish');
        Route::get('registerUser/{audition_id}', [AuditionController::class, 'registerUser'])->name('registerUser');
        Route::get('video-feed', [AuditionController::class, 'videoFeed'])->name('videoFeed');
        Route::get('video-feed-list/{round_id}', [AuditionController::class, 'videoFeedList'])->name('videoFeedList');
        Route::get('published-video-feed-list/{round_info_id}', [AuditionController::class, 'videoPublishedToVideofeed'])->name('videoPublishedToVideofeed');
    });
    // Audition routes ends here

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
    Route::post('star/active/{id}', [AdminController::class, 'activeNow'])->name('star.activeNow');
    Route::post('star/inactive/{id}', [AdminController::class, 'inactiveNow'])->name('star.inactiveNow');

    //For Super Star route
    Route::resource('star', SuperStarController::class);

    // Jury Board route
    Route::resource('jury', JuryBoardController::class);
    Route::post('jury/active/{id}', [JuryBoardController::class, 'activeNow'])->name('jury.activeNow');
    Route::post('jury/inactive/{id}', [JuryBoardController::class, 'inactiveNow'])->name('jury.inactiveNow');
    Route::get('jury-view/{jury_id}', [JuryBoardController::class, 'views'])->name('jury.views');
    Route::post('jury-video-assign', [JuryBoardController::class, 'assignVideo'])->name('jury.AssingVideos');


    // assigned route for admin to star or star to admin
    Route::resource('assigned', StarAssignedController::class);
    Route::get('dashboard/wildCardUser', [DashboardController::class, 'wildCardUser'])->name('wildCardUser');
    Route::get('dashboard/roundResult', [DashboardController::class, 'roundResult'])->name('roundResult');
    Route::get('dashboard/roundCompleteCard', [DashboardController::class, 'roundCompleteCard'])->name('roundCompleteCard');
    //====================== Accounts Route =================
    //manager panel start
    Route::get('accounts-index', [AccountsController::class, 'index'])->name('accounts.index');
    Route::get('accounts-index-superstar-filter/{subCat_id}', [AccountsController::class, 'accountSuperStarName']);
    Route::post('accountFilter', [AccountsController::class, 'accountFilter'])->name('accounts.accountFilter');
    Route::get('superstar-accounts/{id}/{module}', [AccountsController::class, 'superstarList'])->name('accounts.superstarList');
    //manager panel end
    
    // Audition
    Route::get('audition-totalIncome', [AccountsController::class, 'auditionTotalIncome'])->name('auditionTotalIncome');
    Route::get('audition-dailyIncome', [AccountsController::class, 'auditionDailyIncome'])->name('auditionDailyIncome');
    Route::get('audition-weeklyIncome', [AccountsController::class, 'auditionweeklyIncome'])->name('auditionWeeklyIncome');
    Route::get('audition-monthlyIncome', [AccountsController::class, 'auditionMonthlyIncome'])->name('auditionMonthlyIncome');
    Route::get('audition-yearlyIncome', [AccountsController::class, 'auditionYearlyIncome'])->name('auditionYearlyIncome');
    
    // <================================= All Report ======================================>
    Route::get('/audition-report', [ReportController::class, 'auditionReport'])->name('report.audition');
    Route::get('/all-report-filter-subCategory/{id}', [ReportController::class, 'allSubCategory']);
    // Route::get('/audition-report', [ReportController::class, 'auditionReport'])->name('report.audition');
});



Route::get('manager-admin/souvenir/order/list/{id}', [SouvenirController::class, 'allOrderDetails'])->name('managerAdmin.souvenir.allOrderDetails');


