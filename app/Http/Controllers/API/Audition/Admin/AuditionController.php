<?php

namespace App\Http\Controllers\API\Audition\Admin;

use App\Http\Controllers\Controller;
use App\Models\Audition\Audition;
use App\Models\User;
use App\Models\SuperStar;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use App\Models\Audition\AuditionAssignJudge;
use App\Models\Audition\AuditionAssignJury;
use App\Models\Audition\AuditionJudgeInstruction;
use App\Models\Audition\AuditionParticipant;
use App\Models\Audition\AuditionPromoInstruction;
use App\Models\Audition\AuditionPromoInstructionSendInfo;
use App\Models\Audition\AuditionRoundAppealRegistration;
use App\Models\Audition\AuditionRoundInfo;
use App\Models\Audition\AuditionRoundInstructionSendInfo;
use App\Models\Audition\AuditionRoundMarkTracking;
use App\Models\Audition\AuditionRoundRule;
use App\Models\Audition\AuditionUploadVideo;
use App\Models\Audition\AuditionUserVoteMark;
use App\Models\auditionJudgeMark;
use App\Models\AuditionOxygenReplyVideo;
use App\Models\AuditionOxygenVideo;
use App\Models\AuditionRoundInstruction;
use App\Models\JuryGroup;
use App\Models\LoveReact;
use App\Models\WildCard;
use App\Models\AuditionCertificationContent;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuditionController extends Controller
{
    public function events()
    {
        $events = Audition::where([['audition_admin_id', auth('sanctum')->user()->id], ['status', '>', 0]])->get();

        return response()->json([
            'status' => 200,
            'events' => $events,
        ]);
    }

    public function getAllAudition()
    {
        $auditions = Audition::where('status', '>', 0)->get();

        return response()->json([
            'status' => 200,
            'auditions' => $auditions,
        ]);
    }

    public function statusUpdate(Request $request)
    {
        $audition = Audition::find($request->audition_id);
        $message = "";

        try {
            if ($request->status == 1) {
                $audition->update([
                    'status' => 1,
                ]);
                $message = "Audition Accepted Successfully!";
            } else {
                $audition->update([
                    'status' => 11,
                ]);
                $message = "Audition Reject Successfully!";
            }
            return response()->json([
                'status' => 200,
                'message' => $message,
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'status' => 500,
                'message' => 'Opps... Something went wrong ! ' . $exception->getMessage(),
            ]);
        }
    }

    public function storePostContent(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'instruction' => 'required|min:5',
            'description' => 'required|min:5',
            'image' => 'nullable|mimes:jpg,jpeg,png,gif',
            'video' => 'nullable|mimes:mp4,mkv',
            'fees' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'validation_errors' => $validator->errors(),
            ]);
        } else {
            $audition = Audition::find($request->audition_id);
            $auditionInfo = $audition->info;
            if ($audition->status >= 2) {
                return response()->json([
                    'status' => 410,
                    'message' => 'This Audition Already Posted by Manager Admin!',
                ]);
            }
            $audition->instruction = $request->instruction;
            $audition->description = $request->description;
            $audition->user_reg_start_date = $request->user_reg_start_date;
            $audition->user_reg_end_date = $request->user_reg_end_date;
            $audition->fees = $request->fees;
            $audition->status = 2;

            if ($request->hasfile('image')) {
                $destination = $audition->banner;
                if (File::exists($destination)) {
                    File::delete($destination);
                }
                $image             = $request->image;
                $image_folder_path       = 'uploads/images/auditions/post/';
                $image_new_name    = Str::random(20) . '-' . now()->timestamp . '.' . $image->getClientOriginalExtension();
                // save to server
                $request->image->move($image_folder_path, $image_new_name);
                $audition->banner = $image_folder_path . '/' . $image_new_name;
            }

            if ($request->hasfile('video')) {
                $destination = $audition->video;
                if (File::exists($destination)) {
                    File::delete($destination);
                }
                $file             = $request->video;
                $folder_path       = 'uploads/videos/auditions/post/';
                $file_new_name    = Str::random(20) . '-' . now()->timestamp . '.' . $file->getClientOriginalExtension();
                // save to server
                $request->video->move($folder_path, $file_new_name);
                $audition->video = $folder_path . '/' . $file_new_name;
            }

            try {
                $audition->save();
                $auditionInfo->save();
                return response()->json([
                    'status' => 200,
                    'message' => 'Audition Post Content Updated Successfully!',
                ]);
            } catch (\Exception $exception) {
                return response()->json([
                    'status' => 500,
                    'message' => 'Opps... Something went wrong ! ' . $exception->getMessage(),
                ]);
            }
        }
    }

    public function postList()
    {
        $events = Audition::where([['audition_admin_id', auth('sanctum')->user()->id], ['status', '>', 1]])->get();

        return response()->json([
            'status' => 200,
            'events' => $events,
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
            'pending_videos' => AuditionUploadVideo::where('audition_id', $audition_id)->where('round_id', $audition_round_id)->where('approval_status', 0)->get(),
            'reject_videos' => AuditionUploadVideo::where('audition_id', $audition_id)->where('round_id', $audition_round_id)->where('approval_status', 2)->get(),
            'approved_videos' => AuditionUploadVideo::where('audition_id', $audition_id)->where('round_id', $audition_round_id)->where('approval_status', 1)->get(),
            'check_videos' => AuditionUploadVideo::where('audition_id', $audition_id)->where('round_id', $audition_round_id)->whereIn('approval_status', [1, 2])->get(),
            'pending_videos_num' => $audition->uploadedVideos->where('round_id', $audition_round_id)->where('approval_status', 0)->count(),
            'approved_videos_num' => $audition->uploadedVideos->where('round_id', $audition_round_id)->where('approval_status', 1)->count(),
            'check_video_num' => $audition->uploadedVideos->where('round_id', $audition_round_id)->whereIn('approval_status', [1, 2])->count(),
            'reject_video_num' => $audition->uploadedVideos->where('round_id', $audition_round_id)->where('approval_status', 2)->count(),
            'first_audition_round_rule' => AuditionRoundRule::find($audition_round_id),
        ]);
    }
    public function singleAuditionRounds($audition_id)
    {
        $audition = Audition::find($audition_id);
        $audition_rule = $audition->auditionRules;
        $audition_round_rules = $audition_rule->roundRules;

        if ($audition->judgeInstructions->where('round_id', $audition->audition_round_rules_id)->count() > 0) {
            $is_already_submitted = true;
            if ($audition->judgeInstructions->where('round_id', $audition->audition_round_rules_id)->where('status', 0)->count() > 0) {
                $is_all_star_responsed = false;
                if ($audition->judgeInstructions->where('round_id', $audition->audition_round_rules_id)->where('status', 1)->count() > 0) {
                    $is_any_star_responsed  = true;
                } else {
                    $is_any_star_responsed  = false;
                }
            } else {
                $is_all_star_responsed = true;
                $is_any_star_responsed  = true;
            }
        } else {
            $is_already_submitted = false;
            $is_all_star_responsed = false;
            $is_any_star_responsed  = false;
        }

        if ($audition->judgeInstructions->where('round_id', $audition->audition_round_rules_id)->first()) {
            $active_audition_judge_instruction_id = $audition->judgeInstructions->where('round_id', $audition->audition_round_rules_id)->first()->id;
        } else {
            $active_audition_judge_instruction_id = null;
        }
        return response()->json([
            'status' => 200,
            'audition' => $audition,
            'audition_rule' => $audition_rule,
            'audition_judge_instructions' => $audition->judgeInstructions->where('round_id', $audition->audition_round_rules_id),
            'active_audition_judge_instruction_id' => $active_audition_judge_instruction_id,
            'audition_round_rules' => $audition_round_rules,
            'first_audition_round_rule' => AuditionRoundRule::find($audition->audition_round_rules_id),
            'is_already_submitted' => $is_already_submitted,
            'is_all_star_responsed' => $is_all_star_responsed,
            'is_any_star_responsed' => $is_any_star_responsed,
        ]);
    }
    public function singleAuditionRoundWithRoundId($audition_id, $audition_round_id)
    {
        $audition = Audition::find($audition_id);
        $audition_rule = $audition->auditionRules;
        $audition_round_rules = $audition_rule->roundRules;

        if ($audition->judgeInstructions->where('round_id', $audition_round_id)->count() > 0) {
            $is_already_submitted = true;
            if ($audition->judgeInstructions->where('round_id', $audition_round_id)->where('status', 0)->count() > 0) {
                $is_all_star_responsed = false;
                if ($audition->judgeInstructions->where('round_id', $audition_round_id)->where('status', 1)->count() > 0) {
                    $is_any_star_responsed  = true;
                } else {
                    $is_any_star_responsed  = false;
                }
            } else {
                $is_all_star_responsed = true;
                $is_any_star_responsed  = true;
            }
        } else {
            $is_already_submitted = false;
            $is_all_star_responsed = false;
            $is_any_star_responsed  = false;
        }

        if ($audition->judgeInstructions->where('round_id', $audition_round_id)->first()) {
            $active_audition_judge_instruction_id = $audition->judgeInstructions->where('round_id', $audition_round_id)->first()->id;
        } else {
            $active_audition_judge_instruction_id = null;
        }
        return response()->json([
            'status' => 200,
            'audition' => $audition,
            'audition_rule' => $audition_rule,
            'audition_judge_instructions' => $audition->judgeInstructions->where('round_id', $audition_round_id),
            'active_audition_judge_instruction_id' => $active_audition_judge_instruction_id,
            'audition_round_rules' => $audition_round_rules,
            'first_audition_round_rule' => AuditionRoundRule::find($audition_round_id),
            'is_already_submitted' => $is_already_submitted,
            'is_all_star_responsed' => $is_all_star_responsed,
            'is_any_star_responsed' => $is_any_star_responsed,
        ]);
    }
    public function assignJuries(Request $request)
    {
        try {
            foreach ($request->juries as $parentKey => $juryGroup) {
                foreach ($juryGroup as $key => $value) {
                    if ($parentKey == 0) {
                        AuditionUploadVideo::where([['group_b_jury_id', null], ['audition_id', $request->audition_id], ['type', $request->type],  ['approval_status', 1], ['round_info_id', $request->round_info_id]])->take($request->distributed_videos[$parentKey][$key])->update([
                            'group_b_jury_id' => $value,
                        ]);
                    }
                    if ($parentKey == 1) {
                        AuditionUploadVideo::where([['group_c_jury_id', null], ['audition_id', $request->audition_id], ['type', $request->type],  ['approval_status', 1], ['round_info_id', $request->round_info_id]])->take($request->distributed_videos[$parentKey][$key])->update([
                            'group_c_jury_id' => $value,
                        ]);
                    }
                }
            }

            return response()->json([
                'status' => 200,
                'message' => 'Jury assigned successfully !',
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'status' => 500,
                'message' => 'Opps... Something went wrong ! ' . $exception->getMessage(),
            ]);
        }
    }
    public function assignJudges(Request $request)
    {
        $audition = Audition::find($request->audition_id);
        $judgesIds = $audition->assignedJudges->pluck('judge_id')->toArray();

        // return  AuditionUploadVideo::where([['judge_id', []], ['audition_id', $request->audition_id], ['type', $request->type],  ['approval_status', 1], ['round_info_id', $request->round_info_id]])->get();

        try {
            // AuditionUploadVideo::where([['judge_id', []], ['audition_id', $request->audition_id], ['type', $request->type],  ['approval_status', 1], ['round_info_id', $request->round_info_id]])->update([
            //     'judge_id' => json_encode($judgesIds),
            //     // 'updated_at' => Carbon::now()
            // ]);

            $auditionUploadVideos =  AuditionUploadVideo::where([['judge_id', []], ['audition_id', $request->audition_id], ['type', $request->type],  ['approval_status', 1], ['round_info_id', $request->round_info_id]])->get();

            foreach ($auditionUploadVideos as $key => $auditionUploadVideo) {
                $auditionUploadVideo->judge_id = json_encode($judgesIds);
                $auditionUploadVideo->save();
            }

            return response()->json([
                'status' => 200,
                'message' => 'Judge assigned successfully !',
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'status' => 500,
                'message' => 'Opps... Something went wrong ! ' . $exception->getMessage(),
            ]);
        }
    }

    public function singleAuditionApprovedVideoWithRoundId($audition_id, $audition_round_info_id)
    {
        $audition = Audition::find($audition_id);
        $auditionRoundInfo  = AuditionRoundInfo::find($audition_round_info_id);

        $assignJuries = AuditionAssignJury::with('juryGroup')->whereHas('juryGroup', function ($q) {
            $q->where('is_primary', false);
        })->where([['audition_id', $audition->id]])->get();

        $assignJuriesOrderByGroup = $assignJuries->groupBy('group_id');

        $auditionParticipantWithVideos = AuditionParticipant::with(['videos' => function ($query) use ($audition_round_info_id) {
            return $query->where([['round_info_id', $audition_round_info_id], ['type', 'general'],  ['approval_status', 1],])->get();
        }, 'participant'])->where([['audition_id', $audition_id], ['round_info_id', $audition_round_info_id]])->get();

        $totalNumberOfVideos = AuditionUploadVideo::where([['round_info_id', $audition_round_info_id], ['type', 'general'], ['audition_id', $audition_id], ['approval_status', 1]])->count();

        if ($auditionRoundInfo->has_jury_or_judge_mark == 0) {
            $alreadyAssignedCount = AuditionUploadVideo::where([['round_info_id', $audition_round_info_id], ['type', 'general'], ['audition_id', $audition_id], ['approval_status', 1], ['group_b_jury_id', '!=', null], ['group_c_jury_id', '!=', null]])->count();
        } else {
            $alreadyAssignedCount = AuditionUploadVideo::where([['round_info_id', $audition_round_info_id], ['type', 'general'], ['audition_id', $audition_id], ['approval_status', 1], ['judge_id', '!=', '[]']])->count();
        }

        $isVideoAlreadyAssigned = $alreadyAssignedCount > 0 ? true : false;

        return response()->json([
            'status' => 200,
            'audition' => $audition,
            'auditionRoundInfo' => $auditionRoundInfo,
            'assignJuriesOrderByGroup' => $assignJuriesOrderByGroup,
            'auditionParticipantWithVideos' => $auditionParticipantWithVideos,
            'totalNumberOfVideos' => $totalNumberOfVideos,
            'isVideoAlreadyAssigned' => $isVideoAlreadyAssigned,
        ]);
    }
    public function appealApprovedVideoWithRoundId($audition_id, $audition_round_info_id)
    {
        $audition = Audition::find($audition_id);
        $auditionRoundInfo  = AuditionRoundInfo::find($audition_round_info_id);

        $assignJuries = AuditionAssignJury::with('juryGroup')->whereHas('juryGroup', function ($q) {
            $q->where('is_primary', false);
        })->where([['audition_id', $audition->id]])->get();

        $assignJuriesOrderByGroup = $assignJuries->groupBy('group_id');

        $auditionParticipantWithVideos = AuditionParticipant::with(['videos' => function ($query) use ($audition_round_info_id) {
            return $query->where([['round_info_id', $audition_round_info_id], ['type', 'appeal'],  ['approval_status', 1]])->get();
        }, 'participant'])->where([['audition_id', $audition_id], ['round_info_id', $audition_round_info_id]])->get();

        $totalNumberOfVideos = AuditionUploadVideo::where([['round_info_id', $audition_round_info_id], ['type', 'appeal'], ['audition_id', $audition_id], ['approval_status', 1]])->count();

        if ($auditionRoundInfo->round_type == 0) {
            $alreadyAssignedCount = AuditionUploadVideo::where([['round_info_id', $audition_round_info_id], ['type', 'appeal'], ['audition_id', $audition_id], ['approval_status', 1], ['group_b_jury_id', '!=', null], ['group_c_jury_id', '!=', null]])->count();
        } else {
            $alreadyAssignedCount = AuditionUploadVideo::where([['round_info_id', $audition_round_info_id], ['type', 'appeal'], ['audition_id', $audition_id], ['approval_status', 1], ['judge_id', '!=', '[]']])->count();
        }


        $isVideoAlreadyAssigned = $alreadyAssignedCount > 0 ? true : false;

        return response()->json([
            'status' => 200,
            'audition' => $audition,
            'auditionRoundInfo' => $auditionRoundInfo,
            'assignJuriesOrderByGroup' => $assignJuriesOrderByGroup,
            'auditionParticipantWithVideos' => $auditionParticipantWithVideos,
            'totalNumberOfVideos' => $totalNumberOfVideos,
            'isVideoAlreadyAssigned' => $isVideoAlreadyAssigned,
        ]);
    }
    public function videoReportBasedOnSingleJury($audition_id, $audition_round_info_id, $jury_id, $type)
    {
        // return $audition_id."-------".$audition_round_info_id."-------".$jury_id;
        $audition = Audition::find($audition_id);
        $auditionRoundInfo  = AuditionRoundInfo::find($audition_round_info_id);


        if (AuditionUploadVideo::where([['group_b_jury_id', $jury_id], ['round_info_id', $audition_round_info_id], ['type', $type], ['audition_id', $audition_id]])->count() > 0) {
            $videos =  AuditionUploadVideo::where([['group_b_jury_id', $jury_id], ['round_info_id', $audition_round_info_id], ['type', $type], ['audition_id', $audition_id]])->get();
            $video_number = AuditionUploadVideo::where([['group_b_jury_id', $jury_id], ['round_info_id', $audition_round_info_id], ['type', $type], ['audition_id', $audition_id]])->count();
            $marked_video_number = AuditionUploadVideo::where([['group_b_jury_mark', '!=', null], ['group_b_jury_id', $jury_id], ['round_info_id', $audition_round_info_id], ['type', $type], ['audition_id', $audition_id]])->count();
            $non_marked_video_number = AuditionUploadVideo::where([['group_b_jury_mark', null], ['group_b_jury_id', $jury_id], ['round_info_id', $audition_round_info_id], ['type', $type], ['audition_id', $audition_id]])->count();
        } else if (AuditionUploadVideo::where([['group_c_jury_id', $jury_id], ['round_info_id', $audition_round_info_id], ['type', $type], ['audition_id', $audition_id]])->count() > 0) {
            $videos = AuditionUploadVideo::where([['group_c_jury_id', $jury_id], ['round_info_id', $audition_round_info_id], ['type', $type], ['audition_id', $audition_id]])->get();
            $video_number =  AuditionUploadVideo::where([['group_c_jury_id', $jury_id], ['round_info_id', $audition_round_info_id], ['type', $type], ['audition_id', $audition_id]])->count();
            $marked_video_number = AuditionUploadVideo::where([['group_c_jury_mark', '!=', null], ['group_c_jury_id', $jury_id], ['round_info_id', $audition_round_info_id], ['type', $type], ['audition_id', $audition_id]])->count();
            $non_marked_video_number = AuditionUploadVideo::where([['group_c_jury_mark', null], ['group_c_jury_id', $jury_id], ['round_info_id', $audition_round_info_id], ['type', $type], ['audition_id', $audition_id]])->count();
        } else if (AuditionUploadVideo::where([['group_a_ran_jury_id', $jury_id], ['round_info_id', $audition_round_info_id], ['type', $type], ['audition_id', $audition_id]])->count() > 0 || AuditionUploadVideo::where([['group_a_per_jury_id', $jury_id], ['round_info_id', $audition_round_info_id], ['type', $type], ['audition_id', $audition_id]])->count() > 0) {

            $auditionUploadVideoARan = AuditionUploadVideo::where([['group_a_ran_jury_id', $jury_id], ['round_info_id', $audition_round_info_id], ['type', $type], ['audition_id', $audition_id]])->get();
            $auditionUploadVideoAPer = AuditionUploadVideo::where([['group_a_per_jury_id', $jury_id], ['round_info_id', $audition_round_info_id], ['type', $type], ['audition_id', $audition_id]])->get();
            $markedauditionUploadVideoARan = AuditionUploadVideo::where([['group_a_ran_jury_id', '!=', null], ['group_a_ran_jury_id', $jury_id], ['round_info_id', $audition_round_info_id], ['type', $type], ['audition_id', $audition_id]])->get();
            $markedauditionUploadVideoAPer = AuditionUploadVideo::where([['group_a_per_jury_id', '!=', null], ['group_a_per_jury_id', $jury_id], ['round_info_id', $audition_round_info_id], ['type', $type], ['audition_id', $audition_id]])->get();
            $nonMarkedauditionUploadVideoARan = AuditionUploadVideo::where([['group_a_ran_jury_id', null], ['group_a_ran_jury_id', $jury_id], ['round_info_id', $audition_round_info_id], ['type', $type], ['audition_id', $audition_id]])->get();
            $nonMarkedauditionUploadVideoAPer = AuditionUploadVideo::where([['group_a_per_jury_id', null], ['group_a_per_jury_id', $jury_id], ['round_info_id', $audition_round_info_id], ['type', $type], ['audition_id', $audition_id]])->get();


            $videos =  $auditionUploadVideoARan->concat($auditionUploadVideoAPer);
            $video_number =  $videos->count();

            $marked_video =  $markedauditionUploadVideoARan->concat($markedauditionUploadVideoAPer);
            $non_marked_video = $nonMarkedauditionUploadVideoARan->concat($nonMarkedauditionUploadVideoAPer);

            $marked_video_number =  $marked_video->count();
            $non_marked_video_number = $non_marked_video->count();
        } else {
            $video_number  = 0;
            $videos = [];
            $marked_video_number = 0;
            $non_marked_video_number = 0;
        }



        return response()->json([
            'status' => 200,
            'audition' => $audition,
            'auditionRoundInfo' => $auditionRoundInfo,
            'video_number' => $video_number,
            'videos' => $videos,
            'marked_video_number' => $marked_video_number,
            'non_marked_video_number' => $non_marked_video_number,
        ]);
    }


    public function singleAuditionRoundAssessmentResult($audition_id, $audition_round_info_id, $type)
    {
        $audition = Audition::find($audition_id);
        $auditionRoundInfo  = AuditionRoundInfo::find($audition_round_info_id);

        $assignJuries = AuditionAssignJury::with('juryGroup')->where([['audition_id', $audition->id]])->get();
        $assignJuriesOrderByGroup = $assignJuries->groupBy('group_id');
        $roundBasedAuditionUploadVideos = AuditionUploadVideo::where([['round_info_id', $audition_round_info_id], ['type', $type], ['audition_id', $audition_id], ['approval_status', 1]])->get();

        if (AuditionUploadVideo::where([['round_info_id', $audition_round_info_id], ['type', $type], ['jury_final_mark', null], ['audition_id', $audition_id], ['approval_status', 1]])->count() > 0) {
            $isAbleToMerge = true;
        } else {
            $isAbleToMerge = false;
        }

        $participants = AuditionParticipant::whereHas('videos', function ($query) use ($audition_round_info_id, $type) {
            $query->where([['round_info_id', $audition_round_info_id], ['type', $type]]);
        })->with(['videos' => function ($query) use ($audition_round_info_id, $type) {
            return $query->where([['round_info_id', $audition_round_info_id], ['type', $type]])->get();
        }, 'participant'])
            ->where([['audition_id', $audition_id]])
            ->get();
        $wildcardInfo = WildCard::where([['end_round_info_id', $audition_round_info_id], ['audition_id', $audition_id]])->first();

        return response()->json([
            'status' => 200,
            'audition' => $audition,
            'auditionRoundInfo' => $auditionRoundInfo,
            'assignJuriesOrderByGroup' => $assignJuriesOrderByGroup,
            'roundBasedAuditionUploadVideos' => $roundBasedAuditionUploadVideos,
            'participants' => $participants,
            'isAbleToMerge' => $isAbleToMerge,
            'wildcardInfo' => $wildcardInfo,
        ]);
    }
    public function singleAuditionRoundVideoMerge($audition_id, $audition_round_info_id, $type)
    {

        $auditionRoundInfo = AuditionRoundInfo::find($audition_round_info_id);
        $roundBasedAuditionUploadVideos = AuditionUploadVideo::where([['round_info_id', $audition_round_info_id], ['type', $type], ['jury_final_mark', null], ['audition_id', $audition_id], ['approval_status', 1]])->get();

        foreach ($roundBasedAuditionUploadVideos as $key => $roundBasedAuditionUploadVideo) {
            if ($roundBasedAuditionUploadVideo->group_a_jury_mark != null) {
                $roundBasedAuditionUploadVideo->jury_final_mark =  $roundBasedAuditionUploadVideo->group_a_jury_mark;
            } else {
                $max_mark =   max($roundBasedAuditionUploadVideo->group_b_jury_mark, $roundBasedAuditionUploadVideo->group_c_jury_mark);
                $roundBasedAuditionUploadVideo->jury_final_mark =  $max_mark;
            }
            $roundBasedAuditionUploadVideo->save();
        }

        $participants = AuditionParticipant::whereHas('videos', function ($query) use ($audition_round_info_id, $type) {
            $query->where([['round_info_id', $audition_round_info_id], ['type', $type]]);
        })->with(['videos' => function ($query) use ($audition_round_info_id, $type) {
            return $query->where([['round_info_id', $audition_round_info_id], ['type', $type]])->get();
        }, 'participant'])->where([['audition_id', $audition_id]])->get();

        foreach ($participants as $parentKey => $auditionParticipant) {
            $sum_of_final_mark = 0;
            foreach ($auditionParticipant->videos->where('type', $type) as $key => $video) {
                $sum_of_final_mark += $video->jury_final_mark == null ? 0 : $video->jury_final_mark;
            }
            if ($type == 'appeal') {
                $average = number_format(($sum_of_final_mark / $auditionRoundInfo->appeal_video_slot_num), 2);
            } else {
                $average = number_format(($sum_of_final_mark / $auditionRoundInfo->video_slot_num), 2);
            }

            $auditionRoundMarkTracking  = new AuditionRoundMarkTracking();
            $auditionRoundMarkTracking->user_id = $auditionParticipant->user_id;
            $auditionRoundMarkTracking->type = $type;
            $auditionRoundMarkTracking->round_info_id = $audition_round_info_id;
            $auditionRoundMarkTracking->audition_id = $audition_id;
            $auditionRoundMarkTracking->avg_mark = $average;
            $auditionRoundMarkTracking->save();
        }
        if ($type == "general") {
            $rejectedUserListGeneral = AuditionUploadVideo::selectRaw('user_id,count(approval_status) as totalRejected')->where([['audition_id', $audition_id], ['round_info_id', $audition_round_info_id], ['approval_status', 2], ['type', 'general']])->groupBy('user_id')->get('video');
            foreach ($rejectedUserListGeneral as $rejectedUser) {
                if ($rejectedUser->totalRejected == $auditionRoundInfo->video_slot_num) {
                    $auditionRoundMarkTracking  = new AuditionRoundMarkTracking();
                    $auditionRoundMarkTracking->user_id = $rejectedUser->user_id;
                    $auditionRoundMarkTracking->type = "rejected";
                    $auditionRoundMarkTracking->round_info_id = $audition_round_info_id;
                    $auditionRoundMarkTracking->audition_id = $audition_id;
                    $auditionRoundMarkTracking->audition_id = $audition_id;
                    $auditionRoundMarkTracking->result_message = "You are rejected";
                    $auditionRoundMarkTracking->avg_mark = 00;
                    $auditionRoundMarkTracking->save();
                }
            }
        }

        if ($type == "appeal") {
            $rejectedUserListAppeal = AuditionUploadVideo::selectRaw('user_id,count(approval_status) as totalRejected')->where([['audition_id', $audition_id], ['round_info_id', $audition_round_info_id], ['approval_status', 2], ['type', 'appeal']])->groupBy('user_id')->get('video');
            foreach ($rejectedUserListAppeal as $rejectedUser) {
                if ($rejectedUser->totalRejected == $auditionRoundInfo->appeal_video_slot_num) {
                    $auditionRoundMarkTracking  = new AuditionRoundMarkTracking();
                    $auditionRoundMarkTracking->user_id = $rejectedUser->user_id;
                    $auditionRoundMarkTracking->type = "appeal_rejected";
                    $auditionRoundMarkTracking->round_info_id = $audition_round_info_id;
                    $auditionRoundMarkTracking->audition_id = $audition_id;
                    $auditionRoundMarkTracking->audition_id = $audition_id;
                    $auditionRoundMarkTracking->result_message = "You are rejected";
                    $auditionRoundMarkTracking->avg_mark = 00;
                    $auditionRoundMarkTracking->save();
                }
            }
        }



        return response()->json([
            'status' => 200,
            'message' => 'Video mark merged Successfully',
        ]);
    }

    public function singleAuditionRoundVideoResultByPercentage($audition_id, $audition_round_info_id, $percentage_range, $type)
    {
        if ($type == "wildcard") {
            $wildcardInfo = WildCard::where('end_round_info_id', $audition_round_info_id)->first();
            $percentageWildcardMarkTrackings = LoveReact::selectRaw('participant_id, sum(react_num) as react_num')->groupBy('participant_id')->where([['round_info_id', $wildcardInfo->start_round_info_id], ['react_voting_type', $type], ['audition_id', $audition_id]])->get();

            $myArray = json_decode($percentageWildcardMarkTrackings);

            $percentegeWildcardMarking = array_filter(
                $myArray,
                function ($obj) use ($percentage_range) {
                    return $obj->react_num >= $percentage_range;
                }
            );
            return response()->json([
                'status' => 200,
                'message' => 'OK',
                'percentageWildcardMarkTrackings' =>  $percentegeWildcardMarking,
            ]);
        }

        $percentageBaseRoundMarkTrackings = AuditionRoundMarkTracking::where([['round_info_id', $audition_round_info_id], ['type', $type], ['audition_id', $audition_id], ['avg_mark', '>=', $percentage_range]])->get();
        return response()->json([
            'status' => 200,
            'message' => 'OK',
            'percentageBaseRoundMarkTrackings' => $percentageBaseRoundMarkTrackings,
        ]);
    }

    public function singleAuditionRoundVideoResultByFilterNumber($audition_id, $audition_round_info_id, $filter_number, $type)
    {

        if ($type == "wildcard") {
            $wildcardInfo = WildCard::where('end_round_info_id', $audition_round_info_id)->first();

            $filterNumberBaseRoundMarkTrackings = LoveReact::selectRaw('participant_id,sum(react_num) as total_react_num')->groupBy('participant_id')->where([['round_info_id', $wildcardInfo->start_round_info_id], ['react_voting_type', $type], ['audition_id', $audition_id]])->orderBy('total_react_num', 'DESC')->take($filter_number)->get();

            return response()->json([
                'status' => 200,
                'message' => 'OK',
                'filterNumberBaseRoundMarkTrackings' => $filterNumberBaseRoundMarkTrackings,
            ]);
        }
        $filterNumberBaseRoundMarkTrackings = AuditionRoundMarkTracking::where([['round_info_id', $audition_round_info_id], ['type', $type], ['audition_id', $audition_id]])->orderBy('avg_mark', 'DESC')->take($filter_number)->get();
        return response()->json([
            'status' => 200,
            'message' => 'OK',
            'filterNumberBaseRoundMarkTrackings' => $filterNumberBaseRoundMarkTrackings,
        ]);
    }

    public function singleAuditionInstruction($id)
    {
        $auditionJudgeInstruction = AuditionJudgeInstruction::find($id);

        return response()->json([
            'status' => 200,
            'auditionJudgeInstruction' => $auditionJudgeInstruction,
        ]);
    }

    public function storePromoInstruction(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'audition_id' => 'required',
            'instruction' => 'required|min:5',
            'image' => 'required|mimes:jpg,jpeg,png',
            'video' => 'required|mimes:mp4,mkv',
        ], [
            'audition_id.required' => 'Select a audition'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'validation_errors' => $validator->errors(),
            ]);
        } else {
            $instruction = new AuditionPromoInstruction();
            $instruction->audition_id = $request->audition_id;
            $instruction->instruction = $request->instruction;
            $instruction->send_to_manager = 1;
            try {
                if ($request->hasfile('image')) {
                    $image             = $request->image;
                    $image_folder_path       = 'uploads/images/auditions/instructions/';
                    $image_new_name    = Str::random(20) . '-' . now()->timestamp . '.' . $image->getClientOriginalExtension();
                    // save to server
                    $request->image->move($image_folder_path, $image_new_name);
                    $instruction->image = $image_folder_path . '/' . $image_new_name;
                }

                if ($request->hasfile('video')) {
                    $file             = $request->video;
                    $folder_path       = 'uploads/videos/auditions/instructions/';
                    $file_new_name    = Str::random(20) . '-' . now()->timestamp . '.' . $file->getClientOriginalExtension();
                    // save to server
                    $request->video->move($folder_path, $file_new_name);
                    $instruction->video = $folder_path . '/' . $file_new_name;
                }

                if ($request->hasfile('pdf')) {
                    $image             = $request->pdf;
                    $pdf_folder_path       = 'uploads/pdf/auditions/instructions/';
                    $pdf_new_name    = Str::random(20) . '-' . now()->timestamp . '.' . $image->getClientOriginalExtension();
                    // save to server
                    $request->pdf->move($pdf_folder_path, $pdf_new_name);
                    $instruction->document = $pdf_folder_path . '/' . $pdf_new_name;
                }

                $instruction->save();

                // if ($request->star_ids) {
                //     if (count($request->star_ids) > 0) {
                //         $instruction->send_to_judge = 1;
                //         $instruction->save();
                //         foreach ($request->star_ids as $key => $star) {
                //             $instruction_info = new AuditionPromoInstructionSendInfo();
                //             $instruction_info->audition_id = $request->audition_id;
                //             $instruction_info->audition_promo_ins_id = $instruction->id;
                //             $instruction_info->judge_id = $star;
                //             $instruction_info->instruction = $request->instruction;

                //             $instruction_info->image = $instruction->image;
                //             $instruction_info->video = $instruction->video;
                //             $instruction_info->document = $instruction->document;
                //             $instruction_info->save();
                //         }
                //     }
                // }


                return response()->json([
                    'status' => 200,
                    'message' => 'Audition Promo instruction submitted successfully !!',
                    'instruction' => $instruction,
                ]);
            } catch (\Exception $exception) {
                return response()->json([
                    'status' => 200,
                    'message' =>  $exception->getMessage(),
                ]);
            }
        }
    }



    public function superStarStorePromo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'audition_id' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'instruction' => 'required|min:5',
            'image' => 'required|mimes:jpg,jpeg,png',
            'video' => 'required|mimes:mp4,mkv',
            'star_ids' => 'required',
        ], [
            'star_ids.*' => 'Select at least one Star',
            'audition_id.required' => 'Select a audition'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'validation_errors' => $validator->errors(),
            ]);
        } else {
            $instruction = new AuditionPromoInstruction();
            $instruction->audition_id = $request->audition_id;
            $instruction->instruction = $request->instruction;
            $instruction->start_date = $request->start_date;
            $instruction->end_date = $request->end_date;
            try {
                if ($request->hasfile('image')) {
                    $image             = $request->image;
                    $image_folder_path       = 'uploads/images/auditions/instructions/';
                    $image_new_name    = Str::random(20) . '-' . now()->timestamp . '.' . $image->getClientOriginalExtension();
                    // save to server
                    $request->image->move($image_folder_path, $image_new_name);
                    $instruction->image = $image_folder_path . '/' . $image_new_name;
                }

                if ($request->hasfile('video')) {
                    $file             = $request->video;
                    $folder_path       = 'uploads/videos/auditions/instructions/';
                    $file_new_name    = Str::random(20) . '-' . now()->timestamp . '.' . $file->getClientOriginalExtension();
                    // save to server
                    $request->video->move($folder_path, $file_new_name);
                    $instruction->video = $folder_path . '/' . $file_new_name;
                }

                if ($request->hasfile('pdf')) {
                    $image             = $request->pdf;
                    $pdf_folder_path       = 'uploads/pdf/auditions/instructions/';
                    $pdf_new_name    = Str::random(20) . '-' . now()->timestamp . '.' . $image->getClientOriginalExtension();
                    // save to server
                    $request->pdf->move($pdf_folder_path, $pdf_new_name);
                    $instruction->document = $pdf_folder_path . '/' . $pdf_new_name;
                }

                if ($request->star_ids) {
                    if (count($request->star_ids) > 0) {
                        $instruction->send_to_judge = 1;
                        $instruction->save();
                        foreach ($request->star_ids as $key => $star) {
                            $instruction_info = new AuditionPromoInstructionSendInfo();
                            $instruction_info->audition_id = $request->audition_id;
                            $instruction_info->audition_promo_ins_id = $instruction->id;
                            $instruction_info->judge_id = $star;
                            $instruction_info->instruction = $request->instruction;

                            $instruction_info->image = $instruction->image;
                            $instruction_info->video = $instruction->video;
                            $instruction_info->document = $instruction->document;
                            $instruction_info->save();
                        }
                    }
                }

                return response()->json([
                    'status' => 200,
                    'message' => 'Audition Promo instruction submitted successfully !!',
                    'instruction' => $instruction,
                ]);
            } catch (\Exception $exception) {
                return response()->json([
                    'status' => 200,
                    'message' =>  $exception->getMessage(),
                ]);
            }
        }
    }





    // Promotional Video upload By Partha Ghose
    public function promotionalVideoStore(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'audition_id' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'instruction' => 'required|min:5',
            'description' => 'required|min:5',
            'image' => 'required|mimes:jpg,jpeg,png',
            'video' => 'required|mimes:mp4,mkv',
            'star_ids' => 'required',
        ], [
            'star_ids.*' => 'Select at least one Star',
            'audition_id.required' => 'Select a audition'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'validation_errors' => $validator->errors(),
            ]);
        } else {
            try {

                if ($request->hasfile('image')) {
                    $image             = $request->image;
                    $image_folder_path       = 'uploads/images/auditions/promotional/';
                    $image_new_name    = Str::random(20) . '-' . now()->timestamp . '.' . $image->getClientOriginalExtension();
                    // save to server
                    $request->image->move($image_folder_path, $image_new_name);
                    // $instruction_info->image = $image_folder_path . '/' . $image_new_name;
                }

                if ($request->hasfile('video')) {
                    $file             = $request->video;
                    $folder_path       = 'uploads/videos/auditions/promotional/';
                    $file_new_name    = Str::random(20) . '-' . now()->timestamp . '.' . $file->getClientOriginalExtension();
                    // save to server
                    $request->video->move($folder_path, $file_new_name);
                    // $instruction_info->video = $folder_path . '/' . $file_new_name;
                }

                if ($request->hasfile('pdf')) {
                    $image             = $request->pdf;
                    $pdf_folder_path       = 'uploads/pdf/auditions/promotional/';
                    $pdf_new_name    = Str::random(20) . '-' . now()->timestamp . '.' . $image->getClientOriginalExtension();
                    // save to server
                    $request->pdf->move($pdf_folder_path, $pdf_new_name);
                    // $instruction_info->document = $pdf_folder_path . '/' . $pdf_new_name;
                }




                if ($request->star_ids) {
                    if (count($request->star_ids) > 0) {
                        foreach ($request->star_ids as $key => $star) {
                            $instruction_info = new AuditionPromoInstructionSendInfo();
                            $instruction_info->audition_id = $request->audition_id;
                            $instruction_info->audition_admin_id = auth('sanctum')->user()->id;
                            $instruction_info->judge_id = $star;
                            $instruction_info->instruction = $request->instruction;
                            $instruction_info->description = $request->description;

                            $instruction_info->start_date = $request->start_date;
                            $instruction_info->end_date = $request->end_date;


                            // $instruction_info->banner = $image_folder_path . $image_new_name;
                            // $instruction_info->video = $video_folder_path . $video_new_name;
                            // $instruction_info->document = $video_folder_path . $pdf_new_name;



                            $instruction_info->image = $image_folder_path . '/' . $image_new_name;
                            $instruction_info->video = $folder_path . '/' . $file_new_name;
                            $instruction_info->document = $pdf_folder_path . '/' . $pdf_new_name;

                            $instruction_info->status = 0;
                            $instruction_info->save();
                        }
                    }
                }

                return response()->json([
                    'status' => 200,
                    'message' => 'Audition Promotional submitted successfully !!',
                ]);
            } catch (\Exception $exception) {
                return response()->json([
                    'status' => 200,
                    'message' =>  $exception->getMessage(),
                ]);
            }
        }
    }
    public function superstarPromotionalVideoStore(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'instruction' => 'required|min:5',
            'image' => 'required|mimes:jpg,jpeg,png',
            'video' => 'required|mimes:mp4,mkv',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'validation_errors' => $validator->errors(),
            ]);
        } else {
            try {

                if ($request->hasfile('image')) {
                    $image             = $request->image;
                    $image_folder_path       = 'uploads/images/auditions/promotional/';
                    $image_new_name    = Str::random(20) . '-' . now()->timestamp . '.' . $image->getClientOriginalExtension();
                    // save to server
                    $request->image->move($image_folder_path, $image_new_name);
                    // $instruction_info->image = $image_folder_path . '/' . $image_new_name;
                }

                if ($request->hasfile('video')) {
                    $file             = $request->video;
                    $folder_path       = 'uploads/videos/auditions/promotional/';
                    $file_new_name    = Str::random(20) . '-' . now()->timestamp . '.' . $file->getClientOriginalExtension();
                    // save to server
                    $request->video->move($folder_path, $file_new_name);
                    // $instruction_info->video = $folder_path . '/' . $file_new_name;
                }

                if ($request->hasfile('pdf')) {
                    $image             = $request->pdf;
                    $pdf_folder_path       = 'uploads/pdf/auditions/promotional/';
                    $pdf_new_name    = Str::random(20) . '-' . now()->timestamp . '.' . $image->getClientOriginalExtension();
                    // save to server
                    $request->pdf->move($pdf_folder_path, $pdf_new_name);
                    // $instruction_info->document = $pdf_folder_path . '/' . $pdf_new_name;
                }



                $audition_admin = Audition::find($request->audition_id);

                $instruction_info = new AuditionPromoInstructionSendInfo();
                $instruction_info->judge_id = auth('sanctum')->user()->id;
                $instruction_info->audition_id = $request->audition_id;
                $instruction_info->audition_admin_id = $audition_admin->audition_admin_id;
                $instruction_info->instruction = $request->instruction;

                $instruction_info->image = $image_folder_path . '/' . $image_new_name;
                $instruction_info->video = $folder_path . '/' . $file_new_name;
                $instruction_info->document = $pdf_folder_path . '/' . $pdf_new_name;
                $instruction_info->status = 3;

                $instruction_info->save();


                return response()->json([
                    'status' => 200,
                    'message' => 'Superstar Audition Promotional submitted successfully !!',
                ]);
            } catch (\Exception $exception) {
                return response()->json([
                    'status' => 200,
                    'message' =>  $exception->getMessage(),
                ]);
            }
        }
    }

    // Pending Auditions
    public function promotionalList()
    {
        $event = AuditionPromoInstructionSendInfo::with('audition')->where([['audition_admin_id', auth('sanctum')->user()->id], ['status', 0]])->latest()->get();
        return response()->json([
            'status' => 200,
            'event' => $event,
        ]);
    }

    public function judgePromotionalList()
    {
        $event = AuditionPromoInstructionSendInfo::with('audition')->where([['judge_id', auth('sanctum')->user()->id], ['status', 3]])->latest()->get();
        return response()->json([
            'status' => 200,
            'event' => $event,
        ]);
    }
    public function acceptedJudgePromotionalList()
    {
        $event = AuditionPromoInstructionSendInfo::with('audition')->where([['judge_id', auth('sanctum')->user()->id], ['status', '!=', 3]])->latest()->get();
        return response()->json([
            'status' => 200,
            'event' => $event,
        ]);
    }
    public function acceptedPromotionalList()
    {
        $event = AuditionPromoInstructionSendInfo::with('audition')->where('audition_admin_id', auth('sanctum')->user()->id)->where('status', 3)->latest()->get();

        return response()->json([
            'status' => 200,
            'event' => $event,
        ]);
    }

    public function judgePromotionalView($id)
    {
        $event = AuditionPromoInstructionSendInfo::find($id);

        return response()->json([
            'status' => 200,
            'eventView' => $event,
        ]);
    }

    public function judgePromotionalVideoCheck($auditionId)
    {
        $event = AuditionPromoInstructionSendInfo::where('audition_id', $auditionId)->where('judge_id', auth('sanctum')->user()->id)->where('status', 3)->get();

        if (count($event)) {
            return response()->json([
                'status' => 200,
            ]);
        } else {
            return response()->json([
                'status' => 600,
            ]);
        }
    }

    public function judgePromotionalViewAccepted($id)
    {
        $event = AuditionPromoInstructionSendInfo::find($id);
        $event->status = 1;
        $event->save();

        return response()->json([
            'status' => 200,
            'message' => 'Audition Promotional Video Accepted !!',
        ]);
    }

    public function judgePromotionalViewDecline($id)
    {
        $event = AuditionPromoInstructionSendInfo::find($id);
        $event->status = 2;
        $event->save();

        return response()->json([
            'status' => 200,
            'message' => 'Audition Promotional Video Declined !!',
        ]);
    }

    public function auditionJudgePromotionalView($id)
    {
        $event = AuditionPromoInstructionSendInfo::find($id);

        return response()->json([
            'status' => 200,
            'eventView' => $event,
        ]);
    }


    public function promoInstrucction($audition_id)
    {
        $event = Audition::find($audition_id);
        $promo_instruction = AuditionPromoInstruction::where([['audition_id', $audition_id], ['send_to_manager', 1]])->last();
        return response()->json([
            'status' => 200,
            'event' => $event,
            'promo_instruction' => $promo_instruction,
        ]);
    }

    public function updatePromoInstruction(Request $request)
    {
        // return $request->all();
        $validator = Validator::make($request->all(), [
            'instruction' => 'required|min:5',
            'image' => 'required|mimes:jpg,jpeg,png',
            'video' => 'required|mimes:mp4,mkv',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'validation_errors' => $validator->errors(),
            ]);
        } else {
            $instruction = AuditionPromoInstruction::find($request->audition_promo_instruction_id);
            $instruction->audition_id = $request->audition_id;
            $instruction->instruction = $request->instruction;

            if ($request->hasfile('image')) {
                $image             = $request->image;
                $image_folder_path       = 'uploads/images/auditions/instructions/';
                $image_new_name    = Str::random(20) . '-' . now()->timestamp . '.' . $image->getClientOriginalExtension();
                // save to server
                $request->image->move($image_folder_path, $image_new_name);
                $instruction->image = $image_folder_path . '/' . $image_new_name;
            }

            if ($request->hasfile('video')) {
                $file             = $request->video;
                $folder_path       = 'uploads/videos/auditions/instructions/';
                $file_new_name    = Str::random(20) . '-' . now()->timestamp . '.' . $file->getClientOriginalExtension();
                // save to server
                $request->video->move($folder_path, $file_new_name);
                $instruction->video = $folder_path . '/' . $file_new_name;
            }
            $instruction->send_to_manager = 1;
            $instruction->save();

            return response()->json([
                'status' => 200,
                'message' => 'Promo Instruction Updated!',
            ]);
        }
    }
    public function storeRoundInstruction(Request $request)
    {
        // return $request->all();
        $old_instruction = AuditionRoundInstruction::where([['audition_id', $request->audition_id], ['round_info_id', $request->round_info_id]])->first();

        if (isset($old_instruction->id)) {
            $validator = Validator::make($request->all(), [
                'round_info_id' => 'required|exists:audition_round_infos,id',
                'instruction' => 'required|min:10',
            ], [
                'round_info_id.required' => 'Please Select Round Number',
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'round_info_id' => 'required|exists:audition_round_infos,id',
                'instruction' => 'required|min:10',
                'image' => 'required|mimes:jpg,jpeg,png',
                'video' => 'required|mimes:mp4,mkv',
            ], [
                'round_info_id.required' => 'Please Select Round Number',
            ]);
        }

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'validation_errors' => $validator->errors(),
            ]);
        } else {

            $auditionRoundInfo                         = AuditionRoundInfo::find($request->round_info_id);
            $auditionRoundInfo->video_duration         = $request->video_time_duration;
            $auditionRoundInfo->video_slot_num         = $request->video_slot;
            $auditionRoundInfo->appeal_video_duration  = $request->appeal_video_time_duration;
            $auditionRoundInfo->appeal_video_slot_num  = $request->appeal_video_slot_num;
            $auditionRoundInfo->appeal_fee  = $request->appeal_fee;
            $auditionRoundInfo->status  = 1;
            $auditionRoundInfo->save();

            if (isset($old_instruction->id)) {
                $instruction = $old_instruction;
            } else {
                $instruction = new AuditionRoundInstruction();
            }

            $instruction->round_info_id = $request->round_info_id;
            $instruction->audition_id = $request->audition_id;
            $instruction->instruction = $request->instruction;
            // $instruction->round_fee = $request->round_fee;
            $instruction->appeal_fee = $request->appeal_fee;

            try {
                if ($request->hasfile('image')) {
                    $image             = $request->image;
                    $image_folder_path       = 'uploads/images/auditions/round/instructions/';
                    $image_new_name    = Str::random(20) . '-' . now()->timestamp . '.' . $image->getClientOriginalExtension();
                    // save to server
                    $request->image->move($image_folder_path, $image_new_name);
                    $instruction->image = $image_folder_path . '/' . $image_new_name;
                }

                if ($request->hasfile('video')) {
                    $file             = $request->video;
                    $folder_path       = 'uploads/videos/auditions/round/instructions/';
                    $file_new_name    = Str::random(20) . '-' . now()->timestamp . '.' . $file->getClientOriginalExtension();
                    // save to server
                    $request->video->move($folder_path, $file_new_name);
                    $instruction->video = $folder_path . '/' . $file_new_name;
                }

                if ($request->hasfile('pdf')) {
                    $image             = $request->pdf;
                    $pdf_folder_path       = 'uploads/pdf/auditions/round/instructions/';

                    $pdf_new_name    = Str::random(20) . '-' . now()->timestamp . '.' . $image->getClientOriginalExtension();
                    // save to server
                    $request->pdf->move($pdf_folder_path, $pdf_new_name);
                    $instruction->document = $pdf_folder_path . '/' . $pdf_new_name;
                }

                $instruction->send_to_manager = 1;
                $instruction->save();


                Audition::where('id', $request->audition_id)->update(['active_round_info_id' => $request->round_info_id]);


                return response()->json([
                    'status' => 200,
                    'message' => 'Audition Round Instruction submitted successfully !!',

                ]);
            } catch (\Exception $exception) {
                return response()->json([
                    'status' => 200,
                    'message' =>  $exception->getMessage(),
                ]);
            }
        }
    }

    public function updateRoundInstruction(Request $request)
    {

        $old_instruction = AuditionRoundInstruction::where([['audition_id', $request->audition_id], ['round_info_id', $request->round_info_id]])->first();

        if (isset($old_instruction->id)) {
            $validator = Validator::make($request->all(), [
                'round_info_id' => 'required',
                'instruction' => 'required|min:5',
            ], [
                'round_info_id.required' => 'Please Select Round Number',
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'round_info_id' => 'required',
                'instruction' => 'required|min:5',
                'image' => 'required|mimes:jpg,jpeg,png',
                'video' => 'required|mimes:mp4,mkv',
                'pdf' => 'required|mimes:pdf',
            ], [
                'round_info_id.required' => 'Please Select Round Number',
            ]);
        }


        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'validation_errors' => $validator->errors(),
            ]);
        } else {

            if (isset($old_instruction->id)) {
                $instruction = $old_instruction;
            } else {
                $instruction = new AuditionRoundInstruction();
            }

            $instruction->round_info_id = $request->round_info_id;
            $instruction->audition_id = $request->audition_id;
            $instruction->instruction = $request->instruction;
            // $instruction->round_fee = $request->round_fee;
            $instruction->appeal_fee = $request->appeal_fee;
            $instruction->submission_end_date = Carbon::parse($request->submission_date);

            try {
                if ($request->hasfile('image')) {
                    // fileDelete($instruction->image);
                    $image             = $request->image;
                    $image_folder_path       = 'uploads/images/auditions/round/instructions/';
                    $image_new_name    = Str::random(20) . '-' . now()->timestamp . '.' . $image->getClientOriginalExtension();
                    // save to server
                    $request->image->move($image_folder_path, $image_new_name);
                    $instruction->image = $image_folder_path . '/' . $image_new_name;
                }

                if ($request->hasfile('video')) {
                    // fileDelete($instruction->video);
                    $file             = $request->video;
                    $folder_path       = 'uploads/videos/auditions/round/instructions/';
                    $file_new_name    = Str::random(20) . '-' . now()->timestamp . '.' . $file->getClientOriginalExtension();
                    // save to server
                    $request->video->move($folder_path, $file_new_name);
                    $instruction->video = $folder_path . '/' . $file_new_name;
                }

                if ($request->hasfile('pdf')) {
                    // fileDelete($instruction->pdf);
                    $image             = $request->pdf;
                    $pdf_folder_path       = 'uploads/pdf/auditions/round/instructions/';
                    $pdf_new_name    = Str::random(20) . '-' . now()->timestamp . '.' . $image->getClientOriginalExtension();
                    // save to server
                    $request->pdf->move($pdf_folder_path, $pdf_new_name);
                    $instruction->document = $pdf_folder_path . '/' . $pdf_new_name;
                }
                $instruction->send_to_manager = 1;
                $instruction->save();

                return response()->json([
                    'status' => 200,
                    'message' => 'Round Instruction Send Manager Admin successfully !!',
                ]);
            } catch (\Exception $exception) {
                return response()->json([
                    'status' => 200,
                    'message' =>  $exception->getMessage(),
                ]);
            }
        }
    }


    public function getRoundInstruction($audition_id, $round_info_id)
    {
        $auditon_round_instruction = AuditionRoundInstruction::where([['audition_id', $audition_id], ['round_info_id', $round_info_id]])->first();

        $audition = Audition::find($audition_id);
        return response()->json([
            'status' => 200,
            'auditon_round_instruction' => $auditon_round_instruction,
            'event' => $audition,
        ]);
    }

    public function sendDummyInstructionToJudges(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
            'time_boundary' => 'required',
            'banner' => 'required',
            'video' => 'required',
            'number_of_videos' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'validation_errors' => $validator->errors(),
            ]);
        } else {
            $audition = Audition::find($request->audition_id);
            $auditionRoundRule = AuditionRoundRule::find($request->audition_round_id);

            try {
                if ($request->hasfile('banner')) {
                    $image             = $request->banner;
                    $image_folder_path       = 'uploads/images/auditions/';
                    $image_new_name    = Str::random(20) . '-' . now()->timestamp . '.' . $image->getClientOriginalExtension();
                    // save to server
                    $request->banner->move($image_folder_path, $image_new_name);
                }
                if ($request->hasfile('video')) {
                    $file             = $request->video;
                    $folder_path       = 'uploads/videos/auditions/';
                    $file_new_name    = Str::random(20) . '-' . now()->timestamp . '.' . $file->getClientOriginalExtension();
                    // save to server
                    $request->video->move($folder_path, $file_new_name);
                }
                foreach ($audition->assignedJudges as $assignedJudge) {
                    $auditionJudgeInstruction               = new AuditionJudgeInstruction();
                    $auditionJudgeInstruction->audition_id  =  $audition->id;
                    $auditionJudgeInstruction->star_id      =  $assignedJudge->judge_id;
                    $auditionJudgeInstruction->round_id     =  $auditionRoundRule->id;
                    $auditionJudgeInstruction->title        =  $request->title;
                    $auditionJudgeInstruction->status       =  0;
                    $auditionJudgeInstruction->description  =  $request->description;
                    $auditionJudgeInstruction->time_boundary =  Carbon::parse($request->time_boundary);

                    $auditionJudgeInstruction->banner = $image_folder_path . $image_new_name;
                    $auditionJudgeInstruction->video = $folder_path . $file_new_name;

                    $auditionJudgeInstruction->save();
                }

                if ($audition->judgeInstructions->where('round_id', $audition->audition_round_rules_id)->count() > 0) {
                    $is_already_submitted = true;
                    if ($audition->judgeInstructions->where('round_id', $audition->audition_round_rules_id)->where('status', 0)->count() > 0) {
                        $is_all_star_responsed = false;
                        if ($audition->judgeInstructions->where('round_id', $audition->audition_round_rules_id)->where('status', 1)->count() > 0) {
                            $is_any_star_responsed  = true;
                        } else {
                            $is_any_star_responsed  = false;
                        }
                    } else {
                        $is_all_star_responsed = true;
                        $is_any_star_responsed  = true;
                    }
                } else {
                    $is_already_submitted = false;
                    $is_all_star_responsed = false;
                    $is_any_star_responsed = false;
                }

                return response()->json([
                    'status' => 200,
                    'message' => 'Audition instruction submitted successfully !!',
                    'audition_judge_instructions' => $audition->judgeInstructions->where('round_id', $audition->audition_round_rules_id),
                    'is_already_submitted' => $is_already_submitted,
                    'is_all_star_responsed' => $is_all_star_responsed,
                    'is_any_star_responsed' => $is_any_star_responsed,
                ]);
            } catch (\Exception $exception) {
                return response()->json([
                    'status' => 200,
                    'message' =>  $exception->getMessage(),
                ]);
            }
        }
    }



    public function count()
    {
        $live = Audition::where([['audition_admin_id', auth('sanctum')->user()->id], ['status', 3]])->count();
        $pending = Audition::where([['audition_admin_id', auth('sanctum')->user()->id], ['status', 0]])->count();
        $request_approval_pending = Audition::where([['audition_admin_id', auth('sanctum')->user()->id], ['status', 1]])->count();

        return response()->json([
            'status' => 200,
            'live' => $live,
            'pending' => $pending,
            'request_approval_pending' => $request_approval_pending,
        ]);
    }

    // Pending Auditions
    public function pending()
    {
        $event = Audition::where([['audition_admin_id', auth('sanctum')->user()->id], ['status', 0]])->get();
        return response()->json([
            'status' => 200,
            'event' => $event,
        ]);
    }

    // Pending Auditions
    public function request()
    {
        $event = Audition::where([['audition_admin_id', auth('sanctum')->user()->id], ['status', 1]])->get();
        return response()->json([
            'status' => 200,
            'event' => $event,
        ]);
    }

    // assigned Audition
    public function assignedAudition()
    {
        $event = Audition::where([['audition_admin_id', auth('sanctum')->user()->id]])->get();
        return response()->json([
            'status' => 200,
            'event' => $event,
        ]);
    }

    // Live Auditions
    public function live()
    {
        // return 'Audition::all()';

        $lives = Audition::where([['audition_admin_id', auth('sanctum')->user()->id], ['status', 3]])->get();
        return response()->json([
            'status' => 200,
            'lives' => $lives,
        ]);
    }
    // Live Auditions
    public function onlineRound()
    {
        $audition = Audition::where([['audition_admin_id', auth('sanctum')->user()->id], ['status', 3]])->first();
        $activeRoundInfoId = $audition->active_round_info_id;

        $lives = Audition::with('activeRoundInfo')->whereHas('activeRoundInfo', function ($q) use ($activeRoundInfoId) {
            $q->where('round_type', 1)->with('markTrackings', function ($q) use ($activeRoundInfoId) {
                $q->with('user')->where([['round_info_id', $activeRoundInfoId], ['winning_status', 1]]);
            });
        })->where([['audition_admin_id', auth('sanctum')->user()->id], ['status', 3]])->first();
        return response()->json([
            'status' => 200,
            'lives' => $lives,
        ]);
    }

    public function getRoundInstructionJudges($audition_id, $round_info_id)
    {

        $round_instruction = AuditionRoundInstruction::where([['audition_id', $audition_id], ['round_info_id', $round_info_id]])->first();

        $round_ins_send_info = AuditionRoundInstructionSendInfo::where([['audition_id', $audition_id], ['round_info_id', $round_info_id]])->get();


        return response()->json([
            'status' => 200,
            'round_instruction' => $round_instruction,
            'round_ins_send_info' => $round_ins_send_info,
        ]);
    }


    public function totalJudgeApproval($slug)
    {
        $audition = Audition::where('slug', $slug)->first();
        $total_judge = AuditionAssignJudge::where('audition_id', $audition->id)->count();
        $total_judge_approval = AuditionAssignJudge::where([['audition_id', $audition->id], ['approved_by_judge', 1]])->count();

        return response()->json([
            'status' => 200,
            'approve_status' => $total_judge == $total_judge_approval,
        ]);
    }

    public function getAuditionById($id)
    {

        $event = Audition::with(['assignedJudges', 'participant', 'promoInstruction'])->where('id', $id)->first();

        return response()->json([
            'status' => 200,
            'event' => $event,
        ]);
    }

    public function getAudition($slug)
    {

        $event = Audition::with(['assignedJudges', 'participant', 'promoInstruction'])->where('slug', $slug)->first();

        $ids = $event->assignedJuries->unique('group_id')->pluck('group_id');
        $juryGroups =  JuryGroup::whereIn('id', $ids)->get();

        $promo_instruction_infos = AuditionPromoInstructionSendInfo::with('judge')->where('audition_id', $event->id)->get();

        return response()->json([
            'status' => 200,
            'event' => $event,
            'juryGroups' => $juryGroups,
            'promo_instruction_infos' => $promo_instruction_infos,
        ]);
    }

    // Star Admin Adution Start


    public function getAdminAuditions()
    {
        $star = User::where('user_type', 'star')->where('parent_user', auth('sanctum')->user()->id)->first();

        $liveAuditions = Audition::with('judge')
            ->whereHas('judge', function ($q) use ($star) {
                $q->where([['judge_id', $star->id], ['approved_by_judge', 1]]);
            })->get();

        $pendingAuditions = Audition::with('judge')
            ->whereHas('judge', function ($q) use ($star) {
                $q->where([['judge_id', $star->id], ['approved_by_judge', 0]]);
            })->get();

        return response()->json([
            'status' => 200,
            'pending_auditions' => $pendingAuditions,
            'liveAuditions' => $liveAuditions,
            'liveCount' => $pendingAuditions->count(),
            'pendingCount' => $liveAuditions->count(),
        ]);
    }



    public function starAdminDetailsAudition($id)
    {
        $event = Audition::find($id);
        $judges = AuditionAssignJudge::where('audition_id', $id)->get();
        $juries = AuditionAssignJury::where('audition_id', $id)->get();
        $approve_status = AuditionAssignJudge::where('judge_admin_id', auth('sanctum')->user()->id)->first();
        return response()->json([
            'status' => 200,
            'event' => $event,
            'judges' => $judges,
            'juries' => $juries,
            'approve_status' => $approve_status,
        ]);
    }

    // Star Admin Adution End
    public function getAuditionVideos($audition_id)
    {
        $audition_videos =  AuditionParticipant::where('audition_id', $audition_id)->where('filter_status', 0)->get();

        return response()->json([
            'status' => 200,
            'audition_videos' => $audition_videos,
        ]);
    }


    public function submitFilterVideo(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'audition_id' => 'required',
            'participant_id' => 'required',
        ]);


        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'validation_errors' => $validator->errors(),
            ]);
        } else {

            $participant = AuditionParticipant::find($request->participant_id);
            $participant->filter_status = 1;
            $participant->admin_id = auth('sanctum')->user()->id;

            if ($request->accept == 1) {
                $participant->accept_status = 1;
            }

            if ($request->reject == 1) {
                $participant->accept_status = 0;
                $participant->comments = $request->comments;
            }

            try {

                $participant->save();

                return response()->json([
                    'status' => 200,
                    'filter' => $participant,
                    'message' => 'Video Filtered successfully Done'
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

    public function acceptedVideo($audition_id)
    {
        $accepted_videos =  AuditionParticipant::where('audition_id', $audition_id)->where('accept_status', 1)->where('filter_status', 1)->get();

        return response()->json([
            'status' => 200,
            'accepted_videos' => $accepted_videos,
        ]);
    }

    public function rejectedVideo($audition_id)
    {
        $rejected_videos =  AuditionParticipant::where('audition_id', $audition_id)->where('accept_status', 0)->where('filter_status', 1)->get();

        return response()->json([
            'status' => 200,
            'rejected_videos' => $rejected_videos,
        ]);
    }

    public function videoSendManagerAdmin(Request $request)
    {

        AuditionParticipant::where([['audition_id', $request->audition_id], ['accept_status', 1], ['filter_status', 1], ['jury_id', null]])->update([
            'send_manager_admin' => $request->send_manager_admin,
        ]);

        return response()->json([
            'status' => 200,
            'send_manager_admin' => true,
            'message' => 'Send to Manager Admin Successfully',
        ]);
    }

    public function getJuryVideos()
    {

        $audition_videos =  AuditionParticipant::with(['auditions'])->where([['jury_id', Auth::user()->id], ['marks_id', null]])->get();

        $auditionInfo =  AuditionParticipant::with(['auditions'])->where([['jury_id', Auth::user()->id]])->first();

        return response()->json([
            'status' => 200,
            'audition_videos' => $audition_videos,
            'auditionInfo' => $auditionInfo,
        ]);
    }

    public function participantList($id)
    {
        $participantList = AuditionParticipant::with(['audition', 'participant'])->where('audition_id', $id)->latest()->get();

        return response()->json([

            'status' => 200,
            'participantList' => $participantList

        ]);
    }


    // Star Marking Auditions


    public function getStarVideos($id)
    {

        $audition_videos =  AuditionParticipant::with('auditions')->doesntHave('judgeMark')->where('audition_id', $id)->get();

        $auditionInfo =  Audition::where('id', $id)->first();

        return response()->json([
            'status' => 200,
            'audition_videos' => $audition_videos,
            'auditionInfo' => $auditionInfo,
        ]);
    }

    public function saveRoundInstruction(Request $request)
    {



        $validator = Validator::make($request->all(), [
            // 'title' => 'required',
            // 'description' => 'required',
            // 'star_ids' => 'required',
        ]);


        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'validation_errors' => $validator->errors(),
            ]);
        } else {
            $audition = AuditionRoundRule::find($request->audition_round_rule_id);
            $audition->title = $request->title;
            $audition->description = $request->description;
            $audition->uploade_date = $request->uploade_date;
            $audition->status = 1;

            if ($request->hasfile('banner')) {

                $destination = $audition->banner;

                if (File::exists($destination)) {
                    File::delete($destination);
                }
                $file = $request->file('banner');
                $extension = $file->getClientOriginalExtension();
                $filename = 'uploads/images/auditions/instructions/' . time() . '.' . $extension;
                Image::make($file)->resize(900, 400)->save($filename, 50);

                $audition->banner = $filename;
            }

            if ($request->hasFile('video')) {
                if ($audition->video != null && file_exists($audition->video)) {
                    unlink($audition->video);
                }
                $file        = $request->file('video');
                $path        = 'uploads/videos/auditions/instructions';
                $file_name   = time() . rand('0000', '9999') . '.' . $file->getClientOriginalName();
                $file->move($path, $file_name);
                $audition->video = $path . '/' . $file_name;
            }

            $audition->save();

            return response()->json([
                'status' => 200,
                'message' => 'Audition Instruction Send to Manager Admin successfully'
            ]);
        }
    }

    public function group_juries($audition_id, $group_id)
    {

        $juries = AuditionAssignJury::where([['audition_id', $audition_id], ['group_id', $group_id]])->get();

        return response()->json([
            'status' => 200,
            'juries' => $juries,
        ]);
    }



    public function getRoundInfo($audition_id, $round_info_id, $type)
    {

        $round_info = AuditionRoundInfo::find($round_info_id);

        $assignJuries = AuditionAssignJury::with('juryGroup')->whereHas('juryGroup', function ($q) {
            $q->where('is_primary', false);
        })->where('audition_id', $audition_id)->get();

        $alreadyAssignedRanCount = AuditionUploadVideo::where([['round_info_id', $round_info_id], ['type', $type], ['audition_id', $audition_id], ['approval_status', 1], ['group_a_ran_jury_id', '!=', null]])->count();

        $alreadyAssignedPerCount = AuditionUploadVideo::where([['round_info_id', $round_info_id], ['type', $type], ['audition_id', $audition_id], ['approval_status', 1], ['group_a_per_jury_id', '!=', null]])->count();

        $isVideoAlreadyAssignedRan = $alreadyAssignedRanCount > 0 ? true : false;
        $isVideoAlreadyAssignedPer = $alreadyAssignedPerCount > 0 ? true : false;


        $assignJuriesOrderByGroup = $assignJuries->groupBy('group_id');

        $mainJury = AuditionAssignJury::with('juryGroup')->whereHas('juryGroup', function ($q) {
            $q->where('is_primary', true);
        })->where('audition_id', $audition_id)->get();

        if ($type == "appeal") {
            $appealUser = AuditionRoundAppealRegistration::where([['round_info_id', $round_info_id], ['audition_id', $audition_id]])->pluck('user_id');

            $group_b_videos = AuditionParticipant::with(['videos' => function ($query) use ($round_info_id, $type) {
                return $query->where([['round_info_id', $round_info_id], ['type', $type], ['group_b_jury_id', '!=', null]])->get();
            }, 'participant'])->where([['audition_id', $audition_id]])->whereIn('user_id',    $appealUser)->get();

            $group_c_videos = AuditionParticipant::with(['videos' => function ($query) use ($round_info_id, $type) {
                return $query->where([['round_info_id', $round_info_id], ['type', $type], ['group_c_jury_id', '!=', null]])->get();
            }, 'participant'])->where([['audition_id', $audition_id]])->whereIn('user_id',    $appealUser)->get();
        } else {
            $group_b_videos = AuditionParticipant::with(['videos' => function ($query) use ($round_info_id, $type) {
                return $query->where([['round_info_id', $round_info_id], ['type', $type], ['group_b_jury_id', '!=', null]])->get();
            }, 'participant'])->where([['audition_id', $audition_id]])->get();

            $group_c_videos = AuditionParticipant::with(['videos' => function ($query) use ($round_info_id, $type) {
                return $query->where([['round_info_id', $round_info_id], ['type', $type], ['group_c_jury_id', '!=', null]])->get();
            }, 'participant'])->where([['audition_id', $audition_id]])->get();
        }

        return response()->json([
            'status' => 200,
            'round_info' => $round_info,
            'group_b_videos' => $group_b_videos,
            'group_c_videos' => $group_c_videos,
            'juriesByGroup' => $assignJuriesOrderByGroup,
            'mainJury' => $mainJury,
            'isVideoAlreadyAssignedRan' => $isVideoAlreadyAssignedRan,
            'isVideoAlreadyAssignedPer' => $isVideoAlreadyAssignedPer,
        ]);
    }

    public function round_videos($round_info_id)
    {

        $videos = AuditionUploadVideo::where([['type', 'general'], ['round_info_id', $round_info_id], ['approval_status', 0]])->get();
        $selectedVideos = AuditionUploadVideo::where([['type', 'general'], ['round_info_id', $round_info_id], ['approval_status', 1]])->get();
        $rejectedVideos = AuditionUploadVideo::where([['type', 'general'], ['round_info_id', $round_info_id], ['approval_status', 2]])->get();

        return response()->json([
            'status' => 200,
            'videos' => $videos,
            'selectedVideos' => $selectedVideos,
            'rejectedVideos' => $rejectedVideos,
        ]);
    }

    public function round_appeal_videos($round_info_id)
    {

        $videos = AuditionUploadVideo::where([['type', 'appeal'], ['round_info_id', $round_info_id], ['approval_status', 0]])->get();
        $selectedVideos = AuditionUploadVideo::where([['type', 'appeal'], ['round_info_id', $round_info_id], ['approval_status', 1]])->get();
        $rejectedVideos = AuditionUploadVideo::where([['type', 'appeal'], ['round_info_id', $round_info_id], ['approval_status', 2]])->get();

        return response()->json([
            'status' => 200,
            'videos' => $videos,
            'selectedVideos' => $selectedVideos,
            'rejectedVideos' => $rejectedVideos,
        ]);
    }

    public function round_videos_set_approved(Request $req, $id)
    {

        $video = AuditionUploadVideo::find($id);
        $video->approval_status = 1;
        $video->comment = $req->comment;
        $video->save();

        return response()->json([
            'status' => 200,
        ]);
    }

    public function round_videos_set_reject(Request $req, $id)
    {

        $video = AuditionUploadVideo::find($id);
        $video->approval_status = 2;
        $video->comment = $req->comment;
        $video->save();

        return response()->json([
            'status' => 200,
        ]);
    }

    public function getRandomForJury($audition_id, $round_info_id, $value, $type)
    {
        $random_videos = AuditionUploadVideo::where([['audition_id', $audition_id], ['round_info_id', $round_info_id], ['type', $type], ['approval_status', 1],  ['group_b_jury_mark', '!=', null], ['group_c_jury_mark', '!=', null], ['group_a_per_jury_id', null]])->inRandomOrder()->limit($value)->get();

        return response()->json([
            'status' => 200,
            'whice' => 'r',
            'random_videos' => $random_videos,
        ]);
    }

    public function getPercentageVideoForJury($audition_id, $round_info_id, $value, $type)
    {

        $B_C_videos = AuditionUploadVideo::where([['audition_id', $audition_id], ['round_info_id', $round_info_id], ['approval_status', 1],   ['type', $type], ['group_b_jury_mark', '!=', null], ['group_c_jury_mark', '!=', null]])->get();

        $videoIds = [];
        foreach ($B_C_videos as $key => $video) {
            if (
                $video->group_b_jury_mark > $video->group_c_jury_mark &&
                ($video->group_b_jury_mark - $video->group_c_jury_mark >= $value)
            ) {
                array_push($videoIds, $video->id);
            }
            if (
                $video->group_c_jury_mark > $video->group_b_jury_mark &&
                ($video->group_c_jury_mark - $video->group_b_jury_mark >= $value)
            ) {
                array_push($videoIds, $video->id);
            }
        }

        $percentage_videos = AuditionUploadVideo::whereIn('id', $videoIds)->where([['group_a_ran_jury_id', null],  ['type', $type],])->get();

        return response()->json([
            'status' => 200,
            'whice' => 'p',
            'percentage_videos' => $percentage_videos,
        ]);
    }

    public function assignMainJuries(Request $request)
    {
        try {
            foreach ($request->juries as $key => $jury_id) {
                AuditionUploadVideo::where([['group_a_ran_jury_id', null], ['audition_id', $request->audition_id], ['type', $request->type], ['approval_status', 1],  ['round_info_id', $request->round_info_id], ['group_a_per_jury_id', null]])->inRandomOrder()->take($request->random_videos[$key])->update([
                    'group_a_ran_jury_id' => $jury_id,
                ]);
            }

            return response()->json([
                'status' => 200,
                'message' => 'Jury assigned successfully !',
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'status' => 500,
                'message' => 'Opps... Something went wrong ! ' . $exception->getMessage(),
            ]);
        }
    }

    public function assignMainJuriesForPercentage(Request $request)
    {
        try {
            $percentage_videos = AuditionUploadVideo::where([['audition_id', $request->audition_id], ['type', $request->type], ['approval_status', 1],  ['round_info_id', $request->round_info_id], ['group_b_jury_mark', '!=', null], ['group_c_jury_mark', '!=', null]])->get();

            $videoIds = [];
            foreach ($percentage_videos as $key => $percentage_video) {
                if ($percentage_video->group_b_jury_mark > $percentage_video->group_c_jury_mark && ($percentage_video->group_b_jury_mark - $percentage_video->group_c_jury_mark >= $request->value)) {
                    array_push($videoIds, $percentage_video->id);
                }
                if ($percentage_video->group_c_jury_mark > $percentage_video->group_b_jury_mark && ($percentage_video->group_c_jury_mark - $percentage_video->group_b_jury_mark >= $request->value)) {
                    array_push($videoIds, $percentage_video->id);
                }
            }

            foreach ($request->juries as $key => $jury_id) {
                AuditionUploadVideo::whereIn('id', $videoIds)->where([['group_a_per_jury_id', null], ['group_a_ran_jury_id', null], ['audition_id', $request->audition_id], ['type', $request->type], ['round_info_id', $request->round_info_id]])->take($request->random_videos[$key])->update([
                    'group_a_per_jury_id' => $jury_id,
                ]);
            }

            return response()->json([
                'status' => 200,
                'message' => 'Jury assigned successfully !',
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'status' => 500,
                'message' => 'Opps... Something went wrong ! ' . $exception->getMessage(),
            ]);
        }
    }

    public function roundResultSendToManager(Request $request)
    {
        if ($request->filter_type == 'number') {
            AuditionRoundMarkTracking::where([
                ['round_info_id', $request->round_info_id],
                ['audition_id', $request->audition_id],
                ['type', $request->type]
            ])->orderBy('avg_mark', 'DESC')->take($request->filter_number)->update(['wining_status' => 1,]);
        } else if ($request->filter_type == 'percentage') {
            AuditionRoundMarkTracking::where([
                ['round_info_id', $request->round_info_id],
                ['audition_id', $request->audition_id],
                ['type', $request->type],
                ['avg_mark', '>=', $request->percentage_range]
            ])->update(['wining_status' => 1,]);
        }

        if ($request->type == 'general') {
            AuditionRoundInfo::where('id', $request->round_info_id)->update([
                'manager_status' => 1,
            ]);
        } else {
            AuditionRoundInfo::where('id', $request->round_info_id)->update([
                'appeal_manager_status' => 1,
            ]);
        }

        return response()->json([
            'status' => 200,
            'message' => 'Audition Round Result Send To Manager Successfully',
        ]);
    }

    // By Srabon

    public function storeRoundInstructionVideo(Request $request)
    {


        // return $request->judge_id;


        // $old_instruction = AuditionRoundInstruction::where([['audition_id', $request->audition_id], ['round_info_id', $request->round_info_id]])->first();

        {
            $validator = Validator::make($request->all(), [
                'round_info_id' => 'required|exists:audition_round_infos,id',
                'instruction' => 'required|min:10',
                'description' => 'required|min:10',
                'image' => 'required|mimes:jpg,jpeg,png',
                'video' => 'required|mimes:mp4,mkv',
            ], [
                'round_info_id.required' => 'Please Select Round Number',
            ]);
        }

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'validation_errors' => $validator->errors(),
            ]);
        } else {

            $image_path = NULL;
            $video_path = NULL;
            $pdf_path = NULL;


            foreach ($request->judge_id as $judge => $id) {

                $instruction = new AuditionRoundInstructionSendInfo();

                $instruction->round_info_id = $request->round_info_id;
                $instruction->audition_admin_id = auth()->user()->id;
                $instruction->audition_id = $request->audition_id;
                $instruction->instruction = $request->instruction;
                $instruction->description = $request->description;
                $instruction->start_date = $request->start_date;
                $instruction->end_date = $request->end_date;
                $instruction->judge_id =  $id;

                if ($judge == 0) {

                    // try {
                    if ($request->hasfile('image')) {
                        $image             = $request->image;
                        $image_folder_path       = 'uploads/images/auditions/round/instructions/';
                        $image_new_name    = Str::random(4) . $id . now()->timestamp . '.' . $image->getClientOriginalExtension();
                        // save to server
                        $request->image->move($image_folder_path, $image_new_name);
                        $instruction->image = $image_folder_path . $image_new_name;
                        $image_path = $instruction->image;
                    }

                    if ($request->hasfile('video')) {
                        $file             = $request->video;
                        $folder_path       = 'uploads/videos/auditions/round/instructions/';
                        $file_new_name    = Str::random(20) . $id . '-' . now()->timestamp . '.' . $file->getClientOriginalExtension();
                        // save to server
                        $request->video->move($folder_path, $file_new_name);
                        $instruction->video = $folder_path . $file_new_name;
                        $video_path = $instruction->video;
                    }

                    if ($request->hasfile('pdf')) {
                        $image             = $request->pdf;
                        $pdf_folder_path       = 'uploads/pdf/auditions/round/instructions/';

                        $pdf_new_name    = Str::random(20) . $id . '-' . now()->timestamp . '.' . $image->getClientOriginalExtension();
                        // save to server
                        $request->pdf->move($pdf_folder_path, $pdf_new_name);
                        $instruction->document = $pdf_folder_path . $pdf_new_name;
                        $pdf_path = $instruction->document;
                    }
                } else {

                    $instruction->image = $image_path;
                    $instruction->video = $video_path;
                    $instruction->document = $pdf_path;
                }


                $instruction->save();



                // return response()->json([
                //     'status' => 200,
                //     'message' =>  'something...',
                // ]);
                // } catch (\Exception $exception) {
                //     return response()->json([
                //         'status' => 200,
                //         'message' =>  $exception->getMessage(),
                //     ]);
                // }
            }
            return response()->json([
                'status' => 200,
                'message' => 'Audition Round Instruction video submitted successfully !!',

            ]);
        }
    }
    public function storeRoundInstructionVideoList()
    {

        $event = AuditionRoundInstructionSendInfo::with(['audition', 'star'])->where([['audition_admin_id', auth('sanctum')->user()->id], ['status', 0]])->latest()->get();
        return response()->json([
            'status' => 200,
            'event' => $event,
        ]);
    }
    public function acceptRoundInstructionVideoList()
    {

        $event = AuditionRoundInstructionSendInfo::with(['audition', 'star'])->where([['audition_admin_id', auth('sanctum')->user()->id], ['status', 1]])->latest()->get();
        return response()->json([
            'status' => 200,
            'event' => $event,
        ]);
    }
    public function getVideoDetails($id)
    {

        $event = AuditionRoundInstructionSendInfo::with('audition')->where('id', $id)->first();
        return response()->json([
            'status' => 200,
            'event' => $event,
        ]);
    }
    public function getJudgeMark($audition_id, $round_info_id)
    {

        $participants = AuditionParticipant::whereHas('videos', function ($query) use ($round_info_id) {
            $query->where([['round_info_id', $round_info_id]]);
        })->with(['videos' => function ($query) use ($round_info_id) {
            $query->with('judge_video_mark', 'totalUserVoteReact')->where([['round_info_id', $round_info_id]])->get();
        }, 'participant'])
            ->where([['audition_id', $audition_id]])
            ->get();

        $auditionRoundInfo  = AuditionRoundInfo::find($round_info_id);
        $roundBasedAuditionUploadVideos = AuditionUploadVideo::where([['round_info_id', $round_info_id], ['audition_id', $audition_id], ['approval_status', 1]])->get();
        $ableToMargeVideos = AuditionUploadVideo::where([['round_info_id', $round_info_id], ['judge_avg_mark', null], ['audition_id', $audition_id], ['approval_status', 1]])->get();

        return response()->json([
            'status' => 200,
            'participants' => $participants,
            'auditionRoundInfo' => $auditionRoundInfo,
            'roundBasedAuditionUploadVideos' => $roundBasedAuditionUploadVideos,
            'ableToMargeVideos' => $ableToMargeVideos,
        ]);
    }
    public function getEligibleParticipant($audition_id, $round_info_id)
    {
        $prevRound = $round_info_id - 1;

        $participants = AuditionRoundMarkTracking::with(['userUploadedVideo' => function ($q) use ($audition_id, $round_info_id) {
            $q->with('judge_video_mark', 'totalUserVoteReact')->where([['round_info_id', $round_info_id]])->where([['audition_id', $audition_id], ['round_info_id', $round_info_id]])->get();
        }, 'oxygenVideo'])->where([['audition_id', $audition_id], ['round_info_id',   $prevRound], ['wining_status', 1]])->get();

        $ableToMargeVideos = AuditionUploadVideo::where([['round_info_id', $round_info_id], ['judge_avg_mark', null], ['audition_id', $audition_id], ['approval_status', 1]])->get();


        $auditionRoundInfo = AuditionRoundInfo::find($round_info_id);
        return response()->json([
            'status' => 200,
            'participants' => $participants,
            'auditionRoundInfo' => $auditionRoundInfo,
            'ableToMargeVideos' => $ableToMargeVideos,

        ]);
    }
    public function makeRoundResultMerge($audition_id, $round_info_id)
    {
        $auditionRoundInfo = AuditionRoundInfo::find($round_info_id);
        $auditionUserVotingMark = AuditionUserVoteMark::where('audition_id', $audition_id)->first();
        $ableToMargeVideos = AuditionUploadVideo::with('judge_video_mark', 'totalUserVoteReact')->where([['round_info_id', $round_info_id], ['user_judge_total_mark', null], ['audition_id', $audition_id], ['approval_status', 1]])->get();

        foreach ($ableToMargeVideos as $videos) {
            foreach ($videos->judge_video_mark->groupBy('audition_uploads_video_id') as $mark) {
                $videos->judge_avg_mark = (($mark->sum('judge_mark') / $mark->count()) * $auditionRoundInfo->jury_or_judge_mark) / 100;
                $videos->save();
            }
        }
        foreach ($ableToMargeVideos as $videos) {
            foreach (($videos->totalUserVoteReact) as $mark) {
                $videos->user_vote_avg_mark = ($mark['react_num'] * $auditionUserVotingMark->user_mark) / $auditionUserVotingMark->total_react;
                $videos->save();
            }
        }
        foreach ($ableToMargeVideos as $videos) {
            $videos->user_judge_total_mark = $videos->user_vote_avg_mark + $videos->judge_avg_mark;
            $videos->save();
        }

        $participants = AuditionParticipant::whereHas('videos', function ($query) use ($round_info_id) {
            $query->where([['round_info_id', $round_info_id]]);
        })->with(['videos' => function ($query) use ($round_info_id) {
            return $query->where([['round_info_id', $round_info_id]])->get();
        }, 'participant'])->where([['audition_id', $audition_id]])->get();

        foreach ($participants as $parentKey => $auditionParticipant) {
            $sum_of_final_mark = 0;
            foreach ($auditionParticipant->videos as $key => $video) {
                $sum_of_final_mark += $video->user_judge_total_mark == null ? 0 : $video->user_judge_total_mark;
            }

            $average = number_format(($sum_of_final_mark / ($auditionRoundInfo->video_slot_num ? $auditionRoundInfo->video_slot_num : 1)), 2);


            $auditionRoundMarkTracking  = new AuditionRoundMarkTracking();
            $auditionRoundMarkTracking->user_id = $auditionParticipant->user_id;
            $auditionRoundMarkTracking->type = "general";
            $auditionRoundMarkTracking->round_info_id = $round_info_id;
            $auditionRoundMarkTracking->audition_id = $audition_id;
            $auditionRoundMarkTracking->avg_mark = $average;
            $auditionRoundMarkTracking->save();
        }
        return response()->json([
            'status' => 200,
            'message' => 'Result Merged successfully !!',

        ]);
    }


    public function liveAuditionVideoUpload(Request $request)

    {
        $validator = Validator::make($request->all(), [
            'video' => 'required|mimes:mp4,mkv',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'validation_errors' => $validator->errors(),
            ]);
        } else {
            $assignedJudges = AuditionAssignJudge::where([['audition_id', $request->audition_id]])->pluck('judge_id');

            $uploadVideo = new AuditionUploadVideo();
            $uploadVideo->audition_id = $request->audition_id;
            $uploadVideo->round_info_id = $request->round_info_id;
            $uploadVideo->user_id = $request->user_id;
            $uploadVideo->approval_status = 1;
            $uploadVideo->judge_id =  json_encode($assignedJudges);

            if ($request->hasfile('video')) {
                $destination = $uploadVideo->video;
                if (File::exists($destination)) {
                    File::delete($destination);
                }
                $file             = $request->video;
                $folder_path       = 'uploads/videos/auditions/post/';
                $file_new_name    = Str::random(20) . '-' . now()->timestamp . '.' . $file->getClientOriginalExtension();
                // save to server
                $request->video->move($folder_path, $file_new_name);
                $uploadVideo->video = $folder_path . '/' . $file_new_name;
            }

            $uploadVideo->save();
        }
        return response()->json([

            'status' => 200,
            'message ' => "Video Uploaded Successfully!",

        ]);
    }
    public function userUploadedVideos($user_id, $audition_id, $round_info_id)
    {

        $videos = AuditionUploadVideo::where([['user_id', $user_id], ['audition_id', $audition_id], ['round_info_id', $round_info_id]])->get();
        return response()->json([

            'status' => 200,
            'videos' => $videos,

        ]);
    }
    public function liveJudgeMarkUpload(Request $request)
    {

        $videos = AuditionUploadVideo::where([['user_id', $request->user_id], ['audition_id', $request->audition_id], ['round_info_id', $request->round_info_id]])->first();
        $validator = Validator::make($request->all(), [
            'judge_mark' => 'required',
            'judge_comment' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'validation_errors' => $validator->errors(),
            ]);
        } else {

            $judgeMarks = AuditionJudgeMark::where([['judge_id', $request->judge_id], ['audition_id', $request->audition_id], ['round_info_id', $request->round_info_id], ['audition_uploads_video_id', $videos->id]])->first();

            if (!$judgeMarks) {
                $judgeMark = new auditionJudgeMark();
                $judgeMark->audition_id = $request->audition_id;
                $judgeMark->round_info_id = $request->round_info_id;
                $judgeMark->judge_id = $request->judge_id;
                $judgeMark->judge_mark = $request->judge_mark;
                $judgeMark->judge_comment = $request->judge_comment;
                $judgeMark->audition_uploads_video_id = $videos->id;
                $judgeMark->save();

                return response()->json([

                    'status' => 200,
                    'message' => "Video Marking Successfull!",

                ]);
            } else {
                return response()->json([

                    'status' => 400,
                    'message' => "Mark Already Submitted !",

                ]);
            }
        }
    }
    public function wildcardLoveReact($audition_id, $round_info_id)
    {

        $wildcardparticipant = LoveReact::where([['audition_id', $audition_id], ['round_info_id', $round_info_id]])->groupBy('participant_id')->pluck('participant_id');
        $wildcardParticipant = AuditionParticipant::with('totalLoveReact', 'participant')->whereIn('user_id', $wildcardparticipant)->get();

        return response()->json([

            'status' => 200,
            'wildcardParticipant' => $wildcardParticipant,
        ]);
    }
    public function wildcardResultSendToManager(Request $request)
    {
        if ($request->filter_type == "number") {
            $wildcardInfo = WildCard::where('end_round_info_id', $request->round_info_id)->first();

            $wildcardSelectedParticipant = LoveReact::selectRaw('participant_id,sum(react_num) as total_react_num')->groupBy('participant_id')->where([['round_info_id',  $wildcardInfo->start_round_info_id], ['react_voting_type', $request->type], ['audition_id', $request->audition_id]])->orderBy('total_react_num', 'DESC')->take($request->filter_number)->get();
            foreach ($wildcardSelectedParticipant as $selectedParticipant) {
                foreach (array($selectedParticipant) as $participant) {
                    AuditionRoundMarkTracking::create([
                        'user_id' => $participant['participant_id'],
                        'round_info_id' => $request->round_info_id,
                        'audition_id' => $request->audition_id,
                        'type' => $request->type,
                        'wining_status' => 1,
                        'avg_mark' => $participant['total_react_num'],
                    ]);
                }
            }
            $wildcardInfo = WildCard::where([['end_round_info_id', $request->round_info_id], ['audition_id', $request->audition_id]])->update(['status' => 2]);
            return response()->json([
                'status' => 200,
                'message' => 'Result Sent To manager',
            ]);
        }
        $percentage_range = $request->percentage_range;
        if ($request->filter_type == "percentage") {
            $wildcardInfo = WildCard::where('end_round_info_id', $request->round_info_id)->first();
            $percentageWildcardMarkTrackings = LoveReact::selectRaw('participant_id, sum(react_num) as react_num')->groupBy('participant_id')->where([['round_info_id', $wildcardInfo->start_round_info_id], ['react_voting_type', $request->type], ['audition_id', $request->audition_id]])->get();

            $myArray = json_decode($percentageWildcardMarkTrackings);

            $percentegeWildcardMarking = array_filter(
                $myArray,
                function ($obj) use ($percentage_range) {
                    return $obj->react_num >= $percentage_range;
                }
            );
            foreach ($percentegeWildcardMarking as $selectedParticipant) {
                foreach (array($selectedParticipant) as $participant) {
                    AuditionRoundMarkTracking::create([
                        'user_id' => $participant->participant_id,
                        'round_info_id' => $request->round_info_id,
                        'audition_id' => $request->audition_id,
                        'type' => $request->type,
                        'wining_status' => 1,
                        'avg_mark' => $participant->react_num,
                    ]);
                }
            }
            $wildcardInfo = WildCard::where([['end_round_info_id', $request->round_info_id], ['audition_id', $request->audition_id]])->update(['status' => 2]);
            return response()->json([
                'status' => 200,
                'message' => 'Result Sent To manager',
            ]);
        }
    }
    public function OxygenVideoUpload(Request $request)

    {
        $validator = Validator::make($request->all(), [
            'video' => 'required|mimes:mp4,mkv',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'validation_errors' => $validator->errors(),
            ]);
        } else {
            $uploadVideo = new AuditionOxygenVideo();
            $uploadVideo->audition_id = $request->audition_id;
            $uploadVideo->round_info_id = $request->round_info_id;
            $uploadVideo->user_id = $request->user_id;
            $uploadVideo->status = 1;

            if ($request->hasfile('video')) {
                $destination = $uploadVideo->video;
                if (File::exists($destination)) {
                    File::delete($destination);
                }
                $file             = $request->video;
                $folder_path       = 'uploads/videos/auditions/post';
                $file_new_name    = Str::random(20) . '-' . now()->timestamp . '.' . $file->getClientOriginalExtension();
                // save to server
                $request->video->move($folder_path, $file_new_name);
                $uploadVideo->video = $folder_path . '/' . $file_new_name;
            }

            $uploadVideo->save();
        }
        return response()->json([

            'status' => 200,
            'message ' => "Video Uploaded Successfully!",

        ]);
    }
    public function getReplyVideos($audition_id, $round_info_id, $user_id)
    {
        $replyVideos = AuditionOxygenReplyVideo::where([['audition_id', $audition_id], ['round_info_id', $round_info_id], ['participant_id', $user_id]])->get();
        return response()->json([

            'status' => 200,
            'replyVideos' => $replyVideos,

        ]);
    }
    public function makeOxygenWinner($audition_id, $round_info_id, $user_id)
    {
        $replyVideos = AuditionOxygenVideo::where([['audition_id', $audition_id], ['round_info_id', $round_info_id], ['user_id', $user_id]])->update([
            'status' => 2,
        ]);
        if ($replyVideos) {
            AuditionRoundMarkTracking::create([
                'user_id' => $user_id,
                'audition_id' => $audition_id,
                'round_info_id' => $round_info_id,
                'type' => "oxygen",
                'result_message' => "Congratulations ! You are selected Via Oxygen",
                'avg_mark' => 00,
                'wining_status' => 1,

            ]);
        }

        return response()->json([

            'status' => 200,
            'message' => "Participant Selected",

        ]);
    }
    public function makeCertificate(Request $request)
    {
        $auditionCertificationContent = new AuditionCertificationContent();
        $auditionCertificationContent->audition_id = $request->audition_id;
        $auditionCertificationContent->title = $request->title;
        $auditionCertificationContent->fee = $request->fee;
        $auditionCertificationContent->sub_title = $request->sub_title;
        $auditionCertificationContent->main_content = $request->main_content;

        try {
            if ($request->hasfile('company_logo')) {
                $image             = $request->company_logo;
                $image_folder_path       = 'uploads/images/auditions/certificate/';
                $image_new_name    = Str::random(20) . '-' . now()->timestamp . '.' . $image->getClientOriginalExtension();
                // save to server
                $request->company_logo->move($image_folder_path, $image_new_name);
                $auditionCertificationContent->company_logo = $image_folder_path . $image_new_name;
            }
        } catch (\Exception $exception) {
            return response()->json([
                'status' => 200,
                'message' =>  $exception->getMessage(),
            ]);
        }
        try {
            if ($request->hasfile('brand_logo')) {
                $image             = $request->brand_logo;
                $image_folder_path       = 'uploads/images/auditions/certificate/';
                $image_new_name    = Str::random(20) . '-' . now()->timestamp . '.' . $image->getClientOriginalExtension();
                // save to server
                $request->brand_logo->move($image_folder_path, $image_new_name);
                $auditionCertificationContent->brand_logo = $image_folder_path . $image_new_name;
            }
        } catch (\Exception $exception) {
            return response()->json([
                'status' => 200,
                'message' =>  $exception->getMessage(),
            ]);
        }
        try {
            if ($request->hasfile('frame')) {
                $image             = $request->frame;
                $image_folder_path       = 'uploads/images/auditions/certificate/';
                $image_new_name    = Str::random(20) . '-' . now()->timestamp . '.' . $image->getClientOriginalExtension();
                // save to server
                $request->frame->move($image_folder_path, $image_new_name);
                $auditionCertificationContent->frame = $image_folder_path . $image_new_name;
            }
        } catch (\Exception $exception) {
            return response()->json([
                'status' => 200,
                'message' =>  $exception->getMessage(),
            ]);
        }

        $auditionCertificationContent->save();
        if ($auditionCertificationContent) {
            return response()->json([
                'status' => 200,
                'message' => "content created",
            ]);
        }
    }
}
