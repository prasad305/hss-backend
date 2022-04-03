<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LiveChat;
use App\Models\EventProfile;
use App\Models\Greeting;
use App\Models\LiveChatRegistration;
use App\Models\SuperStar;
use Carbon\Carbon;
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
    public function pendingLiveChat()
    {
        $pendingLiveChats = LiveChat::where('star_id', auth('sanctum')->user()->id)->where('star_approve_status', 0)->latest()->get();
        $pendingLiveChatNumber = LiveChat::where('star_approve_status', 0)->where('star_id', auth('sanctum')->user()->id)->count();

        return response()->json([
            'status' => 200,
            'message' => 'Ok',
            'pendingLiveChats' => $pendingLiveChats,
            'pendingLiveChatNumber' => $pendingLiveChatNumber,
        ]);
    }

    public function approveLiveChat()
    {
        $approveLiveChats = LiveChat::where('star_id', auth('sanctum')->user()->id)->where('star_approve_status', 1)->latest()->get();
        $pendingLiveChatNumber = LiveChat::where('star_approve_status', 0)->where('star_id', auth('sanctum')->user()->id)->count();

        return response()->json([
            'status' => 200,
            'message' => 'Ok',
            'approveLiveChats' => $approveLiveChats,
            'pendingLiveChatNumber' => $pendingLiveChatNumber,
        ]);
    }

    public function details($id)
    {
        $event = LiveChat::find($id);

        return response()->json([
            'status' => 200,
            'message' => 'Ok',
            'event' => $event,
            'details' => '"' . $event->description . '"',
        ]);
    }


    public function setApproveLiveChat($id)
    {
        $approveLiveChat = LiveChat::find($id);
        $approveLiveChat->star_approve_status = 1;
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

    public function registeredUserList($live_chat_id)
    {
        $event = LiveChat::find($live_chat_id);
        $registeredLiveChats = LiveChatRegistration::where('live_chat_id', $live_chat_id)->get();


        return response()->json([
            'status' => 200,
            'message' => 'Ok',
            'registeredLiveChats' => $registeredLiveChats,
            'event' => $event,
        ]);
    }

    public function add_live_session(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:live_chats,title',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'validation_errors' => $validator->errors(),
            ]);
        } else {
            $superStar = SuperStar::where('star_id', $request->input('star_id'))->first();

            $liveChat = new LiveChat();
            $liveChat->title = $request->input('title');
            $liveChat->star_id = $request->input('star_id');
            $liveChat->category_id = $superStar->category_id;
            $liveChat->admin_id = $superStar->admin_id;
            $liveChat->created_by_id = auth('sanctum')->user()->id;
            $liveChat->description = $request->input('description');
            $liveChat->date = $request->input('date');
            $liveChat->start_time = Carbon::parse($request->input('start_time'));
            $liveChat->end_time = Carbon::parse($request->input('end_time'));
            $liveChat->fee = $request->input('fee');

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
    public function update_live_session(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'validation_errors' => $validator->errors(),
            ]);
        } else {

            $liveChat = LiveChat::find($request->id);
            $liveChat->title = $request->input('title');
            $liveChat->description = $request->input('description');
            $liveChat->date = $request->input('date');
            $liveChat->start_time = Carbon::parse($request->input('start_time'));
            $liveChat->end_time = Carbon::parse($request->input('end_time'));
            $liveChat->fee = $request->input('fee');

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

            // return $request->input('description');
            return response()->json([
                'status' => 200,
                'message' => 'Live Session update',
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

    public function approved_list()
    {
        $event = LiveChat::where([['created_by_id', auth('sanctum')->user()->id], ['status', 1]])->latest()->get();

        $event_count = LiveChat::where('created_by_id', auth('sanctum')->user()->id)->count();

        return response()->json([
            'status' => 200,
            'message' => 'Ok',
            'event' => $event,
            'event_count' => $event_count,
        ]);
    }

    public function pending_list()
    {
        $event = LiveChat::where([['created_by_id', auth('sanctum')->user()->id], ['status', null]])->latest()->get();

        return response()->json([
            'status' => 200,
            'message' => 'Ok',
            'event' => $event,
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
}
