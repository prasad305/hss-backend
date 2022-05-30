<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\LearningSession;
use App\Models\LearningSessionAssignment;
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

    public function assignment_rule_add(Request $request)
    {

        $post = LearningSession::find($request->input('id'));
        $post->assignment_fee = $request->input('assignment_fee');
        $post->assignment_reg_start_date = $request->input('start_date');
        $post->assignment_reg_end_date = $request->input('end_date');
        $post->assignment_video_slot_number = $request->input('slot_number');
        $post->assignment_instruction = $request->input('instruction');
        $post->status = 4; // Assignment Rules Send To Manager Admin

        $post->update();

        return response()->json([
            'status' => 200,
            'message' => 'Assignment Ruled Added',
        ]);
    }



    public function assignment_set_approval(Request $request, $type, $id)
    {

        $post = LearningSessionAssignment::find($id);

        if($type == 'approve')
        {
            $post->status = 1;
        }else{
            $post->status = 2;
        }

        $post->comment = $request->input('comment');

        $post->update();

        return response()->json([
            'status' => 200,
            'message' => 'Status Updated',
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
        $events = LearningSession::where([['created_by_id', auth('sanctum')->user()->id], ['status', '<', 2]]);

        return response()->json([
            'status' => 200,
            'events' => $events->latest()->get(),
            'count' => $events->count(),
        ]);
    }

    public function live_list()
    {
        $events = LearningSession::where([['created_by_id', auth('sanctum')->user()->id], ['status', 2]]);

        return response()->json([
            'status' => 200,
            'events' => $events->latest()->get(),
            'count' => $events->count(),
        ]);
    }

    public function evaluation_list()
    {
        $events = LearningSession::where([['created_by_id', auth('sanctum')->user()->id], ['status','>', 2], ['status','<', 9]]);

        return response()->json([
            'status' => 200,
            'events' => $events->latest()->get(),
            'count' => $events->count(),
        ]);
    }

    public function completed_list()
    {
        $events = LearningSession::where([['created_by_id', auth('sanctum')->user()->id], ['status', 9]]);

        return response()->json([
            'status' => 200,
            'events' => $events->latest()->get(),
            'count' => $events->count(),
        ]);
    }

    public function details($slug)
    {
        $event = LearningSession::where('slug',$slug)->first();

        return response()->json([
            'status' => 200,
            'event' => $event,
            'message' => 'Success',
        ]);
    }

    public function assignment_details($id)
    {
        // $event = LearningSessionAssignment::all();

        $learning_session = LearningSession::find($id);
        $instruction = $learning_session->assignment_instruction;

        $event = LearningSessionAssignment::where([['event_id', $id],['status',0]])->get();
        $approved_event = LearningSessionAssignment::where([['event_id', $id],['status',1]])->get();
        $rejected_event = LearningSessionAssignment::where([['event_id', $id],['status',2]])->get();

        return response()->json([
            'status' => 200,
            'instruction' => $instruction,
            'event' => $event,
            'approved_event' => $approved_event,
            'rejected_event' => $rejected_event,

            'message' => 'Success',
        ]);
    }

    public function pending_details($slug)
    {
        $post = LearningSession::where('slug',$slug)->first();

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
        $events = LearningSession::where([['star_id', auth('sanctum')->user()->id], ['status', '<', 1]]);

        return response()->json([
            'status' => 200,
            'events' => $events->latest()->get(),
            'count' => $events->count(),
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
        $events = LearningSession::where([['star_id', auth('sanctum')->user()->id], ['status', '>', 0], ['status', '<', 10]]);

        return response()->json([
            'status' => 200,
            'events' => $events->latest()->get(),
            'count' => $events->count(),
        ]);
    }

    public function star_evaluation_list()
    {
        $events = LearningSession::where([['star_id', auth('sanctum')->user()->id], ['status', 3]]);

        return response()->json([
            'status' => 200,
            'events' => $events->latest()->get(),
            'count' => $events->count(),
        ]);
    }

    public function star_coompleted_list()
    {
        $events = LearningSession::where([['star_id', auth('sanctum')->user()->id], ['status', 9]]);

        return response()->json([
            'status' => 200,
            'events' => $events->latest()->get(),
            'count' => $events->count(),
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
