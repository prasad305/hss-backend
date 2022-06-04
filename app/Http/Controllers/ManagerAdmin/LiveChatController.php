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

class LiveChatController extends Controller
{

    public function show($id)
    {
        $event = LiveChat::find($id);
        return view('ManagerAdmin.LiveChat.details', compact('event'));
    }


    public function pending()
    {
        $upcommingEvent = LiveChat::where('status', 1)->latest()->get();

        return view('ManagerAdmin.LiveChat.index', compact('upcommingEvent'));
    }

    public function published()
    {
        $upcommingEvent = LiveChat::where([
            ['status', 1]
        ])->latest()->latest()->get();

        return view('ManagerAdmin.LiveChat.index', compact('upcommingEvent'));
    }

    public function all()
    {
        $upcommingEvent = LiveChat::latest()->latest()->get();

        return view('ManagerAdmin.LiveChat.index', compact('upcommingEvent'));
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
            $post->category_id=$starCat->category_id;
            $post->sub_category_id=$starCat->sub_category_id;
            $post->save();
        } else {
            $event->status = 8;
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
        $liveChat = LiveChat::findOrFail($id);
        $liveChat->fill($request->except('_token'));

        $liveChat->title = $request->input('title');
        $liveChat->description = $request->input('description');

        // $liveChat->date = $request->input('date');
        // $liveChat->start_time = Carbon::parse($request->input('start_time'));
        // $liveChat->end_time = Carbon::parse($request->input('end_time'));

        $liveChat->fee = $request->input('fee');
        $liveChat->total_seat = $request->input('slots');

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
