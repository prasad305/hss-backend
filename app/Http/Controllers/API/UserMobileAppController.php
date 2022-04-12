<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Audition\Audition;
use App\Models\Audition\AuditionParticipant;
use App\Models\Greeting;
use App\Models\GreetingsRegistration;
use App\Models\LiveChatRegistration;
use App\Models\LiveChat;
use App\Models\LearningSession;
use App\Models\LearningSessionRegistration;
use App\Models\MeetupEvent;
use App\Models\MeetupEventRegistration;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
        if( $modelName == 'GreetingsRegistration'){
            $eventRegistration = new GreetingsRegistration();
            $event = Greeting::find($eventId);
            $eventRegistration->greeting_id = $eventId;
            $activity->type = 'greeting';
        }
        if( $modelName == 'AuditionParticipant'){
            $eventRegistration = new AuditionParticipant();
            $event = Audition::find($eventId);
            $eventRegistration->audition_id = $eventId;
            $activity->type = 'audition';
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
}
