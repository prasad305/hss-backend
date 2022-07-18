<?php

namespace App\Http\Controllers\ManagerAdmin;

use App\Http\Controllers\Controller;
use App\Models\SimplePost;
use App\Models\Post;
use App\Models\SuperStar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;

class SimplePostController extends Controller
{
    //
    public function all()
    {
        $post = SimplePost::where('category_id', auth()->user()->category_id)->where('status', 1)->orWhere('star_approval', 1)->latest()->get();

        return view('ManagerAdmin.SimplePost.index', compact('post'));
    }

    public function pending()
    {
        $post = SimplePost::where('category_id', auth()->user()->category_id)->where([['status', 0], ['star_approval', 1]])->latest()->get();

        return view('ManagerAdmin.SimplePost.index', compact('post'));
    }

    public function published()
    {
        $post = SimplePost::where('category_id', auth()->user()->category_id)->where('status', 1)->latest()->get();

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

        $request->validate([

            'title' => 'required',
            'description' => 'required',



        ], [
            'title.required' => 'Title Field Is Required',
            'description.required' => 'Description Field Is Required',

        ]);

        $meetup = SimplePost::findOrFail($id);
        $meetup->fill($request->except('_token'));

        $meetup->title = $request->input('title', 'image', 'video');
        $meetup->description = $request->input('description');

        if ($request->hasfile('image')) {

            $destination = $meetup->image;
            if (File::exists(public_path($destination))) {
                File::delete(public_path($destination));
            }

            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = 'uploads/images/post/' . time() . '.' . $extension;

            Image::make($file)->resize(900, 400)->save($filename, 50);
            $meetup->image = $filename;
        }

        if ($request->hasfile('video')) {

            $destination = $meetup->image;
            if (File::exists(public_path($destination))) {
                File::delete(public_path($destination));
            }
            if ($request->hasFile('video')) {

                $file        = $request->file('video');
                $path        = 'uploads/videos/post';
                $file_name   = time() . rand('0000', '9999') . '.' . $file->getClientOriginalName();
                $file->move($path, $file_name);
                $meetup->video = $path . '/' . $file_name;
            }
        }


        try {
            $meetup->update();
            if ($meetup) {
                return response()->json([
                    'success' => true,
                    'message' => 'Post Updated Successfully'
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

        if ($spost->status != 1) {
            $spost->status = 1;
            $spost->update();

            $starCat = SuperStar::find($spost->star_id);
            // Create New post //
            $post = new Post();
            $post->type = 'general';
            $post->user_id = $spost->star_id;
            $post->event_id = $spost->id;
            $post->category_id = $spost->category_id;
            $post->title = $spost->title;
            $post->details = $spost->description;
            $post->status = 1;
            $post->sub_category_id = $spost->subcategory_id;
            $post->save();
        } else {
            $spost->status = 0;
            $spost->update();

            //Remove post //
            $post = Post::where('event_id', $id)->first();
            $post->delete();
        }

        return redirect()->back()->with('success', 'Published');
    }
}
