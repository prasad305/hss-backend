<?php

namespace App\Http\Controllers\API\Audition\Judge;

use App\Http\Controllers\Controller;
use App\Models\Audition\Audition;
use App\Models\Audition\AuditionAssignJudge;
use App\Models\Audition\AuditionAssignJury;
use App\Models\Audition\AuditionJudgeInstruction;
use App\Models\Audition\AuditionPromoInstructionSendInfo;
use App\Models\Audition\AuditionRoundInstructionSendInfo;
use App\Models\Audition\AuditionUploadVideo;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Svg\Tag\Rect;

class JudgeAuditionController extends Controller
{
    // Star  Audition Start
    public function starPendingAudtion()
    {
        $pendingAuditions = Audition::with('judge')
            ->whereHas('judge', function ($q) {
                $q->where([['judge_id', auth('sanctum')->user()->id], ['approved_by_judge', 0]]);
            })->where('status', 1)
            ->get();
        return response()->json([
            'status' => 200,
            'pending_auditions' => $pendingAuditions,
        ]);
    }
    public function starPromoInstructionPending()
    {
        $auditions = Audition::with(['assignedJudges' => function ($q) {
            return $q->where('judge_id', auth('sanctum')->user()->id);
        }])->where('status', 1)
            ->get();

        return response()->json([
            'status' => 200,
            'auditions' => $auditions,
        ]);
    }
    public function starAuditionByPromoInstructionPending($id)
    {
        $auditionPromoInstructionSendInfo  = AuditionPromoInstructionSendInfo::find($id);
        return response()->json([
            'status' => 200,
            'auditionPromoInstructionSendInfo' => $auditionPromoInstructionSendInfo,
            'audition' => $auditionPromoInstructionSendInfo->audition,
        ]);
    }
    public function getRoundInstructionByJudge($audition_id, $round_id)
    {
        $auditionRoundInstructionSendInfo = AuditionRoundInstructionSendInfo::where([['audition_id', $audition_id], ['round_info_id', $round_id], ['judge_id', auth()->user()->id]])->first();
        $audition = Audition::find($audition_id);
        return response()->json([
            'status' => 200,
            'auditionRoundInstructionSendInfo' => $auditionRoundInstructionSendInfo,
            'audition' => $audition,
        ]);
    }
    public function starAuditionByPromoInstructionUpdate(Request $request)
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

                $auditionPromoInstructionSendInfo  = AuditionPromoInstructionSendInfo::find($request->audition_promo_instruction_send_info_id);
                $auditionPromoInstructionSendInfo->instruction = $request->instruction;
                $auditionPromoInstructionSendInfo->status = 1;

                if ($request->hasfile('image')) {
                    $image             = $request->image;
                    $image_folder_path       = 'uploads/images/auditions/instructions/';
                    $image_new_name    = Str::random(20) . '-' . now()->timestamp . '.' . $image->getClientOriginalExtension();
                    // save to server
                    $request->image->move($image_folder_path, $image_new_name);
                    $auditionPromoInstructionSendInfo->image = $image_folder_path . '/' . $image_new_name;
                }

                if ($request->hasfile('video')) {
                    $file             = $request->video;
                    $folder_path       = 'uploads/videos/auditions/instructions/';
                    $file_new_name    = Str::random(20) . '-' . now()->timestamp . '.' . $file->getClientOriginalExtension();
                    // save to server
                    $request->video->move($folder_path, $file_new_name);
                    $auditionPromoInstructionSendInfo->video = $folder_path . '/' . $file_new_name;
                }

                if ($request->hasfile('pdf')) {
                    $image             = $request->pdf;
                    $pdf_folder_path       = 'uploads/pdf/auditions/instructions/';
                    $pdf_new_name    = Str::random(20) . '-' . now()->timestamp . '.' . $image->getClientOriginalExtension();
                    // save to server
                    $request->pdf->move($pdf_folder_path, $pdf_new_name);
                    $auditionPromoInstructionSendInfo->document = $pdf_folder_path . '/' . $pdf_new_name;
                }

