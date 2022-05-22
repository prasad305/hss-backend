<?php

namespace App\Http\Controllers\ManagerAdmin;

use App\Http\Controllers\Controller;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\File;

class SuperStarController extends Controller
{
    public function index()
    {
        $stars = User::where('user_type', 'star')->orderBy('id', 'DESC')->get();
        return view('ManagerAdmin.stars.index', compact('stars'));
    }

    public function create()
    {
        $data = [
            'sub_categories' => SubCategory::where('category_id',auth()->user()->category_id)->orderBY('id','desc')->get(),
        ];
        return view('ManagerAdmin.stars.create',$data);
    }

   
    public function store(Request $request)
    {
        
        $request->validate([
            'sub_category_id' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'dob' => 'required',
        ]);

        $user = new User();
        $user->fill($request->except('_token'));
        $user->user_type = 'star'; // Admin user_type == 'star'
        $user->category_id = auth()->user()->category_id;
        $user->sub_category_id = $request->sub_category_id;
        $user->dob = $request->dob;
        $user->address = $request->address;
        $user->details = $request->details;
        $user->created_by = createdBy();
        try {
            $user->save();
            if ($user) {
                return response()->json([
                    'success' => true,
                    'message' => 'Star Added Successfully'
                ]);
            }
        } catch (\Exception $exception) {
            return response()->json([
                'type' => 'error',
                'message' => 'Opps somthing went wrong. ' . $exception->getMessage(),
            ]);
        }
    }

  
    public function show(User $star)
    {
 
        return view('ManagerAdmin.stars.details')->with('auditionAdmin', $star);
    }

 
    public function edit(User $star)
    {
        $data = [
            'star' => $star,
            'sub_categories' => SubCategory::where('category_id',auth()->user()->category_id)->orderBY('id','desc')->get(),
        ];
        return view('ManagerAdmin.stars.edit', $data);
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'sub_category_id' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'dob' => 'required',
        ]);

        $user = User::findOrFail($id);
        $user->fill($request->except('_token'));
        $user->dob = $request->dob;
        $user->address = $request->address;
        $user->details = $request->details;
        $user->sub_category_id = $request->sub_category_id;
        $user->updated_by = updatedBy();

        try {
            $user->save();
            if ($user) {
                return response()->json([
                    'success' => true,
                    'message' => 'Star Updated Successfully'
                ]);
            }
        } catch (\Exception $exception) {
            return response()->json([
                'type' => 'error',
                'message' => 'Opps somthing went wrong. ' . $exception->getMessage(),
            ]);
        }
    }

    
    public function destroy(User $star)
    {
        try {
            if ($star->cover_photo != null)
                File::delete(public_path($star->cover_photo)); 

            if ($star->image != null)
                File::delete(public_path($star->image)); 

            
            $star->delete();
            
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
