<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SimplePost;
use App\Models\Post;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManagerStatic as Image;
use Vonage\Client\Exception\Validation;

class SimplePostController extends Controller
{
    //
    public function add(Request $request)
    {

        $validator = Validator::make($request->all(), [

            'title' => 'required',
            'description' => 'required',
            'star_id' => 'required',
            'type' => 'required',


        ],[
            'title.required' => 'Title Field Is Required',
            'description.required' => 'Description Field Is Required',
            'star_id.required' => "Star Field Is Required",
            'type.required' => "This  Field Is Required",

        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 402,
                'errors' => $validator->errors(),
            ]);
        }

        $post = new SimplePost();
        $post->title = $request->input('title');
        $post->created_by_id = auth('sanctum')->user()->id;
        $post->category_id = auth('sanctum')->user()->category_id;
        $post->subcategory_id = auth('sanctum')->user()->sub_category_id;
        $post->star_id = $request->input('star_id');
        $post->description = $request->input('description');
        $post->fee = $request->input('fee') > 0  ? $request->input('fee') : 0;
        $post->video = $request->input('video');
        $post->type = $request->input('type');

        if ($request->hasfile('image')) {
            $destination = $post->image;
            if (File::exists($destination)) {
                File::delete($destination);
            }
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = 'uploads/images/post/' . time() . '.' . $extension;

            Image::make($file)->resize(900, 400)->save($filename, 100);
            $post->image = $filename;
        }
        if ($request->hasFile('video')) {
    
            $file        = $request->file('video');
            $path        = 'uploads/videos/post';
            $file_name   = time() . rand('0000', '9999') . '.' . $file->getClientOriginalName();
            $file->move($path, $file_name);
            $post->video = $path . '/' . $file_name;
        }
        $post->save();

