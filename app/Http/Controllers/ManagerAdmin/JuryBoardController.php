<?php

namespace App\Http\Controllers\ManagerAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Audition\AuditionParticipant;
use App\Models\JuryBoard;
use App\Models\JuryGroup;
use App\Models\SubCategory;
use App\Models\User;
use App\Models\Audition\AuditionAssignJury;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\File;

class JuryBoardController extends Controller
{
    public function index()
    {
        $data = [
            // 'juries' =>  User::where([['category_id',auth()->user()->category_id],['user_type', 'jury']])->orderBy('id', 'DESC')->get(),
            'group' => JuryGroup::with('board')->where('category_id',auth()->user()->category_id)->get(),
            
        ];

        return view('ManagerAdmin.jury.index', $data);
    }

    public function views($jury_id)
    {
        
        $data = [
            // 'jury' =>  User::findOrFail($jury_id),
            'jury' => JuryBoard::findOrFail($jury_id),

        ];
        // dd($data);
        return view('ManagerAdmin.jury.views', $data);
    }

    public function assignVideo(Request $request)
    {

        $request->validate([
            'jury_id' => 'required',
            'number_of_videos' => 'required'
        ]);

        $filter_videos = AuditionParticipant::where([['audition_id', $request->audition_id], ['accept_status', 1], ['filter_status', 1], ['send_manager_admin', 1], ['jury_id', null]])->take($request->number_of_videos)->get();

       foreach ($filter_videos as $key => $video) {
           $video->jury_id = $request->jury_id;
           $video->save();
       }

       session()->flash('success', 'Jury Assigned Successfully!');
       return redirect()->back();
    }


    public function create()
    {
        $data = [
            'sub_categories' => SubCategory::where([['status', 1],['category_id',auth()->user()->category_id]])->orderBy('name', 'asc')->get(),
            'groups' => JuryGroup::where([['status',1],['category_id',auth()->user()->category_id]])->orderBy('name', 'asc')->get(),
        ];
        return view('ManagerAdmin.jury.create', $data);
    }


    public function store(Request $request)
    {
        $request->validate(
            [
            'first_name' => 'required',
            'last_name' => 'required',
            'sub_category_id' => 'required',
            'image' => 'mimes:jpeg,jpg,png,gif|max:2000',
            'cover' => 'mimes:jpeg,jpg,png,gif|max:2000',
            'terms_and_condition' => 'required',
            ],[
                'sub_category_id.required' => 'The sub category field is required',
            ]
        );


        $user = new User();

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->user_type = 'jury';
        $user->category_id = auth()->user()->category_id;
        $user->sub_category_id = $request->sub_category_id;
        $user->created_by = createdBy();
        // $user->parent_user = auth()->user()->id;

        if ($request->hasFile('image')) {
            $image             = $request->file('image');
            $folder_path       = 'uploads/images/users/juries/';
            $image_new_name    = time() . '.' . $image->getClientOriginalExtension();
            //resize and save to server
            Image::make($image->getRealPath())->save($folder_path . $image_new_name);
            $user->image   = $folder_path . $image_new_name;
        }

        if ($request->hasFile('cover')) {
            $image             = $request->file('cover');
            $folder_path       = 'uploads/images/users/juries/';
            $image_new_name    = time() . '.' . $image->getClientOriginalExtension();
            //resize and save to server
            Image::make($image->getRealPath())->resize(879, 200)->save($folder_path . $image_new_name);
            $user->cover_photo   = $folder_path . $image_new_name;
        }

        try {
            $user->save();

            $jury = new JuryBoard();
            $jury->star_id = $user->id;
            $jury->group_id = $request->group_id;
            // $jury->admin_id = auth()->user()->id;
            // $jury->category_id = $request->category_id;
            // $jury->sub_category_id = $request->sub_category_id;
            $jury->terms_and_condition = $request->terms_and_condition;
            $jury->qr_code = rand(10000000, 99999999);
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

    public function show($search)
    {
        $data = [
            'juries' =>  User::when($search != null,function($query) use($search){
                return $query->where('first_name','like','%'.$search.'%')->orWhere('last_name','like','%'.$search.'%');
            })->where('user_type', 'jury')->orderBy('id', 'DESC')->get(),
            'search' => $search,

        ];
        return view('ManagerAdmin.jury.index', $data);
    }

    public function edit($id)
    {
       $data = [
            'jury' => JuryBoard::findOrFail($id),
            'sub_categories' => SubCategory::where([['status', 1],['category_id',auth()->user()->category_id]])->orderBy('id', 'DESC')->get(),
            'groups' => JuryGroup::where([['status',1],['category_id',auth()->user()->category_id]])->orderBy('name', 'asc')->get(),
        ];
        return view('ManagerAdmin.jury.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $request->validate(
            [
            'first_name' => 'required',
            'last_name' => 'required',
            'sub_category_id' => 'required',
            'image' => 'mimes:jpeg,jpg,png,gif|max:2000',
            'cover' => 'mimes:jpeg,jpg,png,gif|max:2000',
            'terms_and_condition' => 'required',
            ],[
                'sub_category_id.required' => 'The sub category field is required',
            ]
        );

        $user = User::find($id);

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->category_id = auth()->user()->category_id;
        $user->sub_category_id = $request->sub_category_id;

        $user->created_by = updatedBy();

        if ($request->hasFile('image')) {
            if ($user->image != null)
                File::delete(public_path($user->image)); //Old image delete

            $image             = $request->file('image');
            $folder_path       = 'uploads/images/users/juries/';
            $image_new_name    = time() . '.' . $image->getClientOriginalExtension();
            //resize and save to server
            Image::make($image->getRealPath())->save($folder_path . $image_new_name);
            $user->image   = $folder_path . $image_new_name;
        }

        if ($request->hasFile('cover')) {
            if ($user->cover_photo != null)
                File::delete(public_path($user->cover_photo)); //Old image delete

            $image             = $request->file('cover');
            $folder_path       = 'uploads/images/users/juries/';
            $image_new_name    = time() . '.' . $image->getClientOriginalExtension();
            //resize and save to server
            Image::make($image->getRealPath())->resize(879, 200)->save($folder_path . $image_new_name);
            $user->cover_photo   = $folder_path . $image_new_name;
        }

        try {
            $user->save();

            $jury = JuryBoard::where('star_id', $user->id)->first();
            $jury->group_id = $request->group_id;
            $jury->terms_and_condition = $request->terms_and_condition;
            $jury->save();

            if ($jury) {
                return response()->json([
                    'success' => true,
                    'message' => 'Jury Updated Successfully!'
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
       $JuryBoard = JuryBoard::find($id);
       $juryId =  $JuryBoard->assignjuries->id;
       $jury = User::find($juryId);

       $assignJuryId = $JuryBoard->star_id;
       $AuditionAssignJury = AuditionAssignJury::where('jury_id',$assignJuryId)->first();
       $test = $AuditionAssignJury->jury_id;
        if ($test) {
            return response()->json([
                'type' => 'error',
                'message' => "You won't be able to delete this!"
            ]);
       }else{
        try {
            if ($jury->image != null)
                File::delete(public_path($jury->image)); //Old image delete

            if ($jury->cover_photo != null)
                File::delete(public_path($jury->cover_photo)); //Old image delete

            $delete = $jury->delete();

            if ($delete) {
                JuryBoard::find($id)->delete();
            }

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
