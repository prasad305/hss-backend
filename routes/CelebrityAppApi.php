<?php

use App\Http\Controllers\API\UserMobileAppController;
use App\Http\Controllers\API\MarketplaceMobileAppController;
use App\Http\Controllers\API\AuthController;
use Illuminate\Support\Facades\Route;



// Registered & Verified Star Middleware
Route::middleware(['auth:sanctum', 'isAPIStar'])->group(function () {
    Route::get('/checkingSuperStar', function () {
        return response()->json(['message' => 'You are in as Superstar', 'status' => 200], 200);
    });
    
});