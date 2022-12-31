<?php

namespace App\Http\Controllers\ManagerAdmin;

use App\Http\Controllers\Controller;
use App\Models\MeetupEvent;
use App\Models\Post;
use App\Models\SuperStar;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Validator;

class MeetupEventController extends Controller
{
    public function manager_all()
    {
        $upcommingEvent = MeetupEvent::where([['status', '>', 0], ['status', '!=', 11], ['category_id', auth()->user()->category_id]])->latest()->get();

        return view('ManagerAdmin.MeetupEvents.index', compact('upcommingEvent'));
    }


    public function manager_pending()
    {
        $upcommingEvent = MeetupEvent::where([['status', 1], ['category_id', auth()->user()->category_id]])->latest()->get();

        return view('ManagerAdmin.MeetupEvents.index', compact('upcommingEvent'));
    }

    public function manager_published()
    {
        $upcommingEvent = MeetupEvent::where([['status', 2], ['category_id', auth()->user()->category_id]])->latest()->get();

        return view('ManagerAdmin.MeetupEvents.index', compact('upcommingEvent'));
    }



    public function set_approve_by_manager($id)
    {
        $meetup = MeetupEvent::find($id);
        $meetup->star_approval = 1;
        $meetup->update();

        return response()->json([
            'status' => 200,
            'meetup' => $meetup,
            'message' => 'Approved',
        ]);
    }

    public function event_info($id)
    {

        $meetup = MeetupEvent::find($id);

        return response()->json([
            'status' => 200,
            'meetup' => $meetup,
            'message' => 'Approved',
        ]);
    }

    public function edit($id)
    {
        $event = MeetupEvent::find($id);

        return view('ManagerAdmin.MeetupEvents.edit', compact('event'));
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'title' => 'required',
            'description' => 'required|min:5',
            'instruction' => 'required|min:5',
            'image' => 'mimes:png,jpg,jpeg,webP',
        ], [
            'title.required' => 'This Field Is Required',
            'description.required' => 'This Field Is Required',
            'instruction.required' => 'This Field Is Required',
        ]);

        $meetup = MeetupEvent::findOrFail($id);
        $meetup->fill($request->except('_token'));

        $meetup->title = $request->input('title');
        $meetup->description = $request->input('description');
        $meetup->instruction = $request->input('instruction');


        if ($request->hasfile('image')) {
            $destination = $meetup->banner;
            if (File::exists($destination)) {
                File::delete($destination);
            }
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = 'uploads/images/meetup/' . time() . '.' . $extension;

            Image::make($file)->resize(900, 400)
                ->save($filename, 50);

            $meetup->banner = $filename;
        }

        try {
            $meetup->update();
            if ($meetup) {
                return response()->json([
                    'success' => true,
                    'message' => 'Meetup Event Updated Successfully'
                ]);
            }
        } catch (\Exception $exception) {
            return response()->json([
                'type' => 'error',
                'message' => 'Opps somthing went wrong. ' . $exception->getMessage(),
            ]);
        }
    }


    public function manager_event_details($id)
    {
        $meetup = MeetupEvent::find($id);

        return view('ManagerAdmin.MeetupEvents.details', compact('meetup'));
    }


    public function manager_event_set_publish(Request $request, $id)
    {
        $meetup = MeetupEvent::find($id);



        if ($meetup->status != 2) {

            $request->validate([
                'post_start_date' => 'required',
                'post_end_date' => 'required',
            ]);

            if ($meetup->meetup_type == "Online") {
                $meetup->event_link = createRoomID();
            }

            $meetup->status = 2;
            $managerApprove = $meetup->update();

            if($managerApprove){
                $userInfo = getUserInfo();
                $senderInfo = getManagerInfo(auth()->user()->id);
                
                foreach ($userInfo as $key => $data) {
                    SendMail($data->email,$meetup,$senderInfo);
                }
            }


            $starCat = SuperStar::where('star_id', $meetup->star_id)->first();
            // Create New post //
            $post = new Post();
            $post->type = 'meetup';
            $post->user_id = $meetup->star_id;
            $post->star_id = json_encode($meetup->star_id);
            $post->event_id = $meetup->id;
            $post->category_id = $starCat->category_id;
            $post->sub_category_id = $starCat->sub_category_id;
            $post->post_start_date = Carbon::parse($request->post_start_date);
            $post->post_end_date = Carbon::parse($request->post_end_date);
            // $post->user_like_id = '[]';
            // $post->react_provider = '[]';

            $post->save();

            return redirect()->back()->with('success', 'Published');
        } else {
            $meetup->status = 10;
            $meetup->update();
            //Remove post //
            $post = Post::where('event_id', $id)->first();
            $post->delete();

            return redirect()->back()->with('warning', 'Removed');
        }


        return redirect()->back()->with('success', 'Published');
    }
}
