<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LiveChat;
use App\Models\EventProfile;
use App\Models\Greeting;
use App\Models\LiveChatRegistration;
use App\Models\QnA;
use App\Models\QnaRegistration;
use App\Models\SuperStar;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;

class LiveChatController extends Controller
{
    public function livechat()
    {
        $livechats = LiveChat::where('star_id', auth('sanctum')->user()->id)->get();
        $pendingLiveChatNumber = LiveChat::where('star_approve_status', 0)->where('star_id', auth('sanctum')->user()->id)->count();

        return response()->json([
            'status' => 200,
            'message' => 'Ok',
            'livechats' => $livechats,
            'pendingLiveChatNumber' => $pendingLiveChatNumber,
        ]);
    }


    public function liveChatList($type)
    {
        $id = auth('sanctum')->user()->id;

        if ($type == 'all')
            $events = LiveChat::where([['star_id', $id], ['status', '>', 0]]);
        if ($type == 'pending')
            $events = LiveChat::where([['star_id', $id], ['status', '<', 1]]);
        if ($type == 'approved')
            $events = LiveChat::where([['star_id', $id], ['status', '>', 0], ['status', '<', 10]]);
        if ($type == 'completed')
            $events = LiveChat::where([['star_id', $id], ['status', 9]]);
        if ($type == 'rejected')
            $events = LiveChat::where([['star_id', $id], ['status', 11]]);

        return response()->json([
            'status' => 200,
            'events' => $events->latest()->get(),
            'count' => $events->count(),
        ]);
    }


    public function details($slug)
    {
        $event = LiveChat::where('slug', $slug)->first();

        return response()->json([
            'status' => 200,
            'message' => 'Ok',
            'event' => $event,
        ]);
    }


    public function slots($slug)
    {
        $event = LiveChat::where('slug', $slug)->first();
        $users = LiveChatRegistration::where('live_chat_id', $event->id)->get();

        return response()->json([
            'status' => 200,
            'message' => 'Ok',
            'users' => $users,
        ]);
    }

    public function setApproveLiveChat($id)
    {
        $approveLiveChat = LiveChat::find($id);
        $approveLiveChat->status = 1;
        $approveLiveChat->update();

        return response()->json([
            'status' => 200,
            'message' => 'Event Approved',
        ]);
    }

