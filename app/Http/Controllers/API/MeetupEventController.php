<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MeetupEvent;
use App\Models\MeetupEventRegistration;
use App\Models\SuperStar;
use App\Models\Activity;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Validator;

class MeetupEventController extends Controller
{
    public function add_by_admin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'star_id' => 'required',
            'title' => 'required|unique:meetup_events,title',
            'description' => 'required|min:8',
            'instruction' => 'required|min:8',
            'event_date' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'reg_start_date' => 'required',
            'reg_end_date' => 'required',
            'fee' => 'required',
            'slots' => 'required',
            'venue' => 'required_if:meetup_type,"Offline"',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'validation_errors' => $validator->errors(),
            ]);
        } else {
            $star = SuperStar::where('star_id', $request->input('star_id'))->first();

            $meetup = new MeetupEvent();

            $meetup->created_by_id = auth('sanctum')->user()->id;
            $meetup->star_id = $request->input('star_id');
            $meetup->category_id = $star->category_id;
            $meetup->sub_category_id = $star->sub_category_id;
            $meetup->admin_id = $star->admin_id;
            $meetup->title = $request->input('title');
            $meetup->slug = Str::slug($request->input('title'));
            $meetup->event_link = $request->input('event_link');
            $meetup->venue = $request->input('venue');
            $meetup->meetup_type = $request->input('meetup_type');
            $meetup->event_date = $request->input('event_date');
            $meetup->start_time = $request->input('start_time');
            $meetup->end_time = $request->input('end_time');
            $meetup->description = $request->input('description');
            $meetup->instruction = $request->input('instruction');
            $meetup->total_seat = $request->input('slots');
            $meetup->reg_start_date = $request->input('reg_start_date');
            $meetup->reg_end_date = $request->input('reg_end_date');
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

            if ($request->hasfile('video')) {
                $destination = $meetup->video;
                if (File::exists($destination)) {
                    File::delete($destination);
                }
                $file = $request->file('video');
                $path = 'uploads/videos/meetup';
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extension;
                $file->move($path, $filename);
                $meetup->video = $path . '/' . $filename;
            }

            $meetup->save();

            return response()->json([
                'status' => 200,
                'meetup_id' => $meetup->id,
                'message' => 'Meetup Event Added',
            ]);
        }
    }

    public function update_by_admin(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required|min:6',
            'instruction' => 'required|min:6',
            'event_date' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'reg_start_date' => 'required',
            'reg_end_date' => 'required',
            'fee' => 'required',
            'total_seat' => 'required|numeric|min:0',
            'venue' => 'required_if:meetup_type,"Offline"',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'validation_errors' => $validator->errors(),
            ]);
        } else {
            $meetup = MeetupEvent::find($id);

            $meetup->title = $request->input('title');
            $meetup->slug = Str::slug($request->input('title'));
            $meetup->event_link = $request->input('event_link');
            $meetup->venue = $request->input('venue');
            $meetup->meetup_type = $request->input('meetup_type');
            $meetup->event_date = $request->input('event_date');
            $meetup->start_time = $request->input('start_time');
            $meetup->end_time = $request->input('end_time');
            $meetup->description = $request->input('description');
            $meetup->instruction = $request->input('instruction');
            $meetup->total_seat = $request->input('total_seat');
            $meetup->reg_start_date = $request->input('reg_start_date');
            $meetup->reg_end_date = $request->input('reg_end_date');
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

            if ($request->hasfile('video')) {
                $destination = $meetup->video;
                if (File::exists($destination)) {
                    File::delete($destination);
                }
                $file = $request->file('video');
                $path = 'uploads/videos/meetup';
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extension;
                $file->move($path, $filename);
                $meetup->video = $path . '/' . $filename;
            }

            $meetup->update();

            return response()->json([
                'status' => 200,
                'meetup' => $meetup,
                'message' => 'Meetup Event Updated',
            ]);
        }
    }




    public function pending_list()
    {
        $events = MeetupEvent::where([['admin_id', auth('sanctum')->user()->id], ['status', '<', 2]]);

        return response()->json([
            'status' => 200,
            'events' => $events->latest()->get(),
            'count' => $events->count(),
        ]);
    }

    public function live_list()
    {
        $events = MeetupEvent::where([['admin_id', auth('sanctum')->user()->id], ['status', 2]]);

        return response()->json([
            'status' => 200,
            'events' => $events->latest()->get(),
            'count' => $events->count(),
        ]);
    }

    public function completed()
    {
        $events = MeetupEvent::where([['admin_id', auth('sanctum')->user()->id], ['status', 9]]);

        return response()->json([
            'status' => 200,
            'events' => $events->latest()->get(),
            'count' => $events->count(),
        ]);
    }

    public function details($slug)
    {
        $meetup = MeetupEvent::where('slug', $slug)->first();

        return response()->json([
            'status' => 200,
            'meetup' => $meetup,
            'message' => 'Success',
        ]);
    }

    public function slots($slug)
    {

        $event = MeetupEvent::where('slug', $slug)->first();

        $meetup = MeetupEventRegistration::where('meetup_event_id', $event->id)->get();
        $slot = $event->total_seat;

        return response()->json([
            'status' => 200,
            'meetup' => $meetup,
            'count' => $meetup->count(),
            'empty_slot' => $slot - $meetup->count(),
            'message' => 'Success',
        ]);
    }

    public function star_meetup_list($type)
    {
        if ($type == 'all')
            $events = MeetupEvent::where([['star_id', auth('sanctum')->user()->id], ['status', '>', 0]]);

        if ($type == 'pending')
            $events = MeetupEvent::where([['star_id', auth('sanctum')->user()->id], ['status', '<', 1]]);
        if ($type == 'approved')
            $events = MeetupEvent::where([['star_id', auth('sanctum')->user()->id], ['status', '>', 0], ['status', '<', 10]]);
        if ($type == 'completed')
            $events = MeetupEvent::where([['star_id', auth('sanctum')->user()->id], ['status', 9]]);
        if ($type == 'rejected')
            $events = MeetupEvent::where([['star_id', auth('sanctum')->user()->id], ['status', 11]]);

        return response()->json([
            'status' => 200,
            'events' => $events->latest()->get(),
            'count' => $events->count(),
        ]);
    }

    public function star_approved_list()
    {
        $events = MeetupEvent::where([['star_id', auth('sanctum')->user()->id], ['status', '>', 0], ['status', '<', 10]]);

        return response()->json([
            'status' => 200,
            'events' => $events->latest()->get(),
            'count' => $events->count(),
        ]);
    }

    public function star_completed_list()
    {
        $events = MeetupEvent::where([['star_id', auth('sanctum')->user()->id], ['status', 9]]);

        return response()->json([
            'status' => 200,
            'events' => $events->latest()->get(),
            'count' => $events->count(),
        ]);
    }

    public function set_approve($id)
    {
        $meetup = MeetupEvent::find($id);
        $meetup->status = 1;
        $meetup->update();

        return response()->json([
            'status' => 200,
            'message' => 'Approved',
        ]);
    }

    public function set_reject($id)
    {
        $meetup = MeetupEvent::find($id);
        $meetup->status = 11;
        $meetup->update();

        return response()->json([
            'status' => 200,
            'message' => 'Approved',
        ]);
    }

    /// Manager Part ////

    public function event_info($id)
    {

        $meetup = MeetupEvent::find($id);

        return response()->json([
            'status' => 200,
            'meetup' => $meetup,
            'message' => 'Approved',
        ]);
    }




    public function manager_event_details($id)
    {
        $meetup = MeetupEvent::find($id);

        return view('ManagerAdmin.MeetupEvents.details', compact('meetup'));
    }


    public function manager_event_set_publish(Request $request, $id)
    {
        $meetup = MeetupEvent::find($id);

        if ($meetup->status != 2) {

            $request->validate([
                'post_start_date' => 'required',
                'post_end_date' => 'required',
            ]);

            $meetup->status = 2;
            $meetup->update();

            $starCat = SuperStar::where('star_id', $meetup->star_id)->first();
            // Create New post //
            $post = new Post();
            $post->type = 'meetup';
            $post->user_id = $meetup->star_id;
            $post->event_id = $meetup->id;
            $post->category_id = $starCat->category_id;
            $post->sub_category_id = $starCat->sub_category_id;
            $post->post_start_date = Carbon::parse($request->post_start_date);
            $post->post_end_date = Carbon::parse($request->post_end_date);
            $post->save();

            return redirect()->back()->with('success', 'Published');
        } else {
            $meetup->status = 10;
            $meetup->update();
            //Remove post //
            $post = Post::where('event_id', $id)->first();
            $post->delete();

            return redirect()->back()->with('warning', 'Removed');
        }


        return redirect()->back()->with('success', 'Published');
    }



    // User Part
    public function meetup_event_list()
    {
        $meetup = MeetupEvent::where('status', 2)->latest()->get();

        return response()->json([
            'status' => 200,
            'meetup' => $meetup,
            'message' => 'Success',
        ]);
    }

    public function meetup_event_booking($star_id, $event_id)
    {
        $star = SuperStar::where('star_id', $star_id)->first();
        $meetup = MeetupEvent::find($event_id);

        return response()->json([
            'status' => 200,
            'star' => $star,
            'meetup' => $meetup,
            'message' => 'Success',
        ]);
    }

    public function meetup_register(Request $request)
    {
        $meetup = new MeetupEventRegistration();
        $event = MeetupEvent::find($request->input('meetup_event_id'));

        $meetup->user_id = auth('sanctum')->user()->id;
        $meetup->meetup_event_id = $request->input('meetup_event_id');
        $meetup->card_holder_name = $request->input('card_holder_name');
        $meetup->account_no = $request->input('card_number');
        $meetup->payment_date = $request->input('event_date');
        $meetup->amount = $event->fee;
        $meetup->payment_status = 1;

        $meetup->save();

        // New Activity Add For MeetupEventRegistration
        $activity = new Activity();
        $activity->user_id = auth('sanctum')->user()->id;
        $activity->event_id = $request->input('meetup_event_id');
        $activity->event_registration_id = $meetup->id;
        $activity->type = 'meetup';
        $activity->save();

        return response()->json([
            'status' => 200,
            'meetup' => $meetup,
            'message' => 'Success',
        ]);
    }

    public function edit($id)
    {
        $event = MeetupEvent::find($id);

        return view('ManagerAdmin.MeetupEvents.edit', compact('event'));
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'title' => 'required',
            'description' => 'required|min:5',
            'instruction' => 'required|min:5',
            'image' => 'mimes:png,jpg,jpeg,webP',
        ], [
            'title.required' => 'This Field Is Required',
            'description.required' => 'This Field Is Required',
            'instruction.required' => 'This Field Is Required',
        ]);

        $meetup = MeetupEvent::findOrFail($id);
        $meetup->fill($request->except('_token'));

        $meetup->title = $request->input('title');
        $meetup->description = $request->input('description');
        $meetup->instruction = $request->input('instruction');


        if ($request->hasfile('image')) {
            $destination = $meetup->banner;
            if (File::exists($destination)) {
                File::delete($destination);
            }
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = 'uploads/images/meetup/' . time() . '.' . $extension;

            Image::make($file)->resize(900, 400)
                ->save($filename, 50);

            $meetup->banner = $filename;
        }

        try {
            $meetup->update();
            if ($meetup) {
                return response()->json([
                    'success' => true,
                    'message' => 'Meetup Event Updated Successfully'
                ]);
            }
        } catch (\Exception $exception) {
            return response()->json([
                'type' => 'error',
                'message' => 'Opps somthing went wrong. ' . $exception->getMessage(),
            ]);
        }
    }

    public function star_add_meetup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:meetup_events,title',
            'description' => 'required|min:8',
            'instruction' => 'required|min:8',
            'event_date' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'reg_start_date' => 'required',
            'reg_end_date' => 'required',
            'fee' => 'required',
            'slots' => 'required',
            'venue' => 'required_if:meetup_type,"Offline"',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'validation_errors' => $validator->errors(),
            ]);
        } else {
            $superStar = SuperStar::where('star_id', auth('sanctum')->user()->id)->first();

            $meetup = new MeetupEvent();

            $meetup->created_by_id = auth('sanctum')->user()->id;
            $meetup->star_id = auth('sanctum')->user()->id;
            $meetup->admin_id = $superStar->admin_id;
            $meetup->category_id = $superStar->category_id;
            $meetup->sub_category_id = $superStar->sub_category_id;
            $meetup->title = $request->input('title');
            $meetup->slug = Str::slug($request->input('title'));
            $meetup->event_link = $request->input('event_link');
            $meetup->venue = $request->input('venue');
            $meetup->meetup_type = $request->input('meetup_type');
            $meetup->event_date = $request->input('event_date');
            $meetup->start_time = $request->input('start_time');
            $meetup->end_time = $request->input('end_time');
            $meetup->description = $request->input('description');
            $meetup->instruction = $request->input('instruction');
            $meetup->total_seat = $request->input('slots');
            $meetup->reg_start_date = $request->input('reg_start_date');
            $meetup->reg_end_date = $request->input('reg_end_date');
            $meetup->fee = $request->input('fee');
            $meetup->status = 1;

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

            if ($request->hasfile('video')) {
                $destination = $meetup->video;
                if (File::exists($destination)) {
                    File::delete($destination);
                }
                $file = $request->file('video');
                $path = 'uploads/videos/meetup';
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extension;
                $file->move($path, $filename);
                $meetup->video = $path . '/' . $filename;
            }

            if ($request->image_path) {
                $meetup->banner = $request->image_path;
            }

            $meetup->save();

            return response()->json([
                'status' => 200,
                'meetup_id' => $meetup->id,
                'message' => 'Meetup Event Added',
            ]);
        }
    }



    public function star_edit(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'star_id' => 'required',
            'title' => 'required',
            'description' => 'required|min:6',
            'instruction' => 'required|min:6',
            'event_date' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'reg_start_date' => 'required',
            'reg_end_date' => 'required',
            'fee' => 'required',
            'total_seat' => 'required',
            'venue' => 'required_if:meetup_type,"Offline"',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'validation_errors' => $validator->errors(),
            ]);
        } else {
            $meetup = MeetupEvent::find($id);

            $meetup->star_id = $request->input('star_id');
            $meetup->title = $request->input('title');
            $meetup->slug = Str::slug($request->input('title'));
            $meetup->event_link = $request->input('event_link');
            $meetup->venue = $request->input('venue');
            $meetup->meetup_type = $request->input('meetup_type');
            $meetup->event_date = $request->input('event_date');
            $meetup->start_time = $request->input('start_time');
            $meetup->end_time = $request->input('end_time');
            $meetup->description = $request->input('description');
            $meetup->instruction = $request->input('instruction');
            $meetup->total_seat = $request->input('total_seat');
            $meetup->reg_start_date = $request->input('reg_start_date');
            $meetup->reg_end_date = $request->input('reg_end_date');
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

            if ($request->hasfile('video')) {
                $destination = $meetup->video;
                if (File::exists($destination)) {
                    File::delete($destination);
                }
                $file = $request->file('video');
                $path = 'uploads/videos/meetup';
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extension;
                $file->move($path, $filename);
                $meetup->video = $path . '/' . $filename;
            }

            $meetup->update();

            return response()->json([
                'status' => 200,
                'meetup' => $meetup,
                'message' => 'Meetup Event Updated',
            ]);
        }
    }
}
