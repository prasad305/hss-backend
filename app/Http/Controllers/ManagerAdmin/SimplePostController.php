<?php

namespace App\Http\Controllers\ManagerAdmin;

use App\Http\Controllers\Controller;
use App\Models\SimplePost;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;

class SimplePostController extends Controller
{
    //
    public function all()
    {
        $post = SimplePost::latest()->get();

        return view('ManagerAdmin.SimplePost.index', compact('post'));
    }

    public function pending()
    {
        $post = SimplePost::where([['status',0],['star_approval',1]])->latest()->get();

        return view('ManagerAdmin.SimplePost.index', compact('post'));
    }

    public function published()
    {
        $post = SimplePost::where('status',1)->latest()->get();

        return view('ManagerAdmin.SimplePost.index', compact('post'));
    }

    public function details($id)
    {
        $post = SimplePost::find($id);

        return view('ManagerAdmin.SimplePost.details', compact('post'));
    }


    public function edit($id)
    {
        $event = SimplePost::find($id);

        return view('ManagerAdmin.SimplePost.edit', compact('event'));
    }

    public function update(Request $request, $id)
    {
        $meetup = SimplePost::findOrFail($id);
        $meetup->fill($request->except('_token'));

        $meetup->title = $request->input('title');
        $meetup->description = $request->input('description');

        // $meetup->event_link= $request->input('event_link');
        // $meetup->meetup_type = $request->input('meetup_type');
        // $meetup->date = $request->input('date');
        // $meetup->start_time = $request->input('start_time');
        // $meetup->end_time = $request->input('end_time');
        // $meetup->venue = $request->input('venue');

        if ($request->hasfile('image')) {

            // $destination = $meetup->image;
            // if (File::exists($destination)) {
            //     File::delete($destination);
            // }

            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = 'uploads/images/post/' . time() . '.' . $extension;

            Image::make($file)->resize(900, 400)->save($filename, 50);
            $meetup->image = $filename;


        }


            try {
                $meetup->update();
                if($meetup){
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

    public function set_publish($id)
    {
        $spost = SimplePost::find($id);

        if($spost->status != 1)
        {
            $spost->status = 1;
            $spost->update();

            // Create New post //
            $post = new Post();
            $post->type='general';
            $post->user_id=$spost->star_id;
            $post->event_id = $spost->id;
            $post->save();
        }
        else
        {
            $spost->status = 0;
            $spost->update();

            //Remove post //
            $post = Post::where('event_id',$id)->first();
            $post->delete();
        }

        return redirect()->back()->with('success', 'Published');


    }
}
