<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\MeetupEvent;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Str;


class MeetupEventController extends Controller
{
    public function index()
    {
        $categories = Category::get();
        return view('SuperAdmin.MeetupEvent.index', compact('categories'));
    }
    public function meetupEventList($categoryId)
    {
        $postList = MeetupEvent::where('category_id', $categoryId)->latest()->get();
        return view('SuperAdmin.MeetupEvent.MeetupEventList', compact('postList'));
    }
    public function meetupEventDetails($postId)
    {
        $meetup = MeetupEvent::findOrFail($postId);
        return view('SuperAdmin.MeetupEvent.details', compact('meetup'));
    }
    public function meetupeventEdit($id)
    {
        $event = MeetupEvent::find($id);

        return view('SuperAdmin.MeetupEvent.edit', compact('event'));
    }
    public function meetupEventUpdate(Request $request, $id)
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
    public function meetupEventDestroy($id)
    {
        $post = Post::where('event_id', $id)->first();
        $postDelete = MeetupEvent::findOrfail($id);
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
