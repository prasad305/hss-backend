<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Acquired_app;
use App\Models\Activity;
use App\Models\Auction;
use App\Models\Audition\Audition;
use App\Models\Audition\AuditionParticipant;
use App\Models\Audition\AuditionRoundInfo;
use App\Models\Bidding;
use App\Models\FanGroupMessage;
use App\Models\Greeting;
use App\Models\GreetingsRegistration;
use App\Models\LiveChatRegistration;
use App\Models\LiveChat;
use App\Models\LearningSession;
use App\Models\LearningSessionEvaluation;
use App\Models\LearningSessionRegistration;
use App\Models\Marketplace;
use App\Models\MarketplaceOrder;
use App\Models\MeetupEvent;
use App\Models\MeetupEventRegistration;
use App\Models\MyChatList;
use App\Models\Notification;
use App\Models\QnA;
use App\Models\QnaMessage;
use App\Models\QnaRegistration;
use App\Models\User;
use App\Models\UserInfo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Str;


class UserMobileAppController extends Controller
{
    public function menu()
    {
        $activities = Activity::where('user_id', auth('sanctum')->user()->id)->orderBy('id', 'DESC')->get();

        return response()->json([
            'status' => 200,
            'activity_length' => $activities->count(),
            'greeting_activities' => Activity::where('user_id', auth('sanctum')->user()->id)->where('type', 'greeting')->orderBy('id', 'DESC')->get(),
            'learning_session_activities' => Activity::where('user_id', auth('sanctum')->user()->id)->where('type', 'learningSession')->orderBy('id', 'DESC')->get(),
            'live_chat_activities' => Activity::where('user_id', auth('sanctum')->user()->id)->where('type', 'liveChat')->orderBy('id', 'DESC')->get(),
            'qna_activities' => Activity::where('user_id', auth('sanctum')->user()->id)->where('type', 'qna')->orderBy('id', 'DESC')->get(),
            'meetup_activities' => Activity::where('user_id', auth('sanctum')->user()->id)->where('type', 'meetup')->orderBy('id', 'DESC')->get(),
            'auction_activities' => Activity::where('user_id', auth('sanctum')->user()->id)->where('type', 'auction')->orderBy('id', 'DESC')->get(),
            'marketplace_activities' => Activity::where('user_id', auth('sanctum')->user()->id)->where('type', 'marketplace')->orderBy('id', 'DESC')->get(),
            'souviner_activities' => Activity::where('user_id', auth('sanctum')->user()->id)->where('type', 'souviner')->orderBy('id', 'DESC')->get(),
            // 'all_activities' => Activity::where('user_id', auth('sanctum')->user()->id)->orderBy('id', 'DESC')->get(),
        ]);
    }
    public function eventRegister(Request $request)
    {
        // return $request->all();
        $user = auth('sanctum')->user();
        $eventId = (string)$request->event_id;
        $modelName = $request->model_name;

        // New Activity Add For event register
        $activity = new Activity();


        if ($modelName == 'meetup') {
            $eventRegistration = new MeetupEventRegistration();
            $event = MeetupEvent::find($eventId);
            $eventRegistration->meetup_event_id = $eventId;
            $eventRegistration->amount = $event->fee;
            $activity->type = 'meetup';
        }
        if ($modelName == 'learningSession') {
            $eventRegistration = new LearningSessionRegistration();
            $event = LearningSession::find($eventId);
            $eventRegistration->learning_session_id = $eventId;
            $eventRegistration->amount = $event->fee;
            $activity->type = 'learningSession';

            if ($event->assignment == 1) {
                $evaluation = new LearningSessionEvaluation();
                $evaluation->event_id = $event->id;
                $evaluation->user_id = $user->id;
                $evaluation->save();
            }
        }

        if ($modelName == 'livechat') {

            $create_room_id =  createRoomID();
            $eventRegistration = new LiveChatRegistration();
            $event = LiveChat::find($eventId);
            $event->available_start_time = Carbon::parse($request->end_time)->addMinutes($event->interval)->format('H:i:s');
            $eventRegistration->live_chat_id = $eventId;
            $eventRegistration->amount = $request->fee;
            $eventRegistration->room_id = $create_room_id;
            $eventRegistration->live_chat_start_time = Carbon::parse($request->start_time)->format('H:i:s');
            $eventRegistration->live_chat_end_time = Carbon::parse($request->end_time)->format('H:i:s');
            $activity->room_id = $create_room_id;
            $activity->type = 'livechat';


            $event->update();
        }
        if ($modelName == 'qna') {
            $eventRegistration = new QnaRegistration();
            $event = QnA::find($eventId);
            $event->available_start_time = Carbon::parse($request->end_time)->addMinutes($event->time_interval)->format('H:i:s');
            $eventRegistration->qna_id = $eventId;
            $eventRegistration->amount = $request->fee;
            $eventRegistration->room_id = Str::random(20);
            $eventRegistration->qna_date = $event->event_date;
            $eventRegistration->qna_start_time = Carbon::parse($request->start_time)->format('H:i:s');
            $eventRegistration->qna_end_time = Carbon::parse($request->end_time)->format('H:i:s');
            $activity->type = 'qna';
            $event->update();
        }

        if ($modelName == 'greeting') {
            $eventRegistration = GreetingsRegistration::find($request->event_registration_id);
            $event = Greeting::find($eventId);
            $eventRegistration->status = 1;
            $activity->type = 'greeting';

            $notification = Notification::find($request->notification_id);
            $notification->view_status = 1;
            $notification->save();
        }
        if ($modelName == 'auction') {
            $eventRegistration = Bidding::find($request->event_registration_id);
            $event = Auction::find($eventId);
            if ($eventRegistration->applied_status == 0) {
                $eventRegistration->applied_status = 1;
            }
            $activity->type = 'auction';
            $aquired_app = new Acquired_app();
            $aquired_app->name = $request->card_holder_name;
            $aquired_app->bidding_id = $eventRegistration->id;
            $aquired_app->payment_id = 1;
            $aquired_app->card_number = $request->card_number;
            $aquired_app->phone = auth()->user()->phone;
            $aquired_app->ccv = 454654;
            $aquired_app->expiry_date = Carbon::now()->addDays(100);
            $aquired_app->save();
        }
        if ($modelName == 'marketplace') {
            $eventRegistration = MarketplaceOrder::find($request->event_registration_id);
            $event = Marketplace::find($eventId);

            $eventRegistration->cvc = $request->cvc;
            $eventRegistration->card_no = $request->card_no;
            $eventRegistration->expire_date = $request->expire_date;
            $eventRegistration->status = 1;
            $event->total_selling += $eventRegistration->items;
            $event->save();
            $eventRegistration->status = 1;
            $activity->type = 'marketplace';
        }
        if ($modelName == 'AuditionParticipant') {
            $eventRegistration = new AuditionParticipant();
            $event = Audition::find($eventId);
            $activity->type = 'audition';
            $first_round_info = AuditionRoundInfo::where([['audition_id', $eventId]])->first();

            $eventRegistration->user_id = $user->id;
            $eventRegistration->audition_id = $eventId;
            $eventRegistration->round_info_id = $first_round_info->id;
            $eventRegistration->amount = $event->fees;
            $eventRegistration->save();
        }

        $eventRegistration->user_id = $user->id;
        $eventRegistration->card_holder_name = $request->card_holder_name;
        $eventRegistration->account_no = $request->card_number;
        $eventRegistration->payment_date = Carbon::now();
        $eventRegistration->payment_status = 1;
        $eventRegistration->save();


        /**
         * qna add to my chat list
         */

        if ($modelName == 'qna') {
            $myChatList = new MyChatList();
            $myChatList->title =  $event->title;
            $myChatList->type =  'qna';
            $myChatList->qna_id =  $eventRegistration->id;
            $myChatList->user_id =  Auth()->user()->id;
            $myChatList->status =  1;
            $myChatList->save();
        }

        $activity->user_id = $user->id;
        $activity->event_id = $event->id;
        $activity->event_registration_id = $eventRegistration->id;
        $activity->save();

        return response()->json([
            'status' => 200,
            'eventRegistration' => $eventRegistration,
            'modelName' => $modelName,
            'eventId' => $eventId,
            'message' => 'Success Registered',
        ]);
    }

