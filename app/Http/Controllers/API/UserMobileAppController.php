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
use App\Models\MeetupEvent;
use App\Models\MeetupEventRegistration;
use App\Models\User;
use App\Models\UserInfo;
use Carbon\Carbon;
use Illuminate\Http\Request;

use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Str;


class UserMobileAppController extends Controller
{
    public function eventRegister(Request $request){
        $user = User::find(auth('sanctum')->user()->id);
        $eventId = (string)$request->event_id;
        $modelName = $request->model_name;

        // New Activity Add For Activity
        $activity = new Activity();

        if( $modelName == 'MeetupEventRegistration'){
            $eventRegistration = new MeetupEventRegistration();
            $event = MeetupEvent::find($eventId);
            $eventRegistration->meetup_event_id = $eventId;
            $activity->type = 'meetup';
        }
        if( $modelName == 'LearningSessionRegistration'){
            $eventRegistration = new LearningSessionRegistration();
            $event = LearningSession::find($eventId);
            $eventRegistration->learning_session_id = $eventId;
            $activity->type = 'learningSession';
        }
        if( $modelName == 'LiveChatRegistration'){
            $eventRegistration = new LiveChatRegistration();
            $event = LiveChat::find($eventId);
            $eventRegistration->live_chat_id = $eventId;
            $activity->type = 'liveChat';
        }
        // if( $modelName == 'GreetingsRegistration'){
        //     $eventRegistration = new GreetingsRegistration();
        //     $event = Greeting::find($eventId);
        //     $eventRegistration->greeting_id = $eventId;
        //     $activity->type = 'greeting';
        // }
        if( $modelName == 'AuditionParticipant'){
            $eventRegistration = new AuditionEventRegistration();
            $event = Audition::find($eventId);
            $eventRegistration->audition_event_id = $eventId;
            $activity->type = 'audition';

            $participant = new AuditionParticipant();
            $participant->user_id = $user->id;
            $participant->audition_id = $eventId;
            $participant->save();
        }

        $eventRegistration->user_id = $user->id;
        $eventRegistration->card_holder_name = $request->card_holder_name;
        $eventRegistration->account_no = $request->card_number;
        $eventRegistration->payment_date = Carbon::now();
        $eventRegistration->amount = $event->fee;
        $eventRegistration->payment_status = 1;
        $eventRegistration->save();


        $activity->user_id = $user->id;
        $activity->event_id = $event->id;
        $activity->save();

        return response()->json([
            'status'=>200,
            'eventRegistration'=>$eventRegistration,
            'modelName'=>$modelName,
            'eventId'=>$eventId,
            'message'=>'Success',
        ]);
    }

    public function greetingStatus($star_id){
        $greetingsRegistration = GreetingsRegistration::where('user_id', auth('sanctum')->user()->id)->orderBy('id','DESC')->first();

        $greeting = Greeting::where([['star_id', $star_id], ['star_approve_status', '>', 0]])->first();

        if (isset($greeting)) {
            $is_this_star_have_greeting = true;
        } else {
            $is_this_star_have_greeting = false;
        }


        if (isset($greetingsRegistration)) {
            if($greetingsRegistration->status == 2){
                $is_registered_already = false;
            }else{
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

     public function userInformationUpdate(Request $request){
        $user = User::find(auth('sanctum')->user()->id);
        $userInfo = new UserInfo();



        try {
             if($request->img['data']){

            $originalExtension = str_ireplace("image/","",$request->img['type']);

            $folder_path       = 'uploads/images/users/';

            $image_new_name    = Str::random(20).'-'.now()->timestamp.'.'.$originalExtension;
            $decodedBase64 = $request->img['data'];
        }

            Image::make($decodedBase64)->save($folder_path.$image_new_name);
            $user->image = $folder_path.$image_new_name;

            $userInfo->user_id= $user->id;
            $userInfo->country=  $request->country;
            $userInfo->occupation=  $request->occupation;
            $userInfo->edu_level=  $request->edu;

            $userInfo->save();
            $user->save();
            return response()->json([
                "message"=>"Profile image updated ",
                "status"=>"200",
                "userInfo" =>  $user
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                "message"=>"Image field required, invalid image !",
                "error"=>$exception->getMessage(),
                "status"=>"0",
            ]);
        }
    }
}
