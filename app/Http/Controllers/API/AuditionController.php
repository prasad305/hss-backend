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
       

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
            'star_one_id' => 'required',
            'banner' => 'required',

        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'validation_errors' => $validator->errors(),
            ]);
        }else{
            $one = $request->star_one_id;
            $two = $request->star_two_id;
            $three = $request->star_three_id;
    
             $primay_array = [$one,$two,$three];

             $star_ids = array_filter($primay_array);
    
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
                foreach ($star_ids as $key => $star) {
                   $assign_star = AssignJudge::create([
                        'audition_id' => $audition->id,
                        'judge_id' => $star,
                   ]); 
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
        // foreach ($audition->assignJudge as $key => $value) {
        //     # code...
        // }
        return response()->json([
            'status' => 200,
            'audition' => $audition,
            'audition' => $audition,
        ]);
    }


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
