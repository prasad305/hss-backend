<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Audition\Audition;
use App\Models\User;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use App\Models\Audition\AssignJudge;
use Illuminate\Support\Facades\Validator;

class AuditionController extends Controller
{

    public function index()
    {
        //
    }

    public function adminStatus()
    {
        $live = Audition::where([['admin_id', auth('sanctum')->user()->id], ['status', 1]])->count();
        $pending = Audition::where([['admin_id', auth('sanctum')->user()->id], ['status', 0]])->count();
        return response()->json([
            'status' => 200,
            'live' => $live,
            'pending' => $pending,
        ]);
    }


    public function adminPendings()
    {
        $pendings = Audition::where([['admin_id', auth('sanctum')->user()->id], ['status', 0]])->get();
        return response()->json([
            'status' => 200,
            'pendings' => $pendings,
        ]);
    }

    public function stars()
    {
        $stars = User::where([['user_type', 'star'], ['status', 1]])->get();
        return response()->json([
            'status' => 200,
            'stars' => $stars,
        ]);
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        

        // return $request->star_ids;

        // foreach ($array as $id){
        //     return $id;
        // }
       
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
            'star_ids' => 'required',
        ]);

        

        

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'validation_errors' => $validator->errors(),
            ]);
        }else{
            $audition = Audition::find($request->audition_id);
            $audition->title = $request->title;
            $audition->description = $request->description;
    
            if ($request->hasfile('banner')) {
                $destination = $audition->banner;

                if (File::exists($destination)) {
                    File::delete($destination);
                }
                $file = $request->file('banner');
                $extension = $file->getClientOriginalExtension();
                $filename = 'uploads/images/auditions/' . time() . '.' . $extension;
    
                Image::make($file)->resize(900, 400)->save($filename, 50);
    
                $audition->banner = $filename;
            }
    
    
            try { 
                $audition->save();

                $star_ids = array_map('intval', explode(',', $request->star_ids));
                
                AssignJudge::whereNotIn('id',$star_ids)->where('audition_id', $audition->id)->delete();

                foreach ($star_ids as $key => $star) {
                    if(!AssignJudge::where('judge_id',$star)->where('audition_id', $audition->id)->first()){
                        $assign_star = AssignJudge::create([
                            'audition_id' => $audition->id,
                            'judge_id' => $star,
                        ]); 
                    }
                }
                return response()->json([
                    'status' => 200,
                    'stars' => $assign_star,
                    'audition' => $audition,
                    'message' => 'Audition Judge Added successfully'
                ]);
            } catch (\Exception $exception) {
                return response()->json([
                    'status' => 30,
                    'type' => 'error',
                    'message' => $exception->getMessage()
                ]);
            }
        }


     
       
    }

    public function getAudition($audition_id){
        $audition = Audition::with('assignJudge')->find($audition_id);
       
        $judge_ids = [];
        foreach ($audition->assignJudge as $key => $judge) {
           array_push($judge_ids, $judge->judge_id);
        }
        
        // return $judge_ids;
        return response()->json([
            'status' => 200,
            'audition' => $audition,
            'judge_ids' => $judge_ids
        ]);
    }

    // public function starAudition(){
    //     $star_auditions = AssignJudge::where([['judge_id', auth('sanctum')->user()->id], ['approved_by_judge', 0]])->get();
    //     return response()->json([
    //         'status' => 200,
    //         'star_auditions' => $star_auditions,
    //     ]);
    // }

    // public function starSingleAudition($id){

    //     return $this->getAudition($id);

    // }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }
}
