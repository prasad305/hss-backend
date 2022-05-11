<?php

namespace App\Http\Controllers\ManagerAdmin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Audition\AssignAdmin;
use App\Models\Audition\Audition;
use App\Models\Audition\AuditionAssignJudge;
use App\Models\Audition\AuditionParticipant;
use App\Models\Audition\AuditionRoundRule;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\File;

class AuditionAdminController extends Controller
{
    public function index()
    {
        $auditionAdmins = User::where('user_type', 'audition-admin')->orderBy('id', 'DESC')->get();
        return view('ManagerAdmin.auditionAdmin.index', compact('auditionAdmins'));
    }


    public function juryPublished($audition_id)
    {
        $assignJuries = AuditionParticipant::select('jury_id')->get();

        $userIds = [];
        foreach ($assignJuries as $jury) {
            if($jury->jury_id != null){
                array_push($userIds, $jury->jury_id);
            }
        }

        $avaiable_juries = User::whereNotIn('id', $userIds)->where('user_type','jury')->orderBy('id', 'DESC')->get();

        $filter_videos = AuditionParticipant::where([['audition_id',$audition_id],['accept_status', 1],['filter_status', 1],['send_manager_admin',1],['jury_id', null]])->get();

        $total_jury = count($avaiable_juries);
        $total_video = count($filter_videos);

        $videoPackArray = [];
       if($total_jury > 0){
            $video_pack = floor($total_video / $total_jury);
            for ($total_jury; $total_jury > 0; $total_jury--) {
                if($total_jury == 1){
                    array_push($videoPackArray, $total_video);
                }else{
                    array_push($videoPackArray, $video_pack);
                    $total_video = $total_video - $video_pack;
                }
            }
       }

        $data = [
            'filter_videos' => $filter_videos,
            'avaiable_juries' => $avaiable_juries,
            'video_pack' => $videoPackArray,
            'audition_id' => $audition_id,
        ];

        return view('ManagerAdmin.Audition.jury_published',$data);
    }

    public function assinged()
    {
        $assignAdmins = AssignAdmin::select('assign_person')->get();

        $userIds = [];
        foreach ($assignAdmins as $assignAdmin) {
            array_push($userIds, $assignAdmin->assign_person);
        }
        $auditionAdmins = User::whereIn('id', $userIds)->orderBy('id', 'DESC')->get();

        return view('ManagerAdmin.auditionAdmin.index', compact('auditionAdmins'));
    }

    public function notAssinged()
    {
        $assignAdmins = AssignAdmin::select('assign_person')->get();

        $userIds = [];
        foreach ($assignAdmins as $assignAdmin) {
            array_push($userIds, $assignAdmin->assign_person);
        }
        $auditionAdmins = User::whereNotIn('id', $userIds)->where('user_type', 'audition-admin')->orderBy('id', 'DESC')->get();
        return view('ManagerAdmin.auditionAdmin.index', compact('auditionAdmins'));
    }


    public function instruction($audition_id){
        $audition = Audition::find($audition_id);
         $data = [
            'instruction' => AuditionRoundRule::find($audition->audition_round_rules_id),
            'audition' => $audition,
        ];
        return view('ManagerAdmin.Audition.instruction',$data);
    }