    public function deleteLiveChat($id)
    {
        $approveLiveChat = LiveChat::find($id);
        $approveLiveChat->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Ok',
        ]);
    }
    public function livechatListByDate($date)
    {
        $livechats = LiveChat::whereDate('date', Carbon::parse($date)->format('Y-m-d'))->where('star_id',  auth('sanctum')->user()->id)->get();
        return response()->json([
            'status' => 200,
            'message' => 'Ok',
            'livechats' => $livechats,
            'star_id' => auth('sanctum')->user()->id,
        ]);
    }

    public function sinlgeLiveChat($id)
    {
        $liveChat = LiveChat::find($id);

        return response()->json([
            'status' => 200,
            'message' => 'Ok',
            'liveChat' => $liveChat,
        ]);
    }

    public function registeredUserList($live_chat_slug)
    {
        $event = LiveChat::where('slug', $live_chat_slug)->first();
        $registeredLiveChats = LiveChatRegistration::where('live_chat_id', $event->id)->get();


        return response()->json([
            'status' => 200,
            'message' => 'Ok',
            'registeredLiveChats' => $registeredLiveChats,
            'event' => $event,
        ]);
    }

    public function add_by_admin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'star_id' => 'required',
            'title' => 'required|unique:live_chats',
            'image' => 'required',
            'description' => 'required|min:6',
            'instruction' => 'required|min:6',
            'date' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'registration_start_date' => 'required',
            'registration_end_date' => 'required',
            'fee' => 'required',
            'max_time' => 'required|min:1',
            'min_time' => 'required|min:1',
            'interval' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'validation_errors' => $validator->errors(),
            ]);
        } else {
            $superStar = SuperStar::where('star_id', $request->input('star_id'))->first();

            $liveChat = new LiveChat();
            $liveChat->title = $request->input('title');
            $liveChat->slug = Str::slug($request->input('title'));
            $liveChat->star_id = $request->input('star_id');
            $liveChat->category_id = $superStar->category_id;
            $liveChat->sub_category_id = $superStar->sub_category_id;
            $liveChat->admin_id = auth('sanctum')->user()->id;
            $liveChat->created_by_id = auth('sanctum')->user()->id;
            $liveChat->instruction = $request->input('instruction');
            $liveChat->description = $request->input('description');
            $liveChat->event_date = $request->input('date');
            $liveChat->start_time = $request->input('start_time');
            $liveChat->end_time = $request->input('end_time');
            $liveChat->registration_start_date = $request->input('registration_start_date');
            $liveChat->registration_end_date = $request->input('registration_end_date');
            $liveChat->fee = $request->input('fee');
            $liveChat->total_seat = $request->input('total_seat');
            $liveChat->max_time = $request->input('max_time');
            $liveChat->min_time = $request->input('min_time');
            $liveChat->interval = $request->input('interval');

            if ($request->hasfile('image')) {
                $destination = $liveChat->banner;
                if (File::exists($destination)) {
                    File::delete($destination);
                }
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                $filename = 'uploads/images/live_chat/' . time() . '.' . $extension;

                Image::make($file)->resize(900, 400)->save($filename, 100);
                $liveChat->banner = $filename;
            }

            $liveChat->save();


            return response()->json([
                'status' => 200,
                'message' => 'Live Session Added',
            ]);
        }
    }


    public function update_by_admin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required|min:5',
            'instruction' => 'required|min:5',
            'date' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'registration_start_date' => 'required',
            'registration_end_date' => 'required',
            'fee' => 'required',
            'max_time' => 'required|min:1',
            'min_time' => 'required|min:1',
            'interval' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'validation_errors' => $validator->errors(),
            ]);
        } else {
            $liveChat = LiveChat::find($request->id);
            $liveChat->title = $request->input('title');
            $liveChat->slug = Str::slug($request->input('title'));
            $liveChat->description = $request->input('description');
            $liveChat->instruction = $request->input('instruction');
            $liveChat->event_date = $request->input('date');
            $liveChat->start_time = $request->input('start_time');
            $liveChat->end_time = $request->input('end_time');
            $liveChat->registration_start_date = $request->input('registration_start_date');
            $liveChat->registration_end_date = $request->input('registration_end_date');
            $liveChat->fee = $request->input('fee');
            $liveChat->total_seat = $request->input('total_seat');
            $liveChat->max_time = $request->input('max_time');
            $liveChat->min_time = $request->input('min_time');
            $liveChat->interval = $request->input('interval');

            if ($request->hasfile('image')) {
                $destination = $liveChat->banner;
                if (File::exists($destination)) {
                    File::delete($destination);
                }
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                $filename = 'uploads/images/live_chat/' . time() . '.' . $extension;

                Image::make($file)->resize(900, 400)->save($filename, 100);
                $liveChat->banner = $filename;
            }
            $liveChat->update();

            return response()->json([
                'status' => 200,
                'event' => $liveChat,
                'message' => 'Live Session Updated',
            ]);
        }
    }




    /// Admin Method ....
    public function admin_livechat()
    {
        $livechats = LiveChat::where('star_id', auth('sanctum')->user()->id)->get();
        $pendingLiveChatNumber = LiveChat::where('star_approve_status', 0)->where('admin_id', auth('sanctum')->user()->id)->count();

        return response()->json([
            'status' => 200,
            'message' => 'Ok',
            'livechats' => $livechats,
            'pendingLiveChatNumber' => $pendingLiveChatNumber,
        ]);
    }

    public function admin_sinlgeLiveChat($id)
    {
        $liveChat = LiveChat::find($id);

        return response()->json([
            'status' => 200,
            'message' => 'Ok',
            'liveChat' => $liveChat,
        ]);
    }




    public function admin_livechatListByDate($date)
    {
        $livechats = LiveChat::whereDate('date', Carbon::parse($date)->format('Y-m-d'))->where('admin_id',  auth('sanctum')->user()->id)->get();
        return response()->json([
            'status' => 200,
            'message' => 'Ok',
            'livechats' => $livechats,
            'star_id' => auth('sanctum')->user()->id,
        ]);
    }

    public function admin_registeredUserList($live_chat_id)
    {
        $registeredLiveChats = LiveChatRegistration::where('live_chat_id', $live_chat_id)->get();

        return response()->json([
            'status' => 200,
            'message' => 'Ok',
            'registeredLiveChats' => $registeredLiveChats,
        ]);
    }



    public function pending_list()
    {
        $events = LiveChat::where([['admin_id', auth('sanctum')->user()->id], ['status', '<', 2]]);

        return response()->json([
            'status' => 200,
            'events' => $events->latest()->get(),
            'count' => $events->count(),
        ]);
    }

    public function live_list()
    {
        $events = LiveChat::where([['admin_id', auth('sanctum')->user()->id], ['status', 2]]);

        return response()->json([
            'status' => 200,
            'events' => $events->latest()->get(),
            'count' => $events->count(),
        ]);
    }

    public function completed_list()
    {
        $events = LiveChat::where([['admin_id', auth('sanctum')->user()->id], ['status', 9]]);

        return response()->json([
            'status' => 200,
            'events' => $events->latest()->get(),
            'count' => $events->count(),
        ]);
    }



    public function detials($id)
    {
        $event = LiveChat::find($id);

        return response()->json([
            'status' => 200,
            'message' => 'Ok',
            'event' => $event,
        ]);
    }

    public function count()
    {
        $approved = LiveChat::where([['created_by_id', auth('sanctum')->user()->id], ['status', 1]])->count();
        $pending = LiveChat::where([['created_by_id', auth('sanctum')->user()->id], ['status', null]])->count();

        return response()->json([
            'status' => 200,
            'approved' => $approved,
            'pending' => $pending,
        ]);
    }

    public function count2()
    {
        $approved = LiveChat::where('star_id', auth('sanctum')->user()->id)->where('star_approve_status', 1)->count();
        $pending = LiveChat::where('star_id', auth('sanctum')->user()->id)->where('star_approve_status', 0)->count();

        return response()->json([
            'status' => 200,
            'approved' => $approved,
            'pending' => $pending,
        ]);
    }



    public function profile_create(Request $request)
    {
        $liveChat = new EventProfile();
        $liveChat->title = $request->input('title');
        $liveChat->created_by_id = auth('sanctum')->user()->id;
        $liveChat->description = $request->input('description');
        $liveChat->cost = $request->input('cost');
        $liveChat->type = 'livechat';

        if ($request->hasfile('banner')) {
            $destination = $liveChat->banner;
            if (File::exists($destination)) {
                File::delete($destination);
            }
            $file = $request->file('banner');
            $extension = $file->getClientOriginalExtension();
            $filename = 'uploads/images/live_chat/' . time() . '.' . $extension;

            Image::make($file)->resize(900, 400)->save($filename, 100);
            $liveChat->banner = $filename;
        }

        $liveChat->save();

        return response()->json([
            'status' => 200,
            'message' => 'Live Chat Profile Created',
        ]);
    }



    public function profile()
    {
        $event = EventProfile::where('created_by_id', auth('sanctum')->user()->id)->first();

        return response()->json([
            'status' => 200,
            'message' => 'Ok',
            'event' => $event,
        ]);
    }

    public function greetingsCreateStatus()
    {
        // $greeting = Greeting::where('created_by_id', 3)->first();
        return response()->json([
            'status' => 200,
            'greeting' => 45,
            'message' => 'alredy have',
        ]);
    }

    // user section
    public function userAll()
    {
        $event = LiveChat::all();

        return response()->json([
            'status' => 200,
            'message' => 'Ok',
            'event' => $event,
        ]);
    }



    // Star Controlling Method
    public function add_by_star(Request $request)
    {
        // return $request->all();

        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:live_chats',
            // 'image' => 'required',
            'description' => 'required|min:6',
            'instruction' => 'required|min:6',
            'date' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'registration_start_date' => 'required',
            'registration_end_date' => 'required',
            'fee' => 'required',
            'max_time' => 'required|min:1',
            'interval' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'validation_errors' => $validator->errors(),
            ]);
        } else {
            $superStar = SuperStar::where('star_id', auth('sanctum')->user()->id)->first();

            $liveChat = new LiveChat();
            $liveChat->title = $request->input('title');
            $liveChat->slug = Str::slug($request->input('title'));
            $liveChat->star_id = auth('sanctum')->user()->id;
            $liveChat->category_id = $superStar->category_id;
            $liveChat->sub_category_id = $superStar->sub_category_id;
            $liveChat->admin_id = auth('sanctum')->user()->parent_user;
            $liveChat->created_by_id = auth('sanctum')->user()->id;
            $liveChat->instruction = $request->input('instruction');
            $liveChat->description = $request->input('description');
            $liveChat->event_date = Carbon::parse($request->input('date'));
            $liveChat->start_time = Carbon::parse($request->input('start_time'));
            $liveChat->end_time = Carbon::parse($request->input('end_time'));
            $liveChat->registration_start_date = Carbon::parse($request->input('registration_start_date'));
            $liveChat->registration_end_date = Carbon::parse($request->input('registration_end_date'));
            $liveChat->fee = $request->input('fee');
            $liveChat->max_time = $request->input('max_time');
            $liveChat->min_time = $request->input('min_time');
            $liveChat->interval = $request->input('interval');
            $liveChat->status = 1;

            if ($request->hasfile('image')) {
                $destination = $liveChat->banner;
                if (File::exists($destination)) {
                    File::delete($destination);
                }
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                $filename = 'uploads/images/live_chat/' . time() . '.' . $extension;

                Image::make($file)->resize(900, 400)->save($filename, 100);
                $liveChat->banner = $filename;
            }
            if ($request->image_path) {
                $liveChat->banner = $request->image_path;
            }

            $liveChat->save();


            return response()->json([
                'status' => 200,
                'message' => 'Live Session Added',
            ]);
        }
    }

    public function update_by_star(Request $request)
    {
        // return $request->all();

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required|min:5',
            'instruction' => 'required|min:5',
            'date' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'registration_start_date' => 'required',
            'registration_end_date' => 'required',
            'fee' => 'required',
            'max_time' => 'required|min:1',
            'min_time' => 'required|min:1',
            'interval' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'validation_errors' => $validator->errors(),
            ]);
        } else {
            $liveChat = LiveChat::find($request->id);
            $liveChat->title = $request->title;
            $liveChat->slug = Str::slug($request->title);
            $liveChat->description = $request->description;
            $liveChat->instruction = $request->instruction;
            $liveChat->event_date = Carbon::parse($request->date);

            $liveChat->start_time = Carbon::parse($request->start_time);
            $liveChat->end_time = Carbon::parse($request->end_time);
            $liveChat->registration_start_date = Carbon::parse($request->registration_start_date);
            $liveChat->registration_end_date = Carbon::parse($request->registration_end_date);
            $liveChat->fee = $request->fee;
            $liveChat->total_seat = $request->total_seat;
            $liveChat->max_time = $request->max_time;
            $liveChat->min_time = $request->min_time;
            $liveChat->interval = $request->interval;


            if ($request->hasfile('image')) {
                $destination = $liveChat->banner;
                if (File::exists($destination)) {
                    File::delete($destination);
                }
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                $filename = 'uploads/images/live_chat/' . time() . '.' . $extension;

                Image::make($file)->resize(900, 400)->save($filename, 100);
                $liveChat->banner = $filename;
            }

            if ($request->new_path) {
                $liveChat->banner = $request->new_path;
            }
            $liveChat->update();
            return response()->json([
                'status' => 200,
                'event' => $liveChat,
                'message' => 'Live Session Updated',
            ]);
        }
    }

    public function set_reject_by_star($id)
    {
        $event = LiveChat::find($id);
        $event->status = 11;
        $event->update();

        return response()->json([
            'status' => 200,
            'message' => 'Event has been rejected!',
        ]);
    }
}
