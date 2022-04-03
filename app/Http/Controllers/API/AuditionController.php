<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Audition\Audition;
use App\Models\User;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use App\Models\Audition\AssignJudge;
use App\Models\Audition\AuditionParticipant;
use App\Models\Audition\FilterVideo;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Expr\Assign;

class AuditionController extends Controller
{

    public function index()
    {
        //
    }

    public function auditionAdminStatus()
    {
        $live = Audition::where([['admin_id', auth('sanctum')->user()->id], ['status', 1]])->count();
        $pending = Audition::where([['admin_id', auth('sanctum')->user()->id], ['status', 0]])->count();
        return response()->json([
            'status' => 200,
            'live' => $live,
            'pending' => $pending,
        ]);
    }
    public function starAdminStatus()
    {
        $live = Audition::where([['parent_user', auth('sanctum')->user()->id], ['star_approval', 1]])->count();
        $pending = Audition::where([['parent_user', auth('sanctum')->user()->id], ['star_approval', 0]])->count();
        return response()->json([
            'status' => 200,
            'live' => $live,
            'pending' => $pending,
        ]);
    }


    public function auditionAdminPendings()
    {
        $pendings = Audition::where([['admin_id', auth('sanctum')->user()->id], ['status', 0]])->get();
        return response()->json([
            'status' => 200,
            'pendings' => $pendings,
        ]);
    }
    public function auditionAdminLive()
    {
        $lives = Audition::where([['admin_id', auth('sanctum')->user()->id], ['status', 1]])->get();
        return response()->json([
            'status' => 200,
            'lives' => $lives,
        ]);
    }
    public function auditionStatus($audition_id)
    {
        $auditionStatus = Audition::with('judge', 'judge.user')->where([['admin_id', auth('sanctum')->user()->id], ['id', $audition_id]])->get();
        return response()->json([
            'status' => 200,
            'auditionStatus' => $auditionStatus,
        ]);
    }
    public function confirmedAudition($audition_id)
    {
        $confirmedAudition = Audition::where([['admin_id', auth('sanctum')->user()->id], ['id', $audition_id]])->update(['star_approval' => 1]);
        return response()->json([
            'status' => 200,
            'confirmedAudition' => $confirmedAudition,
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
            'star_ids' => 'required',
            //'video' => 'mimes:mp4,mkv,3gp',
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
            $audition->start_time = $request->start_time;
            $audition->end_time = $request->end_time;
            $audition->round_status = $request->round_status;

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


            try {

                $audition->save();

                $star_ids = array_map('intval', explode(',', $request->star_ids));

                AssignJudge::whereNotIn('id', $star_ids)->where('audition_id', $audition->id)->delete();

                foreach ($star_ids as $key => $star) {
                    if (!AssignJudge::where('judge_id', $star)->where('audition_id', $audition->id)->first()) {
                        $assign_star = AssignJudge::create([
                            'audition_id' => $audition->id,
                            'judge_id' => $star,
                        ]);
                    }
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




    public function getAudition($audition_id)
    {
        $audition = Audition::with(['judge', 'participant'])->find($audition_id);

        $judge_ids = [];
        foreach ($audition->judge as $key => $star) {
            array_push($judge_ids, $star->judge_id);
        }

        // return $judge_ids;

        return response()->json([
            'status' => 200,
            'audition' => $audition,
            'judge_ids' => $judge_ids
        ]);
    }

    public function starPendingAudtion()
    {
        $pendingAuditions = Audition::with('judge')
            ->whereHas('judge', function ($q) {
                $q->where([['judge_id', auth('sanctum')->user()->id], ['approved_by_judge', 0]]);
            })->get();

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

        $pending_auditions = Audition::with(['judge', 'judge.user'])->where('id', $id)->get();
        return response()->json([

            'status' => 200,
            'pending_audition' => $pending_auditions,
        ]);
    }
    public function starApprovedAudition($id)
    {
        AssignJudge::where('audition_id', $id)->where('judge_id', auth('sanctum')->user()->id)->update(['approved_by_judge' => 1]);

        return response()->json([
            'status' => 200,
        ]);
    }

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

    public function videoSendManagerAdmin(Request $request)
    {
       
        AuditionParticipant::where([['audition_id', $request->audition_id],['accept_status', 1],['filter_status', 1]])->update([
            'send_manager_admin' => $request->send_manager_admin,
        ]);


        return response()->json([
            'status' => 200,
            'send_manager_admin' => true,
            'message' => 'Send to Manager Admin Successfully',
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
