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
use App\Models\Audition\AuditionParticipant;
use App\Models\Audition\AuditionMark;
use App\Models\JudgeMarks;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuditionController extends Controller
{
    //Count
    public function count()
    {
        $live = Audition::where([['audition_admin_id', auth('sanctum')->user()->id], ['status', 1]])->count();
        $pending = Audition::where([['audition_admin_id', auth('sanctum')->user()->id], ['status', 0]])->count();
        return response()->json([
            'status' => 200,
            'live' => $live,
            'pending' => $pending,
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
        $event = Audition::with(['assignJudge', 'participant'])->where('slug', $slug)->first();

        return response()->json([
            'status' => 200,
            'event' => $event,
        ]);
    }

 




    


    // Star Audtion End



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
        $pending_auditions = Audition::with(['judge', 'jury','admin'])->where('id', $id)->get();
        return response()->json([

            'status' => 200,
            'pending_audition' => $pending_auditions,
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
        // return $request->all();

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
    public function participantList()
    {
        $participantList = AuditionParticipant::with(['auditions', 'user'])->orderBy('id', 'DESC')->get();

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
}
