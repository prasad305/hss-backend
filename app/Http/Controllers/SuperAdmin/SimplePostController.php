<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\SimplePost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;

class SimplePostController extends Controller
{
    public function index()
    {
        $categories = Category::get();
        return view('SuperAdmin.SimplePost.index', compact('categories'));
    }
    public function simplepostList($categoryId)
    {
        $postList = SimplePost::with(['star','admin'])->where('category_id', $categoryId)->latest()->get();
        return view('SuperAdmin.SimplePost.PostList', compact('postList'));
    }
    public function simplepostDetails($postId)
    {
        $post = SimplePost::findOrFail($postId);
        return view('SuperAdmin.SimplePost.details', compact('post'));
    }
    public function simplepostEdit($id)
    {
        $event = SimplePost::find($id);

        return view('SuperAdmin.SimplePost.edit', compact('event'));
    }
    public function simplepostUpdate(Request $request, $id)
    {

        $request->validate([

            'title' => 'required',
            'description' => 'required|min:10',



        ], [
            'title.required' => 'Title Field Is Required',
            'description.required' => 'Description Field Is Required',

        ]);

        $meetup = SimplePost::findOrFail($id);
        $meetup->fill($request->except('_token', 'image', 'video'));

        $meetup->title = $request->input('title');
        $meetup->description = $request->input('description');

        if ($request->hasfile('image')) {

            $destination = ($meetup->image);
            if (File::exists(public_path($destination))) {
                File::delete(public_path($destination));
            }

            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = 'uploads/images/post/' . time() . rand('0000', '9999')  . '.' . $extension;

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
    public function simplepostDestroy($id)
    {
        $post = Post::where('event_id', $id)->first();
        $postDelete = SimplePost::findOrfail($id);
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
