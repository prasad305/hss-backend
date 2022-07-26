<?php

namespace App\Http\Controllers\ManagerAdmin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Audition\AssignAdmin;
use App\Models\Audition\Audition;
use App\Models\Audition\AuditionAssignJudge;
use App\Models\Audition\AuditionParticipant;
use App\Models\Audition\AuditionPromoInstruction;
use App\Models\Audition\AuditionRoundRule;
use App\Models\Post;
use App\Models\SubCategory;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\File;

class AuditionAdminController extends Controller
{
    public function index()
    {
        $auditionAdmins = User::where([['category_id', auth()->user()->category_id], ['user_type', 'audition-admin']])->orderBy('id', 'DESC')->get();
        return view('ManagerAdmin.auditionAdmin.index', compact('auditionAdmins'));
    }




    public function juryPublished($audition_id)
    {
        $assignJuries = AuditionParticipant::select('jury_id')->get();

        $userIds = [];
        foreach ($assignJuries as $jury) {
            if ($jury->jury_id != null) {
                array_push($userIds, $jury->jury_id);
            }
        }

        $avaiable_juries = User::whereNotIn('id', $userIds)->where('user_type', 'jury')->orderBy('id', 'DESC')->get();

        $filter_videos = AuditionParticipant::where([['audition_id', $audition_id], ['accept_status', 1], ['filter_status', 1], ['send_manager_admin', 1], ['jury_id', null]])->get();

        $total_jury = count($avaiable_juries);
        $total_video = count($filter_videos);

        $videoPackArray = [];
        if ($total_jury > 0) {
            $video_pack = floor($total_video / $total_jury);
            for ($total_jury; $total_jury > 0; $total_jury--) {
                if ($total_jury == 1) {
                    array_push($videoPackArray, $total_video);
                } else {
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

        return view('ManagerAdmin.Audition.jury_published', $data);
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


    public function instruction($audition_id)
    {
        $audition = Audition::find($audition_id);
        $data = [
            'instruction' => AuditionRoundRule::find($audition->audition_round_rules_id),
            'audition' => $audition,
        ];
        return view('ManagerAdmin.Audition.instruction', $data);
    }

    public function sendInstructionToParticipant($audition_id)
    {

        $audition = Audition::find($audition_id);

        $instruction = AuditionRoundRule::find($audition->audition_round_rules_id);
        $instruction->status = 2;
        $instruction->save();

        $participants = AuditionParticipant::where('audition_id', $audition_id)->update([
            'audition_round_rules_id' => $audition->audition_round_rules_id,
        ]);

        session()->flash('success', 'Send To Participant Successfully');
        return redirect()->back();
    }


    public function create()
    {
        $data = [
            'sub_categories' => SubCategory::where('category_id', auth()->user()->category_id)->orderBy('name', 'asc')->get(),
        ];
        return view('ManagerAdmin.auditionAdmin.create', $data);
    }


    public function store(Request $request)
    {
        $request->validate([
            'sub_category_id' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|unique:users',
            'phone' => 'required|numeric|min:11|unique:users',
            'image' => 'mimes:jpeg,jpg,png,gif|max:2000',
            'cover' => 'mimes:jpeg,jpg,png,gif|max:2000',
        ], [
            'sub_category_id.required' => 'The Category Field is Required',
        ]);



        $user = new User();
        $user->fill($request->except(['_token', 'image', 'cover']));
        $user->password = Hash::make('12345');
        $user->user_type = 'audition-admin'; // Admin user_type == 'audition-admin'
        $user->otp = rand(100000, 999999);
        $user->category_id = auth()->user()->category_id;
        $user->sub_category_id = $request->sub_category_id;
        $user->created_by = createdBy();
        // $user->status = 0;

        if ($request->hasFile('image')) {
            $image             = $request->file('image');
            $folder_path       = 'uploads/images/users/audition_admins/';
            $image_new_name    = time() . '.' . $image->getClientOriginalExtension();
            //resize and save to server
            Image::make($image->getRealPath())->save($folder_path . $image_new_name);
            $user->image   = $folder_path . $image_new_name;
        }

        if ($request->hasFile('cover')) {
            $image             = $request->file('cover');
            $folder_path       = 'uploads/images/users/audition_admins/cover/';
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
                    'message' => 'Audition Admin Added Successfully'
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
        $search_text = $search;
        $auditionAdmins = User::when($search != null, function ($query) use ($search) {
            return $query->where('first_name', 'like', '%' . $search . '%')->orWhere('last_name', 'like', '%' . $search . '%');
        })->where('user_type', 'audition-admin')->orderBy('id', 'DESC')->get();

        return view('ManagerAdmin.auditionAdmin.index', compact('auditionAdmins', 'search_text'));
    }


    public function edit(User $auditionAdmin)
    {
        $data = [
            'auditionAdmin' => $auditionAdmin,
            'sub_categories' => SubCategory::where('category_id', auth()->user()->category_id)->orderBy('name', 'asc')->get(),
        ];
        return view('ManagerAdmin.auditionAdmin.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'sub_category_id' => 'required',
                'first_name' => 'required',
                'last_name' => 'required',
                // 'email' => 'required',
                // 'phone' => 'required',
                'image' => 'mimes:jpeg,jpg,png,gif|max:2000',
                'cover' => 'mimes:jpeg,jpg,png,gif|max:2000',
            ],
            [
                'sub_category_id.required' => 'The Category Field is Required',
            ]
        );

        $user = User::findOrFail($id);
        $user->fill($request->except('_token'));
        $user->sub_category_id = $request->sub_category_id;
        $user->updated_by = updatedBy();

        if ($request->hasFile('image')) {
            if ($user->image != null)
                File::delete(public_path($user->image)); //Old image delete

            $image             = $request->file('image');
            $folder_path       = 'uploads/images/users/audition_admins/';
            $image_new_name    = time() . '.' . $image->getClientOriginalExtension();
            //resize and save to server
            Image::make($image->getRealPath())->save($folder_path . $image_new_name);
            $user->image   = $folder_path . $image_new_name;
        }

        if ($request->hasFile('cover')) {
            if ($user->cover_photo != null)
                File::delete(public_path($user->cover_photo)); //Old image delete

            $image             = $request->file('cover');
            $folder_path       = 'uploads/images/users/audition_admins/cover/';
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

    public function customSearch($text)
    {
        return $text;
    }


    public function destroy(User $auditionAdmin)
    {
        try {
            if ($auditionAdmin->cover_photo != null)
                File::delete(public_path($auditionAdmin->cover_photo));

            if ($auditionAdmin->image != null)
                File::delete(public_path($auditionAdmin->image));

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

    //<=================== Audition Logic by srabon =============================

    public function all()
    {
        $audition = Audition::where('status', '>', 1)->latest()->get();

        return view('ManagerAdmin.Audition.index', compact('audition'));
    }

    public function pending()
    {
        $audition = Audition::where('status', 2)->latest()->get();
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
        $judges = AuditionAssignJudge::where('audition_id', $audition->id)->get();
        return view('ManagerAdmin.Audition.details')->with('audition', $audition)->with('judges', $judges);
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

            $post =  Post::where('type', 'audition')->where('event_id', $audition->id)->first();
            if ($post) {
                $post->delete();
            }
        } else {
            $audition->status = 3;
            $audition->update();
            $post =  Post::where('type', 'audition')->where('event_id', $audition->id)->first();
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

    public function manager_audition_set_publish(Request $request,$audition_id)
    {
        $audition = Audition::find($audition_id);

        if ($audition->status != 2) {
            $request->validate([
                'post_start_date' => 'required',
                'post_end_date' => 'required',
            ]);
            $audition->status = 2;
            $audition->update();

        //    return $audition->star;

            // Create New post //
            $post = new Post();
            $post->type = 'audition';
            $post->event_id = $audition->id;
            $post->category_id = $audition->category_id;
            // $post->sub_category_id = $audition->sub_category_id;
            $post->post_start_date = Carbon::parse($request->post_start_date);
            $post->post_end_date = Carbon::parse($request->post_end_date);
            $post->save();
            return redirect()->back()->with('success', 'Published');
        } else {
            //$audition->manager_approval = 0;
            $audition->status = 10;
            $audition->update();

            //Remove post //
            $post = Post::where([['event_id', $audition->id],['type','audition']])->first();
            $post->delete();
            return redirect()->back()->with('error', 'Unpublished');
        }


    }



    public function auditionAdmins()
    {
        return view('ManagerAdmin.Audition.admins');
    }


    public function adminAssign()
    {
        return view('ManagerAdmin.Audition.adminAssign');
    }

    public function adminAssignSubmit()
    {
        return view('ManagerAdmin.Audition.adminAssignSubmit');
    }
    public function auditionDashboard()
    {
        return view('ManagerAdmin.Audition.auditionAdminDashboard');
    }
    public function auditionJuries()
    {
        return view('ManagerAdmin.Audition.juries');
    }
    public function auditionEvents()
    {
        $auditions =  Audition::where('category_id', auth()->user()->category_id )->get();
        return view('ManagerAdmin.Audition.events',compact('auditions'));
    }

    public function getPromoInstruction($audition_id){
        $event = Audition::where([['id',$audition_id]])->first();
        $instruction = AuditionPromoInstruction::where([['audition_id',$audition_id],['send_to_manager',1]])->first();
        return view('ManagerAdmin.Audition.promo_instruction',compact('instruction','event'));
    }

    public function getRoundInstruction($audition_id){
         $event = Audition::find($audition_id);
        return view('ManagerAdmin.Audition.round_instruction',compact('event'));
    }


    public function getRoundResult(){
        $auditions = Audition::where([['status','>=',2],['category_id', auth()->user()->category_id]])->get();
        return view('ManagerAdmin.Audition.round_result',compact('auditions'));
    }

    public function showRoundResult($audition_id){
         $event = Audition::find($audition_id);
        return view('ManagerAdmin.Audition.show_round_result',compact('event'));
    }

    public function registrationRules()
    {
        $data = [
            'auditions' => Audition::where('category_id', auth()->user()->category_id)
                ->get(),
        ];
        return view('ManagerAdmin.registrationRule.index', $data);
    }

    public function createRegistrationRules($audition_id)
    {
        $audition = Audition::find($audition_id);
        $groups = json_decode($audition->auditionRules->jury_groups);
         $round_rules = AuditionRoundRule::where('audition_rules_id', $audition->audition_rules_id)->get();

        $data = [
            'audition' => $audition,
            'groups' => $groups->{'groups_id'},
            'juries_num' => $groups->{'group_members'},
            'round_rules' => $round_rules,
        ];

        return view('ManagerAdmin.registrationRule.create', $data);
    }


    public function storeRegistrationRules(Request $request)
    {
        // return $request->all();
        $request->validate([
            'registration_start_date' => 'required',
            'registration_end_date' => 'required',
            'final_result_published_date' => 'required',
            'fees' => 'required',
        ]);

        $audition = Audition::find($request->audition_id);
        $audition->user_reg_start_date = date('Y-m-d',strtotime($request->registration_start_date));
        $audition->user_reg_end_date = date('Y-m-d',strtotime($request->registration_end_date));
        $audition->final_result_published_date = $request->final_result_published_date;
        $audition->fees = $request->fees;

        try {
            $audition->save();
            foreach ($request->round_ids as $key => $round) {
                AuditionRoundRule::where('id', $round)->update(
                    [
                        'start_date' => $request->round_start_date[$key],
                        'end_date' => $request->round_end_date[$key],
                    ]
                );
            }
            return response()->json([
                'status' => 200,
                'message' => 'Audition Rules Updated Successfully!',
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'type' => 'error',
                'message' => $exception->getMessage(),
            ]);
        }



        // return $request->all();
    }



    public function editRegistrationRules($audition_id)
    {
        $audition = Audition::find($audition_id);
        $groups = json_decode($audition->auditionRules->jury_groups);
        $round_rules = AuditionRoundRule::where('audition_rules_id', $audition->audition_rules_id)->get();

        $data = [
            'audition' => $audition,
            'groups' => $groups->{'groups_id'},
            'juries_num' => $groups->{'group_members'},
            'round_rules' => $round_rules,
        ];

        return view('ManagerAdmin.registrationRule.edit',$data);
    }

    public function getRoundInfo($round_id){
       $round = AuditionRoundRule::find($round_id);

       return view('ManagerAdmin.registrationRule.round_rules',compact('round'));
    //    return response()->json([
    //     'status' => 200,
    //     'round' => $round,
    //    ]);

    }

    public function updateRegistrationRound(Request $request,$round_id){
        // return $request->all();
        $round = AuditionRoundRule::find($round_id);

        $round->video_duration           = $request->video_duration;
        $round->jury_marking_start_date  = $request->jury_marking_start_date;
        $round->jury_marking_end_date    = $request->jury_marking_end_date;
        $round->judge_marking_start_date = $request->judge_marking_start_date;
        $round->judge_marking_end_date   = $request->judge_marking_end_date;
        $round->appeal_start_date        = $request->appeal_start_date;
        $round->appeal_end_date          = $request->appeal_end_date;
        $round->result_published_date    = $request->result_published_date;
        $round->appeal_result_date       = $request->appeal_result_date;

        $round->save();
        session()->flash('success','Updated Successfully');
        return redirect()->back();
    }
}
