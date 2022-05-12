<?php

use App\Http\Controllers\SuperAdmin\AdminAuditionController;
use App\Http\Controllers\SuperAdmin\AuditionAdminController;
use App\Http\Controllers\SuperAdmin\Audition\AuditionController;
use App\Http\Controllers\SuperAdmin\DashboardController;
use App\Http\Controllers\SuperAdmin\ManagerAdminController;
use App\Http\Controllers\SuperAdmin\AdminController;
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

    Route::get('/package', [DashboardController::class, 'package'])->name('package');
    Route::get('/add-package', [DashboardController::class, 'addPackage'])->name('addPackage');
    Route::post('/store-package', [DashboardController::class, 'packageStore'])->name('packageStore');

    //Dashboard Information
    Route::get('/all/user', [DashboardInfoController::class, 'allUser'])->name('allUser');
    Route::get('/all/star', [DashboardInfoController::class, 'allStar'])->name('allStar');
    Route::get('/all/admin', [DashboardInfoController::class, 'allAdmin'])->name('allAdmin');
    Route::get('/all/marketplace', [DashboardInfoController::class, 'allMarketplace'])->name('allMarketplace');
    Route::get('/all/auction', [DashboardInfoController::class, 'allAuction'])->name('allAuction');

    //MeetUp Events
    Route::get('/all/meetup', [DashboardInfoController::class, 'allMeetUp'])->name('allMeetUp');

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
    Route::get('audition-round-rules/mark/{rules_id}', [AuditionRoundRulesController::class,'getMark']);

    // Audition Round Rules
    Route::resource('audition-admin', AdminAuditionController::class);

    // Audition Round Rules
    Route::resource('audition-jury', JurysAuditionController::class);







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
