<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\FanGroup;
use App\Models\FanPost;
use App\Models\User;
use App\Models\Fan_Group_Join;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;
use Carbon\Carbon;

class FanGroupController extends Controller
{
    public function allStarList(){
        // $allStar = User::where('user_type', 'star')->get();
        $allStar = User::where('parent_user', auth('sanctum')->user()->id)->get();

        return response()->json([
            'status' => 200,
            'allStar' => $allStar,
        ]);
    }
    public function someStarList($data){
        $someStar = User::where('user_type', 'star')->where('id', '!=', $data)->get();

        return response()->json([
            'status' => 200,
            'someStar' => $someStar,
        ]);
    }

    public function fanGroupStore(Request $request){
        $id = auth('sanctum')->user()->id;
        $anotherStar =  $request->another_star;

        $adminId = User::find($anotherStar);
        // return $request->all();

        $fangroup = new FanGroup();

        $fangroup->group_name = $request->group_name;
        $fangroup->slug = Str::slug($request->input('group_name'));
        $fangroup->description = $request->description;
        $fangroup->start_date = $request->start_date;
        $fangroup->end_date = $request->end_date;
        $fangroup->min_member = $request->min_member;
        $fangroup->max_member = $request->max_member;
        $fangroup->created_by = $id;

        $fangroup->my_star = $request->my_star;
        $fangroup->my_star_status = 0;

        $fangroup->another_star = $anotherStar;
        $fangroup->another_star_admin_id = $adminId->parent_user;
        $fangroup->another_star_status = 0;

        if ($request->hasfile('banner')) {

            $file = $request->file('banner');
            $extension = $file->getClientOriginalExtension();
            $filename = 'uploads/images/fangroup/' . time() . '.' . $extension;

            Image::make($file)->resize(800, 300)->save($filename, 100);
            $fangroup->banner = $filename;
        }

        $fangroup->join_approval_status = 0;
        $fangroup->post_approval_status = 0;
        $fangroup->status = 0;

        $fangroup->save();

        return response()->json([
            'status' => 200,
            'message' => 'Fan Group Added Successfully',
        ]);
    }
    public function updateFanGroup(Request $request, $slug){
        // $id = auth('sanctum')->user()->id;
        // $anotherStar =  $request->another_star;

        // $adminId = User::find($anotherStar);
        // return $request->all();

        $fangroup = FanGroup::where('slug', $slug)->first();

        $fangroup->group_name = $request->group_name;
        $fangroup->slug = Str::slug($request->input('group_name'));
        $fangroup->description = $request->description;
        $fangroup->start_date = $request->start_date;
        $fangroup->end_date = $request->end_date;
        $fangroup->min_member = $request->min_member;
        $fangroup->max_member = $request->max_member;
        // $fangroup->created_by = $id;

        // $fangroup->my_star = $request->my_star;
        // $fangroup->my_star_status = 0;

        // $fangroup->another_star = $anotherStar;
        // $fangroup->another_star_admin_id = $adminId->parent_user;
        // $fangroup->another_star_status = 0;

        if ($request->hasfile('banner')) {

            $file = $request->file('banner');
            $extension = $file->getClientOriginalExtension();
            $filename = 'uploads/images/fangroup/' . time() . '.' . $extension;

            Image::make($file)->resize(800, 300)->save($filename, 100);
            $fangroup->banner = $filename;
        }

        $fangroup->join_approval_status = 0;
        $fangroup->post_approval_status = 0;
        $fangroup->status = 0;

        $fangroup->save();

        return response()->json([
            'status' => 200,
            'message' => 'Fan Group Updated Successfully',
        ]);
    }
    public function deleteFanGroup($slug){
        $fangroup = FanGroup::where('slug', $slug)->first();
        $fangroup->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Fan Group Deleted Successfully',
        ]);
    }

    public function starUpdate(Request $request, $slug){

        $fangroup = FanGroup::where('slug', $slug)->first();

        $fangroup->group_name = $request->group_name;
        $fangroup->slug = Str::slug($request->input('group_name'));
        $fangroup->description = $request->description;
        $fangroup->start_date = $request->start_date;
        $fangroup->end_date = $request->end_date;
        $fangroup->min_member = $request->min_member;
        $fangroup->max_member = $request->max_member;

        if ($request->hasfile('banner')) {

            $file = $request->file('banner');
            $extension = $file->getClientOriginalExtension();
            $filename = 'uploads/images/fangroup/' . time() . '.' . $extension;

            Image::make($file)->resize(800, 300)->save($filename, 100);
            $fangroup->banner = $filename;
        }

        $fangroup->save();

        return response()->json([
            'status' => 200,
            'message' => 'Fan Group Updated Successfully',
        ]);
    }

    public function statusStar(){
        $id = auth('sanctum')->user()->id;

        // $starActive = FanGroup::where('my_star', $id)->orWhere('another_star', $id)->get();

        // $starActive = FanGroup::where(['my_star' => $id, 'my_star_status' => 0])->get();

        // $starActive = FanGroup::where(function ($query) {
        //         $query->where('my_star', $id)
        //               ->orWhere('another_star', $id); })->get();

        // $starActive = FanGroup::where('my_star_status',0)->
        //     where('another_star_status',0)->
        //     where(function ($query) use($id) {
        //         $query->where('my_star',$id)
        //             ->orWhere('another_star',$id);
        //     })->get();

        $starActive = FanGroup::where(function ($query) use($id) {
            $query->where('my_star_status', 0)
                ->where('my_star', $id);
            })->
            orWhere(function ($query) use($id) {
                    $query->where('another_star_status', 0)
                        ->where('another_star',$id);
                })->get();

        $starApproved = FanGroup::where(function ($query) use($id) {
            $query->where('my_star_status', 1)
                ->where('my_star', $id);
            })->
            orWhere(function ($query) use($id) {
                    $query->where('another_star_status', 1)
                        ->where('another_star',$id);
                })->get();

        $starRejected = FanGroup::where(function ($query) use($id) {
            $query->where('my_star_status', 2)
                ->where('my_star', $id);
            })->
            orWhere(function ($query) use($id) {
                    $query->where('another_star_status', 2)
                        ->where('another_star',$id);
                })->get();

        $today = Carbon::now();

        $starLiveGroup = FanGroup::where('my_star_status',1)
                                    ->where('another_star_status',1)
                                    ->where(function ($query) use($id) {
                                    $query->where('my_star', $id)
                                        ->orWhere('another_star', $id);
                                    })
                                    ->whereDate('start_date','<=', $today)
                                    ->whereDate('end_date','>=', $today)
                                    ->get();


        // return $star;

        return response()->json([
            'status' => 200,
            'starActive' => $starActive,
            'starApproved' => $starApproved,
            'starRejected' => $starRejected,
            'starLiveGroup' => $starLiveGroup,
            'id' => $id,
        ]);
    }
    public function statusAdminStar(){
        $id = auth('sanctum')->user()->id;
        // $user = FanGroup::where('created_by', $id);
        // another_star_admin_id


        // $fanApproved = FanGroup::where(function ($query) use($id) {
        //     $query->where('my_star_status', 1)
        //         ->where('created_by', $id);
        //     })->
        //     orWhere(function ($query) use($id) {
        //             $query->where('another_star_status', 1)
        //                 ->where('another_star_admin_id',$id);
        //         })->where('status', 1)->get();

        $fanApproved = FanGroup::where(function ($query) use($id) {
                    $query->where('another_star_admin_id', $id)
                        ->orWhere('created_by', $id);
                    })
                    ->where('my_star_status', 1)
                    ->where('status', 1)
                    ->where('another_star_status', 1)
                    ->get();

        $fanApprovedCount = FanGroup::where(function ($query) use($id) {
                    $query->where('another_star_admin_id', $id)
                        ->orWhere('created_by', $id);
                    })
                    ->where('my_star_status', 1)
                    ->where('status', 1)
                    ->where('another_star_status', 1)
                    ->count();

        // $fanApprovedCount = FanGroup::where(function ($query) use($id) {
        //     $query->where('my_star_status', 1)
        //         ->where('created_by', $id);
        //     })->
        //     orWhere(function ($query) use($id) {
        //             $query->where('another_star_status', 1)
        //                 ->where('another_star_admin_id',$id);
        //         })->where('status', 1)->count();


        $fanPending = FanGroup::where(function ($query) use($id) {
            $query->where('my_star_status', 0)
                ->where('created_by', $id);
            })->
            orWhere(function ($query) use($id) {
                    $query->where('another_star_status', 0)
                        ->where('another_star_admin_id',$id);
                })->orWhere('status', 0)->get();

        $fanPendingCount = FanGroup::where(function ($query) use($id) {
            $query->where('my_star_status', 0)
                ->where('created_by', $id);
            })->
            orWhere(function ($query) use($id) {
                    $query->where('another_star_status', 0)
                        ->where('another_star_admin_id',$id);
                })->orWhere('status', 0)->count();


        $today = Carbon::now();

        $fanLiveGroup = FanGroup::where(function ($query) use($id) {
                                    $query->where('another_star_admin_id', $id)
                                        ->orWhere('created_by', $id);
                                    })
                                    ->where('my_star_status', 1)
                                    ->where('status', 1)
                                    ->where('another_star_status', 1)
                                    ->whereDate('start_date','<=', $today)
                                    ->whereDate('end_date','>=', $today)
                                    ->get();





        // $fanPending = FanGroup::where('created_by', $id)->where('my_star_status', 0)->where('another_star_status', 0)->get();
        // $fanPendingCount = FanGroup::where('created_by', $id)->where('my_star_status', 0)->where('another_star_status', 0)->count();

        // $fanApproved = FanGroup::where('created_by', $id)->where('my_star_status', 1)->where('another_star_status', 1)->get();
        // $fanApprovedCount = FanGroup::where('created_by', $id)->where('my_star_status', 1)->where('another_star_status', 1)->count();


        // $today = Carbon::now();

        // $fanLiveGroup = FanGroup::where('created_by', $id)->where('my_star_status', 1)
        //                     ->where('another_star_status', 1)
        //                     ->whereDate('start_date','<=', $today)
        //                     ->whereDate('end_date','>=', $today)
        //                     ->get();


        // return $star;

        return response()->json([
            'status' => 200,
            'fanPending' => $fanPending,
            'fanPendingCount' => $fanPendingCount,
            'fanApproved' => $fanApproved,
            'fanApprovedCount' => $fanApprovedCount,
            'fanLiveGroup' => $fanLiveGroup,
            'id' => $id,
        ]);
    }

    public function fanGroupDetails($slug){
        $id = auth('sanctum')->user()->id;
        $starId = User::find($id);

        $fanDetails = FanGroup::where('slug', $slug)->first();

        return response()->json([
            'status' => 200,
            'fanDetails' => $fanDetails,
            'starId' => $starId,
            'id' => $id,
        ]);
    }

    public function fanGroupActive($slug, $id){
        $fanDetails = FanGroup::where('slug', $slug)->first();
        // $id = auth('sanctum')->user()->id;

        if($fanDetails->my_star == $id){
            $fanDetails->my_star_status = 1;
        }
        if($fanDetails->another_star == $id){
            $fanDetails->another_star_status = 1;
        }

        $fanDetails->save();

        return response()->json([
            'status' => 200,
            'message' => 'Star Approved Successfully',
        ]);
    }

    public function fanGroupIgnore($slug, $id){
        $fanDetails = FanGroup::where('slug', $slug)->first();
        // $id = auth('sanctum')->user()->id;

        if($fanDetails->my_star == $id){
            $fanDetails->my_star_status = 2;
        }
        if($fanDetails->another_star == $id){
            $fanDetails->another_star_status = 2;
        }

        $fanDetails->save();

        return response()->json([
            'status' => 200,
            'message' => 'Fan Group Ignored!',
        ]);
    }

    public function getFanPostShow($slug){
        $fanDetails = FanGroup::where('slug', $slug)->first();
        // $id = auth('sanctum')->user()->id;

        $fanPost = FanPost::where('fan_group_id', $fanDetails->id)->latest()->get();
        $fanMedia = FanPost::where('fan_group_id', $fanDetails->id)->where('image', '!=', Null)->get();
        $fanVideo = FanPost::where('fan_group_id', $fanDetails->id)->where('video', '!=', Null)->get();

        return response()->json([
            'status' => 200,
            'fanPost' => $fanPost,
            'fanMedia' => $fanMedia,
            'fanVideo' => $fanVideo,
            // 'useFanGroup' => $useFanGroup,
        ]);
    }

    public function getFanGroupList(){
        $fanList = FanGroup::where('status', 1)->latest()->get();
        $id = auth('sanctum')->user()->id;

        $useFan = User::where('id', $id)->first();

        $fanUser = json_decode($useFan->fan_group ? $useFan->fan_group : '[]');

        $useFanGroup = FanGroup::select("*")
                    ->whereIn('id', $fanUser)
                    ->get();

        return response()->json([
            'status' => 200,
            'fanList' => $fanList,
            'useFanGroup' => $useFanGroup,
        ]);
    }

    public function getFanGroupDetails($slug){
        $fanDetails = FanGroup::where('slug', $slug)->first();

        $users_one = json_decode($fanDetails->my_user_join ? $fanDetails->my_user_join : '[]');

        $my_user_join = User::select("*")
                    ->whereIn('id', $users_one)
                    ->get();

        $users_two = json_decode($fanDetails->another_user_join ? $fanDetails->another_user_join : '[]');

        $another_user_join = User::select("*")
                    ->whereIn('id', $users_two)
                    ->get();

        $my_star = User::find($fanDetails->my_star);
        $another_star = User::find($fanDetails->another_star);



        return response()->json([
            'status' => 200,
            'fanDetails' => $fanDetails,
            'fanId' => $fanDetails->id,
            'my_user_join' => $my_user_join,
            'another_user_join' => $another_user_join,
            'my_star' => $my_star,
            'another_star' => $another_star,
        ]);
    }

    public function showFanGroup($slug){
        $fanDetails = FanGroup::where('slug', $slug)->first();
        $fanMember = Fan_Group_Join::where('fan_group_id', $fanDetails->id)->where('approveStatus', 0)->get();

        $fanPost = FanPost::where('fan_group_id', $fanDetails->id)->where('status', 0)->get();
        $allFanPost = FanPost::where('fan_group_id', $fanDetails->id)->where('status', 1)->get();

        $fanId = auth('sanctum')->user()->id;

        // return $fanId;

        $users_one = json_decode($fanDetails->my_user_join ? $fanDetails->my_user_join : '[]');

        $my_user_join = User::select("*")
                    ->whereIn('id', $users_one)
                    ->get();

        $users_two = json_decode($fanDetails->another_user_join ? $fanDetails->another_user_join : '[]');

        $another_user_join = User::select("*")
                    ->whereIn('id', $users_two)
                    ->get();

        if($fanDetails->created_by == $fanId){
            $userJoin = $my_user_join;
        }else{
            $userJoin = $another_user_join;
        }

        if($fanDetails->my_star == $fanId){
            $myStar = User::find($fanDetails->my_star);
        }else{
            $myStar = User::find($fanDetails->another_star);
        }

        // $my_star = User::find($fanDetails->my_star);
        // $another_star = User::find($fanDetails->another_star);



        return response()->json([
            'status' => 200,
            'fanDetails' => $fanDetails,
            'fanMember' => $fanMember,
            'fanPost' => $fanPost,
            'allFanPost' => $allFanPost,
            'fanId' => $fanId,
            'userJoin' => $userJoin,
            'myStar' => $myStar,
        ]);
    }

    public function showStarFanGroup($slug){
        $fanDetails = FanGroup::where('slug', $slug)->first();
        $fanMember = Fan_Group_Join::where('fan_group_id', $fanDetails->id)->where('approveStatus', 0)->get();

        $fanPost = FanPost::where('fan_group_id', $fanDetails->id)->where('status', 0)->get();
        $allFanPost = FanPost::where('fan_group_id', $fanDetails->id)->where('status', 1)->get();

        $id = auth('sanctum')->user()->id;
        $my_star = User::find($id);
        $fanId = $my_star->	parent_user;

        // return $fanId;

        $users_one = json_decode($fanDetails->my_user_join ? $fanDetails->my_user_join : '[]');

        $my_user_join = User::select("*")
                    ->whereIn('id', $users_one)
                    ->get();

        $users_two = json_decode($fanDetails->another_user_join ? $fanDetails->another_user_join : '[]');

        $another_user_join = User::select("*")
                    ->whereIn('id', $users_two)
                    ->get();

        if($fanDetails->created_by == $fanId){
            $userJoin = $my_user_join;
            $myStar = User::find($fanDetails->my_star);
            $adminId = User::find($fanDetails->created_by);
        }else{
            $userJoin = $another_user_join;
            $myStar = User::find($fanDetails->another_star);
            $adminId = User::find($fanDetails->another_star_admin_id);
        }

        if($fanDetails->my_star == $fanId){
            $myStar = User::find($fanDetails->my_star);
        }else{
            $myStar = User::find($fanDetails->another_star);
        }

        // $my_star = User::find($fanDetails->my_star);
        // $another_star = User::find($fanDetails->another_star);



        return response()->json([
            'status' => 200,
            'fanDetails' => $fanDetails,
            'fanMember' => $fanMember,
            'fanPost' => $fanPost,
            'allFanPost' => $allFanPost,
            'fanId' => $fanId,
            'userJoin' => $userJoin,
            'myStar' => $myStar,
            'adminId' => $adminId,
        ]);
    }

    public function getFanGroupStore(Request $request){
        $id = auth('sanctum')->user()->id;

        $fan_group_id = $request->fan_group_id;

        $showFanGroup = FanGroup::find($fan_group_id);

        $fanStore = new Fan_Group_Join();
        $fanStore->fan_group_id = $request->fan_group_id;
        $fanStore->star_id = $request->star_id;
        $fanStore->star_name = $request->star_name;
        $fanStore->user_id = $id;
        $fanStore->warning_count = 0;

        if($showFanGroup->join_approval_status == 1){
            $fanStore->approveStatus = 1;
        }else{
            $fanStore->approveStatus = 0;
        }

        $fanStore->save();

        // Add ID(json) in User table
        $user = User::find($id);
        $fan_group_idd = (int) $fan_group_id;

        $array =  $user->fan_group ? json_decode($user->fan_group) : [] ;

        if(!in_array( $fan_group_idd, $array)){
            array_push($array,  $fan_group_idd);
        }
        $user->fan_group = $array;
        $user->save();


        $fan_group = FanGroup::find($fan_group_id);
        // return $fan_group;

        if($fan_group->my_star == $request->star_id){
            $array =  $fan_group->my_user_join ? json_decode($fan_group->my_user_join) : [] ;

            if(!in_array( $id, $array)){
                array_push($array,  $id);
            }
            $fan_group->my_user_join = $array;
            $fan_group->save();
        }
        else{
            $array =  $fan_group->another_user_join ? json_decode($fan_group->another_user_join) : [] ;

            if(!in_array( $id, $array)){
                array_push($array,  $id);
            }
            $fan_group->another_user_join = $array;
            $fan_group->save();
        }

        return response()->json([
            'status' => 200,
            'message' => 'Fan Group Joined Successfully',
        ]);
    }

    public function getFanPostStore(Request $request){
        $id = auth('sanctum')->user()->id;

        $slug = $request->slug;
        $fan_id = FanGroup::where('slug', $slug)->first();
        $star = Fan_Group_Join::where('user_id', $id)->where('fan_group_id', $fan_id->id)->first();

        $fanPost = new FanPost();
        $fanPost->user_id = $id;
        $fanPost->fan_group_id = $fan_id->id;
        $fanPost->description = $request->description;

        $fanPost->star_id = $star->star_id;
        $fanPost->star_name = $star->star_name;

        $fanPost->like_count = 0;

        if($fan_id->post_approval_status == 1){
            $fanPost->status = 1;
        }else{
            $fanPost->status = 0;
        }


        if ($request->hasfile('image')) {

            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = 'uploads/images/fanpost/' . time() . '.' . $extension;

            Image::make($file)->resize(800, 300)->save($filename, 100);
            $fanPost->image = $filename;
        }

        // if ($request->hasfile('video')) {

        //     $file = Request::file('video');
        //     $filename = time() . $file->getClientOriginalExtension();
        //     $path = public_path().'/uploads/images/fanvideo/';
        //     $file->move($path, $filename);


        //     // $file = $request->file('video');
        //     // $extension = $file->getClientOriginalExtension();
        //     // $filename = 'uploads/images/fanvideo/' . time() . '.' . $extension;

        //     // Image::make($file)->save($filename, 100);
        //     // $file->move($path, $filename);
        //     $fanPost->video = $path . $filename;
        // }

        if ($request->hasFile('video')) {
            // $destination = $audition->video;

            // if (File::exists($destination)) {
            //     File::delete($destination);
            // }

            $file = $request->file('video');
            $folder_path = 'uploads/videos/fanvideo/';
            $video_file_name = now()->timestamp . '.' . $file->getClientOriginalExtension();
            // save to server
            $request->video->move(public_path($folder_path), $video_file_name);
            $fanPost->video = $folder_path . $video_file_name;
        }

        $fanPost->save();

        return response()->json([
            'status' => 200,
            'message' => 'Fan Group Post Successfully',
        ]);
    }

    public function getFanGroupJoinId($id){

        $userId = auth('sanctum')->user()->id;
        $fanJoinDetails = Fan_Group_Join::where('fan_group_id', $id)->where('user_id', $userId)->first();

        return response()->json([
            'status' => 200,
            'fanJoinDetails' => $fanJoinDetails,
        ]);
    }

    public function approveFanMember($id){

        $fanMember = Fan_Group_Join::find($id);
        $fanMember->approveStatus = 1;
        $fanMember->save();

        return response()->json([
            'status' => 200,
            'message' => 'Fan Member approved Successfully',
        ]);
    }
    public function approveFanPost($id){

        $fanMember = FanPost::find($id);
        $fanMember->status = 1;
        $fanMember->save();

        return response()->json([
            'status' => 200,
            'message' => 'Fan Post approved Successfully',
        ]);
    }
    public function joinFanGroup($slug, $data){

        $fanjoin = FanGroup::where('slug', $slug)->first();
        $fanjoin->join_approval_status = $data;
        $fanjoin->save();

        if($data == 1){
            return response()->json([
                'status' => 200,
                'message' => 'Anyone Can Join in FanGroup',
            ]);
        }else{
            return response()->json([
                'status' => 200,
                'message' => 'Approve by Admin/Star in FanGroup',
            ]);
        }

    }

    public function postFanGroup($slug, $data){

        $fanpost = FanGroup::where('slug', $slug)->first();
        $fanpost->post_approval_status = $data;
        $fanpost->save();

        if($data == 1){
            return response()->json([
                'status' => 200,
                'message' => 'Anyone Can Post in FanGroup',
            ]);
        }else{
            return response()->json([
                'status' => 200,
                'message' => 'Approve by Admin/Star in FanGroup',
            ]);
        }
    }
}
