<?php

use App\Http\Controllers\API\Payment\PaymentController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

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

//ipay88
Route::get('/ipay88-make-payment/{userId}/{amount}/{eventName}/{eventId}/{valu}/{for}', [PaymentController::class, 'ipayInitiate']);
Route::get('/ipay88-payment-success/{order_id}', [PaymentController::class, 'iPayPaymentSuccess']);
Route::get('/ipay88', function () {
    return view('Ipay88.iPaymentSuccess');
});


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
    return view('Others.MailView.forgetPassword');
});

Route::post('/quize-form', [HomeController::class, 'QuizeJoin'])->name('quizUserSubmit');
Route::post('/quize-submit', [HomeController::class, 'QuizSubmit'])->name('quizDataSubmit');


Route::post('/uplad-video-post', [HomeController::class, 'upload-video']);

Route::get('/my-quize', function () {

    return view('quiz');
});



/**
 * stripe web hook
 */
Route::stripeWebhooks('stripe-webhook');
/**
 * shurjo pay
 */
Route::get('/initiata-shurjo-payment-success', [PaymentController::class, 'successShurjoPayment']);

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



Route::get('/shurjo', function () {
    return view("Others.Payment.shurjoPaymentSuccess");
});

// Redis Testing Route


Route::get('/redis', function () {
    // $posts =  Redis::get('posts');

    // if(!$posts){
    //     $posts = Post::limit(40000)->get();
    //     Redis::set('posts',$posts);
    // }else{
    //      $posts = json_decode($posts);
    //     }
    //     return view('index',compact('posts'));

    // Redis::set('posts',"data set successfully");
    // Redis::get('posts');
    // return response()->json("okay");
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';
require __DIR__ . '/superAdmin.php';
require __DIR__ . '/managerAdmin.php';
require __DIR__ . '/admin.php';
