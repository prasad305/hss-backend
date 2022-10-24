<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Audition\Audition;
use App\Models\Audition\AuditionUserVoteMark;
use Illuminate\Http\Request;

class AuditionUserVoteController extends Controller
{
    public function index()
    {

        $instruction = AuditionUserVoteMark::orderBy('id', 'DESC')->get();
        return view('SuperAdmin.AuditionUserVoteMark.index', compact('instruction'));
    }
    public function userVoteMarkCreate()
    {
        $data = [
            'auditions' => Audition::orderBy('id', 'desc')->get(),
        ];

        return view('SuperAdmin.AuditionUserVoteMark.create', $data);
    }
    public function userVoteMarkEdit($id)
    {
        $data = [
            'auditions' => Audition::orderBy('id', 'desc')->get(),
            'voteMark' => AuditionUserVoteMark::find($id),
        ];
        return view('SuperAdmin.AuditionUserVoteMark.edit', $data);
    }
    public function userVoteMarkStore(Request $request)
    {



        $request->validate([

            'audition_id' => 'required',
            'total_react' => 'required',
            'user_mark' => 'required',


        ]);

        try {
            $instruction = AuditionUserVoteMark::create(
                $request->all()
            );
            if ($instruction) {
                return response()->json([
                    'success' => true,
                    'message' => 'Instruction Add Successfully'
                ]);
            }
        } catch (\Exception $exception) {
            return response()->json([
                'type' => 'error',
                'message' => 'Opps somthing went wrong. ' . $exception->getMessage(),
            ]);
        }
    }

    public function userVoteMarkUpdate(Request $request, $id)
    { 

            $request->validate([


                'audition_id' => 'required',
                'total_react' => 'required',
                'user_mark' => 'required',

            ]);

            try {
                $instruction = AuditionUserVoteMark::findOrFail($id)->Update(
                    [
                        'audition_id' => $request->audition_id,
                        'total_react' => $request->total_react,
                        'user_mark' => $request->user_mark,
                    ]

                );
                if ($instruction) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Instruction Updated Successfully'
                    ]);
                }
            } catch (\Exception $exception) {
                return response()->json([
                    'type' => 'error',
                    'message' => 'Opps somthing went wrong. ' . $exception->getMessage(),
                ]);
            }
        
    }
    public function userVoteMarkDestroy($id)
    {
        $term = AuditionUserVoteMark::findOrfail($id);
        try {
            $term->delete();
            return response()->json([
                'type' => 'success',
                'message' => 'Successfully Deleted !!',
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'type' => 'error',
                'message' => 'error' . $exception->getMessage(),
            ]);
        }
    }
}
