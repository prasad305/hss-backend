<?php

namespace App\Http\Controllers\ManagerAdmin;

use App\Http\Controllers\Controller;
use App\Models\Audition\Audition;
use App\Models\Post;
use App\Models\SuperStar;
use App\Models\LearningSession;
use App\Models\LearningSessionAssignment;
use App\Models\LearningSessionEvaluation;
use App\Models\LearningSessionRegistration;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\DB;

class LearningSessionController extends Controller
{
    public function add(Request $request)
    {
        $meetup = new LearningSession();

        $meetup->created_by_id = auth('sanctum')->user()->id;
        $meetup->star_id = $request->input('star_id');
        $meetup->title = $request->input('title');
        $meetup->event_link = $request->input('event_link');
        $meetup->meetup_type = $request->input('meetup_type');
        $meetup->date = $request->input('date');
        $meetup->start_time = $request->input('start_time');
        $meetup->end_time = $request->input('end_time');
        $meetup->description = $request->input('description');
        $meetup->venue = $request->input('venue');
        $meetup->total_seat = $request->input('slots');
        $meetup->fee = $request->input('fee');

        if ($request->hasfile('banner')) {
            $destination = $meetup->banner;
            if (File::exists($destination)) {
                File::delete($destination);
            }
            $file = $request->file('banner');
            $extension = $file->getClientOriginalExtension();
            $filename = 'uploads/images/meetup/' . time() . '.' . $extension;

            Image::make($file)->resize(900, 400)
                ->save($filename, 50);

            $meetup->banner = $filename;
        }

        $meetup->save();

        return response()->json([
            'status' => 200,
            'meetup_id' => $meetup->id,
            'message' => 'Meetup Event Added',
        ]);
    }

    public function pending_list()
    {
        $meetup = LearningSession::where('status', '<>', 1)->latest()->get();

        return response()->json([
            'status' => 200,
            'meetup' => $meetup,
            'message' => 'Success',
        ]);
    }

    public function approved_list()
    {
        $meetup = LearningSession::where('status', 1)->latest()->get();

        return response()->json([
            'status' => 200,
            'meetup' => $meetup,
            'message' => 'Success',
        ]);
    }

    public function details($id)
    {
        $meetup = LearningSession::find($id);

        return response()->json([
            'status' => 200,
            'meetup' => $meetup,
            'message' => 'Success',
        ]);
    }

    public function slots($id)
    {

        $meetup = LearningSessionRegistration::where('meetup_event_id', $id)->get();

        $slot = LearningSession::find($id)->total_seat;

        return response()->json([
            'status' => 200,
            'meetup' => $meetup,
            'count' => $meetup->count(),
            'empty_slot' => $slot - $meetup->count(),
            'message' => 'Success',
        ]);
    }

    public function star_pending_list()
    {
        $meetup = LearningSession::where([['star_id', auth('sanctum')->user()->id], ['star_approval', 0]])->latest()->get();

        return response()->json([
            'status' => 200,
            'meetup' => $meetup,
            'message' => 'Success',
        ]);
    }

    public function star_approved_list()
    {
        $meetup = LearningSession::where([['star_id', auth('sanctum')->user()->id], ['star_approval', 1]])->latest()->get();

        return response()->json([
            'status' => 200,
            'meetup' => $meetup,
            'message' => 'Success',
        ]);
    }

    public function set_approve($id)
    {
        $meetup = LearningSession::find($id);
        $meetup->star_approval = 1;
        $meetup->update();


        return response()->json([
            'status' => 200,
            'meetup' => $meetup,
            'message' => 'Approved',
        ]);
    }


    /// Manager Part ////
    public function manager_pending()
    {
        $learningSessions = LearningSession::where([['status', 1], ['category_id', auth()->user()->category_id]])->orderBy('updated_at', 'desc')->get();

        return view('ManagerAdmin.LearningSession.index', compact('learningSessions'));
    }
    public function manager_rejected()
    {
        $learningSessions = LearningSession::where([['status', 11], ['category_id', auth()->user()->category_id]])->orderBy('updated_at', 'desc')->get();

        return view('ManagerAdmin.LearningSession.index', compact('learningSessions'));
    }

    public function manager_published()
    {
        $learningSessions = LearningSession::where([
            ['status', 2]
        ])->latest()->get();

        return view('ManagerAdmin.LearningSession.index', compact('learningSessions'));
    }

    public function learningEvaluation()
    {
        $events = LearningSession::where([['status', '>', 3], ['status', '<', 9], ['category_id', auth()->user()->category_id]])->orderBy('updated_at', 'desc')->get();

        return view('ManagerAdmin.LearningSession.evaluation', compact('events'));
    }

    public function evaluationDetails($id)
    {
        $event = LearningSession::findOrFail($id);

        return view('ManagerAdmin.LearningSession.evaluationDetails', compact('event'));
    }

