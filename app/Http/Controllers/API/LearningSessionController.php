<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\LearningSession;
use App\Models\LearningSessionAssignment;
use App\Models\LearningSessionEvaluation;
use App\Models\LearningSessionRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Validator;

class LearningSessionController extends Controller
{
    //
    public function add_learning(Request $request)
    {

        

        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:learning_sessions',
            'description' => 'required',
            'star_id' => 'required',
            'instruction' => 'required',
            'registration_start_date' => 'required',
            'registration_end_date' => 'required',
            'date' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'assignment' => 'required',
            'fee' => 'required',
            'participant_number' => 'required',
            'room_id' => 'required',
            'image' => 'required|mimes:jpg,jpeg,png,gif,webp',
        ],[
           'title.unique' => 'This title already exist' ,
           'star_id.required' => 'Please Select One Star' ,
        ]);


        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->errors(),
            ]);
        } else {

            $post = new LearningSession();
            $post->title = $request->input('title');
            $post->slug = Str::slug($request->input('title'));
            $post->created_by_id = auth('sanctum')->user()->id;
            $post->star_id = $request->input('star_id');
            $post->description = $request->input('description');
            $post->instruction = $request->input('instruction');

            $post->registration_start_date = $request->input('registration_start_date');
            $post->registration_end_date = $request->input('registration_end_date');
            $post->date = $request->input('date');
            $post->start_time = $request->input('start_time');
            $post->end_time = $request->input('end_time');

            $post->assignment = $request->input('assignment');
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
            'message' => 'Assignment Rule Added',
        ]);
    }

    public function registured_user($slug)
    {
        $event = LearningSession::where('slug', $slug)->first();
        $users = LearningSessionRegistration::where('learning_session_id', $event->id)->get();

        return response()->json([
            'status' => 200,
            'users' => $users,
            'message' => 'Success',
        ]);
    }


    //Prepare for Star
    public function assignment_set_approval(Request $request, $type, $id)
    {
        $post = LearningSessionAssignment::find($id);

        if ($type == 'approve') {
            $post->status = 1;
        } else {
            $post->status = 2;
        }

        $post->comment = $request->input('comment');

        $post->update();

        return response()->json([
            'status' => 200,
            'message' => 'Status Updated',

        ]);
    }

    //Prepare for Star
    public function star_assignment_set_approval(Request $request, $type, $id)
    {
        $post = LearningSessionAssignment::find($id);
        
        $post->comment = $request->input('comment');
        $post->mark = $request->input('mark');
        $post->update();
        
        $evalutation = LearningSessionEvaluation::find($post->evaluation_id);
        $evalutation->total_mark = $evalutation->total_mark+$request->input('mark');
        $evalutation->update();

        return response()->json([
            'status' => 200,
            'message' => 'Status Updated',

        ]);
    }



    public function assignment_set_approval_with_mark(Request $request, $type, $id)
    {

        $post = LearningSessionAssignment::find($id);
        $pending = LearningSessionAssignment::where([['event_id', $id], ['status', 1], ['mark', '<', 1]])->count();

        if ($type == 'approve') {
            $post->status = 1;
        } else {
            $post->status = 2;
        }

        $post->mark = $request->input('mark'); 
        $post->comment = $request->input('comment');

        $post->update();

        $eva = LearningSessionEvaluation::where('id',$post->evaluation_id)->first();
        $eva->total_mark += $request->input('mark'); 
        $eva->save();

        return response()->json([
            'status' => 200,
            'pending' => $pending,
            'message' => 'Status Updated',
        ]);
    }


    public function admin_assignment_marks($slug)
    {
        $event = LearningSession::where('slug', $slug)->first();

        $approved = LearningSessionAssignment::where('status', 1)->count();
        $with_mark = LearningSessionAssignment::where('mark', '>', 0)->count();

        return response()->json([
            'status' => 200,
            'event' => $event,
            'complete' => $approved == $with_mark,
            'message' => 'Status Updated',
        ]);
    }

    public function admin_assignment_set_complete($id)
    {
        $event = LearningSession::find($id);
        $event->status = 9;
        $event->update();
        return response()->json([
            'status' => 200,
            'message' => 'Set Completed!',
        ]);

    }

    public function admin_assignment_set_assignment($id)
    {
        $event = LearningSession::find($id);
        $event->status = 3;
        $event->update();


        return response()->json([
            'status' => 200,
            'message' => 'Assignment Session Started!',
        ]);
    }

    public function assignment_send_to_manager($slug)
    {
        $event = LearningSession::where('slug', $slug)->first();
        $event->update(['status' => 6]);
        LearningSessionAssignment::where([['event_id', $event->id], ['status', 1], ['mark', '>', 1]])->update(['send_to_manager' => 1]);

        return response()->json([
            'status' => 200,
            'message' => 'Sent to Manager Successfully!',
        ]);
    }

    public function assignment_send_to_star($id)
    {

        LearningSessionAssignment::where([['event_id', $id], ['status', 1], ['mark', 0],])->update(['send_to_star' => 1]);

        return response()->json([
            'status' => 200,
            'message' => 'Videos Sent to Star!',
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
        $events = LearningSession::where([['created_by_id', auth('sanctum')->user()->id], ['status', '>', 2], ['status', '<', 9]]);

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
        $event = LearningSession::where('slug', $slug)->first();

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

        //Prepare for Manager
        $event = LearningSessionAssignment::where([['event_id', $id], ['status', 0], ['mark', 0], ['send_to_star', 0]])->get();
        $approved_event = LearningSessionAssignment::where([['event_id', $id], ['status', 1], ['mark', '>', 0]])->get();
        $rejected_event = LearningSessionAssignment::where([['event_id', $id], ['status', 2]])->get();

        //Prepare for Star
        $star_event =  $event;
        $star_approved_event = LearningSessionAssignment::where([['event_id', $id], ['status', 1], ['mark', 0]])->get();



        return response()->json([
            'status' => 200,
            'instruction' => $instruction,
            'event' => $event,
            'approved_event' => $approved_event,
            'rejected_event' => $rejected_event,

            'star_event' => $star_event,
            'star_approved_event' => $star_approved_event,

            'message' => 'Success',
        ]);
    }

    public function pending_details($slug)
    {
        $post = LearningSession::where('slug', $slug)->first();

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

    public function update(Request $request,$id)
    {

        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:learning_sessions,title,'.$id,
            'description' => 'required|min:5',
            'star_id' => 'required',
            'instruction' => 'required|min:5',
            'date' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'fee' => 'required',
            'participant_number' => 'required',
            'image' => 'nullable|mimes:jpg,jpeg,png,gif,webp',
        ],[
           'title.unique' => 'This title already exist' ,
           'star_id.required' => 'Please Select One Star' ,
        ]);


        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->errors(),
            ]);
        } else {

           $learning_session = LearningSession::find($id);
           $learning_session->title = $request->input('title');
           $learning_session->slug = Str::slug($request->input('title'));
           $learning_session->description = $request->input('description');
           $learning_session->instruction = $request->input('instruction');

           $learning_session->date = $request->input('date');
           $learning_session->start_time = $request->input('start_time');
           $learning_session->end_time = $request->input('end_time');

           $learning_session->fee = $request->input('fee');
           $learning_session->participant_number = $request->input('participant_number');

            //$post->video = $request->input('video');
            //$post->type = $request->input('type');

            if ($request->hasfile('image')) {
                $destination =$learning_session->banner;
                if (File::exists($destination)) {
                    File::delete($destination);
                }
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                $filename = 'uploads/images/learning_session/' . time() . '.' . $extension;

                Image::make($file)->resize(900, 400)->save($filename, 100);
               $learning_session->banner = $filename;
            }

           $learning_session->save();


            return response()->json([
                'status' => 200,
                'message' => 'Learning Session Updated',
            ]);
        }
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
        $events = LearningSession::where([['star_id', auth('sanctum')->user()->id], ['status', '>', 2], ['status', '<', 9]]);

        return response()->json([
            'status' => 200,
            'events' => $events->latest()->get(),
            'count' => $events->count(),
        ]);
    }

    public function star_assignment_details($id)
    {
        $event = LearningSessionAssignment::where([['event_id', $id], ['send_to_star', 1], ['mark', 0]])->get();
        $approved_event = LearningSessionAssignment::where([['event_id', $id], ['send_to_star', 1], ['mark', '>', 0]])->get();

        return response()->json([
            'status' => 200,
            'event' => $event,
            'approved_event' => $approved_event,
            'message' => 'Success',
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

        $post->status = 1;

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
