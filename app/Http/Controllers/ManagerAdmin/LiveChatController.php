<?php

namespace App\Http\Controllers\ManagerAdmin;

use App\Http\Controllers\Controller;
use App\Models\LiveChat;
use App\Models\Post;
use App\Models\SuperStar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Str;

class LiveChatController extends Controller
{

    public function show($id)
    {
        $event = LiveChat::find($id);
        return view('ManagerAdmin.LiveChat.details', compact('event'));
    }

    public function all()
    {
        $events = LiveChat::where('status', '>', 0)->latest()->get();
        return view('ManagerAdmin.LiveChat.index', compact('events'));
    }

    public function pending()
    {
        $events = LiveChat::where('status', 1)->latest()->get();
        return view('ManagerAdmin.LiveChat.index', compact('events'));
    }

    public function published()
    {
        $events = LiveChat::where('status', 2)->latest()->latest()->get();
        return view('ManagerAdmin.LiveChat.index', compact('events'));
    }

    public function manager_event_details($id)
    {
        $event = LiveChat::find($id);
        return view('ManagerAdmin.LiveChat.details', compact('event'));
    }


    public function manager_event_set_publish($id)
    {
        $event = LiveChat::find($id);

        if ($event->status != 2) {
            $event->status = 2;
            $event->update();
            $starCat = SuperStar::where('star_id', $event->star_id)->first();

            // Create New post //
            $post = new Post();
            $post->type = 'livechat';
            $post->user_id = $event->star_id;
            $post->event_id = $event->id;
            $post->category_id = $starCat->category_id;
            $post->sub_category_id = $starCat->sub_category_id;
            $post->save();
        } else {
            $event->status = 10;
            $event->update();
            // Remove post //
            $post = Post::where('event_id', $id)->first();
            $post->delete();
        }

        return redirect()->back()->with('success', 'Published');
    }

    public function edit($id)
    {
        $event = LiveChat::find($id);
        return view('ManagerAdmin.LiveChat.edit', compact('event'));
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'instruction' => 'required',
            'image' => 'mimes:png,jpg,jpeg,webP',
            'date' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'registration_start_date' => 'required',
            'registration_end_date' => 'required',
            'fee' => 'required',
            'total_seat' => 'required',
            'max_time' => 'required',
            'min_time' => 'required',
            'interval' => 'required',
        ], [
            'title.required' => 'This Field Is Required',
            'description.required' => 'This Field Is Required',
            'instruction.required' => 'This Field Is Required',
            'date.required' => 'This Field Is Required',
            'start_time.required' => 'This Field Is Required',
            'end_time.required' => 'This Field Is Required',
            'registration_start_date.required' => 'This Field Is Required',
            'registration_end_date.required' => 'This Field Is Required',
            'fee.required' => 'This Field Is Required',
            'total_seat.required' => 'This Field Is Required',
            'max_time.required' => 'This Field Is Required',
            'min_time.required' => 'This Field Is Required',
            'interval.required' => 'This Field Is Required',
        ]);


        $liveChat = LiveChat::findOrFail($id);
        $liveChat->fill($request->except('_token'));

        $liveChat->title = $request->input('title');
        $liveChat->slug = Str::slug($request->input('title'));
        $liveChat->description = $request->input('description');
        $liveChat->instruction = $request->input('instruction');

        if ($request->hasfile('image')) {
            $destination = $liveChat->banner;
            if (File::exists($destination)) {
                File::delete($destination);
            }
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = 'uploads/images/live_chat/' . time() . '.' . $extension;

            Image::make($file)->resize(900, 400)->save($filename, 100);
            $liveChat->banner = $filename;
        }

        $liveChat->date = $request->input('date');
        $liveChat->start_time = $request->input('start_time');
        $liveChat->end_time = $request->input('end_time');

        $liveChat->registration_start_date = $request->input('registration_start_date');
        $liveChat->registration_end_date = $request->input('registration_end_date');
        $liveChat->fee = $request->input('fee');
        $liveChat->total_seat = $request->input('total_seat');
        $liveChat->max_time = $request->input('max_time');
        $liveChat->min_time = $request->input('min_time');
        $liveChat->interval = $request->input('interval');


        try {
            $liveChat->update();
            if ($liveChat) {
                return response()->json([
                    'success' => true,
                    'message' => 'LiveChat Event Updated Successfully'
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
