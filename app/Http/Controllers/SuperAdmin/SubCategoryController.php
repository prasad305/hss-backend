<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Session;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subCategories = SubCategory::orderBy('id', 'DESC')->get();
        $category = Category::orderBy('id', 'DESC')->get();
        return view('SuperAdmin.subCategory.index')
            ->with('subCategories', $subCategories)
            ->with('category', $category);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'categories' => Category::orderBy('id', 'desc')->get(),
        ];
        return view('SuperAdmin.subCategory.create', $data);
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
            'name' => 'required|unique:sub_categories',
            'category_id' => 'required'
        ]);

        $subCategory = new SubCategory();

        $subCategory->name = $request->input('name');
        $url = $request->input('name');
        $subCategory->slug = str::slug($url, '-');
        $subCategory->category_id = $request->input('category_id');

        if ($request->hasFile('icon')) {
            if ($subCategory->category != null)
                File::delete(public_path($subCategory->image)); //Old image delete
            $image             = $request->file('icon');
            $folder_path       = 'uploads/category/icon/';
            $image_new_name    = Str::random(20) . '-' . now()->timestamp . '.' . $image->getClientOriginalExtension();
            //resize and save to server
            Image::make($image->getRealPath())->resize(200, 200)->save($folder_path . $image_new_name, 100);
            $subCategory->icon   = $folder_path . $image_new_name;
        }

        if ($request->hasFile('image')) {
            if ($subCategory->category != null)
                File::delete(public_path($subCategory->image)); //Old image delete
            $image             = $request->file('image');
            $folder_path       = 'uploads/category/image/';
            $image_new_name    = Str::random(20) . '-' . now()->timestamp . '.' . $image->getClientOriginalExtension();
            //resize and save to server
            Image::make($image->getRealPath())->resize(600, 600)->save($folder_path . $image_new_name, 100);
            $subCategory->image   = $folder_path . $image_new_name;
        }

        try {
            $subCategory->save();
            return response()->json([
                'type' => 'success',
                'message' => 'Sub Category created successfully',
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
        $categories = Category::orderBy('id', 'DESC')->get();
        $subCategory = SubCategory::findOrfail($id);
        return view('SuperAdmin.subCategory.edit', compact('subCategory', 'categories'));
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
            'name'  => 'required',
        ]);

        $subCategory = SubCategory::findOrFail($id);
        $subCategory->name = $request->name;
        $subCategory->slug = time() . '-' . Str::random(12);
        $subCategory->category_id = $request->category_id;

        if ($request->hasFile('icon')) {
            if ($subCategory->icon != null)
                File::delete(public_path($subCategory->icon)); //Old icon delete
            $image             = $request->file('icon');
            $folder_path       = 'uploads/category/icon/';
            $image_new_name    = Str::random(20) . '-' . now()->timestamp . '.' . $image->getClientOriginalExtension();
            //resize and save to server
            Image::make($image->getRealPath())->resize(200, 200)->save($folder_path . $image_new_name, 100);
            $subCategory->icon   = $folder_path . $image_new_name;
        }

        if ($request->hasFile('image')) {
            if ($subCategory->image != null)
                File::delete(public_path($subCategory->image)); //Old image delete
            $image             = $request->file('image');
            $folder_path       = 'uploads/category/image/';
            $image_new_name    = Str::random(20) . '-' . now()->timestamp . '.' . $image->getClientOriginalExtension();
            //resize and save to server
            Image::make($image->getRealPath())->resize(600, 600)->save($folder_path . $image_new_name, 100);
            $subCategory->image   = $folder_path . $image_new_name;
        }
        try {
            $subCategory->save();
            return response()->json([
                'type' => 'success',
                'message' => 'Sub Category updated successfully',
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'type' => 'error',
                'message' => 'Opps somthing went wrong. ' . $exception->getMessage(),
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $subCategory = SubCategory::findOrfail($id);
        if ($subCategory->image != null){
            File::delete(public_path($subCategory->image)); //Old image delete
        }
        if ($subCategory->icon != null){
            File::delete(public_path($subCategory->icon)); //Old icon delete
        }
        try {
            $subCategory->delete();
            return response()->json([
                'type' => 'success',
                'message' => 'Successfully Deleted !!',
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'type' => 'error',
                'message' => 'Opps...' . $exception->getMessage(),
            ]);
        }
    }
}
