<?php

namespace App\Http\Controllers\API\Audition\Admin;

use App\Http\Controllers\Controller;
use App\Models\Audition\Audition;
use App\Models\User;
use App\Models\SuperStar;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use App\Models\Audition\AssignJudge;
use App\Models\Audition\AuditionAssignJudge;
use App\Models\Audition\AuditionAssignJury;
use App\Models\Audition\AuditionJudgeInstruction;
use App\Models\Audition\AuditionParticipant;
use App\Models\Audition\AuditionMark;
use App\Models\Audition\AuditionPromoInstruction;
use App\Models\Audition\AuditionPromoInstructionSendInfo;
use App\Models\Audition\AuditionRoundInfo;
use App\Models\Audition\AuditionRoundInstructionSendInfo;
use App\Models\Audition\AuditionRoundRule;
use App\Models\Audition\AuditionUploadVideo;
use App\Models\Audition\AuditionVideoMark;
use App\Models\AuditionRoundInstruction;
use App\Models\JudgeMarks;
use App\Models\JuryGroup;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuditionController extends Controller
{
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
                $AuditionUploadVideo->approval_status = 1;
            } elseif ($request->rejected == 1) {
                $AuditionUploadVideo->approval_status = 2;
            }
            $AuditionUploadVideo->audition_admin_comment = $request->comment;
            $AuditionUploadVideo->save();

            return response()->json([
                'status' => 200,
                'message' => "Video filter completed successfully !",
            ]);
        }
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
            'pending_videos' => AuditionUploadVideo::where('audition_id', $audition_id)->where('round_id',  $audition->audition_round_rules_id)->where('approval_status', 0)->get(),
            'reject_videos' => AuditionUploadVideo::where('audition_id', $audition_id)->where('round_id',  $audition->audition_round_rules_id)->where('approval_status', 2)->get(),
            'approved_videos' => AuditionUploadVideo::where('audition_id', $audition_id)->where('round_id',  $audition->audition_round_rules_id)->where('approval_status', 1)->get(),
            'check_videos' => AuditionUploadVideo::where('audition_id', $audition_id)->where('round_id',  $audition->audition_round_rules_id)->whereIn('approval_status', [1, 2])->get(),
            'pending_videos_num' => $audition->uploadedVideos->where('round_id',  $audition->audition_round_rules_id)->where('approval_status', 0)->count(),
            'approved_videos_num' => $audition->uploadedVideos->where('round_id',  $audition->audition_round_rules_id)->where('approval_status', 1)->count(),
            'check_video_num' => $audition->uploadedVideos->where('round_id',  $audition->audition_round_rules_id)->whereIn('approval_status', [1, 2])->count(),
            'reject_video_num' => $audition->uploadedVideos->where('round_id',  $audition->audition_round_rules_id)->where('approval_status', 2)->count(),
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
            'instruction' => 'required|min:5',
            'submission_date' => 'required',
            'image' => 'required|mimes:jpg,jpeg,png',
            'video' => 'required|mimes:mp4,mkv',
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
            // $instruction->submission_end_date = date('Y-m-d', strtotime($request->submission_date));
            $instruction->submission_end_date = Carbon::parse($request->submission_date);

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
                } else {
                    $instruction->send_to_manager = 1;
                    $instruction->save();
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
    public function updatePromoInstruction(Request $request)
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
            $instruction->save();
        }
    }
    public function storeRoundInstruction(Request $request)
    {
        // return $request->star_ids;
        // return $request->all();
        $old_instruction = AuditionRoundInstruction::where([['audition_id', $request->audition_id], ['round_info_id', $request->round_info_id]])->first();

        if (isset($old_instruction->id)) {
            $validator = Validator::make($request->all(), [
                'round_info_id' => 'required',
                'instruction' => 'required|min:5',
                'submission_date' => 'required',
                'star_ids' => 'required',
            ], [
                'round_info_id.required' => 'Please Select Round Number',
                'star_ids.required' => 'Select At Least One Star'
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'round_info_id' => 'required',
                'instruction' => 'required|min:5',
                'submission_date' => 'required',
                'image' => 'required|mimes:jpg,jpeg,png',
                'video' => 'required|mimes:mp4,mkv',
                'star_ids' => 'required',
            ], [
                'round_info_id.required' => 'Please Select Round Number',
                'star_ids.required' => 'Select At Least One Star'
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
            $instruction->submission_end_date = Carbon::parse($request->submission_date);

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

                $instruction->send_to_judge = 1;
                $instruction->save();

                if ($instruction) {

                    if ($request->star_ids) {
                        AuditionRoundInstructionSendInfo::where([['audition_id', $request->audition_id], ['round_info_id', $request->round_info_id]])->delete();

                        foreach ($request->star_ids as $key => $star) {
                            // new round instruction for star create

                            $instruction_info = new AuditionRoundInstructionSendInfo();
                            $instruction_info->audition_id = $request->audition_id;
                            $instruction_info->round_info_id = $instruction->round_info_id;
                            $instruction_info->audition_round_ins_id = $instruction->id;
                            $instruction_info->judge_id = $star;
                            $instruction_info->instruction = $request->instruction;

                            $instruction_info->image = $instruction->image;
                            $instruction_info->video = $instruction->video;
                            $instruction_info->document = $instruction->document;
                            $instruction_info->submission_end_date = $instruction->submission_end_date;
                            $instruction_info->save();
                        }
                    }
                }
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
        
        $old_instruction = AuditionRoundInstruction::where([['audition_id',$request->audition_id],['round_info_id',$request->round_info_id]])->first();

        if (isset($old_instruction->id)) {
            $validator = Validator::make($request->all(), [
                'round_info_id' => 'required',
                'instruction' => 'required|min:5',
            ],[
                'round_info_id.required' => 'Please Select Round Number',
            ]);
        }else{
            $validator = Validator::make($request->all(), [
                'round_info_id' => 'required',
                'instruction' => 'required|min:5',
                'image' => 'required|mimes:jpg,jpeg,png',
                'video' => 'required|mimes:mp4,mkv',
                'pdf' => 'required|mimes:pdf',
            ],[
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
            }else{
                $instruction = new AuditionRoundInstruction();
            }
            
            $instruction->round_info_id = $request->round_info_id;
            $instruction->audition_id = $request->audition_id;
            $instruction->instruction = $request->instruction;
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

    public function auditionPromoInstruction($audition_id)
    {
        $instruction = AuditionPromoInstruction::where('audition_id', $audition_id)->first();
        return response()->json([
            'status' => 200,
            'instruction' => $instruction,
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
        $live = Audition::where([['audition_admin_id', auth('sanctum')->user()->id], ['status', 2]])->count();
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

    // Live Auditions
    public function live()
    {
        // return auth('sanctum')->user()->id;

        $lives = Audition::where([['audition_admin_id', auth('sanctum')->user()->id], ['status', 2]])->get();
        return response()->json([
            'status' => 200,
            'lives' => $lives,
        ]);
    }

    //Stars Under Audition Admin Category
    public function stars($category_id)
    {
        $stars = SuperStar::where([['category_id', $category_id], ['status', 1]])->get();

        return response()->json([
            'status' => 200,
            'stars' => $stars,
        ]);
    }


    public function getAssignedJudge($slug)
    {
        $audition = Audition::where('slug', $slug)->first();

        $judge = AuditionAssignJudge::where('audition_id', $audition->id)->get();
        // return $audition;

        return response()->json([
            'status' => 200,
            'judge' => $judge,
        ]);
    }


    public function getRoundInstructionJudges($audition_id,$round_info_id){
        
        $round_instruction = AuditionRoundInstruction::where([['audition_id',$audition_id],['round_info_id',$round_info_id]])->first();

        $round_ins_send_info = AuditionRoundInstructionSendInfo::where([['audition_id',$audition_id],['round_info_id',$round_info_id]])->get();


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

    public function approvalRequestForManagerAdmin($slug)
    {
        $audition = Audition::where('slug', $slug)->first();
        $audition->status = 2;
        $audition->save();

        return response()->json([
            'status' => 200,
            'event' => $audition,
        ]);
    }




    // Send to Manager Admin
    public function sendManager($audition_id)
    {
        $total_audition = AssignJudge::where('audition_id', $audition_id)->count();
        $sendManager = AssignJudge::where([['audition_id', $audition_id], ['approved_by_judge', 1]])->count();

        return response()->json([
            'status' => 200,
            'sendManager' => $total_audition == $sendManager,
        ]);
    }

    // Audition Modification by Audition Admin
    public function store(Request $request)
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
            $audition = Audition::find($request->audition_id);
            $audition->title = $request->title;
            $audition->description = $request->description;
            $audition->status = 1;

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

            if ($request->hasFile('video')) {
                if ($audition->video != null && file_exists($audition->video)) {
                    unlink($audition->video);
                }
                $file        = $request->file('video');
                $path        = 'uploads/videos/auditions';
                $file_name   = time() . rand('0000', '9999') . '.' . $file->getClientOriginalName();
                $file->move($path, $file_name);
                $audition->video = $path . '/' . $file_name;
            }

            $audition->save();

            return response()->json([
                'status' => 200,
                'message' => 'Audition Judge Added successfully'
            ]);
        }
    }


    // Audition Details

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
    public function starAdminPendingAudition()
    {
        $star = User::where('user_type', 'star')->where('parent_user', auth('sanctum')->user()->id)->first();
        $pendingAuditions = Audition::with('judge')
            ->whereHas('judge', function ($q) use ($star) {
                $q->where([['judge_id', $star->id], ['approved_by_judge', 0]]);
            })->get();

        return response()->json([
            'status' => 200,
            'pending_auditions' => $pendingAuditions,
        ]);
    }


    public function starAdminLiveAudition()
    {
        $star = User::where('user_type', 'star')->where('parent_user', auth('sanctum')->user()->id)->first();

        $liveAuditions = Audition::with('judge')
            ->whereHas('judge', function ($q) use ($star) {
                $q->where([['judge_id', $star->id], ['approved_by_judge', 1]]);
            })->get();

        return response()->json([
            'status' => 200,
            'liveAuditions' => $liveAuditions,
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

    public function juryMarking(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'participant_id' => 'required',
            'audition_id' => 'required',
        ]);


        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'validation_errors' => $validator->errors(),
            ]);
        } else {

            $audition =  Audition::find($request->audition_id);
            if ($audition->setJuryMark >= $request->marks) {

                $auditionMark = AuditionMark::create([

                    //'judge_id' => $request->judge_id,
                    'participant_id' => $request->participant_id,
                    'audition_id' => $request->audition_id,
                    'jury_id' => Auth::user()->id,
                    'comments' => $request->comments,
                    'status' => 1

                ]);

                if ($auditionMark) {
                    if ($request->selected == 1) {
                        $auditionMark->participant_status = 1;
                        $auditionMark->marks = $request->marks;
                    }

                    if ($request->rejected == 1) {
                        $auditionMark->participant_status = 0;
                    }
                    $auditionMark->save();

                    AuditionParticipant::find($request->participant_id)->update([
                        'marks_id' => $auditionMark->id,
                    ]);
                }

                return response()->json([
                    'status' => 200,
                    'message' => 'Marking Successfully',
                ]);
            } else {
                return response()->json([
                    'status' => 202,
                    'message' => $audition->setJuryMark,
                ]);
            }
        }
    }
    public function markingDone()
    {

        $accepted_videos = AuditionMark::with('auditionsParticipant')->orderBy('id', 'DESC')->where([['jury_id', auth()->user()->id], ['marks', '!=', null]])->get();

        return response()->json([
            'status' => 200,
            'accepted_videos' => $accepted_videos,
        ]);
    }


    public function juryMarkingVideos($audition_id)
    {

        // $audition_juries = AuditionParticipant::where([['audition_id', $audition_id], ['accept_status', 1], ['filter_status', 1], ['jury_id', '!=', null]])->get();

        $audition_participants = AuditionParticipant::where([['audition_id', $audition_id], ['accept_status', 1], ['filter_status', 1], ['jury_id', '!=', null]])->get();

        $juryIds = [];
        foreach ($audition_participants as $key => $jury) {
            array_push($juryIds, $jury->jury_id);
        }

        $juries = User::whereIn('id', $juryIds)->with(['participant_jury', 'markingVideo'])->orderBy('id', 'desc')->get();


        return response()->json([
            'status' => 200,
            'audition_participants' => $audition_participants,
            'juries' => $juries,
        ]);
    }

    public function getJuryMarkingVideos($jury_id)
    {
        $marking_videos = AuditionMark::where('jury_id', $jury_id)->count();
        $passed_videos = AuditionMark::where([['jury_id', $jury_id], ['participant_status', 1]])->count();
        $failed_videos = AuditionMark::where([['jury_id', $jury_id], ['participant_status', 0]])->count();

        return response()->json([
            'status' => 200,
            'marking_videos' => $marking_videos,
            'passed_videos' => $passed_videos,
            'failed_videos' => $failed_videos,
        ]);
    }

    public function getMarkWiseVideos($audition_id, $mark)
    {
        $marking_videos = AuditionMark::where('audition_id', $audition_id)->where('selected_status', 1)->where('marks', '>=', $mark)->count();

        return response()->json([
            'status' => 200,
            'mark_wise_videos' => $marking_videos,
        ]);
    }



    public function selectedTop(Request $request)
    {


        if ($request->mark_wise != null && $request->mark_wise == 'mark') {
            AuditionMark::where('audition_id', $request->audition_id)->where('marks', '>=', $request->selected_top)->where('participant_status', 1)->update([
                'selected_status' => 1,
                'message' => $request->message,
            ]);
        }

        if ($request->number_wise != null && $request->number_wise == 'number') {
            AuditionMark::where('audition_id', $request->audition_id)->where('participant_status', 1)->take($request->selected_top)->update([
                'selected_status' => 1,
                'message' => $request->message,
            ]);
        }
        return response()->json([
            'status' => 200,
            'message' => 'Selected Top Videos and Message Send Successfully',
        ]);
    }
    public function rejectedMessage(Request $request)
    {
        AuditionMark::where('marks', null)->where('participant_status', 0)->update([
            'selected_status' => 0,
            'message' => $request->message,
        ]);
        return response()->json([
            'status' => 200,
            'message' => 'Rejected Videos and Message Send Successfully',
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

    public function StarMarking(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'participant_id' => 'required',
            'audition_id' => 'required',
        ]);


        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'validation_errors' => $validator->errors(),
            ]);
        } else {


            $audition =  Audition::find($request->audition_id);

            if ($audition->setJudgeMark >= $request->marks) {

                $auditionMark = JudgeMarks::create([
                    'video_id' => $request->participant_id,
                    'audition_id' => $request->audition_id,
                    'marks' => $request->marks,
                    'judge_id' => Auth::user()->id,
                    'comments' => $request->comments,
                    'selected_status' => $request->selected_status,
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => 'Marking Done! Select Next',
                ]);
            } else {
                return response()->json([
                    'status' => 202,
                    'message' => $audition->setJudgeMark,
                ]);
            }
        }
    }
    public function starMarkingDone($id)
    {

        $accepted_videos = JudgeMarks::with('auditionsParticipant')->where('audition_id', $id)->where('marks', '!=', null)->get();

        return response()->json([
            'status' => 200,
            'accepted_videos' => $accepted_videos,
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




    public function juryNumberOfVideosApply($audition_id, $round_rules_id)
    {
        $audition = Audition::find($audition_id);

        $juryIds = [];
        foreach ($audition->assignedJuries as $key => $jury) {

            if (AuditionUploadVideo::where('jury_id', $jury->jury_id)->count() > 0) {
            } else {
                array_push($juryIds, $jury->jury_id);
            }
        }

        $accepted_videos = $audition->uploadedVideos->where('approval_status', 1)->where('round_id', $round_rules_id)->where('jury_id', null);
        $assigned_juries = AuditionAssignJury::whereIn('jury_id', $juryIds)->where('audition_id', $audition_id)->get();
        $total_jury = count($assigned_juries);
        $total_video = count($accepted_videos);

        $videoPackArray = [];
        if ($total_jury > 0) {
            $video_pack = floor($total_video / $total_jury);
            for ($total_jury; $total_jury > 0; $total_jury--) {


                if ($total_jury == 1) {
                    array_push($videoPackArray, $total_video);
                } else {
                    array_push($videoPackArray, $video_pack);
                    $total_video = $total_video - $video_pack;
                }
            }
        }

        return response()->json([
            'status' => 200,
            'videoPack' => $videoPackArray,
            'assigned_juries' => $assigned_juries,

        ]);
    }

    public function updateJuryAssignVideo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'num_of_videos' => 'required',
        ]);


        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'validation_errors' => $validator->errors(),
            ]);
        } else {
            AuditionUploadVideo::where([['audition_id', $request->audition_id], ['round_id', $request->round_rules_id], ['jury_id', null]])->take($request->num_of_videos)->update([
                'jury_id' => $request->jury_id,
                'jury_mark_deadline' => $request->uploade_date,
            ]);
            return response()->json([
                'status' => 200,
                'message' => 'Video Assign To Jury Successfully!',
            ]);
        }
    }
    public function updateJuryAutoAssignVideo(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'num_of_videos' => 'required',
        ]);
        $audition = Audition::find($request->audition_id);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'validation_errors' => $validator->errors(),
            ]);
        } else {
            $juryIds = $audition->uploadedVideos->whereIn('jury_id', $audition->assignedJuries->pluck('jury_id'))->pluck('jury_id');

            $requiredJuries = $audition->assignedJuries->whereNotIn('jury_id', $juryIds)->pluck('jury_id');
            foreach ($request->num_of_videos as $key => $num_of_video) {
                AuditionUploadVideo::where([['audition_id', $request->audition_id], ['round_id', $request->round_rules_id], ['jury_id', null]])->take($num_of_video)->update([
                    'jury_id' => $requiredJuries[$key],
                    'jury_mark_deadline' => $request->uploade_date,
                ]);
            }
            return response()->json([
                'status' => 200,
                'message' => 'Video Assign To Jury Successfully!',
            ]);
        }
    }

    public function juryMarkOnVideosStatus($audition_id, $round_rules_id)
    {
        $audition = Audition::find($audition_id);
        $juryIds = $audition->assignedJuries->pluck('jury_id');
        $juryAssignVideos = $audition->uploadedVideos->whereIn('jury_id', $juryIds)->where('round_id', $round_rules_id);
        $juryMarkingVideos = $juryAssignVideos->whereIn('jury_approval_status', [1, 2]);
        $juryPassedVideos = $juryMarkingVideos->where([['jury_approval_status', 1], ['mark', '!=', null]]);
        $juryFailedVideos = $juryMarkingVideos->where([['jury_approval_status', 2], ['mark', '!=', null]]);
        return response()->json([
            'status' => 200,
            'juryAssignvideos' => $juryAssignVideos,
            'juryMarkingVideos' => $juryMarkingVideos,
            'juryPassedVideos' => $juryPassedVideos,
            'juryFailedVideos' => $juryFailedVideos,
        ]);
    }


    public function group_juries($audition_id, $group_id)
    {

        $juries = AuditionAssignJury::where([['audition_id', $audition_id], ['group_id', $group_id]])->get();

        return response()->json([
            'status' => 200,
            'juries' => $juries,
        ]);
    }



    public function getRoundInfo($audition_id, $round_info_id){
        
        $round_info = AuditionRoundInfo::find($round_info_id);

        $videos = AuditionParticipant::with(['videos' => function($query) use($round_info_id){
            return $query->where('round_info_id',$round_info_id)->get();
        },'participant'])->where([['audition_id',$audition_id],['round_info_id',$round_info_id]])->get();

        // $round_marked_videos = AuditionVideoMark::where([['audition_id',$audition_id],['round_info_id',$round_info_id]])->get();

        return response()->json([
            'status' => 200,
            'round_info' => $round_info,
            'round_marked_videos' => $videos,
        ]);
    }
    
    public function round_videos($round_info_id)
    {

        $videos = AuditionUploadVideo::where([['round_info_id', $round_info_id],['approval_status',0]])->get();
        $selectedVideos = AuditionUploadVideo::where([['round_info_id', $round_info_id],['approval_status',1]])->get();
        $rejectedVideos = AuditionUploadVideo::where([['round_info_id', $round_info_id],['approval_status',2]])->get();

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
}
