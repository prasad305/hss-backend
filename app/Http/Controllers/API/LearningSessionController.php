<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\LearningSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;

class LearningSessionController extends Controller
{
    //
    public function add(Request $request)
    {
        //return $request->all();


        $post = new LearningSession();
        $post->title = $request->input('title');
        $post->slug = Str::slug($request->input('title'));
        $post->created_by_id = auth('sanctum')->user()->id;
        $post->star_id = $request->input('star_id');
        $post->description = $request->input('description');

        $post->registration_start_date = $request->input('registration_start_date');
        $post->registration_end_date = $request->input('registration_end_date');
        $post->date = $request->input('date');
        $post->start_time = $request->input('start_time');
        $post->end_time = $request->input('end_time');

        $post->fee = $request->input('fee');
        $post->participant_number = $request->input('participant_number');
        $post->room_id = $request->input('room_id');


        //$post->video = $request->input('video');
        //$post->type = $request->input('type');

        if ($request->hasfile('image')) {
            $destination = $post->banner;
            if (File::exists($destination)) {
                File::delete($destination);
            }
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = 'uploads/images/learning_session/' . time() . '.' . $extension;

            Image::make($file)->resize(900, 400)->save($filename, 100);
            $post->banner = $filename;
        }

        $post->save();

        return response()->json([
            'status' => 200,
            'message' => 'Learning Session Added',
        ]);
    }

    public function count()
    {
        $pending = LearningSession::where([['created_by_id', auth('sanctum')->user()->id], ['status', 0]])->count();
        $approved = LearningSession::where([['created_by_id', auth('sanctum')->user()->id], ['status', 1]])->count();

        return response()->json([
            'status' => 200,
            'pending' => $pending,
            'approved' => $approved,
            'message' => 'Success',
        ]);
    }

    public function all()
    {
        $post = LearningSession::where('created_by_id', auth('sanctum')->user()->id)->latest()->get();
        $count = LearningSession::where('created_by_id', auth('sanctum')->user()->id)->count();

        return response()->json([
            'status' => 200,
            'post' => $post,
            'count' => $count,
            'message' => 'Success',
        ]);
    }

    public function pending_list()
    {
        $post = LearningSession::where([['created_by_id', auth('sanctum')->user()->id], ['status', 0]])->latest()->get();
        $count = LearningSession::where([['created_by_id', auth('sanctum')->user()->id], ['status', 0]])->count();

        return response()->json([
            'status' => 200,
            'post' => $post,
            'count' => $count,
            'message' => 'Success',
        ]);
    }

    public function pending_details($id)
    {
        $post = LearningSession::find($id);

        return response()->json([
            'status' => 200,
            'post' => $post,
            'message' => 'Success',
        ]);
    }

    public function approved_list()
    {
        $post = LearningSession::where([['created_by_id', auth('sanctum')->user()->id], ['status', 1]])->latest()->get();
        $count = LearningSession::where([['created_by_id', auth('sanctum')->user()->id], ['status', 1]])->count();

        return response()->json([
            'status' => 200,
            'post' => $post,
            'count' => $count,
            'message' => 'Success',
        ]);
    }


    /// For Super Star ///

    public function star_add(Request $request)
    {
        $post = new LearningSession();
        $post->title = $request->input('title');
        $post->slug = Str::slug($request->input('title'));
        $post->created_by_id = auth('sanctum')->user()->id;
        $post->star_id = auth('sanctum')->user()->id;
        $post->description = $request->input('description');
        $post->registration_start_date = $request->input('registration_start_date');
        $post->registration_end_date = $request->input('registration_end_date');
        $post->date = $request->input('date');
        $post->start_time = $request->input('start_time');
        $post->end_time = $request->input('end_time');
        $post->fee = $request->input('fee');
        $post->participant_number = $request->input('participant_number');
        $post->room_id = $request->input('room_id');
        $post->star_approval = 1;

        if ($request->hasfile('image')) {
            $destination = $post->banner;
            if (File::exists($destination)) {
                File::delete($destination);
            }
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = 'uploads/images/learning_session/' . time() . '.' . $extension;

            Image::make($file)->resize(900, 400)->save($filename, 100);
            $post->banner = $filename;
        }

        $post->save();

        return response()->json([
            'status' => 200,
            'message' => 'Learning Session Added',
        ]);
    }



    public function star_count()
    {
        $pending = LearningSession::where([['star_id', auth('sanctum')->user()->id], ['star_approval', 0]])->count();
        $approved = LearningSession::where([['star_id', auth('sanctum')->user()->id], ['star_approval', 1]])->count();

        return response()->json([
            'status' => 200,
            'pending' => $pending,
            'approved' => $approved,
            'message' => 'Success',
        ]);
    }


    public function star_all()
    {
        $post = LearningSession::where('star_id', auth('sanctum')->user()->id)->get();
        $count = LearningSession::where('star_id', auth('sanctum')->user()->id)->count();

        return response()->json([
            'status' => 200,
            'post' => $post,
            'count' => $count,
            'message' => 'Success',
        ]);
    }

    public function star_pending_list()
    {
        $post = LearningSession::where([['star_id', auth('sanctum')->user()->id], ['star_approval', 0]])->latest()->get();
        $count = LearningSession::where([['star_id', auth('sanctum')->user()->id], ['star_approval', 0]])->count();

        return response()->json([
            'status' => 200,
            'post' => $post,
            'count' => $count,
            'message' => 'Success',
        ]);
    }

    public function star_pending_details($id)
    {
        $event = LearningSession::find($id);

        return response()->json([
            'status' => 200,
            'event' => $event,
            'message' => 'Success',
        ]);
    }

    public function star_approved_list()
    {
        $post = LearningSession::where([['star_id', auth('sanctum')->user()->id], ['star_approval', 1]])->latest()->get();
        $count = LearningSession::where([['star_id', auth('sanctum')->user()->id], ['star_approval', 1]])->count();

        return response()->json([
            'status' => 200,
            'post' => $post,
            'count' => $count,
            'message' => 'Success',
        ]);
    }

    public function approve_post($id)
    {
        $post = LearningSession::find($id);

        $post->star_approval = 1;

        $post->update();

        return response()->json([
            'status' => 200,
            'message' => 'Success',
        ]);
    }



    /// User Section
    public function user_all()
    {
        $post = LearningSession::where('status', 1)->latest()->get();

        return response()->json([
            'status' => 200,
            'post' => $post,
            'message' => 'Success',
        ]);
    }
}
