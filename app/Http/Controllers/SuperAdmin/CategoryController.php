<?php

namespace App\Http\Controllers\SuperAdmin;

use Exception;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use App\Models\Audition\AuditionRules;
use Illuminate\Support\Facades\Session;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category = Category::orderBy('id', 'DESC')->get();
        return view('SuperAdmin.category.index')->with('category', $category);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('SuperAdmin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories',

        ]);

        $category = new Category();

        $category->name = $request->input('name');
        $url = $request->input('name');
        $category->slug = str::slug($url, '-');

        if ($request->hasFile('icon')) {
            if ($category->icon != null)
                File::delete(public_path($category->icon)); //Old image delete
            $image             = $request->file('icon');
            $folder_path       = 'uploads/category/icon/';
            $image_new_name    = Str::random(20) . '-' . now()->timestamp . '.' . $image->getClientOriginalExtension();
            //resize and save to server
            Image::make($image->getRealPath())->resize(200, 200)->save($folder_path . $image_new_name, 100);
            $category->icon   = $folder_path . $image_new_name;
        }

        if ($request->hasFile('image')) {
            if ($category->image != null)
                File::delete(public_path($category->image)); //Old image delete
            $image             = $request->file('image');
            $folder_path       = 'uploads/category/image/';
            $image_new_name    = Str::random(20) . '-' . now()->timestamp . '.' . $image->getClientOriginalExtension();
            //resize and save to server
            Image::make($image->getRealPath())->resize(600, 600)->save($folder_path . $image_new_name, 100);
            $category->image   = $folder_path . $image_new_name;
        }
        try {
            $category->save();

            AuditionRules::create([
                'category_id' => $category->id,
            ]);
            return response()->json([
                'type' => 'success',
                'message' => 'Category created successfully',
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'type' => 'error',
                'message' => 'Opps somthing went wrong. ' . $exception->getMessage(),
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::findOrfail($id);
        return view('SuperAdmin.category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $category = Category::findOrFail($id);
        $category->name = $request->input('name');
        $url = $request->input('name');
        $category->slug = str::slug($url, '-');

        if ($request->hasFile('icon')) {
            if ($category->icon != null)
                File::delete(public_path($category->icon)); //Old image delete
            $image             = $request->file('icon');
            $folder_path       = 'uploads/category/icon/';
            $image_new_name    = Str::random(20) . '-' . now()->timestamp . '.' . $image->getClientOriginalExtension();
            //resize and save to server
            Image::make($image->getRealPath())->resize(200, 200)->save($folder_path . $image_new_name, 100);
            $category->icon   = $folder_path . $image_new_name;
        }

        if ($request->hasFile('image')) {
            if ($category->image != null)
                File::delete(public_path($category->image)); //Old image delete
            $image             = $request->file('image');
            $folder_path       = 'uploads/category/image/';
            $image_new_name    = Str::random(20) . '-' . now()->timestamp . '.' . $image->getClientOriginalExtension();
            //resize and save to server
            Image::make($image->getRealPath())->resize(600, 600)->save($folder_path . $image_new_name, 100);
            $category->image   = $folder_path . $image_new_name;
        }

        try {
            $category->save();
            return response()->json([
                'success' => 'success',
                'message' => 'Category Updated Successfully'
            ]);
        } catch (Exception $exception) {
            return response()->json([
                'type' => 'error',
                'message' => 'Opps somthing went wrong. ' . $exception->getMessage(),
            ]);
        }
    }

    public function destroy($id)
    {
        $category = Category::findOrfail($id);
        if ($category->image != null){
            File::delete(public_path($category->image)); //Old image delete
        }
        if ($category->icon != null){
            File::delete(public_path($category->icon)); //Old icon delete
        }

        if($category->subCategories->count() > 0){
            return response()->json([
                'type' => 'error',
                // 'message' => 'error' . $exception->getMessage(),
                'message' => " Pleae delete first sub categories then try again.",
            ]);
        }
        try {
            $category->delete();
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
