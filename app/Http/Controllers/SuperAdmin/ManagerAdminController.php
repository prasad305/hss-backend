<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Facades\Hash;
use Auth;
use Illuminate\Support\Facades\File;

class ManagerAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        $manager_admin = User::where('user_type','manager-admin')->orderBy('id', 'DESC')->get();
        return view('SuperAdmin.managerAdmin.index')
        ->with('categories',$categories)
        ->with('manager_admin',$manager_admin);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('SuperAdmin.managerAdmin.create', compact('categories'));
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
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required|unique:users',
            'email' => 'required|unique:users',
        ]);

        $manager_admin = new User();

        $manager_admin->first_name = $request->input('first_name');
        $manager_admin->last_name = $request->input('last_name');
        $manager_admin->email = $request->input('email');
        $manager_admin->phone = $request->input('phone');
        $manager_admin->category_id = $request->input('category_id');
        $manager_admin->password = Hash::make('12345');
        $manager_admin->parent_user = auth('sanctum')->user()->id;
        $manager_admin->user_type = 'manager-admin'; // Manager Admin Default Role == 9 
        $manager_admin->status = 1; // approved == 1 

        if($request->hasFile('image')){
            if ($manager_admin->category != null)
                File::delete(public_path($manager_admin->image)); //Old image delete
            $image             = $request->file('image');
            $folder_path       = 'uploads/managerAdmin/image/';
            $image_new_name    = Str::random(20).'-'.now()->timestamp.'.'.$image->getClientOriginalExtension();
            //resize and save to server
            Image::make($image->getRealPath())->resize(600,600)->save($folder_path.$image_new_name, 100);
            $manager_admin->image   = $folder_path . $image_new_name;
        }

        if($request->hasFile('cover')){
            if ($manager_admin->category != null)
                File::delete(public_path($manager_admin->image)); //Old image delete
            $image             = $request->file('cover');
            $folder_path       = 'uploads/managerAdmin/image/';
            $image_new_name    = Str::random(20).'-'.now()->timestamp.'.'.$image->getClientOriginalExtension();
            //resize and save to server
            Image::make($image->getRealPath())->resize(600,600)->save($folder_path.$image_new_name, 100);
            $manager_admin->cover_photo   = $folder_path . $image_new_name;
        }
      
        try {
            $manager_admin->save();
            return response()->json([
                'type' => 'success',
                'message' => 'Successsfully Manager Admin Created !',
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'type' => 'error',
                'message' => 'Failed!',
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
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categories = Category::all();
        $user = User::findOrfail($id);
        return view('SuperAdmin.managerAdmin.edit', compact('user', 'categories'));
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
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'phone' => 'required',
        ]);

        $user = User::findOrFail($id);
        $user->fill($request->except('_token'));

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
                    'message' => 'Manager Admin Updated Successfully'
                ]);
            }
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
        $manager_admin = User::findOrfail($id);
        try {
            $manager_admin->delete();
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