        return response()->json([
            'status' => 200,
            'message' => 'Post Added',
        ]);
    }

    public function count()
    {
        $pending = SimplePost::where([['created_by_id', auth('sanctum')->user()->id], ['status', 0]])->count();
        $approved = SimplePost::where([['created_by_id', auth('sanctum')->user()->id], ['status', 1]])->count();

        return response()->json([
            'status' => 200,
            'pending' => $pending,
            'approved' => $approved,
            'message' => 'Success',
        ]);
    }

    public function all()
    {
        $post = SimplePost::where('created_by_id', auth('sanctum')->user()->id)->latest()->get();
        $count = SimplePost::where('created_by_id', auth('sanctum')->user()->id)->count();

        return response()->json([
            'status' => 200,
            'post' => $post,
            'count' => $count,
            'message' => 'Success',
        ]);
    }

    public function pending_list()
    {
        $post = SimplePost::where([['created_by_id', auth('sanctum')->user()->id], ['status', 0]])->latest()->get();
        $count = SimplePost::where([['created_by_id', auth('sanctum')->user()->id], ['status', 0]])->count();

        return response()->json([
            'status' => 200,
            'post' => $post,
            'count' => $count,
            'message' => 'Success',
        ]);
    }

    public function pending_details($id)
    {
        $post = SimplePost::find($id);

        return response()->json([
            'status' => 200,
            'post' => $post,
            'message' => 'Success',
        ]);
    }

    public function approved_list()
    {
        $post = SimplePost::where([['created_by_id', auth('sanctum')->user()->id], ['status', 1]])->latest()->get();
        $count = SimplePost::where([['created_by_id', auth('sanctum')->user()->id], ['status', 1]])->count();

        return response()->json([
            'status' => 200,
            'post' => $post,
            'count' => $count,
            'message' => 'Success',
        ]);
    }


    /// For Super Star ///

    public function star_count()
    {
        $pending = SimplePost::where([['star_id', auth('sanctum')->user()->id], ['star_approval', 0]])->count();
        $approved = SimplePost::where([['star_id', auth('sanctum')->user()->id], ['star_approval', 1]])->count();

        return response()->json([
            'status' => 200,
            'pending' => $pending,
            'approved' => $approved,
            'message' => 'Success',
        ]);
    }


    public function star_all()
    {
        $post = SimplePost::where('star_id', auth('sanctum')->user()->id)->latest()->get();
        $count = SimplePost::where('star_id', auth('sanctum')->user()->id)->count();

        return response()->json([
            'status' => 200,
            'post' => $post,
            'count' => $count,
            'message' => 'Success',
        ]);
    }

    public function star_pending_list()
    {
        $post = SimplePost::where([['star_id', auth('sanctum')->user()->id], ['star_approval', 0]])->latest()->get();
        $count = SimplePost::where([['star_id', auth('sanctum')->user()->id], ['star_approval', 0]])->count();

        return response()->json([
            'status' => 200,
            'post' => $post,
            'count' => $count,
            'message' => 'Success',
        ]);
    }

    public function star_pending_details($id)
    {
        $post = SimplePost::find($id);

        return response()->json([
            'status' => 200,
            'post' => $post,
            'message' => 'Success',
        ]);
    }

    public function star_approved_list()
    {
        $post = SimplePost::where([['star_id', auth('sanctum')->user()->id], ['star_approval', 1]])->latest()->get();
        // $post = SimplePost::where('star_approval', 1)->latest()->get();
        $count = SimplePost::where([['star_id', auth('sanctum')->user()->id], ['star_approval', 1]])->count();

        $star = auth('sanctum')->user()->id;

        return response()->json([
            'status' => 200,
            'post' => $post,
            'count' => $count,
            'star' => $star,
            'message' => 'Success',
        ]);
    }

    public function approve_post($id)
    {

        $spost = SimplePost::find($id);

        if ($spost->type == 'paid') {
            $spost->star_approval = 1;
            $spost->update();
        } else {
            if ($spost->status != 1) {
                $spost->status = 1;
                $spost->star_approval = 1;
                $spost->update();

                // Create New post //
                $post = new Post();
                $post->type = 'general';
                $post->user_id = $spost->star_id;
                $post->event_id = $spost->id;
                $post->save();
            } else {
                $spost->status = 0;
                $spost->update();

                //Remove post //
                $post = Post::where('event_id', $id)->first();
                $post->delete();
            }
        }


        return response()->json([
            'status' => 200,
            'message' => 'Success',
        ]);
    }

    public function decline_post($id){
        $declinePost = SimplePost::findOrFail($id)->update(['star_approval'=>2]);

        return response()->json([
            'status' => 200,
            'message' => 'Success',
        ]);
    }

    public function star_add(Request $request)
    {
        //return $request->all();


        
        $validator = Validator::make($request->all(), [

            'title' => 'required',
            'description' => 'required',
            'type' => 'required',


        ],[
            'title.required' => 'Title Field Is Required',
            'description.required' => 'Description Field Is Required',
            'type.required' => "This  Field Is Required",

        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 402,
                'errors' => $validator->errors(),
            ]);
        }
        $post = new SimplePost();
        $post->title = $request->input('title');
        $post->created_by_id = auth('sanctum')->user()->id;
        $post->star_id = auth('sanctum')->user()->id;
        $post->category_id = auth('sanctum')->user()->category_id;
        $post->subcategory_id = auth('sanctum')->user()->sub_category_id;
        $post->description = $request->input('description');
        $post->fee = $request->input('fee') > 0  ? $request->input('fee') : 0;
        $post->video = $request->input('video');
        $post->type = $request->input('type');
        $post->star_approval = 1;


        if ($request->input('type') == 'free') {
            $post->status = 1;
        }

        if ($request->hasfile('image')) {
            $destination = $post->image;
            if (File::exists($destination)) {
                File::delete($destination);
            }
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = 'uploads/images/post/' . time() . '.' . $extension;

            Image::make($file)->resize(900, 400)->save($filename, 100);
            $post->image = $filename;
        }
        if ($request->hasFile('video')) {
    
            $file        = $request->file('video');
            $path        = 'uploads/videos/post';
            $file_name   = time() . rand('0000', '9999') . '.' . $file->getClientOriginalName();
            $file->move($path, $file_name);
            $post->video = $path . '/' . $file_name;
        }

        $post->save();

        if ($request->input('type') == 'free') {

            // Create New post //
            $npost = new Post();
            $npost->type = 'general';
            $npost->user_id = auth('sanctum')->user()->id;
            $npost->category_id = auth('sanctum')->user()->category_id;
            $npost->sub_category_id = auth('sanctum')->user()->sub_category_id;
            $npost->event_id = $post->id;
            $npost->title = $post->title;
            $npost->details = $post->description;
            $npost->status = 1;
            $npost->save();
        }

        return response()->json([
            'status' => 200,
            'message' => 'Post Added',
        ]);
    }
}
