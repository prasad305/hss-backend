<?php

namespace App\Http\Controllers\ManagerAdmin\Audition;

use App\Http\Controllers\Controller;
use App\Models\Audition\AssignAdmin;
use App\Models\Audition\Audition;
use App\Models\Audition\AuditionRules;
use App\Models\Audition\AuditionAssignJury;
use App\Models\Audition\AuditionAssignJudge;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class AuditionAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $auditionAdmins = User::where('user_type', 'audition-admin')->orderBy('id', 'DESC')->get();
        return view('ManagerAdmin.Audition.auditionAdmin.index', compact('auditionAdmins'));
    }

    public function assinged()
    {
        $assignAdmins = Audition::select('audition_admin_id')->get();

        $userIds = [];
        foreach ($assignAdmins as $assignAdmin) {
            array_push($userIds, $assignAdmin->audition_admin_id);
        }
        $auditionAdmins = User::whereIn('id', $userIds)->orderBy('id', 'DESC')->get();

        return view('ManagerAdmin.Audition.auditionAdmin.index', compact('auditionAdmins'));
    }

    public function notAssinged()
    {
        $assignAdmins =  Audition::select('audition_admin_id')->get();

        $userIds = [];
        foreach ($assignAdmins as $assignAdmin) {
            array_push($userIds, $assignAdmin->audition_admin_id);
        }
        $auditionAdmins = User::whereNotIn('id', $userIds)->where('user_type', 'audition-admin')->orderBy('id', 'DESC')->get();
         return view('ManagerAdmin.Audition.auditionAdmin.index', compact('auditionAdmins'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::orderBy('name','ASC')->get();
        return view('ManagerAdmin.Audition.auditionAdmin.create', compact('categories'));
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
            'email' => 'required|unique:users',
            'phone' => 'required|unique:users',
            // 'category' => 'required|exists:categories,id',
        ]);

        $user = new User();
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->password = Hash::make('12345');
        $user->user_type = 'audition-admin'; // Admin user_type == 'audition-admin'
        $user->otp = rand(100000, 999999);
        $user->status = 0;
        $user->category_id = Auth::user()->category_id;

        if ($request->hasFile('image')) {
            $image             = $request->file('image');
            $folder_path       = 'uploads/images/users/';
            $image_new_name    = Str::random(10) . '-' . now()->timestamp . '.' . $image->getClientOriginalExtension();
            //resize and save to server
            Image::make($image->getRealPath())->save($folder_path . $image_new_name);
            $user->image   = $folder_path . $image_new_name;
        }

        if ($request->hasFile('cover_photo')) {
            $image             = $request->file('cover_photo');
            $folder_path       = 'uploads/images/users/';
            $image_new_name    = Str::random(10) . '-' . now()->timestamp . '.' . $image->getClientOriginalExtension();
            //resize and save to server
            Image::make($image->getRealPath())->resize(879, 200)->save($folder_path . $image_new_name);
            $user->cover_photo   = $folder_path . $image_new_name;
        }
        try {
            $user->save();
            if ($user) {
                return response()->json([
                    'success' => true,
                    'message' => 'Successfully Stored'
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $auditionAdmin)
    {
        if ($auditionAdmin->status == 0) {
            session()->flash('error', 'This Admin Need to Approval First');
            return redirect()->back();
        }
        $auditionRule = AuditionRules::where('category_id', Auth::user()->category_id)->orderBy('id','DESC')->first();

        // for not assigned juries
        $auditionAssignJurys = AuditionAssignJury::select('jury_id')->get();

        $userIds = [];
        foreach ($auditionAssignJurys as $AuditionAssignJury) {
            array_push($userIds, $AuditionAssignJury->jury_id);
        }
        $juries = User::whereNotIn('id', $userIds)->where('user_type', 'jury')->where('category_id', Auth::user()->category_id)->orderBy('id', 'DESC')->get();

        // for not assigned judge
        $auditionAssignJudges = AuditionAssignJudge::select('judge_id')->get();

        $userIds = [];
        foreach ($auditionAssignJudges as $AuditionAssignJudge) {
            array_push($userIds, $AuditionAssignJudge->judge_id);
        }
        $judges = User::whereNotIn('id', $userIds)->where('user_type', 'judge')->where('category_id', Auth::user()->category_id)->orderBy('id', 'DESC')->get();

        return view('ManagerAdmin.Audition.auditionAdmin.show', compact('auditionAdmin', 'juries', 'judges','auditionRule'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $auditionAdmin)
    {
        $categories = Category::orderBy('name','ASC')->get();
        return view('ManagerAdmin.Audition.auditionAdmin.edit', compact('auditionAdmin','categories'));
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
            'email' => 'required|unique:users,email,'.$id,
            'phone' => 'required|unique:users,phone,'.$id,
            // 'category' => 'required|exists:categories,id',
        ]);

        $user = User::find($id);
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->phone = $request->phone;
        $user->email = $request->email;
        // $user->category_id = $request->category;

        if ($request->hasFile('image')) {
            if($user->image != null){
                File::delete(public_path($user->image));
            }
            $image             = $request->file('image');
            $folder_path       = 'uploads/images/users/';
            $image_new_name    = Str::random(10) . '-' . now()->timestamp . '.' . $image->getClientOriginalExtension();
            //resize and save to server
            Image::make($image->getRealPath())->save($folder_path . $image_new_name);
            $user->image   = $folder_path . $image_new_name;
        }

        if ($request->hasFile('cover_photo')) {
            if($user->cover_photo != null){
                File::delete(public_path($user->cover_photo));
            }
            $image             = $request->file('cover_photo');
            $folder_path       = 'uploads/images/users/';
            $image_new_name    = Str::random(10) . '-' . now()->timestamp . '.' . $image->getClientOriginalExtension();
            //resize and save to server
            Image::make($image->getRealPath())->resize(879, 200)->save($folder_path . $image_new_name);
            $user->cover_photo   = $folder_path . $image_new_name;
        }
        try {
            $user->save();
            if ($user) {
                return response()->json([
                    'success' => true,
                    'message' => 'Successfully Updated'
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
}