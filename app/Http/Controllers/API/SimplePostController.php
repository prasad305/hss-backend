<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\LearningSession;
use Illuminate\Http\Request;
use App\Models\SimplePost;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManagerStatic as Image;
use Vonage\Client\Exception\Validation;
use Illuminate\Support\Str;
use App\Mail\PostNotification;
use Illuminate\Support\Facades\Mail;

class SimplePostController extends Controller
{

    //
    public function add_learning(Request $request)
    {

        // return $request->all();

        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:learning_sessions',
            'description' => 'required|min:2',
            'star_id' => 'required',
            'instruction' => 'required|min:2',
            'registration_start_date' => 'required',
            'registration_end_date' => 'required',
            'date' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'assignment' => 'required',
            'participant_number' => 'required',
            'room_id' => 'required',
            'image' => 'required|mimes:jpg,jpeg,png,gif,webp',
        ], [
            'title.unique' => 'This title already exist',
            'star_id.required' => 'Please Select One Star',
        ]);


        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->errors(),
            ]);
        } else {

            $post = new LearningSession();
            $post->title = $request->input('title');
            $post->slug = Str::slug($request->input('title'));
            $post->created_by_id = auth('sanctum')->user()->id;
            $post->star_id = $request->input('star_id');
            $post->description = $request->input('description');
            $post->instruction = $request->input('instruction');

            $post->registration_start_date = $request->input('registration_start_date');
            $post->registration_end_date = $request->input('registration_end_date');
            $post->date = $request->input('date');
            $post->start_time = $request->input('start_time');
            $post->end_time = $request->input('end_time');

            $post->assignment = $request->input('assignment');
            $post->fee = $request->input('fee');
            $post->participant_number = $request->input('participant_number');
            $post->room_id = $request->input('room_id');

            //$post->video = $request->input('video');
            //$post->type = $request->input('type');

            if ($request->hasfile('image')) {
                $destination = $post->banner;
                if (File::exists($destination)) {
                    File::delete($destination);
                }
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                $filename = 'uploads/images/learning_session/' . time() . '.' . $extension;

                Image::make($file)->resize(900, 400)->save($filename, 100);
                $post->banner = $filename;
            }

            $post->save();


            return response()->json([
                'status' => 200,
                'message' => 'Learning Session Added',
            ]);
        }
    }


    //
    public function add(Request $request)
    {

        $validator = Validator::make($request->all(), [

            'title' => 'required',
            'description' => 'required',
            'star_id' => 'required',
            'type' => 'required',
            'post_type' => 'required',


        ], [
            'title.required' => 'Title Field Is Required',
            'description.required' => 'Description Field Is Required',
            'star_id.required' => "Star Field Is Required",
            'type.required' => "This  Field Is Required",
            'post_type.required' => "This  Field Is Required",

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
        $post->admin_id = auth('sanctum')->user()->id;
        $post->category_id = auth('sanctum')->user()->category_id;
        $post->subcategory_id = auth('sanctum')->user()->sub_category_id;
        $post->star_id = $request->input('star_id');
        $post->description = $request->input('description');
        $post->fee = $request->input('fee') > 0  ? $request->input('fee') : 0;
        $post->video = $request->input('video');
        $post->type = $request->input('type');
        $post->post_type = $request->input('post_type');

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
        if ($request->hasFile('thumbnail')) {

            $file        = $request->file('thumbnail');
            $path        = 'uploads/videos/post';
            $file_name   = time() . rand('0000', '9999') . '.' . $file->getClientOriginalName();
            $file->move($path, $file_name);
            $post->thumbnail = $path . '/' . $file_name;
        }
        $post->save();

        $starInfo = getStarInfo($post->star_id);
        $senderInfo = getAdminInfo($post->admin_id);
        
        Mail::to('ismailbdcse@gmail.com')->send(new PostNotification($post,$senderInfo));
        // Mail::to($starInfo->email)->send(new PostNotification($post,$senderInfo));

        return response()->json([
            'status' => 200,
            'message' => 'Post Added',
            'post' => $post,
        ]);
    }
    public function simplePostUpdate(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [

            'title' => 'required',
            'description' => 'required|min:5',
            'star_id' => 'required',
            'type' => 'required',
            'post_type' => 'required',


        ], [
            'title.required' => 'Title Field Is Required',
            'description.required' => 'Description Field Is Required',
            'star_id.required' => "Star Field Is Required",
            'type.required' => "This  Field Is Required",
            'post_type.required' => "This  Field Is Required",

        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 402,
                'errors' => $validator->errors(),
            ]);
        }

        $post =  SimplePost::find($id);
        $post->title = $request->input('title');
        $post->created_by_id = auth('sanctum')->user()->id;
        $post->category_id = auth('sanctum')->user()->category_id;
        $post->subcategory_id = auth('sanctum')->user()->sub_category_id;
        $post->star_id = $request->input('star_id');
        $post->description = $request->input('description');
        $post->fee = $request->input('fee') > 0  ? $request->input('fee') : 0;
        $post->type = $request->input('type');
        $post->post_type = $request->input('post_type');

        if ($request->hasfile('image')) {
            if (File::exists($post->image)) {
                File::delete($post->image);
            }
            if (File::exists($post->video)) {
                File::delete($post->video);
            }
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = 'uploads/images/post/' . time() . '.' . $extension;

            Image::make($file)->resize(900, 400)->save($filename, 100);
            $post->image = $filename;
            $post->video = null;
        }
        if ($request->hasFile('video')) {
            if (File::exists($post->image)) {
                File::delete($post->image);
            }
            if (File::exists($post->video)) {
                File::delete($post->video);
            }
            $file        = $request->file('video');
            $path        = 'uploads/videos/post';
            $file_name   = time() . rand('0000', '9999') . '.' . $file->getClientOriginalName();
            $file->move($path, $file_name);
            $post->video = $path . '/' . $file_name;
            $post->image = null;
        }
        if ($request->hasFile('thumbnail')) {
            if (File::exists($post->image)) {
                File::delete($post->image);
            }
            if (File::exists($post->thumbnail)) {
                File::delete($post->thumbnail);
            }

            $file        = $request->file('thumbnail');
            $path        = 'uploads/videos/post';
            $file_name   = time() . rand('0000', '9999') . '.' . $file->getClientOriginalName();
            $file->move($path, $file_name);
            $post->thumbnail = $path . '/' . $file_name;
            $post->image = null;
        }
        $post->save();

        return response()->json([
            'status' => 200,
            'message' => 'Post Added',
        ]);
    }


    public function count()
    {
        $pending = SimplePost::where([['admin_id', auth('sanctum')->user()->id], ['status', 0], ['star_approval', '!=', 2]])->count();
        $approved = SimplePost::where([['admin_id', auth('sanctum')->user()->id], ['status', 1], ['star_approval', '!=', 2]])->count();

        return response()->json([
            'status' => 200,
            'pending' => $pending,
            'approved' => $approved,
            'message' => 'Success',
        ]);
    }

    public function all()
    {
        $post = SimplePost::where('admin_id', auth('sanctum')->user()->id)->latest()->get();
        $count = SimplePost::where('admin_id', auth('sanctum')->user()->id)->count();

        return response()->json([
            'status' => 200,
            'post' => $post,
            'count' => $count,
            'message' => 'Success',
        ]);
    }

    public function pending_list()
    {
        $post = SimplePost::where([['admin_id', auth('sanctum')->user()->id], ['status', 0], ['star_approval', '!=', 2]])->latest()->get();
        $count = SimplePost::where([['admin_id', auth('sanctum')->user()->id], ['status', 0], ['star_approval', '!=', 2]])->count();

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
        $post = SimplePost::where([['admin_id', auth('sanctum')->user()->id], ['status', 1]])->latest()->get();
        $count = SimplePost::where([['admin_id', auth('sanctum')->user()->id], ['status', 1]])->count();

        return response()->json([
            'status' => 200,
            'post' => $post,
            'count' => $count,
            'message' => 'Success',
        ]);
    }
    public function rejected_list()
    {
        $post = SimplePost::where([['admin_id', auth('sanctum')->user()->id], ['star_approval', 2]])->latest()->get();
        $count = SimplePost::where([['admin_id', auth('sanctum')->user()->id], ['star_approval', 2]])->count();

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

    public function star_all_mobile()
    {
        $pending = SimplePost::where([['star_id', auth('sanctum')->user()->id], ['star_approval', 0]])->latest()->get();
        $approved = SimplePost::where([['star_id', auth('sanctum')->user()->id], ['star_approval', 1]])->latest()->get();
        $rejected = SimplePost::where([['star_id', auth('sanctum')->user()->id], ['star_approval', 2]])->latest()->get();
        $all = SimplePost::where([['star_id', auth('sanctum')->user()->id]])->latest()->get();

        return response()->json([
            'status' => 200,
            'pending' => $pending,
            'approved' => $approved,
            'rejected' => $rejected,
            'all' => $all,
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
                $post->star_id = json_decode($spost->star_id);
                $post->event_id = $spost->id;
                $post->category_id = auth('sanctum')->user()->category_id;
                $post->sub_category_id = auth('sanctum')->user()->sub_category_id;
                $post->title = $spost->title;
                $post->status = 1;
                $post->details = $spost->description;
                $post->save();
            } else {
                $spost->status = 0;
                $spost->update();

                //Remove post //
                $post = Post::where('event_id', $id)->first();
                $post->delete();
            }
        }
        $managerInfo = getManagerInfo(auth('sanctum')->user()->category_id);
        $senderInfo = getStarInfo(auth('sanctum')->user()->id);
        Mail::to('www.ismailcse@gmail.com')->send(new PostNotification($spost,$senderInfo));
        // Mail::to($managerInfo->email)->send(new PostNotification($spost,$senderInfo));

        return response()->json([
            'status' => 200,
            'message' => 'Success',
        ]);
    }

    public function decline_post($id)
    {
        $declinePost = SimplePost::findOrFail($id)->update(['star_approval' => 2]);

        return response()->json([
            'status' => 200,
            'message' => 'Success',
        ]);
    }

    public function star_add_mobile(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'title' => 'required',
            'description' => 'required',
            'type' => 'required',


        ], [
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
        $post->title = $request->title;
        $post->created_by_id = auth('sanctum')->user()->id;
        $post->admin_id = auth('sanctum')->user()->parent_user;
        $post->star_id = auth('sanctum')->user()->id;
        $post->category_id = auth('sanctum')->user()->category_id;
        $post->subcategory_id = auth('sanctum')->user()->sub_category_id;
        $post->description = $request->description;
        $post->fee = $request->fee > 0  ? $request->fee : 0;
        $post->type = $request->type;
        $post->star_approval = 1;
        if ($request->type == 'free') {
            $post->status = 1;
        }

        if ($request->image != null) {
            try {
                $originalExtension = str_ireplace("image/", "", $request->image['type']);

                $folder_path       = 'uploads/images/post/';

                $image_new_name    = Str::random(20) . '-' . now()->timestamp . '.' . $originalExtension;
                $decodedBase64 = $request->image['data'];

                Image::make($decodedBase64)->save($folder_path . $image_new_name);
                $location = $folder_path . $image_new_name;
                $post->image = $location;
            } catch (\Exception $exception) {
                return response()->json([
                    "error" => $exception->getMessage(),
                    "status" => "from image",
                ]);
            }
        }
        if ($request->video != null) {
            try {
                $originalExtension = str_ireplace("image/", "", $request->video['type']);

                $folder_path       = 'uploads/videos/post/';

                $image_new_name    = Str::random(20) . '-' . now()->timestamp . '.' . $originalExtension;
                $decodedBase64 = $request->video['data'];

                Image::make($decodedBase64)->save($folder_path . $image_new_name);
                $location = $folder_path . $image_new_name;
                $post->video = $location;
            } catch (\Exception $exception) {
                return response()->json([
                    "error" => $exception->getMessage(),
                    "status" => "from video",
                ]);
            }
        }
        if ($request->thumbnail != null) {
            try {
                $originalExtension = str_ireplace("image/", "", $request->thumbnail['type']);

                $folder_path       = 'uploads/images/post/';

                $image_new_name    = Str::random(20) . '-' . now()->timestamp . '.' . $originalExtension;
                $decodedBase64 = $request->thumbnail['data'];

                Image::make($decodedBase64)->save($folder_path . $image_new_name);
                $location = $folder_path . $image_new_name;
                $post->thumbnail = $location;
            } catch (\Exception $exception) {
                return response()->json([
                    "error" => $exception->getMessage(),
                    "status" => "from thumbnail",
                ]);
            }
        }



        $post->save();

        if ($request->input('type') == 'free') {

            // Create New post //
            $npost = new Post();
            $npost->type = 'general';
            $npost->user_id = auth('sanctum')->user()->id;
            $npost->star_id = auth('sanctum')->user()->id;
            $npost->category_id = auth('sanctum')->user()->category_id;
            $npost->sub_category_id = auth('sanctum')->user()->sub_category_id;
            $npost->event_id = $post->id;
            $npost->title = $post->title;
            $npost->status = 1;
            $npost->details = $post->description;
            $npost->save();
        }
        return response()->json([
            'status' => 200,
            'message' => 'Post Added',
        ]);
    }

    public function star_add(Request $request)
    {

        $validator = Validator::make($request->all(), [

            'title' => 'required',
            'description' => 'required',
            'type' => 'required',
            'post_type' => 'required',


        ], [
            'title.required' => 'Title Field Is Required',
            'description.required' => 'Description Field Is Required',
            'post_type.required' => "This  Field Is Required",
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
        $post->admin_id = auth('sanctum')->user()->parent_user;
        $post->star_id = auth('sanctum')->user()->id;
        $post->category_id = auth('sanctum')->user()->category_id;
        $post->subcategory_id = auth('sanctum')->user()->sub_category_id;
        $post->description = $request->input('description');
        $post->fee = $request->input('fee') > 0  ? $request->input('fee') : 0;
        $post->type = $request->input('type');
        $post->post_type = $request->input('post_type');
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
        if ($request->hasFile('thumbnail')) {

            $file        = $request->file('thumbnail');
            $path        = 'uploads/videos/post';
            $file_name   = time() . rand('0000', '9999') . '.' . $file->getClientOriginalName();
            $file->move($path, $file_name);
            $post->thumbnail = $path . '/' . $file_name;
        }

        $post->save();

        if ($request->input('type') == 'free') {

            // Create New post //
            $npost = new Post();
            $npost->type = 'general';
            $npost->user_id = auth('sanctum')->user()->id;
            $npost->star_id = auth('sanctum')->user()->id;
            $npost->category_id = auth('sanctum')->user()->category_id;
            $npost->sub_category_id = auth('sanctum')->user()->sub_category_id;
            $npost->event_id = $post->id;
            $npost->title = $post->title;
            $npost->status = 1;
            $npost->details = $post->description;
            $npost->save();
        }

        $adminInfo = getAdminInfo($post->admin_id);
        $senderInfo = getStarInfo($post->star_id);
        $managerInfo = getManagerInfo(auth('sanctum')->user()->category_id);
        

        
        Mail::to('ismailbdcse@gmail.com')->send(new PostNotification($post,$senderInfo));
        Mail::to('www.ismailcse@gmail.com')->send(new PostNotification($post,$senderInfo));
        // Mail::to($adminInfo->email)->send(new PostNotification($post,$senderInfo));
        // Mail::to($managerInfo->email)->send(new PostNotification($post,$senderInfo));


        return response()->json([
            'status' => 200,
            'type' => $post->type,
            'message' => 'Post Added',
        ]);
    }
    public function star_post_update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [

            'title' => 'required',
            'description' => 'required|min:5',
            'type' => 'required',
            'post_type' => 'required',


        ], [
            'title.required' => 'Title Field Is Required',
            'description.required' => 'Description Field Is Required',
            'type.required' => "This  Field Is Required",
            'post_type.required' => "This  Field Is Required",

        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 402,
                'errors' => $validator->errors(),
            ]);
        }

        $post =  SimplePost::find($id);
        $post->title = $request->input('title');
        $post->category_id = auth('sanctum')->user()->category_id;
        $post->subcategory_id = auth('sanctum')->user()->sub_category_id;
        $post->star_id = auth('sanctum')->user()->id;
        $post->description = $request->input('description');
        $post->fee = $request->input('fee') > 0  ? $request->input('fee') : 0;
        $post->type = $request->input('type');
        $post->post_type = $request->input('post_type');

        if ($request->hasfile('image')) {
            if (File::exists($post->image)) {
                File::delete($post->image);
            }
            if (File::exists($post->video)) {
                File::delete($post->video);
            }
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = 'uploads/images/post/' . time() . '.' . $extension;

            Image::make($file)->resize(900, 400)->save($filename, 100);
            $post->image = $filename;
            $post->video = null;
        }
        if ($request->hasFile('video')) {
            if (File::exists($post->image)) {
                File::delete($post->image);
            }
            if (File::exists($post->video)) {
                File::delete($post->video);
            }
            $file        = $request->file('video');
            $path        = 'uploads/videos/post';
            $file_name   = time() . rand('0000', '9999') . '.' . $file->getClientOriginalName();
            $file->move($path, $file_name);
            $post->video = $path . '/' . $file_name;
            $post->image = null;
        }
        if ($request->hasFile('thumbnail')) {
            if (File::exists($post->image)) {
                File::delete($post->image);
            }
            if (File::exists($post->thumbnail)) {
                File::delete($post->thumbnail);
            }
            $file        = $request->file('video');
            $path        = 'uploads/videos/post';
            $file_name   = time() . rand('0000', '9999') . '.' . $file->getClientOriginalName();
            $file->move($path, $file_name);
            $post->thumbnail = $path . '/' . $file_name;
            $post->image = null;
        }
        $post->save();

        return response()->json([
            'status' => 200,
            'message' => 'Post Updated',
        ]);
    }
}
