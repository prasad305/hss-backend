<?php


use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LiveChatController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin/', 'as' => 'admin.', 'middleware' => ['auth', 'prevent-back-history']], function () {

    Route::get('dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('profile', [DashboardController::class, 'profile'])->name('profile');

    //Live chat
    Route::resource('liveChat', LiveChatController::class);
});
