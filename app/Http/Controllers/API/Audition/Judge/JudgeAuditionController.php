<?php

namespace App\Http\Controllers\API\Audition\Judge;

use App\Http\Controllers\Controller;
use App\Models\Audition\Audition;
use App\Models\Audition\AuditionAssignJudge;
use App\Models\Audition\AuditionAssignJury;
use App\Models\Audition\AuditionJudgeInstruction;
use App\Models\Audition\AuditionPromoInstructionSendInfo;
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
    public function liveEditInstructions($audition_id)
    {
        $audition = Audition::find($audition_id);
        $auditionInstruction = AuditionJudgeInstruction::where('audition_id', $audition_id)->where('round_id', $audition->audition_round_rules_id)->where('star_id', auth('sanctum')->user()->id)->orderBy('id', 'DESC')->first();

        return response()->json([
            'status' => 200,
            'audition' => $audition,
            'auditionInstruction' => $auditionInstruction,
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
}
