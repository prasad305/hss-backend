<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function reboot()
    {
        Artisan::call('cache:clear');
        Artisan::call('route:clear');
        Artisan::call('view:clear');
        file_put_contents(storage_path('logs/laravel.log'), '');
        Artisan::call('key:generate');
        Artisan::call('config:cache');
        return '<center><h1>System Rebooted!</h1></center>';
    }
}