    public function evaluationResult($id)
    {
        $event = LearningSession::findOrFail($id);


        $results = LearningSessionEvaluation::where('event_id', $id)
            ->with(['assignments' => function ($q) {
                return $q->where([['mark', '>', 0], ['send_to_manager', 1]]);
            }])
            ->orderBy('total_mark', 'desc')->get();

        $rejected_videos = LearningSessionEvaluation::where('event_id', $id)
            ->with(['assignments' => function ($q) {
                return $q->where([['status', 2], ['send_to_manager', 1]]);
            }])
            ->get();



        return view('ManagerAdmin.LearningSession.evaluationResult', compact('event', 'results', 'rejected_videos'));
    }

    public function evaluationAccept($id)
    {
        $event = LearningSession::findOrFail($id);
        $event->status = 5;
        $event->save();
        return response()->json([
            'status' => 'success',
            'message' => 'Approved Successfully!',
        ]);
    }

    public function evaluationReject($id)
    {
        $event = LearningSession::findOrFail($id);
        $event->status = 55;
        $event->save();
        return response()->json([
            'status' => 'success',
            'message' => 'Rejected Successfully!',
        ]);
    }

    public function evaluationResultPublished($id)
    {
        $event = LearningSession::findOrFail($id);
        $assignment = LearningSessionAssignment::where([['event_id', $id], ['send_to_manager', 1]])->update([
            'send_to_user' => 1,
        ]);

        session()->flash('success', 'Result Published Successfully');
        return redirect()->back();
    }






    public function manager_all()
    {
        $learningSessions = LearningSession::where([['status', '>', 0], ['category_id', auth()->user()->category_id]])->orderBy('updated_at', 'desc')->get();

        return view('ManagerAdmin.LearningSession.index', compact('learningSessions'));
    }

    public function set_approve_by_manager($id)
    {
        $meetup = LearningSession::find($id);
        $meetup->star_approval = 1;
        $meetup->update();



        return response()->json([
            'status' => 200,
            'meetup' => $meetup,
            'message' => 'Approved',
        ]);
    }

    public function event_info($id)
    {

        $meetup = LearningSession::find($id);

        return response()->json([
            'status' => 200,
            'meetup' => $meetup,
            'message' => 'Approved',
        ]);
    }


    public function manager_event_details($id)
    {
        $event = LearningSession::find($id);

        return view('ManagerAdmin.LearningSession.details', compact('event'));
    }


    public function manager_event_set_publish(Request $request, $id)
    {

        $learningSession = LearningSession::find($id);

        if ($learningSession->status != 2) {
            $request->validate([
                'post_start_date' => 'required',
                'post_end_date' => 'required',
            ]);
            $learningSession->status = 2;
            $learningSession->update();

            //    return $learningSession->star;

            // Create New post //
            $post = new Post();
            $post->type = 'learningSession';
            $post->user_id = $learningSession->star_id;
            $post->star_id = json_decode($learningSession->star_id);
            $post->event_id = $learningSession->id;
            $post->category_id = $learningSession->star->category_id;
            $post->sub_category_id = $learningSession->star->sub_category_id;
            $post->react_provider = "[]";
            $post->user_like_id = "[]";
            // $post->room_id = createRoomID();
            $post->post_start_date = Carbon::parse($request->post_start_date);
            $post->post_end_date = Carbon::parse($request->post_end_date);
            $post->save();
        } else {
            //$learningSession->manager_approval = 0;
            $learningSession->status = 1;
            $learningSession->room_id = createRoomID();
            $learningSession->update();

            //Remove post //
            $post = Post::where([['event_id', $learningSession->id], ['type', 'learningSession']])->first();
            $post->delete();
        }

        return redirect()->back()->with('success', 'Published');
    }




    // User Part


    public function meetup_event_list()
    {
        $meetup = LearningSession::where('status', 1)->latest()->get();

        return response()->json([
            'status' => 200,
            'meetup' => $meetup,
            'message' => 'Success',
        ]);
    }

    public function meetup_event_booking($star_id, $event_id)
    {
        $star = SuperStar::where('star_id', $star_id)->first();
        $meetup = LearningSession::find($event_id);

        return response()->json([
            'status' => 200,
            'star' => $star,
            'meetup' => $meetup,
            'message' => 'Success',
        ]);
    }

    public function meetup_register(Request $request)
    {
        $meetup = new LearningSessionRegistration();
        $event = LearningSession::find($request->input('meetup_event_id'));

        $meetup->user_id = auth('sanctum')->user()->id;
        $meetup->meetup_event_id = $request->input('meetup_event_id');
        $meetup->card_holder_name = $request->input('card_holder_name');
        $meetup->account_no = $request->input('card_number');
        $meetup->payment_date = $request->input('date');
        $meetup->amount = $event->fee;
        $meetup->payment_status = 1;

        $meetup->save();

        return response()->json([
            'status' => 200,
            'meetup' => $meetup,
            'message' => 'Success',
        ]);
    }

    public function edit($id)
    {
        $event = LearningSession::find($id);

        return view('ManagerAdmin.LearningSession.edit', compact('event'));
    }

    public function update(Request $request, $id)
    {
        if ($request->banner_or_video == 0) {
            $request->validate([
                'title' => 'required|unique:learning_sessions,title,' . $id,
                'description' => 'required',
                'instruction' => 'required',
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
                'description' => 'required',
                'instruction' => 'required',
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
}
