<?php

namespace App\Http\Controllers\ManagerAdmin;

use App\Http\Controllers\Controller;
use App\Models\ProfitShare;
use Illuminate\Http\Request;
use App\Models\SubCategory;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\File;

class AdminController extends Controller
{
    public function index()
    {
        $admins = User::with('profitShare')->where([['category_id', auth()->user()->category_id], ['user_type', 'admin']])->orderBy('id', 'DESC')->get();

        return view('ManagerAdmin.admins.index', compact('admins'));
    }

    public function create()
    {
        $data = [
            'sub_categories' => SubCategory::where('category_id', auth()->user()->category_id)->orderBY('id', 'desc')->get(),
        ];
        return view('ManagerAdmin.admins.create', $data);
    }


    public function store(Request $request)
    {

        $request->validate([
            'sub_category_id' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'profit' => 'required',
            'email' => 'required|unique:users',
            'phone' => 'required|numeric|min:11|unique:users',
            'image' => 'mimes:jpeg,jpg,png,gif|max:2000',
            'cover' => 'mimes:jpeg,jpg,png,gif|max:2000',
        ]);



        $user = new User();
        $user->fill($request->except(['_token', 'image', 'cover']));
        $user->password = Hash::make('12345');
        $user->user_type = 'admin'; // Admin user_type == 'admin'
        // $user->otp = rand(100000, 999999);
        $user->otp = 123456;
        $user->category_id = auth()->user()->category_id;
        $user->sub_category_id = $request->sub_category_id;
        $user->created_by = createdBy();
        $user->status = 0;

        if ($request->hasFile('image')) {

            $image             = $request->file('image');
            $folder_path       = 'uploads/images/users/admins/';
            $image_new_name    = time() . '.' . $image->getClientOriginalExtension();
            //resize and save to server
            Image::make($image->getRealPath())->save($folder_path . $image_new_name);
            $user->image   = $folder_path . $image_new_name;
        }

        if ($request->hasFile('cover')) {

            $image             = $request->file('cover');
            $folder_path       = 'uploads/images/users/admins/';
            $image_new_name    = time() . '.' . $image->getClientOriginalExtension();
            //resize and save to server
            Image::make($image->getRealPath())->resize(879, 200)->save($folder_path . $image_new_name);
            $user->cover_photo   = $folder_path . $image_new_name;
        }

        try {
            $user->save();
            if ($user) {
                ProfitShare::create([
                    'user_id' => $user->id,
                    'user_type' => $user->user_type,
                    'profit' => $request->profit,
                ]);
                return response()->json([
                    'type' => 'success',
                    'message' => 'Admin Added Successfully'
                ]);
            }
        } catch (\Exception $exception) {
            return response()->json([
                'type' => 'error',
                'message' => 'Opps somthing went wrong. ' . $exception->getMessage(),
            ]);
        }
    }


    public function show(User $admin)
    {

        return view('ManagerAdmin.admins.details')->with('auditionAdmin', $admin);
    }


    public function edit(User $admin)
    {
        $data = [
            'admin' => $admin,
            'sub_categories' => SubCategory::where('category_id', auth()->user()->category_id)->orderBY('id', 'desc')->get(),
        ];
        return view('ManagerAdmin.admins.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $admin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'sub_category_id' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'profit' => 'required',
            'phone' => 'required',
        ]);

        $user = User::findOrFail($id);
        $user->fill($request->except('_token'));
        $user->sub_category_id = $request->sub_category_id;
        $user->updated_by = updatedBy();

        if ($request->hasFile('image')) {
            if ($user->image != null)
                File::delete(public_path($user->image)); //Old image delete

            $image             = $request->file('image');
            $folder_path       = 'uploads/images/users/admins/';
            $image_new_name    = time() . '.' . $image->getClientOriginalExtension();
            //resize and save to server
            Image::make($image->getRealPath())->save($folder_path . $image_new_name);
            $user->image   = $folder_path . $image_new_name;
        }

        if ($request->hasFile('cover')) {
            if ($user->cover_photo != null)
                File::delete(public_path($user->cover_photo)); //Old image delete

            $image             = $request->file('cover');
            $folder_path       = 'uploads/images/users/admins/';
            $image_new_name    = time() . '.' . $image->getClientOriginalExtension();
            //resize and save to server
            Image::make($image->getRealPath())->resize(879, 200)->save($folder_path . $image_new_name);
            $user->cover_photo   = $folder_path . $image_new_name;
        }

        try {
            $user->save();

            if ($user) {
                ProfitShare::where('user_id', $id)->update([
                    'profit' => $request->profit
                ]);
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $admin
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $admin)
    {
        try {
            if ($admin->cover_photo != null)
                File::delete(public_path($admin->cover_photo));

            if ($admin->image != null)
                File::delete(public_path($admin->image));
            ProfitShare::where('user_id', $admin->id)->delete();

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
        $user->active_status = 1;
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
        $user->active_status = 0;
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
