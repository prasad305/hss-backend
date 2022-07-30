<?php

namespace App\Http\Controllers\API\Audition\Jury;

use App\Http\Controllers\Controller;
use App\Models\Audition\Audition;
use App\Models\Audition\AuditionAssignJury;
use App\Models\Audition\AuditionParticipant;
use App\Models\Audition\AuditionPromoInstructionSendInfo;
use App\Models\Audition\AuditionRoundInfo;
use App\Models\Audition\AuditionRoundRule;
use App\Models\Audition\AuditionUploadVideo;
use App\Models\JuryGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JuryAuditionController extends Controller
{
    public function getAudition($slug)
    {
        $event = Audition::with(['assignedJudges', 'participant', 'promoInstruction'])->where('slug', $slug)->first();
        return response()->json([
            'status' => 200,
            'event' => $event,
        ]);
    }
    public function markAssessment(Request $request)
    {
        $auditionUploadVideo =  AuditionUploadVideo::find($request->video_id);
        if ($request->my_group == 'b') {
            $auditionUploadVideo->group_b_jury_mark = $request->mark;
        } else {
            $auditionUploadVideo->group_c_jury_mark = $request->mark;
        }
        $auditionUploadVideo->save();
        return response()->json([
            'status' => 200,
            'message' => 'Mark added successfully !',
        ]);
    }
    public function markAssessmentAsMainGroup(Request $request)
    {
        $auditionUploadVideo =  AuditionUploadVideo::find($request->video_id);

        $auditionUploadVideo->group_a_jury_mark = $request->mark;

        $auditionUploadVideo->save();
        return response()->json([
            'status' => 200,
            'message' => 'Mark added successfully !',
        ]);
    }
    public function singleAuditionVideoAssessmentWithRound($audition_id, $audition_round_info_id, $type)
    {
        $audition = Audition::find($audition_id);
        $auditionRoundInfo  = AuditionRoundInfo::find($audition_round_info_id);

        if (AuditionUploadVideo::where([['round_info_id', $audition_round_info_id], ['type', $type], ['audition_id', $audition_id], ['group_b_jury_id', auth()->user()->id]])->count() > 0) {
            $myGroup = 'b';
            $auditionUploadVideos =  AuditionUploadVideo::where([['round_info_id', $audition_round_info_id], ['type', $type], ['audition_id', $audition_id], ['group_b_jury_id', auth()->user()->id], ['group_b_jury_mark', null]])->orderBy('updated_at', 'DESC')->get();
            $markedVideos =  AuditionUploadVideo::where([['round_info_id', $audition_round_info_id], ['type', $type], ['audition_id', $audition_id], ['group_b_jury_id', auth()->user()->id], ['group_b_jury_mark', '!=', null]])->orderBy('updated_at', 'DESC')->get();
        } else {
            $myGroup = 'c';
            $auditionUploadVideos =  AuditionUploadVideo::where([['round_info_id', $audition_round_info_id], ['type', $type], ['audition_id', $audition_id], ['group_c_jury_id', auth()->user()->id], ['group_c_jury_mark', null]])->orderBy('updated_at', 'DESC')->get();
            $markedVideos =  AuditionUploadVideo::where([['round_info_id', $audition_round_info_id], ['type', $type], ['audition_id', $audition_id], ['group_c_jury_id', auth()->user()->id], ['group_c_jury_mark', '!=', null]])->orderBy('updated_at', 'DESC')->get();
        }
        return response()->json([
            'status' => 200,
            'audition' => $audition,
            'auditionRoundInfo' => $auditionRoundInfo,
            'myGroup' => $myGroup,
            'auditionUploadVideos' => $auditionUploadVideos,
            'markedVideos' => $markedVideos,
        ]);
    }
    public function VideoAssessmentAsMainGroupWithRound($audition_id, $audition_round_info_id, $type)
    {
        $audition = Audition::find($audition_id);
        $auditionRoundInfo  = AuditionRoundInfo::find($audition_round_info_id);


        $percentageVideos =  AuditionUploadVideo::where([['round_info_id', $audition_round_info_id],['type', $type], ['audition_id', $audition_id], ['group_a_per_jury_id', auth()->user()->id]])->orderBy('updated_at', 'DESC')->get();
        $randomVideos =  AuditionUploadVideo::where([['round_info_id', $audition_round_info_id],['type', $type], ['audition_id', $audition_id], ['group_a_ran_jury_id', auth()->user()->id]])->orderBy('updated_at', 'DESC')->get();

        return response()->json([
            'status' => 200,
            'audition' => $audition,
            'auditionRoundInfo' => $auditionRoundInfo,
            'percentageVideos' => $percentageVideos,
            'randomVideos' => $randomVideos,
        ]);
    }

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
            'pending_videos' => AuditionUploadVideo::where('audition_id', $audition_id)->where('round_id',  $audition->audition_round_rules_id)->where('jury_id', auth('sanctum')->user()->id)->where('jury_approval_status', 0)->get(),
            'reject_videos' => AuditionUploadVideo::where('audition_id', $audition_id)->where('round_id',  $audition->audition_round_rules_id)->where('jury_id', auth('sanctum')->user()->id)->where('jury_approval_status', 2)->get(),
            'approved_videos' => AuditionUploadVideo::where('audition_id', $audition_id)->where('round_id',  $audition->audition_round_rules_id)->where('jury_id', auth('sanctum')->user()->id)->where('jury_approval_status', 1)->get(),
            'check_videos' => AuditionUploadVideo::where('audition_id', $audition_id)->where('round_id',  $audition->audition_round_rules_id)->where('jury_id', auth('sanctum')->user()->id)->whereIn('jury_approval_status', [1, 2])->get(),
            'pending_videos_num' => $audition->uploadedVideos->where('round_id',  $audition->audition_round_rules_id)->where('jury_id', auth('sanctum')->user()->id)->where('jury_approval_status', 0)->count(),
            'approved_videos_num' => $audition->uploadedVideos->where('round_id',  $audition->audition_round_rules_id)->where('jury_id', auth('sanctum')->user()->id)->where('jury_approval_status', 1)->count(),
            'check_video_num' => $audition->uploadedVideos->where('round_id',  $audition->audition_round_rules_id)->where('jury_id', auth('sanctum')->user()->id)->whereIn('jury_approval_status', [1, 2])->count(),
            'reject_video_num' => $audition->uploadedVideos->where('round_id',  $audition->audition_round_rules_id)->where('jury_id', auth('sanctum')->user()->id)->where('jury_approval_status', 2)->count(),
            'first_audition_round_rule' =>  AuditionRoundRule::find($audition->audition_round_rules_id)
        ]);
    }

    public function singleAuditionVideoWithRoundId($audition_id, $audition_round_id)
    {
        $audition = Audition::find($audition_id);
        $audition_rule = $audition->auditionRules;
        $audition_round_rules = $audition_rule->roundRules;

        return response()->json([
            'status' => 200,
            'audition' => $audition,
            'audition_rule' => $audition_rule,
            'audition_round_rules' => $audition_round_rules,
            'pending_videos' => AuditionUploadVideo::where('audition_id', $audition_id)->where('round_id',  $audition_round_id)->where('jury_id', auth('sanctum')->user()->id)->where('jury_approval_status', 0)->get(),
            'reject_videos' => AuditionUploadVideo::where('audition_id', $audition_id)->where('round_id',  $audition_round_id)->where('jury_id', auth('sanctum')->user()->id)->where('jury_approval_status', 2)->get(),
            'approved_videos' => AuditionUploadVideo::where('audition_id', $audition_id)->where('round_id',  $audition_round_id)->where('jury_id', auth('sanctum')->user()->id)->where('jury_approval_status', 1)->get(),
            'check_videos' => AuditionUploadVideo::where('audition_id', $audition_id)->where('round_id',  $audition_round_id)->where('jury_id', auth('sanctum')->user()->id)->whereIn('jury_approval_status', [1, 2])->get(),
            'pending_videos_num' => $audition->uploadedVideos->where('round_id',  $audition_round_id)->where('jury_id', auth('sanctum')->user()->id)->where('jury_approval_status', 0)->count(),
            'approved_videos_num' => $audition->uploadedVideos->where('round_id',  $audition_round_id)->where('jury_id', auth('sanctum')->user()->id)->where('jury_approval_status', 1)->count(),
            'check_video_num' => $audition->uploadedVideos->where('round_id',  $audition_round_id)->where('jury_id', auth('sanctum')->user()->id)->whereIn('jury_approval_status', [1, 2])->count(),
            'reject_video_num' => $audition->uploadedVideos->where('round_id',  $audition_round_id)->where('jury_id', auth('sanctum')->user()->id)->where('jury_approval_status', 2)->count(),
            'first_audition_round_rule' => AuditionRoundRule::find($audition_round_id),
        ]);
    }

    // Live Auditions
    public function live()
    {
        $user = auth('sanctum')->user();
        $auditionIds = $user->assignedAuditionsJury->pluck('audition_id');
        $events = Audition::whereIn('id', $auditionIds)->where('status', 3)->get();
        // return $user->jury;

        $is_my_group_primary = $user->jury->group->is_primary == 1 ? true : false;
        return response()->json([
            'status' => 200,
            'events' => $events,
            'is_my_group_primary' => $is_my_group_primary,
        ]);
    }

    public function videoStatusChange(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'video_id' => 'required',
            // 'comment' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'validation_errors' => $validator->errors(),
            ]);
        } else {
            $AuditionUploadVideo = AuditionUploadVideo::find($request->video_id);
            if ($request->accepted == 1) {
                $AuditionUploadVideo->jury_approval_status = 1;
            } elseif ($request->rejected == 1) {
                $AuditionUploadVideo->jury_approval_status = 2;
            }
            $AuditionUploadVideo->jury_comment = $request->comment;
            $AuditionUploadVideo->jury_mark = $request->mark;
            $AuditionUploadVideo->save();

            return response()->json([
                'status' => 200,
                'message' => "Video mark added successfully !",
            ]);
        }
    }
}
