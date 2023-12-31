<?php

use App\Http\Controllers\HomeController;
use App\Models\Slider;
use App\Models\PaymentMethod;
use Illuminate\Cache\Repository;
use Illuminate\Support\Facades\Route;
use App\Models\Audition\AuditionUserVoteMark;
use App\Http\Controllers\SuperAdmin\FAQController;
use App\Http\Controllers\SuperAdmin\QnAController;
use App\Http\Controllers\SuperAdmin\CityController;
use App\Http\Controllers\SuperAdmin\AdminController;
use App\Http\Controllers\SuperAdmin\StateController;
use App\Http\Controllers\SuperAdmin\EventsController;
use App\Http\Controllers\SuperAdmin\ReportController;
use App\Http\Controllers\SuperAdmin\AboutUsController;
use App\Http\Controllers\SuperAdmin\AuctionController;
use App\Http\Controllers\SuperAdmin\CountryController;
use App\Http\Controllers\SuperAdmin\PackageController;
use App\Http\Controllers\SuperAdmin\AccountsController;
use App\Http\Controllers\SuperAdmin\CategoryController;
use App\Http\Controllers\SuperAdmin\CurrencyController;
use App\Http\Controllers\SuperAdmin\FanGroupController;
use App\Http\Controllers\SuperAdmin\GreetingController;
use App\Http\Controllers\SuperAdmin\LiveChatController;
use App\Http\Controllers\SuperAdmin\SouvenirController;
use App\Http\Controllers\SuperAdmin\DashboardController;
use App\Http\Controllers\SuperAdmin\JuryBoardController;
use App\Http\Controllers\SuperAdmin\JuryGroupController;
use App\Http\Controllers\SuperAdmin\SuperStarController;
use App\Http\Controllers\SuperAdmin\OccupationController;
use App\Http\Controllers\SuperAdmin\SimplePostController;
use App\Http\Controllers\SuperAdmin\MarketplaceController;
use App\Http\Controllers\SuperAdmin\MeetupEventController;
use App\Http\Controllers\SuperAdmin\PackageLoveController;
use App\Http\Controllers\SuperAdmin\SubCategoryController;
use App\Http\Controllers\SuperAdmin\InterestTypeController;
use App\Http\Controllers\SuperAdmin\ManagerAdminController;
use App\Http\Controllers\SuperAdmin\AdminAuditionController;
use App\Http\Controllers\SuperAdmin\AuditionAdminController;
use App\Http\Controllers\SuperAdmin\AuditionRulesController;
use App\Http\Controllers\SuperAdmin\DashboardInfoController;
use App\Http\Controllers\SuperAdmin\JurysAuditionController;
use App\Http\Controllers\SuperAdmin\PrivacyPolicyController;
use App\Http\Controllers\SuperAdmin\EducationlevelController;
use App\Http\Controllers\SuperAdmin\LoveReactPriceController;
use App\Http\Controllers\SuperAdmin\LearningSessionController;
use App\Http\Controllers\SuperAdmin\AuditionUserVoteController;
use App\Http\Controllers\SuperAdmin\Audition\AuditionController;
use App\Http\Controllers\SuperAdmin\AuditionDashboardController;
use App\Http\Controllers\SuperAdmin\AuditionRoundRulesController;
use App\Http\Controllers\SuperAdmin\PaidLoveReactPriceController;
use App\Http\Controllers\SuperAdmin\ProductPurchaseController;
use App\Http\Controllers\SuperAdmin\ProfitWithdrawController;
use App\Http\Controllers\SuperAdmin\TermsConditionController;
use App\Http\Controllers\SuperAdmin\RefundController;
use App\Http\Controllers\SuperAdmin\VirtualtourController;
use App\Http\Controllers\SuperAdmin\DeliveryChargeController;
use App\Http\Controllers\SuperAdmin\RaffleDrowController;
use App\Http\Controllers\SuperAdmin\SouvenirDeliveryChargeController;

    // Super Admin routechange.password
    Route::group(['prefix' => 'super-admin/', 'as' => 'superAdmin.', 'middleware' => ['auth', 'superAdmin', 'prevent-back-history']], function () {

    // quize view
    Route::get('/quiz-result', [HomeController::class, 'viewAllQuize'])->name('showAllQuiz');

    //********************************************//
    //****** Raffle Drow Routes Start *******//
    //********************************************//
    Route::get('/all-user', [RaffleDrowController::class, 'allUser'])->name('alluser');
    Route::get('/country-user', [RaffleDrowController::class, 'countryUser'])->name('countryUser');
    Route::get('/select-user', [RaffleDrowController::class, 'selectedUser'])->name('selectUser');
    //Get All Winner
    Route::get('/all-winner-user', [RaffleDrowController::class, 'allWinnerUser'])->name('allwinneruser');
    Route::get('/country-winner-user', [RaffleDrowController::class, 'countryWinnerUser'])->name('countrywinneruser');
    //Resete Winner
    Route::post('/resete-user', [RaffleDrowController::class, 'reseteUser'])->name('reseteuser');
    //Notification Route cretemessage
    Route::get('/generalmessage/{code}', [RaffleDrowController::class, 'countryUserGeneralmessage'])->name('creategeneralmessage');
    Route::post('/general-notify', [RaffleDrowController::class, 'countryUserNotify'])->name('countryusernotify');
    Route::get('/winnermessage/{code}', [RaffleDrowController::class, 'countryUserWinnermessage'])->name('createwinnermessage');
    Route::post('/winner-notify', [RaffleDrowController::class, 'winnerUserNotify'])->name('winnerusernotify');
    //********************************************//
    //****** Raffle Drow Routes Start *******//
    //********************************************//

    //********************************************//
    //******Learning Session Routes Start *******//
    //********************************************//
    //================= Learning ===============//
    Route::get('learningSession-index', [LearningSessionController::class, 'index'])->name('learningSession.index');
    Route::get('learningSession-list/{id}', [LearningSessionController::class, 'learningSessionList'])->name('learningSession.list');
    Route::get('learningSession-details/{id}', [LearningSessionController::class, 'learningSessionDetails'])->name('learningSession.details');
    Route::get('learningSession-edit/{id}', [LearningSessionController::class, 'learningSessionEdit'])->name('learningSession.edit');
    Route::PUT('learningSession-update/{id}', [LearningSessionController::class, 'LearningSessionUpdate'])->name('learningSession.update');
    Route::delete('learningSession-destroy/{id}', [LearningSessionController::class, 'learningSessionDestroy'])->name('learningSession.destroy');
    //=================Dashboard Routes ===============//
    Route::get('/learning-session', [DashboardController::class, 'learningSessions'])->name('learningSessions');
    Route::get('/learningSession-events-dashboard', [DashboardController::class, 'learningSessionEventsDashboard'])->name('learningSessionEvents.dashboard');
    Route::get('/learningSession-data-list/{type}', [DashboardController::class, 'learningSessionDataList'])->name('learningSessionEvents.learningSessionDataList');
    Route::get('/learningSession-manager-list', [DashboardController::class, 'learningSessionManagerAdminList'])->name('learningSessionEvents.managerAdminList');
    Route::get('/learningSession-manager-events/{id}', [DashboardController::class, 'learningSessionManagerAdminEvents'])->name('learningSessionEvents.managerAdminEvents');
    Route::get('/learningSession-admin-list', [DashboardController::class, 'learningSessionAdminList'])->name('learningSessionEvents.adminList');
    Route::get('/learningSession-admin-events/{id}', [DashboardController::class, 'learningSessionAdminEvents'])->name('learningSessionEvents.adminEvents');
    Route::get('/learningSession-superstar-list', [DashboardController::class, 'learningSessionSuperstarList'])->name('learningSessionEvents.superstarList');
    Route::get('/learningSession-superstar-events/{id}', [DashboardController::class, 'learningSessionSuperstarEvents'])->name('learningSessionEvents.superstarEvents');
    Route::get('/all/learning-session', [DashboardInfoController::class, 'allLearningSession'])->name('allLearningSession');
    Route::get('/all/complete/learning-session', [DashboardInfoController::class, 'allCompleteLearningSession'])->name('allCompleteLearningSession');
    Route::get('/all/upcoming/learning-session', [DashboardInfoController::class, 'allUpcomingLearningSession'])->name('allUpcomingLearningSession');
    //===================== Reports Routes =====================//
    Route::get('/learningSession-report', [ReportController::class, 'learningSessionReport'])->name('report.learningSession');
    Route::post('/learningSession-report-filter', [ReportController::class, 'learningFilter'])->name('report.filter.learningSession');
    //********************************************//
    //******Learning Session Routes End *******//
    //********************************************//

    //********************************************//
    //******MeetUp Routes Start *******//
    //********************************************//
    //************************** Dashboard Route *************************//
    Route::get('/all/meetup', [DashboardInfoController::class, 'allMeetUp'])->name('allMeetUp');
    Route::get('/all/offline/meetup', [DashboardInfoController::class, 'allOfflineMeetUp'])->name('allOfflineMeetUp');
    Route::get('/all/offline/complete/meetup', [DashboardInfoController::class, 'allCompleteOfflineMeetUp'])->name('allCompleteOfflineMeetUp');
    Route::get('/all/online/complete/meetup', [DashboardInfoController::class, 'allCompleteOnlineMeetUp'])->name('allCompleteOnlineMeetUp');
    Route::get('/all/online/upcoming/meetup', [DashboardInfoController::class, 'allUpcomingOnlineMeetUp'])->name('allUpcomingOnlineMeetUp');
    Route::get('/all/offline/upcoming/meetup', [DashboardInfoController::class, 'allUpcomingOfflineMeetUp'])->name('allUpcomingOfflineMeetUp');
    Route::get('/meetup-events', [DashboardController::class, 'meetupEvents'])->name('meetupEvents');
    Route::get('/meetup-events-dashboard', [DashboardController::class, 'meetupEventsDashboard'])->name('meetupEvents.dashboard');
    Route::get('/meetup-data-list/{type}', [DashboardController::class, 'meetupDataList'])->name('meetupEvents.meetupDataList');
    Route::get('/meetup-manager-list', [DashboardController::class, 'meetupManagerAdminList'])->name('meetupEvents.managerAdminList');
    Route::get('/meetup-manager-events/{id}', [DashboardController::class, 'meetupManagerAdminEvents'])->name('meetupEvents.managerAdminEvents');
    Route::get('/meetup-admin-list', [DashboardController::class, 'meetupAdminList'])->name('meetupEvents.adminList');
    Route::get('/meetup-admin-events/{id}', [DashboardController::class, 'meetupAdminEvents'])->name('meetupEvents.adminEvents');
    Route::get('/meetup-superstar-list', [DashboardController::class, 'meetupSuperstarList'])->name('meetupEvents.superstarList');
    Route::get('/meetup-superstar-events/{id}', [DashboardController::class, 'meetupSuperstarEvents'])->name('meetupEvents.superstarEvents');
    //********************** Report Route *******************//
    Route::get('/meetup-report', [ReportController::class, 'meetupReport'])->name('report.meetup');
    Route::post('/meetup-report-filter', [ReportController::class, 'meetupReportFilter'])->name('report.filter.meetupevent');
    //******************** Meetup route *******************//
    Route::get('meetupEvent-index', [MeetupEventController::class, 'index'])->name('meetupEvent.index');
    Route::get('meetupEvent-list/{id}', [MeetupEventController::class, 'meetupEventList'])->name('meetupEvent.list');
    Route::get('meetupEvent-details/{id}', [MeetupEventController::class, 'meetupEventDetails'])->name('meetupEvent.details');
    Route::get('meetupEvent-edit/{id}', [MeetupEventController::class, 'meetupEventEdit'])->name('meetupEvent.edit');
    Route::PUT('meetupEvent-update/{id}', [MeetupEventController::class, 'meetupEventUpdate'])->name('meetupEvent.update');
    Route::delete('meetupEvent-destroy/{id}', [MeetupEventController::class, 'meetupEventDestroy'])->name('meetupEvent.destroy');
    //********************************************//
    //******MeetUp Routes End *******//
    //********************************************//

    //********************************************//
    //******Marketplace Routes Start *******//
    //********************************************//
    //********************* Delivery Routes ********************//
    Route::resource('marketplacedeliverycharge', DeliveryChargeController::class);
    Route::post('marketplacedeliverycharge-active/{id}', [DeliveryChargeController::class, 'activeNow'])->name('marketplacedeliverycharge.activeNow');
    Route::post('marketplacedeliverycharge-inactive/{id}', [DeliveryChargeController::class, 'inactiveNow'])->name('marketplacedeliverycharge.inactiveNow');
    //********************* Marketplace ********************//
    Route::get('marketplace-index', [MarketplaceController::class, 'index'])->name('marketplace.dashboard');
    Route::get('marketplace-list/{id}', [MarketplaceController::class, 'marketplaceList'])->name('marketplace.list');
    Route::get('marketplace-details/{id}', [MarketplaceController::class, 'marketplaceDetails'])->name('marketplace.details');
    Route::get('marketplace-edit/{id}', [MarketplaceController::class, 'marketplaceEdit'])->name('marketplace.edit');
    Route::PUT('marketplace-update/{id}', [MarketplaceController::class, 'marketplaceUpdate'])->name('marketplace.update');
    Route::delete('marketplace-destroy/{id}', [MarketplaceController::class, 'marketplaceDestroy'])->name('marketplace.destroy');
    //********************* Dashboard ********************//
    Route::get('/all/marketplace', [DashboardInfoController::class, 'allMarketplace'])->name('allMarketplace');
    Route::get('/marketplace-events-dashboard', [DashboardController::class, 'marketplaceEventsDashboard'])->name('marketplaceEvents.dashboard');
    Route::get('/marketplace-manager-list', [DashboardController::class, 'marketplaceManagerAdminList'])->name('marketplaceEvents.managerAdminList');
    Route::get('/marketplace-data-list/{type}', [DashboardController::class, 'marketplaceDataList'])->name('marketplaceEvents.marketplaceDataList');
    Route::get('/marketplace-manager-events/{id}', [DashboardController::class, 'marketplaceManagerAdminEvents'])->name('marketplaceEvents.managerAdminEvents');
     Route::get('/marketplace-admin-list', [DashboardController::class, 'marketplaceAdminList'])->name('marketplaceEvents.adminList');
     Route::get('/marketplace-admin-events/{id}', [DashboardController::class, 'marketplaceAdminEvents'])->name('marketplaceEvents.adminEvents');
     Route::get('/marketplace-superstar-list', [DashboardController::class, 'marketplaceSuperstarList'])->name('marketplaceEvents.superstarList');
    Route::get('/marketplace-superstar-events/{id}', [DashboardController::class, 'marketplaceSuperstarEvents'])->name('marketplaceEvents.superstarEvents');
    //********************* Report ********************//
    Route::get('/marketplace-report', [ReportController::class, 'marketplaceReport'])->name('report.marketplace');
    Route::post('/marketplace-report-filter', [ReportController::class, 'marketPlaceFilter'])->name('report.filter.marketPlace');
    //********************************************//
    //******Marketplace Routes End *******//
    //********************************************//

    //********************************************//
    //****** Souvenir Routes Start *******//
    //********************************************//
    //**************** Delivery Routes ***************//
    Route::resource('souvenirdeliverycharge', SouvenirDeliveryChargeController::class);
    Route::post('souvenirdeliverycharge-active/{id}', [SouvenirDeliveryChargeController::class, 'activeNow'])->name('souvenirdeliverycharge.activeNow');
    Route::post('souvenirdeliverycharge-inactive/{id}', [SouvenirDeliveryChargeController::class, 'inactiveNow'])->name('souvenirdeliverycharge.inactiveNow');
    //**************** Souvenir ***************//
    Route::get('souvenir-dashboard', [SouvenirController::class, 'dashboard'])->name('souvenir.dashboard');
    Route::get('souvenir-list/{id}', [SouvenirController::class, 'souvenirList'])->name('souvenir.list');
    Route::get('souvenir-details/{id}', [SouvenirController::class, 'souvenirDetails'])->name('souvenir.details');
    Route::get('souvenir-edit/{id}', [SouvenirController::class, 'souvenirEdit'])->name('souvenir.edit');
    Route::PUT('souvenir-update/{id}', [SouvenirController::class, 'souvenirUpdate'])->name('souvenir.update');
    Route::delete('souvenir-destroy/{id}', [SouvenirController::class, 'souvenirDestroy'])->name('souvenir.destroy');
    //**************** Souvenir Dashboard ***************//
    Route::get('/souvenir-events-dashboard', [DashboardController::class, 'souvenirEventsDashboard'])->name('souvenirEvents.dashboard');
    Route::get('/souvenir-data-list/{type}', [DashboardController::class, 'souvenirDataList'])->name('souvenirEvents.souvenirDataList');
    Route::get('/souvenir-manager-list', [DashboardController::class, 'souvenirManagerAdminList'])->name('souvenirEvents.managerAdminList');
    Route::get('/souvenir-manager-events/{id}', [DashboardController::class, 'souvenirManagerAdminEvents'])->name('souvenirEvents.managerAdminEvents');
    Route::get('/souvenir-admin-list', [DashboardController::class, 'souvenirAdminList'])->name('souvenirEvents.adminList');
    Route::get('/souvenir-admin-events/{id}', [DashboardController::class, 'souvenirAdminEvents'])->name('souvenirEvents.adminEvents');
    Route::get('/souvenir-superstar-list', [DashboardController::class, 'souvenirSuperstarList'])->name('souvenirEvents.superstarList');
    Route::get('/souvenir-superstar-events/{id}', [DashboardController::class, 'souvenirSuperstarEvents'])->name('souvenirEvents.superstarEvents');
    //**************** Souvenir Reports ***************//
    Route::get('/souvenir-report', [ReportController::class, 'souvenirReport'])->name('report.souvenir');
    Route::post('/souvenir-report-filter', [ReportController::class, 'souvenirReportFilter'])->name('report.filter.souvenirReport');
    //********************************************//
    //******Souvenir Routes End *******//
    //********************************************//

    //********************************************//
    //******Auction Routes End *******//
    //********************************************//
    //**************** Auction ***************//
    Route::get('auction-index', [AuctionController::class, 'index'])->name('auction.index');
    Route::get('terms-create', [AuctionController::class, 'termsCreate'])->name('auctionTerms.create');
    Route::post('terms-store', [AuctionController::class, 'termsStore'])->name('auctionTerms.store');
    Route::get('terms-edit/{id}', [AuctionController::class, 'termsEdit'])->name('auctionTerms.edit');
    Route::put('terms-update/{id}', [AuctionController::class, 'termsUpdate'])->name('auctionTerms.update');
    Route::delete('terms-destroy/{id}', [AuctionController::class, 'termsDestroy'])->name('auctionTerms.destroy');
    Route::get('auction-dashboard', [AuctionController::class, 'dashboard'])->name('auction.dashboard');
    Route::get('auction-list/{id}', [AuctionController::class, 'auctionList'])->name('auction.list');
    Route::get('auction-details/{id}', [AuctionController::class, 'auctionDetails'])->name('auction.details');
    Route::get('auction-edit/{id}', [AuctionController::class, 'auctionEdit'])->name('auction.edit');
    Route::PUT('auction-update/{id}', [AuctionController::class, 'auctionUpdate'])->name('auction.update');
    Route::delete('auction-destroy/{id}', [AuctionController::class, 'auctionDestroy'])->name('auction.destroy');
    //**************** Dashboard ***************//
    Route::get('/all/auction', [DashboardInfoController::class, 'allAuction'])->name('allAuction');
    Route::get('/auction-events-dashboard', [DashboardController::class, 'auctionEventsDashboard'])->name('auctionEvents.dashboard');
    Route::get('/auction-data-list/{type}', [DashboardController::class, 'auctionDataList'])->name('auctionEvents.auctionDataList');
    Route::get('/auction-manager-list', [DashboardController::class, 'auctionManagerAdminList'])->name('auctionEvents.managerAdminList');
    Route::get('/auction-manager-events/{id}', [DashboardController::class, 'auctionManagerAdminEvents'])->name('auctionEvents.managerAdminEvents');
    Route::get('/auction-admin-list', [DashboardController::class, 'auctionAdminList'])->name('auctionEvents.adminList');
    Route::get('/auction-admin-events/{id}', [DashboardController::class, 'auctionAdminEvents'])->name('auctionEvents.adminEvents');
    Route::get('/auction-superstar-list', [DashboardController::class, 'auctionSuperstarList'])->name('auctionEvents.superstarList');
    Route::get('/auction-superstar-events/{id}', [DashboardController::class, 'auctionSuperstarEvents'])->name('auctionEvents.superstarEvents');
    //**************** Reports ***************//
    Route::get('/auction-report', [ReportController::class, 'auctionReport'])->name('report.auction');
    Route::post('/auction-report-filter', [ReportController::class, 'auctionReportFilter'])->name('report.filter.auctionReport');
    //********************************************//
    //******Auction Routes End *******//
    //********************************************//

    //********************************************//
    //******Greetings Routes Start *******//
    //********************************************//
    //********* Greeting Type ************//
    Route::resource('greeting-type', GreetingController::class);
    Route::post('admin/greeting-type-active/{id}', [GreetingController::class, 'activeNow'])->name('greetingtype.activeNow');
    Route::post('admin/greeting-type-inactive/{id}', [GreetingController::class, 'inactiveNow'])->name('greetingtype.inactiveNow');
    //********* Greeting ****************//
    Route::get('greeting-index', [GreetingController::class, 'events'])->name('greeting.index');
    Route::get('greeting-list/{id}', [GreetingController::class, 'greetingList'])->name('greeting.list');
    Route::get('greeting-details/{id}', [GreetingController::class, 'greetingDetails'])->name('greeting.details');
    Route::get('greeting-edit/{id}', [GreetingController::class, 'greetingEdit'])->name('greeting.edit');
    Route::PUT('greeting-update/{id}', [GreetingController::class, 'greetingUpdate'])->name('greeting.update');
    Route::delete('greeting-destroy/{id}', [GreetingController::class, 'greetingDestroy'])->name('greeting.destroy');
    //********* Dashboard ****************//
    Route::get('/greetings', [DashboardController::class, 'greetings'])->name('greetings');
    Route::get('/all/greetings', [DashboardInfoController::class, 'allGreeting'])->name('allGreeting');
    Route::get('/all/complete/greetings', [DashboardInfoController::class, 'allCompleteGreeting'])->name('allCompleteGreeting');
    Route::get('/all/upcoming/greetings', [DashboardInfoController::class, 'allUpcomingGreeting'])->name('allUpcomingGreeting');
    Route::get('/greeting-events-dashboard', [DashboardController::class, 'greetingEventsDashboard'])->name('greetingEvents.dashboard');
    Route::get('/greeting-data-list/{type}', [DashboardController::class, 'greetingDataList'])->name('greetingEvents.greetingDataList');
    Route::get('/greeting-manager-list', [DashboardController::class, 'greetingManagerAdminList'])->name('greetingEvents.managerAdminList');
    Route::get('/greeting-manager-events/{id}', [DashboardController::class, 'greetingManagerAdminEvents'])->name('greetingEvents.managerAdminEvents');
    Route::get('/greeting-admin-list', [DashboardController::class, 'greetingAdminList'])->name('greetingEvents.adminList');
    Route::get('/greeting-admin-events/{id}', [DashboardController::class, 'greetingAdminEvents'])->name('greetingEvents.adminEvents');
    Route::get('/greeting-superstar-list', [DashboardController::class, 'greetingSuperstarList'])->name('greetingEvents.superstarList');
    Route::get('/greeting-superstar-events/{id}', [DashboardController::class, 'greetingSuperstarEvents'])->name('greetingEvents.superstarEvents');
    //********* Reports ****************/
    Route::get('/greeting-report', [ReportController::class, 'greetingReport'])->name('report.greeting');
    Route::post('/greeting-report-filter', [ReportController::class, 'greetingReportFilter'])->name('report.filter.greeting');
    //********************************************//
    //******Greetings Routes End *******//
    //********************************************//

    //********************************************//
    //******Simple Post Routes Start *******//
    //********************************************//
    //*********** Simple Post ************//
    Route::get('simplepost-index', [SimplePostController::class, 'index'])->name('simplePost.index');
    Route::get('simplepost-list/{id}', [SimplePostController::class, 'simplepostList'])->name('simplePost.list');
    Route::get('simplepost-details/{id}', [SimplePostController::class, 'simplepostDetails'])->name('simplePost.details');
    Route::get('simplepost-edit/{id}', [SimplePostController::class, 'simplepostEdit'])->name('simplePost.edit');
    Route::PUT('simplepost-update/{id}', [SimplePostController::class, 'simplepostUpdate'])->name('simplePost.update');
    Route::delete('simplepost-destroy/{id}', [SimplePostController::class, 'simplepostDestroy'])->name('simplePost.destroy');
    //*********** Dashboard ************//
    Route::get('/simplePost-events-dashboard', [DashboardController::class, 'simplePostEventsDashboard'])->name('simplePostEvents.dashboard');
    Route::get('/simplePost-data-list/{type}', [DashboardController::class, 'postDataList'])->name('simplePostEvents.postDataList');
    Route::get('/simplePost-manager-list', [DashboardController::class, 'simplePostManagerAdminList'])->name('simplePostEvents.managerAdminList');
    Route::get('/simplePost-manager-events/{id}', [DashboardController::class, 'simplePostManagerAdminEvents'])->name('simplePostEvents.managerAdminEvents');
    Route::get('/simplePost-admin-list', [DashboardController::class, 'simplePostAdminList'])->name('simplePostEvents.adminList');
    Route::get('/simplePost-admin-events/{id}', [DashboardController::class, 'simplePostAdminEvents'])->name('simplePostEvents.adminEvents');
    Route::get('/simplePost-superstar-list', [DashboardController::class, 'simplePostSuperstarList'])->name('simplePostEvents.superstarList');
    Route::get('/simplePost-superstar-events/{id}', [DashboardController::class, 'simplePostSuperstarEvents'])->name('simplePostEvents.superstarEvents');
    //*********** Reports ************//
    Route::get('/simplePost-report', [ReportController::class, 'simplePostReport'])->name('report.simplePost');
    Route::post('/simplePost-report-filter', [ReportController::class, 'simplePostFilter'])->name('report.filter.simplePost');
    Route::get('/simplePost-report-filter-userType/{name}', [ReportController::class, 'simplePostUserName']);
    //********************************************//
    //******Simple Post Routes End *******//
    //********************************************//

    //********************************************//
    //****** Fan Group Routes Start *******//
    //********************************************//
    //========== Fangroup ==========//
    Route::get('fanGroup-index', [FanGroupController::class, 'index'])->name('fanGroup.index');
    Route::get('fanGroup-list/{id}', [FanGroupController::class, 'fanGroupList'])->name('fanGroup.list');
    Route::get('fanGroup-details/{id}', [FanGroupController::class, 'fanGroupDetails'])->name('fanGroup.details');
    Route::get('fanGroup-edit/{id}', [FanGroupController::class, 'fanGroupEdit'])->name('fanGroup.edit');
    Route::PUT('fanGroup-update/{id}', [FanGroupController::class, 'fanGroupUpdate'])->name('fanGroup.update');
    Route::delete('fanGroup-destroy/{id}', [FanGroupController::class, 'fanGroupDestroy'])->name('fanGroup.destroy');
    //========== Dashboard ==========//
    Route::get('/fan-group', [DashboardController::class, 'fanGroup'])->name('fanGroup');
    Route::get('/fanGroup-events-dashboard', [DashboardController::class, 'fanGroupEventsDashboard'])->name('fanGroupEvents.dashboard');
    Route::get('/fanGroup-data-list/{type}', [DashboardController::class, 'fanGroupDataList'])->name('fanGroupEvents.fanGroupDataList');
    Route::get('/fanGroup-manager-list', [DashboardController::class, 'fanGroupManagerAdminList'])->name('fanGroupEvents.managerAdminList');
    Route::get('/fanGroup-manager-events/{id}', [DashboardController::class, 'fanGroupManagerAdminEvents'])->name('fanGroupEvents.managerAdminEvents');
    Route::get('/fanGroup-admin-list', [DashboardController::class, 'fanGroupAdminList'])->name('fanGroupEvents.adminList');
    Route::get('/fanGroup-admin-events/{id}', [DashboardController::class, 'fanGroupAdminEvents'])->name('fanGroupEvents.adminEvents');
    Route::get('/fanGroup-superstar-list', [DashboardController::class, 'fanGroupSuperstarList'])->name('fanGroupEvents.superstarList');
    Route::get('/fanGroup-superstar-events/{id}', [DashboardController::class, 'fanGroupSuperstarEvents'])->name('fanGroupEvents.superstarEvents');
    //========== Report ==========//
    Route::get('/fanGroup-report', [ReportController::class, 'fanGroupReport'])->name('report.fanGroup');
    //********************************************//
    //****** Fan Group Routes End *******//
    //********************************************//

    //********************************************//
    //****** Live Chat Routes Start *******//
    //********************************************//
    //========== LiveChat ==========//
    Route::get('liveChat-index', [LiveChatController::class, 'index'])->name('liveChat.index');
    Route::get('liveChat-list/{id}', [LiveChatController::class, 'liveChatList'])->name('liveChat.list');
    Route::get('liveChat-details/{id}', [LiveChatController::class, 'liveChatDetails'])->name('liveChat.details');
    Route::get('liveChat-edit/{id}', [LiveChatController::class, 'liveChatEdit'])->name('liveChat.edit');
    Route::PUT('liveChat-update/{id}', [LiveChatController::class, 'livechatUpdate'])->name('liveChat.update');
    Route::delete('liveChat-destroy/{id}', [LiveChatController::class, 'liveChatDestroy'])->name('liveChat.destroy');
    //========== Dashboard ==========//
    Route::get('/all/live-chat', [DashboardInfoController::class, 'allLiveChat'])->name('allLiveChat');
    Route::get('/all/complete/live-chat', [DashboardInfoController::class, 'allCompleteLiveChat'])->name('allCompleteLiveChat');
    Route::get('/all/upcoming/live-chat', [DashboardInfoController::class, 'allUpcomingLiveChat'])->name('allUpcomingLiveChat');
    Route::get('/all/running/live-chat', [DashboardInfoController::class, 'allRunningLiveChat'])->name('allRunningLiveChat');
    Route::get('/live-chats', [DashboardController::class, 'liveChats'])->name('liveChats');
    Route::get('/liveChat-events-dashboard', [DashboardController::class, 'liveChatEventsDashboard'])->name('liveChatEvents.dashboard');
    Route::get('/liveChat-data-list/{type}', [DashboardController::class, 'liveChatDataList'])->name('liveChatEvents.liveChatDataList');
    Route::get('/liveChat-manager-list', [DashboardController::class, 'liveChatManagerAdminList'])->name('liveChatEvents.managerAdminList');
    Route::get('/liveChat-manager-events/{id}', [DashboardController::class, 'liveChatManagerAdminEvents'])->name('liveChatEvents.managerAdminEvents');
    Route::get('/liveChat-admin-list', [DashboardController::class, 'liveChatAdminList'])->name('liveChatEvents.adminList');
    Route::get('/liveChat-admin-events/{id}', [DashboardController::class, 'liveChatAdminEvents'])->name('liveChatEvents.adminEvents');
    Route::get('/liveChat-superstar-list', [DashboardController::class, 'liveChatSuperstarList'])->name('liveChatEvents.superstarList');
    Route::get('/liveChat-superstar-events/{id}', [DashboardController::class, 'liveChatSuperstarEvents'])->name('liveChatEvents.superstarEvents');
    //========== Report ==========//
    Route::get('/liveChat-report', [ReportController::class, 'liveChatReport'])->name('report.liveChat');
    Route::post('/liveChat-report', [ReportController::class, 'liveChatReportFilter'])->name('report.Filter.liveChat');
    //********************************************//
    //****** Live Chat Routes End *******//
    //********************************************//

    //********************************************//
    //****** QNA Routes Start *******//
    //********************************************//
    //========== QNA ==========//
    Route::get('qna-index', [QnAController::class, 'index'])->name('qna.index');
    Route::get('qna-list/{id}', [QnAController::class, 'qnaList'])->name('qna.list');
    Route::get('qna-details/{id}', [QnAController::class, 'qnaDetails'])->name('qna.details');
    Route::get('qna-edit/{id}', [QnAController::class, 'qnaEdit'])->name('qna.edit');
    Route::PUT('qna-update/{id}', [QnAController::class, 'qnaUpdate'])->name('qna.update');
    Route::delete('qna-destroy/{id}', [QnAController::class, 'qnaDestroy'])->name('qna.destroy');
    //========== Dashboard ==========//
    Route::get('/qna-events-dashboard', [DashboardController::class, 'qnaEventsDashboard'])->name('qnaEvents.dashboard');
    Route::get('/qna-data-list/{type}', [DashboardController::class, 'qnaDataList'])->name('qnaEvents.qnaDataList');
    Route::get('/qna-manager-list', [DashboardController::class, 'qnaManagerAdminList'])->name('qnaEvents.managerAdminList');
    Route::get('/qna-manager-events/{id}', [DashboardController::class, 'qnaManagerAdminEvents'])->name('qnaEvents.managerAdminEvents');
    Route::get('/qna-admin-list', [DashboardController::class, 'qnaAdminList'])->name('qnaEvents.adminList');
    Route::get('/qna-admin-events/{id}', [DashboardController::class, 'qnaAdminEvents'])->name('qnaEvents.adminEvents');
    Route::get('/qna-superstar-list', [DashboardController::class, 'qnaSuperstarList'])->name('qnaEvents.superstarList');
    Route::get('/qna-superstar-events/{id}', [DashboardController::class, 'qnaSuperstarEvents'])->name('qnaEvents.superstarEvents');
    //========== Report ==========//
    Route::get('/qna-report', [ReportController::class, 'qnaReport'])->name('report.qna');
    Route::post('/qna-report-filter', [ReportController::class, 'qnaReportFilter'])->name('report.Filter.qna');
    //********************************************//
    //****** QNA Routes End *******//
    //********************************************//

    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/withdraw', [ProfitWithdrawController::class, 'index'])->name('withdraw.index');
    Route::put('/txn-store/{id}', [ProfitWithdrawController::class, 'store'])->name('bankTxnId.store');
    Route::get('/settings', [DashboardController::class, 'settings'])->name('settings');
    Route::post('/profile/change/store', [DashboardController::class, 'changeProfile'])->name('change.profile');
    Route::post('/change/password/store', [DashboardController::class, 'changePassword'])->name('change.password');
    Route::get('/user-posts', [DashboardController::class, 'userPosts'])->name('userPosts');
    Route::get('/wallet', [DashboardController::class, 'wallets'])->name('wallets');
    // Route::get('/package', [DashboardController::class, 'package'])->name('package');
    // Route::get('/add-package', [DashboardController::class, 'addPackage'])->name('addPackage');
    // Route::post('/store-package', [DashboardController::class, 'packageStore'])->name('packageStore');

    //Dashboard Information
    Route::get('/all/user', [DashboardInfoController::class, 'allUser'])->name('allUser');
    Route::get('/all/star', [DashboardInfoController::class, 'allStar'])->name('allStar');
    Route::get('/all/admin', [DashboardInfoController::class, 'allAdmin'])->name('allAdmin');

    //Post
    Route::get('/all/post/list', [DashboardInfoController::class, 'allPost'])->name('allPost');
    Route::get('/all/post/daily', [DashboardInfoController::class, 'dailyPost'])->name('dailyPost');
    Route::get('/all/post/weekly', [DashboardInfoController::class, 'weeklyPost'])->name('weeklyPost');
    Route::get('/all/post/monthly', [DashboardInfoController::class, 'monthlyPost'])->name('monthlyPost');

    //Super Admin Profile
    Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');
    Route::get('/settings', [DashboardController::class, 'settings'])->name('settings');
    Route::post('/change/password/store', [DashboardController::class, 'changePassword'])->name('change.password');

    // manager admin
    Route::get('/manager-admin/list', [ManagerAdminController::class, 'list'])->name('managerAdminList');

    // category
    Route::resource('category', CategoryController::class);

    // Audition Routes starts here
    Route::get('/auditions', [DashboardController::class, 'auditions'])->name('auditions');
    Route::resource('audition-rules', AuditionRulesController::class);
    Route::resource('audition-round-rules', AuditionRoundRulesController::class);
    Route::get('audition-round-rules/mark/{rules_id}', [AuditionRoundRulesController::class, 'getMark']);
    Route::resource('jury_groups', JuryGroupController::class);
    Route::resource('auditionAdmin', AuditionAdminController::class);
    Route::post('auditionAdmin/active/{id}', [AuditionAdminController::class, 'activeNow'])->name('auditionAdmin.activeNow');
    Route::post('auditionAdmin/inactive/{id}', [AuditionAdminController::class, 'inactiveNow'])->name('auditionAdmin.inactiveNow');
    Route::get('/audition-list', [AuditionController::class, 'auditionList'])->name('auditionList');
    Route::get('audition-admin-accounts', [AccountsController::class, 'auditionAdminList'])->name('accounts.auditionAdminList');
    Route::get('audition-admin-income', [AccountsController::class, 'auditionAdminIncome'])->name('auditionAdmin.income');
    Route::get('setMark/{id}', [AuditionController::class, 'setMark'])->name('audition.setMark');
    Route::put('setMark/{id}', [AuditionController::class, 'setMarkUpdate'])->name('audition.setMarkUpdate');

    // audition dashboard
    Route::get('/audition-events-dashboard', [DashboardController::class, 'auditionEventsDashboard'])->name('auditionEvents.dashboard');
    Route::get('/audition-list/{id}', [DashboardController::class, 'auditionList'])->name('auditionEvent.list');
    Route::get('/audition-data-list/{type}', [DashboardController::class, 'auditionDataList'])->name('auditionEvents.auditionDataList');
    Route::get('/audition-manager-list', [DashboardController::class, 'auditionManagerAdminList'])->name('auditionEvents.managerAdminList');
    Route::get('/audition-manager-events/{id}', [DashboardController::class, 'auditionManagerAdminEvents'])->name('auditionEvents.managerAdminEvents');
    Route::get('/audition-admin-list', [DashboardController::class, 'adminList'])->name('auditionEvents.adminList');
    Route::get('/audition-admin-events/{id}', [DashboardController::class, 'adminEvents'])->name('auditionEvents.adminEvents');
    Route::get('/audition-superstar-list', [DashboardController::class, 'auditionSuperstarList'])->name('auditionEvents.superstarList');
    Route::get('/audition-superstar-events/{id}', [DashboardController::class, 'auditionSuperstarEvents'])->name('auditionEvents.superstarEvents');
    Route::get('/auditionAdmin-list', [DashboardController::class, 'auditionAdminList'])->name('auditionEvents.auditionAdminList');
    Route::get('/audition-events/{id}', [DashboardController::class, 'auditionAdminEvents'])->name('auditionEvents.auditionAdminEvents');
    Route::get('/audition-events/details/{id}', [DashboardController::class, 'auditionDetails'])->name('audition.details');
    Route::get('/audition-events/round/details/{id}', [DashboardController::class, 'roundDetails'])->name('round.details');
    Route::get('/audition-events/edit/{id}', [DashboardController::class, 'auditionEdit'])->name('audition.edit');
    Route::put('/audition-events/update/{id}', [DashboardController::class, 'auditionUpdate'])->name('audition.update');
    Route::delete('/audition-events/destroy/{id}', [DashboardController::class, 'auditionDestroy'])->name('audition.destroy');

    // UserVoteMarkSetting
    Route::get('audition-user-mark', [AuditionUserVoteController::class, 'index'])->name('userVoteMark.index');
    Route::get('userVoteMark-create', [AuditionUserVoteController::class, 'userVoteMarkCreate'])->name('userVoteMark.create');
    Route::post('userVoteMark-store', [AuditionUserVoteController::class, 'userVoteMarkStore'])->name('userVoteMark.store');
    Route::get('userVoteMark-edit/{id}', [AuditionUserVoteController::class, 'userVoteMarkEdit'])->name('userVoteMark.edit');
    Route::put('userVoteMark-update/{id}', [AuditionUserVoteController::class, 'userVoteMarkUpdate'])->name('userVoteMark.update');
    Route::delete('userVoteMark-destroy/{id}', [AuditionUserVoteController::class, 'userVoteMarkDestroy'])->name('userVoteMark.destroy');

    // Paid Love React Price Setting
    Route::get('paid-love-react-price', [PaidLoveReactPriceController::class, 'index'])->name('loveReactPrice.index');
    Route::get('loveReactPrice-create', [PaidLoveReactPriceController::class, 'loveReactPriceCreate'])->name('loveReactPrice.create');
    Route::post('loveReactPrice-store', [PaidLoveReactPriceController::class, 'loveReactPriceStore'])->name('loveReactPrice.store');
    Route::get('loveReactPrice-edit/{id}', [PaidLoveReactPriceController::class, 'loveReactPriceEdit'])->name('loveReactPrice.edit');
    Route::put('loveReactPrice-update/{id}', [PaidLoveReactPriceController::class, 'loveReactPriceUpdate'])->name('loveReactPrice.update');
    Route::delete('loveReactPrice-destroy/{id}', [PaidLoveReactPriceController::class, 'loveReactPriceDestroy'])->name('loveReactPrice.destroy');
    // Audition Routes ends here


    // Product Purchase
    Route::resource('productpurchase', ProductPurchaseController::class);

    // Tersm and Condtition
    Route::resource('termscondition', TermsConditionController::class);

    // Refund Policy
    Route::resource('refundpolicy', RefundController::class);

    // Events
    Route::resource('events', EventsController::class);

    // Country
    Route::resource('country', CountryController::class);
    Route::post('admin/country-active/{id}', [CountryController::class, 'activeNow'])->name('country.activeNow');
    Route::post('admin/country-inactive/{id}', [CountryController::class, 'inactiveNow'])->name('country.inactiveNow');

    // Package
    Route::resource('package', PackageController::class);
    Route::resource('love', LoveReactPriceController::class);

    // Route::resource('love-package', LoveController::class);
    Route::post('admin/package-active/{id}', [PackageController::class, 'activeNow'])->name('package.activeNow');
    Route::post('admin/package-inactive/{id}', [PackageController::class, 'inactiveNow'])->name('package.inactiveNow');

    // State
    Route::resource('state', StateController::class);
    Route::post('admin/state-active/{id}', [StateController::class, 'activeNow'])->name('state.activeNow');
    Route::post('admin/state-inactive/{id}', [StateController::class, 'inactiveNow'])->name('state.inactiveNow');

    // City
    Route::resource('city', CityController::class);
    Route::get('get-state/{id}', [CityController::class, 'getState'])->name('getState');
    Route::post('admin/city-active/{id}', [CityController::class, 'activeNow'])->name('city.activeNow');
    Route::post('admin/city-inactive/{id}', [CityController::class, 'inactiveNow'])->name('city.inactiveNow');

    //Education Level
    Route::resource('educationlevel', EducationlevelController::class);

    //AboutUs Level
    Route::resource('aboutUs', AboutUsController::class);
    Route::resource('privacy', PrivacyPolicyController::class);
    Route::resource('faq', FAQController::class);

    //Occupation
    Route::resource('occupation', OccupationController::class);
    Route::post('admin/occupation-active/{id}', [OccupationController::class, 'activeNow'])->name('occupation.activeNow');
    Route::post('admin/occupation-inactive/{id}', [OccupationController::class, 'inactiveNow'])->name('occupation.inactiveNow');

    //Virtual Tour
    Route::resource('virtual-tour', VirtualtourController::class);

    // Interest Type
    Route::resource('interest-type', InterestTypeController::class);
    Route::post('admin/interest-type-active/{id}', [InterestTypeController::class, 'activeNow'])->name('interestType.activeNow');
    Route::post('admin/interest-type-inactive/{id}', [InterestTypeController::class, 'inactiveNow'])->name('interestType.inactiveNow');

    // subCategory
    Route::resource('subCategory', SubCategoryController::class);

    // slider
    Route::resource('slider', Slider::class);

    //payment method
    Route::resource('paymentMethod', PaymentMethod::class);

    // managerAdmin
    Route::resource('managerAdmin', ManagerAdminController::class);

    // Currency route
    Route::resource('currency', CurrencyController::class);
    Route::post('currency/active/{id}', [CurrencyController::class, 'activeNow'])->name('currency.activeNow');
    Route::post('currency/inactive/{id}', [CurrencyController::class, 'inactiveNow'])->name('currency.inactiveNow');
    Route::post('currency/changes', [CurrencyController::class, 'currencyChanges'])->name('currency.currencyChanges');

    // Admin route
    Route::resource('admin', AdminController::class);
    Route::get('admin/{category_id}/get-subcategory', [AdminController::class, 'getSubCategory']);
    Route::post('admin/active/{id}', [AdminController::class, 'activeNow'])->name('admin.activeNow');
    Route::post('admin/inactive/{id}', [AdminController::class, 'inactiveNow'])->name('admin.inactiveNow');
    Route::get('admin/starlist', [AdminController::class, 'starlist'])->name('admin.starlist');
    Route::resource('star', SuperStarController::class);
    Route::post('star/active/{id}', [SuperStarController::class, 'activeNow'])->name('star.activeNow');
    Route::post('star/inactive/{id}', [SuperStarController::class, 'inactiveNow'])->name('star.inactiveNow');

    // Jury Route
    Route::resource('jury', JuryBoardController::class);
    Route::post('jury/active/{id}', [JuryBoardController::class, 'activeNow'])->name('jury.activeNow');
    Route::post('jury/inactive/{id}', [JuryBoardController::class, 'inactiveNow'])->name('jury.inactiveNow');

    // superadmin start
    Route::get('accounts-index', [AccountsController::class, 'index'])->name('accounts.index');
    Route::get('accounts-index-superstar-filter/{subCat_id}/{cat_id}', [AccountsController::class, 'accountSuperStarName']);
    Route::get('all-accounts-filter-subCategory/{id}', [AccountsController::class, 'allSubCategory']);
    Route::post('accountFilter', [AccountsController::class, 'accountFilter'])->name('accounts.accountFilter');
    Route::get('superstar-accounts/{id}/{module}', [AccountsController::class, 'superstarList'])->name('accounts.superstarList');
    // superadmin end

    // <================================= All Report ======================================>
    Route::get('/audition-report', [ReportController::class, 'auditionReport'])->name('report.audition');
    Route::get('/all-report-filter-subCategory/{id}', [ReportController::class, 'allSubCategory']);
    // Route::get('/audition-report', [ReportController::class, 'auditionReport'])->name('report.audition');

    // <=================================End All Report ======================================>
});