    public function greetingStatus($star_id)
    {
        $greetingsRegistration = GreetingsRegistration::where('user_id', auth('sanctum')->user()->id)->orderBy('id', 'DESC')->first();

        $greeting = Greeting::where([['star_id', $star_id], ['star_approve_status', '>', 0]])->first();

        if (isset($greeting)) {
            $is_this_star_have_greeting = true;
        } else {
            $is_this_star_have_greeting = false;
        }


        if (isset($greetingsRegistration)) {
            if ($greetingsRegistration->status == 2) {
                $is_registered_already = false;
            } else {
                $is_registered_already = true;
            }
        } else {
            $is_registered_already = false;
        }

        return response()->json([
            'status' => 200,
            'is_registered_already' => $is_registered_already,
            'is_this_star_have_greeting' => $is_this_star_have_greeting,
            'greeting_registration' => $greetingsRegistration,
            'greeting' => $greeting,
        ]);
    }

    public function userInformationUpdate(Request $request)
    {
        $user = User::find(auth('sanctum')->user()->id);
        $userInfo = new UserInfo();


        try {
            if ($request->img['data']) {

                $originalExtension = str_ireplace("image/", "", $request->img['type']);

                $folder_path       = 'uploads/images/users/';

                $image_new_name    = Str::random(20) . '-' . now()->timestamp . '.' . $originalExtension;
                $decodedBase64 = $request->img['data'];
            }

            Image::make($decodedBase64)->save($folder_path . $image_new_name);
            $user->image = $folder_path . $image_new_name;

            $userInfo->user_id = $user->id;
            $userInfo->country =  $request->country;
            $userInfo->occupation =  $request->occupation;
            $userInfo->edu_level =  $request->edu;

            $userInfo->save();
            $user->save();
            return response()->json([
                "message" => "Profile image updated ",
                "status" => "200",
                "userInfo" =>  $user
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                "message" => "Image field required, invalid image !",
                "error" => $exception->getMessage(),
                "status" => "0",
            ]);
        }
    }

