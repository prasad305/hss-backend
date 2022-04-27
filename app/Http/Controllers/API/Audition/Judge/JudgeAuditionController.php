<?php

namespace App\Http\Controllers\API\Audition\Judge;

use App\Http\Controllers\Controller;
use App\Models\Audition\Audition;
use App\Models\Audition\AuditionAssignJudge;

class JudgeAuditionController extends Controller
{
       // Star  Audition Start
       public function starPendingAudtion()
       {
           $pendingAuditions = Audition::with('judge')
                                       ->whereHas('judge', function ($q) {
                                           $q->where([['judge_id', auth('sanctum')->user()->id], ['approved_by_judge', 0]]);
                                       })
                                       ->get();
   
           return response()->json([
               'status' => 200,
               'pending_auditions' => $pendingAuditions,
           ]);
       }
   
       public function starLiveAudtion()
       {
           $liveAuditions = Audition::with('judge')
               ->whereHas('judge', function ($q) {
                   $q->where([['judge_id', auth('sanctum')->user()->id], ['approved_by_judge', 1]]);
               })->get();
   
           return response()->json([
               'status' => 200,
               'liveAuditions' => $liveAuditions,
           ]);
       }
   
    public function starSingleAudition($id)
    {

        $pending_auditions = Audition::with(['judge', 'jury','admin'])->where('id', $id)->where('status',1)->get();
        return response()->json([
            'status' => 200,
            'pending_audition' => $pending_auditions,
        ]);
    }

    public function starApprovedAudition($id)
    {
        AuditionAssignJudge::where('audition_id', $id)->where('judge_id', auth('sanctum')->user()->id)->update(['approved_by_judge' => 1]);

        return response()->json([
            'status' => 200,
        ]);
    }

    public function starDeclineAudition($id)
    {
        AuditionAssignJudge::where('audition_id', $id)->where('judge_id', auth('sanctum')->user()->id)->update(['approved_by_judge' => 2]);

        return response()->json([
            'status' => 200,
        ]);
    }
}
