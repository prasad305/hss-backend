<?php

namespace App\Http\Controllers;

use App\Models\LearningSessionAssignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Str;

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

    public function video_upload(Request $request)
    {




        try {
            file_put_contents('uploads/images/sample5.mp4', base64_decode($request->video['data'], true));
        } catch (\Exception $exception) {
        }


        return response()->json([
            'message' => "ok"
        ]);
    }
}
