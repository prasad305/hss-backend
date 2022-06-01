<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Audition\Audition;
use App\Models\Audition\AuditionParticipant;
use App\Models\AuditionEventRegistration;
use App\Models\Greeting;
use App\Models\GreetingsRegistration;
use App\Models\LiveChatRegistration;
use App\Models\LiveChat;
use App\Models\LearningSession;
use App\Models\LearningSessionRegistration;
use App\Models\LiveChatRoom;
use App\Models\MeetupEvent;
use App\Models\MeetupEventRegistration;
use App\Models\Notification;
use App\Models\User;
use App\Models\UserInfo;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
            'greeting_activities' => Activity::where('user_id', auth('sanctum')->user()->id)->where('type','greeting')->orderBy('id','DESC')->get(),
            'learning_session_activities' => Activity::where('user_id', auth('sanctum')->user()->id)->where('type','learningSession')->orderBy('id','DESC')->get(),
            'live_chat_activities' => Activity::where('user_id', auth('sanctum')->user()->id)->where('type','liveChat')->orderBy('id','DESC')->get(),
            'meetup_activities' => Activity::where('user_id', auth('sanctum')->user()->id)->where('type','meetup')->orderBy('id','DESC')->get(),

        ]);
    }
    public function eventRegister(Request $request)
    {
        // return $request->all();
        $user = User::find(auth('sanctum')->user()->id);
        $eventId = (string)$request->event_id;
        $modelName = $request->model_name;

        // New Activity Add For event register
        $activity = new Activity();


        if( $modelName == 'meetup'){
            $eventRegistration = new MeetupEventRegistration();
            $event = MeetupEvent::find($eventId);
            $eventRegistration->meetup_event_id = $eventId;
            $eventRegistration->amount = $event->fee;
            $activity->type = 'meetup';
        }
        if( $modelName == 'learningSession'){
            $eventRegistration = new LearningSessionRegistration();
            $event = LearningSession::find($eventId);
            $eventRegistration->learning_session_id = $eventId;
            $eventRegistration->amount = $event->fee;
            $activity->type = 'learningSession';
        }

        if( $modelName == 'livechat'){
            $eventRegistration = new LiveChatRegistration();
            $event = LiveChat::find($eventId);
            $event->available_start_time = Carbon::parse($request->end_time)->addMinutes(1)->format('H:i:s');
            $eventRegistration->live_chat_id = $eventId;
            $eventRegistration->amount = $request->fee;
            $eventRegistration->room_id = $request->room_id;
            $eventRegistration->live_chat_start_time = Carbon::parse($request->start_time)->format('H:i:s');
            $eventRegistration->live_chat_end_time = Carbon::parse($request->end_time)->format('H:i:s');
            $activity->type = 'livechat';
            $event->update();
        }
        if( $modelName == 'greeting'){
            $eventRegistration = GreetingsRegistration::find($request->event_registration_id);
            $event = Greeting::find($eventId);
            $eventRegistration->status = 1;
            $activity->type = 'greeting';

            $notification = Notification::find($request->notification_id);
            $notification->view_status = 1;
            $notification->save();
        }
        if ($modelName == 'AuditionParticipant') {
            $eventRegistration = new AuditionEventRegistration();
            $event = Audition::find($eventId);
            $eventRegistration->audition_event_id = $eventId;
            $eventRegistration->amount = $event->fee;
            $activity->type = 'audition';

            $participant = new AuditionParticipant();
            $participant->user_id = $user->id;
            $participant->audition_id = $eventId;
            $eventRegistration->amount = $event->fee;
            $participant->save();
        }

        $eventRegistration->user_id = $user->id;
        $eventRegistration->card_holder_name = $request->card_holder_name;
        $eventRegistration->account_no = $request->card_number;
        $eventRegistration->payment_date = Carbon::now();
        $eventRegistration->payment_status = 1;
        $eventRegistration->save();


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
}