    /**
     * profile & cover image upload
     */
    public function userMediaUpload(Request $request)
    {

        $user = User::find(auth('sanctum')->user()->id);



        try {
            if ($request->img['data']) {

                $originalExtension = str_ireplace("image/", "", $request->img['type']);

                $folder_path       = 'uploads/images/users/';

                $image_new_name    = Str::random(20) . '-' . now()->timestamp . '.' . $originalExtension;
                $decodedBase64 = $request->img['data'];
            }

            Image::make($decodedBase64)->save($folder_path . $image_new_name);


            //profile image upload
            if ($request->img['for'] == "profile") {
                $user->image = $folder_path . $image_new_name;
            }
            //cover image upload
            if ($request->img['for'] == "cover") {
                $user->cover_photo = $folder_path . $image_new_name;
            }




            $user->save();
            if ($request->img['oldImage'] != "") {
                File::delete($request->img['oldImage']);
            }
            return response()->json([
                "message" => $request->img['for'] . " updated",
                "status" => "200",
                "userInfo" =>  $user
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                "message" => "Image field required, invalid image !",
                "error" => $exception->getMessage(),
                "status" => "0",
            ]);
        }
    }

    /**
     * fan group post image upload
     */
    public function uploadPostMedia(Request $request)
    {
        try {
            if ($request->base64) {

                $originalExtension = str_ireplace("image/", "", $request->type);

                $folder_path       = 'uploads/images/fanpost/';

                $image_new_name    = Str::random(20) . '-' . now()->timestamp . '.' . $originalExtension;
                $decodedBase64 = $request->base64;
            }


            Image::make($decodedBase64)->save($folder_path . $image_new_name);



            $imagePath = $folder_path . $image_new_name;

            return response()->json([
                "message" => "uploaded successfully",
                "status" => "200",
                "path" => $imagePath
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                "message" => "Image field required, invalid image !",
                "error" => $exception->getMessage(),
                "status" => "0",
            ]);
        }
    }

    public function uploadPostVideo(Request $request)
    {
        try {
            if ($request->base64) {

                $originalExtension = str_ireplace("video/", "", $request->type);

                $folder_path       = 'uploads/images/fanpost/';

                $image_new_name    = Str::random(20) . '-' . now()->timestamp . '.' . $originalExtension;
                $decodedBase64 = $request->base64;
            }
            $videoPath = $folder_path . $image_new_name;


            file_put_contents($videoPath, base64_decode($decodedBase64, true));


            return response()->json([
                "message" => "uploaded successfully",
                "status" => "200",
                "path" => $videoPath
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                "message" => "Image field required, invalid image !",
                "error" => $exception->getMessage(),
                "status" => "0",
            ]);
        }
    }



    /**
     * all upcomming events get
     */
    public function allUpcommingEvent()
    {
        $learningSessions = LearningSession::where('status', 2)->orderBy('id', 'DESC')->get();
        $liveChats = LiveChat::where('status', 2)->orderBy('id', 'DESC')->get();
        $auditions = Audition::where('status', 2)->orderBy('id', 'DESC')->get();
        $meetups = MeetupEvent::where('status', 2)->orderBy('id', 'DESC')->get();

        return response()->json([
            "learningSessions" => $learningSessions,
            "liveChats" => $liveChats,
            "auditions" =>  $auditions,
            "meetups" => $meetups
        ]);
    }
    /**
     * all star list
     */
    public function allStarList()
    {
        $allStars = User::where('user_type', 'star')->where('status', 1)->orderBy('id', 'DESC')->get();
        return response()->json([
            "stars" =>  $allStars
        ]);
    }

    /**
     * my chat list
     */
    public function MyChatList()
    {
        $myChatList = MyChatList::where('user_id', Auth()->user()->id)->get();

        return response()->json([
            "status" => 200,
            "chatList" => $myChatList
        ]);
    }



    /**
     * get fan group message
     */
    public function getFanGroupMessage($group_id)
    {
        $fanMessageHistory = FanGroupMessage::where([['group_id', $group_id], ['status', 1]])->get();

        return response()->json([
            "status" => 200,
            "chat_history" => $fanMessageHistory
        ]);
    }

    /**
     * get qna message history
     */
    public function getQnaMessage($qna_id)
    {

        $qnaMessageHistory = QnaMessage::where([['sender_id', Auth()->user()->id], ['qna_id', $qna_id]])->get();
        return response()->json([
            "status" => 200,
            "qna_history" => $qnaMessageHistory
        ]);
    }
}
