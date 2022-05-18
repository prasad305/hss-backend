<?php

namespace App\Http\Controllers\API\Audition\Jury;

use App\Http\Controllers\Controller;
use App\Models\Audition\Audition;
use App\Models\Audition\AuditionRoundRule;
use App\Models\Audition\AuditionUploadVideo;
use Illuminate\Http\Request;

class JuryAuditionController extends Controller
{
    public function singleAuditionVideos($audition_id)
    {
        $audition = Audition::find($audition_id);
        $audition_rule = $audition->auditionRules;
        $audition_round_rules = $audition_rule->roundRules;

        return response()->json([
            'status' => 200,
            'audition' => $audition,
            'audition_rule' => $audition_rule,
            'audition_round_rules' => $audition_round_rules,
            'pending_videos' => AuditionUploadVideo::where('audition_id',$audition_id)->where('round_id',  $audition->audition_round_rules_id)->where('approval_status',0)->get(),
            'reject_videos' => AuditionUploadVideo::where('audition_id',$audition_id)->where('round_id',  $audition->audition_round_rules_id)->where('approval_status',2)->get(),
            'approved_videos' => AuditionUploadVideo::where('audition_id',$audition_id)->where('round_id',  $audition->audition_round_rules_id)->where('approval_status',1)->get(),
            'check_videos' => AuditionUploadVideo::where('audition_id',$audition_id)->where('round_id',  $audition->audition_round_rules_id)->whereIn('approval_status',[1,2])->get(),
            'pending_videos_num' => $audition->uploadedVideos->where('round_id',  $audition->audition_round_rules_id)->where('approval_status',0)->count(),
            'approved_videos_num' => $audition->uploadedVideos->where('round_id',  $audition->audition_round_rules_id)->where('approval_status',1)->count(),
            'check_video_num' => $audition->uploadedVideos->where('round_id',  $audition->audition_round_rules_id)->whereIn('approval_status',[1,2])->count(),
            'reject_video_num' => $audition->uploadedVideos->where('round_id',  $audition->audition_round_rules_id)->where('approval_status',2)->count(),
            'first_audition_round_rule' =>  AuditionRoundRule::find($audition->audition_round_rules_id)
        ]);
    }

      // Live Auditions
      public function live()
      {
          $user = auth('sanctum')->user();

        //   foreach ($user->assignedAuditionsJury as $key => $assignedAuditionsJury) {
        //       # code...
        //   }

        // Model::pluck('column')


        $auditionIds = $user->assignedAuditionsJury->pluck('audition_id');

          $lives = Audition::whereIn('id', $auditionIds)->where('status',3)->get();
          return response()->json([
              'status' => 200,
              'lives' => $lives,
          ]);
      }


}
