<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\FanGroup;
use App\Models\FanPost;
use App\Models\User;
use App\Models\Wallet;
use App\Models\Fan_Group_Join;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class FanGroupController extends Controller
{
    // Star List for create in Fan Group
    public function allStarList(){
        // $allStar = User::where('user_type', 'star')->get();
        $allStar = User::where('parent_user', auth('sanctum')->user()->id)->get();

        return response()->json([
            'status' => 200,
            'allStar' => $allStar,
        ]);
    }

    //Another Star List except my Star
    public function someStarList($data){
        $user =  User::find($data);

        $sub_cat_Id = $user->sub_category_id;

        $someStar = User::where('user_type', 'star')->where('id', '!=', $data)->where('sub_category_id', $sub_cat_Id)->get();

        return response()->json([
            'status' => 200,
            'someStar' => $someStar,
        ]);
    }

    // Star Related Fan Post
    public function fanPostStarAll($starId){
        $starFanPost = FanPost::where('star_id', $starId)
                            ->get();

        return response()->json([
                'status' => 200,
                'starFanPost' => $starFanPost,
            ]);
    }

    // Create Fan Group in Admin
    public function fanGroupStore(Request $request){
        // $validator = Validator::make($request->all(), [
        $validator = Validator::make($request->all(),[
            'group_name' => 'required',
            'description' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'club_points' => 'required',
            'my_star' => 'required',
            'another_star' => 'required',
            'banner' => 'required',
        ]);

        if($validator->fails())
        {
            return response()->json([
                'validation_errors'=>$validator->errors(),
            ]);
        }

        else{

            $id = auth('sanctum')->user()->id;
            $anotherStar =  $request->another_star;

            $adminId = User::find($anotherStar);
            // return $request->all();

            $fangroup = new FanGroup();

            $fangroup->group_name = $request->group_name;
            $fangroup->slug = Str::slug($request->input('group_name').'-'.rand(9999,99999));
            $fangroup->description = $request->description;
            $fangroup->club_points = $request->club_points;
            $fangroup->start_date = $request->start_date;
            $fangroup->end_date = $request->end_date;
            $fangroup->min_member = $request->min_member;
            $fangroup->max_member = $request->max_member;
            $fangroup->created_by = $id;

            $fangroup->my_star = $request->my_star;
            $fangroup->my_star_status = 0;

            $fangroup->another_star = $anotherStar;
            if($adminId){
                $fangroup->another_star_admin_id = $adminId->parent_user;
                $fangroup->category_id = $adminId->category_id;
                $fangroup->sub_category_id = $adminId->sub_category_id;
            }
            
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
    }

    // Update Fan Group in Admin
    public function updateFanGroup(Request $request, $slug){
 
        $validator = Validator::make($request->all(),[
            'group_name' => 'required',
            'description' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'club_points' => 'required',
        ]);

        

        if($validator->fails())
        {
            return response()->json([
                'validation_errors'=>$validator->errors(),
            ]);
        }
        else{
            $fangroup = FanGroup::where('slug', $slug)->first();

            $fangroup->group_name = $request->group_name;
            $fangroup->club_points = $request->club_points;
            $fangroup->slug = Str::slug($request->input('group_name').'-'.rand(9999,99999));
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

                $destination = $fangroup->banner;
                if (File::exists($destination)) {
                    File::delete($destination);
                }

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
    }

    // Delete Fan Group in Admin
    public function deleteFanGroup($slug){

        $fangroup = FanGroup::where('slug', $slug)->first();

        $destination = $fangroup->banner;
        if (File::exists($destination)) {
            File::delete($destination);
        }

        $fangroup->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Fan Group Deleted Successfully',
        ]);
    }

    // Update Fan Group in Star Panel
    public function starUpdate(Request $request, $slug){

        $validator = Validator::make($request->all(),[
            'group_name' => 'required',
            'description' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'club_points' => 'required',
        ]);

        
        if($validator->fails())
        {
            return response()->json([
                'validation_errors'=>$validator->errors(),
            ]);
        }
        else{
            $fangroup = FanGroup::where('slug', $slug)->first();

            $fangroup->group_name = $request->group_name;
            $fangroup->club_points = $request->club_points;
            $fangroup->slug = Str::slug($request->input('group_name').'-'.rand(9999,99999));
            $fangroup->description = $request->description;
            $fangroup->start_date = $request->start_date;
            $fangroup->end_date = $request->end_date;
            $fangroup->min_member = $request->min_member;
            $fangroup->max_member = $request->max_member;
    
            if ($request->hasfile('banner')) {
                $destination = $fangroup->banner;
                if (File::exists($destination)) {
                    File::delete($destination);
                }
    
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

    }

    // Approve/Ignore/Rejected Status report in Star Panel of FanGroup 
    public function statusStar(){
        $id = auth('sanctum')->user()->id;

        $starActive = FanGroup::where(function ($query) use($id) {
            $query->where('my_star_status', 0)
                ->where('my_star', $id);
            })->
            orWhere(function ($query) use($id) {
                    $query->where('another_star_status', 0)
                        ->where('another_star',$id);
                })->orderBy('id', 'DESC')->get();

        $starApproved = FanGroup::where(function ($query) use($id) {
            $query->where('my_star_status', 1)
                ->where('my_star', $id)
                ->where('status', 0);
            })->
            orWhere(function ($query) use($id) {
                    $query->where('another_star_status', 1)
                        ->where('another_star',$id)
                        ->where('status', 0);
                })->orderBy('id', 'DESC')->get();

        $starRejected = FanGroup::where(function ($query) use($id) {
            $query->where('my_star_status', 2)
                ->where('my_star', $id);
            })->
            orWhere(function ($query) use($id) {
                    $query->where('another_star_status', 2)
                        ->where('another_star',$id);
                })->orderBy('id', 'DESC')->get();

        $today = Carbon::now();

        $starLiveGroup = FanGroup::where('my_star_status',1)
                                    ->where('another_star_status',1)
                                    ->where(function ($query) use($id) {
                                    $query->where('my_star', $id)
                                        ->orWhere('another_star', $id);
                                    })
                                    ->whereDate('start_date','<=', $today)
                                    ->whereDate('end_date','>=', $today)
                                    ->where('status', 1)
                                    ->orderBy('id', 'DESC')
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

    // Pending/Approve/Live Fan group List in Admin Panel
    public function statusAdminStar(){
        $id = auth('sanctum')->user()->id;

        $fanApproved = FanGroup::where(function ($query) use($id) {
                    $query->where('another_star_admin_id', $id)
                        ->orWhere('created_by', $id);
                    })
                    ->where('my_star_status', 1)
                    ->where('status', 1)
                    ->where('another_star_status', 1)
                    ->orderBy('id', 'DESC')
                    ->get();

        $fanApprovedCount = FanGroup::where(function ($query) use($id) {
                    $query->where('another_star_admin_id', $id)
                        ->orWhere('created_by', $id);
                    })
                    ->where('my_star_status', 1)
                    ->where('status', 1)
                    ->where('another_star_status', 1)
                    ->count();

        $fanPending = FanGroup::where(function ($query) use($id) {
            $query->where('my_star_status', 0)
                ->where('created_by', $id);
            })->
            orWhere(function ($query) use($id) {
                    $query->where('another_star_status', 0)
                        ->where('another_star_admin_id',$id);
                })->orWhere(function ($query) use($id) {
                    $query->where('status', 0)
                        ->orWhere('status', 2);
                })->orderBy('id', 'DESC')->get();

        $fanPendingCount = FanGroup::where(function ($query) use($id) {
            $query->where('my_star_status', 0)
                ->where('created_by', $id);
            })->
            orWhere(function ($query) use($id) {
                    $query->where('another_star_status', 0)
                        ->where('another_star_admin_id',$id);
                })->orWhere(function ($query) use($id) {
                    $query->where('status', 0)
                        ->orWhere('status', 2);
                })->count();


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
                                    ->orderBy('id', 'DESC')
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

    // Get Fan Details in Star
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

    // Active Fan Group
    public function fanGroupActive($slug){
        $fanDetails = FanGroup::where('slug', $slug)->first();
        $id = auth('sanctum')->user()->id;

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

    // Fan group Ignore in Star
    public function fanGroupIgnore($slug){
        $fanDetails = FanGroup::where('slug', $slug)->first();
        $id = auth('sanctum')->user()->id;

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

    // Fan Post/Image/Video show in User Panel
    public function getFanPostShow($slug){
        $fanDetails = FanGroup::where('slug', $slug)->first();
        $userId = auth('sanctum')->user()->id;

        $fanPost = FanPost::where('fan_group_id', $fanDetails->id)->latest()->where('status', 1)->orderBy('id', 'DESC')->get();
        $fanMedia = FanPost::where('fan_group_id', $fanDetails->id)->where('image', '!=', Null)->orderBy('id', 'DESC')->where('status', 1)->get();
        $fanVideo = FanPost::where('fan_group_id', $fanDetails->id)->where('video', '!=', Null)->orderBy('id', 'DESC')->where('status', 1)->get();

        return response()->json([
            'status' => 200,
            'fanPost' => $fanPost,
            'fanMedia' => $fanMedia,
            'fanVideo' => $fanVideo,
            'userId' => $userId,
        ]);
    }

    // Forward Manager Admin for Approval
    public function fanGroupManagerApproval($slug){
        $fanDetails = FanGroup::where('slug', $slug)->first();

        $fanDetails->status = 2;
        $fanDetails->save();
        
        return response()->json([
            'status' => 200,
            'message' => 'Fan Group Approval Request Done!',
        ]);
    }

    // Store Fan Post Like count
    public function postFanPostLike(Request $request, $postId){
        $fanPostId = FanPost::find($postId);
        $fanPostId->user_like_id = $request->showlike;
        $fanPostId->like_count = count(json_decode($request->showlike));
        $fanPostId->save();

        return response()->json([
            'status' => 200,
            'message' => 'Admin Fan Post Done',
        ]);
    }

    // Get Fan Post user Like Array & it's count
    public function getFanPostLike($postId){
        $fanPostId = FanPost::find($postId);

        return response()->json([
            'status' => 200,
            'userLikedList' => $fanPostId->user_like_id,
            'likeCount' => $fanPostId->like_count,
        ]);
    }

    // User FanGroup Join count & show list in user Panel
    public function getFanGroupList(){
        
        $id = auth('sanctum')->user()->id;

        $useFan = User::where('id', $id)->first();

        $fanUser = json_decode($useFan->fan_group ? $useFan->fan_group : '[]');

        $fanCount = FanGroup::select("*")
                            ->whereIn('id', $fanUser)
                            ->where('status', 1)
                            ->count();

        $useFanGroup = FanGroup::select("*")
                    ->whereIn('id', $fanUser)
                    ->where('status', 1)
                    ->get();

        $fanList = FanGroup::where('status', 1)->whereNotIn('id', $fanUser)->latest()->get();

        return response()->json([
            'status' => 200,
            'fanList' => $fanList,
            'fanCount' => $fanCount,
            'useFanGroup' => $useFanGroup,
        ]);
    }

    // two user member list in user panel
    public function getFanGroupDetails($slug){
        // Get User Points for checking 
        // $userPoints = User::find(Auth('sanctum')->user()->id);
        $userPoints = Wallet::where('user_id', Auth('sanctum')->user()->id)->first();
        if($userPoints){
            $userPoints = $userPoints;
        }else{
            $userPoints = 0;
        }

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
            'userPoints' => $userPoints,
            'fanId' => $fanDetails->id,
            'my_user_join' => $my_user_join,
            'another_user_join' => $another_user_join,
            'my_star' => $my_star,
            'another_star' => $another_star,
        ]);
    }

    // Fan Group post/image/video, warning, two user join lists in Admin Panel
    public function showFanGroup($slug){
        $fanDetails = FanGroup::where('slug', $slug)->first();
        $fanMember = Fan_Group_Join::where('fan_group_id', $fanDetails->id)->where('approveStatus', 0)->get();

        $fanPost = FanPost::where('fan_group_id', $fanDetails->id)->where('status', 0)->orderBy('id', 'DESC')->get();
        $allFanPost = FanPost::where('fan_group_id', $fanDetails->id)->where('status', 1)->orderBy('id', 'DESC')->get();
        $fanMedia = FanPost::where('fan_group_id', $fanDetails->id)->where('image', '!=', Null)->orderBy('id', 'DESC')->where('status', 1)->get();
        $fanVideo = FanPost::where('fan_group_id', $fanDetails->id)->where('video', '!=', Null)->orderBy('id', 'DESC')->where('status', 1)->get();

        $fanWarning = Fan_Group_Join::where('fan_group_id', $fanDetails->id)->where('warning_count', '!=', 0)->orderBy('id', 'DESC')->get();

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
            'fanMedia' => $fanMedia,
            'fanVideo' => $fanVideo,
            'fanWarning' => $fanWarning,
            'fanPost' => $fanPost,
            'allFanPost' => $allFanPost,
            'fanId' => $fanId,
            'userJoin' => $userJoin,
            'myStar' => $myStar,
        ]);
    }

    // Analytics show in Admin/Star Panel
    public function showFanGroupAnalytics($slug){
        $fanDetails = FanGroup::where('slug', $slug)->first();

        // Total Fan Post under first star 
        $myStarPost = FanPost::where('fan_group_id', $fanDetails->id)
                                ->where('star_id', $fanDetails->my_star)
                                ->count();

        // Total Fan Post under second star 
        $anotherStarPost = FanPost::where('fan_group_id', $fanDetails->id)
                                ->where('star_id', $fanDetails->another_star)
                                ->count();

        // Analytics Fan Post under first star 
        $users = FanPost::select('id', 'created_at')
        ->where('fan_group_id', $fanDetails->id)
                        ->where('star_id', $fanDetails->my_star)
                ->get()
                ->groupBy(function($date) {
                    //return Carbon::parse($date->created_at)->format('Y'); // grouping by years
                    return Carbon::parse($date->created_at)->format('m'); // grouping by months
                });

                $usermcount = [];
                $userArr = [];

                foreach ($users as $key => $value) {
                    $usermcount[(int)$key] = count($value);
                }

                for($i = 1; $i <= 12; $i++){
                    if(!empty($usermcount[$i])){
                        $userArr[$i] = $usermcount[$i];    
                    }else{
                        $userArr[$i] = 0;    
                    }
                }

        $myStarAna=array();
        
        foreach ($userArr as $key => $value){
            array_push($myStarAna, $value);
        }

        $myStarAnalytics = $myStarAna;


        // Analytics Fan Post under first star 
        $users2 = FanPost::select('id', 'created_at')
        ->where('fan_group_id', $fanDetails->id)
                        ->where('star_id', $fanDetails->another_star)
                ->get()
                ->groupBy(function($date) {
                    //return Carbon::parse($date->created_at)->format('Y'); // grouping by years
                    return Carbon::parse($date->created_at)->format('m'); // grouping by months
                });

                $usermcount2 = [];
                $userArr2 = [];

                foreach ($users2 as $key => $value) {
                    $usermcount2[(int)$key] = count($value);
                }

                for($i = 1; $i <= 12; $i++){
                    if(!empty($usermcount2[$i])){
                        $userArr2[$i] = $usermcount2[$i];    
                    }else{
                        $userArr2[$i] = 0;    
                    }
                }

        $anotherStarAna=array();
        
        foreach ($userArr2 as $key => $value){
            array_push($anotherStarAna, $value);
        }

        $anotherStarAnalytics = $anotherStarAna;


        return response()->json([
            'status' => 200,
            'fanDetails' => $fanDetails,
            'myStarPost' => $myStarPost,
            'anotherStarPost' => $anotherStarPost,
            'myStarAnalytics' => $myStarAnalytics,
            'anotherStarAnalytics' => $anotherStarAnalytics,
        ]);
    }

    // Delete member in Admin/Star Panel
    public function deleteSettingsFan($fanJoinId){

        $fanWarning = Fan_Group_Join::find($fanJoinId);

        $fanWarning->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Fan Group Deleted Successfully',
        ]);
    }

    // Remove warning in Star/Admin Panel
    public function noWarningSettingsFan($warningId){

        $fanWarning = Fan_Group_Join::find($warningId);


        $fanWarning->warning_count = 0;

        $fanWarning->save();

        return response()->json([
            'status' => 200,
            'message' => 'Admin Removed Warning',
        ]);
    }

    // Warning count in post approval in Star/Admin Panel
    public function warningSettingsFan($fanUserId, $fanGroupId){

        $fanWarning = Fan_Group_Join::where('user_id', $fanUserId)->where('fan_group_id', $fanGroupId)->first();


        $fanWarning->warning_count++;

        $fanWarning->save();

        return response()->json([
            'status' => 200,
            'message' => 'Admin Removed Warning',
        ]);
    }


    // Post/Media/Video/Member list 
    public function showStarFanGroup($slug){
        $fanDetails = FanGroup::where('slug', $slug)->first();
        $fanMember = Fan_Group_Join::where('fan_group_id', $fanDetails->id)->where('approveStatus', 0)->orderBy('id', 'DESC')->get();

        $fanPost = FanPost::where('fan_group_id', $fanDetails->id)->where('status', 0)->orderBy('id', 'DESC')->get();
        $allFanPost = FanPost::where('fan_group_id', $fanDetails->id)->where('status', 1)->orderBy('id', 'DESC')->get();

        
        $fanMedia = FanPost::where('fan_group_id', $fanDetails->id)->where('image', '!=', Null)->orderBy('id', 'DESC')->where('status', 1)->get();
        $fanVideo = FanPost::where('fan_group_id', $fanDetails->id)->where('video', '!=', Null)->orderBy('id', 'DESC')->where('status', 1)->get();

        $id = auth('sanctum')->user()->id;
        $my_star = User::find($id);
        $fanId = $my_star->parent_user;

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
        $fanWarning = Fan_Group_Join::where('fan_group_id', $fanDetails->id)->where('warning_count', '!=', 0)->orderBy('id', 'DESC')->get();

        // $my_star = User::find($fanDetails->my_star);
        // $another_star = User::find($fanDetails->another_star);



        return response()->json([
            'status' => 200,
            'fanDetails' => $fanDetails,
            'fanMember' => $fanMember,
            'fanWarning' => $fanWarning,
            'fanPost' => $fanPost,
            'fanMedia' => $fanMedia,
            'fanVideo' => $fanVideo,
            'allFanPost' => $allFanPost,
            'fanId' => $fanId,
            'userJoin' => $userJoin,
            'myStar' => $myStar,
            'adminId' => $adminId,
        ]);
    }


    // User Join Fan Groun in Fan_Group_Join table
    public function getFanGroupStore(Request $request){
        $id = auth('sanctum')->user()->id;

        $fan_group_id = $request->fan_group_id;

        // $latestFanID = FanGroup::latest()->get();
        // dd($latestFanID);

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

        
        Fan_Group_Join::where('fan_group_id', $fan_group_id)->where('user_id', $id)->where('id', '!=', $fanStore->id)->delete();

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

    // User Post in Fan Group in FanPost table
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
        $fanPost->user_like_id = '[]';

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
            $request->video->move($folder_path, $video_file_name);
            $fanPost->video = $folder_path . $video_file_name;
        }

        $fanPost->save();

        return response()->json([
            'status' => 200,
            'message' => 'Fan Group Post Successfully',
        ]);
    }

    // Update banner in Fan Group
    public function updateImageFanGroup(Request $request, $slug){

        $fanImage = FanGroup::where('slug', $slug)->first();


        if ($request->hasfile('banner')) {
            $destination = $fanImage->banner;

            if (File::exists($destination)) {
                File::delete($destination);
            }


            $file = $request->file('banner');
            $extension = $file->getClientOriginalExtension();
            $filename = 'uploads/images/fangroup/' . time() . '.' . $extension;

            Image::make($file)->resize(800, 300)->save($filename, 100);
            $fanImage->banner = $filename;
        }

        $fanImage->save();

        return response()->json([
            'status' => 200,
            'message' => 'Fan Group Image updated Successfully',
        ]);
    }

    // Get FanGroup join details using user_id from Fan_Group_Join table
    public function getFanGroupJoinId($id){

        $userId = auth('sanctum')->user()->id;
        // $fanJoinDetails = Fan_Group_Join::where('fan_group_id', $id)->where('user_id', $userId)->latest()->first();
        $fanJoinDetails = Fan_Group_Join::where('fan_group_id', $id)->where('user_id', $userId)->first();

        return response()->json([
            'status' => 200,
            'fanJoinDetails' => $fanJoinDetails,
        ]);
    }

    // Member approve in Star & Admin Panel
    public function approveFanMember($joinMemberId){

        $fanMember = Fan_Group_Join::find($joinMemberId);
        $fanMember->approveStatus = 1;
        $fanMember->save();

        return response()->json([
            'status' => 200,
            'message' => 'Fan Member approved Successfully',
        ]);
    }

    // Approve Post in Star & Admin Panel
    public function approveFanPost($postId){

        $fanMember = FanPost::find($postId);
        $fanMember->status = 1;
        $fanMember->save();

        return response()->json([
            'status' => 200,
            'message' => 'Fan Post approved Successfully',
        ]);
    }

    // Status change on Setting for User Join in Star & Admin Panel
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

    // Status change on Setting for User Post in Star & Admin Panel
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
