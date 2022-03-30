<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\FanGroup;
use App\Models\User;
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
        $id = Auth::user()->id;
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

        $fangroup->post_approval_status = 0;
        $fangroup->status = 0;

        $fangroup->save();

        return response()->json([
            'status' => 200,
            'message' => 'Fan Group Added Successfully',
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
        $id = Auth::user()->id;

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
        $id = Auth::user()->id;
        // $user = FanGroup::where('created_by', $id);
        // another_star_admin_id


        $fanApproved = FanGroup::where(function ($query) use($id) {
            $query->where('my_star_status', 1)
                ->where('created_by', $id);
            })->
            orWhere(function ($query) use($id) {
                    $query->where('another_star_status', 1)
                        ->where('another_star_admin_id',$id);
                })->get();

        $fanApprovedCount = FanGroup::where(function ($query) use($id) {
            $query->where('my_star_status', 1)
                ->where('created_by', $id);
            })->
            orWhere(function ($query) use($id) {
                    $query->where('another_star_status', 1)
                        ->where('another_star_admin_id',$id);
                })->count();

                
        $fanPending = FanGroup::where(function ($query) use($id) {
            $query->where('my_star_status', 0)
                ->where('created_by', $id);
            })->
            orWhere(function ($query) use($id) {
                    $query->where('another_star_status', 0)
                        ->where('another_star_admin_id',$id);
                })->get();
                
        $fanPendingCount = FanGroup::where(function ($query) use($id) {
            $query->where('my_star_status', 0)
                ->where('created_by', $id);
            })->
            orWhere(function ($query) use($id) {
                    $query->where('another_star_status', 0)
                        ->where('another_star_admin_id',$id);
                })->count();
                
        
        $today = Carbon::now();

        $fanLiveGroup = FanGroup::where(function ($query) use($id) {
                                    $query->where('another_star_admin_id', $id)
                                        ->orWhere('created_by', $id);
                                    })
                                    ->where('my_star_status', 1)
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
        $id = Auth::user()->id;
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
        // $id = Auth::user()->id;

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
        // $id = Auth::user()->id;

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

    public function getFanGroupList(){
        $fanList = FanGroup::where('status', 1)->latest()->get();

        return response()->json([
            'status' => 200,
            'fanList' => $fanList,
        ]);
    }

    public function getFanGroupDetails($slug){
        $fanDetails = FanGroup::where('slug', $slug)->first();
        $my_star = User::find($fanDetails->my_star);
        $another_star = User::find($fanDetails->another_star);

        return response()->json([
            'status' => 200,
            'fanDetails' => $fanDetails,
            'fanId' => $fanDetails->id,
            'my_star' => $my_star,
            'another_star' => $another_star,
        ]);
    }
}
