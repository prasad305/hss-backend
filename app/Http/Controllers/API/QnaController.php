<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\QnA;
use App\Models\QnaRegistration;
use App\Models\Wallet;
use App\Models\Activity;
use App\Models\SuperStar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;
use Auth;
use App\Models\LiveChatRegistration;
use App\Models\LiveChat;
use App\Models\LearningSession;
use App\Models\LearningSessionRegistration;
use App\Models\Greeting;
use App\Models\GreetingsRegistration;
use App\Models\MeetupEvent;
use App\Models\MeetupEventRegistration;
use App\Mail\PostNotification;
use Illuminate\Support\Facades\Mail;


class QnaController extends Controller
{
    public function qnaWalletStore(Request $request)
    {
        // return $request->all();

        if ($request->event_type == 'qna') {
            $event = QnA::find($request->eventId);

            $eventRegistration = new QnaRegistration();

            $walletData = Wallet::where('user_id', Auth::user()->id)->first();
            $walletData->qna = $walletData->qna - 1;
            $walletData->save();

            $eventRegistration->qna_id = $event->id;
            $eventRegistration->user_id = Auth::user()->id;
            $eventRegistration->card_holder_name = Auth::user()->first_name . " " . Auth::user()->last_name;


            $eventRegistration->amount = $request->fee;
            $eventRegistration->payment_status = 1;
            $eventRegistration->payment_method = 'wallet';
            $eventRegistration->payment_date = Carbon::now();
            $eventRegistration->room_id = '-' . Str::random(19);
            $eventRegistration->publish_status = 1;
            $eventRegistration->qna_date = $event->event_date;
            $eventRegistration->qna_start_time = Carbon::parse($request->start_time)->format('H:i:s');
            $eventRegistration->qna_end_time = Carbon::parse($request->end_time)->format('H:i:s');
            $eventRegistration->save();
            $event->available_start_time = (Carbon::parse($request->end_time)->addMinutes($event->interval + 1)->format('H:i:s')) <= Carbon::parse($event->end_time)->format('H:i:s') ? Carbon::parse($request->end_time)->addMinutes($event->interval + 1)->format('H:i:s') : Carbon::parse($event->end_time)->format('H:i:s');
            $event->update();

            $activity = new Activity();
            $activity->type = 'qna';
            $activity->user_id = Auth::user()->id;
            $activity->event_id = $event->id;
            $activity->event_registration_id = $eventRegistration->id;
            $activity->save();
            $userWallet = Wallet::where('user_id', Auth::user()->id)->first();
            return response()->json([
                'status' => 200,
                'message' => 'QnA Successfully Registered ',
                'waletInfo' => $userWallet,
            ]);
        }

        if ($request->event_type == 'livechat') {
            $event = LiveChat::find($request->eventId);

            $eventRegistration = new LiveChatRegistration();

            $walletData = Wallet::where('user_id', Auth::user()->id)->first();
            $walletData->live_chats = $walletData->live_chats - 1;
            $walletData->save();

            $eventRegistration->live_chat_id = $event->id;
            $eventRegistration->user_id = Auth::user()->id;
            $eventRegistration->card_holder_name = Auth::user()->first_name . " " . Auth::user()->last_name;
            $eventRegistration->amount = $request->fee;
            $eventRegistration->payment_status = 1;
            $eventRegistration->publish_status = 1;
            $eventRegistration->payment_method = 'wallet';
            $eventRegistration->payment_date = Carbon::now();
            $eventRegistration->room_id = createRoomID();
            $eventRegistration->live_chat_date = $event->event_date;
            $eventRegistration->live_chat_start_time = Carbon::parse($request->start_time)->format('H:i:s');
            $eventRegistration->live_chat_end_time = Carbon::parse($request->end_time)->format('H:i:s');
            // $activity->type = 'qna';
            $eventRegistration->save();

            $event->available_start_time = (Carbon::parse($request->end_time)->addMinutes($event->interval + 1)->format('H:i:s')) <= Carbon::parse($event->end_time)->format('H:i:s') ? Carbon::parse($request->end_time)->addMinutes($event->interval + 1)->format('H:i:s') : Carbon::parse($event->end_time)->format('H:i:s');
            $event->update();

            $activity = new Activity();
            $activity->type = 'livechat';
            $activity->user_id = Auth::user()->id;
            $activity->event_id = $event->id;
            $activity->event_registration_id = $eventRegistration->id;
            $activity->save();
            $userWallet = Wallet::where('user_id', Auth::user()->id)->first();
            return response()->json([
                'status' => 200,
                'message' => 'LiveChat Successfully Registered ',
                'waletInfo' => $userWallet,
            ]);
        }


        if ($request->event_type == 'learningSession') {
            $event = LearningSession::find($request->eventId);

            $eventRegistration = new LearningSessionRegistration();

            $walletData = Wallet::where('user_id', Auth::user()->id)->first();
            $walletData->learning_session = $walletData->learning_session - 1;
            $walletData->save();

            $eventRegistration->learning_session_id = $event->id;
            $eventRegistration->user_id = Auth::user()->id;
            $eventRegistration->card_holder_name = Auth::user()->first_name . " " . Auth::user()->last_name;
            $eventRegistration->amount = $request->fee;
            $eventRegistration->payment_status = 1;
            $eventRegistration->publish_status = 1;
            $eventRegistration->payment_method = 'wallet';
            $eventRegistration->payment_date = Carbon::now();
            $eventRegistration->save();

            $activity = new Activity();
            $activity->type = 'learningSession';
            $activity->user_id = Auth::user()->id;
            $activity->event_id = $event->id;
            $activity->event_registration_id = $eventRegistration->id;
            $activity->save();

            $userWallet = Wallet::where('user_id', Auth::user()->id)->first();

            return response()->json([
                'status' => 200,
                'message' => 'Learning Session Successfully Registered ',
                'waletInfo' => $userWallet
            ]);
        }


        if ($request->event_type == 'greeting') {
            $greeting =  Wallet::where('user_id', auth('sanctum')->user()->id)->first('greetings');
            $activity = new Activity();
            $activity->type = 'greeting';
            $activity->user_id = Auth::user()->id;
            $eventRegistration = GreetingsRegistration::where([['user_id', auth('sanctum')->user()->id], ['greeting_id', $request->eventId]])->first();
            $eventRegistration->payment_status = 1;
            $eventRegistration->status = 1;
            $eventRegistration->payment_method = 'wallet';
            $eventRegistration->save();
            Wallet::where('user_id', auth('sanctum')->user()->id)->update(['greetings' => $greeting->greetings - 1]);
            $activity->event_id = $greeting->id;
            $activity->event_registration_id = $eventRegistration->id;
            $activity->save();
            $userWallet = Wallet::where('user_id', Auth::user()->id)->first();
            return response()->json([
                'status' => 200,
                'message' => 'Greeting Successfully Registered',
                'waletInfo' => $userWallet,
                'eventRegistration' => $eventRegistration
            ]);


            // $event = Greeting::find($request->eventId);
            // $eventRegistration = GreetingsRegistration::where('user_id', Auth::user()->id)->where('id', $request->greetingId)->first();

            // $walletData = Wallet::where('user_id', Auth::user()->id)->first();
            // $walletData->greetings = $walletData->greetings - 1;
            // $walletData->save();

            // $eventRegistration->card_holder_name = Auth::user()->first_name . " " . Auth::user()->last_name;
            // $eventRegistration->amount = $event->cost;
            // $eventRegistration->payment_status = 1;
            // $eventRegistration->status = 1;
            // $eventRegistration->payment_method = 'wallet';
            // $eventRegistration->payment_date = Carbon::now();
            // $eventRegistration->save();

            // $activity = new Activity();
            // $activity->type = 'greeting';
            // $activity->user_id = Auth::user()->id;
            // $activity->event_id = $event->id;
            // $activity->event_registration_id = $eventRegistration->id;
            // $activity->save();
            // $userWallet = Wallet::where('user_id', Auth::user()->id)->first();
            // return response()->json([
            //     'status' => 200,
            //     'message' => 'Greeting Successfully Registered',
            //     'waletInfo' => $userWallet,
            //     'eventRegistration' => $eventRegistration
            // ]);
        }


        if ($request->event_type == 'meetup') {
            $event = MeetupEvent::find($request->eventId);

            $eventRegistration = new MeetupEventRegistration();

            $walletData = Wallet::where('user_id', Auth::user()->id)->first();
            $walletData->meetup = $walletData->meetup - 1;
            $walletData->save();

            $eventRegistration->meetup_event_id = $event->id;
            $eventRegistration->user_id = Auth::user()->id;
            $eventRegistration->card_holder_name = Auth::user()->first_name . " " . Auth::user()->last_name;
            $eventRegistration->amount = $event->fee;
            $eventRegistration->payment_status = 1;
            // $eventRegistration->status = 1;
            $eventRegistration->payment_method = 'wallet';
            $eventRegistration->payment_date = Carbon::now();
            $eventRegistration->save();

            $activity = new Activity();
            $activity->type = 'meetup';
            $activity->user_id = Auth::user()->id;
            $activity->event_id = $event->id;
            $activity->event_registration_id = $eventRegistration->id;
            $activity->save();

            $userWallet = Wallet::where('user_id', Auth::user()->id)->first();

            return response()->json([
                'status' => 200,
                'message' => 'Meetup Events Successfully Registered',
                'waletInfo' => $userWallet,
            ]);
        }
    }
    public function allInOneMobileQna()
    {

        try {
            $rejected = QnA::where([['admin_id', auth('sanctum')->user()->id], ['star_approval', 2]])->count();
            $completed = QnA::where([['star_id', auth('sanctum')->user()->id], ['status', 9]])->count();
            $pending = QnA::where([['star_id', auth('sanctum')->user()->id], ['star_approval', 0]])->count();
            $live = QnA::where([['star_id', auth('sanctum')->user()->id], ['star_approval', 1]])->count();
            $all = QnA::where([['star_id', auth('sanctum')->user()->id]])->count();
        } catch (\Throwable $th) {
            return $th;
        }


        return response()->json([
            'status' => 200,
            'all' => $all,
            'rejected' => $rejected,
            'completed' => $completed,
            'pending' => $pending,
            'live' => $live,
            'message' => 'Success',
        ]);
    }
    public function add_qna(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'star_id' => 'required',
            'title' => 'required|unique:qn_a_s',
            'image' => 'required',
            'instruction' => 'required|min:5',
            'description' => 'required|min:5',
            'event_date' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'registration_start_date' => 'required',
            'registration_end_date' => 'required',
            'fee' => 'required',
            // 'question_quantity' => 'required',
            'min_time' => 'required|min:1',
            'max_time' => 'required|min:1',
            'time_interval' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'validation_errors' => $validator->errors(),
            ]);
        } else {
            $superStar = SuperStar::where('star_id', $request->input('star_id'))->first();

            $qna = new QnA();
            $qna->title = $request->input('title');
            $qna->slug = Str::slug($request->input('title'));
            $qna->star_id = $request->input('star_id');
            $qna->category_id = $superStar->category_id;
            $qna->sub_category_id = $superStar->sub_category_id;
            $qna->admin_id = auth('sanctum')->user()->id;
            $qna->created_by_id = auth('sanctum')->user()->id;
            $qna->description = $request->input('description');
            $qna->instruction = $request->input('instruction');
            $qna->event_date = $request->input('event_date');
            $qna->start_time = Carbon::parse($request->input('start_time'));
            $qna->end_time = Carbon::parse($request->input('end_time'));
            $qna->registration_start_date = $request->input('registration_start_date');
            $qna->registration_end_date = $request->input('registration_end_date');
            $qna->fee = $request->input('fee');
            // $qna->question_quantity = $request->input('question_quantity');
            $qna->min_time = $request->input('min_time');
            $qna->max_time = $request->input('max_time');
            $qna->time_interval = $request->input('time_interval');

            if ($request->hasfile('image')) {
                $destination = $qna->banner;
                if (File::exists($destination)) {
                    File::delete($destination);
                }
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                $filename = 'uploads/images/qna/' . time() . '.' . $extension;

                Image::make($file)->resize(900, 400)->save($filename, 100);
                $qna->banner = $filename;
            }

            if ($request->hasFile('video')) {
                $destination = $qna->video;
                if (File::exists($destination)) {
                    File::delete($destination);
                }

                $file        = $request->file('video');
                $path        = 'uploads/videos/qna';
                $file_name   = time() . rand('0000', '9999') . '.' . $file->getClientOriginalName();
                $file->move($path, $file_name);
                $qna->video = $path . '/' . $file_name;
            }

            $adminAddResult = $qna->save();
            if($adminAddResult){
                $starInfo = getStarInfo($qna->star_id);
                $senderInfo = getAdminInfo($qna->admin_id);

                SendMail($starInfo->email,$qna,$senderInfo);
            }

            return response()->json([
                'status' => 200,
                'message' => 'QnA Successfully Added ',
                'qna' => $qna,
            ]);
        }
    }
    public function admin_update_Qna(Request $request)
    {
        // return $request->all();
        $qna = QnA::where('slug', $request->slug)->first();

        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:qn_a_s,title,'.$qna->id,
            'event_date' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'instruction' => 'required|min:5',
            'description' => 'required|min:5',
            'registration_start_date' => 'required',
            'registration_end_date' => 'required',
            'fee' => 'required',
            // 'question_quantity' => 'required',
            'min_time' => 'required|min:1',
            'max_time' => 'required|min:1',
            'time_interval' => 'required',
        ],[
            'title.unique' => 'This title already exist',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'validation_errors' => $validator->errors(),
            ]);
        } else {

            $superStar = SuperStar::where('star_id', $request->input('star_id'))->first();

            
            $qna->title = $request->input('title');
            $qna->slug = Str::slug($request->input('title'));
            $qna->star_id = $request->star_id;
            $qna->category_id =  $superStar->category_id;
            $qna->sub_category_id =  $superStar->sub_category_id;
            $qna->admin_id = auth('sanctum')->user()->id;
            $qna->created_by_id = auth('sanctum')->user()->id;
            $qna->description = $request->input('description');
            $qna->instruction = $request->input('instruction');
            $qna->event_date = $request->input('event_date');
            $qna->start_time = Carbon::parse($request->input('start_time'));
            $qna->end_time = Carbon::parse($request->input('end_time'));
            $qna->registration_start_date = $request->input('registration_start_date');
            $qna->registration_end_date = $request->input('registration_end_date');
            $qna->fee = $request->input('fee');
            // $qna->question_quantity = $request->input('question_quantity');
            $qna->min_time = $request->input('min_time');
            $qna->max_time = $request->input('max_time');
            $qna->time_interval = $request->input('time_interval');

            if ($request->hasfile('image')) {
                $destination = $qna->banner;
                if (File::exists($destination)) {
                    File::delete($destination);
                }
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                $filename = 'uploads/images/qna/' . time() . '.' . $extension;

                Image::make($file)->resize(900, 400)->save($filename, 100);
                $qna->banner = $filename;
            }
            if ($request->hasFile('video')) {
                $destination = $qna->video;
                if (File::exists($destination)) {
                    File::delete($destination);
                }

                $file        = $request->file('video');
                $path        = 'uploads/videos/qna';
                $file_name   = time() . rand('0000', '9999') . '.' . $file->getClientOriginalName();
                $file->move($path, $file_name);
                $qna->video = $path . '/' . $file_name;
            }

            $qna->update();

            // return $request->input('description');
            return response()->json([
                'status' => 200,
                'message' => 'QnA Updated !',
            ]);
        }
    }
    public function pendingQna()
    {
        $events = QnA::where([['admin_id', auth('sanctum')->user()->id], ['status', '<', 2], ['star_approval', '!=', 2]]);

        return response()->json([
            'status' => 200,
            'events' => $events->latest()->get(),
            'count' => $events->count(),
        ]);
    }
    public function count()
    {
        $approved = QnA::where([['admin_id', auth('sanctum')->user()->id], ['status', 2]])->count();
        $pending = QnA::where([['admin_id', auth('sanctum')->user()->id], ['status', '<', 2], ['star_approval', '!=', 2]])->count();

        return response()->json([
            'status' => 200,
            'approved' => $approved,
            'pending' => $pending,
        ]);
    }
    public function details($slug)
    {
        $event = QnA::where('slug', $slug)->first();
        return response()->json([
            'status' => 200,
            'message' => 'Ok',
            'event' => $event,
        ]);
    }
    public function liveQnalist()
    {
        $events = QnA::where([['admin_id', auth('sanctum')->user()->id], ['status', 2]]);

        return response()->json([
            'status' => 200,
            'events' => $events->latest()->get(),
            'count' => $events->count(),
        ]);
    }
    public function qna_completed()
    {
        $events = QnA::where([['admin_id', auth('sanctum')->user()->id], ['status', 9]]);

        return response()->json([
            'status' => 200,
            'events' => $events->latest()->get(),
            'count' => $events->count(),
        ]);
    }
    public function qna_rejected()
    {
        $events = QnA::where([['admin_id', auth('sanctum')->user()->id], ['star_approval', 2]]);

        return response()->json([
            'status' => 200,
            'events' => $events->latest()->get(),
            'count' => $events->count(),
        ]);
    }
    public function registeredList($slug)
    {
        $event = QnA::where('slug', $slug)->first();
        $users = QnaRegistration::where([['qna_id', $event->id], ['payment_status', 1]])->get();

        return response()->json([
            'status' => 200,
            'message' => 'Ok',
            'users' => $users,
        ]);
    }


    // Star Section

    public function star_add_qna_mobile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:qn_a_s',
            'event_date' => 'required',
            'instruction' => 'required|min:5',
            'description' => 'required|min:5',
            'start_time' => 'required',
            'end_time' => 'required',
            'registration_start_date' => 'required',
            'registration_end_date' => 'required',
            'fee' => 'required',
            'min_time' => 'required|min:1',
            'max_time' => 'required|min:1',
            'time_interval' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'validation_errors' => $validator->errors(),
            ]);
        } else {

            $qna = new QnA();
            $qna->title = $request->input('title');
            $qna->slug = Str::slug($request->input('title'));
            $qna->star_id = auth('sanctum')->user()->id;
            $qna->category_id =  auth()->user()->category_id;
            $qna->sub_category_id =  auth()->user()->sub_category_id;
            $qna->admin_id = auth()->user()->parent_user;
            $qna->created_by_id = auth('sanctum')->user()->id;
            $qna->description = $request->input('description');
            $qna->instruction = $request->input('instruction');
            $qna->event_date = Carbon::parse($request->input('event_date'));
            $qna->start_time = Carbon::parse($request->input('start_time'));
            $qna->end_time = Carbon::parse($request->input('end_time'));
            $qna->registration_start_date = Carbon::parse($request->input('registration_start_date'));
            $qna->registration_end_date = Carbon::parse($request->input('registration_end_date'));
            $qna->fee = $request->input('fee');
            $qna->star_approval = 1;
            $qna->min_time = $request->input('min_time');
            $qna->max_time = $request->input('max_time');
            $qna->time_interval = $request->input('time_interval');

            // Upload Banner started

            if ($request->banner['type']) {
                try {
                    $originalExtension = str_ireplace("image/", "", $request->banner['type']);

                    $folder_path       = 'uploads/images/qna/';

                    $image_new_name    = Str::random(20) . '-' . now()->timestamp . '.' . $originalExtension;
                    $decodedBase64 = $request->banner['data'];

                    Image::make($decodedBase64)->save($folder_path . $image_new_name);
                    $location = $folder_path . $image_new_name;
                    $qna->banner = $location;
                } catch (\Exception $exception) {
                    return response()->json([
                        "error" => $exception->getMessage(),
                        "status" => "from image",
                    ]);
                }
            }

            // Upload Banner ended


            // Upload Video started

            if ($request->video['type']) {
                try {
                    $originalExtension = str_ireplace("video/", "", $request->video['type']);

                    $folder_path       = 'uploads/videos/qna/';

                    $image_new_name    = Str::random(20) . '-' . now()->timestamp . '.' . $originalExtension;
                    $decodedBase64 = $request->video['data'];
                    $videoPath = $folder_path . $image_new_name;
                    file_put_contents($videoPath, base64_decode($decodedBase64, true));

                    $qna->video = $videoPath;
                } catch (\Exception $exception) {
                    return response()->json([
                        "error" => $exception->getMessage(),
                        "status" => "from video",
                    ]);
                }
            }

            // Upload Video ended

            $addFromMobile = $qna->save();
            if($addFromMobile){
                $managerInfo = getManagerInfoFromCategory(auth('sanctum')->user()->category_id);
                $adminInfo = getAdminInfo(auth('sanctum')->user()->parent_user);
                $senderInfo = getStarInfo(auth('sanctum')->user()->id);

                SendMail($adminInfo->email,$qna,$senderInfo);
                SendMail($managerInfo->email,$qna,$senderInfo);
           }




            return response()->json([
                'status' => 200,
                'message' => 'QnA Successfully Added ',
            ]);
        }
    }

    public function star_add_qna(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:qn_a_s',
            // 'image' => 'required',
            'event_date' => 'required',
            'instruction' => 'required|min:5',
            'description' => 'required|min:5',
            'start_time' => 'required',
            'end_time' => 'required',
            'registration_start_date' => 'required',
            'registration_end_date' => 'required',
            'fee' => 'required',
            // 'question_quantity' => 'required',
            'min_time' => 'required|min:1',
            'max_time' => 'required|min:1',
            'time_interval' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'validation_errors' => $validator->errors(),
            ]);
        } else {
            // $superStar = SuperStar::where('star_id', $request->input('star_id'))->first();

            $qna = new QnA();
            $qna->title = $request->input('title');
            $qna->slug = Str::slug($request->input('title'));
            $qna->star_id = auth('sanctum')->user()->id;
            $qna->category_id =  auth()->user()->category_id;
            $qna->sub_category_id =  auth()->user()->sub_category_id;
            $qna->admin_id = auth()->user()->parent_user;
            $qna->created_by_id = auth('sanctum')->user()->id;
            $qna->description = $request->input('description');
            $qna->instruction = $request->input('instruction');
            $qna->event_date = Carbon::parse($request->input('event_date'));
            $qna->start_time = Carbon::parse($request->input('start_time'));
            $qna->end_time = Carbon::parse($request->input('end_time'));
            $qna->registration_start_date = Carbon::parse($request->input('registration_start_date'));
            $qna->registration_end_date = Carbon::parse($request->input('registration_end_date'));
            $qna->fee = $request->input('fee');
            $qna->star_approval = 1;
            // $qna->question_quantity = $request->input('question_quantity');
            $qna->min_time = $request->input('min_time');
            $qna->max_time = $request->input('max_time');
            $qna->time_interval = $request->input('time_interval');

            if ($request->hasfile('image')) {
                $destination = $qna->banner;
                if (File::exists($destination)) {
                    File::delete($destination);
                }
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                $filename = 'uploads/images/qna/' . time() . '.' . $extension;

                Image::make($file)->resize(900, 400)->save($filename, 100);
                $qna->banner = $filename;
            }
            if ($request->hasFile('video')) {
                $destination = $qna->video;
                if (File::exists($destination)) {
                    File::delete($destination);
                }

                $file        = $request->file('video');
                $path        = 'uploads/videos/qna';
                $file_name   = time() . rand('0000', '9999') . '.' . $file->getClientOriginalName();
                $file->move($path, $file_name);
                $qna->video = $path . '/' . $file_name;
            }

            if ($request->image_path) {
                $qna->banner = $request->image_path;
            }

            $starAddResult = $qna->save();
            if($starAddResult){
                $managerInfo = getManagerInfoFromCategory(auth('sanctum')->user()->category_id);
                $adminInfo = getAdminInfo(auth('sanctum')->user()->parent_user);
                $senderInfo = getStarInfo(auth('sanctum')->user()->id);

                SendMail($adminInfo->email,$qna,$senderInfo);
                SendMail($managerInfo->email,$qna,$senderInfo);
            }

            

            return response()->json([
                'status' => 200,
                'message' => 'QnA Successfully Added ',
            ]);
        }
    }
    public function update_Qna(Request $request)
    {
        // return $request->all();
        $qna = QnA::find($request->id);
        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:qn_a_s,title,'.$qna->id,
            'event_date' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'instruction' => 'required|min:5',
            'description' => 'required|min:5',
            'registration_start_date' => 'required',
            'registration_end_date' => 'required',
            'fee' => 'required',
            // 'question_quantity' => 'required',
            'min_time' => 'required|min:1',
            'max_time' => 'required|min:1',
            'time_interval' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'validation_errors' => $validator->errors(),
            ]);
        } else {

            
            $qna->title = $request->input('title');
            $qna->slug = Str::slug($request->input('title'));
            $qna->admin_id = auth()->user()->parent_user;
            $qna->description = $request->input('description');
            $qna->instruction = $request->input('instruction');
            $qna->event_date = Carbon::parse($request->event_date);
            $qna->start_time = Carbon::parse($request->start_time);
            $qna->end_time = Carbon::parse($request->end_time);
            $qna->registration_start_date = Carbon::parse($request->registration_start_date);
            $qna->registration_end_date = Carbon::parse($request->registration_end_date);
            $qna->fee = $request->input('fee');
            // $qna->question_quantity = $request->input('question_quantity');
            $qna->min_time = $request->input('min_time');
            $qna->max_time = $request->input('max_time');
            $qna->time_interval = $request->input('time_interval');

            if ($request->hasfile('image')) {
                $destination = $qna->banner;
                if (File::exists($destination)) {
                    File::delete($destination);
                }
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                $filename = 'uploads/images/qna/' . time() . '.' . $extension;

                Image::make($file)->resize(900, 400)->save($filename, 100);
                $qna->banner = $filename;
            }
            if ($request->hasFile('video')) {
                $destination = $qna->video;
                if (File::exists($destination)) {
                    File::delete($destination);
                }

                $file        = $request->file('video');
                $path        = 'uploads/videos/qna';
                $file_name   = time() . rand('0000', '9999') . '.' . $file->getClientOriginalName();
                $file->move($path, $file_name);
                $qna->video = $path . '/' . $file_name;
            }

            $qna->update();

            // return $request->input('description');
            return response()->json([
                'status' => 200,
                'message' => 'QnA Updated !',
            ]);
        }
    }

    public function star_pendingQna()
    {
        $events = QnA::where([['star_id', auth('sanctum')->user()->id], ['star_approval', 0]]);

        return response()->json([
            'status' => 200,
            'events' => $events->latest()->get(),
            'count' => $events->count(),
        ]);
    }
    public function star_count()
    {
        $approved = QnA::where([['star_id', auth('sanctum')->user()->id], ['star_approval', 1]])->count();
        $pending = QnA::where([['star_id', auth('sanctum')->user()->id], ['star_approval', 0]])->count();

        return response()->json([
            'status' => 200,
            'approved' => $approved,
            'pending' => $pending,
        ]);
    }
    public function qna_details($slug)
    {
        $event = QnA::where('slug', $slug)->first();
        return response()->json([
            'status' => 200,
            'message' => 'Ok',
            'event' => $event,
        ]);
    }
    public function star_liveQnalist()
    {
        $events = QnA::where([['star_id', auth('sanctum')->user()->id], ['star_approval', 1]]);

        return response()->json([
            'status' => 200,
            'events' => $events->latest()->get(),
            'count' => $events->count(),
        ]);
    }
    public function star_qna_completed()
    {
        $events = QnA::where([['star_id', auth('sanctum')->user()->id], ['status', 9]]);

        return response()->json([
            'status' => 200,
            'events' => $events->latest()->get(),
            'count' => $events->count(),
        ]);
    }
    public function setApprovedQna($id)
    {
        $approvedQna = QnA::find($id);
        $approvedQna->star_approval = 1;
        $approveStar = $approvedQna->update();
        if($approveStar){
            $managerInfo = getManagerInfoFromCategory(auth('sanctum')->user()->category_id);
            $senderInfo = getStarInfo(auth('sanctum')->user()->id);

            SendMail($managerInfo->email,$approvedQna,$senderInfo);
        }

       

        return response()->json([
            'status' => 200,
            'message' => 'Event Approved',
        ]);
    }
    public function setRejectedQna($id)
    {
        $rejectedQna = QnA::find($id);
        $rejectedQna->star_approval = 2;
        $rejectedQna->update();

        return response()->json([
            'status' => 200,
            'message' => 'Event Rejected',
        ]);
    }
    public function QnaRegisteredList($slug)
    {
        $event = QnA::where('slug', $slug)->first();
        $users = QnaRegistration::where([['qna_id', $event->id], ['payment_status', 1]])->get();

        return response()->json([
            'status' => 200,
            'message' => 'Ok',
            'users' => $users,
        ]);
    }
    /**
     * enroll user status update
     */
    public function QnaUserStatusUpdate($id)
    {

        $enrollUser = QnaRegistration::find($id);
        $enrollUser->publish_status = 0;
        $enrollUser->update();

        return response()->json([
            'status' => 200,
            'message' => 'register user status update successfully',
        ]);
    }
}
