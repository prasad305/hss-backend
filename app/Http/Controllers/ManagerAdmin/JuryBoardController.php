<?php

namespace App\Http\Controllers\ManagerAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Audition\AssignAdmin;
use App\Models\Category;
use App\Models\JuryBoard;
use App\Models\SubCategory;
use App\Models\SuperStar;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\File;

class JuryBoardController extends Controller
{
    public function index()
    {
        $data = [
            'juries' =>  User::where('user_type', 'jury')->orderBy('id', 'DESC')->get(),

        ];
        return view('ManagerAdmin.jury.index', $data);
    }

    public function views()
    {
        $data = [
            'juries' =>  User::where('user_type', 'jury')->orderBy('id', 'DESC')->get(),

        ];
        return view('ManagerAdmin.jury.views', $data);
    }

    public function assinged()
    {
        $assignAdmins = AssignAdmin::select('assign_person')->get();

        $userIds = [];
        foreach ($assignAdmins as $assignAdmin) {
            array_push($userIds, $assignAdmin->assign_person);
        }
        $juries = User::whereIn('id', $userIds)->orderBy('id', 'DESC')->get();
        return view('ManagerAdmin.jury.index', compact('auditionAdmins'));
    }

    public function notAssinged()
    {
        $assignAdmins = AssignAdmin::select('assign_person')->get();

        $userIds = [];
        foreach ($assignAdmins as $assignAdmin) {
            array_push($userIds, $assignAdmin->assign_person);
        }
        $juries = User::whereNotIn('id', $userIds)->where('user_type', 'audition-admin')->orderBy('id', 'DESC')->get();
        return view('ManagerAdmin.jury.index', compact('auditionAdmins'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'categories' => Category::where('status', 1)->orderBy('id', 'DESC')->get(),
            'sub_categories' => SubCategory::where('status', 1)->orderBy('id', 'DESC')->get()
        ];
        return view('ManagerAdmin.jury.create', $data);
    }

    public function getSubCategory($category_id)
    {
        return SubCategory::when($category_id > 0, function ($query) use ($category_id) {
                                return $query->where('category_id', $category_id);
                            })->orderBy('id', 'DESC')->get();
    }


    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'category_id' => 'required',
            'sub_category_id' => 'required',
        ]);

        // return $request->all();

        $user = new User();

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->user_type = 'jury';
        $user->parent_user = auth()->user()->id;

        if ($request->hasFile('image')) {
            $image             = $request->file('image');
            $folder_path       = 'uploads/images/users/';
            $image_new_name    = time() . '.' . $image->getClientOriginalExtension();
            //resize and save to server
            Image::make($image->getRealPath())->save($folder_path . $image_new_name);
            $user->image   = $folder_path . $image_new_name;
        }

        if ($request->hasFile('cover')) {
            $image             = $request->file('cover');
            $folder_path       = 'uploads/images/users/';
            $image_new_name    = time() . '.' . $image->getClientOriginalExtension();
            //resize and save to server
            Image::make($image->getRealPath())->resize(879, 200)->save($folder_path . $image_new_name);
            $user->cover_photo   = $folder_path . $image_new_name;
        }

        try {
            $user->save();

            $jury = new JuryBoard();

            $jury->star_id = $user->id;
            $jury->admin_id = auth()->user()->id;
            $jury->category_id = $request->category_id;
            $jury->sub_category_id = $request->sub_category_id;
            $jury->terms_and_condition = $request->terms_and_condition;
            $jury->qr_code = rand( 10000000 , 99999999 );


            $jury->save();

            if ($jury) {
                return response()->json([
                    'success' => true,
                    'message' => 'Jury Added Successfully'
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
     * Display the specified resource.
     *
     * @param  \App\Models\User  $auditionAdmin
     * @return \Illuminate\Http\Response
     */
    public function show(User $jury)
    {
        if ($jury->status == 0) {
            session()->flash('error', 'This Admin Need to Approval First');
            return redirect()->back();
        }
        $data = [
            'jury' => $jury,
        ];
        return view('ManagerAdmin.jury.details',$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $auditionAdmin
     * @return \Illuminate\Http\Response
     */
    public function edit(User $jury)
    {
        $data = [
            'jury' => $jury,
            'categories' => Category::where('status', 1)->orderBy('id', 'DESC')->get(),
            'sub_categories' => SubCategory::where('status', 1)->orderBy('id', 'DESC')->get()
        ];
        return view('ManagerAdmin.jury.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $auditionAdmin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'category_id' => 'required',
            'sub_category_id' => 'required',
        ]);

        $user = User::find($id);

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->parent_user = auth()->user()->id;

        if ($request->hasFile('image')) {
            $image             = $request->file('image');
            $folder_path       = 'uploads/images/users/';
            $image_new_name    = time() . '.' . $image->getClientOriginalExtension();
            //resize and save to server
            Image::make($image->getRealPath())->save($folder_path . $image_new_name);
            $user->image   = $folder_path . $image_new_name;
        }

        if ($request->hasFile('cover')) {
            $image             = $request->file('cover');
            $folder_path       = 'uploads/images/users/';
            $image_new_name    = time() . '.' . $image->getClientOriginalExtension();
            //resize and save to server
            Image::make($image->getRealPath())->resize(879, 200)->save($folder_path . $image_new_name);
            $user->cover_photo   = $folder_path . $image_new_name;
        }

        try {
            $user->save();

            $jury = JuryBoard::where('star_id', $user->id)->first();

            $jury->category_id = $request->category_id;
            $jury->sub_category_id = $request->sub_category_id;
            $jury->terms_and_condition = $request->terms_and_condition;

            $jury->save();

            if ($jury) {
                return response()->json([
                    'success' => true,
                    'message' => 'Jury Updated Successfully'
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
     * @param  \App\Models\User  $auditionAdmin
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $auditionAdmin)
    {
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
