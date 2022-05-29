<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Greeting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;

class StarGreetingController extends Controller
{
    public function greetings_star_status()
    {
        $greeting = Greeting::where('star_id', auth('sanctum')->user()->id)->first();
        if (isset($greeting)) {
            return response()->json([
                'status' => 200,
                'greeting' => $greeting,
                'action' => true,
            ]);
        } else {
            return response()->json([
                'status' => 200,
                'greeting' => [],
                'action' => false,
            ]);
        }
    }
    public function add_greetings(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'instruction' => 'required|min:10',
            'cost' => 'required|numeric||min:1',
            'user_required_day' => 'required|numeric||min:1',
            'banner' => 'required|mimes:jpeg,jpg,png,webp',
            'video' => 'required|mimes:mp4,mov,ogg',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'validation_errors' => $validator->errors(),
            ]);
        } else {
            $greeting = new Greeting();
            $greeting->created_by_id = auth('sanctum')->user()->id;
            $greeting->admin_id = auth('sanctum')->user()->parent_user;
            $greeting->category_id = auth('sanctum')->user()->category_id;

            $greeting->title = $request->title;
            $greeting->instruction = $request->instruction;
            $greeting->star_id = auth('sanctum')->user()->id;
            $greeting->cost = $request->cost;
            $greeting->user_required_day = $request->user_required_day;

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

            $greeting->save();
            return response()->json([
                'status' => 200,
                'greeting' => $greeting,
                'message' => 'Greetings Added Successfully !',
            ]);
        }
    }

    public function edit_greetings(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'instruction' => 'required|min:10',
            'cost' => 'required|numeric||min:1',
            'user_required_day' => 'required|numeric||min:1',
            'banner' => 'nullable|mimes:jpeg,jpg,png,webp',
            'video' => 'nullable|mimes:mp4,mov,ogg',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'validation_errors' => $validator->errors(),
            ]);
        } else {
            $greeting = Greeting::find($request->id);

            $greeting->admin_id = auth('sanctum')->user()->parent_user;
            $greeting->category_id = auth('sanctum')->user()->category_id;

            $greeting->title = $request->title;
            $greeting->instruction = $request->instruction;
            $greeting->cost = $request->cost;
            $greeting->user_required_day = $request->user_required_day;

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

            $greeting->save();
            return response()->json([
                'status' => 200,
                'greeting' => $greeting,
                'message' => 'Greetings Updated Successfully !',
            ]);
        }
    }
    public function approve_greeting($greeting_id)
    {
        $greeting = Greeting::find($greeting_id);
        $greeting->star_approve_status = 1;
        $greeting->save();
        return response()->json([
            'status' => 200,
            'greeting' => $greeting,
            'message' => 'Greetings Accepted Successfully !',
        ]);
    }
    public function decline_greeting($greeting_id)
    {
        $greeting = Greeting::find($greeting_id);
        $greeting->delete();
        return response()->json([
            'status' => 200,
            'greeting' => $greeting,
            'message' => 'Greetings Declined Successfully !',
        ]);
    }
}
