<?php

use App\Http\Controllers\SuperAdmin\AdminAuditionController;
use App\Http\Controllers\SuperAdmin\AuditionAdminController;
use App\Http\Controllers\SuperAdmin\Audition\AuditionController;
use App\Http\Controllers\SuperAdmin\DashboardController;
use App\Http\Controllers\SuperAdmin\ManagerAdminController;
use App\Http\Controllers\SuperAdmin\AdminController;
use App\Http\Controllers\SuperAdmin\AuctionController;
use App\Http\Controllers\SuperAdmin\AuditionDashboardController;
use App\Http\Controllers\SuperAdmin\AuditionRoundRulesController;
use App\Http\Controllers\SuperAdmin\AuditionRulesController;
use App\Http\Controllers\SuperAdmin\SuperStarController;
use App\Http\Controllers\SuperAdmin\JuryBoardController;
use App\Http\Controllers\SuperAdmin\DashboardInfoController;
use App\Http\Controllers\SuperAdmin\CategoryController;
use App\Http\Controllers\SuperAdmin\CountryController;
use App\Http\Controllers\SuperAdmin\PackageController;
use App\Http\Controllers\SuperAdmin\StateController;
use App\Http\Controllers\SuperAdmin\MarketplaceController;
use App\Http\Controllers\SuperAdmin\CityController;
use App\Http\Controllers\SuperAdmin\EventsController;
use App\Http\Controllers\SuperAdmin\GreetingController;
use App\Http\Controllers\SuperAdmin\InterestTypeController;
use App\Http\Controllers\SuperAdmin\JurysAuditionController;
use App\Http\Controllers\SuperAdmin\LiveChatController;
use App\Http\Controllers\SuperAdmin\SimplePostController;
use App\Http\Controllers\SuperAdmin\SubCategoryController;
use App\Models\PaymentMethod;
use App\Models\Slider;
use Illuminate\Support\Facades\Route;

// Super Admin route

