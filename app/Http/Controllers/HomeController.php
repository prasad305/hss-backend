<?php

namespace App\Http\Controllers;

use App\Models\LearningSessionAssignment;
use App\Models\Quiz;
use App\Models\User;
use Illuminate\Auth\Events\Validated;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
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
        // return $request->video;
        // return base64_decode($request->video, true);

        $file = $request->video;
        $chunk = $request->chunk_number;
        $chunks = $request->total_chunks - 1;

        // $fileName = $file->getClientOriginalName();
        $fileName = $request->fileName;
        $chunkName = $fileName . '_' . $chunk . '.part';

        // $file->move(storage_path('uploads/videos/temp'), $chunkName);



        file_put_contents('uploads/videos/temp/' . $chunkName, base64_decode($request->video, true));

        if ($chunk == $chunks) {
            // return "hello";
            $filePath = $this->mergeChunks($fileName, $chunks + 1);
            return response()->json(['success' => true, 'file_path' => $filePath]);
        }

        return response()->json([
            'success' => true,
            'current' => $chunk,
            'total' => $chunks
        ]);
    }


    private function mergeChunks($fileName, $chunks)
    {
        $filePath = public_path('uploads/videos') . '/' . $fileName;
        $target = fopen($filePath, 'w'); //write last chunk

        for ($i = 0; $i < $chunks; $i++) {
            $chunkName = public_path('uploads/videos/temp') . '/' . $fileName . '_' . $i . '.part';
            $chunk = fopen($chunkName, 'r'); //read chunk previous chunk form temp file
            stream_copy_to_stream($chunk, $target); //add all chunks
            fclose($chunk);
            unlink($chunkName);
        }

        fclose($target);

        return $filePath;
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
