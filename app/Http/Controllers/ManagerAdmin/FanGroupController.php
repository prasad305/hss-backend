<?php

namespace App\Http\Controllers\ManagerAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FanGroup;
use App\Models\User;
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
                ->latest()->get();

        return view('ManagerAdmin.fangroup.index', compact('post'));
    }

    public function pending()
    {
        $post = FanGroup::where('my_star_status', 1)
                ->where('another_star_status', 1)
                ->where('status', 0)
                ->latest()->get();

        return view('ManagerAdmin.fangroup.index', compact('post'));
    }

    public function published()
    {
        $post = FanGroup::where('my_star_status', 1)
                ->where('another_star_status', 1)
                ->where('status', 1)
                ->latest()->get();

        return view('ManagerAdmin.fangroup.index', compact('post'));
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
        $fangroup = FanGroup::findOrFail($id);
        
        $fangroup->group_name = $request->group_name;
        $fangroup->slug = Str::slug($request->input('group_name'));
        $fangroup->description = $request->description;
        $fangroup->start_date = $request->start_date;
        $fangroup->end_date = $request->end_date;
        $fangroup->min_member = $request->min_member;
        $fangroup->max_member = $request->max_member;

        if ($request->hasfile('banner')) {

            $file = $request->file('banner');
            $extension = $file->getClientOriginalExtension();
            $filename = 'uploads/images/fangroup/' . time() . '.' . $extension;

            Image::make($file)->resize(800, 300)->save($filename, 100);
            $fangroup->banner = $filename;
        }

        $fangroup->save();

        return response()->json([
            'status' => 200,
            'message' => 'Fan Group Updated Successfully',
        ]);
    }

    public function set_publish($id)
    {
        $spost = FanGroup::find($id);

        if($spost->status != 1)
        {
            $spost->status = 1;
            $spost->update();
            return redirect()->back()->with('success', 'Published');
        }
        else
        {
            $spost->status = 0;
            $spost->update();
            return redirect()->back()->with('success', 'Not Published');
        }

    }
}
