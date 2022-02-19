<?php

use App\Http\Controllers\SuperAdmin\DashboardController;
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

    if(Auth::user())
    {
        if(Auth::user()->user_type == 'super-admin')
        {
            return redirect()->route('superAdmin.dashboard');
        }
        if(Auth::user()->user_type == 'manager-admin')
        {
            return redirect()->route('managerAdmin.dashboard');
        }
    }
    else
    {
        return view('custom-welcome');
    }

})->name('forntend.index');





// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
require __DIR__.'/superAdmin.php';
require __DIR__.'/managerAdmin.php';
require __DIR__.'/admin.php';
