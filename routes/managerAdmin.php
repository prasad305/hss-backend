<?php

use App\Http\Controllers\ManagerAdmin\AdminController;
use App\Http\Controllers\ManagerAdmin\JobAssign;
use App\Http\Controllers\ManagerAdmin\DashboardController;
use App\Http\Controllers\ManagerAdmin\LiveChatController;
use App\Http\Controllers\ManagerAdmin\LiveEventController;
use App\Http\Controllers\ManagerAdmin\LearningSessionController;
use App\Http\Controllers\ManagerAdmin\SimplePostController;
use App\Http\Controllers\ManagerAdmin\MarketplaceController;
use App\Http\Controllers\API\MeetupEventController;
use App\Http\Controllers\ManagerAdmin\AuctionController;
use Illuminate\Support\Facades\Route;

// manager Admin route
Route::group(['prefix' => 'manager-admin/', 'as' => 'managerAdmin.', 'middleware' => ['auth', 'managerAdmin']], function () {

    Route::get('dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('profile', [DashboardController::class, 'profile'])->name('profile');


    Route::get('profile', [DashboardController::class, 'profile'])->name('profile');
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


    // Admin route
    Route::resource('admin', AdminController::class);
    Route::post('admin/active/{id}', [AdminController::class, 'activeNow'])->name('admin.activeNow');
    Route::post('admin/inactive/{id}', [AdminController::class, 'inactiveNow'])->name('admin.inactiveNow');
    Route::get('admin-assinged', [AdminController::class, 'assinged'])->name('admin_assinged');
    Route::get('admin-free', [AdminController::class, 'notAssinged'])->name('admin_notAssinged');


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


    // Souvenir Auction
    Route::get('auction/pending', [AuctionController::class, 'pending'])->name('auctionProduct.pending');
    Route::get('auction/published', [AuctionController::class, 'published'])->name('auctionProduct.published');
    Route::get('auction/all', [AuctionController::class, 'all'])->name('auctionProduct.all');

    Route::get('auction/details/{id}', [AuctionController::class, 'details'])->name('auctionProduct.details');
    Route::get('auction/edit/{id}', [AuctionController::class, 'edit'])->name('auctionProduct.edit');
    Route::put('auction/edit/{id}', [AuctionController::class, 'update'])->name('auctionProduct.update');
    Route::get('auction/set_publish/{id}', [AuctionController::class, 'set_publish'])->name('auctionProduct.set_publish');


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

    //Learning Session
    Route::get('learningSession/pending', [LearningSessionController::class, 'manager_pending'])->name('learningSession.pending');
    Route::get('learningSession/published', [LearningSessionController::class, 'manager_published'])->name('learningSession.published');
    Route::get('learningSession/all', [LearningSessionController::class, 'manager_all'])->name('learningSession.all');

    Route::get('learningSession/details/{id}', [LearningSessionController::class, 'manager_event_details'])->name('learningSession.details');
    Route::get('learningSession/edit/{id}', [LearningSessionController::class, 'edit'])->name('learningSession.edit');
    Route::put('learningSession/edit/{id}', [LearningSessionController::class, 'update'])->name('learningSession.update');
    Route::get('learningSession/set_publish/{id}', [LearningSessionController::class, 'manager_event_set_publish'])->name('learningSession.set_publish');

    //audition create
    Route::post('audition-assign/{admin_id}', [JobAssign::class, 'auditionStore'])->name('AuditionAssign');
});
