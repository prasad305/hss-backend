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
        //
    }


    public function create()
    {
    }


    public function add(Request $request)
    {
        $greeting = new Greeting();

        $greeting->title = $request->input('title');
        $greeting->created_by_id = auth('sanctum')->user()->id;
        $greeting->star_id = $request->input('star_id');

        // $superStar = SuperStar::where('star_id', $request->input('star_id'))->first();
        // $greeting->admin_id = $superStar->admin_id;

        $greeting->description = $request->input('description');
        $greeting->cost = $request->input('cost');
        $greeting->registration_start_date = Carbon::parse($request->input('registration_start_date'));
        $greeting->registration_end_date = Carbon::parse($request->input('registration_end_date'));

        if ($request->hasfile('banner')) {
            $destination = $greeting->banner;
            if (File::exists($destination)) {
                File::delete($destination);
            }
            $file = $request->file('banner');
            $extension = $file->getClientOriginalExtension();
            $filename = 'uploads/images/greetings/' . time() . '.' . $extension;

            Image::make($file)->resize(879, 200)
                ->save($filename, 100);

            $greeting->banner = $filename;
        }

        $greeting->save();

        return response()->json([
            'status' => 200,
            'greeting_id' => $greeting->id,
            'message' => 'Greetings Session Added',
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


    public function view_star_greeting()
    {
        $greeting = Greeting::where('star_id', auth('sanctum')->user()->id)->latest()->first();

        //$greeting = User::where('id',auth('sanctum')->user()->id)->first();

        return response()->json([
            'status' => 200,
            'greeting' => $greeting,
            'message' => 'Success',
        ]);
    }


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
        $greeting = Greeting::where([['star_id', $star_id], ['star_approve_status', '>', 0]])->first();

        if (isset($greeting)) {
            return response()->json([
                'status' => 200,
                'greeting' => $greeting,
                'action' => true,
            ]);
        } else {

            return response()->json([
                'status' => 200,
                'greeting' => $greeting,
                'action' => false,
            ]);
        }
    }

    /***
     * admin greetings check status
     */
    public function greetingsCreateStatusAdmin()
    {
        $greeting = Greeting::where('created_by_id', auth('sanctum')->user()->id)->first();

        if (isset($greeting)) {
            return response()->json([
                'status' => 200,
                'greeting' => $greeting,
                'action' => true,
            ]);
        } else {

            return response()->json([
                'status' => 200,
                'greeting' => $greeting,
                'action' => false,
            ]);
        }
    }
    /**
     * user greeting register information
     */
    public function greetingsRegisterListByGreetingsId($greetings_id)
    {
        $register_list = GreetingsRegistration::where('greeting_id', $greetings_id)->get();

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
        $register_list = GreetingsRegistration::where([['greeting_id', $greetings_id], ['status', 2]])->get();

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
