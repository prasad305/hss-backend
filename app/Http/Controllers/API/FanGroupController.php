<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\FanGroup;
use App\Models\User;
use Illuminate\Support\Str;

class FanGroupController extends Controller
{
    public function allStarList(){
        $allStar = User::where('user_type', 'star')->get();

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
        // return $request->all();

        $fangroup = new FanGroup();
        
        $fangroup->group_name = $request->group_name;
        $fangroup->slug = Str::slug($request->input('group_name'));
        $fangroup->description = $request->description;
        $fangroup->start_date = $request->start_date;
        $fangroup->end_date = $request->end_date;
        $fangroup->min_member = $request->min_member;
        $fangroup->max_member = $request->max_member;

        $fangroup->star_one = $request->star_one;
        $fangroup->star_two = $request->star_two;

        $fangroup->star_one_status = 0;
        $fangroup->star_two_status = 0;
        $fangroup->status = 0;
        $fangroup->created_by = $id;

        $fangroup->save();

        return response()->json([
            'status' => 200,
            'message' => 'Fan Group Added Successfully',
        ]);
    }

    public function statusStar(){
        $id = Auth::user()->id;

        $star = FanGroup::where('star_one', $id)->orWhere('star_two', $id)->get();

        return response()->json([
            'status' => 200,
            'star' => $star,
        ]);
    }
}
