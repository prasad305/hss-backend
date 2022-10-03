<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Marketplace;
use App\Models\Post;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use Carbon\Carbon;
use Illuminate\Support\Str;

class MarketplaceController extends Controller
{
    public function index()
    {
        $categories = Category::get();
        return view('SuperAdmin.Marketplace.index', compact('categories'));
    }

    public function marketplaceList($categoryId)
    {
        $postList = Marketplace::where('category_id', $categoryId)->latest()->get();
        return view('SuperAdmin.Marketplace.postList', compact('postList'));
    }
    public function marketplaceDetails($id)
    {
        $post = Marketplace::find($id);

        return view('SuperAdmin.Marketplace.details', compact('post'));
    }


    public function marketplaceEdit($id)
    {
        $event = Marketplace::find($id);

        return view('SuperAdmin.Marketplace.edit', compact('event'));
    }

    public function marketplaceUpdate(Request $request, $id)
    {
        $request->validate([

            'title' => 'required',
            'description' => 'required',
            'keywords' => 'required',
            'terms_conditions' => 'required',
        ]);

        $marketplace = Marketplace::findOrFail($id);
        $marketplace->fill($request->except('_token', 'image'));

        $marketplace->title = $request->input('title');
        $marketplace->slug = Str::slug($request->input('title') . '-' . rand(9999, 99999));
        $marketplace->description = $request->input('description');
        $marketplace->keywords = $request->input('keywords');
        $marketplace->terms_conditions = $request->input('terms_conditions');

        if ($request->hasfile('image')) {
            $destination = $marketplace->image;
            if ($destination != null && file_exists($destination)) {
                unlink($destination);
            }
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = 'uploads/images/marketplace/' . time() . '.' . $extension;

            Image::make($file)->resize(400, 400)->save($filename, 50);
            $marketplace->image = $filename;
        }


        try {

            $marketplace->update();

            return response()->json([
                'success' => true,
                'message' => 'Description Updated Successfully'
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'type' => 'error',
                'message' => 'Opps somthing went wrong. ' . $exception->getMessage(),
            ]);
        }
    }
    public function marketplaceDestroy($id)
    {
        $post = Post::where('event_id', $id)->first();
        $postDelete = Marketplace::findOrfail($id);
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
