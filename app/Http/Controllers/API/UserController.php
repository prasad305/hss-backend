<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Auction;
use App\Models\Audition\Audition;
use App\Models\Audition\AuditionParticipant;
use App\Models\Audition\AuditionPayment;
use App\Models\Bidding;
use App\Models\FanGroupMessage;
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
use App\Models\ChoiceList;
use App\Models\InterestType;
use App\Models\Message;
use App\Models\PromoVideo;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use DateTimeZone;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\array_sort;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use PhpParser\Node\Expr\FuncCall;
use Intervention\Image\Facades\Image;

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

    public function total_notification_count()
    {
        $notification = Notification::where('user_id', auth('sanctum')->user()->id)->count();

        return response()->json([
            'status' => 200,
            'totalNotification' => $notification,
        ]);
    }


    public function all_post()
    {
        $id = auth('sanctum')->user()->id;
        $selectedCategory = ChoiceList::where('user_id', $id)->first();

        $selectedCategory = json_decode($selectedCategory->category);

        $post = Post::select("*")
            ->whereIn('category_id', $selectedCategory)
            ->latest()->get();

        // $post = Post::latest()->get();

        return response()->json([
            'status' => 200,
            'message' => 'Ok',
            'livechats' => $post,
        ]);
    }

    public function getAllLearningSession()
    {

        $post = Post::where('type', 'learningSession')->latest()->get();


        return response()->json([
            'status' => 200,
            'message' => 'Ok sonet',
            'post' => $post,
        ]);
    }

    public function singleLearnigSession($slug)
    {
        $learnigSession = LearningSession::where('slug', $slug)->first();

        return response()->json([
            'status' => 200,
            'message' => 'Ok',
            'learnigSession' => $learnigSession,
        ]);
    }


    public function LearningSessionRegistration(Request $request)
    {
        // New Learning Session Registration
        $learnigSession = new LearningSessionRegistration();
        $learnigSession->learning_session_id = $request->input('post_id');
        $learnigSession->user_id = auth('sanctum')->user()->id;
        $learnigSession->save();

        // New Activity Add For Learning Session Registrartion
        $activity = new Activity();
        $activity->user_id = auth('sanctum')->user()->id;
        $activity->event_id = $learnigSession->id;
        $activity->type = 'learningSession';
        $activity->save();

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
        $register = LearningSessionRegistration::where('user_id', auth('sanctum')->user()->id)->latest()->get();

        return response()->json([
            'status' => 200,
            'message' => 'Ok',
            'events' => $register,
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


    public function getAllLiveChatEventByStar($id)
    {
        $livechats = LiveChat::where('star_id', $id)->orderBy('id', 'DESC')->get();

        return response()->json([
            'status' => 200,
            'message' => 'Ok',
            'livechats' => $livechats,
        ]);
    }
    public function getAllPostWithForSingleStar($star_id)
    {
        $post = Post::where('user_id', $star_id)->latest()->get();

        return response()->json([
            'status' => 200,
            'message' => 'Ok',
            'livechats' => $post,
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

        // New Activity Add for Live Chat Register
        $activity = new Activity();
        $activity->user_id = auth('sanctum')->user()->id;
        $activity->event_id = $liveChatReg->id;
        $activity->type = 'liveChat';
        $activity->save();

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

        // New Activity Add for Greeting Register
        $activity = new Activity();
        $activity->user_id = auth('sanctum')->user()->id;
        $activity->event_id = $greetings->id;
        $activity->type = 'greeting';
        $activity->save();

        $single_greeting = GreetingsRegistration::where('user_id', auth('sanctum')->user()->id)->first();

        return response()->json([
            'status' => 200,
            'message' => "Your request time is pending,Wating for approval",
            'greeting' => $single_greeting,
            'greeting_registration' => $greetings,
        ]);
    }
    /**
     * greetings reggistaion update
     */
    public function greetingsRegistationUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            // 'date_b' => 'required',
            'phone' => 'required',
            'greetings_context' => 'required',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'validation_errors' => $validator->errors(),
            ]);
        } else {
            $greeting_reg = GreetingsRegistration::where('user_id', auth('sanctum')->user()->id)->orderBy('id', 'DESC')->first();
            $greeting_reg->name = $request->name;
            $greeting_reg->birth_date = $request->date_b;
            $greeting_reg->greeting_contex = $request->greetings_context;
            $greeting_reg->additional_message = $request->additional_message;
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
        // $post = Post::find($id);

        // $array = $post->react_provider ? json_decode($post->react_provider) : [];

        // if(!in_array( auth('sanctum')->user()->id,$array)){
        //     array_push($array,  auth('sanctum')->user()->id);
        //     $post->react_number = $post->react_number + 1;
        //     // $array[] = auth('sanctum')->user()->id;
        // }else{
        //     if (($key = array_search( auth('sanctum')->user()->id, $array))) {
        //         unset($array[$key]);
        //     }
        //     $post->react_number = $post->react_number - 1;
        // }
        // $post->react_provider = $array;
        // $post->save();

        // $react = React::where([['post_id', $id], ['user_id', auth('sanctum')->user()->id]])->first();

        // if ($react) {
        //     $react->delete();
        //     $post = Post::find($id);
        //     $post->react_number = $post->react_number - 1;
        //     $post->update();
        // } else {
        //     $react = new React();
        //     $react->user_id = auth('sanctum')->user()->id;
        //     $react->post_id = $id;
        //     $react->save();

        //     $post = Post::find($id);
        //     $post->react_number = $post->react_number + 1;
        //     $post->update();
        // }

        // $post->react_provider =$array;

        // $post->save();

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
        $notification = Notification::where('user_id', auth('sanctum')->user()->id)->latest()->get();
        $greeting_reg = GreetingsRegistration::where('user_id', auth('sanctum')->user()->id)->first();
        if ($greeting_reg)
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

    public function auctionProduct()
    {
        $product = Auction::with('star')->where('status', 1)->get();
        return response()->json([
            'status' => 200,
            'product' => $product
        ]);
    }
    public function starAuction($star_id)
    {

        $product = Auction::with('star', 'bidding', 'bidding.user')->where('star_id', $star_id)->where('status', 1)->latest()->get();
        return response()->json([
            'status' => 200,
            'product' => $product,
            'message' => 'okay',
        ]);
    }
    public function starAuctionProduct($product_id)
    {
        $product = Auction::with('star')->where('id', $product_id)->get();
        // $product = Auction::with(['star', 'bidding.user'])->where('id', $product_id)->get();
        return response()->json([
            'status' => 200,
            'product' => $product,
            'message' => 'okay',
        ]);
    }
    public function bidNow(Request $request)
    {
        // return response()->json($request->all());

        $user = User::find(auth()->user()->id);
        if (Hash::check($request->password, $user->password)) {
            $bidding = Bidding::create([

                'user_id' => $user->id,
                'auction_id' => $request->auction_id,
                'name' => $user->first_name,
                'amount' => $request->amount,
            ]);
            return response()->json([

                'status' => 200,
                'data' => $bidding,
            ]);
        } else {
            return response()->json([
                'status' => 201,
                'message' => 'Passowrd Not Match'
            ]);
        }
    }

    public function liveBidding($auction_id)
    {
        $bidding = Bidding::with('user')->orderBy('amount', 'DESC')->where('auction_id', $auction_id)->take(6)->get();
        return response()->json([
            'status' => 200,
            'bidding' => $bidding,
        ]);
    }
    public function bidHistory($auction_id)
    {
        $bidHistory = Bidding::orderBy('id', 'DESC')->where('user_id', auth()->user()->id)->where('auction_id', $auction_id)->get();
        return response()->json([
            'status' => 200,
            'bidHistory' => $bidHistory,
        ]);
    }
    public function topBidder($auction_id)
    {
        $topBidder = Bidding::orderBy('amount', 'DESC')->where('auction_id', $auction_id)->limit(4);
        return response()->json([
            'status' => 200,
            'topBidder' => $topBidder,
        ]);
    }
    //=============== Audition Logic By Srabon ===================

    public function getUpcomingAuditions()
    {
        $upcomingAuditions = Audition::orderBy('id', 'DESC')->with('judge.user')->where('status', 1)->latest()->get();

        return response()->json([
            'status' => 200,
            'upcomingAuditions' => $upcomingAuditions,
        ]);
    }
    public function participateAudition($id)
    {
        $participateAudition = Audition::with('judge.user')->where('id', $id)->get();
        $user = User::where('id', Auth()->user()->id)->get();
        $payment = AuditionPayment::where('user_id', Auth()->user()->id)->where('audition_id', $id)->get();
        return response()->json([
            'status' => 200,
            'participateAudition' => $participateAudition,
            'user' => $user,
            'payment' => $payment
        ]);
    }
    public function participantRegister(Request $request)
    {

        $user = User::find(auth()->user()->id);

        if (Hash::check($request->password, $user->password)) {


            if (AuditionParticipant::where('user_id', $user->id)->exists()) {
                return response()->json([
                    'status' => 201,
                    'message' => 'User already Registered'
                ]);
            } else {

                $participant = AuditionParticipant::create([

                    'audition_id' => $request->audition_id,
                    'user_id' => $user->id,
                    'accept_status' => 0,
                ]);
                return response()->json([

                    'status' => 200,
                    'data' => $participant,
                ]);
            }
        } else {
            return response()->json([
                'status' => 201,
                'message' => 'Passowrd Not Match'
            ]);
        }
    }

    public function auditionPayment(Request $request)
    {

        $user = User::find(auth()->user()->id);
        $payment = AuditionPayment::create([

            'audition_id' => $request->audition_id,
            'user_id' => $user->id,
            'card_holder_name' => $request->card_holder_name,
            'card_number' => $request->card_number,
            'status' => 1,
        ]);
        return response()->json([
            'status' => 200,
        ]);
    }
    public function videoUpload(Request $request)
    {

        // return $request->all();

        $audition = AuditionParticipant::where('audition_id', $request->audition_id)->where('user_id', Auth::user()->id)->first();



        if ($request->hasFile('video_url') && $audition->video_url == null) {


            $file        = $request->file('video_url');
            $path        = 'uploads/videos/auditions';
            $file_name   = time() . rand('0000', '9999') . '.' . $file->getClientOriginalName();
            $file->move($path, $file_name);
            $audition->video_url = $path . '/' . $file_name;
        }

        $audition->filter_status = 0;

        $audition->update();

        return response()->json([
            'status' => 200,
        ]);
    }
    public function videoDetails($id)
    {
        $participateAudition = Audition::with(['judge.user', 'participant' => function ($query) {
            return $query->whereNotIn('user_id', [auth()->user()->id])->whereNotNull('video_url')->get();
        }])->where('id', $id)->get();

        $ownVideo = AuditionParticipant::where('user_id', Auth::user()->id)->where('audition_id', $id)->first();

        return response()->json([
            'status' => 200,
            'participateAudition' => $participateAudition,
            'ownVideo' => $ownVideo,
        ]);
    }

    public function enrolledAuditions()
    {

        $enrolledAuditions = AuditionParticipant::with(['auditions'])->where('user_id', auth()->user()->id)->get();

        return response()->json([
            'status' => 200,
            'enrolledAuditions' => $enrolledAuditions,
        ]);
    }
    public function enrolledAuditionsPending()
    {

        $enrolledAuditionsPending = AuditionParticipant::with(['auditions'])->where('user_id', auth()->user()->id)->count();

        return response()->json([
            'status' => 200,
            'enrolledAuditionsPending' => $enrolledAuditionsPending,
        ]);
    }

    //message Controlling
    public function message(Request $request)
    {
        $message = new Message();

        $message->conversation_id = 1;
        $message->sender_id = $request->sender_id;
        $message->receiver_id = $request->receiver_id;
        $message->text = $request->text;
        $message->save();

        return response()->json([
            'status' => 200,
            'message' => $message,
        ]);
    }

    public function get_message($id)
    {
        $message = Message::where('conversation_id', 1)->get();

        return response()->json([
            'status' => 200,
            'message' => $message,
        ]);
    }

    //group message Controlling
    public function group_message(Request $request)
    {
        $message = new FanGroupMessage();

        $message->group_id = $request->group_id;
        $message->sender_id = $request->sender_id;
        $message->text = $request->text;
        $message->save();

        return response()->json([
            'status' => 200,
            'message' => $message,
        ]);
    }

    public function get_group_message($id)
    {
        $message = FanGroupMessage::where('group_id', $id)->get();

        return response()->json([
            'status' => 200,
            'message' => $message,
        ]);
    }

    public function getPromoVideo()
    {

        $promoVideos = PromoVideo::select('video_url')->where('status', 1)->latest()->get();
        return response()->json([
            'status' => 200,
            'promoVideos' => $promoVideos,
        ]);
    }

    // User Profile Update

    public function updateCover(Request $request, $id)
    {

        // return $request->all();

        $userInfo = User::findOrfail($id);

        if ($request->hasfile('cover_photo')) {

            $destination = $userInfo->cover_photo;
            if (File::exists($destination)) {
                File::delete($destination);
            }

            $file = $request->file('cover_photo');
            $extension = $file->getClientOriginalExtension();
            $filename = 'uploads/images/userPhotos/' . time() . '.' . $extension;

            Image::make($file)->resize(900, 400)->save($filename, 100);
            $userInfo->cover_photo = $filename;
        }
        $userInfo->update();

        return response()->json([
            'status' => 200,
            'message' => "Cover Photo updated"
        ]);
    }
    public function updateProfile(Request $request, $id)
    {

        // return $request->all();

        $userInfo = User::findOrfail($id);

        if ($request->hasfile('image')) {

            $destination = $userInfo->image;
            if (File::exists($destination)) {
                File::delete($destination);
            }

            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = 'uploads/images/userPhotos/' . time() . '.' . $extension;

            Image::make($file)->resize(900, 400)->save($filename, 100);
            $userInfo->image = $filename;
        }
        $userInfo->update();

        return response()->json([
            'status' => 200,
            'message' => "Image Photo updated"
        ]);
    }

    public function userPhotos()
    {

        $userPhotos = Activity::where('user_id', auth()->user()->id)->get();


        return response()->json([
            'status' => 200,
            'userPhotos' => $userPhotos
        ]);
    }
}
