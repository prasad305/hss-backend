<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Audition\Audition;
use App\Models\User;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use App\Models\Audition\AssignJudge;

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
        $request->validate([
            'title' => 'required',
            'start_one_id' => 'required',
            'start_two_id' => 'required',
            'start_three_id' => 'required',
            'banner' => 'required',
        ]);

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

        } catch (\Throwable $th) {
            //throw $th;
        }
       
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
