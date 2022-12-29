<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\FanGroup;
use App\Models\FanPost;
use App\Models\User;
use App\Models\UserInfo;
use App\Models\NotificationText;
use App\Models\Notification;
use App\Models\Wallet;
use App\Models\Fan_Group_Join;
use App\Models\FanGroupMessage;
use App\Models\MyChatList;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use DB;
use DateTime;

class FanGroupController extends Controller
{
    // Star List for create in Fan Group
    public function allStarList()
    {
        // $allStar = User::where('user_type', 'star')->get();
        $allStar = User::where('parent_user', auth('sanctum')->user()->id)->get();

        return response()->json([
            'status' => 200,
            'allStar' => $allStar,
        ]);
    }

    //Another Star List except my Star
    public function someStarList($data)
    {
        $user =  User::find($data);

        $sub_cat_Id = $user->sub_category_id;

        $someStar = User::where('user_type', 'star')->where('id', '!=', $data)->where('sub_category_id', $sub_cat_Id)->get();

        return response()->json([
            'status' => 200,
            'someStar' => $someStar,
        ]);
    }

    // Star Related Fan Post
    public function fanPostStarAll($starId)
    {
        $starFanPost = FanPost::where('star_id', $starId)
            ->get();

        return response()->json([
            'status' => 200,
            'starFanPost' => $starFanPost,
        ]);
    }

    //Notification decline post
    public function declineFanPostNotification(Request $request, $postId)
    {

        $fanpost = FanPost::find($postId);
        $fanpost->status = 2;
        $fanpost->save();

        $text = new NotificationText();
        $text->text = $request->text;
        $text->type = "fangroup";
        $text->save();

        Notification::insert([
            'notification_id' => $text->id,
            'event_id' => $fanpost->fan_group_id,
            'user_id' => $fanpost->user_id,
            'view_status' => 0,
            'status' => 0,
            'created_at' => Carbon::now(),
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'Fan Post Declined Successfully',
        ]);
    }

