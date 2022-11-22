<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\LearningSession;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Str;

class LearningSessionController extends Controller
{
    public function index()
    {
        $categories = Category::get();
        return view('SuperAdmin.LearningSession.index', compact('categories'));
    }
    public function learningSessionList($categoryId)
    {
        $postList = LearningSession::with('admin')->where('category_id', $categoryId)->latest()->get();
        return view('SuperAdmin.LearningSession.LearningSessionList', compact('postList'));
    }
    public function learningSessionDetails($postId)
    {
        $event = LearningSession::findOrFail($postId);
        return view('SuperAdmin.LearningSession.details', compact('event'));
    }
    public function learningSessionEdit($id)
    {
        $event = LearningSession::find($id);

        return view('SuperAdmin.LearningSession.edit', compact('event'));
    }
    public function learningSessionUpdate(Request $request, $id)
    {

        if ($request->banner_or_video == 0) {
            $request->validate([
                'title' => 'required|unique:learning_sessions,title,' . $id,
                'description' => 'required|min:5',
                'instruction' => 'required|min:5',
                // 'event_date' => 'required',
                // 'start_time' => 'required',
                // 'end_time' => 'required',
                // 'registration_start_date' => 'required',
                // 'registration_end_date' => 'required',
                // 'assignment' => 'required',
                // 'fee' => 'required',
                // 'participant_number' => 'required',
                'image' => 'nullable|mimes:jpg,jpeg,png',
            ]);
        } else {
            $request->validate([
                'title' => 'required|unique:learning_sessions,title,' . $id,
                'description' => 'required|min:5',
                'instruction' => 'required|min:5',
                // 'event_date' => 'required',
                // 'start_time' => 'required',
                // 'end_time' => 'required',
                // 'registration_start_date' => 'required',
                // 'registration_end_date' => 'required',
                // 'assignment' => 'required',
                // 'fee' => 'required',
                // 'participant_number' => 'required',
                'video' => 'nullable|mimes:mp4,mkv',
            ]);
        }

        $learningSession = LearningSession::findOrFail($id);
        $learningSession->title = $request->input('title');
        $learningSession->slug = Str::slug($request->input('title'));
        $learningSession->description = $request->input('description');
        $learningSession->instruction = $request->input('instruction');

        // $learningSession->registration_start_date = $request->input('registration_start_date');
        // $learningSession->registration_end_date = $request->input('registration_end_date');
        // $learningSession->event_date = $request->input('event_date');
        // $learningSession->start_time = $request->input('start_time');
        // $learningSession->end_time = $request->input('end_time');

        // $learningSession->assignment = $request->input('assignment');
        // $learningSession->fee = $request->input('fee');
        // $learningSession->participant_number = $request->input('participant_number');

        if ($request->hasfile('image')) {
            $destination = $learningSession->banner;
            if (File::exists($destination)) {
                File::delete($destination);
            }
            if ($learningSession->video != null && file_exists($learningSession->video)) {
                unlink($learningSession->video);
            }
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = 'uploads/images/learning_session/' . time() . '.' . $extension;

            Image::make($file)->resize(900, 400)->save($filename, 100);
            $learningSession->banner = $filename;
            $learningSession->video = null;
        }

        if ($request->hasFile('video')) {
            $destination = $learningSession->banner;
            if (File::exists($destination)) {
                File::delete($destination);
            }
            if ($learningSession->video != null && file_exists($learningSession->video)) {
                unlink($learningSession->video);
            }
            $file        = $request->file('video');
            $path        = 'uploads/videos/learning_session';
            $file_name   = time() . rand('0000', '9999') . '.' . $file->getClientOriginalName();
            $file->move($path, $file_name);
            $learningSession->video = $path . '/' . $file_name;
            $learningSession->banner = null;
        }

        try {
            $learningSession->update();
            if ($learningSession) {
                return response()->json([
                    'success' => true,
                    'message' => 'Learning Session Updated Successfully'
                ]);
            }
        } catch (\Exception $exception) {
            return response()->json([
                'type' => 'error',
                'message' => 'Opps somthing went wrong. ' . $exception->getMessage(),
            ]);
        }
    }
    public function learningSessionDestroy($id)
    {
        $post = Post::where('event_id', $id)->first();
        $postDelete = LearningSession::findOrfail($id);
        try {
            $post->delete();
            $postDelete->delete();
            return response()->json([
                'type' => 'success',
                'message' => 'Successfully Deleted !!',
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'type' => 'error',
                'message' => 'error' . $exception->getMessage(),
            ]);
        }
    }
}
