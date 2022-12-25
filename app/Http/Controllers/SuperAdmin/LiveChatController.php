<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\LiveChat;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Str;

class LiveChatController extends Controller
{
    public function index()
    {
        $categories = Category::get();
        return view('SuperAdmin.LiveChat.index', compact('categories'));
    }
    public function livechatList($categoryId)
    {
        $postList = LiveChat::with(['star', 'admin'])->where('category_id', $categoryId)->latest()->get();
        return view('SuperAdmin.LiveChat.LiveChatList', compact('postList'));
    }
    public function livechatDetails($postId)
    {
        $event = LiveChat::findOrFail($postId);
        return view('SuperAdmin.LiveChat.details', compact('event'));
    }
    public function livechatEdit($id)
    {
        $event = LiveChat::find($id);

        return view('SuperAdmin.LiveChat.edit', compact('event'));
    }
    public function livechatUpdate(Request $request, $id)
    {

        $request->validate([
            'title' => 'required|unique:live_chats,title,'.$id,
            'description' => 'required|min:5',
            'instruction' => 'required|min:5',
            'image' => 'mimes:png,jpg,jpeg,webP',
        ], [
            'title.required' => 'This Field Is Required',
            'title.unique' => 'This Title Already Exist',
            'description.required' => 'This Field Is Required',
            'instruction.required' => 'This Field Is Required',
        ]);


        $liveChat = LiveChat::findOrFail($id);
        $liveChat->fill($request->except('_token', 'image'));

        $liveChat->title = $request->input('title');
        $liveChat->slug = Str::slug($request->input('title'));
        $liveChat->description = $request->input('description');
        $liveChat->instruction = $request->input('instruction');

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

        try {
            $liveChat->update();
            if ($liveChat) {
                return response()->json([
                    'success' => true,
                    'message' => 'LiveChat Event Updated Successfully'
                ]);
            }
        } catch (\Exception $exception) {
            return response()->json([
                'type' => 'error',
                'message' => 'Opps somthing went wrong. ' . $exception->getMessage(),
            ]);
        }
    }
    public function livechatDestroy($id)
    {
        $post = Post::where('event_id', $id)->first();
        $postDelete = LiveChat::findOrfail($id);
        try {
            $post->delete();
            $postDelete->delete();
            return response()->json([
                'type' => 'success',
                'message' => 'Successfully Deleted !!',
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'type' => 'error',
                'message' => 'error' . $exception->getMessage(),
            ]);
        }
    }
}
