<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Acquired_app;
use App\Models\Activity;
use App\Models\Auction;
use App\Models\Audition\Audition;
use App\Models\Audition\AuditionParticipant;
use App\Models\Audition\AuditionPayment;
use App\Models\Audition\AuditionRoundRule;
use App\Models\Audition\AuditionUploadVideo;
use App\Models\Bidding;
use App\Models\FanGroupMessage;
use App\Models\Greeting;
use App\Models\GreetingsRegistration;
use App\Models\LearningSession;
use App\Models\SubCategory;
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
use App\Models\LearningSessionAssignment;
use App\Models\LearningSessionEvaluation;
use App\Models\LiveChatRoom;
use App\Models\Message;
use App\Models\PromoVideo;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use DateTimeZone;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\ImageManagerStatic as Image;



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

        $selectedCat = json_decode($selectedCategory->category);
        $selectedSubCat = json_decode($selectedCategory->subcategory);
        $selectedSubSubCat = json_decode($selectedCategory->star_id);

        $cat_post = Post::select("*")
            ->whereIn('category_id', $selectedCat)
            ->latest()->get();

        if (isset($sub_cat_post)) {
            $sub_cat_post = Post::select("*")
                ->whereIn('sub_category_id', $selectedSubCat)
                ->latest()->get();
        } else {
            $sub_cat_post = [];
        }

        if (isset($sub_sub_cat_post)) {
            $sub_sub_cat_post = Post::select("*")
                ->whereIn('user_id', $selectedSubSubCat)
                ->latest()->get();
        } else {
            $sub_sub_cat_post = [];
        }

        $post = $cat_post->concat($sub_cat_post)->concat($sub_sub_cat_post);

        return response()->json([
            'status' => 200,
            'message' => 'Ok',
            'livechats' => $post,
        ]);
    }

    public function single_type_post($type)
    {
        $id = auth('sanctum')->user()->id;

        $selectedCategory = ChoiceList::where('user_id', $id)->first();
        $selectedCat = json_decode($selectedCategory->category);
        $selectedSubCat = json_decode($selectedCategory->subcategory);
        $selectedSubSubCat = json_decode($selectedCategory->star_id);

        $cat_post = Post::select("*")
            ->whereIn('category_id', $selectedCat)
            ->where('type', $type)
            ->latest()->get();

        if (isset($sub_cat_post)) {
            $sub_cat_post = Post::select("*")
                ->whereIn('sub_category_id', $selectedSubCat)
                ->latest()->get();
        } else {
            $sub_cat_post = [];
        }

        if (isset($sub_sub_cat_post)) {
            $sub_sub_cat_post = Post::select("*")
                ->whereIn('user_id', $selectedSubSubCat)
                ->latest()->get();
        } else {
            $sub_sub_cat_post = [];
        }

        $post = $cat_post->concat($sub_cat_post)->concat($sub_sub_cat_post);

        return response()->json([
            'status' => 200,
            'message' => 'Ok',
            'post' => $post,
        ]);
    }


    public function allSubcategoryList($catId)
    {

        $allSubCat = SubCategory::where('category_id', $catId)
            ->latest()
            ->get();

        // $someSubCat = SubCategory::where('category_id', $catId)
        //                     ->whereIn('id', subcategory)
        //                     ->latest()
        //                     ->get();
        // return $allSubCat;
        return response()->json([
            'status' => 200,
            'message' => 'Ok',
            'allSubCat' => $allSubCat,
            // 'someSubCat' => $someSubCat,
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
        $activity->event_id = $request->input('post_id');
        $activity->event_registration_id =  $learnigSession->id;
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

    public function liveChatDetails($slug)
    {
        $event = LiveChat::where('slug', $slug)->first();

        return response()->json([
            'status' => 200,
            'event' => $event,
        ]);
    }

    public function meetupDetails($slug)
    {
        $event = MeetupEvent::where('slug', $slug)->first();

        return response()->json([
            'status' => 200,
            'event' => $event,
        ]);
    }


    public function getLiveChatTiemSlot($minute, $id)
    {
        $livechat = LiveChat::find($id);

        $user_start_time = $livechat->available_start_time ? $livechat->available_start_time : $livechat->start_time;
        $user_end_time = Carbon::parse($user_start_time)->addMinutes($minute)->format('H:i:s');

        $start_date = new DateTime($user_start_time);
        $end_date = new DateTime($livechat->end_time);

        $interval = $start_date->diff($end_date);
        $hours   = $interval->format('%h');
        $minutes = $interval->format('%i');

        $available_minutes = ($hours * 60 + $minutes);
        // $available_time = $available_minutes - $taken_minute;

        if ($available_minutes >= $minute) {
            $msg = "Congratulation! Slot is available for You";
            $available_status = true;
        } else {
            $msg = "Sorry! Slot is not available";
            $available_status = false;
        }


        return response()->json([
            'status' => 200,
            'start_time' => $user_start_time,
            'end_time' => $user_end_time,
            'available' => $available_status,
            'message' =>  $msg,
        ]);
    }


    public function liveChatRigister(Request $request)
    {

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
        $activity->event_id = $request->event_id;
        $activity->event_registration_id = $liveChatReg->id;
        $activity->type = 'liveChat';
        $activity->save();

        //live chat room create
        $liveChatRoom = new LiveChatRoom();
        $liveChatRoom->live_chat_id = $request->event_id;
        $liveChatRoom->star_id = $request->star_id;
        $liveChatRoom->user_id = auth('sanctum')->user()->id;
        $liveChatRoom->room_id = $request->room_id;
        $liveChatRoom->status = 0;
        $liveChatRoom->save();


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
        $greetings->purpose = $request->purpose;
        $greetings->user_id = auth('sanctum')->user()->id;
        $greetings->greeting_id = $request->greetings_id;
        $greetings->save();

        // New Activity Add for Greeting Register
        // $activity = new Activity();
        // $activity->user_id = auth('sanctum')->user()->id;
        // $activity->event_id = $request->greetings_id;
        // $activity->event_registration_id = $greetings->id;
        // $activity->type = 'greeting';
        // $activity->save();

        return response()->json([
            'status' => 200,
            'message' => "Your request time is pending,Wating for approval",
            'greeting' => $greetings,
        ]);
    }
    /**
     * greetings reggistaion update
     */
    public function greetingsRegistationUpdate(Request $request)
    {
        // return $request->all();
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:2',
            'greeting_context' => 'required|min:2',
            'additional_message' => 'nullable|min:2',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'validation_errors' => $validator->errors(),
            ]);
        } else {
            $greeting_reg = GreetingsRegistration::find($request->greeting_registration_id);
            $greeting_reg->name = $request->name;
            $greeting_reg->greeting_context = $request->greeting_context;
            $greeting_reg->additional_message = $request->additional_message;
            $greeting_reg->status = 1;
            $greeting_reg->save();

            return response()->json([
                'status' => 200,
                'greeting' => $greeting_reg->greeting,
                'greetingsRegistration' => $greeting_reg,
            ]);
        }
    }
    public function greetingInfoToRegistration($greeting_id)
    {
        $greeting = Greeting::find($greeting_id);
        $greetingsRegistration =  GreetingsRegistration::where([['user_id', auth('sanctum')->user()->id], ['greeting_id', $greeting_id], ['notification_at', '!=', null]])->orderBy('id', 'DESC')->first();



        return response()->json([
            'status' => 200,
            'greeting' => $greeting,
            'greetingsRegistration' => $greetingsRegistration,
        ]);
    }

    /**
     * public function greetings stastus
     */
    public function greetingStatus($star_id)
    {
        $single_greeting = GreetingsRegistration::whereHas('greeting', function ($q) use ($star_id) {
            $q->where([['star_id', $star_id]]);
        })->where([['user_id', auth('sanctum')->user()->id], ['notification_at', null]])->orderBy('id', 'DESC')->first();

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
        $notification = Notification::where([['user_id', auth('sanctum')->user()->id], ['view_status', 0]])->orderBy('id', 'ASC')->get();
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

        $id = auth('sanctum')->user()->id;
        $selectedCategory = ChoiceList::where('user_id', $id)->first();

        $selectedCat = json_decode($selectedCategory->category);
        $selectedSubCat = json_decode($selectedCategory->subcategory);
        $selectedSubSubCat = json_decode($selectedCategory->star_id);

        $cat_post = Auction::with('star')->orderBy('id', 'DESC')->where('status', 1)
            ->whereIn('category_id', $selectedCat)
            ->latest()->get();

        if (isset($sub_cat_post)) {
            $sub_cat_post = Auction::with('star')->orderBy('id', 'DESC')->where('status', 1)
                ->whereIn('sub_category_id', $selectedSubCat)
                ->latest()->get();
        } else {
            $sub_cat_post = [];
        }

        if (isset($sub_sub_cat_post)) {
            $sub_sub_cat_post = Auction::with('star')->orderBy('id', 'DESC')->where('status', 1)
                ->whereIn('user_id', $selectedSubSubCat)
                ->latest()->get();
        } else {
            $sub_sub_cat_post = [];
        }

        $product = $cat_post->concat($sub_cat_post)->concat($sub_sub_cat_post);

        return response()->json([
            'status' => 200,
            'product' => $product
        ]);


        // $product = Auction::with('star')->orderBy('id','DESC')->where('status', 1)->get();
        // return response()->json([
        //     'status' => 200,
        //     'product' => $product
        // ]);

    }
    public function  auctionSingleProduct($id)
    {
        $userInfo = user::findOrFail(auth()->user()->id);
        $auctionInfo = Auction::findOrFail($id);
        return response()->json([
            'status' => 200,
            'auctionInfo' => $auctionInfo,
            'userInfo' => $userInfo
        ]);
    }

    public function starAuction($star_id)
    {

        $product = Auction::with('star', 'bidding', 'bidding.user')->orderBy('id', 'DESC')->where('star_id', $star_id)->where('status', 1)->latest()->get();
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
    public function auctionApply($auction_id)
    {
        $auctionApply = Bidding::with('user', 'auction')->where('auction_id', $auction_id)->where('notify_status', 1)->where('user_id', auth()->user()->id)->first();
        $winner = Bidding::with('user', 'auction')->where('auction_id', $auction_id)->where('win_status', 1)->where('user_id', auth()->user()->id)->first();
        return response()->json([
            'status' => 200,
            'auctionApply' => $auctionApply,
            'winner' => $winner
        ]);
    }
    public function maxBid($id)
    {
        $maxBid = Bidding::orderBy('amount', 'DESC')->where('auction_id', $id)->where('user_id', auth()->user()->id)->first();
        return response()->json([
            'status' => 200,
            'maxBid' => $maxBid,
        ]);
    }

    public function aquiredProduct(Request $request)
    {

        $bidding = Bidding::where('id', $request->bidding_id)->first();

        $validator = Validator::make($request->all(), [

            'name' => 'required',
            'phone' => 'required',
            'card_number' => 'required',
            'ccv' => 'required',
            'expiry_date' => 'required',


        ], [
            'name.required' => 'This Field Is Required',
            'phone.required' => 'This Field Is Required',
            'card_number.required' => 'This Field Is Required',
            'ccv.required' => 'This Field Is Required',
            'expiry_date.required' => 'This Field Is Required',

        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 402,
                'errors' => $validator->errors(),
            ]);
        }

        $aquired = Acquired_app::create([
            'name' => $request->name,
            'bidding_id' => $request->bidding_id,
            'payment_id' => 1,
            'card_number' => $request->card_number,
            'phone' => $request->phone,
            'ccv' => $request->ccv,
            'expiry_date' => $request->expiry_date,
        ]);


        if ($bidding->applied_status == 0) {
            $bidding->applied_status = 1;
            $bidding->update();
        }

        return response()->json([
            'status' => 200,
            'aquired' => $aquired,
            'message' => "Application success"
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

    public function audition_list()
    {
        $upcomingAuditions = Audition::where('status', 3)->latest()->get();

        return response()->json([
            'status' => 200,
            'event' => $upcomingAuditions,
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

    public function userRoundVideoUpload(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file.*' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'validation_errors' => $validator->errors(),
            ]);
        } else {

            foreach ($request->file as $key => $file) {
                $audition_video = new AuditionUploadVideo();
                $audition_video->audition_id = $request->audition_id;
                $audition_video->round_id = $request->round_id;
                $audition_video->user_id = auth()->user()->id;

                $file_name   = time() . rand('0000', '9999') . $key . '.' . $file->getClientOriginalName();
                $file_path = 'uploads/videos/auditions/';
                $file->move($file_path, $file_name);
                $audition_video->video = $file_path . $file_name;
                $audition_video->save();
            }
            return response()->json([
                'status' => 200,
                'message' => 'Audition Videos Uploaded Successfully!',
            ]);
        }
    }

    // public function checkAuditionVideoUpload($audition_id){

    //         $is_video_uploaded = false;
    //         if(AuditionUploadVideo::where('audition_id',$audition_id)->where('user_id',auth()->user()->id)->count() > 0){
    //             $is_video_uploaded  = true;
    //         }else{
    //             $is_video_uploaded  = false;
    //         }



    // }



    public function videoUpload(Request $request)
    {



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
        $enrolledAuditions = AuditionParticipant::with(['audition'])->where('user_id', auth()->user()->id)->get();

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

    public function userActivites()
    {

        $userActivites = Activity::orderBy('id', 'DESC')->where('user_id', auth()->user()->id)->get();


        return response()->json([
            'status' => 200,
            'userActivites' => $userActivites
        ]);
    }

    public function registration_checker($type, $slug)
    {
        if ($type == 'livechat') {
            $event = LiveChat::where('slug', $slug)->first();
            $participant = LiveChatRegistration::where([['user_id', auth('sanctum')->user()->id], ['live_chat_id', $event->id]])->first();
        }
        if ($type == 'learningSession') {
            $event = LearningSession::where('slug', $slug)->first();
            $participant = LearningSessionRegistration::where([['user_id', auth('sanctum')->user()->id], ['learning_session_id', $event->id]])->first();
        }
        if ($type == 'meetup') {
            $event = MeetupEvent::where('slug', $slug)->first();
            $participant = MeetupEventRegistration::where([['user_id', auth('sanctum')->user()->id], ['meetup_event_id', $event->id]])->first();
        }

        return response()->json([
            'status' => 200,
            'participant' => $participant,
        ]);
    }

    public function UserAuditionDetails($slug)
    {
        $audition = Audition::where('slug', $slug)->first();


        return response()->json([
            'status' => 200,
            'audition' => $audition,
        ]);
    }

    public function roundInstruction($rule_id)
    {

        $instruction = AuditionRoundRule::find($rule_id);
        $audition = Audition::where('audition_round_rules_id', $instruction->id)->first();

        // for user audition video uploaded or not
        $is_video_uploaded = false;
        if ($audition->uploadedVideos->where('round_id', $audition->audition_round_rules_id)->where('user_id', auth()->user()->id)->count() > 0) {
            $is_video_uploaded  = true;
        } else {
            $is_video_uploaded  = false;
        }

        return response()->json([
            'status' => 200,
            'audition' => $audition,
            'instruction' => $instruction,
            'is_video_uploaded' => $is_video_uploaded,
        ]);
    }

    public function UserAuditionRegistrationChecker($slug)
    {
        $audition = Audition::where('slug', $slug)->first();
        $participant = AuditionParticipant::where([['user_id', auth('sanctum')->user()->id], ['audition_id', $audition->id]])->first();

        return response()->json([
            'status' => 200,
            'participant' => $participant,
        ]);
    }

    public function uploadLearningSessionVideo(Request $request)
    {
        // return $request->all();
        $validator = Validator::make($request->all(), [
            'file.*' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'validation_errors' => $validator->errors(),
            ]);
        } else {
            $evaluation = LearningSessionEvaluation::where([['event_id',$request->learning_session_id],['user_id',auth()->user()->id]])->first();
            foreach ($request->file as $key => $file) {
                $learning_video = new LearningSessionAssignment();
                $learning_video->event_id = $request->learning_session_id;
                $learning_video->user_id = auth()->user()->id;
                $learning_video->evaluation_id = $evaluation->id;

                $file_name   = time() . rand('0000', '9999') . $key . '.' . $file->getClientOriginalName();
                $file_path = 'uploads/videos/learnings/';
                $file->move($file_path, $file_name);
                $learning_video->video = $file_path . $file_name;
                $learning_video->save();


            }

            $learning_session = LearningSession::find($request->learning_session_id);
            return response()->json([
                'status' => 200,
                'message' => 'Learning Videos Uploaded Successfully!',
                'learningSession' => $learning_session,
            ]);
        }
    }
}
