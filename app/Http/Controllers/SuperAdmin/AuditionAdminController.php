<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Audition\Audition;
use App\Models\User;
use Illuminate\Http\Request;

use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\File;

class AuditionAdminController extends Controller
{
    
    public function index()
    {
        $data = [
            'admins' => User::where('user_type','audition-admin')->orderBy('id','desc')->get(),
        ];

        return view('SuperAdmin.auditionAdmin.index',$data);
    }

   
    public function create()
    {
        //
    }

   
    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
       $data = [
           'admin' => User::findOrFail($id),
       ];
       
       return view('SuperAdmin.auditionAdmin.edit',$data);

    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'status' => 'required',
        ]);

        $user = User::findOrFail($id);
        $user->fill($request->except('_token'));

        if ($request->hasFile('image')) {
            if ($user->image != null)
                File::delete(public_path($user->image)); //Old image delete

            $image             = $request->file('image');
            $folder_path       = 'uploads/images/users/';
            $image_new_name    = time() . '.' . $image->getClientOriginalExtension();
            //resize and save to server
            Image::make($image->getRealPath())->save($folder_path . $image_new_name);
            $user->image   = $folder_path . $image_new_name;
        }

        if ($request->hasFile('cover')) {
            if ($user->cover_photo != null)
                File::delete(public_path($user->cover_photo)); //Old image delete

            $image             = $request->file('cover');
            $folder_path       = 'uploads/images/users/';
            $image_new_name    = time() . '.' . $image->getClientOriginalExtension();
            //resize and save to server
            Image::make($image->getRealPath())->resize(879, 200)->save($folder_path . $image_new_name);
            $user->cover_photo   = $folder_path . $image_new_name;
        }

        try {
            $user->save();
            if ($user) {
                return response()->json([
                    'success' => true,
                    'message' => 'Audition Admin Updated Successfully'
                ]);
            }
        } catch (\Exception $exception) {
            return response()->json([
                'type' => 'error',
                'message' => 'Opps somthing went wrong. ' . $exception->getMessage(),
            ]);
        }
    }

   
    public function destroy($id)
    {
        $auditionAdmin = User::findOrFail($id);
        $count = Audition::where('admin_id',$id)->count();
        if ($count > 0) {
            return response()->json([
                'type' => 'error',
                'message' => 'Sorry Can\'t Delete, Admin Already Asssigned for Audition!'
            ]); 
        }
        try {
            $auditionAdmin->delete();
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
        $jury = User::findOrFail($id);
        $jury->status = 1;
        try {
            $jury->save();
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
        $jury = User::findOrFail($id);
        $jury->status = 0;
        try {
            $jury->save();
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
