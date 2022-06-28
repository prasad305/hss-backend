<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    // return view('welcome');

    if (Auth::user()) {
        if (Auth::user()->user_type == 'super-admin') {
            return redirect()->route('superAdmin.dashboard');
        }
        if (Auth::user()->user_type == 'manager-admin') {
            return redirect()->route('managerAdmin.dashboard');
        }
    } else {
        return view('custom-welcome');
    }
})->name('forntend.index');


Route::get('/chat', function () {
    return view('chatroom');
});
Route::get('/test-view', function () {

    return "Please add a view !";
    // return view('SuperAdmin.JurysAuditoin.index');
});


// For system reboot
// Route::get('/reboot', [HomeController::class, 'reboot']);

Route::get('/reboot', function () {
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    file_put_contents(storage_path('logs/laravel.log'), '');
    Artisan::call('key:generate');
    Artisan::call('config:cache');
    return '<center><h1>System Rebooted!</h1></center>';
});







// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';
require __DIR__ . '/superAdmin.php';
require __DIR__ . '/managerAdmin.php';
require __DIR__ . '/admin.php';
