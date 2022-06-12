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
        $events = LiveChat::where([['status', '>', 0], ['category_id', auth()->user()->category_id]])->latest()->get();
        return view('ManagerAdmin.LiveChat.index', compact('events'));
    }

    public function pending()
    {
        $events = LiveChat::where([['status', 1], ['category_id', auth()->user()->category_id]])->latest()->get();
        return view('ManagerAdmin.LiveChat.index', compact('events'));
    }

    public function published()
    {
        $events = LiveChat::where([['status', 2], ['category_id', auth()->user()->category_id]])->latest()->get();
        return view('ManagerAdmin.LiveChat.index', compact('events'));
    }

    public function manager_event_details($id)
    {
        $event = LiveChat::find($id);
        return view('ManagerAdmin.LiveChat.details', compact('event'));
    }


    public function manager_event_set_publish(Request $request, $id)
    {
        $event = LiveChat::find($id);

        if ($event->status != 2) {
            $request->validate([
                'post_start_date' => 'required',
                'post_end_date' => 'required',
            ]);

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
            $post->post_start_date = Carbon::parse($request->post_start_date);
            $post->post_end_date = Carbon::parse($request->post_end_date);
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
            'description' => 'required|min:5',
            'instruction' => 'required|min:5',
            'image' => 'mimes:png,jpg,jpeg,webP',
        ], [
            'title.required' => 'This Field Is Required',
            'description.required' => 'This Field Is Required',
            'instruction.required' => 'This Field Is Required',
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
