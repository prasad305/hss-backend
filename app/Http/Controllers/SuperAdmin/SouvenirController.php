<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SouvenirCreate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Str;

class SouvenirController extends Controller
{

    public function dashboard()
    {
        $categories = Category::get();
        return view('SuperAdmin.Souvenir.index', compact('categories'));
    }
    public function souvenirList($categoryId)
    {
        $postList = SouvenirCreate::where('category_id', $categoryId)->latest()->get();
        return view('SuperAdmin.Souvenir.postList', compact('postList'));
    }
    public function souvenirDetails($id)
    {
        $post = SouvenirCreate::find($id);

        return view('SuperAdmin.Souvenir.details', compact('post'));
    }


    public function souvenirEdit($id)
    {
        $event = SouvenirCreate::find($id);

        return view('SuperAdmin.Souvenir.edit', compact('event'));
    }

    public function souvenirUpdate(Request $request, $id)
    {
        $request->validate([

            'title' => 'required',
            'description' => 'required',
            'instruction' => 'required',

        ]);

        $souvenir = SouvenirCreate::findOrFail($id);
        $souvenir->fill($request->except('_token', 'banner', 'video'));

        $souvenir->title = $request->input('title');
        $souvenir->slug = Str::slug($request->input('title') . '-' . rand(9999, 99999));
        $souvenir->description = $request->input('description');
        $souvenir->instruction = $request->input('instruction');

        if ($request->hasfile('banner')) {
            $destination = $souvenir->banner;
            if (File::exists($destination)) {
                File::delete($destination);
            }

            $file = $request->file('banner');
            $extension = $file->getClientOriginalExtension();
            $filename = 'uploads/images/souviner/' . time() . '.' . $extension;

            Image::make($file)->resize(800, 300)->save($filename, 100);
            $souvenir->banner = $filename;
        }


        if ($request->hasFile('video')) {
            if ($souvenir->video != null && file_exists($souvenir->video)) {
                unlink($souvenir->video);
            }
            $file        = $request->file('video');
            $path        = 'uploads/videos/souviner/';
            $file_name   = time() . rand('0000', '9999') . '.' . $file->getClientOriginalName();
            $file->move($path, $file_name);
            $souvenir->video = $path . '/' . $file_name;
        }


        try {

            $souvenir->update();

            return response()->json([
                'success' => true,
                'message' => 'Souvenir Updated Successfully'
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'type' => 'error',
                'message' => 'Opps somthing went wrong. ' . $exception->getMessage(),
            ]);
        }
    }

    public function souvenirDestroy($id)
    {
        $souvenir = SouvenirCreate::findOrFail($id);
        try {
            $souvenir->delete();
            return response()->json([
                'type' => 'success',
                'message' => 'Successfully Deleted'
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'type' => 'error',
                'message' => $exception->getMessage()
            ]);
        }
    }
}
