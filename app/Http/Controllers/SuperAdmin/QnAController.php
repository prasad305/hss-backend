<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\QnA;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Str;


class QnAController extends Controller
{

    public function index()
    {
        $categories = Category::get();
        return view('SuperAdmin.QnA.index', compact('categories'));
    }
    public function qnaList($categoryId)
    {
        $postList = QnA::where('category_id', $categoryId)->latest()->get();
        return view('SuperAdmin.QnA.qnaList', compact('postList'));
    }
    public function qnaDetails($postId)
    {
        $event = QnA::findOrFail($postId);
        return view('SuperAdmin.QnA.details', compact('event'));
    }
    public function qnaEdit($id)
    {
        $event = QnA::find($id);

        return view('SuperAdmin.QnA.edit', compact('event'));
    }
    public function qnaUpdate(Request $request, $id)
    {

        $request->validate([
            'title' => 'required|unique:qn_a_s,title,'.$id,
            'description' => 'required|min:5',
            'instruction' => 'required|min:5',
            'image' => 'mimes:png,jpg,jpeg,webP',
        ], [
            'title.required' => 'This Field Is Required',
            'title.unique' => 'This Title Already Exist',
            'description.required' => 'This Field Is Required',
            'instruction.required' => 'This Field Is Required',
        ]);


        $qna = QnA::findOrFail($id);
        $qna->fill($request->except('_token', 'image'));

        $qna->title = $request->input('title');
        $qna->slug = Str::slug($request->input('title'));
        $qna->description = $request->input('description');
        $qna->instruction = $request->input('instruction');

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

        try {
            $qna->update();
            if ($qna) {
                return response()->json([
                    'success' => true,
                    'message' => 'QnA Event Updated Successfully'
                ]);
            }
        } catch (\Exception $exception) {
            return response()->json([
                'type' => 'error',
                'message' => 'Opps somthing went wrong. ' . $exception->getMessage(),
            ]);
        }
    }
    public function qnaDestroy($id)
    {
        $post = Post::where('event_id', $id)->first();
        $postDelete = QnA::findOrfail($id);
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