Route::group(['prefix' => 'super-admin/', 'as' => 'superAdmin.', 'middleware' => ['auth', 'superAdmin']], function () {

    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/auditions', [DashboardController::class, 'auditions'])->name('auditions');
    Route::get('/meetup-events', [DashboardController::class, 'meetupEvents'])->name('meetupEvents');
    Route::get('/learning-session', [DashboardController::class, 'learningSessions'])->name('learningSessions');
    Route::get('/live-chats', [DashboardController::class, 'liveChats'])->name('liveChats');
    Route::get('/fan-group', [DashboardController::class, 'fanGroup'])->name('fanGroup');
    Route::get('/greetings', [DashboardController::class, 'greetings'])->name('greetings');
    Route::get('/user-posts', [DashboardController::class, 'userPosts'])->name('userPosts');
    Route::get('/wallet', [DashboardController::class, 'wallets'])->name('wallets');

    // Route::get('/package', [DashboardController::class, 'package'])->name('package');
    // Route::get('/add-package', [DashboardController::class, 'addPackage'])->name('addPackage');
    // Route::post('/store-package', [DashboardController::class, 'packageStore'])->name('packageStore');

    //Dashboard Information
    Route::get('/all/user', [DashboardInfoController::class, 'allUser'])->name('allUser');
    Route::get('/all/star', [DashboardInfoController::class, 'allStar'])->name('allStar');
    Route::get('/all/admin', [DashboardInfoController::class, 'allAdmin'])->name('allAdmin');
    Route::get('/all/marketplace', [DashboardInfoController::class, 'allMarketplace'])->name('allMarketplace');
    Route::get('/all/auction', [DashboardInfoController::class, 'allAuction'])->name('allAuction');

    //MeetUp Events
    Route::get('/all/meetup', [DashboardInfoController::class, 'allMeetUp'])->name('allMeetUp');
    Route::get('/all/offline/meetup', [DashboardInfoController::class, 'allOfflineMeetUp'])->name('allOfflineMeetUp');
    Route::get('/all/offline/complete/meetup', [DashboardInfoController::class, 'allCompleteOfflineMeetUp'])->name('allCompleteOfflineMeetUp');
    Route::get('/all/online/complete/meetup', [DashboardInfoController::class, 'allCompleteOnlineMeetUp'])->name('allCompleteOnlineMeetUp');
    Route::get('/all/online/upcoming/meetup', [DashboardInfoController::class, 'allUpcomingOnlineMeetUp'])->name('allUpcomingOnlineMeetUp');
    Route::get('/all/offline/upcoming/meetup', [DashboardInfoController::class, 'allUpcomingOfflineMeetUp'])->name('allUpcomingOfflineMeetUp');

    //Learning Session
    Route::get('/all/learning-session', [DashboardInfoController::class, 'allLearningSession'])->name('allLearningSession');
    Route::get('/all/complete/learning-session', [DashboardInfoController::class, 'allCompleteLearningSession'])->name('allCompleteLearningSession');
    Route::get('/all/upcoming/learning-session', [DashboardInfoController::class, 'allUpcomingLearningSession'])->name('allUpcomingLearningSession');

    //Live Chats
    Route::get('/all/live-chat', [DashboardInfoController::class, 'allLiveChat'])->name('allLiveChat');
    Route::get('/all/complete/live-chat', [DashboardInfoController::class, 'allCompleteLiveChat'])->name('allCompleteLiveChat');
    Route::get('/all/upcoming/live-chat', [DashboardInfoController::class, 'allUpcomingLiveChat'])->name('allUpcomingLiveChat');
    Route::get('/all/running/live-chat', [DashboardInfoController::class, 'allRunningLiveChat'])->name('allRunningLiveChat');


    //Greetings
    Route::get('/all/greetings', [DashboardInfoController::class, 'allGreeting'])->name('allGreeting');
    Route::get('/all/complete/greetings', [DashboardInfoController::class, 'allCompleteGreeting'])->name('allCompleteGreeting');
    Route::get('/all/upcoming/greetings', [DashboardInfoController::class, 'allUpcomingGreeting'])->name('allUpcomingGreeting');

    //Post
    Route::get('/all/post/list', [DashboardInfoController::class, 'allPost'])->name('allPost');
    Route::get('/all/post/daily', [DashboardInfoController::class, 'dailyPost'])->name('dailyPost');
    Route::get('/all/post/weekly', [DashboardInfoController::class, 'weeklyPost'])->name('weeklyPost');
    Route::get('/all/post/monthly', [DashboardInfoController::class, 'monthlyPost'])->name('monthlyPost');

    Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');

    // manager admin
    Route::get('/manager-admin/list', [ManagerAdminController::class, 'list'])->name('managerAdminList');

    // category
    Route::resource('category', CategoryController::class);




    // Audition Dashboard
    Route::resource('audition-dashboard', AuditionDashboardController::class);

    // Audition Rules
    Route::resource('audition-rules', AuditionRulesController::class);

    // Audition Round Rules
    Route::resource('audition-round-rules', AuditionRoundRulesController::class);
    Route::get('audition-round-rules/mark/{rules_id}', [AuditionRoundRulesController::class, 'getMark']);

    // Audition Round Rules
    Route::resource('audition-admin', AdminAuditionController::class);

    // Audition Round Rules
    Route::resource('audition-jury', JurysAuditionController::class);

    // Auction Routes
    Route::get('auction-index', [AuctionController::class, 'index'])->name('auction.index');
    Route::get('terms-create', [AuctionController::class, 'termsCreate'])->name('auctionTerms.create');
    Route::post('terms-store', [AuctionController::class, 'termsStore'])->name('auctionTerms.store');
    Route::get('terms-edit/{id}', [AuctionController::class, 'termsEdit'])->name('auctionTerms.edit');
    Route::put('terms-update/{id}', [AuctionController::class, 'termsUpdate'])->name('auctionTerms.update');
    Route::delete('terms-destroy/{id}', [AuctionController::class, 'termsDestroy'])->name('auctionTerms.destroy');

    // SimplePost 
    Route::get('simplepost-index', [SimplePostController::class, 'index'])->name('simplePost.index');
    Route::get('simplepost-list/{id}', [SimplePostController::class, 'simplepostList'])->name('simplePost.list');
    Route::get('simplepost-details/{id}', [SimplePostController::class, 'simplepostDetails'])->name('simplePost.details');
    Route::get('simplepost-edit/{id}', [SimplePostController::class, 'simplepostEdit'])->name('simplePost.edit');
    Route::PUT('simplepost-update/{id}', [SimplePostController::class, 'simplepostUpdate'])->name('simplePost.update');
    Route::delete('simplepost-destroy/{id}', [SimplePostController::class, 'simplepostDestroy'])->name('simplePost.destroy');

    //LiveChat
    Route::get('liveChat-index', [LiveChatController::class, 'index'])->name('liveChat.index');
    Route::get('liveChat-list/{id}', [LiveChatController::class, 'liveChatList'])->name('liveChat.list');
    Route::get('liveChat-details/{id}', [LiveChatController::class, 'liveChatDetails'])->name('liveChat.details');
    Route::get('liveChat-edit/{id}', [LiveChatController::class, 'liveChatEdit'])->name('liveChat.edit');
    Route::PUT('liveChat-update/{id}', [LiveChatController::class, 'livechatUpdate'])->name('liveChat.update');
    Route::delete('liveChat-destroy/{id}', [LiveChatController::class, 'liveChatDestroy'])->name('liveChat.destroy');






    // Events
    Route::resource('events', EventsController::class);

    //audtion
    Route::resource('audition', AuditionController::class);
    Route::get('setMark/{id}', [AuditionController::class, 'setMark'])->name('audition.setMark');
    Route::put('setMark/{id}', [AuditionController::class, 'setMarkUpdate'])->name('audition.setMarkUpdate');

    // Greeting Type
    Route::resource('greeting-type', GreetingController::class);
    Route::post('admin/greeting-type-active/{id}', [GreetingController::class, 'activeNow'])->name('greetingtype.activeNow');
    Route::post('admin/greeting-type-inactive/{id}', [GreetingController::class, 'inactiveNow'])->name('greetingtype.inactiveNow');

    // Greeting Type
    Route::resource('marketplace', MarketplaceController::class);
    Route::post('admin/marketplace-type-active/{id}', [MarketplaceController::class, 'activeNow'])->name('marketplace.activeNow');
    Route::post('admin/marketplace-type-inactive/{id}', [MarketplaceController::class, 'inactiveNow'])->name('marketplace.inactiveNow');

    // Country
    Route::resource('country', CountryController::class);
    Route::post('admin/country-active/{id}', [CountryController::class, 'activeNow'])->name('country.activeNow');
    Route::post('admin/country-inactive/{id}', [CountryController::class, 'inactiveNow'])->name('country.inactiveNow');

    // Package
    Route::resource('package', PackageController::class);
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

    // Adudition Admin Create by Monir

    Route::resource('auditionAdmin', AuditionAdminController::class);

    Route::post('auditionAdmin/active/{id}', [AuditionAdminController::class, 'activeNow'])->name('auditionAdmin.activeNow');
    Route::post('auditionAdmin/inactive/{id}', [AuditionAdminController::class, 'inactiveNow'])->name('auditionAdmin.inactiveNow');
});