    // Create Fan Group in Admin
    public function fanGroupStore(Request $request)
    {
        // $validator = Validator::make($request->all(), [
        $validator = Validator::make($request->all(), [
            'group_name' => 'required|unique:fan_groups',
            'description' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'club_points' => 'required',
            'my_star' => 'required',
            'another_star' => 'required',
            'banner' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'validation_errors' => $validator->errors(),
            ]);
        } else {

            $id = auth('sanctum')->user()->id;
            $anotherStar =  $request->another_star;

            $adminId = User::find($anotherStar);
            // return $request->all();

            $fangroup = new FanGroup();

            $fangroup->group_name = $request->group_name;
            $fangroup->slug = Str::slug($request->group_name);
            $fangroup->description = $request->description;
            $fangroup->club_points = $request->club_points;
            $fangroup->start_date = $request->start_date;
            $fangroup->end_date = $request->end_date;
            $fangroup->room_id = Str::random(20);
            $fangroup->min_member = $request->min_member;
            $fangroup->max_member = $request->max_member;
            $fangroup->created_by = $id;

            $fangroup->my_star = $request->my_star;
            $fangroup->my_star_status = 0;

            $fangroup->another_star = $anotherStar;
            if ($adminId) {
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
                'fanGroupId' => $fangroup->id,
            ]);
        }
    }

    // Update Fan Group in Admin
    public function updateFanGroup(Request $request, $slug)
    {
        $fangroup = FanGroup::where('slug', $slug)->first();
        $validator = Validator::make($request->all(), [
            'group_name' => 'required|unique:fan_groups,group_name,' . $fangroup->id,
            'description' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'club_points' => 'required',
        ]);



        if ($validator->fails()) {
            return response()->json([
                'validation_errors' => $validator->errors(),
            ]);
        } else {


            $fangroup->group_name = $request->group_name;
            $fangroup->club_points = $request->club_points;
            $fangroup->slug = Str::slug($request->group_name);
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
    public function deleteFanGroup($slug)
    {

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
    public function starUpdate(Request $request, $slug)
    {

        $fangroup = FanGroup::where('slug', $slug)->first();
        $validator = Validator::make($request->all(), [
            'group_name' => 'required|unique:fan_groups,group_name,' . $fangroup->id,
            'description' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'club_points' => 'required',
        ]);


        if ($validator->fails()) {
            return response()->json([
                'validation_errors' => $validator->errors(),
            ]);
        } else {


            $fangroup->group_name = $request->group_name;
            $fangroup->club_points = $request->club_points;
            $fangroup->slug = Str::slug($request->group_name);
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
    public function statusStar()
    {
        $id = auth('sanctum')->user()->id;

        $starActive = FanGroup::where(function ($query) use ($id) {
            $query->where('my_star_status', 0)
                ->where('my_star', $id);
        })->orWhere(function ($query) use ($id) {
            $query->where('another_star_status', 0)
                ->where('another_star', $id);
        })->orderBy('id', 'DESC')->get();

        $starApproved = FanGroup::where(function ($query) use ($id) {
            $query->where('my_star_status', 1)
                ->where('my_star', $id);
        })->orWhere(function ($query) use ($id) {
            $query->where('another_star_status', 1)
                ->where('another_star', $id);
        })->orderBy('id', 'DESC')->get();

        $starRejected = FanGroup::where(function ($query) use ($id) {
            $query->where('my_star_status', 2)
                ->where('my_star', $id);
        })->orWhere(function ($query) use ($id) {
            $query->where('another_star_status', 2)
                ->where('another_star', $id);
        })->orderBy('id', 'DESC')->get();

        $today = Carbon::now();

        $starLiveGroup = FanGroup::where('my_star_status', 1)
            ->where('another_star_status', 1)
            ->where(function ($query) use ($id) {
                $query->where('my_star', $id)
                    ->orWhere('another_star', $id);
            })
            // ->whereDate('start_date', '<=', $today)
            // ->whereDate('end_date', '>=', $today)
            ->where('status', 1)
            ->orderBy('id', 'DESC')
            ->get();
        $allFanGroup = FanGroup::where([['my_star', $id], ['status', 1]])->orWhere([['another_star', $id], ['status', 1]])->get();

        // return $star;

        return response()->json([
            'status' => 200,
            'starActive' => $starActive,
            'starApproved' => $starApproved,
            'starRejected' => $starRejected,
            'starLiveGroup' => $starLiveGroup,
            'allFanGroup' => $allFanGroup,
            'id' => $id,
        ]);
    }

    // Pending/Approve/Live Fan group List in Admin Panel
    public function statusAdminStar()
    {
        $id = auth('sanctum')->user()->id;

        $fanApproved = FanGroup::where(function ($query) use ($id) {
            $query->where('another_star_admin_id', $id)
                ->orWhere('created_by', $id);
        })
            ->where('my_star_status', 1)
            ->where('status', 1)
            ->where('another_star_status', 1)
            ->orderBy('id', 'DESC')
            ->get();

        $fanApprovedCount = FanGroup::where(function ($query) use ($id) {
            $query->where('another_star_admin_id', $id)
                ->orWhere('created_by', $id);
        })
            ->where('my_star_status', 1)
            ->where('status', 1)
            ->where('another_star_status', 1)
            ->count();

        $fanPending = FanGroup::where(function ($query) use ($id) {
            $query->where('my_star_status', 0)
                ->where('created_by', $id);
        })->orWhere(function ($query) use ($id) {
            $query->where('another_star_status', 0)
                ->where('another_star_admin_id', $id);
        })->orWhere(function ($query) use ($id) {
            $query->where('status', 0)
                ->orWhere('status', 2);
        })->orderBy('id', 'DESC')->get();

        $fanPendingCount = FanGroup::where(function ($query) use ($id) {
            $query->where('my_star_status', 0)
                ->where('created_by', $id);
        })->orWhere(function ($query) use ($id) {
            $query->where('another_star_status', 0)
                ->where('another_star_admin_id', $id);
        })->orWhere(function ($query) use ($id) {
            $query->where('status', 0)
                ->orWhere('status', 2);
        })->count();


        $today = Carbon::now();

        $fanLiveGroup = FanGroup::where(function ($query) use ($id) {
            $query->where('another_star_admin_id', $id)
                ->orWhere('created_by', $id);
        })
            ->where('my_star_status', 1)
            ->where('status', 1)
            ->where('another_star_status', 1)
            // ->whereDate('start_date', '<=', $today)
            // ->whereDate('end_date', '>=', $today)
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
    public function fanGroupDetails($slug)
    {
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
    public function fanGroupActive($slug)
    {
        $fanDetails = FanGroup::where('slug', $slug)->first();
        $id = auth('sanctum')->user()->id;

        if ($fanDetails->my_star == $id) {
            $fanDetails->my_star_status = 1;
        }
        if ($fanDetails->another_star == $id) {
            $fanDetails->another_star_status = 1;
        }

        $fanDetails->save();

        return response()->json([
            'status' => 200,
            'message' => 'Star Approved Successfully',
        ]);
    }

    // Fan group Ignore in Star
    public function fanGroupIgnore($slug)
    {
        $fanDetails = FanGroup::where('slug', $slug)->first();
        $id = auth('sanctum')->user()->id;

        if ($fanDetails->my_star == $id) {
            $fanDetails->my_star_status = 2;
        }
        if ($fanDetails->another_star == $id) {
            $fanDetails->another_star_status = 2;
        }

        $fanDetails->save();

        return response()->json([
            'status' => 200,
            'message' => 'Fan Group Ignored!',
        ]);
    }

    // Fan Post/Image/Video show in User Panel
    public function getFanPostShow($slug)
    {
        $fanDetails = FanGroup::where('slug', $slug)->first();
        $userId = auth('sanctum')->user()->id;

        $fanGroupMemebers = Fan_Group_Join::where('fan_group_id', $fanDetails->id)->get();

        $fanPost = FanPost::where('fan_group_id', $fanDetails->id)->latest()->where('status', 1)->orderBy('id', 'DESC')->get();
        $fanMedia = FanPost::where('fan_group_id', $fanDetails->id)->where('image', '!=', Null)->orderBy('id', 'DESC')->where('status', 1)->get();
        $fanVideo = FanPost::where('fan_group_id', $fanDetails->id)->where('video', '!=', Null)->orderBy('id', 'DESC')->where('status', 1)->get();

        $userJoinInfo = Fan_Group_Join::where('user_id', auth('sanctum')->user()->id)->get()->first();
        $userStatus = Fan_Group_Join::where('user_id', auth('sanctum')->user()->id)->where('approveStatus', 1)->get()->first();


        return response()->json([
            'status' => 200,
            'fanPost' => $fanPost,
            'fanMedia' => $fanMedia,
            'fanVideo' => $fanVideo,
            'userId' => $userId,
            'member' => $fanGroupMemebers,
            'myJoinStaus' => $userStatus ? true : false,
            'myJoinData' => $userJoinInfo


        ]);
    }

    // Forward Manager Admin for Approval
    public function fanGroupManagerApproval($slug)
    {
        $fanDetails = FanGroup::where('slug', $slug)->first();

        $fanDetails->status = 2;
        $fanDetails->save();

        return response()->json([
            'status' => 200,
            'message' => 'Fan Group Approval Request Done!',
        ]);
    }

    // Store Fan Post Like count
    public function postFanPostLike(Request $request, $postId)
    {
        $fanPostId = FanPost::find($postId);
        $fanPostId->user_like_id = $request->showlike;
        $fanPostId->save();

        return response()->json([
            'status' => 200,
            'message' => 'React Submitted',
        ]);
    }

    // Get Fan Post user Like Array & it's count
    public function getFanPostLike($postId)
    {
        $fanPostId = FanPost::find($postId);

        return response()->json([
            'status' => 200,
            'userLikedList' => $fanPostId->user_like_id,
            'likeCount' => $fanPostId->like_count,
        ]);
    }

    // User FanGroup Join count & show list in user Panel
    public function getFanGroupList()
    {

        $id = auth('sanctum')->user()->id;

        $useFan = UserInfo::where('user_id', $id)->first();


        if ($useFan) {
            $fanUser = json_decode($useFan->user_fan_group_id);
        } else {
            $fanUser = json_decode('[]');
        }
        // $fanUser = json_decode($useFan->user_fan_group_id ? $useFan->user_fan_group_id : '[]');

        $fanCount = Fan_Group_Join::where('user_id', Auth('sanctum')->user()->id)->count();

        // $useFanGroup = FanGroup::select("*")
        //     ->whereIn('id', $fanUser)
        //     ->where('status', 1)
        //     ->get();


        $useFanGroup = Fan_Group_Join::where('user_id', Auth('sanctum')->user()->id)->latest()->get();

        $fanList = FanGroup::where('status', 1)->whereNotIn('id', $fanUser)->latest()->get();

        return response()->json([
            'status' => 200,
            'fanList' => $fanList,
            'fanCount' => $fanCount,
            'useFanGroup' => $useFanGroup,
        ]);
    }

    // two user member list in user panel
    public function getFanGroupDetails($slug)
    {
        $userPoints = Wallet::where('user_id', Auth('sanctum')->user()->id)->first();

        if ($userPoints) {
            $userPoints = $userPoints;
        } else {
            // $userPoints = new Wallet();
            // $userPoints->save();
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

        $participant = Fan_Group_Join::where('fan_group_id', $fanDetails->id)->get();

        return response()->json([
            'status' => 200,
            'fanDetails' => $fanDetails,
            'userPoints' => $userPoints ? $userPoints : 0,
            'fanId' => $fanDetails->id,
            'my_user_join' => $my_user_join,
            'another_user_join' => $another_user_join,
            'my_star' => $my_star,
            'another_star' => $another_star,
            'participant' => $participant,
        ]);
    }

    // Fan Group post/image/video, warning, two user join lists in Admin Panel
    public function showFanGroup($slug)
    {
        $fanDetails = FanGroup::where('slug', $slug)->first();
        $fanMember = Fan_Group_Join::where('fan_group_id', $fanDetails->id)->where('approveStatus', 0)->get();

        $fanPost = FanPost::where('fan_group_id', $fanDetails->id)->where('status', 0)->orderBy('id', 'DESC')->get();
        $fanDecline = FanPost::where('fan_group_id', $fanDetails->id)->where('status', 2)->orderBy('id', 'DESC')->get();
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

        if ($fanDetails->created_by == $fanId) {
            $userJoin = $my_user_join;
        } else {
            $userJoin = $another_user_join;
        }

        if ($fanDetails->my_star == $fanId) {
            $myStar = User::find($fanDetails->my_star);
        } else {
            $myStar = User::find($fanDetails->another_star);
        }

        return response()->json([
            'status' => 200,
            'fanDetails' => $fanDetails,
            'fanMember' => $fanMember,
            'fanMedia' => $fanMedia,
            'fanVideo' => $fanVideo,
            'fanDecline' => $fanDecline,
            'fanWarning' => $fanWarning,
            'fanPost' => $fanPost,
            'allFanPost' => $allFanPost,
            'fanId' => $fanId,
            'userJoin' => $userJoin,
            'myStar' => $myStar,
        ]);
    }

    // Analytics show in Admin/Star Panel
    public function showFanGroupAnalytics($slug)
    {


        $fanDetails = FanGroup::where('slug', $slug)->first();


        // $fdate = $fanDetails->start_date;
        // $tdate = $fanDetails->end_date;
        // $datetime1 = new DateTime($fdate);
        // $datetime2 = new DateTime($tdate);
        // $interval = $datetime1->diff($datetime2);


        // $interval = $fanDetails->start_date->diff($fanDetails->end_date);


        $current = Carbon::parse($fanDetails->start_date);
        $newCurrent = Carbon::parse($fanDetails->start_date);
        $end = Carbon::parse($fanDetails->end_date);

        $length = $end->diffInDays($current);


        $week = (int)($length / 7);
        if ($week * 7 == $length) {
            $week = $week;
        } else {
            $week = $week + 1;
        }


        // $current_timestamp = Carbon::parse($fanDetails->start_date)->format('Y-m-d H:i:s');
        // $end_timestamp = Carbon::parse($current_timestamp->addDays(7))->format('Y-m-d H:i:s');


        $anotherStarArray = array();
        $anotherStarWeek = array();

        for ($i = 1; $i <= $week; $i++) {
            $current_timestamp = (string) $current;
            $end_timestamp = (string) ($current->addDays(7));

            $firstStarPost = FanPost::where('star_id', $fanDetails->another_star)->where('fan_group_id', $fanDetails->id)->whereBetween('created_at', [$current_timestamp, $end_timestamp])->count();
            $fan_Group_Join = Fan_Group_Join::where('star_id', $fanDetails->another_star)->where('fan_group_id', $fanDetails->id)->whereBetween('created_at', [$current_timestamp, $end_timestamp])->count();
            $fanGroupMessage = FanGroupMessage::where('position', 2)->where('group_id', $fanDetails->id)->whereBetween('created_at', [$current_timestamp, $end_timestamp])->count();

            array_push($anotherStarArray, ($firstStarPost + $fanGroupMessage + $fan_Group_Join));
            array_push($anotherStarWeek, $i);
        }

        // return $anotherStarArray;


        $myStarArray = array();
        $myStarWeek = array();

        for ($i = 1; $i <= $week; $i++) {
            $current_timestamp = (string) $newCurrent;
            $end_timestamp = (string) ($newCurrent->addDays(7));

            $secondStarPost = FanPost::where('star_id', $fanDetails->my_star)->where('fan_group_id', $fanDetails->id)->whereBetween('created_at', [$current_timestamp, $end_timestamp])->count();
            $fan_Group_Join = Fan_Group_Join::where('star_id', $fanDetails->my_star)->where('fan_group_id', $fanDetails->id)->whereBetween('created_at', [$current_timestamp, $end_timestamp])->count();
            $fanGroupMessage = FanGroupMessage::where('position', 1)->where('group_id', $fanDetails->id)->whereBetween('created_at', [$current_timestamp, $end_timestamp])->count();

            array_push($myStarArray, ($secondStarPost + $fanGroupMessage + $fan_Group_Join));
            array_push($myStarWeek, $i);
        }

        // return $myStarArray;

        $myStarAnalytics = $myStarArray;
        $myStarWeek = $myStarWeek;

        $anotherStarAnalytics = $anotherStarArray;
        $anotherStarWeek = $anotherStarWeek;




        // $myStarPostsAll = FanPost::where([['fan_group_id', $fanDetails->id], ['star_id', $fanDetails->my_star]])->get();
        // $myStarPosts = $myStarPostsAll->groupBy(function ($date) {
        //     return Carbon::parse($date->created_at)->ceilWeek()->format('d, M')
        //         . ' - ' . Carbon::parse($date->created_at)->floorWeek()->format('d, M');
        // });

        // $anotherStarPostsAll = FanPost::where([['fan_group_id', $fanDetails->id], ['star_id', $fanDetails->another_star]])->get();
        // $anotherStarPosts = $anotherStarPostsAll->groupBy(function ($date) {
        //     return Carbon::parse($date->created_at)->ceilWeek()->format('d, M')
        //         . ' - ' . Carbon::parse($date->created_at)->floorWeek()->format('d, M');
        // });

        // Total Fan Post under first star
        $myStarPost = FanPost::where('fan_group_id', $fanDetails->id)
            ->where('star_id', $fanDetails->my_star)
            ->count();

        // Total Fan Post under second star
        $anotherStarPost = FanPost::where('fan_group_id', $fanDetails->id)
            ->where('star_id', $fanDetails->another_star)
            ->count();

        // 2022-07-04 00:00:00
        // 2022-07-31 00:00:00

        // $start_date = Carbon::parse($fanDetails->start_date)->format('Y-m-d H:i:s');
        // $end_date = Carbon::parse($fanDetails->end_date)->format('Y-m-d H:i:s');

        // $start_date = $start_date->addDays(7);
        // return $start_date;

        // $myStarNew=array();
        // $myStarCount = 0;

        // while($start_date < $end_date) {

        //     $myStarCount++;

        //   }
        // return $myStarCount;

        // $currentdate = Carbon::now();
        // $current_timestamp = Carbon::now()->format('Y-m-d H:i:s');
        // return $current_timestamp;

        // $data12 = $currentdate->addDays(-7)->format('Y-m-d H:i:s');
        // // return $data12;

        // $data11 = $currentdate->addDays(-7)->format('Y-m-d H:i:s');

        // $data10 = $currentdate->addDays(-7)->format('Y-m-d H:i:s');

        // $data9 = $currentdate->addDays(-7)->format('Y-m-d H:i:s');

        // $data8 = $currentdate->addDays(-7)->format('Y-m-d H:i:s');

        // $data7 = $currentdate->addDays(-7)->format('Y-m-d H:i:s');

        // $data6 = $currentdate->addDays(-7)->format('Y-m-d H:i:s');

        // $data5 = $currentdate->addDays(-7)->format('Y-m-d H:i:s');

        // $data4 = $currentdate->addDays(-7)->format('Y-m-d H:i:s');

        // $data3 = $currentdate->addDays(-7)->format('Y-m-d H:i:s');

        // $data2 = $currentdate->addDays(-7)->format('Y-m-d H:i:s');

        // $data1 = $currentdate->addDays(-7)->format('Y-m-d H:i:s');


        // $firstStar12 = FanPost::where('star_id', $fanDetails->my_star)->where('fan_group_id', $fanDetails->id)->whereDate('created_at', '<=', $current_timestamp)->whereDate('created_at', '>=', $data12)->count();
        // $firstStar11 = FanPost::where('star_id', $fanDetails->my_star)->where('fan_group_id', $fanDetails->id)->whereDate('created_at', '<=', $data12)->whereDate('created_at', '>=', $data11)->count();
        // $firstStar10 = FanPost::where('star_id', $fanDetails->my_star)->where('fan_group_id', $fanDetails->id)->whereDate('created_at', '<=', $data11)->whereDate('created_at', '>=', $data10)->count();
        // $firstStar9 = FanPost::where('star_id', $fanDetails->my_star)->where('fan_group_id', $fanDetails->id)->whereDate('created_at', '<=', $data10)->whereDate('created_at', '>=', $data9)->count();
        // $firstStar8 = FanPost::where('star_id', $fanDetails->my_star)->where('fan_group_id', $fanDetails->id)->whereDate('created_at', '<=', $data9)->whereDate('created_at', '>=', $data8)->count();
        // $firstStar7 = FanPost::where('star_id', $fanDetails->my_star)->where('fan_group_id', $fanDetails->id)->whereDate('created_at', '<=', $data8)->whereDate('created_at', '>=', $data7)->count();
        // $firstStar6 = FanPost::where('star_id', $fanDetails->my_star)->where('fan_group_id', $fanDetails->id)->whereDate('created_at', '<=', $data7)->whereDate('created_at', '>=', $data6)->count();
        // $firstStar5 = FanPost::where('star_id', $fanDetails->my_star)->where('fan_group_id', $fanDetails->id)->whereDate('created_at', '<=', $data6)->whereDate('created_at', '>=', $data5)->count();
        // $firstStar4 = FanPost::where('star_id', $fanDetails->my_star)->where('fan_group_id', $fanDetails->id)->whereDate('created_at', '<=', $data5)->whereDate('created_at', '>=', $data4)->count();
        // $firstStar3 = FanPost::where('star_id', $fanDetails->my_star)->where('fan_group_id', $fanDetails->id)->whereDate('created_at', '<=', $data4)->whereDate('created_at', '>=', $data3)->count();
        // $firstStar2 = FanPost::where('star_id', $fanDetails->my_star)->where('fan_group_id', $fanDetails->id)->whereDate('created_at', '<=', $data3)->whereDate('created_at', '>=', $data2)->count();
        // $firstStar1 = FanPost::where('star_id', $fanDetails->my_star)->where('fan_group_id', $fanDetails->id)->whereDate('created_at', '<=', $data2)->whereDate('created_at', '>=', $data1)->count();

        // $secondStar12 = FanPost::where('star_id', $fanDetails->another_star)->where('fan_group_id', $fanDetails->id)->whereDate('created_at', '<=', $current_timestamp)->whereDate('created_at', '>=', $data12)->count();
        // $secondStar11 = FanPost::where('star_id', $fanDetails->another_star)->where('fan_group_id', $fanDetails->id)->whereDate('created_at', '<=', $data12)->whereDate('created_at', '>=', $data11)->count();
        // $secondStar10 = FanPost::where('star_id', $fanDetails->another_star)->where('fan_group_id', $fanDetails->id)->whereDate('created_at', '<=', $data11)->whereDate('created_at', '>=', $data10)->count();
        // $secondStar9 = FanPost::where('star_id', $fanDetails->another_star)->where('fan_group_id', $fanDetails->id)->whereDate('created_at', '<=', $data10)->whereDate('created_at', '>=', $data9)->count();
        // $secondStar8 = FanPost::where('star_id', $fanDetails->another_star)->where('fan_group_id', $fanDetails->id)->whereDate('created_at', '<=', $data9)->whereDate('created_at', '>=', $data8)->count();
        // $secondStar7 = FanPost::where('star_id', $fanDetails->another_star)->where('fan_group_id', $fanDetails->id)->whereDate('created_at', '<=', $data8)->whereDate('created_at', '>=', $data7)->count();
        // $secondStar6 = FanPost::where('star_id', $fanDetails->another_star)->where('fan_group_id', $fanDetails->id)->whereDate('created_at', '<=', $data7)->whereDate('created_at', '>=', $data6)->count();
        // $secondStar5 = FanPost::where('star_id', $fanDetails->another_star)->where('fan_group_id', $fanDetails->id)->whereDate('created_at', '<=', $data6)->whereDate('created_at', '>=', $data5)->count();
        // $secondStar4 = FanPost::where('star_id', $fanDetails->another_star)->where('fan_group_id', $fanDetails->id)->whereDate('created_at', '<=', $data5)->whereDate('created_at', '>=', $data4)->count();
        // $secondStar3 = FanPost::where('star_id', $fanDetails->another_star)->where('fan_group_id', $fanDetails->id)->whereDate('created_at', '<=', $data4)->whereDate('created_at', '>=', $data3)->count();
        // $secondStar2 = FanPost::where('star_id', $fanDetails->another_star)->where('fan_group_id', $fanDetails->id)->whereDate('created_at', '<=', $data3)->whereDate('created_at', '>=', $data2)->count();
        // $secondStar1 = FanPost::where('star_id', $fanDetails->another_star)->where('fan_group_id', $fanDetails->id)->whereDate('created_at', '<=', $data2)->whereDate('created_at', '>=', $data1)->count();


        // $myStarAna = array();
        // array_push($myStarAna, $firstStar1, $firstStar2, $firstStar3, $firstStar4, $firstStar5, $firstStar6, $firstStar7, $firstStar8, $firstStar9, $firstStar10, $firstStar11, $firstStar12);
        // $myStarAnalytics = $myStarAna;

        // $anotherStarAna = array();
        // array_push($anotherStarAna, $secondStar1, $secondStar2, $secondStar3, $secondStar4, $secondStar5, $secondStar6, $secondStar7, $secondStar8, $secondStar9, $secondStar10, $secondStar11, $secondStar12);
        // $anotherStarAnalytics = $anotherStarAna;


        return response()->json([
            'status' => 200,
            'fanDetails' => $fanDetails,
            'myStarPost' => $myStarPost,
            'anotherStarPost' => $anotherStarPost,
            'myStarAnalytics' => $myStarAnalytics,
            'anotherStarAnalytics' => $anotherStarAnalytics,
            'myStarWeek' => $myStarWeek,
            'anotherStarWeek' => $anotherStarWeek,
            // 'sonet' => $myStarPosts,
            // 'anotherStarPosts' => $anotherStarPosts,
        ]);
    }

    // Delete member in Admin/Star Panel
    public function deleteSettingsFan($fanJoinId)
    {

        $fanWarning = Fan_Group_Join::find($fanJoinId);

        $fanWarning->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Fan Group Deleted Successfully',
        ]);
    }

    // Remove warning in Star/Admin Panel
    public function noWarningSettingsFan($warningId)
    {

        $fanWarning = Fan_Group_Join::find($warningId);


        $fanWarning->warning_count = 0;

        $fanWarning->save();

        return response()->json([
            'status' => 200,
            'message' => 'Admin Removed Warning',
        ]);
    }

    // Warning count in post approval in Star/Admin Panel
    public function warningSettingsFan($fanUserId, $fanGroupId)
    {

        $fanWarning = Fan_Group_Join::where('user_id', $fanUserId)->where('fan_group_id', $fanGroupId)->first();


        $fanWarning->warning_count++;

        $fanWarning->save();

        return response()->json([
            'status' => 200,
            'message' => 'Admin Removed Warning',
        ]);
    }


    // Post/Media/Video/Member list
    public function showStarFanGroup($slug)
    {
        $fanDetails = FanGroup::where('slug', $slug)->first();
        $fanMember = Fan_Group_Join::where('fan_group_id', $fanDetails->id)->where('approveStatus', 0)->orderBy('id', 'DESC')->get();

        $fanPost = FanPost::where('fan_group_id', $fanDetails->id)->where('status', 0)->orderBy('id', 'DESC')->get();
        $fanDecline = FanPost::where('fan_group_id', $fanDetails->id)->where('status', 2)->orderBy('id', 'DESC')->get();
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

        if ($fanDetails->created_by == $fanId) {
            $userJoin = $my_user_join;
            $myStar = User::find($fanDetails->my_star);
            $adminId = User::find($fanDetails->created_by);
        } else {
            $userJoin = $another_user_join;
            $myStar = User::find($fanDetails->another_star);
            $adminId = User::find($fanDetails->another_star_admin_id);
        }

        if ($fanDetails->my_star == $fanId) {
            $myStar = User::find($fanDetails->my_star);
        } else {
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
            'fanDecline' => $fanDecline,
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
    public function getFanGroupStore(Request $request)
    {
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

        $fanGroupChat = new MyChatList();
        $fanGroupChat->title =  $showFanGroup->group_name;
        $fanGroupChat->type =  'fan-group';
        $fanGroupChat->fan_group_id =  $fan_group_id;
        $fanGroupChat->user_id =  $id;



        if ($showFanGroup->join_approval_status == 1) {
            $fanStore->approveStatus = 1;
            $fanGroupChat->status = 1;
        } else {
            $fanStore->approveStatus = 0;
            $fanGroupChat->status = 0;
        }

        $fanStore->save();
        $fanGroupChat->save();




        Fan_Group_Join::where('fan_group_id', $fan_group_id)->where('user_id', $id)->where('id', '!=', $fanStore->id)->delete();

        // Add ID(json) in User Info table
        $user = UserInfo::where('user_id', $id)->first();
        // return $user;
        if ($user) {
            $fan_group_idd = (int) $fan_group_id;

            $array =  $user->user_fan_group_id ? json_decode($user->user_fan_group_id) : [];

            if (!in_array($fan_group_idd, $array)) {
                array_push($array,  $fan_group_idd);
            }
            $user->user_fan_group_id = json_encode($array);
            $user->save();
        } else {
            // return 'partha';
            $user = new UserInfo();
            $fan_group_idd = (int) $fan_group_id;

            $array = [];

            if (!in_array($fan_group_idd, $array)) {
                array_push($array,  $fan_group_idd);
            }

            $user->user_id = $id;
            $user->user_fan_group_id = json_encode($array);
            $user->save();

            // return gettype($user->user_fan_group_id);
        }



        $fan_group = FanGroup::find($fan_group_id);
        // return $fan_group;

        if ($fan_group->my_star == $request->star_id) {
            $array =  $fan_group->my_user_join ? json_decode($fan_group->my_user_join) : [];

            if (!in_array($id, $array)) {
                array_push($array,  $id);
            }
            $fan_group->my_user_join = $array;
            $fan_group->save();
        } else {
            $array =  $fan_group->another_user_join ? json_decode($fan_group->another_user_join) : [];

            if (!in_array($id, $array)) {
                array_push($array,  $id);
            }
            $fan_group->another_user_join = $array;
            $fan_group->save();
        }

        return response()->json([
            'status' => 200,
            'message' => 'Fan Group Joined Successfully',
            'myJoinData' => $fanStore
        ]);
    }

    // User Post in Fan Group in FanPost table
    public function getFanPostStore(Request $request)
    {
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
        $fanPost->share_count = 0;
        $fanPost->share_link = 'https://hellosuperstars.com/group/' . $request->slug;

        $fanPost->like_count = 0;

        if ($fan_id->post_approval_status == 1) {
            $fanPost->status = 1;
        } else {
            $fanPost->status = 0;
        }
        if (isset($request->path)) {
            $fanPost->image = $request->path;
        }
        if (isset($request->video_url)) {
            $fanPost->video = $request->video_url;
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
            'post' => $fanPost
        ]);
    }

    // Update banner in Fan Group
    public function updateImageFanGroup(Request $request, $slug)
    {

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
            'fanDetails' => $fanImage,
            'message' => 'Fan Group Image updated Successfully',
        ]);
    }

    // Get FanGroup join details using user_id from Fan_Group_Join table
    public function getFanGroupJoinId($id)
    {

        $userId = auth('sanctum')->user()->id;
        // $fanJoinDetails = Fan_Group_Join::where('fan_group_id', $id)->where('user_id', $userId)->latest()->first();
        $fanJoinDetails = Fan_Group_Join::where('fan_group_id', $id)->where('user_id', $userId)->first();

        return response()->json([
            'status' => 200,
            'fanJoinDetails' => $fanJoinDetails,
        ]);
    }

    // Member approve in Star & Admin Panel
    public function approveFanMember($joinMemberId)
    {

        $fanMember = Fan_Group_Join::find($joinMemberId);
        $fanMember->approveStatus = 1;
        $fanMember->save();

        return response()->json([
            'status' => 200,
            'message' => 'Fan Member approved Successfully',
        ]);
    }

    // Approve Post in Star & Admin Panel
    public function approveFanPost($postId)
    {

        $fanMember = FanPost::find($postId);
        $fanMember->status = 1;
        $fanMember->save();

        return response()->json([
            'status' => 200,
            'message' => 'Fan Post approved Successfully',
        ]);
    }

    // Status change on Setting for User Join in Star & Admin Panel
    public function joinFanGroup($slug, $data)
    {

        $fanjoin = FanGroup::where('slug', $slug)->first();
        $fanjoin->join_approval_status = $data;
        $fanjoin->save();

        if ($data == 1) {
            return response()->json([
                'status' => 200,
                'message' => 'Anyone Can Join in FanGroup',
            ]);
        } else {
            return response()->json([
                'status' => 200,
                'message' => 'Approve by Admin/Star in FanGroup',
            ]);
        }
    }

    // Status change on Setting for User Post in Star & Admin Panel
    public function postFanGroup($slug, $data)
    {

        $fanpost = FanGroup::where('slug', $slug)->first();
        $fanpost->post_approval_status = $data;
        $fanpost->save();

        if ($data == 1) {
            return response()->json([
                'status' => 200,
                'message' => 'Anyone Can Post in FanGroup',
            ]);
        } else {
            return response()->json([
                'status' => 200,
                'message' => 'Approve by Admin/Star in FanGroup',
            ]);
        }
    }
}
