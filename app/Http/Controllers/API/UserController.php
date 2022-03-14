<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Auction;
use App\Models\Greeting;
use App\Models\GreetingsRegistration;
use App\Models\LearningSession;
use App\Models\LearningSessionRegistration;
use App\Models\LiveChat;
use App\Models\LiveChatRegistration;
use App\Models\MeetupEvent;
use App\Models\MeetupEventRegistration;
use App\Models\Notification;
use App\Models\Post;
use App\Models\React;
use App\Models\SimplePost;
use App\Models\InterestType;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use DateTimeZone;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\array_sort;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function star_info($id)
    {
        $star = User::find($id);


        return response()->json([
            'status' => 200,
            'message' => 'Ok',
            'star' => $star,
        ]);
    }


    public function getAllLiveChatEventWith()
    {
        // $livechats = LiveChat::with('star')->where('status',1)->latest()->get();
        // $meetupEvents = MeetupEvent::with('star')->where('status',1)->latest()->get();
        // $query = ($livechats->merge($meetupEvents));

        $post = Post::latest()->get();

        return response()->json([
            'status' => 200,
            'message' => 'Ok',
            'livechats' => $post,
        ]);
    }

    public function getAllLearningSession()
    {

        $post = Post::where('type','learningSession')->latest()->get();

        return response()->json([
            'status' => 200,
            'message' => 'Ok sonet',
            'post' => $post,
        ]);
    }

    public function singleLearnigSession($slug)
    {
        $learnigSession = LearningSession::where('slug',$slug)->first();

        return response()->json([
            'status' => 200,
            'message' => 'Ok',
            'learnigSession' => $learnigSession,
        ]);
    }



    public function LearningSessionReg(Request $request)
    {
        $learnigSession = new LearningSessionRegistration();
        $learnigSession->learning_session_id = $request->input('post_id');
        $learnigSession->user_id = auth('sanctum')->user()->id;
        $learnigSession->save();


        return response()->json([
            'status' => 200,
            'message' => 'Registration Successful',
            'learnigSession' => $learnigSession,
        ]);
    }

    public function star_photo($id)
    {

        $post = SimplePost::where([['status', 1], ['star_id', $id]])->latest()->get();

        return response()->json([
            'status' => 200,
            'message' => 'Ok',
            'post' => $post,
        ]);
    }
    public function star_video($id)
    {

        $post = SimplePost::where([['status', 1], ['star_id', $id]])->latest()->get();

        return response()->json([
            'status' => 200,
            'message' => 'Ok',
            'post' => $post,
        ]);
    }


    public function getStarPost($id)
    {
        $post = Post::where('user_id', $id)->latest()->get();

        return response()->json([
            'status' => 200,
            'message' => 'Ok',
            'livechats' => $post,
        ]);
    }

    public function interestType()
    {
        $interestTypes = InterestType::where('status', 1)->latest()->get();

        return response()->json([
            'status' => 200,
            'message' => 'Ok',
            'allinteresttypes' => $interestTypes,
        ]);
    }

    public function registeredLivechat()
    {

        $post = LiveChatRegistration::where('user_id', auth('sanctum')->user()->id)->latest()->get();

        return response()->json([
            'status' => 200,
            'message' => 'Ok',
            'events' => $post,
        ]);
    }

    public function registeredLearningSession()
    {

        $post = LearningSessionRegistration::where('user_id', auth('sanctum')->user()->id)->latest()->get();

        return response()->json([
            'status' => 200,
            'message' => 'Ok',
            'events' => $post,
        ]);
    }

    public function registeredMeetup()
    {

        $post = MeetupEventRegistration::where('user_id', auth('sanctum')->user()->id)->latest()->get();

        return response()->json([
            'status' => 200,
            'message' => 'Ok',
            'events' => $post,
        ]);
    }


    public function getAllLiveChatEvent()
    {
        $livechats = LiveChat::orderBy('id', 'DESC')->get();


        return response()->json([
            'status' => 200,
            'message' => 'Ok',
            'livechats' => $livechats,
        ]);
    }


    public function getSingleLiveChatEvent($id)
    {
        $livechat = LiveChat::find($id);


        return response()->json([
            'status' => 200,
            'message' => 'Ok',
            'livechat' => $livechat,
        ]);
    }

    public function sinlgeLiveChat($id)
    {
        $liveChat = Livechat::find($id);
        $starInfo = User::find($liveChat->star_id);

        return response()->json([
            'status' => 200,
            'message' => 'Ok',
            'liveChat' => $liveChat,
            'starInfo' =>  $starInfo

        ]);
    }

    public function getLiveChatTiemSlot($minute, $id)
    {
        $livechat = LiveChat::find($id);
        // $availableTime = $livechat

        $start_date = new DateTime($livechat->start_time, new DateTimeZone('Pacific/Nauru'));
        $end_date = new DateTime($livechat->end_time, new DateTimeZone('Pacific/Nauru'));
        $interval = $start_date->diff($end_date);
        $hours   = $interval->format('%h');
        $minutes = $interval->format('%i');

        $available_minutes = ($hours * 60 + $minutes);
        $taken_minute = $livechat->slot_counter;
        $available_time = $available_minutes - $taken_minute;

        if ($available_time >= $minute) {
            $msg = "slot available";
            $available_status = true;
        } else {
            $msg = "slot not available";
            $available_status = false;
        }


        return response()->json([
            'status' => 200,
            'available' => $available_status,
            'message' =>  $msg,

        ]);
    }
    public function liveChatRigister(Request $request)
    {
        // return $request->all();
        $liveChat = LiveChat::find($request->event_id);
        $liveChat->slot_counter = $liveChat->slot_counter + $request->minute;

        $start_time = Carbon::parse($liveChat->start_time)->addMinutes($liveChat->slot_counter);
        $end_time = Carbon::parse($start_time)->addMinutes($request->minute);

        $liveChatReg = new LiveChatRegistration();
        $liveChatReg->live_chat_id =  $request->event_id;
        $liveChatReg->user_id =  auth('sanctum')->user()->id;
        $liveChatReg->payment_method =  null;
        $liveChatReg->payment_status =  1;
        $liveChatReg->payment_date =  Carbon::now();
        $liveChatReg->amount =  $liveChat->fee * $request->minute;
        $liveChatReg->card_holder_name =  null;
        $liveChatReg->account_no =  null;
        $liveChatReg->live_chat_start_time = $start_time;
        $liveChatReg->live_chat_end_time =   $end_time;
        $liveChatReg->live_chat_date =  $liveChat->date;
        $liveChatReg->video =  null;
        $liveChatReg->comment_count =  null;
        $liveChatReg->publish_status =  1;
        $liveChatReg->save();

        $liveChat->save();

        return response()->json([
            'status' => 200,
            'message' => 'Registation done successfully',
        ]);
    }



    /**
     * greetings registations take time
     */
    public function greetingsRegistation(Request $request)
    {

        $greetings = new GreetingsRegistration();


        $greetings->request_time = Carbon::parse($request->input('time'));
        $greetings->user_id = auth('sanctum')->user()->id;
        $greetings->greeting_id = $request->greetings_id;
        $greetings->save();




        $single_greeting = GreetingsRegistration::where('user_id', auth('sanctum')->user()->id)->first();


        return response()->json([
            'status' => 200,
            'message' => "Your request time is pending,Wating for approval",
            'greeting' => $single_greeting
        ]);
    }
    /**
     * greetings reggistaion update
     */
    public function greetingsRegistationUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'date_b' => 'required',
            'phone' => 'required',
            'greetings_context' => 'required',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'validation_errors' => $validator->errors(),
            ]);
        } else {
            $greeting_reg = GreetingsRegistration::where('user_id', auth('sanctum')->user()->id)->first();
            $greeting_reg->name = $request->name;
            $greeting_reg->birth_date = $request->date_b;
            $greeting_reg->greeting_contex = $request->greetings_context;
            $greeting_reg->phone = $request->phone;
            $greeting_reg->password = Hash::make($request->password);
            $greeting_reg->status = 2;
            $greeting_reg->save();

            $notification = Notification::find($request->notification_id);
            $notification->view_status = 1;
            $notification->save();

            return response()->json([
                'status' => 200,
                'data' => $request->notification_id

            ]);
        }
    }

    /**
     * public function greetings stastus
     */
    public function greetingStatus()
    {
        $single_greeting = GreetingsRegistration::where('user_id', auth('sanctum')->user()->id)->first();

        if (isset($single_greeting)) {
            return response()->json([
                'status' => 200,
                'action' => true,
                'greeting' => $single_greeting,


            ]);
        } else {
            return response()->json([
                'status' => 200,
                'action' => false,
                'greeting' => $single_greeting,


            ]);
        }
    }

    /**
     * user greetings Activety check
     */
    public function starGreetingsStatus($star_id)
    {
        $single_greeting = Greeting::where('star_id', $star_id);
        if (isset($single_greeting)) {

            return response()->json([
                'status' => 200,
                'action' => true
            ]);
        } else {
            return response()->json([
                'status' => 200,
                'action' => false
            ]);
        }
    }


    public function submit_react($id)
    {
        $react = React::where([['post_id', $id], ['user_id', auth('sanctum')->user()->id]])->first();


        if ($react) {
            $react->delete();

            $post = Post::find($id);
            $post->react_number = $post->react_number - 1;
            $post->update();
        } else {
            $react = new React();
            $react->user_id = auth('sanctum')->user()->id;
            $react->post_id = $id;
            $react->save();

            $post = Post::find($id);
            $post->react_number = $post->react_number + 1;
            $post->update();
        }

        return response()->json([
            'status' => 200,
            'message' => 'Ok',
        ]);
    }

    public function check_react($id)
    {
        $reacted = React::where([['post_id', $id], ['user_id', auth('sanctum')->user()->id]])->first();

        //$reacted = React::where('post_id',$id)->first();+
        return response()->json([
            'status' => 200,
            'message' => 'Ok',
            'reacted' => $reacted
        ]);
    }

    /**
     * user notification check
     */
    public function checkUserNotifiaction()
    {
        $notification = Notification::where('user_id', auth('sanctum')->user()->id)->get();
        $greeting_reg = GreetingsRegistration::where('user_id', auth('sanctum')->user()->id)->first();
        if($greeting_reg)
        $greeting_info = Greeting::find($greeting_reg->greeting_id);
        else
        $greeting_info = '';

        return response()->json([
            'status' => 200,
            'user_id' => auth('sanctum')->user()->id,
            'notifiction' => $notification,
            'greeting_info' => $greeting_info,

        ]);
    }

    public function auctionProduct(){
        $product = Auction::with('star')->where('status',1)->get();
        return response()->json([
            'status' => 200,
            'product' => $product
        ]);
    }
}
