<?php

namespace App\Http\Controllers;

use App\Models\LearningSessionAssignment;
use App\Models\Quiz;
use App\Models\User;
use Illuminate\Auth\Events\Validated;
use Illuminate\Support\Facades\Validator;
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

    /**
     * quize join
     */
    public function QuizeJoin(Request $request)
    {

        $User = User::where('email', $request->email)->orWhere('phone', $request->phone)->first();

        if (isset($User)) {
            return view('quizBody', compact('User'));
        } else {
            return redirect()->back()->with("error", "user not found plz downlode app and register");
        }
    }

    /**
     * quiz submit
     */
    public function QuizSubmit(Request $request)
    {

        // $validated = $request->validate([
        //     'quiz_valu' => 'required',
        // ]);

        $quiz = new Quiz();
        $quiz->userPhone = $request->phone;
        $quiz->userEmail = $request->email;
        $quiz->question = $request->quiz_question;
        $quiz->answer = $request->quiz_valu;
        $quiz->save();



        return view('quizThanks');
    }


    /**
     * quize view
     */
    public function viewAllQuize()
    {
        $quizs = Quiz::orderBy('id', 'desc')->where('status', 1)->get();
        return view('SuperAdmin.quizViewAll', compact('quizs'));
    }
}
