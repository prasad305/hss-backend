<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\FanGroup;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Str;


class FanGroupController extends Controller
{
    public function index()
    {
        $categories = Category::get();
        return view('SuperAdmin.FanGroup.index', compact('categories'));
    }
    public function fanGroupList($categoryId)
    {

        $postList = FanGroup::where('category_id', $categoryId)->latest()->get();
        return view('SuperAdmin.FanGroup.FanGroupList', compact('postList'));
    }
    public function fanGroupDetails($postId)
    {
        $post = FanGroup::find($postId);

        $star_one = User::find($post->my_star);
        $another_star = User::find($post->another_star);

        return view('SuperAdmin.fanGroup.details', compact('post', 'star_one', 'another_star'));
    }
    public function fanGroupEdit($id)
    {
        $event = FanGroup::find($id);

        return view('SuperAdmin.FanGroup.edit', compact('event'));
    }
    public function fanGroupUpdate(Request $request, $id)
    {

        $request->validate([
            'group_name' => 'required',
            'description' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
        ]);

        $fangroup = FanGroup::findOrFail($id);

        $fangroup->group_name = $request->group_name;
        $fangroup->slug = Str::slug($request->input('group_name') . '-' . rand(9999, 99999));
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
            if ($fangroup) {
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
    public function fanGroupDestroy($id)
    {
        $post = Post::where('event_id', $id)->first();
        $postDelete = FanGroup::findOrfail($id);
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
