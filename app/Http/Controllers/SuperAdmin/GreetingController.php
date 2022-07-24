<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Greeting;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\GreetingType;
use App\Models\Post;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Str;

class GreetingController extends Controller
{
    public function index()
    {
        $greetingtype = GreetingType::orderBy('id', 'DESC')->get();
        return view('SuperAdmin.greetingType.index')->with('greetingtype', $greetingtype);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('SuperAdmin.greetingType.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'greeting_type' => 'required|unique:greeting_types',
        ]);

        $greetingtype = new GreetingType();

        $greetingtype->greeting_type = $request->input('greeting_type');
        $greetingtype->status = 1;


        try {
            $greetingtype->save();
            return response()->json([
                'type' => 'success',
                'message' => 'Greeting Type created successfully',
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'type' => 'error',
                'message' => 'Opps somthing went wrong. ' . $exception->getMessage(),
            ]);
        }
    }

    public function edit($id)
    {
        $greetingtype = GreetingType::findOrfail($id);
        return view('SuperAdmin.greetingType.edit', compact('greetingtype'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'greeting_type' => 'required|unique:greeting_types,greeting_type,' . $id,
        ]);

        $greetingtype = GreetingType::findOrFail($id);
        $greetingtype->greeting_type = $request->input('greeting_type');

        try {
            $greetingtype->save();
            return response()->json([
                'success' => 'success',
                'message' => 'Greeting Type Updated Successfully'
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'type' => 'error',
                'message' => 'Opps somthing went wrong. ' . $exception->getMessage(),
            ]);
        }
    }

    public function activeNow($id)
    {
        $user = GreetingType::findOrFail($id);
        $user->status = 1;
        try {
            $user->save();
            return response()->json([
                'type' => 'success',
                'message' => 'Successfully Updated'
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'type' => 'error',
                'message' => $exception->getMessage()
            ]);
        }
    }

    public function inactiveNow($id)
    {
        $user = GreetingType::findOrFail($id);
        $user->status = 0;
        try {
            $user->save();
            return response()->json([
                'type' => 'success',
                'message' => 'Successfully Updated'
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'type' => 'error',
                'message' => $exception->getMessage()
            ]);
        }
    }

    // Greeting logic build by Srabon

    public function events()
    {
        $categories = Category::get();
        return view('SuperAdmin.Greeting.index', compact('categories'));
    }
    public function greetingList($categoryId)
    {
        $postList = Greeting::where('category_id', $categoryId)->latest()->get();
        return view('SuperAdmin.Greeting.GreetingList', compact('postList'));
    }
    public function greetingDetails($postId)
    {
        $greeting = Greeting::findOrFail($postId);
        return view('SuperAdmin.Greeting.details', compact('greeting'));
    }
    public function greetingEdit($id)
    {
        $greeting = Greeting::find($id);

        return view('SuperAdmin.Greeting.edit', compact('greeting'));
    }
    public function greetingUpdate(Request $request, $id)
    {

        $request->validate([
            'title' => 'required',
            'instruction' => 'required|min:5',
            'cost' => 'required',
            'minimum_required_day' => 'required',
            'banner' => 'nullable|mimes:png,jpg,jpeg',
            'video' => 'nullable',
        ]);

        $greeting = Greeting::findOrFail($id);
        $greeting->title = $request->title;
        $greeting->instruction = $request->instruction;
        $greeting->cost = $request->cost;
        $greeting->user_required_day = $request->minimum_required_day;

        if ($request->hasfile('banner')) {
            $destination = $greeting->banner;
            if (File::exists($destination)) {
                File::delete($destination);
            }
            $file = $request->file('banner');
            $extension = $file->getClientOriginalExtension();
            $filename = 'uploads/images/greeting/' . time() . '.' . $extension;
            Image::make($file)->resize(900, 400)->save($filename, 50);
            $greeting->banner = $filename;
        }

        if ($request->hasFile('video')) {
            if ($greeting->video != null && file_exists($greeting->video)) {
                unlink($greeting->video);
            }
            $file        = $request->file('video');
            $path        = 'uploads/videos/greeting';
            $file_name   = time() . rand('0000', '9999') . '.' . $file->getClientOriginalName();
            $file->move($path, $file_name);
            $greeting->video = $path . '/' . $file_name;
        }

        try {
            $greeting->save();
            if ($greeting) {
                return response()->json([
                    'success' => true,
                    'message' => 'Greeting Updated Successfully'
                ]);
            }
        } catch (\Exception $exception) {
            return response()->json([
                'type' => 'error',
                'message' => 'Opps somthing went wrong. ' . $exception->getMessage(),
            ]);
        }
    }
    public function greetingDestroy($id)
    {
        $post = Post::where('event_id', $id)->first();
        $postDelete = Greeting::findOrfail($id);
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
