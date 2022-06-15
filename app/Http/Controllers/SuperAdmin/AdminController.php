<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class AdminController extends Controller
{
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admins = User::where('user_type', 'admin')->orderBy('id', 'DESC')->get();
        return view('SuperAdmin.admins.index', compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'categories' =>  Category::all(),
            'sub_categories' => SubCategory::orderBy('id','desc')->get(),
        ];
        return view('SuperAdmin.admins.create',$data);
    }

   
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|unique:users',
            'phone' => 'required|unique:users',
        ]);

        $user = new User();
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->category_id = $request->category_id;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->password = Hash::make('12345');
        $user->user_type = 'admin'; // Admin user_type == 'admin'
        $user->otp = rand( 100000 , 999999 );

        if ($request->hasFile('image')) {
            $image             = $request->file('image');
            $folder_path       = 'uploads/images/users/';
            $image_new_name    = Str::random(20) . '-' . now()->timestamp . '.' . $image->getClientOriginalExtension();
            //resize and save to server
            Image::make($image->getRealPath())->save($folder_path . $image_new_name);
            $user->image   = $folder_path . $image_new_name;
        }

        if ($request->hasFile('cover')) {
            $image             = $request->file('cover');
            $folder_path       = 'uploads/images/users/';
            $image_new_name    = Str::random(20) . '-' . now()->timestamp . '.' . $image->getClientOriginalExtension();
            //resize and save to server
            Image::make($image->getRealPath())->save($folder_path . $image_new_name);
            $user->cover_photo   = $folder_path . $image_new_name;
        }
        try {
            $user->save();
            return response()->json([
                'type' => 'success',
                'message' => 'Admin created successfully',
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'type' => 'error',
                'message' => 'Opps somthing went wrong. ' . $exception->getMessage(),
            ]);
        }

    }

 
    public function show(User $admin)
    {
        //
    }

  
    public function edit(User $admin)
    {
        $categories = Category::all();
        $data['admin'] = $admin;
        $data['categories'] = $categories;
        return view('SuperAdmin.admins.edit',$data);

    }
    
    public function getSubCategory($category_id){
        return SubCategory::where('status',1)
        ->when($category_id>0,function($query) use($category_id){
            return $query->where('category_id',$category_id);
        })
        ->orderBy('name','asc')
        ->get();
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'category_id' => 'required',
            'sub_category_id' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'phone' => 'required',
        ]);

        // return $request->sub_category_id;

        $user = User::findOrFail($id);
        $user->fill($request->except('_token'));
        $user->category_id = $request->category_id;
        $user->sub_category_id = $request->sub_category_id;
        $user->updated_by = updatedBy();

        if ($request->hasFile('image')) {
            if ($user->image != null)
                File::delete(public_path($user->image)); //Old image delete

            $image             = $request->file('image');
            $folder_path       = 'uploads/images/users/';
            $image_new_name    = Str::random(20) . '-' . now()->timestamp . '.' . $image->getClientOriginalExtension();
            //resize and save to server
            Image::make($image->getRealPath())->save($folder_path . $image_new_name);
            $user->image   = $folder_path . $image_new_name;
        }

        if ($request->hasFile('cover')) {
            if ($user->cover_photo != null)
                File::delete(public_path($user->cover_photo)); //Old image delete

            $image             = $request->file('cover');
            $folder_path       = 'uploads/images/users/';
            $image_new_name    = Str::random(20) . '-' . now()->timestamp . '.' . $image->getClientOriginalExtension();
            //resize and save to server
            Image::make($image->getRealPath())->save($folder_path . $image_new_name);
            $user->cover_photo   = $folder_path . $image_new_name;
        }
        try {
            $user->save();
            if($user){
                return response()->json([
                    'success' => true,
                    'message' => 'Admin Updated Successfully'
                ]);
            }
        } catch (\Exception $exception) {
            return response()->json([
                'type' => 'error',
                'message' => 'Opps somthing went wrong. ' . $exception->getMessage(),
            ]);
        }
    }


    public function destroy(User $admin)
    {
        try {
            if ($admin->image != null)
                File::delete(public_path($admin->image)); //Old image delete
            if ($admin->cover_photo != null)
                File::delete(public_path($admin->cover_photo)); //Old cover_photo delete
            $admin->delete();
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

    public function activeNow($id)
    {
        $user = User::findOrFail($id);
        $user->status = 1;
        try {
            $user->save();
            return response()->json([
                'type' => 'success',
                'message' => 'Successfully Updated'
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'type' => 'error',
                'message' => $exception->getMessage()
            ]);
        }
    }

    public function inactiveNow($id)
    {
        $user = User::findOrFail($id);
        $user->status = 0;
        try {
            $user->save();
            return response()->json([
                'type' => 'success',
                'message' => 'Successfully Updated'
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'type' => 'error',
                'message' => $exception->getMessage()
            ]);
        }
    }
}
