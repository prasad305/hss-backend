<?php

namespace App\Http\Controllers\API;

use App\Models\Greeting;
use App\Models\SuperStar;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Models\GreetingsRegistration;
use App\Models\Notification;
use App\Models\NotificationText;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;

class GreetingController extends Controller
{

    public function index()
    {

    }

    public function create()
    {

    }

    public function add(Request $request)
    {
        // return $request->all();
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
            $greeting->admin_id = auth('sanctum')->user()->id;
            $greeting->category_id = auth('sanctum')->user()->category_id;

            $greeting->title = $request->title;
            $greeting->instruction = $request->instruction;
            $greeting->star_id = auth('sanctum')->user()->star->id;
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

            $greeting->admin_id = auth('sanctum')->user()->id;
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


    public function forwardToManagerAdmin($greeting_id){
        $greeting = Greeting::find($greeting_id);
        $greeting->status = 1;
        $greeting->save();
        return response()->json([
            'status' => 200,
            'greeting' => $greeting,
            'message' => 'Greetings Forwarded Successfully !',
        ]);
    }

    public function show($id)
    {
        $greeting = Greeting::find($id);

        return response()->json([
            'status' => 200,
            'greeting' => $greeting,
            'greeting_id' => $greeting->id,
            'message' => 'Greetings Session Added',
        ]);
    }


    public function edit(Greeting $greeting)
    {
        //
    }


    public function update(Request $request, Greeting $greeting)
    {
        //
    }


    public function destroy(Greeting $greeting)
    {
        //
    }


    // public function view_star_greeting()
    // {
    //     $greeting = Greeting::where('star_id', auth('sanctum')->user()->id)->latest()->first();

    //     //$greeting = User::where('id',auth('sanctum')->user()->id)->first();

    //     return response()->json([
    //         'status' => 200,
    //         'greeting' => $greeting,
    //         'message' => 'Success',
    //     ]);
    // }


    public function greetingStatusCheck()
    {

        $greeting = Greeting::where('created_by_id', auth('sanctum')->user()->id)->first();

        return response()->json([
            'status' => 200,
            'greeting' => $greeting,
            'message' => 'Success',
        ]);
    }


    public function greetingsApprovedByStar()
    {
        $greeting = Greeting::where('star_id', auth('sanctum')->user()->id)->latest()->first();
        $greeting->star_approve_status = 1;
        $greeting->save();

        return response()->json([
            'status' => 200,
            'greeting' => $greeting,
            'message' => 'Approved Successfully',
        ]);
    }


    /***
     *  user greetings check status
     */
    public function greetingsCreateStatus($star_id)

    {
        $star = User::find($star_id);
        $greeting = Greeting::where([['star_id', $star_id], ['star_approve_status', '>', 0],['status', 2]])->first();

        if (isset($greeting)) {
            return response()->json([
                'status' => 200,
                'greeting' => $greeting,
                'star' => $star,
                'action' => true,
            ]);
        } else {
            return response()->json([
                'status' => 200,
                'greeting' => $greeting,
                'star' => $star,
                'action' => false,
            ]);
        }
    }

    /***
     * admin greetings check status
     */
    public function greetingsCreateStatusAdmin()
    {
        $greeting = Greeting::where('star_id', auth('sanctum')->user()->star->id)->first();
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
    /**
     * user greeting register information
     */
    public function greetingsRegisterListByGreetingsId()
    {
        $greeting = auth('sanctum')->user()->star->asStarGreeting;
        $register_list = GreetingsRegistration::where('greeting_id', $greeting->id)->get();

        return response()->json([
            'status' => 200,
            'list' => $register_list
        ]);
    }
    /**
     * user greetings reg with payment list
     */
    public function greetingsRegisterWithPaymentList($greetings_id)
    {
        return $register_list = GreetingsRegistration::where([['greeting_id', $greetings_id], ['status', 2]])->get();

        return response()->json([
            'status' => 200,
            'list' => $register_list
        ]);
    }

    /**
     * user register greetings delete
     */
    public function greetingsRegDelete($id)
    {
        $regGreetings = GreetingsRegistration::find($id);
        $regGreetings->delete();

        return response()->json([
            'status' => 200,
        ]);
    }
    /**
     * sent notification to user
     */
    // public function sentNotificationToUser(Request $request)
    // {
    //     return response()->json([
    //         'status' => 200,
    //         'list' => $request->all()
    //     ]);
    // }

    public function sentNotificationToUser(Request $request)
    {


        $users_arry = explode(',', $request->users);
        $greetins_arry = explode(',', $request->greetings_id);

        if (count($users_arry) > 0) {

            $text = new NotificationText();
            $text->text = $request->msg;
            $text->type = "Greetings";
            $text->save();

            foreach ($users_arry as $key => $req) {

                Notification::insert([
                    'notification_id' => $text->id,
                    'user_id' => $req,
                    'view_status' => 0,
                    'status' => 0,

                ]);
            }

            $register_greeting = GreetingsRegistration::whereIn('id', $greetins_arry)->update(['notification_at' => Carbon::now()]);
        }

        $register_list = GreetingsRegistration::where('greeting_id', $request->greeting_id)->get();


        return response()->json([
            'status' => 200,
            'list' =>  $register_list,
            'array' => count($users_arry)
        ]);
    }
}
