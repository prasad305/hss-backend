<?php

namespace App\Http\Controllers\API;

use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Http;

use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Models\Acquired_app;
use App\Models\Activity;
use App\Models\Auction;
use App\Models\Audition\Audition;
use App\Models\Audition\AuditionParticipant;
use App\Models\Audition\AuditionRoundInfo;
use App\Models\Bidding;
use App\Models\Country;
use App\Models\Educationlevel;
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
use App\Models\Occupation;
use App\Models\QnA;
use App\Models\Virtualtour;
use App\Models\QnaMessage;
use App\Models\QnaRegistration;
use App\Models\User;
use App\Models\UserInfo;
use App\Models\Audition\AuditionUploadVideo;
use App\Models\Fan_Group_Join;
use App\Models\Wallet;
use App\Models\Audition\AuditionAssignJudge;
use App\Models\SuperStar;
use App\Models\AuditionCertification;
use App\Models\AuditionCertificationContent;
use App\Models\Audition\AuditionRoundMarkTracking;
use App\Models\LearningSessionCertificate;
use Carbon\Carbon;
use DateTimeImmutable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Models\AuditionOxygenReplyVideo;

use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Str;
// use Barryvdh\DomPDF\Facade\Pdf;
use PDF;

class UserMobileAppController extends Controller
{
    public function menu()
    {
        $activities = Activity::where('user_id', auth('sanctum')->user()->id)->orderBy('id', 'DESC')->get();

        return response()->json([
            'status' => 200,
            'activity_length' => $activities->count(),
            'audition_activities' => Activity::where('user_id', auth('sanctum')->user()->id)->where('type', 'audition')->orderBy('id', 'DESC')->get(),
            'greeting_activities' => Activity::where('user_id', auth('sanctum')->user()->id)->where('type', 'greeting')->orderBy('id', 'DESC')->get(),
            'learning_session_activities' => Activity::where('user_id', auth('sanctum')->user()->id)->where('type', 'learningSession')->orderBy('id', 'DESC')->get(),
            'live_chat_activities' => Activity::where('user_id', auth('sanctum')->user()->id)->where('type', 'liveChat')->orderBy('id', 'DESC')->get(),
            'qna_activities' => Activity::where('user_id', auth('sanctum')->user()->id)->where('type', 'qna')->orderBy('id', 'DESC')->get(),
            'meetup_activities' => Activity::where('user_id', auth('sanctum')->user()->id)->where('type', 'meetup')->orderBy('id', 'DESC')->get(),
            'auction_activities' => Activity::where('user_id', auth('sanctum')->user()->id)->where('type', 'auction')->orderBy('id', 'DESC')->get(),
            'marketplace_activities' => Activity::where('user_id', auth('sanctum')->user()->id)->where('type', 'marketplace')->orderBy('id', 'DESC')->get(),
            'souviner_activities' => Activity::where('user_id', auth('sanctum')->user()->id)->where('type', 'souvenir')->orderBy('id', 'DESC')->get(),
            // 'all_activities' => Activity::where('user_id', auth('sanctum')->user()->id)->orderBy('id', 'DESC')->get(),
        ]);
    }
    public function eventRegister(Request $request)
    {

        // return $request->all();
        $user = auth('sanctum')->user();
        $eventId = (string)$request->event_id;
        $modelName = $request->model_name;


        // return $modelName;

        if ($modelName == 'meetup') {
            if (!MeetupEventRegistration::where([['user_id', auth()->user()->id], ['meetup_event_id', $eventId]])->exists()) {
                $activity = new Activity();
                $eventRegistration = new MeetupEventRegistration();
                $event = MeetupEvent::find($eventId);
                //for free cost regisation
                if ($request->payment_method == "Free-Registaion") {
                    $eventRegistration->payment_method = $request->payment_method;
                    $eventRegistration->payment_status = 1;
                }
                $eventRegistration->user_id = $user->id;
                $eventRegistration->meetup_event_id = $eventId;
                $eventRegistration->amount = $event->fee;
                $activity->type = 'meetup';
                $eventRegistration->save();

                // Wallet start
                if ($request->payment_method == "wallet") {
                    $walletMeetup =  Wallet::where('user_id', auth('sanctum')->user()->id)->first('meetup');
                    Wallet::where('user_id', auth('sanctum')->user()->id)->update(['meetup' => $walletMeetup->meetup - 1]);
                    MeetupEventRegistration::where([['user_id', auth('sanctum')->user()->id], ['meetup_event_id', $eventId]])->update([
                        'payment_status' => 1,
                        'payment_method' => "wallet",

                    ]);
                }

                // Wallet End
            }
        }
        if ($modelName == 'learningSession') {

            if (!LearningSessionRegistration::where([['user_id', auth()->user()->id], ['learning_session_id', $eventId]])->exists()) {

                $activity = new Activity();
                $eventRegistration = new LearningSessionRegistration();
                $event = LearningSession::find($eventId);
                $eventRegistration->user_id = $user->id;
                $eventRegistration->learning_session_id = $eventId;
                $eventRegistration->amount = $event->fee;
                $activity->type = 'learningSession';

                //for free cost regisation
                if ($request->payment_method == "Free-Registaion") {
                    $eventRegistration->payment_method = $request->payment_method;
                    $eventRegistration->publish_status = 1;
                    $eventRegistration->payment_status = 1;
                }

                if ($event->assignment == 1) {
                    $evaluation = new LearningSessionEvaluation();
                    $evaluation->event_id = $event->id;
                    $evaluation->user_id = $user->id;
                    $evaluation->save();
                }

                $eventRegistration->save();
                // Wallet start
                if ($request->payment_method == "wallet") {
                    $learnigSession =  Wallet::where('user_id', auth('sanctum')->user()->id)->first('meetup');
                    Wallet::where('user_id', auth('sanctum')->user()->id)->update(['learning_session' => $learnigSession->learning_session - 1]);
                    LearningSessionRegistration::where([['user_id', auth('sanctum')->user()->id], ['learning_session_id', $eventId]])->update([
                        'payment_status' => 1,
                        'publish_status' => 1,
                        'payment_method' => "wallet",

                    ]);
                }

                // Wallet End
            }
        }

        if ($modelName == 'livechat') {
            if (!LiveChatRegistration::where([['user_id', auth()->user()->id], ['live_chat_id', $eventId]])->exists()) {
                $activity = new Activity();
                $create_room_id =  createRoomID();
                $eventRegistration = new LiveChatRegistration();
                $event = LiveChat::find($eventId);


                //for free cost regisation
                if ($request->payment_method == "Free-Registaion") {
                    $eventRegistration->payment_method = $request->payment_method;
                    $eventRegistration->publish_status = 1;
                    $eventRegistration->payment_status = 1;
                }

                $eventRegistration->user_id = $user->id;
                $eventRegistration->live_chat_id = $eventId;
                $eventRegistration->amount =  $request->quantity > 0 ? ($event->fee * $request->quantity) : $event->fee;
                $eventRegistration->room_id = $create_room_id;
                $eventRegistration->taken_time = $request->quantity;
                $eventRegistration->live_chat_start_time = Carbon::parse($event->start_time)->format('H:i:s');
                // $eventRegistration->live_chat_end_time = Carbon::parse($request->end_time)->format('H:i:s');

                $eventRegistration->live_chat_date = $event->event_date;
                $activity->room_id = $create_room_id;
                $activity->type = 'livechat';
                $eventRegistration->save();

                // Wallet start
                if ($request->payment_method == "wallet") {
                    $walletLiveChat =  Wallet::where('user_id', auth('sanctum')->user()->id)->first('live_chats');
                    Wallet::where('user_id', auth('sanctum')->user()->id)->update(['live_chats' => $walletLiveChat->live_chats - 1]);
                    LiveChatRegistration::where([['user_id', auth('sanctum')->user()->id], ['live_chat_id', $eventId]])->update([
                        'payment_status' => 1,
                        'publish_status' => 1,
                        'payment_method' => "wallet",
                        'room_id' => $create_room_id,
                    ]);
                }

                // Wallet End
                $event->available_start_time = (($event->available_start_time - $request->quantity) - $event->interval);

                // (Carbon::parse($request->end_time)->addMinutes($event->interval)->format('H:i:s')) <= Carbon::parse($event->end_time)->format('H:i:s') ? Carbon::parse($request->end_time)->addMinutes($event->interval)->format('H:i:s') : Carbon::parse($event->end_time)->format('H:i:s');
                $event->update();
            }
        }
        if ($modelName == 'qna') {
            if (!QnaRegistration::where([['user_id', auth()->user()->id], ['qna_id', $eventId]])->exists()) {
                $activity = new Activity();
                $eventRegistration = new QnaRegistration();
                $event = QnA::find($eventId);
                $create_room_id = createRoomID();

                $eventRegistration->user_id = $user->id;

                $eventRegistration->qna_id = $eventId;
                $eventRegistration->amount =  $request->quantity > 0 ? ($event->fee * $request->quantity) : $event->fee;
                $eventRegistration->room_id = $create_room_id;
                $eventRegistration->qna_date = $event->event_date;

                //for free cost regisation
                if ($request->payment_method == "Free-Registaion") {
                    $eventRegistration->payment_method = $request->payment_method;
                    $eventRegistration->payment_status = 1;
                }


                // $eventRegistration->publish_status = 1;
                $eventRegistration->qna_start_time = $event->available_start_time ? Carbon::parse($event->available_start_time)->format('H:i:s'):Carbon::parse($event->start_time)->format('H:i:s');
                // $eventRegistration->card_holder_name =  $request->quantity;
                $eventRegistration->qna_end_time = Carbon::parse($request->end_time)->format('H:i:s');
                $activity->type = 'qna';
                $activity->room_id = $create_room_id;
                $eventRegistration->save();


                // Wallet start
                if ($request->payment_method == "wallet") {
                    $walletQna =  Wallet::where('user_id', auth('sanctum')->user()->id)->first('qna');
                    Wallet::where('user_id', auth('sanctum')->user()->id)->update(['qna' => $walletQna->qna - 1]);
                    QnaRegistration::where([['user_id', auth('sanctum')->user()->id], ['qna_id', $eventId]])->update([
                        'payment_status' => 1,
                        'publish_status' => 1,
                        'payment_method' => "wallet",
                    ]);
                }
                // Wallet End
                $event->available_start_time = (Carbon::parse($request->end_time)->addMinutes($event->time_interval)->format('H:i:s')) <= Carbon::parse($event->end_time)->format('H:i:s') ? Carbon::parse($request->end_time)->addMinutes($event->time_interval)->format('H:i:s') : Carbon::parse($event->end_time)->format('H:i:s');
                $event->update();
                /**
                 * qna add to my chat list
                 */
                $myChatList = new MyChatList();
                $myChatList->title =  $event->title;
                $myChatList->type =  'qna';
                $myChatList->qna_id =  $eventRegistration->id;
                $myChatList->user_id =  Auth()->user()->id;
                $myChatList->status =  1;
                $myChatList->save();
            }
        }

        if ($modelName == 'greeting') {

            if (!GreetingsRegistration::where([['user_id', auth()->user()->id], ['id', $eventId], ['payment_status', 1]])->exists()) {

                $eventRegistration = GreetingsRegistration::find($eventId);
                $event = Greeting::find($eventRegistration->greeting_id);
                $eventRegistration->status = 1;
                $eventRegistration->amount = $event->cost;

                //for free cost regisation
                if ($request->payment_method == "Free-Registaion") {
                    $eventRegistration->payment_method = $request->payment_method;
                    $eventRegistration->payment_status = 1;
                }


                $eventRegistration->save();
                if ($request->payment_method == "wallet") {
                    $activity = new Activity();
                    $activity->type = 'greeting';
                    $greeting =  Wallet::where('user_id', auth('sanctum')->user()->id)->first('greetings');
                    Wallet::where('user_id', auth('sanctum')->user()->id)->update(['greetings' => $greeting->greetings - 1]);
                    GreetingsRegistration::where([['user_id', auth('sanctum')->user()->id], ['id', $eventId]])->update([
                        'payment_status' => 1,
                        'status' => 1,
                        'payment_method' => "wallet",

                    ]);
                }
            }

            // $notification = Notification::find($request->notification_id);
            // $notification->view_status = 1;
            // $notification->save();
        }
        if ($modelName == 'auction') {
            $activity = new Activity();
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
            $activity = new Activity();
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
            $eventRegistration->save();
        }
        if ($modelName == 'audition') {

            $eventRegistration = new AuditionParticipant();
            $event = Audition::find($eventId);
            $first_round_info = AuditionRoundInfo::where([['audition_id', $eventId]])->first();
            $eventRegistration->user_id = $user->id;
            $eventRegistration->audition_id = $eventId;
            $eventRegistration->round_info_id = $first_round_info->id;
            $eventRegistration->amount = $event->fees;
            $eventRegistration->save();


            if ($request->payment_method == "wallet") {
                $activity = new Activity();
                $activity->type = 'audition';
                $walletAuditions =  Wallet::where('user_id', auth('sanctum')->user()->id)->first('auditions');
                Wallet::where('user_id', auth('sanctum')->user()->id)->update(['auditions' => $walletAuditions->auditions - 1]);
                AuditionParticipant::where([['user_id', auth('sanctum')->user()->id], ['audition_id', $eventId]])->update([
                    'payment_status' => 1,
                    'payment_method' => "wallet"

                ]);
            }
        }

        try {
            // $eventRegistration->user_id = $user->id;
            // $eventRegistration->card_holder_name = $request->card_holder_name;
            // $eventRegistration->account_no = $request->card_number;
            // $eventRegistration->payment_date = Carbon::now();
            // $eventRegistration->save();
        } catch (\Throwable $th) {
            //throw $th;
        }




        /**
         * qna add to my chat list
         */

        // if ($modelName == 'qna') {
        //     if (!QnaRegistration::where([['user_id', auth()->user()->id], ['qna_id', $eventId]])->exists()) {

        //     }
        // }

        try {
            $activity->user_id = $user->id;
            $activity->event_id = $event->id;
            $activity->event_registration_id = $eventRegistration->id;
            $activity->save();
        } catch (\Throwable $th) {
            //throw $th;
        }


        $userWallet = Wallet::where('user_id', Auth::user()->id)->first();

        return response()->json([
            'status' => 200,
            'eventRegistration' => $eventRegistration,
            'modelName' => $modelName,
            'eventId' => $eventId,
            'message' => 'Success Registered',
            'waletInfo' => $userWallet,
            'payment_method' => $request->payment_method,
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
            if ($request->img) {


                $originalExtension = str_ireplace("image/", "", $request->img['type']);

                $folder_path       = 'uploads/images/users/';

                $image_new_name    = Str::random(20) . '-' . now()->timestamp . '.' . $originalExtension;
                $decodedBase64 = $request->img['data'];
                Image::make($decodedBase64)->save($folder_path . $image_new_name);
                $user->image = $folder_path . $image_new_name;
            }


            $userInfo->user_id = $user->id;
            $userInfo->country =  $request->country;
            $userInfo->occupation =  $request->occupation;
            $userInfo->edu_level =  $request->edu;
            $userInfo->dob =  Carbon::parse($request->birthday);

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
            // if ($request->img['oldImage'] != "") {
            //     File::delete($request->img['oldImage']);
            // }
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

                $folder_path       = 'uploads/audio/qna/';

                $image_new_name    = Str::random(20) . '-' . now()->timestamp . '.mp4';
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
                "message" => "field required, invalid formate !",
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
    public function getQnaMessage($room_id)
    {

        $qnaMessageHistory = QnaMessage::where('room_id', $room_id)->get();

        return response()->json([
            "status" => 200,
            "qna_history" => $qnaMessageHistory
        ]);
    }
    public function getInvoice(Request $request)
    {
        $data = [
            'productName' => $request->productName,
            'SuperStar' => $request->SuperStar,
            'qty' => $request->qty,
            'unitPrice' => $request->unitPrice,
            'total' => $request->total,
            'subTotal' => $request->subTotal,
            'deliveryCharge' => $request->deliveryCharge,
            'tax' => $request->tax,
            'grandTotal' => $request->grandTotal,
            'orderID' => $request->orderID,
            'orderDate' => $request->orderDate,
            'description' => $request->description,
            'name' => $request->name,

        ];
        $time = time();
        try {
            $pdf = PDF::loadView('Others.Invoice.Invoice', compact('data'));
            file_put_contents('uploads/pdf/' . $time . '.pdf', $pdf->output());
            $filename = 'uploads/pdf/' . $time . '.' . 'pdf';
            return $filename;
        } catch (\Throwable $th) {
            return $th;
        }
    }

    /**
     * crete user form infors
     */
    public function getGetInfos()
    {


        $ocupation = Occupation::where('status', 1)->get();
        $edu = Educationlevel::where('status', 1)->get();
        $country = Country::where('status', 1)->get();


        return response()->json([
            "status" => 200,
            "occupation" => $ocupation,
            "educationlevel" => $edu,
            "country" => $country
        ]);
    }
    public function userRoundVideoUpload(Request $request)
    {
        $audition_video = new AuditionUploadVideo();
        $audition_video->audition_id = $request->audition_id;
        $audition_video->round_info_id = $request->round_info_id;
        $audition_video->user_id = auth('sanctum')->user()->id;
        $audition_video->type = $request->type;
        try {
            if ($request->base64) {

                $originalExtension = str_ireplace("video/", "", $request->videoType);

                $folder_path       = 'uploads/videos/auditions/';

                $image_new_name    = Str::random(20) . '-' . now()->timestamp . '.' . $originalExtension;
                $decodedBase64 = $request->base64;
                $videoPath = $folder_path . $image_new_name;
                file_put_contents($videoPath, base64_decode($decodedBase64, true));
                $audition_video->video = $videoPath;
                $audition_video->save();
                return 'video not found';
                return response()->json([
                    "message" => "uploaded successfully",
                    "status" => "200"
                ]);
            }
        } catch (\Exception $exception) {
            return response()->json([
                "message" => "field required, invalid formate !",
                "error" => $exception->getMessage(),
                "status" => "0",
            ]);
        }













        //single video
        // $audition_video = new AuditionUploadVideo();
        // $audition_video->audition_id = $request->audition_id;
        // $audition_video->round_info_id = $request->round_info_id;
        // $audition_video->user_id = auth('sanctum')->user()->id;
        // $audition_video->type = $request->type;
        // $base64 = $file['base64'];
        //     //upload files
        //     try {
        //         if ($base64) {
        //             $originalExtension = str_ireplace("video/", "", $file['type']);

        //             $file_path       = 'uploads/videos/auditions/';
        //             $file_name    = time() . rand('0000', '9999') . $key . $originalExtension;
        //             $decodedBase64 = $base64;
        //             file_put_contents($file_path, base64_decode($decodedBase64, true));
        //             $audition_video->video = $file_path . $file_name;
        //             $audition_video->save();
        //         }

        //     } catch (\Exception $exception) {
        //         response()->json([
        //             "message" => "Video field required, invalid image !",
        //             "error" => $exception->getMessage(),
        //             "status" => "0",
        //         ]);
        //     }

        //     response()->json([
        //         "message" => "uploaded successfully",
        //         "status" => "200",
        //     ]);
        // }
    }

    /**
     * fan group member list
     */
    public function ganGroupJoinMemebers($fangroup_id)
    {

        $fanGroupMemebers = Fan_Group_Join::where([['fan_group_id', $fangroup_id], ['approveStatus', 1]])->get();

        return response()->json([
            "status" => "200",
            "members" => $fanGroupMemebers
        ]);
    }



    /**
     * sdk test url
     */
    public function sdktestUrl($room_id)
    {
        return $room_id;
        $VIDEOSDK_API_KEY = "9af32487-b9c6-4679-a9f1-c5239c35410b";
        $VIDEOSDK_SECRET_KEY = "aaf9ba47bc165fdcd5a0f57638efd822cee41261a389c6ce438c314c4b3ef429";

        header("Content-type: application/json; charset=utf-8");

        $issuedAt   = new DateTimeImmutable();
        $expire     = $issuedAt->modify('+24 hours')->getTimestamp();

        $payload = [
            'apikey' => $VIDEOSDK_API_KEY,
            'permissions' => array(
                "allow_join", "allow_mod"
            ),
            'iat' => $issuedAt->getTimestamp(),
            'exp' => $expire
        ];


        $jwt = JWT::encode($payload, $VIDEOSDK_SECRET_KEY, 'HS256');

        $request = Http::withHeaders([
            'Authorization' =>  $jwt,
            'Content-Type' => ' application/json'
        ])->GET('https://api.videosdk.live/v2/sessions/?roomId=' . $room_id);


        return $request; //for live
    }

    public function getLearningSessionCertificate(Request $request, $slug)
    {
        // return $request->all();
        $learnigSession = LearningSession::where([['slug', $slug]])->first();
        $superStar = SuperStar::where('star_id', $learnigSession->star->id)->first();

        $starFullName =  $learnigSession->star->first_name . ' ' . $learnigSession->star->last_name;
        $sign = $superStar->signature;
        $userName = $request->name;
        $userFatherName = $request->fatherName;
        $time = time();
        $PDFInfo = [
            'starFullName' => $starFullName,
            'signature' => $sign,
            'userName' => $userName,
            'fatherName' => $userFatherName,
        ];
        try {
            // return view('Others.Certificate.LearningCertificate');
            // $pdf = PDF::loadView('Others.Certificate.LearningCertificate');
            // return $pdf;


            $pdf = PDF::loadView('Others.Certificate.LearningCertificate', compact('PDFInfo'));
            file_put_contents('uploads/pdf/' . $time . '.pdf', $pdf->output());
            $filename = 'uploads/pdf/' . $time . '.' . 'pdf';


            $learning_session = LearningSession::find($request->event_id);

            if ($learning_session) {
                $certificate =  LearningSessionCertificate::where([['event_id', $request->event_id], ['user_id', auth()->user()->id]])->first();
                if (empty($certificate)) {
                    $certificate = new LearningSessionCertificate();
                }
                $certificate->event_id = $request->event_id;
                $certificate->user_id = auth()->user()->id;
                $certificate->name = $request->name;
                $certificate->father_name = $request->fatherName;
                $certificate->save();
            }



            return response()->json([
                'status' => 200,
                'certificateURL' =>  $filename,
                'learning_session' => $learning_session,
                'certificate' => $certificate,
            ]);
            // file_put_contents('uploads/pdf/' . $time . '.pdf', $pdf->output());
            // $filename = 'uploads/pdf/' . $time . '.' . 'pdf';
            // return $filename;
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function checkPaymentStatus($slug)
    {
        $learningSession = LearningSession::where([['slug', $slug]])->first();
        $certificatePay =  LearningSessionCertificate::where([['event_id', $learningSession->id], ['user_id', auth()->user()->id], ['payment_status', 1]])->first();
        return response()->json([
            'status' => 200,
            'certificate' => $certificatePay,
        ]);
    }

    public function getCertificate($audition_id, $round_info_id)
    {

        $isWinner = false;
        $super = false;
        $auditionRoundMarkTracking = AuditionRoundMarkTracking::where([
            ['user_id', auth()->user()->id],
            ['audition_id', $audition_id], ['round_info_id', $round_info_id], ['wining_status', 1]
        ])->first();

        if ($auditionRoundMarkTracking) {
            $certificate = AuditionCertification::where([['audition_id', $audition_id], ['round_info_id', $round_info_id], ['participant_id', auth()->user()->id]])->whereNotNull('certificate')->first();
            if ($certificate) {
                return response()->json([
                    'status' => 200,
                    'certificateURL' =>  $certificate->certificate,
                ]);
            }


            $assignedJudges = AuditionAssignJudge::where('audition_id', $audition_id)->get();
            // return $assignedJudges;
            $totalStars = [];
            foreach ($assignedJudges as $judge) {
                if ($judge->super_judge == 1) {
                    $super = true;
                }
                $superstarId = $judge->judge_id;
                $superStar = SuperStar::where('star_id', $superstarId)->first();
                $superstarName = $superStar->superStar->first_name . " " . $superStar->superStar->last_name;
                $starInfo = [
                    'isSuperAdmin' => $super,
                    'signature' => $superStar['signature'],
                    'name' => $superstarName,
                ];
                array_push($totalStars, $starInfo);
            }
            $userInfo = $auditionRoundMarkTracking->user;
            $certificateContent = AuditionCertificationContent::where([['audition_id', $audition_id]])->first();
            // Calculate for rating star
            $round_info = AuditionRoundInfo::where('id', $round_info_id)->first();
            $totalRound = AuditionRoundInfo::where('audition_id', $audition_id)->count();
            $starRating =  ((($round_info->round_num / $totalRound) * 100) * 5) / 100;
            $PDFInfo = [
                'user' => ($userInfo['first_name'] . ' ' . $userInfo['last_name']),
                'stars' => $totalStars,
                'certificateContent' => $certificateContent,
                'starRating' => $starRating,
            ];
            $time = time();
            try {
                $pdf = PDF::loadView('Others.Certificate.Certificate', compact('PDFInfo'));
                file_put_contents('uploads/pdf/auditions/' . $time . '.pdf', $pdf->output());
                // ->save(public_path('uploads/pdf/auditions/' . $time . '.' . 'pdf'));
                $filename = 'uploads/pdf/auditions/' . $time . '.' . 'pdf';
            } catch (\Throwable $th) {
                return $th;
            }

            $auditionCertification = AuditionCertification::where([['audition_id', $audition_id], ['round_info_id', $round_info_id], ['participant_id', auth()->user()->id]])->first();


            $auditionCertification->certificate = $filename;
            $auditionCertification->update();
            if ($auditionCertification) {
                return response()->json([
                    'status' => 200,
                    'certificateURL' =>  $auditionCertification->certificate,
                ]);
            }
        } else {
            return response()->json([
                'status' => 200,
                'message' =>  "Sorry!",
            ]);
        }
    }
    /**
     * offline meetup ticket downlode
     */
    public function meetUpTicketDownload(Request $request)
    {

        $time = time();
        $user = User::find($request->uid);
        $meetUp = MeetupEvent::find($request->id);
        $pdf = PDF::loadView('Others.ticket.ticketMeetup', compact('user', 'meetUp'));
        file_put_contents('uploads/pdf/' . $time . '.pdf', $pdf->output());
        $filename = 'uploads/pdf/' . $time . '.' . 'pdf';
        return response()->json([
            'status' => 200,
            'certificateURL' =>  $filename,
        ]);
    }
    /**
     * oxygenReplyVideo
     */
    public function oxygenReplyVideo(Request $request)
    {
        try {
            if ($request->base64) {

                $originalExtension = str_ireplace("video/", "", $request->type);

                $folder_path       = 'uploads/videos/auditions/post/';

                $image_new_name    = Str::random(20) . '-' . now()->timestamp . '.' . $originalExtension;
                $decodedBase64 = $request->base64;
            }
            $videoPath = $folder_path . $image_new_name;

            file_put_contents($videoPath, base64_decode($decodedBase64, true));

            if ($videoPath) {
                // return $request->oxy_audition_id;
                $oxygenReply = new AuditionOxygenReplyVideo();

                $oxygenReply->audition_id = $request->oxy_audition_id;

                $oxygenReply->round_info_id = $request->oxy_round_info_id;
                // return;
                $oxygenReply->reply_video = $videoPath;
                $oxygenReply->oxygen_video_id = $request->oxy_video_id;
                $oxygenReply->user_id = auth('sanctum')->user()->id;
                $oxygenReply->participant_id = $request->oxy_user_id;
                $oxygenReply->save();


                // $oxygenReply = AuditionOxygenReplyVideo::create([
                //     'audition_id' => $request->oxy_audition_id,
                //     'round_info_id' => $request->oxy_round_info_id,
                //     'reply_video' => $videoPath,
                //     'oxygen_video_id' => $request->oxy_video_id,
                //     'user_id' => auth('sanctum')->user()->id,
                //     'participant_id' => $request->oxy_user_id,
                // ]);

                return response()->json([
                    "message" => "uploaded successfully",
                    "status" => "200",
                    "path" => $videoPath
                ]);
            }
        } catch (\Exception $exception) {
            return response()->json([
                "message" => "field required, invalid formate !",
                "error" => $exception->getMessage(),
                "status" => "0",
            ]);
        }
    }
    public function getVirtualTourVideo()
    {
        $virtualTourLink = Virtualtour::where('type', 'phone')->first();
        if ($virtualTourLink) {
            return response()->json([
                "message" => "Video found",
                "status" => "200",
                'videoInfo' => $virtualTourLink,
            ]);
        }
        return response()->json([
            "message" => "Can not find the video",
            "status" => "402",
        ]);
    }

    public function fileUploadForMobile(Request $request)
    {
        if (Request::hasFile('file')) {

            $file = Request::file('file');
            $file->move('uploads', $file->getClientOriginalName());
            return "file upload done";
        }
    }


    // sent nptification

    public function sendNotification()
    {

        // return 'done';
        $url = 'https://fcm.googleapis.com/fcm/send';

        $FcmToken = [
            'c3A8rwK8RmeW80RLwg2nr-:APA91bFLp7ooIFolzZw9b3rLe9bCkzLbUf4MUx69AeCemAARpcXzLLQkJJRbETKdfIGsNNYfY3q1lMdUEpZvtut_NcLBhHFkdZXqnvPJaW4rYApGalalAVp38bCk8SNhIlPEs-Rf0OVG',
            'eU6a12BhQMqHBDBwV88u84:APA91bEZO-uemn5MsS0cDjeFOIQptLrKH9QykyIPFz0Ims81W162NF6jFW_tfr7IX7A-lSi94jHm8KPkJAoQXCwA11w8Kxn-kSAjbm9pXpV1c3maBFHaAC1XKg3Of_WFOlCQPgyx4Uq0',
            'ednwG747T7msZ-1rf_k50m:APA91bHIZNMnCmHDVlZTZ_kkT2yKx-yWbNKXy-zpgnIJuZG3oDF0kxOUQPBFd_F8T3Pqep_CxENraEQM4BL2x8CqNiEhwiHftP496i0vwuzDAD8p51MsXgOyXOfL07vNX43vYajURK4R',
            'f0HS8uecTPqlRyuSXuDlyG:APA91bHZfBQWL6cRNhzvJl_eeF9VomLrvswUBQYsdVAj5dpGHqZqPwCHLGySxoWFd3BnjouQsrSNrPETPaStlltBiaxL-Xk1hZHLGk5qAhzWXPOTIj4dk3hpBqmVTc3uWUpxub63zji9',
            'fNc9MMj2Sl2N7owWjwHerQ:APA91bEjeCPvp8q1cZlU1pLu9ixqzzkAJC48tgkF-h6TdhMyNR_h_JrqygiLUlIJzPL4v2f712blcbbX7Px9wB5gDE6f4fUf6cpZES0QXuuBxgjQHeHjCub4dWmtrGcQwUboaZ3AzDxl',
            'eqgITqeDRdq4m8U6Ozz8bC:APA91bEBfV2uohutpyQE4II5VehvC1mZgtI3v0IFrdDQLf3aMaxNMbvUYwKFRooR-pvFKciXkM4KLrkEGIFDkzaxxRX_8LMFjyomnklFTyH5k0wB2mo593kNf3QOWqL79REjYnYEQBL8'
        ];

        $serverKey = 'AAAA1HPHLVg:APA91bEqi8JCGZfEV6CCEs-VCZpMX83_cWlUWGDqkayVzoR5uqhbJGXYX-DmuHSS-_fusEyLthoOEIjafEbx1-l4xzamf-q3-gV8QlXLG-xSa8HqxiS5WCvbayLLfjK_ww0zoPDraSGC'; // ADD SERVER KEY HERE PROVIDED BY FCM

        $data = [
            "registration_ids" => $FcmToken,
            "notification" => [
                "title" => "দেশের মাটিতে পা রাখলেন কামরুল আহসান ",
                "body" => "ami backend thaka bolsi",
                "image" => "http://www.kamrulgroup.com/assets/page-img/aboutmebrif.jpg"
            ]
        ];
        $encodedData = json_encode($data);

        $headers = [
            'Authorization:key=' . $serverKey,
            'Content-Type: application/json',
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);
        // Execute post
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
        // Close connection
        curl_close($ch);
        // FCM response
        dd($result);
    }
}