                $auditionPromoInstructionSendInfo->save();
                return response()->json([
                    'status' => 200,
                    'message' => 'Audition Promo instruction updated successfully !!',
                    'auditionPromoInstructionSendInfo' => $auditionPromoInstructionSendInfo,
                ]);
            } catch (\Exception $exception) {
                return response()->json([
                    'status' => 200,
                    'message' =>  $exception->getMessage(),
                ]);
            }
        }
    }
    public function starAuditionByRoundInstructionUpdate(Request $request)
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

                $auditionRoundInstructionSendInfo  = AuditionRoundInstructionSendInfo::find($request->audition_round_instruction_send_info_id);
                $auditionRoundInstructionSendInfo->instruction = $request->instruction;
                $auditionRoundInstructionSendInfo->status = 1;

                if ($request->hasfile('image')) {
                    $image             = $request->image;
                    $image_folder_path       = 'uploads/images/auditions/instructions/';
                    $image_new_name    = Str::random(20) . '-' . now()->timestamp . '.' . $image->getClientOriginalExtension();
                    // save to server
                    $request->image->move($image_folder_path, $image_new_name);
                    $auditionRoundInstructionSendInfo->image = $image_folder_path . '/' . $image_new_name;
                }

                if ($request->hasfile('video')) {
                    $file             = $request->video;
                    $folder_path       = 'uploads/videos/auditions/instructions/';
                    $file_new_name    = Str::random(20) . '-' . now()->timestamp . '.' . $file->getClientOriginalExtension();
                    // save to server
                    $request->video->move($folder_path, $file_new_name);
                    $auditionRoundInstructionSendInfo->video = $folder_path . '/' . $file_new_name;
                }

                if ($request->hasfile('pdf')) {
                    $image             = $request->pdf;
                    $pdf_folder_path       = 'uploads/pdf/auditions/instructions/';
                    $pdf_new_name    = Str::random(20) . '-' . now()->timestamp . '.' . $image->getClientOriginalExtension();
                    // save to server
                    $request->pdf->move($pdf_folder_path, $pdf_new_name);
                    $auditionRoundInstructionSendInfo->document = $pdf_folder_path . '/' . $pdf_new_name;
                }

                $auditionRoundInstructionSendInfo->save();
                return response()->json([
                    'status' => 200,
                    'message' => 'Audition Round instruction updated successfully !!',
                    'auditionRoundInstructionSendInfo' => $auditionRoundInstructionSendInfo,
                ]);
            } catch (\Exception $exception) {
                return response()->json([
                    'status' => 200,
                    'message' =>  $exception->getMessage(),
                ]);
            }
        }
    }

    public function starLiveAudtion()
    {
        $liveAuditions = Audition::with('judge')
            ->whereHas('judge', function ($q) {
                $q->where([['judge_id', auth('sanctum')->user()->id]]);
            })->where('status', 3)->get();

        return response()->json([
            'status' => 200,
            'liveAuditions' => $liveAuditions,
        ]);
    }
    public function liveEditInstructions($audition_id)
    {
        $audition = Audition::find($audition_id);


        $auditionInstruction = AuditionJudgeInstruction::where('audition_id', $audition_id)->where('round_id', $audition->audition_round_rules_id)->where('judge_id', auth('sanctum')->user()->id)->orderBy('id', 'DESC')->first();

        return response()->json([
            'status' => 200,
            'audition' => $audition,
            'auditionInstruction' => $auditionInstruction,
        ]);
    }
    public function starAudtionDetails($audition_id)
    {
        $audition = Audition::find($audition_id);
        // $auditionInstruction = AuditionJudgeInstruction::where('audition_id', $audition_id)->where('round_id', $audition->audition_round_rules_id)->where('judge_id', auth('sanctum')->user()->id)->orderBy('id', 'DESC')->first();

        return response()->json([
            'status' => 200,
            'audition' => $audition,
            // 'auditionInstruction' => $auditionInstruction,
        ]);
    }

    public function updateAuditionInstruction(Request $request, $audition_instruction_id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
            'time_boundary' => 'required',
            'banner' => 'required',
            'video' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'validation_errors' => $validator->errors(),
            ]);
        } else {
            $auditionJudgeInstruction               = AuditionJudgeInstruction::find($audition_instruction_id);
            $auditionJudgeInstruction->title        =  $request->title;
            $auditionJudgeInstruction->status       =  1;
            $auditionJudgeInstruction->description  =  $request->description;
            $auditionJudgeInstruction->time_boundary =  Carbon::parse($request->time_boundary);
            if ($request->hasfile('banner')) {
                $image             = $request->banner;
                $image_folder_path       = 'uploads/images/auditions/';
                $image_new_name    = Str::random(20) . '-' . now()->timestamp . '.' . $image->getClientOriginalExtension();
                // save to server
                $request->banner->move($image_folder_path, $image_new_name);
                $auditionJudgeInstruction->banner = $image_folder_path . $image_new_name;
            }
            if ($request->hasfile('video')) {
                $file             = $request->video;
                $folder_path       = 'uploads/videos/auditions/';
                $file_new_name    = Str::random(20) . '-' . now()->timestamp . '.' . $file->getClientOriginalExtension();
                // save to server
                $request->video->move($folder_path, $file_new_name);
                $auditionJudgeInstruction->video = $folder_path . $file_new_name;
            }

            $auditionJudgeInstruction->save();

            return response()->json([
                'status' => 200,
                'message' => "Instruction updated sucessfully !",
                'audition' => $auditionJudgeInstruction->audition,
                'auditionInstruction' => $auditionJudgeInstruction,
            ]);
        }
    }

    public function starSingleAudition($id)
    {

        // $pending_auditions = Audition::with(['judge', 'jury','admin'])->where('id', $id)->where('status',1)->get();
        $event = Audition::find($id);
        $judges = AuditionAssignJudge::where('audition_id', $id)->get();
        $juries = AuditionAssignJury::where('audition_id', $id)->get();

        return response()->json([
            'status' => 200,
            'event' => $event,
            'judges' => $judges,
            'juries' => $juries,
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
    public function pendingRoundInstructionVideo()
    {
        $event = AuditionRoundInstructionSendInfo::with(['audition', 'star'])->where([['judge_id', auth('sanctum')->user()->id], ['status', 0]])->latest()->get();
        return response()->json([
            'status' => 200,
            'event' => $event,
            'pending' => $event->count(),
        ]);
    }
    public function acceptedRoundInstructionVideo()
    {
        $event = AuditionRoundInstructionSendInfo::with(['audition', 'star'])->where([['judge_id', auth('sanctum')->user()->id], ['status', 1]])->latest()->get();
        return response()->json([
            'status' => 200,
            'event' => $event,
            'accepted' => $event->count(),
        ]);
    }
    public function roundInstructionVideoDetails($id)
    {

        $event = AuditionRoundInstructionSendInfo::with('audition')->where('id', $id)->first();
        return response()->json([
            'status' => 200,
            'event' => $event,
        ]);
    }

    public function roundInstructionVideoUpdate(Request $request, $id)
    {
        // return $request->all();

        $validator = Validator::make($request->all(), [
            'description' => 'required|min:10',
            'instruction' => 'required|min:10',
            'image' => 'required',
            'video' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'validation_errors' => $validator->errors(),
            ]);
        } else {
            $auditionJudgeInstruction               = AuditionRoundInstructionSendInfo::find($id);
            $auditionJudgeInstruction->status       =  1;
            $auditionJudgeInstruction->description  =  $request->description;
            $auditionJudgeInstruction->instruction  =  $request->instruction;

            if ($request->hasfile('image')) {
                $image             = $request->image;
                $image_folder_path       = 'uploads/images/auditions/round/instructions/';
                $image_new_name    = Str::random(4) . $id . now()->timestamp . '.' . $image->getClientOriginalExtension();
                // save to server
                $request->image->move($image_folder_path, $image_new_name);
                $auditionJudgeInstruction->image = $image_folder_path . $image_new_name;
            }

            if ($request->hasfile('video')) {
                $file             = $request->video;
                $folder_path       = 'uploads/videos/auditions/round/instructions/';
                $file_new_name    = Str::random(20) . $id . '-' . now()->timestamp . '.' . $file->getClientOriginalExtension();
                // save to server
                $request->video->move($folder_path, $file_new_name);
                $auditionJudgeInstruction->video = $folder_path . $file_new_name;
            }

            if ($request->hasfile('pdf')) {
                $image             = $request->pdf;
                $pdf_folder_path       = 'uploads/pdf/auditions/round/instructions/';

                $pdf_new_name    = Str::random(20) . $id . '-' . now()->timestamp . '.' . $image->getClientOriginalExtension();
                // save to server
                $request->pdf->move($pdf_folder_path, $pdf_new_name);
                $auditionJudgeInstruction->document = $pdf_folder_path . $pdf_new_name;
            }

            $auditionJudgeInstruction->save();

            return response()->json([
                'status' => 200,
                'message' => "Instruction updated sucessfully !",
            ]);
        }
    }
    public function round_judges_videos($round_info_id)
    {
        $videos = AuditionUploadVideo::whereJsonContains('judge_id', auth()->user()->id)->where([['type', 'general'], ['round_info_id', $round_info_id], ['approval_status', 1]])->get();
        $selectedVideos = AuditionUploadVideo::where([['type', 'general'], ['round_info_id', $round_info_id], ['approval_status', 1]])->get();

        // $arr = [];
        // foreach ($selectedVideos as  $video) {
        //     array_push($arr, json_decode($video->judge_mark));
        // }
        // return $arr;

        return response()->json([
            'status' => 200,
            'videos' => $videos,
            'selectedVideos' => $selectedVideos
        ]);
    }
    public function judgeVideoMarking(Request $request)
    {


        $auditionUploadVideo =  AuditionUploadVideo::find($request->video_id);
        if ($auditionUploadVideo->judge_mark != null) {
            $arr = json_decode($auditionUploadVideo->judge_mark);

            $data = array_merge($arr, [array(auth()->user()->id => $request->mark)]);
            $auditionUploadVideo->judge_mark =  json_encode($data);
            $auditionUploadVideo->save();

            return response()->json([
                'status' => 200,
                'message' => 'Mark added successfully !',
            ]);
        }
        $data = array(auth()->user()->id => $request->mark);
        $auditionUploadVideo->judge_mark = json_encode(array($data));
        $auditionUploadVideo->save();

        return response()->json([
            'status' => 200,
            'message' => 'Mark added successfully !',
        ]);
    }
}