    public function sendInstructionToParticipant($audition_id){

        $audition = Audition::find($audition_id);

        $instruction = AuditionRoundRule::find($audition->audition_round_rules_id);
        $instruction->status = 2;
        $instruction->save();

        $participants = AuditionParticipant::where('audition_id',$audition_id)->update([
            'audition_round_rules_id' => $audition->audition_round_rules_id,
        ]);

        session()->flash('success','Send To Participant Successfully');
        return redirect()->back();
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('ManagerAdmin.auditionAdmin.create');
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
            if ($user) {
                return response()->json([
                    'success' => true,
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

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $auditionAdmin
     * @return \Illuminate\Http\Response
     */
    public function show(User $auditionAdmin)
    {
        if ($auditionAdmin->status == 0) {
            session()->flash('error', 'This Admin Need to Approval First');
            return redirect()->back();
        }
        return view('ManagerAdmin.auditionAdmin.details')->with('auditionAdmin', $auditionAdmin);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $auditionAdmin
     * @return \Illuminate\Http\Response
     */
    public function edit(User $auditionAdmin)
    {
        $data['auditionAdmin'] = $auditionAdmin;
        return view('ManagerAdmin.auditionAdmin.edit', $data);
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

    //<=================== Audition Logic by srabon =============================

    public function all()
    {
        $audition = Audition::where('status','>',1)->latest()->get();

        return view('ManagerAdmin.Audition.index', compact('audition'));
    }

    public function pending()
    {
        $audition = Audition::where('status', 2CategoryController)->latest()->get();
        return view('ManagerAdmin.Audition.index', compact('audition'));
    }

    public function published()
    {
        $audition = Audition::where('status', 3)->latest()->get();
        return view('ManagerAdmin.Audition.index', compact('audition'));
    }

    public function details($id)
    {
        $audition = Audition::find($id);
        $judges = AuditionAssignJudge::where('audition_id',$audition->id)->get();
        return view('ManagerAdmin.Audition.details')->with('audition',$audition)->with('judges', $judges);
    }


    public function auditionEdit($id)
    {
        $audition = Audition::find($id);

        return view('ManagerAdmin.Audition.edit', compact('audition'));
    }

    public function auditionUpdate(Request $request, $id)
    {
        $audition = Audition::findOrFail($id);
        $audition->fill($request->except('_token'));

        $audition->title = $request->input('title');
        $audition->description = $request->input('description');

        // $meetup->event_link= $request->input('event_link');
        // $meetup->meetup_type = $request->input('meetup_type');
        // $meetup->date = $request->input('date');
        // $meetup->start_time = $request->input('start_time');
        // $meetup->end_time = $request->input('end_time');
        // $meetup->venue = $request->input('venue');

        if ($request->hasfile('banner')) {

            // $destination = $meetup->image;
            // if (File::exists($destination)) {
            //     File::delete($destination);
            // }

            $file = $request->file('banner');
            $extension = $file->getClientOriginalExtension();
            $filename = 'uploads/images/auditions/' . time() . '.' . $extension;

            Image::make($file)->resize(900, 400)->save($filename, 50);
            $audition->banner = $filename;
        }


        try {
            $audition->update();
            if ($audition) {
                return response()->json([
                    'success' => true,
                    'message' => 'Updated Successfully'
                ]);
            }
        } catch (\Exception $exception) {
            return response()->json([
                'type' => 'error',
                'message' => 'Opps somthing went wrong. ' . $exception->getMessage(),
            ]);
        }
    }

    public function set_publish($id)
    {
        $audition = Audition::find($id);

        if ($audition->status == 3) {
            $audition->status = 2;
            $audition->update();

            $post =  Post::where('type','audition')->where('event_id',$audition->id)->first();
            if ($post) {
                $post->delete();
            }

        } else {
            $audition->status = 3;
            $audition->update();
            $post =  Post::where('type','audition')->where('event_id',$audition->id)->first();
            $category_id = Auth::user()->category_id;

            if (!isset($post)) {
                Post::create([
                    'type' => 'audition',
                    'category_id' => $category_id,
                    'user_id' => '1',
                    'event_id' => $audition->id,
                    'title' => $audition->title,
                    'details' => $audition->description,
                    'status' => 1,
                    ]);
            }
        }

        return redirect()->back()->with('success', 'Published');
    }


    public function auditionAdmins(){
        return view('ManagerAdmin.Audition.admins');
    }


    public function adminAssign(){
        return view('ManagerAdmin.Audition.adminAssign');
    }

    public function adminAssignSubmit(){
        return view('ManagerAdmin.Audition.adminAssignSubmit');
    }
    public function auditionDashboard(){
        return view('ManagerAdmin.Audition.auditionAdminDashboard');
    }
    public function auditionJuries(){
        return view('ManagerAdmin.Audition.juries');
    }
    public function auditionEvents(){

        
       $round_rules = AuditionRoundRule::where('status',1)->get();
       
       foreach ($round_rules as $key => $rule) {
            $auditions = Audition::where('audition_round_rules_id',[$rule->id])->get();
       }

         $data = [
            'pending_instructions' => $round_rules,
            'auditions' => $auditions,
        ];
        return view('ManagerAdmin.Audition.events',$data);
    }
}

