<?php

namespace App\Http\Controllers\ManagerAdmin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\SuperStar;
use App\Models\LearningSession;
use App\Models\LearningSessionRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;

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
        $upcommingEvent = LearningSession::where([
            ['star_approval', 1], ['status', 0]
        ])->latest()->get();

        return view('ManagerAdmin.LearningSession.index', compact('upcommingEvent'));
    }

    public function manager_published()
    {
        $upcommingEvent = LearningSession::where([
            ['status', 1]
        ])->latest()->latest()->get();

        return view('ManagerAdmin.LearningSession.index', compact('upcommingEvent'));
    }

    public function manager_all()
    {
        $upcommingEvent = LearningSession::latest()->latest()->get();

        return view('ManagerAdmin.LearningSession.index', compact('upcommingEvent'));
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
        // $upcommingEvent = LearningSession::where([
        //     ['star_approval',1],['manager_approval',0]
        // ])->latest()->get();

        // return view('ManagerAdmin.LearningSession.index', compact('upcommingEvent'));

        $meetup = LearningSession::find($id);

        return view('ManagerAdmin.LearningSession.details', compact('meetup'));
    }


    public function manager_event_set_publish($id)
    {
        $meetup = LearningSession::find($id);

        if ($meetup->status != 1) {
            //$meetup->manager_approval = 1;
            $meetup->status = 1;

            $meetup->update();

            $starCat = SuperStar::where('star_id', $meetup->star_id)->first();
            
            // Create New post //
            $post = new Post();
            $post->type = 'learningSession';
            $post->user_id = $meetup->star_id;
            $post->event_id = $meetup->id;
            $post->category_id=$starCat->category_id;
            $post->sub_category_id=$starCat->sub_category_id;
            $post->save();
        } else {
            //$meetup->manager_approval = 0;
            $meetup->status = 0;
            $meetup->update();

            //Remove post //
            $post = Post::where('event_id', $id)->first();
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
        $meetup = LearningSession::findOrFail($id);
        $meetup->fill($request->except('_token'));

        $meetup->title = $request->input('title');
        $meetup->slug = Str::slug($request->input('title'));
        $meetup->description = $request->input('description');

        // $meetup->event_link= $request->input('event_link');
        // $meetup->meetup_type = $request->input('meetup_type');
        // $meetup->date = $request->input('date');
        // $meetup->start_time = $request->input('start_time');
        // $meetup->end_time = $request->input('end_time');
        // $meetup->venue = $request->input('venue');

        $meetup->participant_number = $request->input('slots');
        $meetup->fee = $request->input('fee');

        if ($request->hasfile('image')) {
            $destination = $meetup->banner;
            if (File::exists($destination)) {
                File::delete($destination);
            }
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = 'uploads/images/learning_session/' . time() . '.' . $extension;

            Image::make($file)->resize(900, 400)
                ->save($filename, 50);

            $meetup->banner = $filename;
        }

        try {
            $meetup->update();
            if ($meetup) {
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
