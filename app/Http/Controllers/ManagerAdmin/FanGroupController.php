<?php

namespace App\Http\Controllers\ManagerAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FanGroup;
use App\Models\User;
use App\Models\Post;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;
use Carbon\Carbon;
use Illuminate\Support\Str;

class FanGroupController extends Controller
{
    public function all()
    {
        $post = FanGroup::where('my_star_status', 1)
                ->where('another_star_status', 1)
                ->where('status', '!=', 0)
                ->where('category_id',auth()->user()->category_id)
                ->latest()->get();
        $fanstatus = 'Pending/Published';
        return view('ManagerAdmin.fangroup.index', compact('post', 'fanstatus'));
    }

    public function pending()
    {
        $post = FanGroup::where('my_star_status', 1)
                ->where('another_star_status', 1)
                ->where('status', 2)
                ->where('category_id',auth()->user()->category_id)
                ->latest()->get();

        $fanstatus = 'Pending';

        return view('ManagerAdmin.fangroup.index', compact('post', 'fanstatus'));
    }

    public function published()
    {
        $post = FanGroup::where('my_star_status', 1)
                ->where('another_star_status', 1)
                ->where('status', 1)
                ->where('category_id',auth()->user()->category_id)
                ->latest()->get();
        $fanstatus = 'Published';
        return view('ManagerAdmin.fangroup.index', compact('post', 'fanstatus'));
    }

    public function details($id)
    {
        $post = FanGroup::find($id);

        $star_one = User::find($post->my_star);
        $another_star = User::find($post->another_star);

        return view('ManagerAdmin.fangroup.details', compact('post', 'star_one', 'another_star'));
    }


    public function edit($id)
    {
        $event = FanGroup::find($id);

        return view('ManagerAdmin.fangroup.edit', compact('event'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'group_name' => 'required|unique:fan_groups,group_name,'.$id,
            'description' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
        ]);

        $fangroup = FanGroup::findOrFail($id);
        
        $fangroup->group_name = $request->group_name;
        $fangroup->slug = Str::slug($request->group_name);
        $fangroup->description = $request->description;
        $fangroup->start_date = $request->start_date;
        $fangroup->end_date = $request->end_date;
        // $fangroup->min_member = $request->min_member;
        // $fangroup->max_member = $request->max_member;

        if ($request->hasfile('banner')) {

            $destination = $fangroup->banner;
            if ($destination != null && file_exists($destination)) {
                unlink($destination);
            }

            $file = $request->file('banner');
            $extension = $file->getClientOriginalExtension();
            $filename = 'uploads/images/fangroup/' . time() . '.' . $extension;

            Image::make($file)->resize(800, 300)->save($filename, 100);
            $fangroup->banner = $filename;
        }

        // $fangroup->save();

        
        try {
            $fangroup->save();
            if($fangroup){
                // return response()->json([
                //     'success' => true,
                //     'message' => 'Marketplace Updated Successfully'
                // ]);
                return response()->json([
                    'status' => 200,
                    'message' => 'Fan Group Updated Successfully',
                ]);
            }
        } catch (\Exception $exception) {
            return response()->json([
                'type' => 'error',
                'message' => 'Opps somthing went wrong. ' . $exception->getMessage(),
            ]);
        }
    }

    public function set_publish(Request $request)
    {
        // dd($request->all());
       
        $id = $request->postId;
        $spost = FanGroup::find($id);


        if($spost->status != 1)
        {
            $request->validate([
                'post_start_date' => 'required',
                'post_end_date' => 'required',
            ]);

            $spost->status = 1;
            $spost->update();

            $post = new Post();
            $post->type = 'fangroup';
            // $post->user_id = $event->star_id;
            $post->event_id = $spost->id;
            $post->category_id=$spost->category_id;
            $post->sub_category_id=$spost->sub_category_id;
            $post->title = $spost->group_name;
            $post->star_id = '['.$spost->my_star.', '.$spost->another_star.']';
            $post->post_start_date = Carbon::parse($request->post_start_date)->format('Y-m-d');
            $post->post_end_date = Carbon::parse($request->post_end_date)->format('Y-m-d');
            $post->details = $spost->description;
            $post->user_id = $spost->created_by;
            $post->share_link = 'https://hellosuperstars.com/group/'.$spost->slug;
            $post->status = 1;

            $post->save();

            return redirect()->back()->with('success', 'Published');
        }
        else
        {
            $spost->status = 2;
            $spost->update();

            // Remove post //
            $post = Post::where('event_id', $id)->first();
            $post->delete();

            return redirect()->back()->with('success', 'Not Published');
        }

    }
}
