<?php

use App\Http\Controllers\API\UserMobileAppController;
use App\Http\Controllers\API\AuthController;
use Illuminate\Support\Facades\Route;


// Registered & Verified User Middleware
Route::middleware(['auth:sanctum', 'isAPIUser'])->group(function () {

    Route::group(['prefix' => 'user/', 'as' => 'user.'], function () {
        Route::post('event-register', [UserMobileAppController::class, 'eventRegister']);
        Route::group(['prefix' => 'mobile-app/', 'as' => 'mobileApp.'], function () {
            Route::get('greeting-status/{star_id}', [UserMobileAppController::class, 'greetingStatus']);
            Route::get('menu', [UserMobileAppController::class, 'menu']);
        });
    });

    Route::post('mobile/userInformation_update', [UserMobileAppController::class, 'userInformationUpdate']);
});
