<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Livechat;
use App\Models\LiveChatRegistration;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LivechatController extends Controller
{

    /// Super Star Method ....

    public function livechat()
    {
        $livechats = Livechat::where('star_id', auth('sanctum')->user()->id)->get();
        $pendingLiveChatNumber = Livechat::where('star_approve_status', 0)->where('star_id', auth('sanctum')->user()->id)->count();

        return response()->json([
            'status' => 200,
            'message' => 'Ok',
            'livechats' => $livechats,
            'pendingLiveChatNumber' => $pendingLiveChatNumber,
        ]);
    }
    public function pendingLiveChat()
    {
        $pendingLiveChats = Livechat::where('star_id', auth('sanctum')->user()->id)->where('star_approve_status', false)->get();
        $pendingLiveChatNumber = Livechat::where('star_approve_status', 0)->where('star_id', auth('sanctum')->user()->id)->count();

        return response()->json([
            'status' => 200,
            'message' => 'Ok',
            'pendingLiveChats' => $pendingLiveChats,
            'pendingLiveChatNumber' => $pendingLiveChatNumber,
        ]);
    }
    public function approveLiveChat($id)
    {
        $approveLiveChat = Livechat::find($id);
        $approveLiveChat->star_approve_status = 1;
        $approveLiveChat->save();
        return response()->json([
            'status' => 200,
            'message' => 'Ok',
        ]);
    }

    public function deleteLiveChat($id)
    {
        $approveLiveChat = Livechat::find($id);
        $approveLiveChat->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Ok',
        ]);
    }
    public function livechatListByDate($date)
    {
        $livechats = Livechat::whereDate('date', Carbon::parse($date)->format('Y-m-d'))->where('star_id',  auth('sanctum')->user()->id)->get();
        return response()->json([
            'status' => 200,
            'message' => 'Ok',
            'livechats' => $livechats,
            'star_id' => auth('sanctum')->user()->id,
        ]);
    }

    public function sinlgeLiveChat($id)
    {
        $liveChat = Livechat::find($id);

        return response()->json([
            'status' => 200,
            'message' => 'Ok',
            'liveChat' => $liveChat,
        ]);
    }

    public function registeredUserList($live_chat_id)
    {
        $registeredLiveChats = LiveChatRegistration::where('live_chat_id', $live_chat_id)->get();
        return response()->json([
            'status' => 200,
            'message' => 'Ok',
            'registeredLiveChats' => $registeredLiveChats,
        ]);
    }



    /// Admin Method ....

    public function admin_livechat()
    {
        $livechats = Livechat::where('star_id', auth('sanctum')->user()->id)->get();
        $pendingLiveChatNumber = Livechat::where('star_approve_status', 0)->where('admin_id', auth('sanctum')->user()->id)->count();

        return response()->json([
            'status' => 200,
            'message' => 'Ok',
            'livechats' => $livechats,
            'pendingLiveChatNumber' => $pendingLiveChatNumber,
        ]);
    }

    public function admin_sinlgeLiveChat($id)
    {
        $liveChat = Livechat::find($id);

        return response()->json([
            'status' => 200,
            'message' => 'Ok',
            'liveChat' => $liveChat,
        ]);
    }


    public function admin_livechatListByDate($date)
    {
        $livechats = Livechat::whereDate('date', Carbon::parse($date)->format('Y-m-d'))->where('admin_id',  auth('sanctum')->user()->id)->get();

        return response()->json([
            'status' => 200,
            'message' => $date,
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


}
